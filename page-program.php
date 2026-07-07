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
$tc_modules = tc_program_modules();

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

        <!-- Full-width course banner (hero) -->
        <nav class="tc-hero__crumbs tc-coursebanner__crumbs" aria-label="Breadcrumb">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a><span>›</span>
            <a href="<?php echo esc_url( tc_tpl_url( 'page-program.php', '/program-curriculum/' ) ); ?>">Programs</a><span>›</span>
            <span class="tc-hero__crumbs-current">Full-Stack Developer</span>
        </nav>

        <section class="tc-coursebanner tc-reveal">
            <span class="tc-coursebanner__bg" data-parallax="10" aria-hidden="true"></span>
            <div class="tc-coursebanner__inner">

                <div class="tc-coursebanner__content" data-motion-in>
                    <h1 class="tc-coursebanner__title">The Full-Stack Development Masterclass</h1>
                    <p class="tc-coursebanner__kicker">Live classroom program</p>
                    <div class="tc-coursebanner__rating">
                        <strong class="tc-stat__num" data-animate>4.8</strong>
                        <span class="tc-coursebanner__stars" aria-hidden="true">★★★★★</span>
                        <!-- CLAUDE CODE: rating + review count are PLACEHOLDERS — swap for real figures. -->
                        <span class="tc-coursebanner__reviews">1,200+ learner reviews</span>
                    </div>
                    <p class="tc-coursebanner__desc">Become a job-ready full-stack developer in 14 weeks — from Angular 18
                        and .NET 8 through SQL Server to Cloud, GenAI and Agentic AI. Learn by building real projects,
                        reviewed by working mentors.</p>

                    <div class="tc-coursebanner__skills">
                        <?php foreach ( array( 'Angular 18', '.NET 8', 'SQL Server', 'Cloud', 'GenAI', 'REST APIs' ) as $skill ) : ?>
                            <span class="tc-coursebanner__skill"><?php echo esc_html( $skill ); ?></span>
                        <?php endforeach; ?>
                        <span class="tc-coursebanner__skill tc-coursebanner__skill--more">+ Agentic AI &amp; more</span>
                    </div>

                    <div class="tc-coursebanner__actions">
                        <a class="tc-btn tc-btn--light" data-magnetic
                            href="<?php echo esc_url( tc_tpl_url( 'page-apply.php', '/admissions-apply/' ) ); ?>">Enroll this course</a>
                    </div>
                </div>

                <?php $tc_hero_illo = function_exists( 'tc_opt_image' ) ? tc_opt_image( 'tc_program_hero_img' ) : ''; ?>
                <div class="tc-coursebanner__art" aria-hidden="true">
                    <?php if ( $tc_hero_illo ) : ?>
                        <img class="tc-coursebanner__art-img" src="<?php echo esc_url( $tc_hero_illo ); ?>" alt="" loading="lazy" decoding="async">
                    <?php else : ?>
                        <!-- CLAUDE CODE: built-in placeholder illustration. Upload one at
                             Appearance → Customize → VisionONE Content → "Program hero — illustration". -->
                        <div class="tc-illo">
                            <div class="tc-illo__glow"></div>
                            <div class="tc-illo__panel">
                                <span class="tc-illo__dots"><i></i><i></i><i></i></span>
                                <span class="tc-illo__code"><b style="width:70%"></b><b style="width:45%"></b><b style="width:85%"></b><b style="width:55%"></b><b style="width:35%"></b></span>
                            </div>
                            <div class="tc-illo__card tc-illo__card--react"><?php echo tc_brand_icon( 'react', 34 ); ?></div>
                            <div class="tc-illo__card tc-illo__card--review">
                                <span class="tc-illo__avatar"></span>
                                <span class="tc-illo__stars">★★★★★</span>
                            </div>
                            <span class="tc-illo__chip tc-illo__chip--code">&lt;/&gt;</span>
                            <span class="tc-illo__chip tc-illo__chip--brace">{ }</span>
                            <span class="tc-illo__chip tc-illo__chip--db"><?php echo tc_brand_icon( 'mongodb', 22 ); ?></span>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </section>

        <!-- Quick-facts strip -->
        <div class="tc-coursefeatures" data-motion-in>
            <div class="tc-coursefeature">
                <span class="tc-coursefeature__ic tc-coursefeature__ic--blue"><?php echo tc_icon( 'sliders', 20 ); ?></span>
                <div class="tc-coursefeature__meta"><strong>Learn by Doing</strong><span>Hands-on lessons built around real app projects.</span></div>
            </div>
            <div class="tc-coursefeature">
                <span class="tc-coursefeature__ic tc-coursefeature__ic--violet"><?php echo tc_icon( 'chart', 20 ); ?></span>
                <div class="tc-coursefeature__meta"><strong>End-to-End Curriculum</strong><span>Angular 18, .NET 8, SQL, Cloud &amp; GenAI.</span></div>
            </div>
            <div class="tc-coursefeature">
                <span class="tc-coursefeature__ic tc-coursefeature__ic--amber"><?php echo tc_icon( 'globe', 20 ); ?></span>
                <div class="tc-coursefeature__meta"><strong>Language</strong><span>English &amp; Hindi, taught in class.</span></div>
            </div>
            <div class="tc-coursefeature">
                <span class="tc-coursefeature__ic tc-coursefeature__ic--green"><?php echo tc_icon( 'calendar', 20 ); ?></span>
                <div class="tc-coursefeature__meta"><strong>Time to complete</strong><span>10–14 weeks with mentor-guided practice.</span></div>
            </div>
        </div>

        <div class="row tc-program-body">
            <!-- Single, centred reading column (sticky enrol card removed —
                 its context now lives in the course banner + facts strip above). -->
            <div class="col-12 tc-program-content">

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

                <!-- "Choose your track" section removed. -->

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
                        <details id="tc-module-<?php echo (int) $i; ?>" class="tc-acc__item tc-acc__item--<?php echo esc_attr( $phase ); ?> tc-reveal" style="--delay: <?php echo ( $i % 4 ) * 70; ?>ms" open>
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
            <!-- CLAUDE CODE: pricing is a PLACEHOLDER — final numbers live on Fees & Batches. -->
            <p class="tc-cta-band__price">From <strong>₹49,999 + GST</strong> · No-Cost EMI available</p>
            <div class="tc-cta-band__actions">
                <a class="tc-btn tc-btn--primary" href="<?php echo esc_url( tc_tpl_url( 'page-apply.php', '/admissions-apply/' ) ); ?>">Apply Now</a>
                <a class="tc-btn tc-btn--ghost" href="<?php echo esc_url( tc_tpl_url( 'page-fees.php', '/fees-batches/' ) ); ?>">View Fees &amp; Batches</a>
            </div>
        </section>

    </div>
</div>

<?php get_footer();
