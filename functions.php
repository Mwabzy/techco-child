<?php

if ( !defined( 'WP_DEBUG' ) ) {
	die( 'Direct access forbidden.' );
}


add_action( 'wp_enqueue_scripts', 'techco_child_enqueue_styles', 99 );

function techco_child_enqueue_styles() {
   wp_enqueue_style( 'parent-style', get_stylesheet_directory_uri() . '/style.css' );
}

// Premium variable webfont (Inter) for the Visioner pages' refined type scale.
add_action( 'wp_enqueue_scripts', function () {
    wp_enqueue_style(
        'tc-font-inter',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap',
        array(),
        null
    );
}, 5 );
/**
 * Fluent Forms – Email + Mobile validation (JS only)
 */
add_action('wp_footer', function () {
?>
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* -----------------------
     * EMAIL VALIDATION
     * --------------------- */
    document.addEventListener('blur', function (e) {
        if (!e.target.classList.contains('ff-validate-email')) return;

        const email = e.target.value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        removeError(e.target);

        if (email !== '' && !emailRegex.test(email)) {
            showError(e.target, 'Please enter a valid email address');
        }
    }, true);


    /* -----------------------
     * MOBILE NUMBER ONLY
     * --------------------- */
    document.addEventListener('input', function (e) {
        if (!e.target.classList.contains('ff-number-only')) return;

        e.target.value = e.target.value.replace(/\D+/g, '');
    });

    document.addEventListener('paste', function (e) {
        if (!e.target.classList.contains('ff-number-only')) return;

        e.preventDefault();
        const pasted = (e.clipboardData || window.clipboardData)
                        .getData('text')
                        .replace(/\D+/g, '');
        e.target.value = pasted;
    });

    /* -----------------------
     * FORM SUBMIT CHECK
     * --------------------- */
    document.addEventListener('submit', function (e) {
        const emailField = document.querySelector('.ff-validate-email');
        const phoneField = document.querySelector('.ff-number-only');

        let hasError = false;

        if (emailField) {
            removeError(emailField);
            const email = emailField.value.trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (email !== '' && !emailRegex.test(email)) {
                showError(emailField, 'Please enter a valid email address');
                hasError = true;
            }
        }

        if (phoneField && /\D/.test(phoneField.value)) {
            showError(phoneField, 'Mobile number must contain digits only');
            hasError = true;
        }

        if (hasError) e.preventDefault();
    }, true);


    /* -----------------------
     * HELPER FUNCTIONS
     * --------------------- */
    function showError(input, message) {
        const wrapper = input.closest('.ff-el-input--content');
        if (!wrapper) return;

        let error = wrapper.querySelector('.js-error');
        if (!error) {
            error = document.createElement('div');
            error.className = 'error text-danger js-error';
            wrapper.appendChild(error);
        }
        error.textContent = message;
    }

    function removeError(input) {
        const wrapper = input.closest('.ff-el-input--content');
        if (!wrapper) return;

        const error = wrapper.querySelector('.js-error');
        if (error) error.remove();
    }

});
</script>
<?php
});


/**
 * ------------------------------------------------------------------
 * Visioner Training — child theme additions
 * ------------------------------------------------------------------
 */

// Disable the parent theme's scroll-up button
add_filter( 'techco_option_scroll_up_btn', '__return_false' );

// Enqueue custom CSS/JS (loaded after parent/child base styles).
add_action( 'wp_enqueue_scripts', function () {
    $dir = get_stylesheet_directory();
    $uri = get_stylesheet_directory_uri();

    wp_enqueue_style(
        'techco-child-custom',
        $uri . '/assets/css/custom.css',
        array( 'parent-style' ),
        file_exists( $dir . '/assets/css/custom.css' ) ? filemtime( $dir . '/assets/css/custom.css' ) : '1.0.0'
    );

    // Motion One (self-hosted UMD → window.Motion). Loaded before our JS so
    // custom.js can progressively enhance with it when present.
    wp_enqueue_script(
        'motion-one',
        $uri . '/assets/js/vendor/motion.min.js',
        array(),
        file_exists( $dir . '/assets/js/vendor/motion.min.js' ) ? filemtime( $dir . '/assets/js/vendor/motion.min.js' ) : '11.11.13',
        true
    );

    wp_enqueue_script(
        'techco-child-custom',
        $uri . '/assets/js/custom.js',
        array( 'motion-one' ),
        file_exists( $dir . '/assets/js/custom.js' ) ? filemtime( $dir . '/assets/js/custom.js' ) : '1.0.0',
        true
    );
}, 100 );

// Inline SVG icon helper (tc_icon) used across the Visioner templates.
require_once get_stylesheet_directory() . '/inc/icons.php';

// Inline brand-logo SVG helper (tc_brand_icon) for the home "Stack" grid.
require_once get_stylesheet_directory() . '/inc/brand-icons.php';

// Floating WhatsApp click-to-chat widget (hooks wp_footer itself).
require_once get_stylesheet_directory() . '/inc/whatsapp-widget.php';

// Fluent Forms → Google Sheets sync (config via wp-config.php constants).
require_once get_stylesheet_directory() . '/inc/google-sheets-sync.php';

// Visioner sticky nav for templates that hide the parent header (hooks wp_body_open).
require_once get_stylesheet_directory() . '/inc/visioner-nav.php';

// India localization: +91 phone prefix, IST/date defaults, en-IN SEO signals.
require_once get_stylesheet_directory() . '/inc/india-localization.php';

// VisionONE content images: Customizer photo uploaders (tc_opt_image helper).
require_once get_stylesheet_directory() . '/inc/theme-options.php';

// Shared program curriculum data (tc_program_modules / tc_program_search_index).
require_once get_stylesheet_directory() . '/inc/program-data.php';

/**
 * ------------------------------------------------------------------
 * Resolve the URL of a Visioner page by its assigned template file.
 *
 * Links use this so they always point at the right page no matter which
 * slug you choose in wp-admin. If no published page uses the template yet,
 * it falls back to a slug-based URL.
 *
 * Usage: echo esc_url( tc_tpl_url( 'page-apply.php', '/admissions-apply/' ) );
 * ------------------------------------------------------------------
 */
function tc_tpl_url( $template, $fallback = '/' ) {
	static $cache = array();
	if ( isset( $cache[ $template ] ) ) {
		return $cache[ $template ];
	}

	$ids = get_posts( array(
		'post_type'        => 'page',
		'post_status'      => 'publish',
		'numberposts'      => 1,
		'fields'           => 'ids',
		'no_found_rows'    => true,
		'meta_key'         => '_wp_page_template',
		'meta_value'       => $template,
		'suppress_filters' => false,
	) );

	$url = ! empty( $ids ) ? get_permalink( $ids[0] ) : home_url( $fallback );

	$cache[ $template ] = $url;
	return $url;
}

/**
 * ------------------------------------------------------------------
 * Hide the Techco site header on the Visioner page templates.
 *
 * Techco's header.php renders its header only when the page meta
 * techco_common_meta['page_header_disable'] is not true. We inject that
 * flag for our templates (preserving any other Techco settings), so the
 * header is removed without editing the parent theme or each page by hand.
 *
 * To keep the header on a given template, remove it from $targets.
 * To re-enable everywhere, delete this filter.
 * ------------------------------------------------------------------
 */
add_filter( 'get_post_metadata', 'tc_disable_techco_header', 10, 4 );
function tc_disable_techco_header( $value, $object_id, $meta_key, $single ) {
	if ( 'techco_common_meta' !== $meta_key || is_admin() ) {
		return $value;
	}

	static $busy = false;
	if ( $busy ) {
		return $value; // avoid recursion when we read the meta below
	}

	$targets = array(
		'page-home.php',
		'page-program.php',
		'page-fees.php',
		'page-apply.php',
		'page-colleges.php',
		'page-payment.php',
		'page-resources.php',
	);

	$busy     = true;
	$template = get_page_template_slug( $object_id );
	$existing = get_post_meta( $object_id, 'techco_common_meta', true );
	$busy     = false;

	if ( ! in_array( $template, $targets, true ) ) {
		return $value;
	}

	$meta = is_array( $existing ) ? $existing : array();
	$meta['page_header_disable'] = true;

	// get_post_metadata expects an array of values; core returns [0] for single.
	return array( $meta );
}
