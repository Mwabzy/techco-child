<?php

if ( !defined( 'WP_DEBUG' ) ) {
	die( 'Direct access forbidden.' );
}


add_action( 'wp_enqueue_scripts', 'techco_child_enqueue_styles', 99 );

function techco_child_enqueue_styles() {
   wp_enqueue_style( 'parent-style', get_stylesheet_directory_uri() . '/style.css' );
}
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

    wp_enqueue_script(
        'techco-child-custom',
        $uri . '/assets/js/custom.js',
        array(),
        file_exists( $dir . '/assets/js/custom.js' ) ? filemtime( $dir . '/assets/js/custom.js' ) : '1.0.0',
        true
    );
}, 100 );

// Floating WhatsApp click-to-chat widget (hooks wp_footer itself).
require_once get_stylesheet_directory() . '/inc/whatsapp-widget.php';
