<?php
/**
 * ------------------------------------------------------------------
 * VisionONE — Applications CRM · bootstrap
 * ------------------------------------------------------------------
 * Wires up the front-end CRM (page-crm.php):
 *   - loads the Sheets data-access layer
 *   - enqueues CRM assets only on the CRM template
 *   - registers admin-ajax write/refresh endpoints (capability + nonce gated)
 *   - hides the parent theme header on the CRM template
 *
 * Access is admins-only; the template itself hard-guards before output.
 *
 * @package Techco Child
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

require_once __DIR__ . '/class-crm-sheets.php';

/** Capability required to view/use the CRM. */
if ( ! defined( 'TC_CRM_CAP' ) ) {
	define( 'TC_CRM_CAP', 'manage_options' );
}

/** True when the current request is the CRM page template. */
function tc_crm_is_crm_page() {
	if ( is_admin() ) { return false; }
	$id = get_queried_object_id();
	return $id && 'page-crm.php' === get_page_template_slug( $id );
}

/**
 * Enqueue CRM assets only on the CRM template.
 */
add_action( 'wp_enqueue_scripts', function () {
	if ( ! tc_crm_is_crm_page() || ! current_user_can( TC_CRM_CAP ) ) {
		return;
	}

	$dir = get_stylesheet_directory();
	$uri = get_stylesheet_directory_uri();

	wp_enqueue_style(
		'tc-crm',
		$uri . '/assets/css/crm.css',
		array( 'techco-child-custom' ),
		file_exists( $dir . '/assets/css/crm.css' ) ? filemtime( $dir . '/assets/css/crm.css' ) : '1.0.0'
	);

	wp_enqueue_script(
		'tc-crm',
		$uri . '/assets/js/crm.js',
		array(),
		file_exists( $dir . '/assets/js/crm.js' ) ? filemtime( $dir . '/assets/js/crm.js' ) : '1.0.0',
		true
	);
}, 110 );

/**
 * Localize the CRM data + config onto the enqueued script.
 * Runs late so the handle is registered. Data is fetched server-side so the
 * Apps Script token never reaches the browser.
 */
function tc_crm_boot_data( $force = false ) {
	$result = TC_CRM_Sheets::get_entries( $force );
	return array(
		'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
		'nonce'    => wp_create_nonce( 'tc_crm' ),
		'entries'  => $result['entries'],
		'error'    => $result['error'],
		'stages'      => TC_CRM_Sheets::stages(),
		'payments'    => TC_CRM_Sheets::payment_states(),
		'fieldGroups' => TC_CRM_Sheets::field_groups(),
		'currency' => '₹',
		'user'     => wp_get_current_user()->display_name,
	);
}

/**
 * First + last initials from a display name, for the topbar avatar badge.
 */
function tc_crm_initials( $name ) {
	$parts = array_filter( preg_split( '/\s+/', trim( $name ) ) );
	if ( empty( $parts ) ) {
		return '';
	}
	$initials = mb_substr( reset( $parts ), 0, 1 );
	if ( count( $parts ) > 1 ) {
		$initials .= mb_substr( end( $parts ), 0, 1 );
	}
	return mb_strtoupper( $initials );
}

/* ----------------------------- AJAX: update ----------------------------- */
add_action( 'wp_ajax_tc_crm_update', function () {
	check_ajax_referer( 'tc_crm', 'nonce' );
	if ( ! current_user_can( TC_CRM_CAP ) ) {
		wp_send_json_error( array( 'error' => 'Unauthorized.' ), 403 );
	}

	$entry_id = isset( $_POST['entry_id'] ) ? sanitize_text_field( wp_unslash( $_POST['entry_id'] ) ) : '';
	$meta_in  = isset( $_POST['meta'] ) && is_array( $_POST['meta'] ) ? wp_unslash( $_POST['meta'] ) : array();

	$result = TC_CRM_Sheets::update_entry( $entry_id, $meta_in );
	if ( empty( $result['ok'] ) ) {
		wp_send_json_error( array( 'error' => $result['error'] ), 400 );
	}
	wp_send_json_success( array( 'entry_id' => $entry_id ) );
} );

/* ---------------------------- AJAX: refresh ----------------------------- */
add_action( 'wp_ajax_tc_crm_refresh', function () {
	check_ajax_referer( 'tc_crm', 'nonce' );
	if ( ! current_user_can( TC_CRM_CAP ) ) {
		wp_send_json_error( array( 'error' => 'Unauthorized.' ), 403 );
	}
	$result = TC_CRM_Sheets::get_entries( true );
	wp_send_json_success( array( 'entries' => $result['entries'], 'error' => $result['error'] ) );
} );

