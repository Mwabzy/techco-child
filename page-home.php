<?php
/**
 * Template Name: VisionONE — Home / Landing
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

// "Why VisionOne" service cards. First card renders as the filled feature card.
// 'color' picks the icon-tile hue; 'link' points at the most relevant page.
$tc_why = array(
    array('ic' => 'sliders', 'color' => 'feature', 'title' => 'Project-first learning', 'text' => 'Write real code from day one and ship a feature every week — not just watch lectures.', 'link' => array('page-program.php', '/program-curriculum/')),
    array('ic' => 'award', 'color' => 'violet', 'title' => 'Industry mentors', 'text' => 'Live mentorship, code reviews and 1:1 guidance from working engineers, in class.', 'link' => array('page-program.php', '/program-curriculum/')),
    array('ic' => 'chart', 'color' => 'amber', 'title' => 'Placement support', 'text' => 'Mock interviews, resume &amp; GitHub polish, and a TPO/placement pipeline.', 'link' => array('page-apply.php', '/admissions-apply/')),
    array('ic' => 'receipt', 'color' => 'pink', 'title' => 'EMI-friendly fees', 'text' => 'Transparent pricing with No-Cost EMI options on eligible cards.', 'link' => array('page-fees.php', '/fees-batches/')),
);

// "Program tracks" cards (image-2 style, in-class context — no prices).
$tc_tracks = array(
    array('img' => 'tc_track_img_1', 'cat' => 'Fullstack', 'title' => 'MERN Fullstack Track', 'text' => 'Build and deploy complete web apps — React front-ends wired to Node/Express APIs and MongoDB.', 'len' => '14 weeks', 'level' => 'Beginner-friendly', 'key' => 'react'),
    array('img' => 'tc_track_img_2', 'cat' => 'Frontend', 'title' => 'Frontend Engineering', 'text' => 'Master modern HTML, CSS and JavaScript with React to craft fast, accessible interfaces.', 'len' => '8 weeks', 'level' => 'No experience needed', 'key' => 'javascript'),
    array('img' => 'tc_track_img_3', 'cat' => 'Backend', 'title' => 'Backend & APIs', 'text' => 'Design REST APIs, model data in SQL &amp; MongoDB, and ship secure, deployable services.', 'len' => '10 weeks', 'level' => 'Some coding helps', 'key' => 'nodejs'),
);

$tc_stack = array(
    array('label' => 'HTML & CSS', 'key' => 'html-css', 'brand' => '#2496ED'),
    array('label' => 'JavaScript', 'key' => 'javascript', 'brand' => '#1C75BC'),
    array('label' => 'React', 'key' => 'react', 'brand' => '#5FC1F0'),
    array('label' => 'Node.js', 'key' => 'nodejs', 'brand' => '#10173D'),
    array('label' => 'Express', 'key' => 'express', 'brand' => '#0A0E2E'),
    array('label' => 'MongoDB', 'key' => 'mongodb', 'brand' => '#2496ED'),
    array('label' => 'SQL', 'key' => 'sql', 'brand' => '#1C75BC'),
    array('label' => 'Git & GitHub', 'key' => 'git-github', 'brand' => '#5FC1F0'),
    array('label' => 'Docker', 'key' => 'docker', 'brand' => '#10173D'),
    array('label' => 'REST APIs', 'key' => 'rest-api', 'brand' => '#0A0E2E'),
    array('label' => 'Auth & Security', 'key' => 'auth-security', 'brand' => '#2496ED'),
    array('label' => 'Deployment', 'key' => 'deployment', 'brand' => '#1C75BC'),
);

$tc_steps = array(
    array('n' => '1', 'ic' => 'chat', 'color' => 'blue', 'title' => 'Apply', 'text' => 'Submit the quick registration form and pick your preferred batch.'),
    array('n' => '2', 'ic' => 'mail', 'color' => 'violet', 'title' => 'Get confirmed', 'text' => 'Our team confirms your seat over email &amp; WhatsApp and shares the joining kit.'),
    array('n' => '3', 'ic' => 'sliders', 'color' => 'amber', 'title' => 'Learn &amp; build', 'text' => '14 weeks of live, project-first training with mentors and weekly reviews.'),
    array('n' => '4', 'ic' => 'award', 'color' => 'green', 'title' => 'Get placed', 'text' => 'Graduate with a portfolio and step into interviews with placement support.'),
);

// Reviews (image-3 people cards). 'img' = Customizer avatar key; 'color' tints the role line.
$tc_tests = array(
    array('quote' => 'I joined as a complete beginner and finished with a deployed MERN app in my portfolio. The weekly reviews kept me accountable.', 'name' => 'Placeholder Student', 'role' => 'Fullstack Developer', 'img' => 'tc_review_img_1', 'color' => 'blue'),
    array('quote' => 'The mentors actually review your code. That feedback loop is what got me interview-ready faster than self-study ever did.', 'name' => 'Placeholder Student', 'role' => 'Frontend Engineer', 'img' => 'tc_review_img_2', 'color' => 'violet'),
    array('quote' => 'EMI made it accessible, and the placement prep was the part I underestimated most. Worth every week.', 'name' => 'Placeholder Student', 'role' => 'MERN Developer', 'img' => 'tc_review_img_3', 'color' => 'pink'),
);
?>

<div id="primary" class="content-area page-content-area tc-page tc-home pt-120 pb-120">
    <div class="container">

        <!-- SECTION: Hero (split — message left, visual right) -->
        <section class="tc-hero tc-home__hero tc-home__hero--split">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <span class="tc-eyebrow">VisionOne &middot; Fullstack Developer Training</span>
                    <h1 class="tc-hero__title">Up Your <span
                            class="tc-gradient-text tc-gradient-text--freeze">Skills</span> To Launch Your <span
                            class="tc-gradient-text tc-gradient-text--freeze">Dev Career</span></h1>
                    <p class="tc-hero__sub">Learn modern web development by building real projects, mentored
                        by working engineers — from fundamentals to a deployed MERN app in 14 weeks, backed by
                        placement support.</p>

                    <div class="tc-home__hero-actions">
                        <a class="tc-btn tc-btn--primary" data-magnetic
                            href="<?php echo esc_url(tc_tpl_url('page-apply.php', '/admissions-apply/') . '#tc-apply-form-anchor'); ?>">Get
                            Started</a>
                        <a class="tc-btn tc-btn--ghost"
                            href="<?php echo esc_url(tc_tpl_url('page-program.php', '/program-curriculum/')); ?>">Explore
                            the curriculum</a>
                    </div>

                    <!-- Feature trio (mirrors reference's icon row) -->
                    <ul class="tc-herofeat">
                        <li><span class="tc-herofeat__ic tc-herofeat__ic--blue"><?php echo tc_icon('sliders', 20); ?></span>Project-first learning</li>
                        <li><span class="tc-herofeat__ic tc-herofeat__ic--orange"><?php echo tc_icon('award', 20); ?></span>Industry mentors</li>
                        <li><span class="tc-herofeat__ic tc-herofeat__ic--blue"><?php echo tc_icon('chart', 20); ?></span>Placement support</li>
                    </ul>

                    <!-- Collaboration / trust row (mirrors reference's "250+ Collaboration" + logos) -->
                    <div class="tc-herotrust">
                        <div class="tc-herotrust__stat">
                            <strong class="tc-stat__num" data-animate>12,000+</strong>
                            <span class="tc-stat__label">Learners trained</span>
                        </div>
                        <div class="tc-herotrust__logos">
                            <?php foreach (array('Partner Colleges', 'Hiring Partners', 'TPO Cells') as $tname): ?>
                                <span class="tc-herotrust__chip"><?php echo tc_icon('award', 16); ?><?php echo esc_html($tname); ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <!-- Visual: photo-in-disc + floating stat cards + concentric rings -->
                    <div class="tc-herovis" data-tilt>
                        <span class="tc-herovis__ring tc-herovis__ring--1" aria-hidden="true"></span>
                        <span class="tc-herovis__ring tc-herovis__ring--2" aria-hidden="true"></span>

                        <div class="tc-herovis__disc" data-parallax="4">
                            <?php
                            /* CLAUDE CODE: drop a cut-out student photo (transparent PNG, ~700px)
                               at assets/images/hero-student.png and it replaces the monogram below. */
                            $tc_hero_img = get_stylesheet_directory() . '/assets/images/hero-student.png';
                            if (file_exists($tc_hero_img)):
                                ?>
                                <img class="tc-herovis__photo"
                                    src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/hero-student.png'); ?>"
                                    alt="A VisionOne fullstack student" loading="eager" decoding="async" />
                            <?php else: ?>
                                <span class="tc-herovis__mono" aria-hidden="true">&lt;/&gt;</span>
                            <?php endif; ?>
                        </div>

                        <!-- Floating card: ring progress (top-right) -->
                        <div class="tc-herofloat tc-herofloat--tr" style="--delay: 620ms">
                            <span class="tc-herofloat__ring" style="--pct: 92"><b>4.8<i>★</i></b></span>
                            <span class="tc-herofloat__meta"><strong>Rated</strong>by 12k+ learners</span>
                        </div>

                        <!-- Floating card: lessons (left) -->
                        <div class="tc-herofloat tc-herofloat--l" style="--delay: 760ms">
                            <span class="tc-herofloat__ic tc-herofloat__ic--blue"><?php echo tc_icon('play', 20); ?></span>
                            <span class="tc-herofloat__meta"><strong>100+</strong>Live lessons</span>
                        </div>

                        <!-- Floating card: mentors (bottom-right) -->
                        <div class="tc-herofloat tc-herofloat--br" style="--delay: 900ms">
                            <span class="tc-herofloat__ic tc-herofloat__ic--orange"><?php echo tc_icon('award', 20); ?></span>
                            <span class="tc-herofloat__meta"><strong>50+</strong>Industry mentors</span>
                        </div>
                    </div>
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

        <!-- SECTION: Why VisionOne — service cards -->
        <section class="tc-section tc-services tc-reveal">
            <div class="tc-services__head">
                <span class="tc-eyebrow">Why VisionOne</span>
                <h2 class="tc-section__title">A hands-on, classroom-first way to go from beginner to hired</h2>
            </div>
            <div class="tc-services__grid">
                <?php foreach ($tc_why as $i => $f):
                    $is_feature = ($f['color'] === 'feature');
                    $card_class = 'tc-servicecard tc-reveal' . ($is_feature ? ' tc-servicecard--feature' : '');
                    $url = tc_tpl_url($f['link'][0], $f['link'][1]);
                    ?>
                    <article class="<?php echo esc_attr($card_class); ?>" style="--delay: <?php echo $i * 80; ?>ms">
                        <span class="tc-servicecard__ic tc-servicecard__ic--<?php echo esc_attr($f['color']); ?>"><?php echo tc_icon($f['ic'], 24); ?></span>
                        <h3 class="tc-servicecard__title"><?php echo esc_html($f['title']); ?></h3>
                        <p class="tc-servicecard__text"><?php echo wp_kses_post($f['text']); ?></p>
                        <a class="tc-servicecard__more" href="<?php echo esc_url($url); ?>">Learn more <?php echo tc_icon('arrow-right', 16); ?></a>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- SECTION: The Stack — scattered brand-icon cloud -->
        <section class="tc-section tc-stackcloud tc-reveal">
            <div class="tc-stackcloud__head">
                <span class="tc-eyebrow">The Stack</span>
                <h2 class="tc-section__title">Tools &amp; technologies you'll master in class</h2>
                <p class="tc-muted">A structured 14-week ladder takes you from web fundamentals through frontend,
                    backend, databases and deployment — hands-on with the same tools working teams ship every day.</p>
            </div>
            <div class="tc-stackcloud__grid" data-motion-in>
                <?php foreach ($tc_stack as $i => $tech): ?>
                    <span class="tc-stackbadge" style="--brand: <?php echo esc_attr($tech['brand']); ?>;"
                        tabindex="0" aria-label="<?php echo esc_attr($tech['label']); ?>">
                        <span class="tc-stackbadge__tip" role="tooltip"><?php echo esc_html($tech['label']); ?></span>
                        <span class="tc-stackbadge__ic"><?php echo tc_brand_icon($tech['key'], 34); ?></span>
                    </span>
                <?php endforeach; ?>
            </div>
            <div class="tc-stackcloud__cta">
                <a class="tc-btn tc-btn--outline"
                    href="<?php echo esc_url(tc_tpl_url('page-program.php', '/program-curriculum/')); ?>">See the full curriculum</a>
            </div>
        </section>

        <!-- SECTION: Program tracks — course-style cards (in-class, no pricing) -->
        <section class="tc-section tc-tracks tc-reveal">
            <div class="tc-tracks__head">
                <span class="tc-eyebrow">Explore Programs</span>
                <h2 class="tc-section__title">Popular training tracks</h2>
                <p class="tc-muted">Pick the classroom track that matches where you are — every one is
                    project-first and finishes with a portfolio-ready build.</p>
            </div>
            <div class="tc-tracks__grid">
                <?php foreach ($tc_tracks as $i => $tr):
                    $tr_img = tc_opt_image($tr['img']);
                    $tr_url = tc_tpl_url('page-program.php', '/program-curriculum/');
                    ?>
                    <article class="tc-trackcard tc-reveal" style="--delay: <?php echo $i * 90; ?>ms">
                        <a class="tc-trackcard__media<?php echo $tr_img ? '' : ' tc-trackcard__media--placeholder'; ?>"
                            href="<?php echo esc_url($tr_url); ?>" aria-label="<?php echo esc_attr($tr['title']); ?>"
                            <?php if ($tr_img): ?>style="background-image: url('<?php echo esc_url($tr_img); ?>');"<?php endif; ?>>
                            <?php if (!$tr_img): ?>
                                <span class="tc-trackcard__media-ic"><?php echo tc_brand_icon($tr['key'], 44); ?></span>
                            <?php endif; ?>
                            <span class="tc-trackcard__len"><?php echo tc_icon('calendar', 14); ?> <?php echo esc_html($tr['len']); ?></span>
                        </a>
                        <div class="tc-trackcard__body">
                            <span class="tc-trackcard__cat"><?php echo esc_html($tr['cat']); ?></span>
                            <h3 class="tc-trackcard__title">
                                <a href="<?php echo esc_url($tr_url); ?>"><?php echo esc_html($tr['title']); ?> <?php echo tc_icon('arrow-right', 16); ?></a>
                            </h3>
                            <p class="tc-trackcard__text"><?php echo wp_kses_post($tr['text']); ?></p>
                            <div class="tc-trackcard__foot">
                                <span class="tc-trackcard__level"><?php echo tc_icon('award', 15); ?> <?php echo esc_html($tr['level']); ?></span>
                                <a class="tc-trackcard__more" href="<?php echo esc_url($tr_url); ?>">View track</a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
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

        <!-- SECTION: How it works — numbered steps + imagery -->
        <section class="tc-section tc-hiw tc-reveal">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <span class="tc-eyebrow">How it works</span>
                    <h2 class="tc-section__title">From application to placed</h2>
                    <ol class="tc-hiw__steps">
                        <?php foreach ($tc_steps as $i => $s): ?>
                            <li class="tc-hiw__step tc-reveal" style="--delay: <?php echo $i * 90; ?>ms">
                                <span class="tc-hiw__num" aria-hidden="true"><?php echo esc_html($s['n']); ?></span>
                                <span class="tc-hiw__card">
                                    <span class="tc-hiw__ic tc-hiw__ic--<?php echo esc_attr($s['color']); ?>"><?php echo tc_icon($s['ic'], 20); ?></span>
                                    <span class="tc-hiw__meta">
                                        <strong><?php echo wp_kses_post($s['title']); ?></strong>
                                        <span><?php echo wp_kses_post($s['text']); ?></span>
                                    </span>
                                </span>
                            </li>
                        <?php endforeach; ?>
                    </ol>
                </div>
                <div class="col-lg-6">
                    <?php $hiw1 = tc_opt_image('tc_hiw_img_1'); $hiw2 = tc_opt_image('tc_hiw_img_2'); ?>
                    <div class="tc-hiw__media">
                        <div class="tc-hiw__photo tc-hiw__photo--1<?php echo $hiw1 ? '' : ' is-placeholder'; ?>"
                            <?php if ($hiw1): ?>style="background-image:url('<?php echo esc_url($hiw1); ?>');"<?php endif; ?>>
                            <?php if (!$hiw1): ?><span class="tc-hiw__photo-ic"><?php echo tc_icon('sliders', 30); ?></span><?php endif; ?>
                        </div>
                        <div class="tc-hiw__photo tc-hiw__photo--2<?php echo $hiw2 ? '' : ' is-placeholder'; ?>"
                            <?php if ($hiw2): ?>style="background-image:url('<?php echo esc_url($hiw2); ?>');"<?php endif; ?>>
                            <?php if (!$hiw2): ?><span class="tc-hiw__photo-ic"><?php echo tc_icon('award', 34); ?></span><?php endif; ?>
                        </div>
                        <div class="tc-hiw__floatstat">
                            <strong data-animate>12,000+</strong>
                            <span>Learners trained &amp; placed</span>
                        </div>
                    </div>
                </div>
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

        <!-- SECTION: Reviews — people cards -->
        <section class="tc-section tc-reviews tc-reveal">
            <div class="tc-reviews__head">
                <span class="tc-eyebrow">Student stories</span>
                <h2 class="tc-section__title">Meet some of our learners</h2>
                <p class="tc-muted">Real words from students who started in our classroom and walked out
                    interview-ready. (Placeholder quotes &amp; names — swap for your own.)</p>
            </div>
            <div class="tc-reviews__grid">
                <?php foreach ($tc_tests as $i => $t):
                    $av = tc_opt_image($t['img']);
                    ?>
                    <figure class="tc-reviewcard tc-reveal" style="--delay: <?php echo $i * 90; ?>ms">
                        <span class="tc-reviewcard__avatar<?php echo $av ? '' : ' is-placeholder'; ?>"
                            <?php if ($av): ?>style="background-image:url('<?php echo esc_url($av); ?>');"<?php endif; ?>
                            aria-hidden="true"><?php echo $av ? '' : esc_html(mb_substr($t['name'], 0, 1)); ?></span>
                        <div class="tc-reviewcard__stars" aria-hidden="true">★★★★★</div>
                        <blockquote class="tc-reviewcard__text">&ldquo;<?php echo esc_html($t['quote']); ?>&rdquo;</blockquote>
                        <figcaption class="tc-reviewcard__by">
                            <strong><?php echo esc_html($t['name']); ?></strong>
                            <em class="tc-reviewcard__role tc-reviewcard__role--<?php echo esc_attr($t['color']); ?>"><?php echo esc_html($t['role']); ?></em>
                        </figcaption>
                    </figure>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- SECTION: Final CTA -->
        <section class="tc-section tc-cta-band text-center tc-reveal">
            <span class="tc-eyebrow">Admissions open</span>
            <h2>Your developer career starts here</h2>
            <p class="tc-cta-band__sub">Join the next VisionOne cohort. Apply now and our team will confirm
                your batch over email &amp; WhatsApp.</p>
            <div class="tc-cta-band__actions">
                <a class="tc-btn tc-btn--primary" data-magnetic
                    href="<?php echo esc_url(tc_tpl_url('page-apply.php', '/admissions-apply/') . '#tc-apply-form-anchor'); ?>">Apply Now</a>
                <a class="tc-btn tc-btn--ghost"
                    href="<?php echo esc_url(tc_tpl_url('page-program.php', '/program-curriculum/')); ?>">View the
                    Program</a>
            </div>
        </section>

    </div>
</div>

<?php get_footer();
