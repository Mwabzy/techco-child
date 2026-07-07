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
