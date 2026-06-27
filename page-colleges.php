<?php
/**
 * Template Name: Visioner — For Colleges (TPO)
 *
 * B2B/TPO enquiry page for bulk/college tie-ups.
 * @package Techco Child
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();
require_once get_stylesheet_directory() . '/inc/page-banner.php';
techco_child_page_banner( 'For Colleges & TPOs', 'Bulk training, campus tie-ups and placement pipelines' );
?>

<div id="primary" class="content-area page-content-area pt-120 pb-120">
    <div class="container">

        <!-- SECTION: Value for colleges -->
        <section class="tc-section">
            <h2 class="tc-section__title">Partner with Visioner</h2>
            <div class="row">
                <!-- CLAUDE CODE: 3 value cards (bulk pricing, on-campus/online cohorts, placement reporting). -->
                <div class="col-lg-4"><div class="tc-feature"><h3>Bulk Pricing</h3><p class="tc-muted">Placeholder.</p></div></div>
                <div class="col-lg-4"><div class="tc-feature"><h3>Flexible Cohorts</h3><p class="tc-muted">Placeholder.</p></div></div>
                <div class="col-lg-4"><div class="tc-feature"><h3>Placement Reports</h3><p class="tc-muted">Placeholder.</p></div></div>
            </div>
        </section>

        <!-- SECTION: TPO enquiry form -->
        <section class="tc-section tc-tpo-enquiry">
            <h2 class="tc-section__title">TPO Enquiry</h2>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <?php
                    // CLAUDE CODE / KUWAYA: a separate, shorter Fluent Form for colleges
                    // (College name · TPO contact · Email · Phone · No. of students · Message).
                    // Replace the id below with the real TPO form ID.
                    if ( function_exists( 'do_shortcode' ) ) {
                        echo do_shortcode( '[fluentform id="2"]' );
                    }
                    ?>
                </div>
            </div>
        </section>

    </div>
</div>

<?php get_footer();
