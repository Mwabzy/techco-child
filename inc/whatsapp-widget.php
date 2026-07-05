<?php
/**
 * Floating WhatsApp click-to-chat widget.
 * Renders a fixed button (bottom-right) that deep-links to wa.me with a prefilled message.
 * Number + default message are filtered so you can change them without editing markup.
 *
 * @package Techco Child
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('techco_child_whatsapp_widget')) {
    function techco_child_whatsapp_widget()
    {

        // VisionOne WhatsApp line (intl format, digits only, no +).
        $number = apply_filters('techco_child_wa_number', '918143533535');
        $message = apply_filters('techco_child_wa_message', 'Hi visionONE, I\'d like to know more about the Full Stack Training program.');

        if (empty($number)) {
            return;
        }

        $href = 'https://wa.me/' . rawurlencode($number) . '?text=' . rawurlencode($message);
        ?>
        <a class="tc-wa-float" href="<?php echo esc_url($href); ?>" target="_blank" rel="noopener nofollow"
            aria-label="Chat on WhatsApp">
            <svg viewBox="0 0 32 32" width="28" height="28" aria-hidden="true" focusable="false">
                <path fill="currentColor"
                    d="M16.04 3.2c-7.1 0-12.86 5.76-12.86 12.86 0 2.27.6 4.49 1.73 6.44L3.2 28.8l6.49-1.7a12.8 12.8 0 0 0 6.35 1.62h.01c7.1 0 12.86-5.76 12.86-12.86S23.14 3.2 16.04 3.2zm0 23.5h-.01a10.6 10.6 0 0 1-5.4-1.48l-.39-.23-3.85 1.01 1.03-3.75-.25-.39a10.62 10.62 0 1 1 19.72-5.6c0 5.87-4.78 10.65-10.65 10.65zm6.16-7.97c-.34-.17-2-.99-2.31-1.1-.31-.11-.54-.17-.76.17-.22.34-.87 1.1-1.07 1.32-.2.23-.39.25-.73.08-.34-.17-1.43-.53-2.72-1.68-1-.9-1.68-2-1.88-2.34-.2-.34-.02-.52.15-.69.15-.15.34-.39.51-.59.17-.2.22-.34.34-.57.11-.23.06-.43-.03-.6-.08-.17-.76-1.84-1.05-2.52-.27-.66-.55-.57-.76-.58l-.65-.01c-.22 0-.59.08-.9.43-.31.34-1.18 1.16-1.18 2.82s1.21 3.27 1.38 3.5c.17.23 2.38 3.64 5.77 5.1.81.35 1.43.56 1.92.71.81.26 1.54.22 2.12.13.65-.1 2-.82 2.28-1.6.28-.79.28-1.46.2-1.6-.08-.14-.31-.23-.65-.4z" />
            </svg>
        </a>
        <?php
    }
}
add_action('wp_footer', 'techco_child_whatsapp_widget', 50);
