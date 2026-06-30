<?php
/**
 * Template Name: Visioner — Admissions / Apply
 *
 * Premium admissions funnel: hero, how-to-apply steps, eligibility,
 * batches, application form + trust panel, FAQ, CTA.
 * NOTE: intentionally omits techco_child_page_banner() — the .tc-hero
 * below provides its own breadcrumb + title, mirrors page-program.php.
 * @package Techco Child
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();

/**
 * CLAUDE CODE: Placeholder admissions content — swap copy/dates for the
 * final deck wording before launch.
 */

/**
 * Minimal line-icon set (24x24, stroke = currentColor) — keeps the page
 * SVG-based instead of relying on emoji glyphs for visual consistency
 * across OS/browser fonts.
 */
$tc_icons = array(
	'apply'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>',
	'call'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.69 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.9.33 1.85.56 2.81.69A2 2 0 0 1 22 16.92Z"/></svg>',
	'offer'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10 12 5 2 10l10 5 10-5Z"/><path d="M6 12v5c0 1.1 2.7 2 6 2s6-.9 6-2v-5"/></svg>',
	'rocket' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09Z"/><path d="M12 15l-3-3 4.5-9 5.5 1.5L20 9.5 11 12.5"/><path d="M15 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/></svg>',
	'doc'    => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"/><path d="M14 2v6h6"/></svg>',
);

$tc_steps = array(
	array( 'icon' => 'apply',  'title' => 'Apply Online',      'desc' => 'Submit the form below with your details and preferred batch.' ),
	array( 'icon' => 'call',   'title' => 'Counselling Call',  'desc' => 'Our team calls within 24h to discuss the track, fit and timing.' ),
	array( 'icon' => 'offer',  'title' => 'Offer & Seat Lock',  'desc' => 'Get your offer letter and lock your seat with the first payment.' ),
	array( 'icon' => 'rocket', 'title' => 'Onboarding',        'desc' => 'Join the orientation session and meet your mentors before Day 1.' ),
);

$tc_eligibility = array(
	'Open to graduates, final-year students &amp; career-switchers',
	'No prior coding experience required — we start from fundamentals',
	'Basic computer literacy and a stable internet connection',
	'Comfortable committing 15–20 hrs/week for the duration of the cohort',
);

$tc_batches = array(
	array( 'name' => 'Cohort — July 2026',      'date' => 'Starts 6 Jul 2026',  'mode' => 'Online · Hybrid', 'seats' => 'Few seats left' ),
	array( 'name' => 'Cohort — September 2026', 'date' => 'Starts 7 Sep 2026',  'mode' => 'Online',          'seats' => 'Open' ),
	array( 'name' => 'Cohort — November 2026',  'date' => 'Starts 2 Nov 2026',  'mode' => 'Hybrid',          'seats' => 'Open' ),
);

$tc_faqs = array(
	array( 'q' => 'Is there a refund if I change my mind after enrolling?', 'a' => 'Our No-Refund policy applies once a seat is confirmed — please review it carefully before paying. We\'re happy to answer questions on a counselling call first.' ),
	array( 'q' => 'Can I pay in EMIs?',                                     'a' => 'Yes — EMI-friendly plans are available. Exact EMI amounts are on the Fees &amp; Batches page.' ),
	array( 'q' => 'Do I need prior coding experience to apply?',            'a' => 'No. The programme is designed for absolute beginners and ramps up from web fundamentals.' ),
	array( 'q' => 'Will I get a certificate?',                              'a' => 'Yes, you receive a certificate of completion once you finish the capstone project.' ),
	array( 'q' => 'Is placement support included?',                         'a' => 'Yes — every cohort includes placement &amp; TPO support as part of the programme.' ),
	array( 'q' => 'What if my preferred batch is full?',                    'a' => 'We\'ll offer you the next available cohort and hold your application on file.' ),
);
?>

<div id="primary" class="content-area page-content-area tc-page pt-120 pb-120">
    <div class="container">

        <!-- SECTION: Hero -->
        <section class="tc-hero tc-texture-dots tc-reveal">
            <!-- Ambient glow orbs -->
            <div class="tc-glow-orb tc-glow-orb--blue" aria-hidden="true"></div>
            <div class="tc-glow-orb tc-glow-orb--orange" aria-hidden="true"></div>

            <nav class="tc-hero__crumbs" aria-label="Breadcrumb">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a><span>›</span>
                <span class="tc-hero__crumbs-current">Admissions</span>
            </nav>

            <h1 class="tc-hero__title"><span class="tc-gradient-text tc-gradient-text--freeze">Admissions are open</span></h1>
            <p class="tc-hero__sub">Apply in minutes. Our team will confirm your seat over email &amp;
                WhatsApp, and walk you through fees, batches and onboarding.</p>

            <span class="tc-badge tc-badge--bestseller">Admissions Open</span>

            <div class="tc-hero__stats">
                <div class="tc-stat">
                    <strong class="tc-stat__num" data-animate>6 Jul 2026</strong>
                    <span class="tc-stat__label">next intake</span>
                </div>
                <div class="tc-stat tc-stat--divider">
                    <strong class="tc-stat__num" data-animate>24 hrs</strong>
                    <span class="tc-stat__label">avg. response time</span>
                </div>
                <div class="tc-stat tc-stat--divider">
                    <strong class="tc-stat__num" data-animate>Limited</strong>
                    <span class="tc-stat__label">seats per cohort</span>
                </div>
            </div>
        </section>

        <!-- SECTION: How to apply -->
        <section class="tc-section tc-steps-section tc-reveal">
            <span class="tc-eyebrow">The Process</span>
            <h2 class="tc-section__title">How admissions work</h2>
            <div class="tc-timeline">
                <?php foreach ( $tc_steps as $i => $s ) : ?>
                <div class="tc-timeline__step tc-reveal" style="--delay: <?php echo $i * 80; ?>ms">
                    <div class="tc-timeline__node"><?php echo esc_html( $i + 1 ); ?></div>
                    <h3 class="tc-timeline__title"><?php echo esc_html( $s['title'] ); ?></h3>
                    <p class="tc-muted"><?php echo esc_html( $s['desc'] ); ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- SECTION: Eligibility -->
        <section class="tc-section tc-section--tint tc-eligibility-section tc-reveal">
            <span class="tc-eyebrow">Who can apply</span>
            <h2 class="tc-section__title">Eligibility</h2>
            <ul class="tc-checklist tc-eligibility-grid">
                <?php foreach ( $tc_eligibility as $i => $item ) : ?>
                <li class="tc-reveal" style="--delay: <?php echo $i * 70; ?>ms"><?php echo wp_kses_post( $item ); ?></li>
                <?php endforeach; ?>
            </ul>
        </section>

        <!-- SECTION: Dates & batches -->
        <section class="tc-section tc-batches-section tc-reveal">
            <span class="tc-eyebrow">Plan ahead</span>
            <h2 class="tc-section__title">Upcoming batches</h2>
            <p class="tc-muted tc-placeholder-note">Dates shown are indicative — confirm final batch dates on the Fees &amp; Batches page.</p>
            <div class="tc-batch-list">
                <?php foreach ( $tc_batches as $i => $b ) : ?>
                <a href="#tc-apply-form-anchor" class="tc-batch-item tc-reveal" style="--delay: <?php echo $i * 80; ?>ms">
                    <span class="tc-batch-item__tag"><?php echo esc_html( $b['mode'] ); ?></span>
                    <span class="tc-batch-item__body">
                        <span class="tc-batch-item__title"><?php echo esc_html( $b['name'] ); ?></span>
                        <span class="tc-batch-item__desc tc-muted"><?php echo esc_html( $b['date'] ); ?> · <?php echo esc_html( $b['seats'] ); ?></span>
                    </span>
                    <?php echo tc_icon( 'arrow-right', 18, 'tc-batch-item__arrow' ); ?>
                </a>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- SECTION: Application form + trust panel -->
        <section class="tc-section tc-apply-section tc-reveal" id="tc-apply-form-anchor">
            <span class="tc-eyebrow">Apply</span>
            <h2 class="tc-section__title">Start your application</h2>

            <div class="row">

                <!-- LEFT: the registration form -->
                <div class="col-lg-7 tc-reveal">
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
                <div class="col-lg-5 tc-reveal" style="--delay: 100ms">
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
        </section>

        <!-- SECTION: FAQ -->
        <section class="tc-section tc-section--tint tc-faq-section tc-reveal">
            <span class="tc-eyebrow">Questions</span>
            <h2 class="tc-section__title">Frequently asked questions</h2>
            <div class="tc-faq">
                <?php foreach ( $tc_faqs as $i => $faq ) : ?>
                <details class="tc-faq__item tc-reveal" style="--delay: <?php echo ( $i % 4 ) * 70; ?>ms" <?php echo $i === 0 ? 'open' : ''; ?>>
                    <summary class="tc-faq__q"><?php echo esc_html( $faq['q'] ); ?></summary>
                    <p class="tc-faq__a tc-muted"><?php echo wp_kses_post( $faq['a'] ); ?></p>
                </details>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- SECTION: CTA -->
        <section class="tc-section tc-cta-band text-center">
            <h2>Seats fill up fast each cohort</h2>
            <p class="tc-cta-band__sub">Apply now and our team will confirm your batch over email &amp; WhatsApp
                within 24 hours.</p>
            <div class="tc-cta-band__actions">
                <a class="tc-btn tc-btn--primary" href="#tc-apply-form-anchor">Apply Now</a>
                <a class="tc-btn tc-btn--ghost" href="<?php echo esc_url( tc_tpl_url( 'page-fees.php', '/fees-batches/' ) ); ?>">View Fees &amp; Batches</a>
            </div>
        </section>

    </div>
</div>

<?php get_footer();
