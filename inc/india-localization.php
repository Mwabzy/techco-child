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
 * 3. Country dial-code picker on Fluent Forms phone fields.
 *    Replaces the old fixed "+91" badge with a <select> of dial codes
 *    (defaults to India). The chosen code is prepended to the value at
 *    submit time so the stored/synced number is fully international,
 *    while the user keeps seeing just their local number.
 * ---------------------------------------------------------------- */
add_action(
	'wp_footer',
	function () {
		?>
<script>
document.addEventListener('DOMContentLoaded', function () {
	// [name, dial code, max local digits]. India first, then common
	// destinations, then the rest. Add/remove rows freely.
	var TC_COUNTRIES = [
		['India', '+91', 10],
		['United States', '+1', 10],
		['Canada', '+1', 10],
		['United Kingdom', '+44', 10],
		['United Arab Emirates', '+971', 9],
		['Saudi Arabia', '+966', 9],
		['Qatar', '+974', 8],
		['Kuwait', '+965', 8],
		['Oman', '+968', 8],
		['Bahrain', '+973', 8],
		['Australia', '+61', 9],
		['New Zealand', '+64', 9],
		['Singapore', '+65', 8],
		['Malaysia', '+60', 9],
		['Indonesia', '+62', 11],
		['Philippines', '+63', 10],
		['Thailand', '+66', 9],
		['Vietnam', '+84', 9],
		['China', '+86', 11],
		['Hong Kong', '+852', 8],
		['Japan', '+81', 10],
		['South Korea', '+82', 10],
		['Pakistan', '+92', 10],
		['Bangladesh', '+880', 10],
		['Sri Lanka', '+94', 9],
		['Nepal', '+977', 10],
		['Germany', '+49', 11],
		['France', '+33', 9],
		['Italy', '+39', 10],
		['Spain', '+34', 9],
		['Netherlands', '+31', 9],
		['Belgium', '+32', 9],
		['Switzerland', '+41', 9],
		['Austria', '+43', 10],
		['Ireland', '+353', 9],
		['Portugal', '+351', 9],
		['Sweden', '+46', 9],
		['Norway', '+47', 8],
		['Denmark', '+45', 8],
		['Poland', '+48', 9],
		['Greece', '+30', 10],
		['Turkey', '+90', 10],
		['Russia', '+7', 10],
		['Israel', '+972', 9],
		['Egypt', '+20', 10],
		['Morocco', '+212', 9],
		['Nigeria', '+234', 10],
		['Ghana', '+233', 9],
		['Kenya', '+254', 9],
		['Tanzania', '+255', 9],
		['Uganda', '+256', 9],
		['Ethiopia', '+251', 9],
		['South Africa', '+27', 9],
		['Zambia', '+260', 9],
		['Zimbabwe', '+263', 9],
		['Rwanda', '+250', 9],
		['Brazil', '+55', 11],
		['Mexico', '+52', 10],
		['Argentina', '+54', 10]
	];

	// Set to false if your phone field rejects the "+" character on submit
	// (stores digits only, e.g. 919876543210 instead of +919876543210).
	var PREPEND_PLUS = true;

	// Which country is pre-selected. Match by dial code.
	var DEFAULT_DIAL = '+91';

	function buildSelect() {
		var sel = document.createElement('select');
		sel.className = 'tc-phone-cc';
		sel.setAttribute('aria-label', 'Country dialing code');
		TC_COUNTRIES.forEach(function (c) {
			var o = document.createElement('option');
			o.value = c[1];
			o.setAttribute('data-len', c[2]);
			o.textContent = c[1] + '  ' + c[0]; // "+91  India"
			if (c[1] === DEFAULT_DIAL && !sel.value) { o.selected = true; }
			sel.appendChild(o);
		});
		return sel;
	}

	function applyCountry(input, sel) {
		var opt = sel.options[sel.selectedIndex];
		var len = opt ? parseInt(opt.getAttribute('data-len'), 10) : 15;
		input.setAttribute('maxlength', String(len || 15));
		input.dataset.tcDial = sel.value || DEFAULT_DIAL;
	}

	function decoratePhones(scope) {
		(scope || document).querySelectorAll('input.ff-number-only').forEach(function (input) {
			if (input.dataset.tcPhone) return;        // already done
			input.dataset.tcPhone = '1';

			var wrap = document.createElement('span');
			wrap.className = 'tc-phone-wrap';
			input.parentNode.insertBefore(wrap, input);

			var sel = buildSelect();
			wrap.appendChild(sel);
			wrap.appendChild(input);

			input.setAttribute('inputmode', 'numeric');
			// Clean local-number example; never a "+91 …" placeholder that would
			// read as a doubled code next to the picker.
			input.setAttribute('placeholder', '98765 43210');
			applyCountry(input, sel);

			sel.addEventListener('change', function () { applyCountry(input, sel); });
		});
	}
	decoratePhones(document);
	// Fluent Forms can re-render (multi-step / ajax) — re-decorate on DOM changes.
	if (window.MutationObserver) {
		new MutationObserver(function () { decoratePhones(document); })
			.observe(document.body, { childList: true, subtree: true });
	}

	// Prepend the selected dial code into the submitted value, then restore the
	// field so the user keeps seeing just their local number. Capture phase so
	// Fluent Forms serializes the prefixed value before we revert it.
	document.addEventListener('submit', function (e) {
		var form = e.target;
		if (!form || !form.querySelectorAll) { return; }
		form.querySelectorAll('input.ff-number-only[data-tc-phone]').forEach(function (input) {
			var digits = (input.value || '').replace(/\D/g, '');
			if (!digits) { return; }
			var dial = input.dataset.tcDial || DEFAULT_DIAL;
			var code = PREPEND_PLUS ? dial : dial.replace(/\D/g, '');
			input.dataset.tcOrig = input.value;
			input.value = code + digits;
			setTimeout(function () {
				if (input.dataset.tcOrig !== undefined) {
					input.value = input.dataset.tcOrig;
					delete input.dataset.tcOrig;
				}
			}, 0);
		});
	}, true);
});
</script>
		<?php
	},
	60
);
