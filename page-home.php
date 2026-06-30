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

if (!defined('ABSPATH')) {
    exit;
}

get_header();

/* CLAUDE CODE: homepage copy blocks — realistic placeholders, easy to swap. */
$tc_why = array(
    array('ic' => 'sliders', 'tone' => 'blue', 'title' => 'Project-first learning', 'text' => 'Write real code from day one and ship a feature every week — not just watch lectures.'),
    array('ic' => 'award', 'tone' => 'orange', 'title' => 'Industry mentors', 'text' => 'Live mentorship, code reviews and 1:1 guidance from working engineers.'),
    array('ic' => 'chart', 'tone' => 'blue', 'title' => 'Placement support', 'text' => 'Mock interviews, resume &amp; GitHub polish, and a TPO/placement pipeline.'),
    array('ic' => 'receipt', 'tone' => 'orange', 'title' => 'EMI-friendly fees', 'text' => 'Transparent pricing with No-Cost EMI options on eligible cards.'),
);

$tc_stack = array(
    array('label' => 'HTML & CSS', 'key' => 'html-css', 'brand' => '#E34F26'),
    array('label' => 'JavaScript', 'key' => 'javascript', 'brand' => '#F7DF1E'),
    array('label' => 'React', 'key' => 'react', 'brand' => '#61DAFB'),
    array('label' => 'Node.js', 'key' => 'nodejs', 'brand' => '#5FA04E'),
    array('label' => 'Express', 'key' => 'express', 'brand' => '#303030'),
    array('label' => 'MongoDB', 'key' => 'mongodb', 'brand' => '#47A248'),
    array('label' => 'SQL', 'key' => 'sql', 'brand' => '#2f6bff'),
    array('label' => 'Git & GitHub', 'key' => 'git-github', 'brand' => '#F05032'),
    array('label' => 'Docker', 'key' => 'docker', 'brand' => '#2496ED'),
    array('label' => 'REST APIs', 'key' => 'rest-api', 'brand' => '#2f6bff'),
    array('label' => 'Auth & Security', 'key' => 'auth-security', 'brand' => '#ff7a18'),
    array('label' => 'Deployment', 'key' => 'deployment', 'brand' => '#2f6bff'),
);

$tc_steps = array(
    array('n' => '01', 'title' => 'Apply', 'text' => 'Submit the quick registration form and pick your preferred batch.'),
    array('n' => '02', 'title' => 'Get confirmed', 'text' => 'Our team confirms your seat over email &amp; WhatsApp and shares the joining kit.'),
    array('n' => '03', 'title' => 'Learn & build', 'text' => '14 weeks of live, project-first training with mentors and weekly reviews.'),
    array('n' => '04', 'title' => 'Get placed', 'text' => 'Graduate with a portfolio and step into interviews with placement support.'),
);

$tc_tests = array(
    array('quote' => 'I joined as a complete beginner and finished with a deployed MERN app in my portfolio. The weekly reviews kept me accountable.', 'name' => 'Placeholder Student', 'role' => 'Fullstack Developer'),
    array('quote' => 'The mentors actually review your code. That feedback loop is what got me interview-ready faster than self-study ever did.', 'name' => 'Placeholder Student', 'role' => 'Frontend Engineer'),
    array('quote' => 'EMI made it accessible, and the placement prep was the part I underestimated most. Worth every week.', 'name' => 'Placeholder Student', 'role' => 'MERN Developer'),
);
?>

<div id="primary" class="content-area page-content-area tc-page tc-home pt-120 pb-120">
    <div class="container">

        <!-- SECTION: Hero -->
        <section class="tc-hero tc-home__hero tc-texture-dots tc-reveal">
            <!-- Ambient glow orbs -->
            <div class="tc-glow-orb tc-glow-orb--blue" aria-hidden="true"></div>
            <div class="tc-glow-orb tc-glow-orb--orange" aria-hidden="true"></div>

            <div class="row align-items-center">
                <div class="col-lg-7">
                    <span class="tc-eyebrow">VisionOne &middot; Fullstack Developer Training</span>
                    <h1 class="tc-hero__title">Become a <span
                            class="tc-gradient-text tc-gradient-text--freeze">job-ready fullstack
                            developer</span> in 14 weeks</h1>
                    <p class="tc-hero__sub">Learn modern web development by building real projects, mentored
                        by working engineers — from fundamentals to a deployed MERN app, backed by placement support.
                    </p>

                    <div class="tc-home__hero-actions">
                        <a class="tc-btn tc-btn--primary"
                            href="<?php echo esc_url(tc_tpl_url('page-apply.php', '/admissions-apply/')); ?>">Apply
                            Now</a>
                        <a class="tc-btn tc-btn--ghost"
                            href="<?php echo esc_url(tc_tpl_url('page-program.php', '/program-curriculum/')); ?>">Explore
                            the curriculum</a>
                    </div>

                    <!-- CLAUDE CODE: hero stats are PLACEHOLDERS — swap for real figures. -->
                    <div class="tc-hero__stats">
                        <div class="tc-stat">
                            <strong class="tc-stat__num" data-animate>4.8</strong>
                            <span class="tc-stars" aria-hidden="true">★★★★★</span>
                            <span class="tc-stat__label">learner rating</span>
                        </div>
                        <div class="tc-stat tc-stat--divider">
                            <strong class="tc-stat__num" data-animate>12,000+</strong>
                            <span class="tc-stat__label">learners trained</span>
                        </div>
                        <div class="tc-stat tc-stat--divider">
                            <strong class="tc-stat__num" data-animate>14</strong>
                            <span class="tc-stat__label">weeks</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <!-- Next-cohort highlight card -->
                    <aside class="tc-home__herocard">
                        <span class="tc-home__herocard-title"><b>Admissions open</b></span>
                        <h3 class="tc-home__herocard-title">Next cohort</h3>
                        <!-- CLAUDE CODE: set the real upcoming batch date. -->
                        <p class="tc-home__herocard-date">Starting <strong>July 6, 2026</strong></p>
                        <ul class="tc-home__herocard-list">
                            <li><?php echo tc_icon('calendar', 18); ?> 14 weeks · weekday &amp; weekend tracks</li>
                            <li><?php echo tc_icon('globe', 18); ?> Online / hybrid · English &amp; Hindi</li>
                            <li><?php echo tc_icon('award', 18); ?> Certificate + placement support</li>
                            <li><?php echo tc_icon('receipt', 18); ?> EMI &amp; No-Cost EMI available</li>
                        </ul>
                        <a class="tc-btn tc-btn--accent tc-btn--block tc-btn--glow"
                            href="<?php echo esc_url(tc_tpl_url('page-apply.php', '/admissions-apply/') . '#tc-apply-form-anchor'); ?>">Reserve
                            your seat</a>
                        <p class="tc-home__herocard-note">Seats are limited each cohort.</p>
                    </aside>
                </div>
            </div>
        </section>

        <!-- SECTION: Trust strip -->
        <section class="tc-section tc-logos tc-reveal">
            <p class="tc-logos__label">Trusted by students &amp; colleges across India</p>
            <!-- CLAUDE CODE: swap label text for real partner / hiring-company logo marks when available. -->
            <div class="tc-marquee">
                <div class="tc-marquee__track">
                    <?php
                    $tc_trust = array('Partner College', 'Hiring Partner', 'TPO Cell', 'Startup Partner', 'Tech Company');
                    for ($r = 0; $r < 2; $r++):
                        foreach ($tc_trust as $tname): ?>
                            <span class="tc-marquee__item"><?php echo tc_icon('award', 18); ?> <?php echo esc_html($tname); ?></span>
                        <?php endforeach;
                    endfor; ?>
                </div>
            </div>
        </section>

        <!-- SECTION: Why VisionOne -->
        <section class="tc-section tc-section--tint tc-why tc-reveal">
            <h2 class="tc-section__title">Why VisionOne</h2>
            <div class="tc-bento">
                <?php foreach ($tc_why as $i => $f): ?>
                    <div class="tc-feature tc-reveal<?php echo $i === 0 ? ' tc-bento__cell--lead' : ''; ?>" style="--delay: <?php echo $i * 80; ?>ms">
                        <span
                            class="tc-feature__ic tc-feature__ic--<?php echo esc_attr($f['tone']); ?>"><?php echo tc_icon($f['ic'], 24); ?></span>
                        <h3><?php echo esc_html($f['title']); ?></h3>
                        <p class="tc-muted"><?php echo wp_kses_post($f['text']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- SECTION: What you'll learn (stack) + curriculum teaser -->
        <section class="tc-section tc-stack-sec tc-reveal">
            <div class="row align-items-center">
                <div class="col-lg-5">
                    <span class="tc-eyebrow">The Stack</span>
                    <h2 class="tc-section__title">Everything you need, end to end</h2>
                    <p class="tc-muted">A structured 14-week ladder takes you from web fundamentals through
                        frontend, backend, databases and deployment — finishing with a portfolio-grade capstone.</p>
                    <a class="tc-btn tc-btn--outline"
                        href="<?php echo esc_url(tc_tpl_url('page-program.php', '/program-curriculum/')); ?>">See
                        the full curriculum</a>
                </div>
                <div class="col-lg-7">
                    <div class="tc-techgrid">
                        <?php foreach ($tc_stack as $i => $tech): ?>
                            <span class="tc-techtile-wrap tc-reveal" style="--delay: <?php echo $i * 40; ?>ms;">
                                <span class="tc-techtile" tabindex="0"
                                    style="--brand: <?php echo esc_attr($tech['brand']); ?>;"
                                    aria-label="<?php echo esc_attr($tech['label']); ?>">
                                    <span class="tc-techtile__tip" role="tooltip"><?php echo esc_html($tech['label']); ?></span>
                                    <span class="tc-techtile__ic"><?php echo tc_brand_icon($tech['key'], 40); ?></span>
                                </span>
                            </span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION: Outcomes stats band -->
        <section class="tc-section tc-section--dark tc-texture-dots tc-outcomes tc-reveal">
            <div class="tc-statband">
                <div class="tc-statband__item tc-reveal" style="--delay: 0ms">
                    <span class="tc-statband__num">14 weeks</span><span class="tc-statband__label">To job-ready</span>
                </div>
                <div class="tc-statband__item tc-reveal" style="--delay: 80ms">
                    <span class="tc-statband__num">100+ lessons</span><span class="tc-statband__label">Live &amp; hands-on</span>
                </div>
                <div class="tc-statband__item tc-reveal" style="--delay: 160ms">
                    <span class="tc-statband__num">1 capstone</span><span class="tc-statband__label">Deployed &amp; portfolio-ready</span>
                </div>
                <div class="tc-statband__item tc-reveal" style="--delay: 240ms">
                    <span class="tc-statband__num">EMI</span><span class="tc-statband__label">No-Cost options</span>
                </div>
            </div>
        </section>

        <!-- SECTION: How it works -->
        <section class="tc-section tc-steps-sec tc-reveal">
            <h2 class="tc-section__title">How it works</h2>
            <div class="tc-timeline">
                <?php foreach ($tc_steps as $i => $s): ?>
                    <div class="tc-timeline__step tc-reveal" style="--delay: <?php echo $i * 80; ?>ms">
                        <div class="tc-timeline__node"><?php echo esc_html($i + 1); ?></div>
                        <h3 class="tc-timeline__title"><?php echo esc_html($s['title']); ?></h3>
                        <p class="tc-muted"><?php echo wp_kses_post($s['text']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- SECTION: Pricing + Colleges teaser (merged split panel) -->
        <section class="tc-section tc-section--tint tc-priceteaser tc-reveal">
            <div class="tc-split-panel">
                <div class="tc-split-panel__half">
                    <span class="tc-eyebrow">Fees &amp; EMI</span>
                    <h2 class="tc-section__title tc-section__title--flush">Transparent pricing, EMI-friendly</h2>
                    <p class="tc-muted">Clear fees inclusive of 18% GST, with No-Cost EMI on eligible cards and
                        secure online payment via Razorpay.</p>
                    <div>
                        <a class="tc-btn tc-btn--primary"
                            href="<?php echo esc_url(tc_tpl_url('page-fees.php', '/fees-batches/')); ?>">View Fees &amp;
                            Batches</a>
                    </div>
                </div>
                <div class="tc-split-panel__half">
                    <span class="tc-eyebrow">For Colleges &amp; TPOs</span>
                    <h2 class="tc-section__title tc-section__title--flush">Training partnerships for campuses</h2>
                    <p class="tc-muted">Bulk fullstack training on campus or online, transparent per-student
                        rates, placement reporting — and zero revenue-share.</p>
                    <div>
                        <a class="tc-btn tc-btn--ghost"
                            href="<?php echo esc_url(tc_tpl_url('page-colleges.php', '/for-colleges/')); ?>">Explore
                            college partnerships</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION: Testimonials -->
        <section class="tc-section tc-section--tint tc-testimonials tc-reveal">
            <h2 class="tc-section__title">What learners say</h2>
            <div class="row">
                <?php foreach ($tc_tests as $i => $t): ?>
                    <?php if ($i === 0): ?>
                        <div class="col-lg-7 tc-reveal" style="--delay: 0ms">
                            <figure class="tc-quote tc-quote--featured">
                                <div class="tc-quote__stars" aria-hidden="true">★★★★★</div>
                                <blockquote class="tc-quote__text">&ldquo;<?php echo esc_html($t['quote']); ?>&rdquo;
                                </blockquote>
                                <figcaption class="tc-quote__by">
                                    <span class="tc-quote__avatar"
                                        aria-hidden="true"><?php echo esc_html(mb_substr($t['name'], 0, 1)); ?></span>
                                    <span>
                                        <strong><?php echo esc_html($t['name']); ?></strong>
                                        <em><?php echo esc_html($t['role']); ?></em>
                                    </span>
                                </figcaption>
                            </figure>
                        </div>
                        <div class="col-lg-5">
                            <div class="row">
                    <?php else: ?>
                            <div class="col-12 tc-reveal" style="--delay: <?php echo $i * 100; ?>ms">
                                <figure class="tc-quote">
                                    <div class="tc-quote__stars" aria-hidden="true">★★★★★</div>
                                    <blockquote class="tc-quote__text">&ldquo;<?php echo esc_html($t['quote']); ?>&rdquo;
                                    </blockquote>
                                    <figcaption class="tc-quote__by">
                                        <span class="tc-quote__avatar"
                                            aria-hidden="true"><?php echo esc_html(mb_substr($t['name'], 0, 1)); ?></span>
                                        <span>
                                            <strong><?php echo esc_html($t['name']); ?></strong>
                                            <em><?php echo esc_html($t['role']); ?></em>
                                        </span>
                                    </figcaption>
                                </figure>
                            </div>
                    <?php endif; ?>
                <?php endforeach; ?>
                            </div>
                        </div>
            </div>
            <p class="tc-placeholder-note">Placeholder testimonials — swap for real student quotes &amp; names.</p>
        </section>

        <!-- SECTION: Final CTA -->
        <section class="tc-section tc-cta-band text-center tc-reveal">
            <!-- Ambient glow orbs -->
            <div class="tc-glow-orb tc-glow-orb--blue" aria-hidden="true"></div>
            <div class="tc-glow-orb tc-glow-orb--orange" aria-hidden="true"></div>

            <h2>Your developer career starts here</h2>
            <p class="tc-cta-band__sub">Join the next VisionOne cohort. Apply now and our team will confirm
                your batch over email &amp; WhatsApp.</p>
            <div class="tc-cta-band__actions">
                <a class="tc-btn tc-btn--primary"
                    href="<?php echo esc_url(tc_tpl_url('page-apply.php', '/admissions-apply/')); ?>">Apply Now</a>
                <a class="tc-btn tc-btn--ghost"
                    href="<?php echo esc_url(tc_tpl_url('page-program.php', '/program-curriculum/')); ?>">View the
                    Program</a>
            </div>
        </section>

    </div>
</div>

<?php get_footer();
