<?php
/**
 * ------------------------------------------------------------------
 * Redirect-safe JSON POST to the Google Apps Script Web App.
 * ------------------------------------------------------------------
 * Apps Script Web App URLs (…/exec) always answer with a 302 to their real
 * execution URL on script.googleusercontent.com. cURL's default redirect
 * handling downgrades POST to GET on a 302 while still carrying the original
 * Content-Type/Content-Length headers — Google's front-end then rejects that
 * as a malformed request (HTML "Error 400"), and the POST body (and thus
 * doPost()) never actually runs. Disabling auto-redirect and manually
 * re-POSTing to the Location header preserves the method and fixes it.
 *
 * Used by inc/google-sheets-sync.php and inc/crm/class-crm-sheets.php.
 *
 * @package Techco Child
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

function tc_gsheet_post_json( $url, array $payload, $timeout = 15 ) {
	$args = array(
		'timeout'     => $timeout,
		'redirection' => 0, // handled manually below.
		'headers'     => array( 'Content-Type' => 'application/json' ),
		'body'        => wp_json_encode( $payload ),
	);

	$response = wp_remote_post( $url, $args );
	if ( is_wp_error( $response ) ) {
		return $response;
	}

	$code = wp_remote_retrieve_response_code( $response );
	if ( in_array( $code, array( 301, 302, 303, 307, 308 ), true ) ) {
		$location = wp_remote_retrieve_header( $response, 'location' );
		if ( $location ) {
			$response = wp_remote_post( $location, $args );
		}
	}

	return $response;
}
