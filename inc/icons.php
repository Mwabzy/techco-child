<?php
/**
 * Inline SVG icon helper for Visioner pages.
 * Feather-style 24×24 strokes that inherit `currentColor`, so an icon takes the
 * colour of whatever element it sits in. Usage: echo tc_icon( 'calendar', 18 );
 *
 * @package Techco Child
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! function_exists( 'tc_icon' ) ) {
	/**
	 * @param string $name  Icon key (see $icons below).
	 * @param int    $size  Pixel width/height.
	 * @param string $class Extra CSS classes.
	 * @return string Inline SVG markup (empty string if unknown key).
	 */
	function tc_icon( $name, $size = 24, $class = '' ) {

		// Stroke-based icon bodies (drawn with fill:none; stroke:currentColor).
		$icons = array(
			'calendar'     => '<rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>',
			'globe'        => '<circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10A15.3 15.3 0 0 1 12 2z"/>',
			'award'        => '<circle cx="12" cy="8" r="6"/><path d="M15.5 13.5 17 22l-5-3-5 3 1.5-8.5"/>',
			'mail'         => '<rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 6-10 7L2 6"/>',
			'phone'        => '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/>',
			'chat'         => '<path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>',
			'receipt'      => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><line x1="8" y1="13" x2="16" y2="13"/><line x1="8" y1="17" x2="16" y2="17"/>',
			'sliders'      => '<line x1="4" y1="21" x2="4" y2="14"/><line x1="4" y1="10" x2="4" y2="3"/><line x1="12" y1="21" x2="12" y2="12"/><line x1="12" y1="8" x2="12" y2="3"/><line x1="20" y1="21" x2="20" y2="16"/><line x1="20" y1="12" x2="20" y2="3"/><line x1="1" y1="14" x2="7" y2="14"/><line x1="9" y1="8" x2="15" y2="8"/><line x1="17" y1="16" x2="23" y2="16"/>',
			'chart'        => '<line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/>',
			'code'         => '<polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/>',
			'briefcase'    => '<rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 5V3a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/>',
			'credit-card'  => '<rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/>',
			'chevron-down' => '<polyline points="6 9 12 15 18 9"/>',
			'arrow-right'  => '<line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>',
			'zap'          => '<polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>',
			'settings'     => '<circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>',
			'rocket'       => '<path d="M12 2c3 1.6 5 5.2 5 9.2L14.5 14h-5L7 11.2C7 7.2 9 3.6 12 2z"/><circle cx="12" cy="9.2" r="1.6"/><path d="M9.5 16l-2.2 3.2M14.5 16l2.2 3.2M12 16v4.2"/>',
			'search'       => '<circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>',
			'brain'        => '<path d="M9.5 2a3 3 0 0 0-3 3v.3A3.5 3.5 0 0 0 4 8.5 3.5 3.5 0 0 0 5.7 11.5 3.5 3.5 0 0 0 4 14.5 3.5 3.5 0 0 0 6.5 17.8V19a3 3 0 0 0 3 3"/><path d="M14.5 2a3 3 0 0 1 3 3v.3A3.5 3.5 0 0 1 20 8.5a3.5 3.5 0 0 1-1.7 3 3.5 3.5 0 0 1 1.7 3 3.5 3.5 0 0 1-2.5 3.3V19a3 3 0 0 1-3 3"/><line x1="12" y1="2" x2="12" y2="22"/>',
			'building'     => '<rect x="4" y="2" width="16" height="20" rx="1"/><line x1="9" y1="6" x2="9" y2="6"/><line x1="15" y1="6" x2="15" y2="6"/><line x1="9" y1="10" x2="9" y2="10"/><line x1="15" y1="10" x2="15" y2="10"/><line x1="9" y1="14" x2="9" y2="14"/><line x1="15" y1="14" x2="15" y2="14"/><line x1="9" y1="18" x2="15" y2="18"/>',
			'check'        => '<polyline points="20 6 9 17 4 12"/>',
			'map-pin'      => '<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>',
			'whatsapp'     => '<path d="M3 21l1.65-4.95A9 9 0 1 1 8.05 19.5z"/><path d="M8.5 8.5c.3-.7.6-.7 1-.7h.4c.3 0 .5.1.7.6.2.5.7 1.7.7 1.9.1.1.1.3 0 .5-.1.2-.2.3-.3.5-.2.2-.3.3-.1.6.6.9 1.2 1.6 2 2.1.9.6 1.2.5 1.4.4.2-.1.9-1 1.1-1.4.2-.3.5-.3.8-.2.3.1 1.9.9 2.2 1 .3.2.5.3.6.4.1.2.1 1-.3 1.9-.4.9-2 1.7-2.8 1.8-.7.1-1.6.2-5.1-1.1-4.3-1.7-7-6.1-7.2-6.4-.2-.3-1.6-2.2-1.6-4.1 0-2 1-2.9 1.4-3.3.4-.4.8-.5 1.1-.5z"/>',
		);

		$class_attr = 'tc-ico' . ( $class ? ' ' . $class : '' );
		$size       = (int) $size;

		// Solid play triangle is filled, not stroked — handle separately.
		if ( 'play' === $name ) {
			return sprintf(
				'<svg class="%s" width="%d" height="%d" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false"><polygon points="7 4 20 12 7 20"/></svg>',
				esc_attr( $class_attr ), $size, $size
			);
		}

		if ( empty( $icons[ $name ] ) ) {
			return '';
		}

		return sprintf(
			'<svg class="%s" width="%d" height="%d" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">%s</svg>',
			esc_attr( $class_attr ), $size, $size, $icons[ $name ]
		);
	}
}
