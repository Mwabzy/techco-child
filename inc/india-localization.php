<?php
/**
 * ------------------------------------------------------------------
 * India localization for the Visioner site.
 * ------------------------------------------------------------------
 *  1. +91 prefix on Fluent Forms phone fields (.ff-number-only), capped
 *     to 10 digits — users type only their mobile number.
 *  2. India site defaults (timezone IST, dd/mm/yyyy dates) applied once,
 *     so the admin can still change them afterwards.
 *  3. en-IN SEO/locale signals (html lang, og:locale, hreflang, geo meta)
 *     without changing WordPress' PHP locale (keeps translations intact).
 *
 * @package Techco Child
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* ------------------------------------------------------------------
 * 1. India site defaults — run ONCE, then leave the admin in control.
 * ---------------------------------------------------------------- */
add_action( 'init', 'tc_apply_india_defaults' );
function tc_apply_india_defaults() {
	if ( get_option( 'tc_india_locale_applied' ) ) {
		return;
	}
	update_option( 'timezone_string', 'Asia/Kolkata' );
	update_option( 'gmt_offset', '' );          // cleared so timezone_string wins
	update_option( 'date_format', 'd/m/Y' );
	update_option( 'time_format', 'g:i a' );
	update_option( 'start_of_week', 1 );        // Monday
	update_option( 'tc_india_locale_applied', 1 );
}

/* ------------------------------------------------------------------
 * 2. en-IN locale / SEO signals.
 * ---------------------------------------------------------------- */
// <html lang="en-IN">
add_filter(
	'language_attributes',
	function ( $output ) {
		return preg_replace( '/lang="[^"]*"/', 'lang="en-IN"', $output );
	}
);

// Region + locale hints in <head>.
add_action(
	'wp_head',
	function () {
		echo "\n<!-- Visioner: India locale -->\n";
		echo '<meta property="og:locale" content="en_IN" />' . "\n";
		echo '<meta name="geo.region" content="IN" />' . "\n";
		echo '<meta name="geo.placename" content="India" />' . "\n";
		$url = home_url( add_query_arg( null, null ) );
		echo '<link rel="alternate" hreflang="en-in" href="' . esc_url( $url ) . '" />' . "\n";
		echo '<link rel="alternate" hreflang="x-default" href="' . esc_url( $url ) . '" />' . "\n";
	},
	5
);

/* ------------------------------------------------------------------
 * 3. +91 prefix on Fluent Forms phone fields.
 * ---------------------------------------------------------------- */
add_action(
	'wp_footer',
	function () {
		?>
<script>
document.addEventListener('DOMContentLoaded', function () {
	function decoratePhones(scope) {
		(scope || document).querySelectorAll('input.ff-number-only').forEach(function (input) {
			if (input.dataset.tcPhone) return;        // already done
			input.dataset.tcPhone = '1';

			var wrap = document.createElement('span');
			wrap.className = 'tc-phone-wrap';
			input.parentNode.insertBefore(wrap, input);

			var prefix = document.createElement('span');
			prefix.className = 'tc-phone-prefix';
			prefix.textContent = '+91';
			wrap.appendChild(prefix);
			wrap.appendChild(input);

			input.setAttribute('maxlength', '10');
			input.setAttribute('inputmode', 'numeric');
			if (!input.getAttribute('placeholder')) {
				input.setAttribute('placeholder', '98765 43210');
			}
		});
	}
	decoratePhones(document);
	// Fluent Forms can re-render (multi-step / ajax) — re-decorate on DOM changes.
	if (window.MutationObserver) {
		new MutationObserver(function () { decoratePhones(document); })
			.observe(document.body, { childList: true, subtree: true });
	}
});
</script>
		<?php
	},
	60
);
