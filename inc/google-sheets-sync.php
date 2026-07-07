<?php
/**
 * ------------------------------------------------------------------
 * Fluent Forms → Google Sheets sync (free, no Fluent Forms Pro).
 * ------------------------------------------------------------------
 * On every Fluent Forms submission we POST the entry as JSON to a
 * Google Apps Script Web App, which appends a row to a Sheet.
 *
 * Configure in wp-config.php (NOT committed):
 *   define( 'GSHEET_WEBAPP_URL',   'https://script.google.com/macros/s/XXXX/exec' );
 *   define( 'GSHEET_SHARED_TOKEN', 'some-long-random-string' );   // optional but recommended
 *   define( 'GSHEET_FORM_IDS',     '1' );  // optional: comma-separated form IDs to sync; empty/undefined = all
 *
 * The Apps Script verifies GSHEET_SHARED_TOKEN before writing, so the
 * endpoint can't be spammed by anyone who finds the URL.
 *
 * @package Techco Child
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Send Apply-form (id 1) submitters straight to the fee payment page instead
 * of the default "thank you" inline message.
 */
add_filter( 'fluentform/form_submission_confirmation', 'tc_apply_form_redirect_to_payment', 20, 3 );

function tc_apply_form_redirect_to_payment( $confirmation, $form_data, $form ) {
	if ( ! isset( $form->id ) || 1 !== (int) $form->id ) {
		return $confirmation;
	}

	$confirmation['redirectTo'] = 'customUrl';
	$confirmation['customUrl']  = tc_tpl_url( 'page-payment.php', '/pay/' );

	return $confirmation;
}

/**
 * Point the Apply form's "accept_terms" checkbox label ("I accept the Terms
 * & Conditions and Disclaimer") at the in-page Terms modal (rendered once
 * via tc_render_terms_modal() in page-apply.php) instead of navigating
 * away. This is a plain checkbox field (Checkable component), not
 * FluentForm's built-in "Terms and Conditions" field type — its option
 * label has no link by default, so we wrap the "Terms & Conditions" phrase
 * in an anchor at render time.
 */
add_filter( 'fluentform/rendering_field_data_input_checkbox', 'tc_apply_form_link_terms_field', 20, 2 );

function tc_apply_form_link_terms_field( $data, $form ) {
	if ( ! isset( $form->id ) || 1 !== (int) $form->id ) {
		return $data;
	}

	if ( 'accept_terms' !== ( $data['attributes']['name'] ?? '' ) ) {
		return $data;
	}

	$pattern = '/Terms\s*(?:&amp;|&|and)\s*Conditions/i';
	$replace = '<a href="#tc-modal-terms" data-tc-modal-open="terms">$0</a>';

	// Single checkboxes are usually stored as settings.advanced_options
	// (list of ['label' => ..., 'value' => ...]); fall back to the plain
	// options (value => label) map used for simpler checkbox groups.
	if ( ! empty( $data['settings']['advanced_options'] ) && is_array( $data['settings']['advanced_options'] ) ) {
		foreach ( $data['settings']['advanced_options'] as $i => $option ) {
			if ( isset( $option['label'] ) && is_string( $option['label'] ) && false === stripos( $option['label'], '<a ' ) ) {
				$data['settings']['advanced_options'][ $i ]['label'] = preg_replace( $pattern, $replace, $option['label'], 1 );
			}
		}
	} elseif ( ! empty( $data['options'] ) && is_array( $data['options'] ) ) {
		foreach ( $data['options'] as $value => $label ) {
			if ( is_string( $label ) && false === stripos( $label, '<a ' ) ) {
				$data['options'][ $value ] = preg_replace( $pattern, $replace, $label, 1 );
			}
		}
	}

	return $data;
}

/**
 * Checkable::compile() builds this checkbox's aria-label from the same
 * (now HTML-containing) label text via esc_attr() only — it never strips
 * tags the way FluentForm's native "Terms and Conditions" field does. Left
 * alone, the anchor markup we just injected would be read out literally by
 * screen readers. Clean the aria-label back down to plain text here.
 *
 * Note: we can't scope this via the $data param — Checkable::compile()
 * has a bug where it reassigns $data to the (unfiltered) $html string just
 * before calling printContent(), so $data received here is actually a
 * copy of $html, not the field's data array. Detect the field from the
 * HTML itself instead.
 */
add_filter( 'fluentform/rendering_field_html_input_checkbox', 'tc_apply_form_fix_terms_aria_label', 20, 3 );

function tc_apply_form_fix_terms_aria_label( $html, $data, $form ) {
	if ( ! isset( $form->id ) || 1 !== (int) $form->id ) {
		return $html;
	}

	if ( false === strpos( $html, 'name="accept_terms[]"' ) ) {
		return $html;
	}

	return preg_replace_callback(
		'/aria-label=([\'"])(.*?)\1/i',
		function ( $m ) {
			$plain = wp_strip_all_tags( html_entity_decode( $m[2], ENT_QUOTES ) );
			return 'aria-label=' . $m[1] . esc_attr( $plain ) . $m[1];
		},
		$html
	);
}

/**
 * Fluent Forms fires this after an entry is stored.
 * Signature: do_action( 'fluentform/submission_inserted', $entryId, $formData, $form ).
 */
add_action( 'fluentform/submission_inserted', 'tc_gsheet_sync_submission', 20, 3 );

function tc_gsheet_sync_submission( $entry_id, $form_data, $form ) {

	// No endpoint configured → nothing to do.
	if ( ! defined( 'GSHEET_WEBAPP_URL' ) || ! GSHEET_WEBAPP_URL ) {
		return;
	}

	// Optional allow-list of form IDs (e.g. only the Apply form).
	if ( defined( 'GSHEET_FORM_IDS' ) && '' !== trim( (string) GSHEET_FORM_IDS ) ) {
		$allowed = array_filter( array_map( 'trim', explode( ',', (string) GSHEET_FORM_IDS ) ) );
		if ( ! in_array( (string) $form->id, $allowed, true ) ) {
			return;
		}
	}

	// Flatten the submitted fields into "Label => scalar string" pairs.
	$fields = tc_gsheet_flatten_fields( $form_data );

	$payload = array(
		'token'        => defined( 'GSHEET_SHARED_TOKEN' ) ? GSHEET_SHARED_TOKEN : '',
		'form_id'      => (string) $form->id,
		'form_title'   => isset( $form->title ) ? $form->title : '',
		'entry_id'     => (string) $entry_id,
		'submitted_at' => current_time( 'Y-m-d H:i:s' ),
		'fields'       => $fields,
	);

	$response = tc_gsheet_post_json( GSHEET_WEBAPP_URL, $payload, 15 );

	// Log failures so they show up in debug.log without breaking the user's submission.
	if ( is_wp_error( $response ) ) {
		error_log( '[GSheet sync] Entry ' . $entry_id . ' failed: ' . $response->get_error_message() );
		return;
	}

	$code = wp_remote_retrieve_response_code( $response );
	if ( $code < 200 || $code >= 300 ) {
		error_log( '[GSheet sync] Entry ' . $entry_id . ' HTTP ' . $code . ': ' . wp_remote_retrieve_body( $response ) );
	}
}

/**
 * Turn Fluent Forms' nested submission array into flat, sheet-friendly
 * "field name => string value" pairs. Composite fields (name, address)
 * are joined with spaces; multi-selects with commas; anything stranger
 * falls back to JSON so no data is silently dropped.
 */
function tc_gsheet_flatten_fields( $form_data ) {
	$out = array();

	foreach ( (array) $form_data as $key => $value ) {

		// Skip Fluent Forms internal/hidden bookkeeping keys.
		if ( is_string( $key ) && ( '_' === $key[0] || in_array( $key, array( '__fluent_form_embded_post_id', 'g-recaptcha-response' ), true ) ) ) {
			continue;
		}

		if ( is_array( $value ) ) {
			// Associative (e.g. first_name/last_name) → join non-empty parts.
			$is_assoc = array_keys( $value ) !== range( 0, count( $value ) - 1 );
			$parts    = array_filter(
				array_map(
					function ( $v ) {
						return is_scalar( $v ) ? trim( (string) $v ) : wp_json_encode( $v );
					},
					$value
				),
				'strlen'
			);
			$out[ $key ] = implode( $is_assoc ? ' ' : ', ', $parts );
		} else {
			$out[ $key ] = is_scalar( $value ) ? (string) $value : wp_json_encode( $value );
		}
	}

	return $out;
}
