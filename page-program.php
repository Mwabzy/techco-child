<?php
/**
 * Template Name: Visioner — Program / Curriculum
 *
 * 14-week fullstack curriculum ladder.
 * @package Techco Child
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();
require_once get_stylesheet_directory() . '/inc/page-banner.php';
techco_child_page_banner( 'Program & Curriculum', 'Fullstack Developer Training — 14-week structured ladder' );

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

        <!-- SECTION: Program overview -->
        <section class="tc-section tc-program-intro">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <span class="tc-eyebrow">The Programme</span>
                    <h2 class="tc-section__title">What you'll master</h2>
                    <p class="tc-lead">Visioner's Fullstack Developer track turns absolute beginners and
                        career-switchers into job-ready engineers in 14 focused weeks — no fluff, all build.</p>
                    <p class="tc-muted">You'll progress from web fundamentals to a production-grade MERN
                        stack, writing real code from day one. Every module is project-first: you ship
                        working features, review them with industry mentors, and push them to your GitHub.</p>
                    <p class="tc-muted">By graduation you'll have a deployed capstone app, a polished
                        portfolio and interview-ready DSA — backed by our placement &amp; TPO network.</p>
                </div>
                <div class="col-lg-5">
                    <div class="tc-quickfacts-card">
                        <h3 class="tc-quickfacts-card__title">Quick Facts</h3>
                        <ul class="tc-quickfacts">
                            <li><span>Duration</span><strong>14 weeks</strong></li>
                            <li><span>Mode</span><strong>Online / Hybrid</strong></li>
                            <li><span>Batch size</span><strong>Limited cohort*</strong></li>
                            <li><span>Level</span><strong>Beginner → Job-ready</strong></li>
                            <li><span>Outcome</span><strong>Fullstack portfolio + placement support</strong></li>
                        </ul>
                        <p class="tc-quickfacts-card__note">*Placeholder — confirm exact batch size from the deck.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION: Phase legend -->
        <section class="tc-section tc-phases">
            <div class="tc-phase-legend">
                <span class="tc-phase-tag tc-phase-tag--frontend">Frontend &middot; Weeks 1–7</span>
                <span class="tc-phase-tag tc-phase-tag--backend">Backend &amp; Fullstack &middot; Weeks 8–12</span>
                <span class="tc-phase-tag tc-phase-tag--career">Capstone &amp; Career &middot; Weeks 13–14</span>
            </div>
        </section>

        <!-- SECTION: Curriculum ladder (week-by-week) -->
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
