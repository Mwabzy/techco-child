<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package techco
 */
if (get_post_meta(get_the_ID(), 'techco_common_meta', true)) {
    $footer_meta = get_post_meta(get_the_ID(), 'techco_common_meta', true);
} else {
    $footer_meta = array();
}

if (array_key_exists('page_footer_disable', $footer_meta)) {
    $page_footer_disable = $footer_meta['page_footer_disable'];
} else {
    $page_footer_disable = false;
}

$page_footer_sticky_disable = isset($footer_meta['page_footer_sticky_disable']) ? $footer_meta['page_footer_sticky_disable'] : false;
$global_footer_sticky = techco_option('footer_sticky');
$page_sticky_enabled = !$page_footer_sticky_disable && $global_footer_sticky;
?>
</div>
<footer class="xb-footer <?php if ($page_sticky_enabled) { ?>sticky<?php } ?>">
    <?php if ($page_footer_disable != true) {
        echo '<footer class="site-footer default-footer">';
        echo '<div class="footer__copyright">';
        echo '<div class="container">';
        echo '<div class="footer__copyright-inner ul_li_center">';
        echo '<div class="footer__copyright-text mt-15 mb-15">';
        echo esc_html('© visionONE 2026 | All Rights Reserved');
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</footer>';
    } ?>
</footer>

</div><!-- #page -->


<?php wp_footer(); ?>

</body>
</html>
