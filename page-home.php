<?php
/**
 * Template Name: Visioner — Home / Landing
 *
 * Marketing landing page that ties the Visioner site together. Reuses the
 * shared Visioner components (hero, feature cards, stats, CTA band) plus a few
 * homepage-only sections. Set a Page to this template and mark it as the front
 * page in Settings → Reading.
 * NOTE: omits techco_child_page_banner() — provides its own hero.
 * @package Techco Child
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();

/* CLAUDE CODE: homepage copy blocks — realistic placeholders, easy to swap. */
$tc_why = array(
	array( 'ic' => 'sliders', 'tone' => 'blue',   'title' => 'Project-first learning', 'text' => 'Write real code from day one and ship a feature every week — not just watch lectures.' ),
	array( 'ic' => 'award',   'tone' => 'orange', 'title' => 'Industry mentors',       'text' => 'Live mentorship, code reviews and 1:1 guidance from working engineers.' ),
	array( 'ic' => 'chart',   'tone' => 'blue',   'title' => 'Placement support',      'text' => 'Mock interviews, resume &amp; GitHub polish, and a TPO/placement pipeline.' ),
	array( 'ic' => 'receipt', 'tone' => 'orange', 'title' => 'EMI-friendly fees',      'text' => 'Transparent pricing with No-Cost EMI options on eligible cards.' ),
);

$tc_stack = array( 'HTML & CSS', 'JavaScript', 'React', 'Node.js', 'Express', 'MongoDB', 'SQL', 'Git & GitHub', 'Docker', 'REST APIs', 'Auth & Security', 'Deployment' );

$tc_steps = array(
	array( 'n' => '01', 'title' => 'Apply',        'text' => 'Submit the quick registration form and pick your preferred batch.' ),
	array( 'n' => '02', 'title' => 'Get confirmed', 'text' => 'Our team confirms your seat over email &amp; WhatsApp and shares the joining kit.' ),
	array( 'n' => '03', 'title' => 'Learn & build', 'text' => '14 weeks of live, project-first training with mentors and weekly reviews.' ),
	array( 'n' => '04', 'title' => 'Get placed',    'text' => 'Graduate with a portfolio and step into interviews with placement support.' ),
);

$tc_tests = array(
	array( 'quote' => 'I joined as a complete beginner and finished with a deployed MERN app in my portfolio. The weekly reviews kept me accountable.', 'name' => 'Placeholder Student', 'role' => 'Fullstack Developer' ),
	array( 'quote' => 'The mentors actually review your code. That feedback loop is what got me interview-ready faster than self-study ever did.', 'name' => 'Placeholder Student', 'role' => 'Frontend Engineer' ),
	array( 'quote' => 'EMI made it accessible, and the placement prep was the part I underestimated most. Worth every week.', 'name' => 'Placeholder Student', 'role' => 'MERN Developer' ),
);
?>

<div id="primary" class="content-area page-content-area tc-page tc-home pt-120 pb-120">
    <div class="container">

        <!-- SECTION: Hero -->
        <section class="tc-hero tc-home__hero">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <span class="tc-eyebrow">VisionOne &middot; Fullstack Developer Training</span>
                    <h1 class="tc-hero__title">Become a job-ready fullstack developer in 14 weeks</h1>
                    <p class="tc-hero__sub">Learn modern web development by building real projects, mentored
                        by working engineers — from fundamentals to a deployed MERN app, backed by placement support.</p>

                    <div class="tc-home__hero-actions">
                        <a class="tc-btn tc-btn--primary" href="/admissions-apply/">Apply Now</a>
                        <a class="tc-btn tc-btn--ghost" href="/program-curriculum/">Explore the curriculum</a>
                    </div>

                    <!-- CLAUDE CODE: hero stats are PLACEHOLDERS — swap for real figures. -->
                    <div class="tc-hero__stats">
                        <div class="tc-stat">
                            <strong class="tc-stat__num">4.8*</strong>
                            <span class="tc-stars" aria-hidden="true">★★★★★</span>
                            <span class="tc-stat__label">learner rating*</span>
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
                </div>

                <div class="col-lg-5">
                    <!-- Next-cohort highlight card -->
                    <aside class="tc-home__herocard">
                        <span class="tc-badge tc-badge--bestseller">Admissions open</span>
                        <h3 class="tc-home__herocard-title">Next cohort</h3>
                        <!-- CLAUDE CODE: set the real upcoming batch date. -->
                        <p class="tc-home__herocard-date">Starting <strong>[ next batch date ]</strong></p>
                        <ul class="tc-home__herocard-list">
                            <li><?php echo tc_icon( 'calendar', 18 ); ?> 14 weeks · weekday &amp; weekend tracks</li>
                            <li><?php echo tc_icon( 'globe', 18 ); ?> Online / hybrid · English &amp; Hindi</li>
                            <li><?php echo tc_icon( 'award', 18 ); ?> Certificate + placement support</li>
                            <li><?php echo tc_icon( 'receipt', 18 ); ?> EMI &amp; No-Cost EMI available</li>
                        </ul>
                        <a class="tc-btn tc-btn--accent tc-btn--block" href="/admissions-apply/">Reserve your seat</a>
                        <p class="tc-home__herocard-note">Seats are limited each cohort.</p>
                    </aside>
                </div>
            </div>
        </section>

        <!-- SECTION: Trust strip -->
        <section class="tc-section tc-logos">
            <p class="tc-logos__label">Trusted by students &amp; colleges across India</p>
            <div class="tc-logos__row">
                <!-- CLAUDE CODE: replace with real partner / hiring-company logos. -->
                <span class="tc-logos__chip">Partner College</span>
                <span class="tc-logos__chip">Hiring Partner</span>
                <span class="tc-logos__chip">TPO Cell</span>
                <span class="tc-logos__chip">Startup Partner</span>
                <span class="tc-logos__chip">Tech Company</span>
            </div>
        </section>

        <!-- SECTION: Why VisionOne -->
        <section class="tc-section tc-why">
            <h2 class="tc-section__title">Why VisionOne</h2>
            <div class="row">
                <?php foreach ( $tc_why as $f ) : ?>
                <div class="col-md-6 col-lg-3">
                    <div class="tc-feature">
                        <span class="tc-feature__ic tc-feature__ic--<?php echo esc_attr( $f['tone'] ); ?>"><?php echo tc_icon( $f['ic'], 24 ); ?></span>
                        <h3><?php echo esc_html( $f['title'] ); ?></h3>
                        <p class="tc-muted"><?php echo wp_kses_post( $f['text'] ); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- SECTION: What you'll learn (stack) + curriculum teaser -->
        <section class="tc-section tc-stack-sec">
            <div class="row align-items-center">
                <div class="col-lg-5">
                    <span class="tc-eyebrow">The Stack</span>
                    <h2 class="tc-section__title">Everything you need, end to end</h2>
                    <p class="tc-muted">A structured 14-week ladder takes you from web fundamentals through
                        frontend, backend, databases and deployment — finishing with a portfolio-grade capstone.</p>
                    <a class="tc-btn tc-btn--outline" href="/program-curriculum/">See the full curriculum</a>
                </div>
                <div class="col-lg-7">
                    <div class="tc-stack">
                        <?php foreach ( $tc_stack as $tech ) : ?>
                            <span class="tc-stack__chip"><?php echo esc_html( $tech ); ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION: Outcomes stats band -->
        <section class="tc-section tc-outcomes">
            <div class="tc-factstrip">
                <div class="tc-fact"><strong>14 weeks</strong><span>To job-ready</span></div>
                <div class="tc-fact"><strong>100+ lessons*</strong><span>Live + hands-on</span></div>
                <div class="tc-fact"><strong>1 capstone</strong><span>Deployed &amp; portfolio-ready</span></div>
                <div class="tc-fact"><strong>EMI</strong><span>No-Cost options*</span></div>
            </div>
        </section>

        <!-- SECTION: How it works -->
        <section class="tc-section tc-steps-sec">
            <h2 class="tc-section__title">How it works</h2>
            <div class="row">
                <?php foreach ( $tc_steps as $s ) : ?>
                <div class="col-md-6 col-lg-3">
                    <div class="tc-home__step">
                        <span class="tc-home__step-num"><?php echo esc_html( $s['n'] ); ?></span>
                        <h3 class="tc-home__step-title"><?php echo esc_html( $s['title'] ); ?></h3>
                        <p class="tc-muted"><?php echo wp_kses_post( $s['text'] ); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- SECTION: Pricing teaser -->
        <section class="tc-section tc-priceteaser">
            <div class="tc-priceteaser__panel">
                <div class="tc-priceteaser__text">
                    <span class="tc-eyebrow">Fees &amp; EMI</span>
                    <h2 class="tc-section__title tc-section__title--flush">Transparent pricing, EMI-friendly</h2>
                    <p class="tc-muted">Clear fees inclusive of 18% GST, with No-Cost EMI on eligible cards and
                        secure online payment via Razorpay.</p>
                </div>
                <div class="tc-priceteaser__cta">
                    <a class="tc-btn tc-btn--primary" href="/fees-batches/">View Fees &amp; Batches</a>
                </div>
            </div>
        </section>

        <!-- SECTION: For colleges callout -->
        <section class="tc-section tc-callout">
            <div class="tc-callout__panel">
                <div>
                    <span class="tc-eyebrow">For Colleges &amp; TPOs</span>
                    <h2 class="tc-section__title tc-section__title--flush">Training partnerships for campuses</h2>
                    <p class="tc-muted">Bulk fullstack training on campus or online, transparent per-student
                        rates, placement reporting — and zero revenue-share.</p>
                </div>
                <a class="tc-btn tc-btn--ghost" href="/for-colleges/">Explore college partnerships</a>
            </div>
        </section>

        <!-- SECTION: Testimonials -->
        <section class="tc-section tc-testimonials">
            <h2 class="tc-section__title">What learners say</h2>
            <div class="row">
                <?php foreach ( $tc_tests as $t ) : ?>
                <div class="col-md-4">
                    <figure class="tc-quote">
                        <div class="tc-quote__stars" aria-hidden="true">★★★★★</div>
                        <blockquote class="tc-quote__text">&ldquo;<?php echo esc_html( $t['quote'] ); ?>&rdquo;</blockquote>
                        <figcaption class="tc-quote__by">
                            <span class="tc-quote__avatar" aria-hidden="true"><?php echo esc_html( mb_substr( $t['name'], 0, 1 ) ); ?></span>
                            <span>
                                <strong><?php echo esc_html( $t['name'] ); ?></strong>
                                <em><?php echo esc_html( $t['role'] ); ?></em>
                            </span>
                        </figcaption>
                    </figure>
                </div>
                <?php endforeach; ?>
            </div>
            <p class="tc-placeholder-note">Placeholder testimonials — swap for real student quotes &amp; names.</p>
        </section>

        <!-- SECTION: Final CTA -->
        <section class="tc-section tc-cta-band text-center">
            <h2>Your developer career starts here</h2>
            <p class="tc-cta-band__sub">Join the next VisionOne cohort. Apply now and our team will confirm
                your batch over email &amp; WhatsApp.</p>
            <div class="tc-cta-band__actions">
                <a class="tc-btn tc-btn--primary" href="/admissions-apply/">Apply Now</a>
                <a class="tc-btn tc-btn--ghost" href="/program-curriculum/">View the Program</a>
            </div>
        </section>

    </div>
</div>

<?php get_footer();
