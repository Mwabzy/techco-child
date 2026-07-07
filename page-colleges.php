<?php
/**
 * Template Name: visionONE — For Colleges (TPO)
 *
 * B2B/TPO page: bulk pricing, engagement models + TPO enquiry form.
 * Udemy-style hero with a sticky enquiry card alongside the content.
 * NOTE: omits techco_child_page_banner() — the .tc-hero provides its own
 * breadcrumb + title (same pattern as page-program.php).
 * @package Techco Child
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();

/**
 * Bulk / college pricing (from the Visioner deck — "College & Bulk Pricing").
 * Per-student rates, exclusive of GST (shown as "+ GST"). 'rec' marks the
 * recommended tier. Swap figures here if the deck is revised.
 */
$tc_bulk = array(
	array( 'name' => 'Core Program',     'dur' => '10 Weeks', 'b20' => '₹35,000', 'b40' => '₹29,000', 'rec' => false ),
	array( 'name' => 'Core + Cloud',     'dur' => '12 Weeks', 'b20' => '₹40,000', 'b40' => '₹34,000', 'rec' => false ),
	array( 'name' => 'Complete Bundle',  'dur' => '14 Weeks', 'b20' => '₹49,000', 'b40' => '₹42,000', 'rec' => true ),
);

// Official VisionOne contact details.
$tc_org = array(
	'name'  => 'VisionOne Access Private Limited',
	'addr'  => 'Plot No: 3-225, 4th Floor, Mahendra Mindspace, Kavuri Hills, Phase 2, Madhapur, Hyderabad, Telangana – 500033',
	'email' => 'marketing@visionerpsolutions.com',
	'web'   => 'www.visionerpsolutions.com',
	'phone' => '+91 8143533434',
	'wa'    => '+91 8143533535',
	'hours' => 'Mon – Fri: 10 am – 7 pm (closed weekends &amp; public holidays)',
	'gstin' => '36AALCV9084F1ZR',
	'cin'   => 'U62011TS2026PTC211545',
);
$tc_tel    = preg_replace( '/[^0-9+]/', '', $tc_org['phone'] );
$tc_wa_tel = preg_replace( '/[^0-9+]/', '', $tc_org['wa'] );
?>

<div id="primary" class="content-area page-content-area tc-page pt-120 pb-120">
    <div class="container">

        <!-- Full-width gradient banner hero (consistent with the program page) -->
        <nav class="tc-hero__crumbs tc-coursebanner__crumbs" aria-label="Breadcrumb">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a><span>›</span>
            <span class="tc-hero__crumbs-current">For Colleges &amp; TPOs</span>
        </nav>

        <section class="tc-coursebanner tc-coursebanner--simple tc-reveal">
            <span class="tc-coursebanner__bg" data-parallax="10" aria-hidden="true"></span>
            <div class="tc-coursebanner__inner">
                <div class="tc-coursebanner__content" data-motion-in>
                    <span class="tc-coursebanner__kicker">visionONE Training · College &amp; Bulk</span>
                    <h1 class="tc-coursebanner__title">Train &amp; place your students with visionONE</h1>
                    <p class="tc-coursebanner__desc">Industry-grade fullstack training for your campus — delivered
                        on-site or online at transparent bulk rates, with placement reporting and zero revenue-share.</p>
                    <div class="tc-coursebanner__stats">
                        <span class="tc-herostat"><strong>50+</strong><span>campus cohorts run</span></span>
                        <span class="tc-herostat"><strong>12,000+</strong><span>students trained</span></span>
                        <span class="tc-herostat"><strong>20–40+</strong><span>batch sizes supported</span></span>
                        <span class="tc-herostat"><strong>0%</strong><span>revenue-share</span></span>
                    </div>
                    <div class="tc-coursebanner__actions">
                        <a class="tc-btn tc-btn--light" data-magnetic href="#tpo-enquiry">Request a proposal</a>
                        <a class="tc-btn tc-btn--ghost" href="tel:<?php echo esc_attr( $tc_tel ); ?>">Call the placements team</a>
                    </div>
                </div>
            </div>
        </section>

        <div class="row tc-program-body">
            <!-- Single centred reading column (sticky panel removed — its CTAs
                 now live in the banner; contact details are in the footer contact
                 section and the TPO enquiry form below). -->
            <div class="col-12 tc-program-content">

                <!-- Value cards -->
                <section class="tc-section tc-college-value tc-reveal">
                    <h2 class="tc-section__title">Why colleges choose us</h2>
                    <div class="tc-bento tc-bento--2col">
                        <div class="tc-feature tc-bento__cell--lead tc-reveal" style="--delay: 0ms">
                            <span class="tc-feature__ic tc-feature__ic--blue">₹</span>
                            <div>
                                <h3>Bulk &amp; transparent pricing</h3>
                                <p class="tc-muted">Discounted per-student rates that drop further at 40+.
                                    Clean GST invoice — no hidden fees, no commissions.</p>
                            </div>
                        </div>
                        <div class="tc-feature tc-reveal" style="--delay: 80ms">
                            <span class="tc-feature__ic tc-feature__ic--violet"><?php echo tc_icon( 'sliders', 24 ); ?></span>
                            <h3>Flexible cohorts</h3>
                            <p class="tc-muted">On-campus or fully online, weekday or weekend tracks,
                                scheduled around your academic calendar.</p>
                        </div>
                        <div class="tc-feature tc-reveal" style="--delay: 160ms">
                            <span class="tc-feature__ic tc-feature__ic--amber"><?php echo tc_icon( 'chart', 24 ); ?></span>
                            <h3>Placement reporting</h3>
                            <p class="tc-muted">Attendance, assessment scores and a placement-ready
                                pipeline, reported back to your TPO cell.</p>
                        </div>
                    </div>
                </section>

                <!-- Bulk pricing table -->
                <section class="tc-section tc-bulk tc-reveal">
                    <h2 class="tc-section__title">College &amp; bulk pricing</h2>
                    <p class="tc-muted tc-bulk__lead">Per-student fees. Rates fall as batch size grows —
                        all figures exclusive of 18% GST.</p>

                    <div class="tc-ptable-wrap">
                        <table class="tc-ptable">
                            <thead>
                                <tr>
                                    <th class="tc-ptable__plan">Program (per student)</th>
                                    <th>Duration</th>
                                    <th>Batch 20+</th>
                                    <th>Batch 40+</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ( $tc_bulk as $row ) : ?>
                                <tr class="<?php echo $row['rec'] ? 'tc-ptable__row--rec' : ''; ?>">
                                    <td class="tc-ptable__plan">
                                        <?php echo esc_html( $row['name'] ); ?>
                                        <?php if ( $row['rec'] ) : ?>
                                            <span class="tc-ptable__star" aria-hidden="true">★</span>
                                            <span class="tc-ptable__badge">Recommended</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo esc_html( $row['dur'] ); ?></td>
                                    <td><strong><?php echo esc_html( $row['b20'] ); ?></strong> <span class="tc-ptable__gst">+ GST</span></td>
                                    <td><strong><?php echo esc_html( $row['b40'] ); ?></strong> <span class="tc-ptable__gst">+ GST</span></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- Engagement models -->
                <section class="tc-section tc-models tc-reveal">
                    <h2 class="tc-section__title">Two ways to engage</h2>
                    <div class="row">
                        <div class="col-md-6 tc-reveal" style="--delay: 0ms">
                            <div class="tc-model tc-model--a">
                                <span class="tc-model__tag">Model A</span>
                                <h3 class="tc-model__name">Student-paid</h3>
                                <p class="tc-muted">College hosts the batch; students pay visionONE directly
                                    at the bulk rate. Zero cost to the institution.</p>
                            </div>
                        </div>
                        <div class="col-md-6 tc-reveal" style="--delay: 80ms">
                            <div class="tc-model tc-model--b">
                                <span class="tc-model__tag">Model B</span>
                                <h3 class="tc-model__name">College-sponsored</h3>
                                <p class="tc-muted">Invoice raised against a PO on Net 15 / Net 30 terms.
                                    No commission, no revenue-share.</p>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>

        <!-- SECTION: TPO enquiry form (full width) -->
        <section class="tc-section tc-tpo-enquiry tc-reveal" id="tpo-enquiry">
            <div class="tc-tpo-panel">
                <div class="row align-items-center">
                    <div class="col-lg-5">
                        <span class="tc-eyebrow">TPO Enquiry</span>
                        <h2 class="tc-section__title">Request a campus proposal</h2>
                        <p class="tc-muted">Tell us about your cohort and we'll send a tailored proposal —
                            pricing, schedule and delivery model — within 1–2 working days.</p>
                        <ul class="tc-checklist">
                            <li>Custom batch size &amp; timing</li>
                            <li>On-campus or online delivery</li>
                            <li>GST invoice against PO</li>
                        </ul>
                    </div>
                    <div class="col-lg-7">
                        <div class="tc-tpo-formwrap">
                            <?php
                            // CLAUDE CODE / KUWAYA: shorter Fluent Form for colleges
                            // (College name · TPO contact · Email · Phone · No. of students · Message).
                            // Replace the id below with the real TPO form ID.
                            if ( function_exists( 'do_shortcode' ) ) {
                                echo do_shortcode( '[fluentform id="2"]' );
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION: Contact / org info (full width) -->
        <section class="tc-section tc-section--tint tc-contact tc-reveal">
            <div class="tc-contact__grid">
                <div class="tc-contact__col">
                    <h3 class="tc-contact__org"><?php echo esc_html( $tc_org['name'] ); ?></h3>
                    <p class="tc-muted"><?php echo esc_html( $tc_org['addr'] ); ?></p>
                </div>
                <div class="tc-contact__col">
                    <ul class="tc-contact__list">
                        <li><span>Phone</span><a href="tel:<?php echo esc_attr( $tc_tel ); ?>"><?php echo esc_html( $tc_org['phone'] ); ?></a></li>
                        <li><span>WhatsApp</span><a href="https://wa.me/<?php echo esc_attr( ltrim( $tc_wa_tel, '+' ) ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $tc_org['wa'] ); ?></a></li>
                        <li><span>Email</span><a href="mailto:<?php echo esc_attr( $tc_org['email'] ); ?>"><?php echo esc_html( $tc_org['email'] ); ?></a></li>
                        <li><span>Web</span><a href="https://<?php echo esc_attr( $tc_org['web'] ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $tc_org['web'] ); ?></a></li>
                        <li><span>Hours</span><?php echo wp_kses_post( $tc_org['hours'] ); ?></li>
                        <li><span>GSTIN</span><?php echo esc_html( $tc_org['gstin'] ); ?></li>
                        <li><span>CIN</span><?php echo esc_html( $tc_org['cin'] ); ?></li>
                    </ul>
                </div>
            </div>
        </section>

    </div>
</div>

<?php get_footer();
