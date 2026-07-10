<?php
/**
 * Template Name: VisionONE — Home / Landing
 *
 * Marketing landing page for the AI Code Development Training Program.
 * Reuses the shared Visioner components (hero, feature cards, stats, CTA
 * band, apply form) plus a few homepage-only sections (program-at-a-glance,
 * salary table, curriculum list). Set a Page to this template and mark it
 * as the front page in Settings → Reading.
 * NOTE: omits techco_child_page_banner() — provides its own hero.
 * @package Techco Child
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

/* CLAUDE CODE: homepage copy blocks — realistic placeholders, easy to swap. */

// Program at a glance — rendered inside the hero's floating visual.
$tc_glance = array(
    array('label' => 'Course', 'value' => 'AI Code Development'),
    array('label' => 'Duration', 'value' => '12 Weeks (3 Months)'),
    array('label' => 'Mode', 'value' => 'Classroom'),
    array('label' => 'Schedule', 'value' => 'Mon–Fri, 3–4 hrs/day'),
    array('label' => 'Batches', 'value' => 'Every Month'),
    array('label' => 'Location', 'value' => 'Madhapur, Hyderabad'),
);

// Market stat band.
$tc_market_stats = array(
    array('num' => '75%+', 'label' => 'of enterprises are piloting or scaling AI dev tools'),
    array('num' => '3–5x', 'label' => 'faster prototyping with AI coding copilots'),
    array('num' => '#1', 'label' => 'fastest-growing skill in software job posts'),
);

// "Why AI Code Development Matters" feature grid.
$tc_shift = array(
    array('ic' => 'zap', 'color' => 'blue', 'title' => 'AI-Assisted Coding', 'text' => 'Code suggestions, autocompletion, and full functions generated in real time.'),
    array('ic' => 'settings', 'color' => 'violet', 'title' => 'Automation', 'text' => 'Repetitive tasks — scaffolding, formatting, boilerplate — handled automatically.'),
    array('ic' => 'rocket', 'color' => 'amber', 'title' => 'Faster Development', 'text' => 'Ideas move from concept to working application in a fraction of the time.'),
    array('ic' => 'search', 'color' => 'green', 'title' => 'Smarter Testing &amp; Debugging', 'text' => 'AI detects bugs, suggests fixes, and writes test cases alongside developers.'),
    array('ic' => 'brain', 'color' => 'pink', 'title' => 'Intelligent Systems', 'text' => 'Applications that reason, automate workflows, and adapt to users.'),
    array('ic' => 'building', 'color' => 'blue', 'title' => 'Enterprise Adoption', 'text' => 'Companies of every size are standardizing on AI-powered dev tools.'),
);

// Career scope.
$tc_roles = array(
    'AI Code Developer',
    'AI Software Engineer',
    'Prompt Engineer',
    'AI Application Developer',
    'Machine Learning Engineer',
    'Automation Developer',
    'AI Tool Integration Specialist',
    'Full Stack Developer (AI skills)',
);
$tc_industries = array('IT & Software', 'Startups', 'SaaS Firms', 'Finance', 'Healthcare', 'Education', 'Manufacturing', 'E-Commerce', 'Consulting');

$tc_salary = array(
    array('level' => 'Entry Level', 'role' => 'Entry Level AI Code Developer', 'india' => '₹4 – 7 LPA', 'global' => '$65,000 – $85,000'),
    array('level' => 'Junior', 'role' => 'Junior AI Developer', 'india' => '₹7 – 12 LPA', 'global' => '$85,000 – $105,000'),
    array('level' => 'Mid-Level', 'role' => 'Mid-Level AI Software Engineer', 'india' => '₹12 – 22 LPA', 'global' => '$105,000 – $140,000'),
    array('level' => 'Senior', 'role' => 'Senior AI Developer / AI Architect', 'india' => '₹22 – 40+ LPA', 'global' => '$140,000 – $190,000+'),
);

// Curriculum — 10 modules.
$tc_modules = array(
    'Introduction to AI and AI in Software Development',
    'Programming Foundations for AI Development',
    'AI Coding Tools and Productivity Platforms',
    'Prompt Engineering for Developers',
    'Building AI-Powered Applications',
    'APIs, Automation, and AI Integration',
    'Debugging, Testing, and Code Optimization with AI',
    'Git, Deployment, and Cloud Basics',
    'Real-World Projects and Case Studies',
    'Resume, Portfolio, and Interview Preparation',
);

// Tech stack — grouped by category.
$tc_stack_groups = array(
    'Frontend' => array(
        array('label' => 'Angular 18', 'key' => 'angular', 'brand' => '#DD0031'),
        array('label' => 'TypeScript', 'key' => 'typescript', 'brand' => '#3178C6'),
        array('label' => 'RxJS', 'key' => 'rxjs', 'brand' => '#B7178C'),
        array('label' => 'HTML & CSS', 'key' => 'html-css', 'brand' => '#2496ED'),
    ),
    'Backend & APIs' => array(
        array('label' => '.NET 8', 'key' => 'dotnet', 'brand' => '#512BD4'),
        array('label' => 'Entity Framework Core', 'key' => 'entity-framework', 'brand' => '#0C8F6E'),
        array('label' => 'REST APIs', 'key' => 'rest-api', 'brand' => '#009688'),
    ),
    'Database' => array(
        array('label' => 'SQL Server', 'key' => 'sql-server', 'brand' => '#A91D22'),
        array('label' => 'Stored Procedures', 'key' => 'sql', 'brand' => '#00758F'),
    ),
    'Cloud & DevOps' => array(
        array('label' => 'AWS', 'key' => 'aws', 'brand' => '#FF9900'),
        array('label' => 'Azure', 'key' => 'azure', 'brand' => '#0078D4'),
        array('label' => 'Git & GitHub', 'key' => 'git-github', 'brand' => '#F05032'),
        array('label' => 'CI/CD', 'key' => 'deployment', 'brand' => '#7C3AED'),
    ),
    'GenAI & Agentic AI' => array(
        array('label' => 'LLM APIs', 'key' => 'genai', 'brand' => '#7C3AED'),
        array('label' => 'Prompt Engineering', 'key' => 'genai', 'brand' => '#7C3AED'),
        array('label' => 'AI Agents', 'key' => 'ai-agents', 'brand' => '#D97706'),
    ),
);

// Hands-on projects.
$tc_projects = array(
    array('ic' => 'chat', 'color' => 'blue', 'title' => 'AI Chatbot', 'text' => 'Conversational assistant built with LLM integration.'),
    array('ic' => 'receipt', 'color' => 'violet', 'title' => 'AI Resume Analyzer', 'text' => 'Parses and scores resumes using AI-driven analysis.'),
    array('ic' => 'code', 'color' => 'amber', 'title' => 'Code Generation Assistant', 'text' => 'Tool that generates and explains boilerplate code.'),
    array('ic' => 'check', 'color' => 'green', 'title' => 'Automated Testing Tool', 'text' => 'AI-assisted test case generation and execution.'),
    array('ic' => 'settings', 'color' => 'pink', 'title' => 'Business Automation Workflow', 'text' => 'End-to-end workflow automation using AI agents.'),
    array('ic' => 'globe', 'color' => 'blue', 'title' => 'AI-Integrated Web Application', 'text' => 'Full-stack app with embedded AI capabilities.'),
);

// Outcomes checklist.
$tc_outcomes = array(
    'Use AI coding tools effectively',
    'Build AI-powered applications',
    'Integrate AI APIs into real systems',
    'Automate development tasks',
    'Create a portfolio of AI projects',
    'Apply for AI developer roles with confidence',
);
?>

<div id="primary" class="content-area page-content-area tc-page tc-home pt-120 pb-120">
    <div class="container">

        <!-- SECTION: Hero (split — message left, program-at-a-glance visual right) -->
        <section class="tc-hero tc-home__hero tc-home__hero--split">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <span class="tc-eyebrow">Career-Ready Training Program</span>
                    <h1 class="tc-hero__title">AI Code Development <span
                            class="tc-gradient-text tc-gradient-text--freeze">Training Program</span></h1>
                    <p class="tc-hero__sub">Build the future of software with Artificial Intelligence. Learn
                        AI-assisted coding, automation, and real project delivery — the way modern development
                        teams work today.</p>

                    <div class="tc-home__hero-actions">
                        <a class="tc-btn tc-btn--primary" data-magnetic
                            href="<?php echo esc_url(tc_tpl_url('page-apply.php', '/admissions-apply/') . '#tc-apply-form-anchor'); ?>">Enroll
                            for the Next Batch</a>
                        <a class="tc-btn tc-btn--ghost"
                            href="<?php echo esc_url(tc_tpl_url('page-fees.php', '/fees-batches/')); ?>">View
                            Curriculum</a>
                    </div>

                    <!-- Feature quad -->
                    <ul class="tc-herofeat">
                        <li><span class="tc-herofeat__ic tc-herofeat__ic--blue"><?php echo tc_icon('zap', 20); ?></span>AI-Assisted Coding</li>
                        <li><span class="tc-herofeat__ic tc-herofeat__ic--orange"><?php echo tc_icon('settings', 20); ?></span>Automation</li>
                        <li><span class="tc-herofeat__ic tc-herofeat__ic--blue"><?php echo tc_icon('code', 20); ?></span>Real Projects</li>
                        <li><span class="tc-herofeat__ic tc-herofeat__ic--orange"><?php echo tc_icon('chart', 20); ?></span>Career Growth</li>
                    </ul>
                </div>

                <div class="col-lg-5">
                    <!-- Visual: clean "Program at a Glance" fact table -->
                    <div class="tc-glancecard tc-reveal" style="--delay: 120ms">
                        <span class="tc-glancecard__head">Program at a Glance</span>
                        <dl class="tc-glancecard__list">
                            <?php foreach ($tc_glance as $g): ?>
                                <div class="tc-glancecard__row">
                                    <dt><?php echo esc_html($g['label']); ?></dt>
                                    <dd><?php echo esc_html($g['value']); ?></dd>
                                </div>
                            <?php endforeach; ?>
                        </dl>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION: Market stat band -->
        <section class="tc-section tc-section--navy tc-texture-dots tc-outcomes tc-reveal">
            <div class="tc-statband">
                <?php foreach ($tc_market_stats as $i => $s): ?>
                    <div class="tc-statband__item tc-reveal" style="--delay: <?php echo $i * 80; ?>ms">
                        <span class="tc-statband__num"><?php echo esc_html($s['num']); ?></span><span
                            class="tc-statband__label"><?php echo esc_html($s['label']); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- SECTION: The Shift — why AI Code Development matters -->
        <section class="tc-section tc-services tc-reveal tc-section--navy">
            <div class="tc-services__head">
                <span class="tc-eyebrow">The Shift</span>
                <h2 class="tc-section__title">Why AI Code Development Matters</h2>
                <p class="tc-muted">Software development is being rebuilt around AI. Developers who pair human
                    judgment with AI-powered tools ship features faster, with fewer bugs, and at a scale that was
                    impossible just a few years ago.</p>
            </div>
            <div class="tc-bento tc-bento--4col">
                <?php foreach ($tc_shift as $i => $f): ?>
                    <div class="tc-feature tc-reveal" style="--delay: <?php echo $i * 80; ?>ms">
                        <span
                            class="tc-feature__ic tc-feature__ic--<?php echo esc_attr($f['color']); ?>"><?php echo tc_icon($f['ic'], 24); ?></span>
                        <h3><?php echo wp_kses_post($f['title']); ?></h3>
                        <p class="tc-muted"><?php echo wp_kses_post($f['text']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- SECTION: Career scope & job opportunities -->
        <section class="tc-section tc-section--navy tc-reveal">
            <span class="tc-eyebrow">Career Scope</span>
            <h2 class="tc-section__title">Career Scope &amp; Job Opportunities</h2>
            <p class="tc-muted" style="max-width: 720px;">Demand for developers who can build with AI is climbing
                across every sector. This program prepares you for roles such as:</p>

            <div class="tc-split-panel">
                <div class="tc-split-panel__half">
                    <h3 class="tc-section__title tc-section__title--flush">Roles You Can Target</h3>
                    <ul class="tc-eligibility-grid">
                        <?php foreach ($tc_roles as $i => $role): ?>
                            <li class="tc-eligibility-item tc-reveal" style="--delay: <?php echo $i * 50; ?>ms">
                                <span class="tc-eligibility-check"><?php echo tc_icon('check', 14); ?></span>
                                <p><?php echo esc_html($role); ?></p>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="tc-split-panel__half">
                    <h3 class="tc-section__title tc-section__title--flush">Opportunities Across Industries</h3>
                    <ul class="tc-eligibility-grid">
                        <?php foreach ($tc_industries as $i => $ind): ?>
                            <li class="tc-eligibility-item tc-reveal" style="--delay: <?php echo $i * 50; ?>ms">
                                <span class="tc-eligibility-check"><?php echo tc_icon('building', 14); ?></span>
                                <p><?php echo esc_html($ind); ?></p>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <div class="tc-salarytable-wrap tc-reveal" style="--delay: 100ms">
                <h3 class="tc-section__title tc-section__title--flush">Indicative Salary Range by Experience</h3>
                <div class="tc-salarytable-scroll">
                    <table class="tc-salarytable">
                        <thead>
                            <tr>
                                <th>Experience Level</th>
                                <th>Role</th>
                                <th>India (Annual)</th>
                                <th>Global / US (Annual)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tc_salary as $row): ?>
                                <tr>
                                    <td data-label="Experience Level"><?php echo esc_html($row['level']); ?></td>
                                    <td data-label="Role"><?php echo esc_html($row['role']); ?></td>
                                    <td data-label="India (Annual)"><?php echo esc_html($row['india']); ?></td>
                                    <td data-label="Global / US (Annual)"><?php echo esc_html($row['global']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <p class="tc-muted tc-salarytable__note">Figures are approximate market estimates for orientation
                    only. Actual compensation varies by city, company size, industry, AI tools/stack expertise,
                    and project portfolio.</p>
            </div>
        </section>

        <!-- SECTION: Curriculum — 10 modules -->
        <section class="tc-section tc-section--navy tc-hiw tc-reveal" id="tc-curriculum">
            <span class="tc-eyebrow">Curriculum</span>
            <h2 class="tc-section__title">Course Syllabus — 10 Modules</h2>
            <p class="tc-muted" style="max-width: 720px;">A structured path from programming fundamentals to
                shipping real AI-powered applications.</p>
            <ol class="tc-curriculum-grid">
                <?php foreach ($tc_modules as $i => $mod): ?>
                    <li class="tc-curriculum-card tc-reveal" style="--delay: <?php echo $i * 50; ?>ms">
                        <span class="tc-curriculum-card__num" aria-hidden="true"><?php echo esc_html(sprintf('%02d', $i + 1)); ?></span>
                        <span class="tc-curriculum-card__meta">
                            <strong>Module <?php echo esc_html($i + 1); ?></strong>
                            <span><?php echo esc_html($mod); ?></span>
                        </span>
                    </li>
                <?php endforeach; ?>
            </ol>
        </section>

        <!-- SECTION: Tools & technologies (grouped stack cloud) -->
        <section class="tc-section tc-stackcloud tc-reveal tc-section--navy">
            <div class="tc-stackcloud__head">
                <span class="tc-eyebrow">Hands-On Stack</span>
                <h2 class="tc-section__title">Tools &amp; Technologies You'll Use</h2>
                <p class="tc-muted">You'll work with the same AI tools, languages, and platforms that modern
                    development teams use every day — applied on real project work, not just slides.</p>
            </div>
            <?php
            $tc_stack_colors = array('blue', 'violet', 'amber', 'green', 'pink');
            $tc_stack_i = 0;
            ?>
            <div class="tc-stackpanels">
                <?php foreach ($tc_stack_groups as $group => $items):
                    $tc_color = $tc_stack_colors[$tc_stack_i % count($tc_stack_colors)];
                    $tc_stack_i++;
                    ?>
                    <div class="tc-stackpanel tc-reveal" style="--delay: <?php echo $tc_stack_i * 70; ?>ms">
                        <div class="tc-stackpanel__head">
                            <span class="tc-feature__ic tc-feature__ic--<?php echo esc_attr($tc_color); ?> tc-stackpanel__ic"><?php echo tc_icon('code', 20); ?></span>
                            <h3 class="tc-stackpanel__title"><?php echo esc_html($group); ?></h3>
                        </div>
                        <ul class="tc-stackpanel__list">
                            <?php foreach ($items as $tech): ?>
                                <li class="tc-stackpanel__item">
                                    <span class="tc-stackpanel__item-ic"><?php echo tc_brand_icon($tech['key'], 22); ?></span>
                                    <span class="tc-stackpanel__item-label"><?php echo esc_html($tech['label']); ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- SECTION: Hands-on projects -->
        <section class="tc-section tc-section--navy tc-tracks tc-reveal">
            <div class="tc-tracks__head">
                <span class="tc-eyebrow">Apply What You Learn</span>
                <h2 class="tc-section__title">Hands-On Projects</h2>
                <p class="tc-muted">Every module connects to practical build work. By graduation, you'll have
                    shipped a portfolio of real AI-powered applications.</p>
            </div>
            <div class="tc-tracks__grid">
                <?php foreach ($tc_projects as $i => $p): ?>
                    <article class="tc-trackcard tc-reveal" style="--delay: <?php echo $i * 90; ?>ms">
                        <div class="tc-trackcard__top">
                            <span class="tc-trackcard__ic tc-feature__ic tc-feature__ic--<?php echo esc_attr($p['color']); ?>"><?php echo tc_icon($p['ic'], 22); ?></span>
                            <span class="tc-trackcard__index"><?php printf('%02d', $i + 1); ?></span>
                        </div>
                        <div class="tc-trackcard__body">
                            <h3 class="tc-trackcard__title"><?php echo esc_html($p['title']); ?></h3>
                            <p class="tc-trackcard__text"><?php echo esc_html($p['text']); ?></p>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- SECTION: What you'll walk away with -->
        <section class="tc-section tc-section--navy tc-eligibility-section tc-reveal">
            <div class="tc-eligibility-card">
                <div class="tc-eligibility-head">
                    <span class="tc-eyebrow">Outcomes</span>
                    <h2 class="tc-section__title">What You'll Walk Away With</h2>
                </div>
                <ul class="tc-eligibility-grid">
                    <?php foreach ($tc_outcomes as $i => $o): ?>
                        <li class="tc-eligibility-item tc-reveal" style="--delay: <?php echo $i * 60; ?>ms">
                            <span class="tc-eligibility-check"><?php echo tc_icon('check', 14); ?></span>
                            <p><?php echo esc_html($o); ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </section>

        <!-- SECTION: Get in touch -->
        <section class="tc-section tc-section--navy tc-reveal">
            <span class="tc-eyebrow">Get In Touch</span>
            <h2 class="tc-section__title">Start Your AI Code Development Journey</h2>
            <div class="tc-contact-grid">
                <div class="tc-contact-card tc-reveal" style="--delay: 0ms">
                    <span class="tc-contact-card__ic tc-feature__ic--blue"><?php echo tc_icon('phone', 22); ?></span>
                    <span class="tc-contact-card__body">
                        <span class="tc-contact-card__label">Call Us</span>
                        <a class="tc-contact-card__value" href="tel:+918143533434">+91 81435 33434</a>
                        <span class="tc-contact-card__meta">Mon–Fri, 10am–7pm</span>
                    </span>
                </div>
                <div class="tc-contact-card tc-reveal" style="--delay: 80ms">
                    <span class="tc-contact-card__ic tc-feature__ic--green"><?php echo tc_icon('whatsapp', 22); ?></span>
                    <span class="tc-contact-card__body">
                        <span class="tc-contact-card__label">WhatsApp</span>
                        <a class="tc-contact-card__value" href="https://wa.me/918143533434" target="_blank"
                            rel="noopener">+91 81435 33434</a>
                    </span>
                </div>
                <div class="tc-contact-card tc-reveal" style="--delay: 160ms">
                    <span class="tc-contact-card__ic tc-feature__ic--violet"><?php echo tc_icon('mail', 22); ?></span>
                    <span class="tc-contact-card__body">
                        <span class="tc-contact-card__label">Email</span>
                        <a class="tc-contact-card__value tc-contact-card__value--long"
                            href="mailto:marketing@visionerpsolutions.com">marketing@visionerpsolutions.com</a>
                    </span>
                </div>
                <div class="tc-contact-card tc-reveal" style="--delay: 240ms">
                    <span class="tc-contact-card__ic tc-feature__ic--amber"><?php echo tc_icon('globe', 22); ?></span>
                    <span class="tc-contact-card__body">
                        <span class="tc-contact-card__label">Website</span>
                        <a class="tc-contact-card__value" href="https://www.visionerpsolutions.com" target="_blank"
                            rel="noopener">visionerpsolutions.com</a>
                    </span>
                </div>
            </div>
            <div class="tc-contact-address tc-reveal" style="--delay: 300ms">
                <span class="tc-contact-address__label">Registered Office</span>
                <p class="tc-contact-address__text">
                    <strong>VisionONE ERP Solutions</strong> — VisionOne Access Private Limited<br>
                    Plot No: 3-225 &amp; 226, 4th Floor, Mahendra Mindspace, Kavuri Hills Phase 2,<br>
                    Madhapur, Hyderabad, Telangana, India – 500033
                </p>
            </div>
        </section>

        <!-- SECTION: Final CTA -->
        <section class="tc-section tc-cta-band text-center tc-reveal">
            <span class="tc-eyebrow">Admissions open</span>
            <h2>Start Your AI Code Development Journey</h2>
            <p class="tc-cta-band__sub">New batches begin every month. Enroll now and our team will confirm your
                batch over email &amp; WhatsApp.</p>
            <div class="tc-cta-band__actions">
                <a class="tc-btn tc-btn--primary" data-magnetic
                    href="<?php echo esc_url(tc_tpl_url('page-apply.php', '/admissions-apply/') . '#tc-apply-form-anchor'); ?>">Enroll
                    for the Next Batch</a>
                <a class="tc-btn tc-btn--ghost"
                            href="<?php echo esc_url(tc_tpl_url('page-fees.php', '/fees-batches/')); ?>">View
                            Curriculum</a>
            </div>
        </section>

    </div>
</div>

<?php get_footer();
