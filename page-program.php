<?php
/**
 * Template Name: Visioner — Program / Curriculum
 *
 * 14-week fullstack curriculum ladder, with a Udemy-style course hero.
 * NOTE: this template intentionally omits techco_child_page_banner() — the
 * .tc-hero below provides its own breadcrumb + title so a banner would duplicate it.
 * @package Techco Child
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();

/**
 * CLAUDE CODE: Placeholder curriculum — realistic fullstack ladder, swap the
 * exact topics/blurbs for the final deck wording. Each row = one week card.
 * 'phase' drives the accent colour (frontend / backend / career).
 */
$tc_weeks = array(
	array( 'phase' => 'Frontend', 'topic' => 'Web Foundations',            'desc' => 'HTML5 semantics, CSS3, the box model and responsive, mobile-first layouts.' ),
	array( 'phase' => 'Frontend', 'topic' => 'Modern CSS & UI',            'desc' => 'Flexbox, CSS Grid, Bootstrap utilities, components and accessible design.' ),
	array( 'phase' => 'Frontend', 'topic' => 'JavaScript Fundamentals',    'desc' => 'ES6+ syntax, the DOM, events, and interactive UI from scratch.' ),
	array( 'phase' => 'Frontend', 'topic' => 'Advanced JavaScript',        'desc' => 'Async/await, Promises, fetch, modules and consuming REST APIs.' ),
	array( 'phase' => 'Frontend', 'topic' => 'Tooling & Version Control',  'desc' => 'Git & GitHub workflows, npm, bundlers and a professional dev setup.' ),
	array( 'phase' => 'Frontend', 'topic' => 'React Fundamentals',         'desc' => 'Components, props, state and hooks — building reusable interfaces.' ),
	array( 'phase' => 'Frontend', 'topic' => 'Advanced React',             'desc' => 'Routing, Context, state management and performance patterns.' ),
	array( 'phase' => 'Backend',  'topic' => 'Node.js & Express',          'desc' => 'Server-side JavaScript, building and structuring RESTful APIs.' ),
	array( 'phase' => 'Backend',  'topic' => 'Databases',                  'desc' => 'SQL & MongoDB, schema/data modelling and CRUD at scale.' ),
	array( 'phase' => 'Backend',  'topic' => 'Auth & Security',            'desc' => 'JWT, sessions, password hashing and OWASP-aware best practices.' ),
	array( 'phase' => 'Backend',  'topic' => 'Fullstack Integration',      'desc' => 'Wiring a MERN app end-to-end — frontend, API and database.' ),
	array( 'phase' => 'Backend',  'topic' => 'DevOps & Deployment',        'desc' => 'Docker basics, CI/CD pipelines and shipping to the cloud.' ),
	array( 'phase' => 'Career',   'topic' => 'Capstone Project',           'desc' => 'Design, build and deploy a portfolio-grade fullstack application.' ),
	array( 'phase' => 'Career',   'topic' => 'Career & Placement Prep',    'desc' => 'DSA refresh, resume, GitHub polish, mock interviews & placement drive.' ),
);
?>

<div id="primary" class="content-area page-content-area tc-page pt-120 pb-120">
    <div class="container">

        <!-- SECTION: Course-style hero head (full width) -->
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

        <!-- SECTION: Body — content rail (left) + sticky enrolment card (right) -->
        <div class="row tc-program-body">

            <!-- RIGHT on desktop / TOP on mobile: sticky enrolment card -->
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

            <!-- LEFT on desktop: long content the card sticks alongside -->
            <div class="col-lg-8 order-lg-1">

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

                <!-- Curriculum ladder (week-by-week) -->
                <section class="tc-section tc-curriculum">
                    <h2 class="tc-section__title">14-Week Curriculum Ladder</h2>
                    <div class="tc-ladder">
                        <?php foreach ( $tc_weeks as $i => $w ) :
                            $num   = $i + 1;
                            $phase = strtolower( $w['phase'] );
                        ?>
                        <article class="tc-ladder__week tc-ladder__week--<?php echo esc_attr( $phase ); ?>">
                            <div class="tc-ladder__head">
                                <span class="tc-ladder__num">Week <?php echo esc_html( $num ); ?></span>
                                <span class="tc-ladder__phase"><?php echo esc_html( $w['phase'] ); ?></span>
                            </div>
                            <h3 class="tc-ladder__topic"><?php echo esc_html( $w['topic'] ); ?></h3>
                            <p class="tc-muted"><?php echo esc_html( $w['desc'] ); ?></p>
                        </article>
                        <?php endforeach; ?>
                    </div>
                </section>

            </div>
        </div>

        <!-- SECTION: CTA -->
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
