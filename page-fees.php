<?php
/**
 * Template Name: Visioner — Fees & Batches
 *
 * Fee plans (incl. GST), batch schedule, Razorpay payment + EMI info.
 * @package Techco Child
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();
require_once get_stylesheet_directory() . '/inc/page-banner.php';
techco_child_page_banner( 'Fees & Batches', 'Transparent pricing — all figures inclusive of 18% GST' );
?>

<div id="primary" class="content-area page-content-area pt-120 pb-120">
    <div class="container">

        <!-- SECTION: Fee plans -->
        <section class="tc-section tc-fees">
            <h2 class="tc-section__title">Fee Plans</h2>
            <div class="row">
                <!-- CLAUDE CODE: build the pricing cards from slides 5–6 (Course Fees / Bulk Pricing).
                     Each card: plan name, base fee, GST line, total. Mark the recommended plan. -->
                <div class="col-lg-4">
                    <div class="tc-price-card">
                        <h3 class="tc-price-card__name">Standard</h3>
                        <p class="tc-price-card__base">₹ — base</p>
                        <p class="tc-price-card__gst">+18% GST</p>
                        <p class="tc-price-card__total"><strong>₹ — total</strong></p>
                        <a class="tc-btn tc-btn--outline" href="/admissions-apply/">Enrol</a>
                    </div>
                </div>
                <!-- repeat for other plans … -->
            </div>
        </section>

        <!-- SECTION: Batch schedule -->
        <section class="tc-section tc-batches">
            <h2 class="tc-section__title">Batch Schedule & Timings</h2>
            <!-- CLAUDE CODE: table from slide 8 (Batch Schedule & Timings) — track, start date, timing. -->
            <table class="tc-table">
                <thead><tr><th>Batch</th><th>Track</th><th>Timing</th><th>Starts</th></tr></thead>
                <tbody>
                    <tr><td>—</td><td>Weekday</td><td>—</td><td>—</td></tr>
                </tbody>
            </table>
        </section>

        <!-- SECTION: Payment + EMI -->
        <section class="tc-section tc-payment">
            <h2 class="tc-section__title">Pay Online</h2>
            <p class="tc-muted">Secure payment via Razorpay. EMI and No-Cost EMI available on eligible cards.</p>

            <div class="tc-razorpay-slot">
                <!-- CLAUDE CODE / KUWAYA: paste the Razorpay Payment Button snippet here.
                     Razorpay Dashboard → Payment Button → Generate → copy the <form>…<script> block.
                     It is a hosted button; no server code needed. Keep the live key on live only. -->
                <p class="tc-placeholder-note">[ Razorpay Payment Button goes here ]</p>
            </div>

            <div class="tc-emi-info">
                <h3>EMI &amp; No-Refund Policy</h3>
                <!-- CLAUDE CODE: EMI plans from slide 7 (Payment Plans & No-Refund Policy). -->
                <p class="tc-muted">Placeholder — list EMI tenures and the no-refund terms.</p>
            </div>
        </section>

    </div>
</div>

<?php get_footer();
