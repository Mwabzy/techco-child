/**
 * VisionONE — Applications CRM (front-end, admins-only)
 * Vanilla JS, no external dependencies — charts are hand-rolled inline SVG.
 * Data arrives server-rendered via window.tcCrmData (see page-crm.php);
 * all writes go through admin-ajax (tc_crm_update / tc_crm_refresh) with a
 * nonce + capability check on the server (see inc/crm/crm.php).
 */
(function () {
	'use strict';

	var boot = window.tcCrmData || {};
	if (!boot.ajaxUrl) { return; }

	var root = document.getElementById('tc-crm');
	if (!root) { return; }

	var STAGES = boot.stages || ['New', 'Contacted', 'Counselling', 'Offer', 'Enrolled', 'Lost'];
	var PAYMENTS = boot.payments || ['Unpaid', 'Partial', 'Paid'];
	var CURRENCY = boot.currency || '₹';

	var FIELD_GROUPS = Array.isArray(boot.fieldGroups) ? boot.fieldGroups : [];

	var state = {
		entries: Array.isArray(boot.entries) ? boot.entries.slice() : [],
		view: 'overview',
		boardMode: false,
		pipelineFilters: { search: '', status: '', batch: '', course: '' },
		reportFilters: { from: '', to: '', status: '', batch: '', course: '' },
	};

	/* ------------------------------- helpers ------------------------------- */
	function $(sel, ctx) { return (ctx || root).querySelector(sel); }
	function $$(sel, ctx) { return Array.prototype.slice.call((ctx || root).querySelectorAll(sel)); }
	function esc(s) {
		return String(s == null ? '' : s).replace(/[&<>"']/g, function (c) {
			return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
		});
	}
	function slug(s) { return String(s || '').toLowerCase().replace(/[^a-z0-9]+/g, ''); }
	function debounce(fn, ms) {
		var t;
		return function () {
			var args = arguments, ctx = this;
			clearTimeout(t);
			t = setTimeout(function () { fn.apply(ctx, args); }, ms);
		};
	}
	function parseDate(v) {
		if (!v) { return null; }
		var d = new Date(String(v).replace(' ', 'T'));
		return isNaN(d.getTime()) ? null : d;
	}
	function fmtDate(v) {
		var d = parseDate(v);
		if (!d) { return v || '—'; }
		return d.toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' });
	}
	function money(n) {
		n = parseFloat(n) || 0;
		return CURRENCY + ' ' + n.toLocaleString('en-IN');
	}
	function toNumber(v) {
		var n = parseFloat(String(v || '').replace(/[^\d.]/g, ''));
		return isNaN(n) ? 0 : n;
	}
	function uniqueValues(field) {
		var set = {};
		state.entries.forEach(function (e) { var v = (e[field] || '').trim(); if (v) { set[v] = true; } });
		return Object.keys(set).sort();
	}
	function toast(msg, isError) {
		var host = $('[data-el="toast"]');
		if (!host) { return; }
		var el = document.createElement('div');
		el.className = 'tc-crm-toast-item' + (isError ? ' tc-crm-toast-item--error' : '');
		el.textContent = msg;
		host.appendChild(el);
		setTimeout(function () { el.remove(); }, 2600);
	}

	/* --------------------------------- ajax --------------------------------- */
	function ajax(action, data) {
		var body = new URLSearchParams();
		body.set('action', action);
		body.set('nonce', boot.nonce);
		Object.keys(data || {}).forEach(function (k) {
			if (typeof data[k] === 'object') {
				Object.keys(data[k]).forEach(function (sub) { body.set(k + '[' + sub + ']', data[k][sub]); });
			} else {
				body.set(k, data[k]);
			}
		});
		return fetch(boot.ajaxUrl, { method: 'POST', credentials: 'same-origin', body: body })
			.then(function (r) { return r.json(); });
	}

	function updateEntry(entryId, metaPatch) {
		var entry = state.entries.find(function (e) { return e.entry_id === entryId; });
		if (!entry) { return; }
		var previous = {};
		Object.keys(metaPatch).forEach(function (k) {
			var localKey = k.replace('crm_', '');
			previous[localKey] = entry[localKey];
			entry[localKey] = metaPatch[k];
		});
		renderAll();
		ajax('tc_crm_update', { entry_id: entryId, meta: metaPatch }).then(function (res) {
			if (!res || !res.success) {
				Object.keys(previous).forEach(function (k) { entry[k] = previous[k]; });
				renderAll();
				toast((res && res.data && res.data.error) || 'Could not save — please retry.', true);
			} else {
				toast('Saved');
			}
		}).catch(function () {
			Object.keys(previous).forEach(function (k) { entry[k] = previous[k]; });
			renderAll();
			toast('Network error — could not save.', true);
		});
	}

	function refresh() {
		var btn = $('[data-action="refresh"]');
		if (btn) { btn.disabled = true; }
		ajax('tc_crm_refresh', {}).then(function (res) {
			if (res && res.success) {
				state.entries = res.data.entries || [];
				renderAll();
				toast('Data refreshed');
			} else {
				toast((res && res.data && res.data.error) || 'Could not refresh.', true);
			}
		}).finally(function () {
			if (btn) { btn.disabled = false; }
		});
	}

	/* ---------------------------------- tabs --------------------------------- */
	function initTabs() {
		$$('.tc-crm__tab').forEach(function (tab) {
			tab.addEventListener('click', function () {
				state.view = tab.getAttribute('data-view');
				$$('.tc-crm__tab').forEach(function (t) {
					t.classList.toggle('is-active', t === tab);
					t.setAttribute('aria-selected', t === tab ? 'true' : 'false');
				});
				$$('.tc-crm__view').forEach(function (v) {
					v.classList.toggle('is-active', v.getAttribute('data-view-panel') === state.view);
				});
			});
		});
		$('[data-action="refresh"]').addEventListener('click', refresh);
	}

	/* ------------------------------- SVG charts ------------------------------ */
	function svgEl(tag, attrs) {
		var el = document.createElementNS('http://www.w3.org/2000/svg', tag);
		Object.keys(attrs || {}).forEach(function (k) { el.setAttribute(k, attrs[k]); });
		return el;
	}

	function lineChart(container, points) {
		container.innerHTML = '';
		if (!points.length || points.every(function (p) { return p.value === 0; })) {
			container.innerHTML = '<div class="tc-crm-chart--empty">No submissions yet in this window.</div>';
			return;
		}
		var w = 560, h = 180, padX = 8, padY = 16;
		var max = Math.max.apply(null, points.map(function (p) { return p.value; })) || 1;
		var stepX = (w - padX * 2) / Math.max(1, points.length - 1);
		var coords = points.map(function (p, i) {
			var x = padX + i * stepX;
			var y = h - padY - (p.value / max) * (h - padY * 2);
			return [x, y];
		});
		var linePath = coords.map(function (c, i) { return (i === 0 ? 'M' : 'L') + c[0].toFixed(1) + ',' + c[1].toFixed(1); }).join(' ');
		var areaPath = linePath + ' L' + coords[coords.length - 1][0].toFixed(1) + ',' + (h - padY) + ' L' + coords[0][0].toFixed(1) + ',' + (h - padY) + ' Z';

		var svg = svgEl('svg', { viewBox: '0 0 ' + w + ' ' + h, preserveAspectRatio: 'none' });
		var defs = svgEl('defs', {});
		var grad = svgEl('linearGradient', { id: 'tcCrmAreaGrad', x1: '0', y1: '0', x2: '0', y2: '1' });
		grad.appendChild(svgEl('stop', { offset: '0%', 'stop-color': 'var(--tc-blue)', 'stop-opacity': '0.28' }));
		grad.appendChild(svgEl('stop', { offset: '100%', 'stop-color': 'var(--tc-blue)', 'stop-opacity': '0' }));
		defs.appendChild(grad);
		svg.appendChild(defs);
		svg.appendChild(svgEl('path', { d: areaPath, fill: 'url(#tcCrmAreaGrad)', stroke: 'none' }));
		svg.appendChild(svgEl('path', { d: linePath, fill: 'none', stroke: 'var(--tc-blue)', 'stroke-width': '2.5', 'stroke-linejoin': 'round', 'stroke-linecap': 'round' }));
		coords.forEach(function (c, i) {
			var dot = svgEl('circle', { cx: c[0], cy: c[1], r: 3, fill: 'var(--tc-blue)' });
			var title = document.createElementNS('http://www.w3.org/2000/svg', 'title');
			title.textContent = points[i].label + ': ' + points[i].value;
			dot.appendChild(title);
			svg.appendChild(dot);
		});
		container.appendChild(svg);
	}

	function barRows(container, rows, emptyMsg) {
		container.innerHTML = '';
		if (!rows.length) {
			container.innerHTML = '<div class="tc-crm-chart--empty">' + esc(emptyMsg) + '</div>';
			return;
		}
		var max = Math.max.apply(null, rows.map(function (r) { return r.value; })) || 1;
		rows.forEach(function (r) {
			var row = document.createElement('div');
			row.className = 'tc-crm-bar-row';
			row.innerHTML =
				'<span class="tc-crm-bar-row__label" title="' + esc(r.label) + '">' + esc(r.label) + '</span>' +
				'<span class="tc-crm-bar-row__track"><span class="tc-crm-bar-row__fill" style="width:' + Math.round((r.value / max) * 100) + '%"></span></span>' +
				'<span class="tc-crm-bar-row__val">' + r.value + '</span>';
			container.appendChild(row);
		});
	}

	function funnelChart(container, rows) {
		container.innerHTML = '';
		var max = Math.max.apply(null, rows.map(function (r) { return r.value; })) || 1;
		rows.forEach(function (r) {
			var row = document.createElement('div');
			row.className = 'tc-crm-funnel__row';
			row.innerHTML =
				'<span class="tc-crm-funnel__label">' + esc(r.label) + '</span>' +
				'<span class="tc-crm-funnel__bar"><span class="tc-crm-funnel__fill" style="width:' + Math.round((r.value / max) * 100) + '%"></span></span>' +
				'<span class="tc-crm-funnel__val">' + r.value + '</span>';
			container.appendChild(row);
		});
	}

	/* -------------------------------- overview -------------------------------- */
	function renderOverview() {
		var entries = state.entries;
		var now = new Date();
		var weekAgo = new Date(now.getTime() - 7 * 24 * 3600 * 1000);

		var total = entries.length;
		var thisWeek = entries.filter(function (e) { var d = parseDate(e.submitted_at); return d && d >= weekAgo; }).length;
		var enrolled = entries.filter(function (e) { return e.status === 'Enrolled'; }).length;
		var revenue = entries.filter(function (e) { return e.payment_status === 'Paid'; })
			.reduce(function (sum, e) { return sum + toNumber(e.payment_amount); }, 0);
		var pipelineValue = entries.filter(function (e) { return e.status !== 'Lost'; })
			.reduce(function (sum, e) { return sum + toNumber(e.fee_total); }, 0);

		var statsHost = $('[data-el="stats"]');
		statsHost.innerHTML = [
			['Total applications', total, ''],
			['This week', thisWeek, 'new submissions'],
			['Enrolled', enrolled, total ? Math.round((enrolled / total) * 100) + '% of total' : ''],
			['Pipeline value', money(pipelineValue), 'quoted fees, active pipeline'],
			['Revenue collected', money(revenue), 'marked as Paid'],
		].map(function (s) {
			return '<div class="tc-crm-stat"><span class="tc-crm-stat__label">' + esc(s[0]) + '</span>' +
				'<span class="tc-crm-stat__num">' + (typeof s[1] === 'number' ? s[1] : esc(s[1])) + '</span>' +
				(s[2] ? '<span class="tc-crm-stat__sub">' + esc(s[2]) + '</span>' : '') + '</div>';
		}).join('');

		// Timeline — last 14 days.
		var days = [];
		for (var i = 13; i >= 0; i--) {
			var d = new Date(now.getTime() - i * 24 * 3600 * 1000);
			days.push({ key: d.toISOString().slice(0, 10), label: d.toLocaleDateString('en-IN', { day: '2-digit', month: 'short' }), value: 0 });
		}
		var dayIndex = {};
		days.forEach(function (d, idx) { dayIndex[d.key] = idx; });
		entries.forEach(function (e) {
			var d = parseDate(e.submitted_at);
			if (!d) { return; }
			var key = d.toISOString().slice(0, 10);
			if (dayIndex.hasOwnProperty(key)) { days[dayIndex[key]].value++; }
		});
		lineChart($('[data-chart="timeline"]'), days);

		// Funnel.
		funnelChart($('[data-chart="funnel"]'), STAGES.map(function (s) {
			return { label: s, value: entries.filter(function (e) { return e.status === s; }).length };
		}));

		// Batch / course / mode / source bar charts (top 6 each).
		function topCounts(field) {
			var counts = {};
			entries.forEach(function (e) { var v = (e[field] || '').trim(); if (v) { counts[v] = (counts[v] || 0) + 1; } });
			return Object.keys(counts).map(function (k) { return { label: k, value: counts[k] }; })
				.sort(function (a, b) { return b.value - a.value; }).slice(0, 6);
		}
		barRows($('[data-chart="batch"]'), topCounts('preferred_batch'), 'No batch data yet.');
		barRows($('[data-chart="course"]'), topCounts('course_interest'), 'No course data yet.');
		barRows($('[data-chart="mode"]'), topCounts('mode_of_training'), 'No mode data yet.');
		barRows($('[data-chart="source"]'), topCounts('hear_about_us'), 'No source data yet.');
	}

	/* -------------------------------- pipeline -------------------------------- */
	function populateSelect(el, values, placeholder) {
		var current = el.value;
		el.innerHTML = '<option value="">' + esc(placeholder) + '</option>' +
			values.map(function (v) { return '<option value="' + esc(v) + '">' + esc(v) + '</option>'; }).join('');
		if (values.indexOf(current) !== -1) { el.value = current; }
	}

	function filteredPipelineEntries() {
		var f = state.pipelineFilters;
		var q = f.search.trim().toLowerCase();
		return state.entries.filter(function (e) {
			if (f.status && e.status !== f.status) { return false; }
			if (f.batch && e.preferred_batch !== f.batch) { return false; }
			if (f.course && e.course_interest !== f.course) { return false; }
			if (q) {
				var hay = [e.name, e.email, e.phone].join(' ').toLowerCase();
				if (hay.indexOf(q) === -1) { return false; }
			}
			return true;
		});
	}

	function stageClass(stage) { return 'tc-crm-pill--' + slug(stage) || 'tc-crm-pill--new'; }
	function paymentClass(p) { return 'tc-crm-pill--' + (slug(p) || 'unpaid'); }
	function feeTitle(e) {
		if (!e.fee_total) { return ''; }
		return ' title="' + esc(e.fee_program + ': ' + money(e.fee_base) + ' + GST ' + money(e.fee_gst)) + '"';
	}

	function optionList(values, current) {
		return values.map(function (v) {
			return '<option value="' + esc(v) + '"' + (v === current ? ' selected' : '') + '>' + esc(v) + '</option>';
		}).join('');
	}

	function renderPipelineTable(entries) {
		var host = $('[data-el="pipeline-body"]');
		if (!entries.length) {
			host.innerHTML = '<div class="tc-crm-chart--empty">No applicants match these filters.</div>';
			return;
		}
		var rows = entries.map(function (e) {
			return '<tr data-entry="' + esc(e.entry_id) + '">' +
				'<td><div class="tc-crm-name">' + esc(e.name || '—') + '</div>' +
				'<div class="tc-crm-muted-cell">' + esc(e.email || '') + (e.phone ? ' · ' + esc(e.phone) : '') + '</div></td>' +
				'<td class="tc-crm-muted-cell">' + esc(e.course_interest || '—') + '</td>' +
				'<td class="tc-crm-muted-cell"' + feeTitle(e) + '>' + (e.fee_total ? money(e.fee_total) : '—') + '</td>' +
				'<td class="tc-crm-muted-cell">' + esc(e.preferred_batch || '—') + '</td>' +
				'<td class="tc-crm-muted-cell">' + esc(e.mode_of_training || '—') + (e.preferred_class_timing ? ' · ' + esc(e.preferred_class_timing) : '') + '</td>' +
				'<td class="tc-crm-muted-cell">' + esc(fmtDate(e.submitted_at)) + '</td>' +
				'<td><select data-field="crm_status" class="tc-crm-pill ' + stageClass(e.status) + '">' + optionList(STAGES, e.status) + '</select></td>' +
				'<td><input type="text" data-field="crm_owner" value="' + esc(e.owner || '') + '" placeholder="Unassigned"></td>' +
				'<td><select data-field="crm_payment_status" class="tc-crm-pill ' + paymentClass(e.payment_status) + '">' + optionList(PAYMENTS, e.payment_status) + '</select></td>' +
				'<td><input type="text" inputmode="decimal" data-field="crm_payment_amount" value="' + esc(e.payment_amount || '') + '" placeholder="Amount"></td>' +
				'<td><input type="text" data-field="crm_notes" value="' + esc(e.notes || '') + '" placeholder="Add a note…"></td>' +
				'<td><button type="button" class="tc-crm__btn tc-crm__btn--ghost tc-crm__btn--sm" data-action="view-entry">View</button></td>' +
				'</tr>';
		}).join('');

		host.innerHTML = '<div class="tc-crm__table-wrap"><table class="tc-crm-table"><thead><tr>' +
			'<th>Applicant</th><th>Course Interest</th><th>Program Fee</th><th>Batch</th><th>Mode / Timing</th><th>Submitted</th><th>Status</th><th>Owner</th><th>Payment</th><th>Amount</th><th>Notes</th><th></th>' +
			'</tr></thead><tbody>' + rows + '</tbody></table></div>';

		bindInlineEdits(host);
	}

	function renderPipelineBoard(entries) {
		var host = $('[data-el="pipeline-body"]');
		var cols = STAGES.map(function (stage) {
			var inStage = entries.filter(function (e) { return e.status === stage; });
			var cards = inStage.map(function (e) {
				return '<div class="tc-crm-board__card" data-entry="' + esc(e.entry_id) + '">' +
					'<div class="tc-crm-board__card-name">' + esc(e.name || '—') + '</div>' +
					'<div class="tc-crm-board__card-sub">' + esc(e.course_interest || '—') + (e.preferred_batch ? ' · ' + esc(e.preferred_batch) : '') + (e.fee_total ? ' · ' + money(e.fee_total) : '') + '</div>' +
					'<select data-field="crm_status">' + optionList(STAGES, e.status) + '</select>' +
					'</div>';
			}).join('');
			return '<div class="tc-crm-board__col"><div class="tc-crm-board__col-title">' + esc(stage) +
				'<span class="tc-crm-board__count">' + inStage.length + '</span></div>' + cards + '</div>';
		}).join('');
		host.innerHTML = '<div class="tc-crm-board">' + cols + '</div>';
		bindInlineEdits(host);
	}

	function bindInlineEdits(host) {
		$$('[data-field]', host).forEach(function (input) {
			var evt = input.tagName === 'SELECT' ? 'change' : 'change';
			input.addEventListener(evt, function () {
				var row = input.closest('[data-entry]');
				var entryId = row.getAttribute('data-entry');
				var field = input.getAttribute('data-field');
				updateEntry(entryId, one(field, input.value));
			});
		});
		function one(k, v) { var o = {}; o[k] = v; return o; }
	}

	function renderPipeline() {
		populateSelect($('[data-el="filter-status"]'), STAGES, 'All statuses');
		populateSelect($('[data-el="filter-batch"]'), uniqueValues('preferred_batch'), 'All batches');
		populateSelect($('[data-el="filter-course"]'), uniqueValues('course_interest'), 'All courses');

		var entries = filteredPipelineEntries();
		if (state.boardMode) { renderPipelineBoard(entries); } else { renderPipelineTable(entries); }
	}

	function initPipelineToolbar() {
		$('[data-el="search"]').addEventListener('input', debounce(function (e) {
			state.pipelineFilters.search = e.target.value;
			renderPipeline();
		}, 200));
		['status', 'batch', 'course'].forEach(function (key) {
			$('[data-el="filter-' + key + '"]').addEventListener('change', function (e) {
				state.pipelineFilters[key] = e.target.value;
				renderPipeline();
			});
		});
		$$('[data-table-view]').forEach(function (btn) {
			btn.addEventListener('click', function () {
				state.boardMode = btn.getAttribute('data-table-view') === 'board';
				$$('[data-table-view]').forEach(function (b) { b.classList.toggle('is-active', b === btn); });
				renderPipeline();
			});
		});
	}

	/* -------------------------------- reports -------------------------------- */
	function filteredReportEntries() {
		var f = state.reportFilters;
		return state.entries.filter(function (e) {
			if (f.status && e.status !== f.status) { return false; }
			if (f.batch && e.preferred_batch !== f.batch) { return false; }
			if (f.course && e.course_interest !== f.course) { return false; }
			var d = parseDate(e.submitted_at);
			if (f.from && d && d < new Date(f.from)) { return false; }
			if (f.to && d && d > new Date(f.to + 'T23:59:59')) { return false; }
			return true;
		});
	}

	function renderReports() {
		populateSelect($('[data-el="report-status"]'), STAGES, 'All statuses');
		populateSelect($('[data-el="report-batch"]'), uniqueValues('preferred_batch'), 'All batches');
		populateSelect($('[data-el="report-course"]'), uniqueValues('course_interest'), 'All courses');

		var entries = filteredReportEntries();
		var revenue = entries.filter(function (e) { return e.payment_status === 'Paid'; })
			.reduce(function (sum, e) { return sum + toNumber(e.payment_amount); }, 0);

		$('[data-el="report-stats"]').innerHTML = [
			['Results', entries.length, ''],
			['Enrolled', entries.filter(function (e) { return e.status === 'Enrolled'; }).length, ''],
			['Lost', entries.filter(function (e) { return e.status === 'Lost'; }).length, ''],
			['Revenue (Paid)', money(revenue), ''],
		].map(function (s) {
			return '<div class="tc-crm-stat"><span class="tc-crm-stat__label">' + esc(s[0]) + '</span>' +
				'<span class="tc-crm-stat__num">' + (typeof s[1] === 'number' ? s[1] : esc(s[1])) + '</span></div>';
		}).join('');

		var host = $('[data-el="report-table"]');
		if (!entries.length) {
			host.innerHTML = '<div class="tc-crm-chart--empty">No results for this filter.</div>';
			return;
		}
		var rows = entries.map(function (e) {
			return '<tr data-entry="' + esc(e.entry_id) + '">' +
				'<td><div class="tc-crm-name">' + esc(e.name || '—') + '</div><div class="tc-crm-muted-cell">' + esc(e.email || '') + '</div></td>' +
				'<td class="tc-crm-muted-cell">' + esc(e.phone || '—') + '</td>' +
				'<td class="tc-crm-muted-cell">' + esc(e.course_interest || '—') + '</td>' +
				'<td class="tc-crm-muted-cell"' + feeTitle(e) + '>' + (e.fee_total ? money(e.fee_total) : '—') + '</td>' +
				'<td class="tc-crm-muted-cell">' + esc(e.preferred_batch || '—') + '</td>' +
				'<td class="tc-crm-muted-cell">' + esc(fmtDate(e.submitted_at)) + '</td>' +
				'<td><span class="tc-crm-pill ' + stageClass(e.status) + '">' + esc(e.status) + '</span></td>' +
				'<td><span class="tc-crm-pill ' + paymentClass(e.payment_status) + '">' + esc(e.payment_status || 'Unpaid') + '</span></td>' +
				'<td class="tc-crm-muted-cell">' + esc(e.payment_amount ? money(e.payment_amount) : '—') + '</td>' +
				'<td><button type="button" class="tc-crm__btn tc-crm__btn--ghost tc-crm__btn--sm" data-action="view-entry">View</button></td>' +
				'</tr>';
		}).join('');
		host.innerHTML = '<table class="tc-crm-table"><thead><tr>' +
			'<th>Applicant</th><th>Phone</th><th>Course Interest</th><th>Program Fee</th><th>Batch</th><th>Submitted</th><th>Status</th><th>Payment</th><th>Amount</th><th></th>' +
			'</tr></thead><tbody>' + rows + '</tbody></table>';
	}

	/** Flatten boot.fieldGroups into a single ordered [{key,label}] list. */
	function flatFieldList() {
		var list = [];
		FIELD_GROUPS.forEach(function (g) {
			(g.fields || []).forEach(function (f) { list.push(f); });
		});
		return list;
	}

	function exportCsv() {
		var entries = filteredReportEntries();
		var fields = flatFieldList();
		var cols = fields.map(function (f) { return f.key; })
			.concat(['fee_base', 'fee_gst', 'fee_total', 'submitted_at', 'status', 'owner', 'payment_status', 'payment_amount', 'payment_plan', 'notes']);
		var header = fields.map(function (f) { return f.label; })
			.concat(['Program Fee (Base)', 'Program Fee (GST)', 'Program Fee (Total)', 'Submitted At', 'Status', 'Owner', 'Payment Status', 'Payment Amount', 'Payment Plan', 'Notes']);
		function csvCell(v) {
			v = String(v == null ? '' : v);
			return /[",\n]/.test(v) ? '"' + v.replace(/"/g, '""') + '"' : v;
		}
		var lines = [header.join(',')];
		entries.forEach(function (e) { lines.push(cols.map(function (c) { return csvCell(e[c]); }).join(',')); });
		var blob = new Blob([lines.join('\n')], { type: 'text/csv;charset=utf-8;' });
		var url = URL.createObjectURL(blob);
		var a = document.createElement('a');
		a.href = url;
		a.download = 'VisionONE-crm-report-' + new Date().toISOString().slice(0, 10) + '.csv';
		document.body.appendChild(a);
		a.click();
		a.remove();
		URL.revokeObjectURL(url);
		toast('Exported ' + entries.length + ' rows.');
	}

	function initReportsToolbar() {
		['from', 'to'].forEach(function (key) {
			$('[data-el="report-' + key + '"]').addEventListener('change', function (e) {
				state.reportFilters[key] = e.target.value;
				renderReports();
			});
		});
		['status', 'batch', 'course'].forEach(function (key) {
			$('[data-el="report-' + key + '"]').addEventListener('change', function (e) {
				state.reportFilters[key] = e.target.value;
				renderReports();
			});
		});
		$('[data-action="export-csv"]').addEventListener('click', exportCsv);
	}

	/* ---------------------------- applicant detail ---------------------------- */
	function buildDetailSections(e) {
		return FIELD_GROUPS.map(function (g) {
			var rows = (g.fields || []).map(function (f) {
				var v = (e[f.key] || '').trim();
				if (!v) { return ''; }
				return '<div class="tc-crm-modal__row"><span class="tc-crm-modal__row-label">' + esc(f.label) + '</span>' +
					'<span class="tc-crm-modal__row-val">' + esc(v) + '</span></div>';
			}).join('');
			if (!rows) { return ''; }
			return '<div class="tc-crm-modal__section"><h4 class="tc-crm-modal__section-title">' + esc(g.label) + '</h4>' + rows + '</div>';
		}).join('');
	}

	function openDetailModal(entryId) {
		var e = state.entries.find(function (x) { return x.entry_id === entryId; });
		var host = $('[data-el="detail-modal"]');
		if (!e || !host) { return; }

		host.innerHTML =
			'<div class="tc-crm-modal__overlay" data-action="close-modal"></div>' +
			'<div class="tc-crm-modal__panel" role="dialog" aria-modal="true" aria-label="Applicant details">' +
				'<div class="tc-crm-modal__head">' +
					'<div>' +
						'<div class="tc-crm-modal__name">' + esc(e.name || '—') + '</div>' +
						'<div class="tc-crm-modal__meta">' + esc(e.email || '') + (e.phone ? ' · ' + esc(e.phone) : '') + '</div>' +
					'</div>' +
					'<button type="button" class="tc-crm__btn tc-crm__btn--ghost tc-crm__btn--sm" data-action="close-modal">Close</button>' +
				'</div>' +
				'<div class="tc-crm-modal__summary">' +
					'<span class="tc-crm-pill ' + stageClass(e.status) + '">' + esc(e.status) + '</span>' +
					'<span class="tc-crm-pill ' + paymentClass(e.payment_status) + '">' + esc(e.payment_status || 'Unpaid') + '</span>' +
					(e.payment_amount ? '<span class="tc-crm-modal__amount">' + money(e.payment_amount) + '</span>' : '') +
					'<span class="tc-crm-modal__submitted">Submitted ' + esc(fmtDate(e.submitted_at)) + '</span>' +
				'</div>' +
				(e.fee_total ? '<div class="tc-crm-modal__section">' +
					'<h4 class="tc-crm-modal__section-title">Program Fee — ' + esc(e.fee_program) + '</h4>' +
					'<div class="tc-crm-modal__row"><span class="tc-crm-modal__row-label">Base fee</span><span class="tc-crm-modal__row-val">' + money(e.fee_base) + '</span></div>' +
					'<div class="tc-crm-modal__row"><span class="tc-crm-modal__row-label">GST</span><span class="tc-crm-modal__row-val">' + money(e.fee_gst) + '</span></div>' +
					'<div class="tc-crm-modal__row"><span class="tc-crm-modal__row-label">Total payable</span><span class="tc-crm-modal__row-val">' + money(e.fee_total) + '</span></div>' +
				'</div>' : '') +
				(e.owner || e.notes ? '<div class="tc-crm-modal__notes">' +
					(e.owner ? '<strong>Owner:</strong> ' + esc(e.owner) + '<br>' : '') +
					(e.notes ? esc(e.notes) : '') +
				'</div>' : '') +
				'<div class="tc-crm-modal__body">' + buildDetailSections(e) + '</div>' +
			'</div>';
		host.hidden = false;
		document.addEventListener('keydown', onModalKeydown);
	}

	function closeDetailModal() {
		var host = $('[data-el="detail-modal"]');
		if (!host || host.hidden) { return; }
		host.hidden = true;
		host.innerHTML = '';
		document.removeEventListener('keydown', onModalKeydown);
	}

	function onModalKeydown(e) {
		if (e.key === 'Escape') { closeDetailModal(); }
	}

	/** Single delegated listener: "View" buttons, clickable board cards, modal close. */
	function initDetailModal() {
		root.addEventListener('click', function (ev) {
			if (ev.target.closest('[data-action="close-modal"]')) {
				closeDetailModal();
				return;
			}
			if (ev.target.tagName === 'SELECT' || ev.target.tagName === 'OPTION') { return; }
			var trigger = ev.target.closest('[data-action="view-entry"]') || ev.target.closest('.tc-crm-board__card');
			if (trigger) {
				var rowEl = trigger.closest('[data-entry]');
				if (rowEl) { openDetailModal(rowEl.getAttribute('data-entry')); }
			}
		});
	}

	/* --------------------------------- boot ---------------------------------- */
	function renderAll() {
		renderOverview();
		renderPipeline();
		renderReports();
	}

	initTabs();
	initPipelineToolbar();
	initReportsToolbar();
	initDetailModal();
	renderAll();
})();
