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
    <?php if ($page_footer_disable != true):
        // Elevated footer for the Visioner templates; classic copyright elsewhere.
        $tc_footer_templates = array(
            'page-home.php',
            'page-program.php',
            'page-fees.php',
            'page-apply.php',
            'page-colleges.php',
            'page-payment.php',
            'page-resources.php',
        );
        $tc_footer_tpl = is_page() ? (string) get_page_template_slug(get_the_ID()) : '';
        if (function_exists('tc_tpl_url') && in_array($tc_footer_tpl, $tc_footer_templates, true)):
            $tc_home_url = tc_tpl_url('page-home.php', '/');
            $tc_year = date('Y');
            ?>
            <footer class="tc-footer" role="contentinfo">
                <div class="container tc-footer__inner">

                    <div class="tc-footer__brand">
                        <a class="tc-footer__logo" href="<?php echo esc_url($tc_home_url); ?>" aria-label="VisionONE — home">
                            <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/logo.png'); ?>" alt=""
                                aria-hidden="true">
                            <span>Vision<span class="tc-footer__logo-accent">ONE</span></span>
                        </a>
                        <p class="tc-footer__tagline">Job-ready fullstack developer training in 14 weeks — project-first,
                            mentor-led, backed by placement support.</p>
                    </div>

                    <nav class="tc-footer__col" aria-label="Explore">
                        <span class="tc-footer__col-title">Explore</span>
                        <a href="<?php echo esc_url(tc_tpl_url('page-program.php', '/program-curriculum/')); ?>">Program</a>
                        <a href="<?php echo esc_url(tc_tpl_url('page-fees.php', '/fees-batches/')); ?>">Fees &amp; Batches</a>
                        <a href="<?php echo esc_url(tc_tpl_url('page-colleges.php', '/for-colleges/')); ?>">For Colleges</a>
                    </nav>

                    <nav class="tc-footer__col" aria-label="Get started">
                        <span class="tc-footer__col-title">Get started</span>
                        <a href="<?php echo esc_url(tc_tpl_url('page-apply.php', '/admissions-apply/') . '#tc-apply-form-anchor'); ?>">Apply Now</a>
                        <a href="<?php echo esc_url(tc_tpl_url('page-resources.php', '/resources/')); ?>">Study Materials</a>
                    </nav>

                    <div class="tc-footer__cta">
                        <span class="tc-footer__col-title">Admissions open</span>
                        <p>Seats are limited each cohort.</p>
                        <a class="tc-btn tc-btn--primary" data-magnetic
                            href="<?php echo esc_url(tc_tpl_url('page-apply.php', '/admissions-apply/') . '#tc-apply-form-anchor'); ?>">Reserve your
                            seat</a>
                    </div>

                </div>
                <div class="tc-footer__bar">
                    <div class="container tc-footer__bar-inner">
                        <span><?php echo esc_html('© VisionONE ' . $tc_year . ' · All Rights Reserved'); ?></span>
                        <span class="tc-footer__made">Built in India</span>
                    </div>
                </div>
            </footer>
        <?php else:
            echo '<footer class="site-footer default-footer">';
            echo '<div class="footer__copyright">';
            echo '<div class="container">';
            echo '<div class="footer__copyright-inner ul_li_center">';
            echo '<div class="footer__copyright-text mt-15 mb-15">';
            echo esc_html('© VisionONE ' . date('Y') . ' | All Rights Reserved');
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</footer>';
        endif;
    endif; ?>
</footer>

</div><!-- #page -->


<?php wp_footer(); ?>

</body>

</html>