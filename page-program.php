<?php
/**
 * Template Name: Visioner — Program / Curriculum
 *
 * 14-week fullstack curriculum, with a Udemy-style course hero + sticky enrol
 * card and a collapsible "Course content" accordion.
 * NOTE: this template intentionally omits techco_child_page_banner() — the
 * .tc-hero below provides its own breadcrumb + title so a banner would duplicate it.
 * @package Techco Child
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();

/**
 * CLAUDE CODE: Placeholder curriculum — realistic fullstack ladder, swap the
 * exact topics/blurbs/lesson-counts/durations for the final deck wording.
 * 'phase' drives the accent colour. 'lessons'/'mins' feed the accordion meta + totals.
 */
$tc_weeks = array(
	array( 'phase' => 'Frontend', 'topic' => 'Web Foundations',            'lessons' => 8,  'mins' => 70,  'desc' => 'HTML5 semantics, CSS3, the box model and responsive, mobile-first layouts.' ),
	array( 'phase' => 'Frontend', 'topic' => 'Modern CSS & UI',            'lessons' => 7,  'mins' => 60,  'desc' => 'Flexbox, CSS Grid, Bootstrap utilities, components and accessible design.' ),
	array( 'phase' => 'Frontend', 'topic' => 'JavaScript Fundamentals',    'lessons' => 9,  'mins' => 75,  'desc' => 'ES6+ syntax, the DOM, events, and interactive UI from scratch.' ),
	array( 'phase' => 'Frontend', 'topic' => 'Advanced JavaScript',        'lessons' => 8,  'mins' => 80,  'desc' => 'Async/await, Promises, fetch, modules and consuming REST APIs.' ),
	array( 'phase' => 'Frontend', 'topic' => 'Tooling & Version Control',  'lessons' => 6,  'mins' => 55,  'desc' => 'Git & GitHub workflows, npm, bundlers and a professional dev setup.' ),
	array( 'phase' => 'Frontend', 'topic' => 'React Fundamentals',         'lessons' => 10, 'mins' => 95,  'desc' => 'Components, props, state and hooks — building reusable interfaces.' ),
	array( 'phase' => 'Frontend', 'topic' => 'Advanced React',             'lessons' => 9,  'mins' => 85,  'desc' => 'Routing, Context, state management and performance patterns.' ),
	array( 'phase' => 'Backend',  'topic' => 'Node.js & Express',          'lessons' => 8,  'mins' => 80,  'desc' => 'Server-side JavaScript, building and structuring RESTful APIs.' ),
	array( 'phase' => 'Backend',  'topic' => 'Databases',                  'lessons' => 7,  'mins' => 70,  'desc' => 'SQL & MongoDB, schema/data modelling and CRUD at scale.' ),
	array( 'phase' => 'Backend',  'topic' => 'Auth & Security',            'lessons' => 6,  'mins' => 65,  'desc' => 'JWT, sessions, password hashing and OWASP-aware best practices.' ),
	array( 'phase' => 'Backend',  'topic' => 'Fullstack Integration',      'lessons' => 9,  'mins' => 100, 'desc' => 'Wiring a MERN app end-to-end — frontend, API and database.' ),
	array( 'phase' => 'Backend',  'topic' => 'DevOps & Deployment',        'lessons' => 7,  'mins' => 75,  'desc' => 'Docker basics, CI/CD pipelines and shipping to the cloud.' ),
	array( 'phase' => 'Career',   'topic' => 'Capstone Project',           'lessons' => 5,  'mins' => 120, 'desc' => 'Design, build and deploy a portfolio-grade fullstack application.' ),
	array( 'phase' => 'Career',   'topic' => 'Career & Placement Prep',    'lessons' => 6,  'mins' => 90,  'desc' => 'DSA refresh, resume, GitHub polish, mock interviews & placement drive.' ),
);

// Totals for the "Course content" summary line.
$tc_total_lessons = array_sum( wp_list_pluck( $tc_weeks, 'lessons' ) );
$tc_total_mins    = array_sum( wp_list_pluck( $tc_weeks, 'mins' ) );

// Helper: minutes -> "Xh Ym" / "Ym".
if ( ! function_exists( 'tc_fmt_len' ) ) {
	function tc_fmt_len( $mins ) {
		$h = intdiv( (int) $mins, 60 );
		$m = (int) $mins % 60;
		if ( $h && $m ) { return $h . 'h ' . $m . 'm'; }
		if ( $h )       { return $h . 'h'; }
		return $m . 'm';
	}
}
?>

<div id="primary" class="content-area page-content-area tc-page pt-120 pb-120">
    <div class="container">

        <div class="row tc-program-body">

            <!-- RIGHT on desktop / TOP on mobile: sticky enrolment card (starts at hero top) -->
            <div class="col-lg-4 order-lg-2">
                <aside class="tc-enrol-card">
                    <div class="tc-enrol-card__preview">
                        <!-- CLAUDE CODE: swap href for the real preview video / thumbnail image. -->
                        <a href="#program-preview" class="tc-enrol-card__play" aria-label="Preview the program">
                            <span class="tc-enrol-card__play-icon">▶</span>
                        </a>
                        <span class="tc-enrol-card__preview-label">Preview the program</span>
                    </div>
                    <div class="tc-enrol-card__body">
                        <!-- CLAUDE CODE: pricing is a PLACEHOLDER — final numbers live on Fees & Batches. -->
                        <div class="tc-enrol-card__price">
                            <span class="tc-enrol-card__price-now">EMI from ₹ —/mo*</span>
                            <span class="tc-enrol-card__price-was">₹ — one-time</span>
                        </div>
                        <p class="tc-enrol-card__price-note">*Indicative. See Fees &amp; Batches for final
                            pricing, inclusive of 18% GST.</p>

                        <a class="tc-btn tc-btn--primary tc-btn--block" href="/admissions-apply/">Apply Now</a>
                        <a class="tc-btn tc-btn--ghost tc-btn--block" href="/fees-batches/">View Fees &amp; EMI</a>

                        <ul class="tc-enrol-card__features">
                            <li>14 weeks · online / hybrid cohort</li>
                            <li>Live mentorship &amp; code reviews</li>
                            <li>Capstone project + portfolio</li>
                            <li>Placement &amp; TPO support</li>
                            <li>Certificate on completion</li>
                        </ul>
                    </div>
                </aside>
            </div>

            <!-- LEFT: hero text + the long content the card sticks alongside -->
            <div class="col-lg-8 order-lg-1">

                <!-- Hero head -->
                <section class="tc-hero">
                    <nav class="tc-hero__crumbs" aria-label="Breadcrumb">
                        <a href="/">Home</a><span>›</span>
                        <a href="/program-curriculum/">Programs</a><span>›</span>
                        <span class="tc-hero__crumbs-current">Fullstack Developer</span>
                    </nav>

                    <h1 class="tc-hero__title">Visioner Fullstack Developer Bootcamp</h1>
                    <p class="tc-hero__sub">Master modern fullstack development by building real projects
                        in 14 weeks. Go from fundamentals to a deployed MERN app — and become job-ready.</p>

                    <span class="tc-badge tc-badge--bestseller">Most Popular Track</span>

                    <p class="tc-hero__author">Mentored by
                        <a href="/admissions-apply/">Visioner industry mentors &amp; lead instructors</a>
                    </p>

                    <div class="tc-hero__meta">
                        <span class="tc-hero__meta-item">🗓 Curriculum updated <strong>2026</strong></span>
                        <span class="tc-hero__meta-item">🌐 English &amp; Hindi</span>
                        <span class="tc-hero__meta-item">🎓 Certificate on completion</span>
                    </div>

                    <!-- CLAUDE CODE: rating + learner numbers are PLACEHOLDERS — swap for real figures. -->
                    <div class="tc-hero__stats">
                        <div class="tc-stat">
                            <strong class="tc-stat__num">4.8*</strong>
                            <span class="tc-stars" aria-hidden="true">★★★★★</span>
                            <span class="tc-stat__label">2,400+ ratings*</span>
                        </div>
                        <div class="tc-stat tc-stat--divider">
                            <strong class="tc-stat__num">12,000+*</strong>
                            <span class="tc-stat__label">learners trained</span>
                        </div>
                        <div class="tc-stat tc-stat--divider">
                            <strong class="tc-stat__num">14</strong>
                            <span class="tc-stat__label">weeks · project-first</span>
                        </div>
                    </div>
                </section>

                <!-- What you'll master -->
                <section class="tc-section tc-program-intro">
                    <span class="tc-eyebrow">The Programme</span>
                    <h2 class="tc-section__title">What you'll master</h2>
                    <p class="tc-lead">Visioner's Fullstack Developer track turns absolute beginners and
                        career-switchers into job-ready engineers in 14 focused weeks — no fluff, all build.</p>
                    <p class="tc-muted">You'll progress from web fundamentals to a production-grade MERN
                        stack, writing real code from day one. Every module is project-first: you ship
                        working features, review them with industry mentors, and push them to your GitHub.
                        By graduation you'll have a deployed capstone app, a polished portfolio and
                        interview-ready DSA — backed by our placement &amp; TPO network.</p>

                    <div class="tc-factstrip">
                        <div class="tc-fact"><strong>14 weeks</strong><span>Structured ladder</span></div>
                        <div class="tc-fact"><strong>Online / Hybrid</strong><span>Flexible cohorts</span></div>
                        <div class="tc-fact"><strong>Beginner → Pro</strong><span>No prior code needed</span></div>
                        <div class="tc-fact"><strong>Job-ready</strong><span>Portfolio + placement</span></div>
                    </div>
                </section>

                <!-- Phase legend -->
                <section class="tc-section tc-phases">
                    <div class="tc-phase-legend">
                        <span class="tc-phase-tag tc-phase-tag--frontend">Frontend &middot; Weeks 1–7</span>
                        <span class="tc-phase-tag tc-phase-tag--backend">Backend &amp; Fullstack &middot; Weeks 8–12</span>
                        <span class="tc-phase-tag tc-phase-tag--career">Capstone &amp; Career &middot; Weeks 13–14</span>
                    </div>
                </section>

                <!-- Course content (Udemy-style accordion) -->
                <section class="tc-section tc-curriculum">
                    <div class="tc-acc__head">
                        <h2 class="tc-section__title tc-section__title--flush">Course content</h2>
                        <button type="button" class="tc-acc__toggle-all" data-tc-expand-all>Collapse all sections</button>
                    </div>
                    <p class="tc-acc__summary">
                        <?php echo count( $tc_weeks ); ?> sections &middot;
                        <?php echo (int) $tc_total_lessons; ?> lessons &middot;
                        <?php echo esc_html( tc_fmt_len( $tc_total_mins ) ); ?> total length<span class="tc-acc__summary-note"> (indicative*)</span>
                    </p>

                    <div class="tc-acc">
                        <?php foreach ( $tc_weeks as $i => $w ) :
                            $num   = $i + 1;
                            $phase = strtolower( $w['phase'] );
                        ?>
                        <details class="tc-acc__item tc-acc__item--<?php echo esc_attr( $phase ); ?>" open>
                            <summary class="tc-acc__summary-row">
                                <span class="tc-acc__chevron" aria-hidden="true">⌄</span>
                                <span class="tc-acc__title">
                                    <span class="tc-acc__day">Week <?php echo esc_html( $num ); ?> &middot; <?php echo esc_html( $w['phase'] ); ?></span>
                                    <span class="tc-acc__topic"><?php echo esc_html( $w['topic'] ); ?></span>
                                </span>
                                <span class="tc-acc__meta">
                                    <?php echo (int) $w['lessons']; ?> lessons &middot; <?php echo esc_html( tc_fmt_len( $w['mins'] ) ); ?>
                                </span>
                            </summary>
                            <div class="tc-acc__body">
                                <p class="tc-muted"><?php echo esc_html( $w['desc'] ); ?></p>
                                <!-- CLAUDE CODE: generic lesson rows — swap for the real lecture titles per week. -->
                                <ul class="tc-acc__lessons">
                                    <li><span class="tc-acc__lesson-ic">▶</span> Concept walkthrough &amp; live demo</li>
                                    <li><span class="tc-acc__lesson-ic">▶</span> Guided hands-on coding</li>
                                    <li><span class="tc-acc__lesson-ic">▶</span> Practice exercise / mini-project</li>
                                </ul>
                            </div>
                        </details>
                        <?php endforeach; ?>
                    </div>
                </section>

            </div>
        </div>

        <!-- CTA (full width) -->
        <section class="tc-section tc-cta-band text-center">
            <h2>Ready to become a fullstack developer?</h2>
            <p class="tc-cta-band__sub">Seats are limited each cohort. Apply now and our team will confirm
                your batch over email &amp; WhatsApp.</p>
            <div class="tc-cta-band__actions">
                <a class="tc-btn tc-btn--primary" href="/admissions-apply/">Apply Now</a>
                <a class="tc-btn tc-btn--ghost" href="/fees-batches/">View Fees &amp; Batches</a>
            </div>
        </section>

    </div>
</div>

<?php get_footer();
