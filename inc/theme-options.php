<?php
/**
 * ------------------------------------------------------------------
 * VisionONE content images — Customizer photo uploaders.
 * ------------------------------------------------------------------
 * Adds a "VisionONE Content" section to Appearance → Customize where the
 * site owner can upload the photos used by the home-page sections. Every
 * section degrades gracefully (gradient / initial / icon placeholders) until
 * an image is set, so nothing ever looks broken empty.
 *
 * Read an image in templates with:  tc_opt_image( 'tc_hiw_img_1' )  → URL or ''
 * Check presence with:              tc_has_opt_image( 'tc_hiw_img_1' )
 *
 * @package Techco Child
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * The image slots we expose, grouped for tidy Customizer labels.
 * key => label
 */
function tc_content_image_fields() {
	return array(
		// How It Works — two side photos.
		'tc_hiw_img_1'      => __( 'How It Works — photo 1 (tall/left)', 'techco-child' ),
		'tc_hiw_img_2'      => __( 'How It Works — photo 2 (large/right)', 'techco-child' ),
		// Reviews — student avatars.
		'tc_review_img_1'   => __( 'Review 1 — student photo', 'techco-child' ),
		'tc_review_img_2'   => __( 'Review 2 — student photo', 'techco-child' ),
		'tc_review_img_3'   => __( 'Review 3 — student photo', 'techco-child' ),
		// Program tracks — card thumbnails.
		'tc_track_img_1'    => __( 'Track 1 — card image', 'techco-child' ),
		'tc_track_img_2'    => __( 'Track 2 — card image', 'techco-child' ),
		'tc_track_img_3'    => __( 'Track 3 — card image', 'techco-child' ),
		// Program hero — right-side illustration (SVG/PNG). Overrides the built-in placeholder art.
		'tc_program_hero_img' => __( 'Program hero — illustration (right side)', 'techco-child' ),
	);
}

add_action( 'customize_register', 'tc_register_content_images' );
function tc_register_content_images( $wp_customize ) {

	$wp_customize->add_section(
		'tc_content_images',
		array(
			'title'       => __( 'VisionONE Content', 'techco-child' ),
			'description' => __( 'Upload the photos used on the home page. Leave any blank to keep the built-in placeholder.', 'techco-child' ),
			'priority'    => 30,
		)
	);

	foreach ( tc_content_image_fields() as $key => $label ) {
		$wp_customize->add_setting(
			$key,
			array(
				'default'           => '',
				'sanitize_callback' => 'esc_url_raw',
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				$key,
				array(
					'label'   => $label,
					'section' => 'tc_content_images',
					'settings' => $key,
				)
			)
		);
	}
}

/**
 * Return a stored content-image URL (escaped) or '' if unset.
 */
if ( ! function_exists( 'tc_opt_image' ) ) {
	function tc_opt_image( $key, $default = '' ) {
		$url = get_theme_mod( $key, $default );
		return $url ? esc_url( $url ) : '';
	}
}

/**
 * Whether a content-image slot has been filled.
 */
if ( ! function_exists( 'tc_has_opt_image' ) ) {
	function tc_has_opt_image( $key ) {
		return (bool) get_theme_mod( $key, '' );
	}
}
