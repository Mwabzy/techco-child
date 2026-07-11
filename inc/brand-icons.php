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

if (!defined('ABSPATH')) {
	exit;
}

if (!function_exists('tc_brand_icon')) {
	/**
	 * @param string $key  Brand key (see $marks below).
	 * @param int    $size Pixel width/height.
	 * @return string Inline SVG markup (empty string if unknown key).
	 */
	function tc_brand_icon($key, $size = 40)
	{

		$marks = array(

			// HTML5 (orange) + CSS3 (blue) shields, paired and centred.
			'html-css' =>
				'<g transform="translate(0 6) scale(.5)"><path fill="#E34F26" d="M3 1.5h18l-1.64 18.48L11.98 22.5l-7.34-2.52L3 1.5zm14.65 3.78H6.36l.2 2.25h10.7l-.62 6.86-4.66 1.29-4.66-1.29-.32-3.57h2.28l.16 1.8 2.54.69 2.54-.69.27-2.95H7.07l-.62-6.78h11.4l-.2 2.39z"/></g>'
				. '<g transform="translate(12 6) scale(.5)"><path fill="#1572B6" d="M3 1.5h18l-1.64 18.48L11.98 22.5l-7.34-2.52L3 1.5zm14.65 3.78H6.36l.2 2.25h10.7l-.62 6.86-4.66 1.29-4.66-1.29-.32-3.57h2.28l.16 1.8 2.54.69 2.54-.69.27-2.95H7.07l-.62-6.78h11.4l-.2 2.39z"/></g>',

			// JavaScript — yellow square, black "JS".
			'javascript' =>
				'<rect x="1.5" y="1.5" width="21" height="21" rx="3" fill="#F7DF1E"/>'
				. '<path fill="#0A0E2E" d="M7.4 13.1l1.78-.92c.21.45.46.76.94.76.46 0 .73-.18.73-.86V8.2h2.06v3.95c0 1.51-.88 2.2-2.17 2.2-1.16 0-1.84-.6-2.18-1.34zm5.9-.22l1.78-.84c.23.49.54.83 1.21.83.51 0 .84-.25.84-.6 0-.42-.33-.57-.9-.82l-.31-.13c-.9-.38-1.5-.86-1.5-1.87 0-.93.71-1.64 1.82-1.64.79 0 1.36.27 1.77 1l-1.71.71c-.21-.38-.44-.53-.78-.53-.35 0-.57.22-.57.53 0 .37.23.52.76.75l.31.13c1.06.45 1.66.91 1.66 1.95 0 1.12-.88 1.73-2.06 1.73-1.16 0-1.91-.55-2.28-1.27z"/>',

			// React — cyan atom: nucleus + 3 elliptical orbits.
			'react' =>
				'<g fill="none" stroke="#61DAFB" stroke-width="1">'
				. '<ellipse cx="12" cy="12" rx="10.5" ry="4"/>'
				. '<ellipse cx="12" cy="12" rx="10.5" ry="4" transform="rotate(60 12 12)"/>'
				. '<ellipse cx="12" cy="12" rx="10.5" ry="4" transform="rotate(120 12 12)"/>'
				. '</g><circle cx="12" cy="12" r="2.1" fill="#61DAFB"/>',

			// Node.js — green hexagon with an inner facet line.
			'nodejs' =>
				'<path fill="#339933" d="M12 1.5l9 5.25v10.5L12 22.5l-9-5.25V6.75z"/>'
				. '<path fill="none" stroke="#fff" stroke-opacity=".55" stroke-width="1" d="M12 6l4.7 2.74v5.52L12 17l-4.7-2.74V8.74z"/>',

			// Express — dark rounded square, "ex" wordmark.
			'express' =>
				'<rect x="1.5" y="1.5" width="21" height="21" rx="5" fill="#303030"/>'
				. '<path fill="#fff" d="M6.2 14.2v-1.55h2.9v-1.1H6.2V10.1h3.25V8.9H4.8v6.5h4.75v-1.2H6.2zm6.05-1.32l1.9 2.52h1.66l-2.72-3.45 2.5-3.05h-1.6l-1.7 2.13-1.7-2.13h-1.66l2.52 3.1-2.7 3.4h1.62l1.88-2.52z"/>',

			// MongoDB — two-tone green leaf with stem.
			'mongodb' =>
				'<path fill="#13AA52" d="M12 1.5c.9 2.6 2.4 4 3.6 5.5 1.6 2 2.4 4.1 2.4 6.4 0 4-2.6 6.8-4.9 8l-.5 2.6h-1.2l-.5-2.6C8.1 19.7 6 17 6 13.4c0-2.3.8-4.4 2.4-6.4C9.6 5.5 11.1 4.1 12 1.5z"/>'
				. '<path fill="#00684A" d="M12 4.2c.7 1.7 1.6 3 1.6 5.6V21l-.9 1.4-.5-2.6c-.1-5-.2-10.6-.2-15.6z"/>',

			// SQL — database cylinder (conceptual, DB teal).
			'sql' =>
				'<g fill="none" stroke="#00758F" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">'
				. '<ellipse cx="12" cy="5.5" rx="7.5" ry="3"/>'
				. '<path d="M4.5 5.5v13c0 1.66 3.36 3 7.5 3s7.5-1.34 7.5-3v-13"/>'
				. '<path d="M4.5 12c0 1.66 3.36 3 7.5 3s7.5-1.34 7.5-3"/>'
				. '</g>',

			// Git — branch glyph in Git orange.
			'git-github' =>
				'<g fill="none" stroke="#F05032" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">'
				. '<circle cx="6" cy="6" r="2.1"/>'
				. '<circle cx="6" cy="18" r="2.1"/>'
				. '<circle cx="18" cy="9" r="2.1"/>'
				. '<path d="M6 8.1v7.8"/>'
				. '<path d="M18 11.1c0 4.9-12 1.5-12 4.8"/>'
				. '</g>',

			// Docker — stacked containers above the whale body (Docker blue).
			'docker' =>
				'<g fill="#1D63ED">'
				. '<rect x="2.8" y="9.8" width="3" height="3" rx=".4"/>'
				. '<rect x="6.3" y="9.8" width="3" height="3" rx=".4"/>'
				. '<rect x="9.8" y="9.8" width="3" height="3" rx=".4"/>'
				. '<rect x="6.3" y="6.3" width="3" height="3" rx=".4"/>'
				. '<rect x="9.8" y="6.3" width="3" height="3" rx=".4"/>'
				. '<rect x="9.8" y="2.8" width="3" height="3" rx=".4"/>'
				. '<path d="M1.5 13.6h18.2c.3 1.3-.2 2.6-1.3 3.6-1.7 1.6-4.4 2.3-7.4 2.3-3.3 0-6.3-1-7.9-3.4-.9-1.4-1.3-1.9-1.6-2.5z"/>'
				. '</g>',

			// REST APIs — JSON braces with a node (conceptual, teal).
			'rest-api' =>
				'<g fill="none" stroke="#009688" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">'
				. '<path d="M8.5 4.5C6 4.5 6 7 6 8c0 2-1.3 3-2.5 3 1.2 0 2.5 1 2.5 3 0 1 0 3.5 2.5 3.5"/>'
				. '<path d="M15.5 4.5C18 4.5 18 7 18 8c0 2 1.3 3 2.5 3-1.2 0-2.5 1-2.5 3 0 1 0 3.5-2.5 3.5"/>'
				. '</g><circle cx="12" cy="11.5" r="1.4" fill="#009688"/>',

			// Auth & Security — shield + padlock (conceptual, secure green).
			'auth-security' =>
				'<g fill="none" stroke="#16A34A" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">'
				. '<path d="M12 2.3L4.3 5.8v5.7c0 4.6 3.3 7.8 7.7 9.7 4.4-1.9 7.7-5.1 7.7-9.7V5.8z"/>'
				. '<rect x="9" y="11.2" width="6" height="5" rx="1"/>'
				. '<path d="M10.1 11.2V9.6a1.9 1.9 0 0 1 3.8 0v1.6"/>'
				. '</g>',

			// Deployment — rocket lift-off (conceptual, violet).
			'deployment' =>
				'<g fill="none" stroke="#7C3AED" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">'
				. '<path d="M12 2c3 1.6 5 5.2 5 9.2L14.5 14h-5L7 11.2C7 7.2 9 3.6 12 2z"/>'
				. '<circle cx="12" cy="9.2" r="1.6"/>'
				. '<path d="M9.5 16l-2.2 3.2M14.5 16l2.2 3.2M12 16v4.2"/>'
				. '</g>',

			// Angular — red shield with the "A" chevron.
			'angular' =>
				'<path fill="#DD0031" d="M12 1.5l9.5 3.4-1.45 12.6L12 22.5l-8.05-4.99L2.5 4.9z"/>'
				. '<path fill="#fff" d="M12 4.3l6.3 13.2h-2.3l-1.27-3.15H9.2L7.94 17.5H5.65zM12 8.1l-1.9 4.4h3.8z"/>',

			// TypeScript — blue square, "TS" wordmark.
			'typescript' =>
				'<rect x="1.5" y="1.5" width="21" height="21" rx="3" fill="#3178C6"/>'
				. '<path fill="#fff" d="M13.9 8.6H9.3v1.5h2.15v6.4h1.5v-6.4h1.95zM17.9 9.9c-.9 0-1.5.3-1.5.95 0 .55.42.78 1.2 1.05l.55.18c1.15.4 1.85.92 1.85 2.02 0 1.28-1 2-2.5 2-.9 0-1.7-.32-2.2-1l1.05-.75c.32.42.7.65 1.2.65.55 0 .9-.25.9-.68 0-.42-.28-.6-1-.85l-.5-.18c-1.05-.4-1.85-.9-1.85-2.05 0-1.2.95-1.95 2.3-1.95.85 0 1.6.32 2.05.98l-1 .78c-.25-.35-.55-.55-1-.55z"/>',

			// RxJS — pink reactive-stream swirl (conceptual).
			'rxjs' =>
				'<g fill="none" stroke="#B7178C" stroke-width="1.6" stroke-linecap="round">'
				. '<path d="M4 12c3-6 6-9 8-9s5 3 8 9c-3 6-6 9-8 9s-5-3-8-9z"/>'
				. '</g><circle cx="12" cy="12" r="2" fill="#B7178C"/>',

			// .NET — purple hexagon, "N" mark.
			'dotnet' =>
				'<path fill="#512BD4" d="M12 1.5l9 5.25v10.5L12 22.5l-9-5.25V6.75z"/>'
				. '<path fill="#fff" d="M7.6 15.5V8.6h1.35l3.4 4.7V8.6h1.35v6.9h-1.35l-3.4-4.7v4.7zm7.9 0V8.6h1.4v6.9z"/>',

			// Entity Framework — teal database + link (conceptual).
			'entity-framework' =>
				'<g fill="none" stroke="#0C8F6E" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">'
				. '<ellipse cx="8.5" cy="6" rx="5" ry="2.2"/>'
				. '<path d="M3.5 6v6c0 1.2 2.24 2.2 5 2.2s5-1 5-2.2V6"/>'
				. '<path d="M13.5 10.2c1.6.2 3 .8 3 1.8v6c0 1.2-2.24 2.2-5 2.2-2 0-3.7-.5-4.5-1.2"/>'
				. '</g>',

			// SQL Server — grey/red database cylinder (conceptual).
			'sql-server' =>
				'<g fill="none" stroke="#A91D22" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">'
				. '<ellipse cx="12" cy="5.5" rx="7.5" ry="3"/>'
				. '<path d="M4.5 5.5v13c0 1.66 3.36 3 7.5 3s7.5-1.34 7.5-3v-13"/>'
				. '<path d="M4.5 12c0 1.66 3.36 3 7.5 3s7.5-1.34 7.5-3"/>'
				. '</g>',

			// AWS — orange "smile" arrow beneath a cloud silhouette.
			'aws' =>
				'<path fill="#232F3E" d="M6 8.5c-2.2 0-3.8 1.7-3.8 3.7 0 2 1.6 3.6 3.8 3.6h11.2c1.8 0 3.3-1.5 3.3-3.3 0-1.6-1.2-2.9-2.7-3.2C17.3 6.6 15.4 5 13 5c-2.1 0-3.9 1.3-4.6 3.1-.1 0-.2-.1-.4-.1z"/>'
				. '<path fill="#FF9900" d="M5 18.5c3.3 2 9.6 2.7 14 .3" stroke="#FF9900" stroke-width="1.4" fill="none" stroke-linecap="round"/>'
				. '<path fill="#FF9900" d="M17.6 17.8l1.9.5-.2 1.9z"/>',

			// Azure — blue angular "ramp" mark.
			'azure' =>
				'<path fill="#0078D4" d="M8.5 3.5h5l-5.2 15h-5z"/>'
				. '<path fill="#0078D4" d="M9.3 3.5h4.4l-6.6 12.8h9L4 20.5z" opacity=".85"/>',

			// GenAI / LLM APIs — violet spark-node (conceptual).
			'genai' =>
				'<g fill="none" stroke="#7C3AED" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">'
				. '<path d="M12 3l1.6 4.4L18 9l-4.4 1.6L12 15l-1.6-4.4L6 9l4.4-1.6z"/>'
				. '<path d="M18.5 15l.7 1.9 1.9.7-1.9.7-.7 1.9-.7-1.9-1.9-.7 1.9-.7z"/>'
				. '</g>',

			// AI Agents — amber connected-nodes mark (conceptual).
			'ai-agents' =>
				'<g fill="none" stroke="#D97706" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">'
				. '<circle cx="6" cy="7" r="2.2"/><circle cx="18" cy="7" r="2.2"/><circle cx="12" cy="18" r="2.2"/>'
				. '<path d="M7.9 8.3L11 16M16.1 8.3L13 16M8.2 7h7.6"/>'
				. '</g>',
		);

		if (empty($marks[$key])) {
			return '';
		}

		$size = (int) $size;

		return sprintf(
			'<svg class="tc-brandico" width="%1$d" height="%1$d" viewBox="0 0 24 24" aria-hidden="true" focusable="false">%2$s</svg>',
			$size,
			$marks[$key]
		);
	}
}
