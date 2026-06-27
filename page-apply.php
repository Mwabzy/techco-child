<?php
/**
 * Template Name: Visioner — Admissions / Apply
 *
 * Registration form (Fluent Forms) + brochure download gated on submit success.
 * @package Techco Child
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();
require_once get_stylesheet_directory() . '/inc/page-banner.php';
techco_child_page_banner( 'Admissions — Apply Now', 'Fill the form below. We\'ll confirm your seat over email + WhatsApp.' );
?>

<div id="primary" class="content-area page-content-area pt-120 pb-120">
    <div class="container">
        <div class="row">

            <!-- LEFT: the registration form -->
            <div class="col-lg-7">
                <div class="tc-apply-form">
                    <?php
                    /**
                     * CLAUDE CODE / KUWAYA:
                     * 1. Build the form in Fluent Forms with these fields (from the deck):
                     *    Full name · Email (.ff-validate-email) · Phone/WhatsApp (.ff-number-only) ·
                     *    College/Company · Program & preferred batch · Timing track · Payment plan ·
                     *    How did you hear about us? · Accept No-Refund policy (required checkbox).
                     * 2. Integrations: Google Sheets (Fluent Forms → Integrations),
                     *    confirmation Email (Settings → Notifications),
                     *    WhatsApp (webhook → Cloud API / provider on submit).
                     * 3. Replace the id below with the real form ID.
                     */
                    if ( function_exists( 'do_shortcode' ) ) {
                        echo do_shortcode( '[fluentform id="1"]' );
                    }
                    ?>
                </div>
            </div>

            <!-- RIGHT: trust panel + gated brochure -->
            <div class="col-lg-5">
                <aside class="tc-apply-aside">
                    <h3>Why Visioner</h3>
                    <!-- CLAUDE CODE: 3–4 trust bullets (placement, mentors, projects). -->
                    <ul class="tc-checklist">
                        <li>Industry-mentored, project-first</li>
                        <li>Placement &amp; TPO support</li>
                        <li>EMI-friendly fees</li>
                    </ul>

                    <div class="tc-brochure" data-state="locked">
                        <p class="tc-brochure__locked">📄 Submit the form to unlock the brochure download.</p>
                        <!-- CLAUDE CODE / KUWAYA: upload the brochure to Media, put its URL in href. -->
                        <a class="tc-btn tc-btn--primary tc-brochure__link" href="#BROCHURE_PDF_URL" download hidden>
                            Download Brochure (PDF)
                        </a>
                    </div>
                </aside>
            </div>

        </div>
    </div>
</div>

<?php get_footer();
