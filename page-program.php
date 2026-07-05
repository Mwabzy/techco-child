<?php
/**
 * Template Name: visionONE — Program / Curriculum
 *
 * 14-week full-stack curriculum (Angular + .NET + SQL + Cloud + AI), with a
 * Udemy-style course hero + sticky enrol card and a collapsible "Course
 * content" accordion.
 * NOTE: this template intentionally omits techco_child_page_banner() — the
 * .tc-hero below provides its own breadcrumb + title so a banner would duplicate it.
 * @package Techco Child
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();

/**
 * Curriculum modules — from the Visioner deck (14-Week Curriculum Ladder).
 * 'phase' drives the accent colour (core / cloud / ai). 'lessons'/'mins' are
 * indicative placeholders (the deck lists modules + milestones, not lecture
 * counts) feeding the accordion meta + totals — swap when finalised.
 */
$tc_modules = array(
	array( 'phase' => 'Core',  'weeks' => 'Weeks 1–2',   'topic' => 'Frontend — Angular 18',        'milestone' => 'Responsive UI', 'lessons' => 12, 'mins' => 600, 'desc' => 'TypeScript, RxJS, components, routing and responsive, mobile-first UI.' ),
	array( 'phase' => 'Core',  'weeks' => 'Weeks 3–4',   'topic' => 'Backend — .NET 8 Web API',      'milestone' => 'REST API',      'lessons' => 11, 'mins' => 560, 'desc' => 'C#, Entity Framework Core and building structured RESTful services.' ),
	array( 'phase' => 'Core',  'weeks' => 'Weeks 5–6',   'topic' => 'SQL Server',                    'milestone' => 'Data layer',    'lessons' => 9,  'mins' => 470, 'desc' => 'Schema design, queries, stored procedures and data integration.' ),
	array( 'phase' => 'Core',  'weeks' => 'Weeks 7–8',   'topic' => 'Auth, Security & Mini-ERP',     'milestone' => 'Working app',   'lessons' => 10, 'mins' => 520, 'desc' => 'Authentication, security and a full-stack Mini-ERP (Angular + .NET + SQL).' ),
	array( 'phase' => 'Core',  'weeks' => 'Weeks 9–10',  'topic' => 'Capstone + Git/DevOps',         'milestone' => 'Capstone',      'lessons' => 8,  'mins' => 480, 'desc' => 'Build & ship a capstone with Git and DevOps fundamentals. Core Program ends here (10 weeks).' ),
	array( 'phase' => 'Cloud', 'weeks' => 'Weeks 11–12', 'topic' => 'Cloud — AWS & Azure',           'milestone' => 'Live on cloud', 'lessons' => 8,  'mins' => 430, 'desc' => 'Cloud fundamentals, CI/CD and deploying your capstone live (12 weeks).' ),
	array( 'phase' => 'AI',    'weeks' => 'Week 13',     'topic' => 'GenAI',                         'milestone' => 'AI feature',    'lessons' => 5,  'mins' => 300, 'desc' => 'LLM APIs, prompt engineering and building real AI features (13 weeks).' ),
	array( 'phase' => 'AI',    'weeks' => 'Week 14',     'topic' => 'Agentic AI',                    'milestone' => 'AI agent',      'lessons' => 5,  'mins' => 300, 'desc' => 'Agents, tools and autonomous automation workflows. Complete Bundle ends here (14 weeks).' ),
);

// Program tracks (exit points) — from the deck's "Program Options".
$tc_tracks = array(
	array( 'name' => 'Core Program',               'weeks' => '10 weeks', 'desc' => 'Angular 18, .NET 8 Web API, C#, SQL Server, auth & REST — Mini-ERP build + capstone.', 'flag' => false ),
	array( 'name' => 'Core + Cloud',               'weeks' => '12 weeks', 'desc' => 'Everything in Core, plus AWS + Azure fundamentals, CI/CD and cloud deployment.',        'flag' => false ),
	array( 'name' => 'Core + GenAI & Agentic AI',  'weeks' => '13 weeks', 'desc' => 'Core plus LLM APIs, prompt engineering, AI features and agentic workflows.',            'flag' => false ),
	array( 'name' => 'Complete Bundle',            'weeks' => '14 weeks', 'desc' => 'Full stack + Cloud + GenAI + Agentic AI in one career track — our flagship.',            'flag' => true ),
);

// Totals for the "Course content" summary line.
$tc_total_lessons = array_sum( wp_list_pluck( $tc_modules, 'lessons' ) );
$tc_total_mins    = array_sum( wp_list_pluck( $tc_modules, 'mins' ) );

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
                <aside class="tc-enrol-card tc-reveal">
                    <div class="tc-enrol-card__preview">
                        <!-- CLAUDE CODE: swap href for the real preview video / thumbnail image. -->
                        <a href="#program-preview" class="tc-enrol-card__play" aria-label="Preview the program">
                            <?php echo tc_icon( 'play', 24 ); ?>
                        </a>
                        <span class="tc-enrol-card__preview-label">Preview the program</span>
                    </div>
                    <div class="tc-enrol-card__body">
                        <!-- CLAUDE CODE: pricing is a PLACEHOLDER — final numbers live on Fees & Batches. -->
                        <div class="tc-enrol-card__price">
                            <span class="tc-enrol-card__price-now">From ₹49,999 + GST</span>
                        </div>
                        <p class="tc-enrol-card__price-note">Core Program. Fees shown as Fees + GST (GST billed
                            on the invoice). See Fees &amp; Batches for all tracks &amp; EMI.</p>

                        <a class="tc-btn tc-btn--primary tc-btn--block" href="<?php echo esc_url( tc_tpl_url( 'page-apply.php', '/admissions-apply/' ) ); ?>">Apply Now</a>
                        <a class="tc-btn tc-btn--ghost tc-btn--block" href="<?php echo esc_url( tc_tpl_url( 'page-fees.php', '/fees-batches/' ) ); ?>">View Fees &amp; EMI</a>

                        <ul class="tc-enrol-card__features">
                            <li>10–14 weeks · classroom / online</li>
                            <li>Angular 18 · .NET 8 · SQL Server</li>
                            <li>Cloud, GenAI &amp; Agentic AI tracks</li>
                            <li>Capstone project + portfolio</li>
                            <li>Placement &amp; TPO support</li>
                        </ul>
                    </div>
                </aside>
            </div>

            <!-- LEFT: hero text + the long content the card sticks alongside -->
            <div class="col-lg-8 order-lg-1">

                <!-- Hero head -->
                <section class="tc-hero tc-texture-dots tc-reveal">
                    <!-- Ambient glow orbs -->
                    <div class="tc-glow-orb tc-glow-orb--blue" aria-hidden="true"></div>
                    <div class="tc-glow-orb tc-glow-orb--orange" aria-hidden="true"></div>

                    <nav class="tc-hero__crumbs" aria-label="Breadcrumb">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a><span>›</span>
                        <a href="<?php echo esc_url( tc_tpl_url( 'page-program.php', '/program-curriculum/' ) ); ?>">Programs</a><span>›</span>
                        <span class="tc-hero__crumbs-current">Full-Stack Developer</span>
                    </nav>

                    <h1 class="tc-hero__title"><span class="tc-gradient-text tc-gradient-text--freeze">Full-Stack Development</span> Training Program</h1>
                    <p class="tc-hero__sub">Become a job-ready full-stack developer in 14 weeks — Angular 18
                        and .NET 8 through SQL Server, Cloud, GenAI and Agentic AI, built around real projects.</p>

                    <span class="tc-badge tc-badge--bestseller">Flagship Track</span>

                    <p class="tc-hero__author">Mentored by
                        <a href="<?php echo esc_url( tc_tpl_url( 'page-apply.php', '/admissions-apply/' ) ); ?>">visionONE industry mentors &amp; lead instructors</a>
                    </p>

                    <div class="tc-hero__meta">
                        <span class="tc-hero__meta-item"><?php echo tc_icon( 'calendar', 16 ); ?> Updated for <strong>2026</strong></span>
                        <span class="tc-hero__meta-item"><?php echo tc_icon( 'globe', 16 ); ?> Classroom (Hyderabad) &amp; online</span>
                        <span class="tc-hero__meta-item"><?php echo tc_icon( 'award', 16 ); ?> Certificate on completion</span>
                    </div>

                    <!-- CLAUDE CODE: rating + learner numbers are PLACEHOLDERS — swap for real figures. -->
                    <div class="tc-hero__stats">
                        <div class="tc-stat">
                            <strong class="tc-stat__num" data-animate>4.8</strong>
                            <span class="tc-stars" aria-hidden="true">★★★★★</span>
                            <span class="tc-stat__label">learner rating</span>
                        </div>
                        <div class="tc-stat tc-stat--divider">
                            <strong class="tc-stat__num" data-animate>Angular + .NET</strong>
                            <span class="tc-stat__label">+ Cloud &amp; AI</span>
                        </div>
                        <div class="tc-stat tc-stat--divider">
                            <strong class="tc-stat__num" data-animate>14</strong>
                            <span class="tc-stat__label">weeks · project-first</span>
                        </div>
                    </div>
                </section>

                <!-- What you'll master -->
                <section class="tc-section tc-program-intro tc-reveal">
                    <span class="tc-eyebrow">The Programme</span>
                    <h2 class="tc-section__title">What you'll master</h2>
                    <p class="tc-lead">visionONE's Full-Stack track turns beginners and career-switchers into
                        job-ready engineers in 10–14 weeks — no fluff, all build.</p>
                    <p class="tc-muted">You'll progress from an Angular 18 frontend to a .NET 8 + SQL Server
                        backend, ship a full-stack Mini-ERP and a portfolio capstone, then go further than
                        any other Hyderabad bootcamp with Cloud (AWS &amp; Azure), GenAI and Agentic AI.
                        Every module is project-first, reviewed by working mentors and backed by our
                        placement &amp; TPO network.</p>

                    <div class="tc-statband">
                        <div class="tc-statband__item tc-reveal" style="--delay: 0ms">
                            <span class="tc-statband__num">Angular + .NET</span><span class="tc-statband__label">Modern full stack</span>
                        </div>
                        <div class="tc-statband__item tc-reveal" style="--delay: 80ms">
                            <span class="tc-statband__num">Cloud &amp; AI</span><span class="tc-statband__label">AWS/Azure · GenAI</span>
                        </div>
                        <div class="tc-statband__item tc-reveal" style="--delay: 160ms">
                            <span class="tc-statband__num">Beginner → Pro</span><span class="tc-statband__label">No prior code needed</span>
                        </div>
                        <div class="tc-statband__item tc-reveal" style="--delay: 240ms">
                            <span class="tc-statband__num">Job-ready</span><span class="tc-statband__label">Portfolio + placement</span>
                        </div>
                    </div>
                </section>

                <!-- Program tracks (exit points) -->
                <section class="tc-section tc-tracks tc-reveal">
                    <h2 class="tc-section__title">Choose your track</h2>
                    <p class="tc-muted tc-tracks__lead">Core is the 10-week spine — bolt on Cloud and AI, or
                        take the Complete Bundle. You can exit at any milestone.</p>
                    <div class="tc-bento">
                        <?php foreach ( $tc_tracks as $i => $t ) : ?>
                        <div class="tc-feature tc-reveal<?php echo $t['flag'] ? ' tc-feature--flag tc-bento__cell--lead' : ''; ?>" style="--delay: <?php echo $i * 80; ?>ms">
                            <?php if ( $t['flag'] ) : ?><span class="tc-feature__flag">Flagship</span><?php endif; ?>
                            <span class="tc-track__weeks"><?php echo esc_html( $t['weeks'] ); ?></span>
                            <h3><?php echo esc_html( $t['name'] ); ?></h3>
                            <p class="tc-muted"><?php echo esc_html( $t['desc'] ); ?></p>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </section>

                <!-- Phase legend -->
                <section class="tc-section tc-phases tc-reveal">
                    <div class="tc-phase-legend">
                        <span class="tc-phase-tag tc-phase-tag--frontend">Core &middot; Weeks 1–10</span>
                        <span class="tc-phase-tag tc-phase-tag--backend">Cloud &middot; Weeks 11–12</span>
                        <span class="tc-phase-tag tc-phase-tag--career">GenAI &amp; Agentic AI &middot; Weeks 13–14</span>
                    </div>
                </section>

                <!-- Course content (Udemy-style accordion) -->
                <section class="tc-section tc-curriculum tc-reveal">
                    <div class="tc-acc__head">
                        <h2 class="tc-section__title tc-section__title--flush">Course content</h2>
                        <button type="button" class="tc-acc__toggle-all" data-tc-expand-all>Collapse all sections</button>
                    </div>
                    <p class="tc-acc__summary">
                        <?php echo count( $tc_modules ); ?> modules &middot;
                        <?php echo (int) $tc_total_lessons; ?> lessons &middot;
                        <?php echo esc_html( tc_fmt_len( $tc_total_mins ) ); ?> total length<span class="tc-acc__summary-note"> (indicative)</span>
                    </p>

                    <div class="tc-acc">
                        <?php foreach ( $tc_modules as $i => $m ) :
                            $phase = strtolower( $m['phase'] );
                        ?>
                        <details class="tc-acc__item tc-acc__item--<?php echo esc_attr( $phase ); ?> tc-reveal" style="--delay: <?php echo ( $i % 4 ) * 70; ?>ms" open>
                            <summary class="tc-acc__summary-row">
                                <span class="tc-acc__chevron" aria-hidden="true"><?php echo tc_icon( 'chevron-down', 20 ); ?></span>
                                <span class="tc-acc__title">
                                    <span class="tc-acc__day"><?php echo esc_html( $m['weeks'] ); ?> &middot; <?php echo esc_html( $m['phase'] ); ?></span>
                                    <span class="tc-acc__topic"><?php echo esc_html( $m['topic'] ); ?></span>
                                </span>
                                <span class="tc-acc__meta">
                                    <?php echo (int) $m['lessons']; ?> lessons &middot; <?php echo esc_html( tc_fmt_len( $m['mins'] ) ); ?>
                                </span>
                            </summary>
                            <div class="tc-acc__body">
                                <p class="tc-muted"><?php echo esc_html( $m['desc'] ); ?></p>
                                <p class="tc-acc__milestone"><strong>Milestone:</strong> <?php echo esc_html( $m['milestone'] ); ?></p>
                            </div>
                        </details>
                        <?php endforeach; ?>
                    </div>
                </section>

            </div>
        </div>

        <!-- CTA (full width) -->
        <section class="tc-section tc-cta-band text-center tc-reveal">
            <!-- Ambient glow orbs -->
            <div class="tc-glow-orb tc-glow-orb--blue" aria-hidden="true"></div>
            <div class="tc-glow-orb tc-glow-orb--orange" aria-hidden="true"></div>

            <h2>Ready to become a full-stack developer?</h2>
            <p class="tc-cta-band__sub">Seats are limited each cohort. Apply now and our team will confirm
                your batch over email &amp; WhatsApp.</p>
            <div class="tc-cta-band__actions">
                <a class="tc-btn tc-btn--primary" href="<?php echo esc_url( tc_tpl_url( 'page-apply.php', '/admissions-apply/' ) ); ?>">Apply Now</a>
                <a class="tc-btn tc-btn--ghost" href="<?php echo esc_url( tc_tpl_url( 'page-fees.php', '/fees-batches/' ) ); ?>">View Fees &amp; Batches</a>
            </div>
        </section>

    </div>
</div>

<?php get_footer();
