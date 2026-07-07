<?php
/**
 * ------------------------------------------------------------------
 * visionONE — Program pricing (single source of truth)
 * ------------------------------------------------------------------
 * Base prices + GST rate for the 4 program tracks. Consumed by:
 *   - page-fees.php    (fee plan cards)
 *   - page-payment.php (plan selector + live fee summary)
 *   - inc/crm/class-crm-sheets.php (per-applicant fee, matched against
 *     the Admissions form's `course_interest` field)
 *
 * Change a price here and it updates everywhere at once.
 *
 * @package Techco Child
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/** The 4 program tracks. `course_interest` must match Fluent Form #1's
 *  option text (tc_price_for_course_interest() below normalizes both
 *  sides before comparing, so minor punctuation/entity differences don't
 *  break the match). */
function tc_program_pricing() {
	return array(
		array(
			'id'              => 'core',
			'name'            => 'Core Program',
			'weeks'           => '10 weeks',
			'course_interest' => 'Core Program (10 weeks)',
			'base'            => 49999,
			'gst_rate'        => 18,
		),
		array(
			'id'              => 'core-cloud',
			'name'            => 'Core + Cloud',
			'weeks'           => '12 weeks',
			'course_interest' => 'Core + Cloud (12 weeks)',
			'base'            => 58474,
			'gst_rate'        => 18,
		),
		array(
			'id'              => 'core-genai',
			'name'            => 'Core + GenAI & Agentic AI',
			'weeks'           => '13 weeks',
			'course_interest' => 'Core + GenAI & Agentic AI (13 weeks)',
			'base'            => 63558,
			'gst_rate'        => 18,
		),
		array(
			'id'              => 'bundle',
			'name'            => 'Complete Bundle',
			'weeks'           => '14 weeks',
			'course_interest' => 'Complete Bundle (14 weeks)',
			'base'            => 72034,
			'gst_rate'        => 18,
		),
	);
}

/** Lookup a plan by its `id` (page-fees.php / page-payment.php). */
function tc_program_pricing_by_id( $id ) {
	foreach ( tc_program_pricing() as $plan ) {
		if ( $plan['id'] === $id ) { return $plan; }
	}
	return null;
}

/** Lowercase, entity-decode, strip everything but a-z0-9 — so matching
 *  survives `&amp;` vs `&`, dash variants, spacing, etc. */
function tc_normalize_match_str( $s ) {
	$s = html_entity_decode( (string) $s, ENT_QUOTES );
	$s = strtolower( $s );
	return preg_replace( '/[^a-z0-9]+/', '', $s );
}

/** Find the plan whose course_interest matches a submitted value (or null). */
function tc_price_for_course_interest( $value ) {
	$norm = tc_normalize_match_str( $value );
	if ( '' === $norm ) { return null; }
	foreach ( tc_program_pricing() as $plan ) {
		if ( tc_normalize_match_str( $plan['course_interest'] ) === $norm ) {
			return $plan;
		}
	}
	return null;
}

function tc_gst_amount( $base, $gst_rate = 18 ) {
	return (int) round( $base * $gst_rate / 100 );
}

function tc_price_total( $base, $gst_rate = 18 ) {
	return (int) $base + tc_gst_amount( $base, $gst_rate );
}
