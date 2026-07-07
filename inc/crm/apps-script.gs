/**
 * ============================================================================
 * visionONE — Applications CRM · Google Apps Script Web App
 * ============================================================================
 * This is the Google Sheet's server-side API. It backs BOTH:
 *   1. The existing Fluent Forms → Sheet sync (inc/google-sheets-sync.php),
 *      which POSTs each submission here (action defaults to "submit").
 *   2. The theme CRM (page-crm.php), which:
 *        - GETs  ?action=list   → reads every submission + its CRM columns
 *        - POSTs action=update   → writes CRM fields (status/notes/payment…)
 *
 * All requests are guarded by a shared token that must equal the
 * GSHEET_SHARED_TOKEN you set in wp-config.php.
 *
 * ---------------------------------------------------------------------------
 * DEPLOY / REDEPLOY
 * ---------------------------------------------------------------------------
 * 1. Open your Sheet → Extensions → Apps Script.
 * 2. Replace the whole Code.gs with this file's contents.
 * 3. Set Script Properties (Project Settings → Script properties):
 *        SHARED_TOKEN = <the same value as GSHEET_SHARED_TOKEN in wp-config>
 *        SHEET_NAME   = <tab name, e.g. "Submissions">   (optional; defaults to first sheet)
 * 4. Deploy → Manage deployments → edit the existing Web App deployment →
 *    "New version" → Deploy. Keep "Execute as: Me", "Who has access: Anyone".
 *    (Reusing the SAME deployment keeps your existing /exec URL unchanged.)
 * ============================================================================
 */

// CRM columns this script manages (auto-created on first write if missing).
var CRM_COLUMNS = [
  'entry_id',
  'crm_status',
  'crm_owner',
  'crm_notes',
  'crm_payment_status',
  'crm_payment_amount',
  'crm_payment_plan',
  'crm_updated_at'
];

var META_COLUMNS = ['form_id', 'form_title', 'submitted_at'];

/** Resolve the working sheet (tab). */
function getSheet_() {
  var props = PropertiesService.getScriptProperties();
  var name = props.getProperty('SHEET_NAME');
  var ss = SpreadsheetApp.getActiveSpreadsheet();
  var sheet = name ? ss.getSheetByName(name) : ss.getSheets()[0];
  if (!sheet) { sheet = ss.getSheets()[0]; }
  return sheet;
}

function getToken_() {
  return PropertiesService.getScriptProperties().getProperty('SHARED_TOKEN') || '';
}

/** Read the header row as an array (trimmed). */
function getHeaders_(sheet) {
  var lastCol = sheet.getLastColumn();
  if (lastCol < 1) { return []; }
  return sheet.getRange(1, 1, 1, lastCol).getValues()[0].map(function (h) {
    return String(h).trim();
  });
}

/** Ensure every column in `needed` exists in the header row; append any missing. */
function ensureColumns_(sheet, needed) {
  var headers = getHeaders_(sheet);
  var lower = headers.map(function (h) { return h.toLowerCase(); });
  var toAdd = [];
  needed.forEach(function (col) {
    if (lower.indexOf(col.toLowerCase()) === -1) { toAdd.push(col); }
  });
  if (toAdd.length) {
    var start = headers.length + 1;
    sheet.getRange(1, start, 1, toAdd.length).setValues([toAdd]);
    headers = headers.concat(toAdd);
  }
  return headers;
}

/** Case-insensitive column index (0-based) or -1. */
function colIndex_(headers, name) {
  var lower = headers.map(function (h) { return h.toLowerCase(); });
  return lower.indexOf(String(name).toLowerCase());
}

function jsonOut_(obj) {
  return ContentService
    .createTextOutput(JSON.stringify(obj))
    .setMimeType(ContentService.MimeType.JSON);
}

/* ============================ GET → list ================================= */
function doGet(e) {
  try {
    var params = (e && e.parameter) ? e.parameter : {};
    if (params.token !== getToken_()) {
      return jsonOut_({ ok: false, error: 'unauthorized' });
    }
    var action = params.action || 'list';
    if (action !== 'list') {
      return jsonOut_({ ok: false, error: 'unknown_action' });
    }

    var sheet = getSheet_();
    var headers = ensureColumns_(sheet, CRM_COLUMNS);
    var lastRow = sheet.getLastRow();
    var rows = [];

    if (lastRow > 1) {
      var values = sheet.getRange(2, 1, lastRow - 1, headers.length).getValues();
      values.forEach(function (row) {
        var obj = {};
        headers.forEach(function (h, i) {
          if (!h) { return; }
          var v = row[i];
          obj[h] = (v instanceof Date) ? Utilities.formatDate(v, Session.getScriptTimeZone(), 'yyyy-MM-dd HH:mm:ss')
                                       : (v === null || v === undefined ? '' : String(v));
        });
        // Skip fully-empty rows.
        var hasData = Object.keys(obj).some(function (k) { return obj[k] !== ''; });
        if (hasData) { rows.push(obj); }
      });
    }

    return jsonOut_({ ok: true, headers: headers, rows: rows, count: rows.length });
  } catch (err) {
    return jsonOut_({ ok: false, error: String(err) });
  }
}

/* ==================== POST → submit (sync) / update (CRM) ================= */
function doPost(e) {
  var lock = LockService.getScriptLock();
  try {
    lock.waitLock(20000);
  } catch (lockErr) {
    return jsonOut_({ ok: false, error: 'busy' });
  }

  try {
    var body = {};
    if (e && e.postData && e.postData.contents) {
      body = JSON.parse(e.postData.contents);
    }
    if (body.token !== getToken_()) {
      return jsonOut_({ ok: false, error: 'unauthorized' });
    }

    var action = body.action || 'submit';
    var sheet = getSheet_();

    if (action === 'update') { return handleUpdate_(sheet, body); }
    return handleSubmit_(sheet, body);
  } catch (err) {
    return jsonOut_({ ok: false, error: String(err) });
  } finally {
    lock.releaseLock();
  }
}

/** Append a new submission row (preserves the existing sync payload shape). */
function handleSubmit_(sheet, body) {
  var fields = body.fields || {};
  // Build the set of columns this submission needs.
  var needed = META_COLUMNS.concat(CRM_COLUMNS);
  Object.keys(fields).forEach(function (k) {
    if (needed.indexOf(k) === -1) { needed.push(k); }
  });
  var headers = ensureColumns_(sheet, needed);

  var record = {
    entry_id: body.entry_id || '',
    form_id: body.form_id || '',
    form_title: body.form_title || '',
    submitted_at: body.submitted_at || Utilities.formatDate(new Date(), Session.getScriptTimeZone(), 'yyyy-MM-dd HH:mm:ss'),
    crm_status: 'New'
  };
  Object.keys(fields).forEach(function (k) { record[k] = fields[k]; });

  var row = headers.map(function (h) {
    return record.hasOwnProperty(h) ? record[h] : '';
  });
  sheet.appendRow(row);

  return jsonOut_({ ok: true, entry_id: record.entry_id });
}

/** Update CRM fields on the row matching entry_id. */
function handleUpdate_(sheet, body) {
  var entryId = String(body.entry_id || '');
  if (!entryId) { return jsonOut_({ ok: false, error: 'missing_entry_id' }); }

  var headers = ensureColumns_(sheet, CRM_COLUMNS);
  var idCol = colIndex_(headers, 'entry_id');
  if (idCol === -1) { return jsonOut_({ ok: false, error: 'no_entry_id_column' }); }

  var lastRow = sheet.getLastRow();
  if (lastRow < 2) { return jsonOut_({ ok: false, error: 'not_found' }); }

  var ids = sheet.getRange(2, idCol + 1, lastRow - 1, 1).getValues();
  var targetRow = -1;
  for (var i = 0; i < ids.length; i++) {
    if (String(ids[i][0]) === entryId) { targetRow = i + 2; break; }
  }
  if (targetRow === -1) { return jsonOut_({ ok: false, error: 'not_found' }); }

  var meta = body.crm || {};
  meta.crm_updated_at = Utilities.formatDate(new Date(), Session.getScriptTimeZone(), 'yyyy-MM-dd HH:mm:ss');

  var updatable = ['crm_status', 'crm_owner', 'crm_notes', 'crm_payment_status',
                   'crm_payment_amount', 'crm_payment_plan', 'crm_updated_at'];
  updatable.forEach(function (key) {
    if (meta.hasOwnProperty(key)) {
      var c = colIndex_(headers, key);
      if (c !== -1) { sheet.getRange(targetRow, c + 1).setValue(meta[key]); }
    }
  });

  return jsonOut_({ ok: true, entry_id: entryId, updated_at: meta.crm_updated_at });
}
