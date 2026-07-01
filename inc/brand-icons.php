<?php
/**
 * Inline multi-colour brand-logo SVG helper for the Visioner "Stack" grid.
 *
 * Unlike tc_icon() (monochrome feather strokes that inherit currentColor),
 * these marks carry their own authentic brand colours via `fill`/`stroke`,
 * so they need a dedicated helper. Each entry is the inner SVG body; the
 * wrapper supplies the viewBox + sizing. Unknown keys return '' (never fatal).
 *
 * Usage: echo tc_brand_icon( 'react', 40 );
 *
 * @package Techco Child
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! function_exists( 'tc_brand_icon' ) ) {
	/**
	 * @param string $key  Brand key (see $marks below).
	 * @param int    $size Pixel width/height.
	 * @return string Inline SVG markup (empty string if unknown key).
	 */
	function tc_brand_icon( $key, $size = 40 ) {

		$marks = array(

			// HTML5 + CSS3 shields, paired and centred.
			'html-css' =>
				'<g transform="translate(0 6) scale(.5)"><path fill="#2496ED" d="M3 1.5h18l-1.64 18.48L11.98 22.5l-7.34-2.52L3 1.5zm14.65 3.78H6.36l.2 2.25h10.7l-.62 6.86-4.66 1.29-4.66-1.29-.32-3.57h2.28l.16 1.8 2.54.69 2.54-.69.27-2.95H7.07l-.62-6.78h11.4l-.2 2.39z"/></g>'
				. '<g transform="translate(12 6) scale(.5)"><path fill="#10173D" d="M3 1.5h18l-1.64 18.48L11.98 22.5l-7.34-2.52L3 1.5zm14.65 3.78H6.36l.2 2.25h10.7l-.62 6.86-4.66 1.29-4.66-1.29-.32-3.57h2.28l.16 1.8 2.54.69 2.54-.69.27-2.95H7.07l-.62-6.78h11.4l-.2 2.39z"/></g>',

			// JavaScript — yellow square, black "JS".
			'javascript' =>
				'<rect x="1.5" y="1.5" width="21" height="21" rx="3" fill="#5FC1F0"/>'
				. '<path fill="#0A0E2E" d="M7.4 13.1l1.78-.92c.21.45.46.76.94.76.46 0 .73-.18.73-.86V8.2h2.06v3.95c0 1.51-.88 2.2-2.17 2.2-1.16 0-1.84-.6-2.18-1.34zm5.9-.22l1.78-.84c.23.49.54.83 1.21.83.51 0 .84-.25.84-.6 0-.42-.33-.57-.9-.82l-.31-.13c-.9-.38-1.5-.86-1.5-1.87 0-.93.71-1.64 1.82-1.64.79 0 1.36.27 1.77 1l-1.71.71c-.21-.38-.44-.53-.78-.53-.35 0-.57.22-.57.53 0 .37.23.52.76.75l.31.13c1.06.45 1.66.91 1.66 1.95 0 1.12-.88 1.73-2.06 1.73-1.16 0-1.91-.55-2.28-1.27z"/>',

			// React — atom: nucleus + 3 elliptical orbits.
			'react' =>
				'<g fill="none" stroke="#2496ED" stroke-width="1">'
				. '<ellipse cx="12" cy="12" rx="10.5" ry="4"/>'
				. '<ellipse cx="12" cy="12" rx="10.5" ry="4" transform="rotate(60 12 12)"/>'
				. '<ellipse cx="12" cy="12" rx="10.5" ry="4" transform="rotate(120 12 12)"/>'
				. '</g><circle cx="12" cy="12" r="2.1" fill="#2496ED"/>',

			// Node.js — green hexagon with an inner facet line.
			'nodejs' =>
				'<path fill="#10173D" d="M12 1.5l9 5.25v10.5L12 22.5l-9-5.25V6.75z"/>'
				. '<path fill="none" stroke="#fff" stroke-opacity=".55" stroke-width="1" d="M12 6l4.7 2.74v5.52L12 17l-4.7-2.74V8.74z"/>',

			// Express — dark rounded square, "ex" wordmark.
			'express' =>
				'<rect x="1.5" y="1.5" width="21" height="21" rx="5" fill="#0A0E2E"/>'
				. '<path fill="#fff" d="M6.2 14.2v-1.55h2.9v-1.1H6.2V10.1h3.25V8.9H4.8v6.5h4.75v-1.2H6.2zm6.05-1.32l1.9 2.52h1.66l-2.72-3.45 2.5-3.05h-1.6l-1.7 2.13-1.7-2.13h-1.66l2.52 3.1-2.7 3.4h1.62l1.88-2.52z"/>',

			// MongoDB — two-tone leaf with stem.
			'mongodb' =>
				'<path fill="#2496ED" d="M12 1.5c.9 2.6 2.4 4 3.6 5.5 1.6 2 2.4 4.1 2.4 6.4 0 4-2.6 6.8-4.9 8l-.5 2.6h-1.2l-.5-2.6C8.1 19.7 6 17 6 13.4c0-2.3.8-4.4 2.4-6.4C9.6 5.5 11.1 4.1 12 1.5z"/>'
				. '<path fill="#1C75BC" d="M12 4.2c.7 1.7 1.6 3 1.6 5.6V21l-.9 1.4-.5-2.6c-.1-5-.2-10.6-.2-15.6z"/>',

			// SQL — database cylinder (conceptual, brand blue).
			'sql' =>
				'<g fill="none" stroke="#2496ED" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">'
				. '<ellipse cx="12" cy="5.5" rx="7.5" ry="3"/>'
				. '<path d="M4.5 5.5v13c0 1.66 3.36 3 7.5 3s7.5-1.34 7.5-3v-13"/>'
				. '<path d="M4.5 12c0 1.66 3.36 3 7.5 3s7.5-1.34 7.5-3"/>'
				. '</g>',

			// Git — branch glyph in Git orange.
			'git-github' =>
				'<g fill="none" stroke="#5FC1F0" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">'
				. '<circle cx="6" cy="6" r="2.1"/>'
				. '<circle cx="6" cy="18" r="2.1"/>'
				. '<circle cx="18" cy="9" r="2.1"/>'
				. '<path d="M6 8.1v7.8"/>'
				. '<path d="M18 11.1c0 4.9-12 1.5-12 4.8"/>'
				. '</g>',

			// Docker — stacked containers above the whale body.
			'docker' =>
				'<g fill="#2496ED">'
				. '<rect x="2.8" y="9.8" width="3" height="3" rx=".4"/>'
				. '<rect x="6.3" y="9.8" width="3" height="3" rx=".4"/>'
				. '<rect x="9.8" y="9.8" width="3" height="3" rx=".4"/>'
				. '<rect x="6.3" y="6.3" width="3" height="3" rx=".4"/>'
				. '<rect x="9.8" y="6.3" width="3" height="3" rx=".4"/>'
				. '<rect x="9.8" y="2.8" width="3" height="3" rx=".4"/>'
				. '<path d="M1.5 13.6h18.2c.3 1.3-.2 2.6-1.3 3.6-1.7 1.6-4.4 2.3-7.4 2.3-3.3 0-6.3-1-7.9-3.4-.9-1.4-1.3-1.9-1.6-2.5z"/>'
				. '</g>',

			// REST APIs — JSON braces with a node (conceptual, brand blue).
			'rest-api' =>
				'<g fill="none" stroke="#2496ED" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">'
				. '<path d="M8.5 4.5C6 4.5 6 7 6 8c0 2-1.3 3-2.5 3 1.2 0 2.5 1 2.5 3 0 1 0 3.5 2.5 3.5"/>'
				. '<path d="M15.5 4.5C18 4.5 18 7 18 8c0 2 1.3 3 2.5 3-1.2 0-2.5 1-2.5 3 0 1 0 3.5-2.5 3.5"/>'
				. '</g><circle cx="12" cy="11.5" r="1.4" fill="#2496ED"/>',

			// Auth & Security — shield + padlock (conceptual, brand orange).
			'auth-security' =>
				'<g fill="none" stroke="#5FC1F0" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">'
				. '<path d="M12 2.3L4.3 5.8v5.7c0 4.6 3.3 7.8 7.7 9.7 4.4-1.9 7.7-5.1 7.7-9.7V5.8z"/>'
				. '<rect x="9" y="11.2" width="6" height="5" rx="1"/>'
				. '<path d="M10.1 11.2V9.6a1.9 1.9 0 0 1 3.8 0v1.6"/>'
				. '</g>',

			// Deployment — rocket lift-off (conceptual, brand blue).
			'deployment' =>
				'<g fill="none" stroke="#2496ED" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">'
				. '<path d="M12 2c3 1.6 5 5.2 5 9.2L14.5 14h-5L7 11.2C7 7.2 9 3.6 12 2z"/>'
				. '<circle cx="12" cy="9.2" r="1.6"/>'
				. '<path d="M9.5 16l-2.2 3.2M14.5 16l2.2 3.2M12 16v4.2"/>'
				. '</g>',
		);

		if ( empty( $marks[ $key ] ) ) {
			return '';
		}

		$size = (int) $size;

		return sprintf(
			'<svg class="tc-brandico" width="%1$d" height="%1$d" viewBox="0 0 24 24" aria-hidden="true" focusable="false">%2$s</svg>',
			$size,
			$marks[ $key ]
		);
	}
}
