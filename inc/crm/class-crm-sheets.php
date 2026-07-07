<?php
/**
 * ------------------------------------------------------------------
 * VisionONE CRM — Google Sheets data-access layer.
 * ------------------------------------------------------------------
 * Reads applicants from, and writes CRM meta back to, the Google Sheet
 * via the Apps Script Web App (see inc/crm/apps-script.gs). Reuses the
 * same wp-config constants as the submission sync:
 *
 *   GSHEET_WEBAPP_URL    — the /exec Web App URL
 *   GSHEET_SHARED_TOKEN  — shared secret guarding the endpoint
 *
 * The Web App URL/token stay server-side; the browser only ever talks to
 * admin-ajax.php (see inc/crm/crm.php).
 *
 * @package Techco Child
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

class TC_CRM_Sheets {

	/** Transient key for the cached entry list. */
	const CACHE_KEY = 'tc_crm_entries';

	/** Cache lifetime — Apps Script is slow, admissions volume is low. */
	const CACHE_TTL = 180; // 3 minutes.

	/** Canonical pipeline stages (order matters — used for the funnel). */
	public static function stages() {
		return array( 'New', 'Contacted', 'Counselling', 'Offer', 'Enrolled', 'Lost' );
	}

	/** Manual payment states. */
	public static function payment_states() {
		return array( 'Unpaid', 'Partial', 'Paid' );
	}

	/** Is the CRM configured (endpoint present)? */
	public static function is_configured() {
		return defined( 'GSHEET_WEBAPP_URL' ) && GSHEET_WEBAPP_URL;
	}

	private static function token() {
		return defined( 'GSHEET_SHARED_TOKEN' ) ? GSHEET_SHARED_TOKEN : '';
	}

	/**
	 * Fetch all submissions (+ CRM columns) from the Sheet.
	 *
	 * @param bool $force Bypass the cache.
	 * @return array { entries: array<array>, error: string|'' }
	 */
	public static function get_entries( $force = false ) {
		if ( ! self::is_configured() ) {
			return array( 'entries' => array(), 'error' => 'The CRM data source is not configured (GSHEET_WEBAPP_URL missing).' );
		}

		if ( ! $force ) {
			$cached = get_transient( self::CACHE_KEY );
			if ( is_array( $cached ) ) {
				return array( 'entries' => $cached, 'error' => '' );
			}
		}

		$url = add_query_arg(
			array( 'action' => 'list', 'token' => self::token() ),
			GSHEET_WEBAPP_URL
		);

		$response = wp_remote_get( $url, array(
			'timeout'     => 20,
			'redirection' => 5, // Apps Script /exec 302s to its CDN.
		) );

		if ( is_wp_error( $response ) ) {
			return array( 'entries' => array(), 'error' => 'Could not reach the data source: ' . $response->get_error_message() );
		}

		$code = wp_remote_retrieve_response_code( $response );
		if ( $code < 200 || $code >= 300 ) {
			return array( 'entries' => array(), 'error' => 'Data source returned HTTP ' . $code . '.' );
		}

		$data = json_decode( wp_remote_retrieve_body( $response ), true );
		if ( ! is_array( $data ) || empty( $data['ok'] ) ) {
			$msg = is_array( $data ) && ! empty( $data['error'] ) ? $data['error'] : 'unexpected response';
			return array( 'entries' => array(), 'error' => 'Data source error: ' . $msg );
		}

		$entries = array();
		foreach ( (array) ( $data['rows'] ?? array() ) as $row ) {
			$entries[] = self::normalize_row( (array) $row );
		}

		// Newest first.
		usort( $entries, function ( $a, $b ) {
			return strcmp( (string) $b['submitted_at'], (string) $a['submitted_at'] );
		} );

		set_transient( self::CACHE_KEY, $entries, self::CACHE_TTL );

		return array( 'entries' => $entries, 'error' => '' );
	}

	/**
	 * Persist CRM fields for one entry, then bust the cache.
	 *
	 * @param string $entry_id
	 * @param array  $meta  Whitelisted CRM fields.
	 * @return array { ok: bool, error: string }
	 */
	public static function update_entry( $entry_id, array $meta ) {
		if ( ! self::is_configured() ) {
			return array( 'ok' => false, 'error' => 'CRM data source not configured.' );
		}
		$entry_id = trim( (string) $entry_id );
		if ( '' === $entry_id ) {
			return array( 'ok' => false, 'error' => 'Missing entry id.' );
		}

		$allowed = array( 'crm_status', 'crm_owner', 'crm_notes', 'crm_payment_status', 'crm_payment_amount', 'crm_payment_plan' );
		$crm     = array();
		foreach ( $allowed as $key ) {
			if ( array_key_exists( $key, $meta ) ) {
				$crm[ $key ] = 'crm_notes' === $key
					? sanitize_textarea_field( $meta[ $key ] )
					: sanitize_text_field( $meta[ $key ] );
			}
		}
		if ( empty( $crm ) ) {
			return array( 'ok' => false, 'error' => 'Nothing to update.' );
		}

		$response = tc_gsheet_post_json( GSHEET_WEBAPP_URL, array(
			'token'    => self::token(),
			'action'   => 'update',
			'entry_id' => $entry_id,
			'crm'      => $crm,
		), 20 );

		if ( is_wp_error( $response ) ) {
			return array( 'ok' => false, 'error' => $response->get_error_message() );
		}
		$data = json_decode( wp_remote_retrieve_body( $response ), true );
		if ( ! is_array( $data ) || empty( $data['ok'] ) ) {
			$msg = is_array( $data ) && ! empty( $data['error'] ) ? $data['error'] : 'update failed';
			return array( 'ok' => false, 'error' => $msg );
		}

		delete_transient( self::CACHE_KEY );
		return array( 'ok' => true, 'error' => '' );
	}

	/** Clear the cached entry list. */
	public static function flush_cache() {
		delete_transient( self::CACHE_KEY );
	}

	/**
	 * The real Fluent Form #1 ("Admissions Application") field groups, in
	 * display order. Single source of truth for labels — shared with the JS
	 * via tc_crm_boot_data() so the UI, CSV export, and detail modal never
	 * drift out of sync with each other.
	 */
	public static function field_groups() {
		return array(
			array(
				'label'  => 'Personal & Contact',
				'fields' => array(
					array( 'key' => 'full_name', 'label' => 'Full Name' ),
					array( 'key' => 'phone_number', 'label' => 'Phone Number' ),
					array( 'key' => 'whatsapp_number', 'label' => 'WhatsApp Number' ),
					array( 'key' => 'email', 'label' => 'Email Address' ),
				),
			),
			array(
				'label'  => 'Course Interest',
				'fields' => array(
					array( 'key' => 'course_interest', 'label' => 'Course / Program' ),
					array( 'key' => 'mode_of_training', 'label' => 'Mode of Training' ),
					array( 'key' => 'location_city', 'label' => 'Location / City' ),
					array( 'key' => 'preferred_language', 'label' => 'Preferred Language' ),
					array( 'key' => 'enroll_timeline', 'label' => 'Timeline to Enroll' ),
					array( 'key' => 'preferred_batch', 'label' => 'Preferred Batch' ),
					array( 'key' => 'preferred_class_timing', 'label' => 'Preferred Class Timing' ),
				),
			),
			array(
				'label'  => 'Profile',
				'fields' => array(
					array( 'key' => 'age_group', 'label' => 'Age Group' ),
					array( 'key' => 'highest_qualification', 'label' => 'Highest Qualification' ),
					array( 'key' => 'current_status', 'label' => 'Current Status' ),
					array( 'key' => 'current_company_college', 'label' => 'Current Company / College' ),
				),
			),
			array(
				'label'  => 'Skill & Goals',
				'fields' => array(
					array( 'key' => 'current_skill_level', 'label' => 'Current Skill Level' ),
					array( 'key' => 'completed_related_course', 'label' => 'Completed a Related Course Before?' ),
					array( 'key' => 'main_reason_joining', 'label' => 'Main Reason for Joining' ),
					array( 'key' => 'expected_outcome', 'label' => 'Expected Outcome' ),
				),
			),
			array(
				'label'  => 'Job Support',
				'fields' => array(
					array( 'key' => 'target_role', 'label' => 'Target Role' ),
					array( 'key' => 'preferred_job_location', 'label' => 'Preferred Job Location' ),
					array( 'key' => 'notice_period', 'label' => 'Current Notice Period' ),
				),
			),
			array(
				'label'  => 'Payment',
				'fields' => array(
					array( 'key' => 'payment_preference', 'label' => 'Payment Preference' ),
					array( 'key' => 'need_gst_invoice', 'label' => 'Need GST / Tax Invoice?' ),
					array( 'key' => 'billing_name', 'label' => 'Billing Name / Company Name' ),
				),
			),
			array(
				'label'  => 'Technical Readiness',
				'fields' => array(
					array( 'key' => 'has_laptop', 'label' => 'Has a Laptop?' ),
					array( 'key' => 'internet_availability', 'label' => 'Internet Availability' ),
				),
			),
			array(
				'label'  => 'Follow-up',
				'fields' => array(
					array( 'key' => 'hear_about_us', 'label' => 'How Did You Hear About Us?' ),
				),
			),
		);
	}

	/** Flat key => label map derived from field_groups(), for quick lookups. */
	private static function field_labels() {
		$labels = array();
		foreach ( self::field_groups() as $group ) {
			foreach ( $group['fields'] as $field ) {
				$labels[ $field['key'] ] = $field['label'];
			}
		}
		return $labels;
	}

	/**
	 * Normalize a raw sheet row into a stable shape the UI relies on, while
	 * keeping every original column under `raw` so nothing is lost.
	 *
	 * Uses exact (case-insensitive) key lookups against the real Fluent Forms
	 * field names (see field_groups() above) instead of fuzzy keyword
	 * matching, so values never get pulled from the wrong column.
	 */
	private static function normalize_row( array $row ) {
		$by_key = array();
		foreach ( $row as $key => $val ) {
			$by_key[ strtolower( trim( (string) $key ) ) ] = trim( (string) $val );
		}
		$field = function ( $key ) use ( $by_key ) {
			return $by_key[ $key ] ?? '';
		};

		$entry = array(
			'entry_id'     => $field( 'entry_id' ),
			'name'         => $field( 'full_name' ),
			'email'        => $field( 'email' ),
			'phone'        => '' !== $field( 'phone_number' ) ? $field( 'phone_number' ) : $field( 'whatsapp_number' ),
			'submitted_at' => $field( 'submitted_at' ),
			'status'       => '' !== $field( 'crm_status' ) ? $field( 'crm_status' ) : 'New',
			'owner'        => $field( 'crm_owner' ),
			'notes'        => $field( 'crm_notes' ),
			'payment_status' => $field( 'crm_payment_status' ),
			'payment_amount' => $field( 'crm_payment_amount' ),
			'payment_plan'   => $field( 'crm_payment_plan' ),
		);

		foreach ( self::field_labels() as $key => $label ) {
			$entry[ $key ] = $field( $key );
		}

		// Program fee, derived from the applicant's course_interest — see
		// inc/pricing.php (the single source of truth, shared with the Fees
		// and Payment pages).
		$plan = function_exists( 'tc_price_for_course_interest' )
			? tc_price_for_course_interest( $entry['course_interest'] )
			: null;
		if ( $plan ) {
			$entry['fee_program'] = $plan['name'];
			$entry['fee_base']    = $plan['base'];
			$entry['fee_gst']     = tc_gst_amount( $plan['base'], $plan['gst_rate'] );
			$entry['fee_total']   = tc_price_total( $plan['base'], $plan['gst_rate'] );
		} else {
			$entry['fee_program'] = '';
			$entry['fee_base']    = 0;
			$entry['fee_gst']     = 0;
			$entry['fee_total']   = 0;
		}

		$entry['raw'] = $row;

		return $entry;
	}
}
