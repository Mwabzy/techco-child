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

// Hero highlight tags.
$tc_hero_tags = array('AI-Assisted Coding', 'Automation', 'Real Projects', 'Career Growth');

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

// "Hands-On Projects" — portfolio builds shipped during the program.
$tc_projects = array(
    array('ic' => 'chat', 'color' => 'blue', 'title' => 'AI Chatbot', 'text' => 'Conversational assistant built with LLM integration.'),
    array('ic' => 'receipt', 'color' => 'blue', 'title' => 'AI Resume Analyzer', 'text' => 'Parses and scores resumes using AI-driven analysis.'),
    array('ic' => 'code', 'color' => 'blue', 'title' => 'Code Generation Assistant', 'text' => 'Tool that generates and explains boilerplate code.'),
    array('ic' => 'check', 'color' => 'green', 'title' => 'Automated Testing Tool', 'text' => 'AI-assisted test case generation and execution.'),
    array('ic' => 'sliders', 'color' => 'blue', 'title' => 'Business Automation Workflow', 'text' => 'End-to-end workflow automation using AI agents.'),
    array('ic' => 'globe', 'color' => 'blue', 'title' => 'AI-Integrated Web Application', 'text' => 'Full-stack app with embedded AI capabilities.'),
);
$tc_project_outcomes = array(
    'Use AI coding tools effectively',
    'Integrate AI APIs into real systems',
    'Create a portfolio of AI projects',
    'Build AI-powered applications',
    'Automate development tasks',
    'Apply for AI developer roles with confidence',
);

// Enquiry form — same WhatsApp line as the nav/floating widget.
$tc_enquiry_wa_number = apply_filters('techco_child_wa_number', '918143533434');
$tc_enquiry_wa_msg = apply_filters('techco_child_wa_message', 'Hi VisionONE, I\'d like to know more about the AI Code Development program.');
$tc_enquiry_wa_url = $tc_enquiry_wa_number ? 'https://wa.me/' . rawurlencode($tc_enquiry_wa_number) . '?text=' . rawurlencode($tc_enquiry_wa_msg) : '#';

// Next 6 months, for the "Preferred Batch Month" dropdown.
$tc_batch_months = array();
for ($m = 0; $m < 6; $m++) {
    $tc_batch_months[] = date_i18n('F Y', strtotime("+{$m} month"));
}
?>

<div id="primary" class="content-area page-content-area tc-page tc-home">
    <div class="container">

        <!-- SECTION: Hero (dark navy — program overview + at-a-glance card) -->
        <section class="tc-hero tc-home__hero tc-section--dark">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <span class="tc-eyebrow">Career-Ready Training Program</span>
                    <h1 class="tc-hero__title">AI Code <span class="tc-text-accent">Development</span>
                        Training Program</h1>
                    <p class="tc-hero__sub">Build the future of software with Artificial
                        Intelligence. Learn AI-assisted coding, automation, and real project delivery — the way
                        modern development teams work today.</p>

                    <div class="tc-home__hero-actions">
                        <a class="tc-btn tc-btn--primary" data-magnetic href="#tc-enquiry">Enroll
                            for the Next Batch</a>
                        <a class="tc-btn tc-btn--ghost" href="#tc-curriculum">View
                            Curriculum</a>
                    </div>

                    <!-- Highlight tags -->
                    <ul class="tc-hero__tags">
                        <?php foreach ($tc_hero_tags as $tag): ?>
                            <li class="tc-hero__tag"><?php echo esc_html($tag); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="col-lg-5">
                    <!-- Program at a glance -->
                    <div class="tc-glance">
                        <span class="tc-glance__eyebrow">Program at a Glance</span>
                        <dl class="tc-glance__list">
                            <?php foreach ($tc_glance as $row): ?>
                                <div class="tc-glance__row">
                                    <dt><?php echo esc_html($row['label']); ?></dt>
                                    <dd><?php echo esc_html($row['value']); ?></dd>
                                </div>
                            <?php endforeach; ?>
                        </dl>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION: Why AI Code Development Matters -->
        <section id="tc-why" class="tc-section tc-services tc-reveal tc-section--dark">
            <span class="tc-eyebrow">The Shift</span>
            <h2 class="tc-section__title">Why AI Code Development Matters</h2>
            <p class="tc-muted" style="max-width: 640px;">Software development is being rebuilt around AI.
                Developers who pair human judgment with AI-powered tools ship features faster, with fewer bugs,
                and at a scale that was impossible just a few years ago.</p>
            <div class="tc-services__grid tc-services__grid--dark">
                <?php foreach ($tc_shift as $i => $f): ?>
                    <article class="tc-darkcard tc-reveal" style="--delay: <?php echo $i * 80; ?>ms">
                        <span class="tc-servicecard__ic tc-servicecard__ic--<?php echo esc_attr($f['color']); ?>"><?php echo tc_icon($f['ic'], 24); ?></span>
                        <h3 class="tc-darkcard__title"><?php echo esc_html($f['title']); ?></h3>
                        <p class="tc-darkcard__text"><?php echo wp_kses_post($f['text']); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- SECTION: Career scope & job opportunities -->
        <section id="tc-careers" class="tc-section tc-section--dark tc-reveal">
            <span class="tc-eyebrow">Career Scope</span>
            <h2 class="tc-section__title">Career Scope &amp; Job Opportunities</h2>
            <p class="tc-muted" style="max-width: 720px;">Demand for developers who can build with AI is climbing
                across every sector. This program prepares you for roles such as:</p>

            <h3 class="tc-career__subhead">Roles You Can Target</h3>
            <ul class="tc-pillrow">
                <?php foreach ($tc_roles as $role): ?>
                    <li class="tc-pill tc-pill--accent"><?php echo esc_html($role); ?></li>
                <?php endforeach; ?>
            </ul>

            <h3 class="tc-career__subhead">Opportunities Across Industries</h3>
            <ul class="tc-pillrow">
                <?php foreach ($tc_industries as $ind): ?>
                    <li class="tc-pill"><?php echo esc_html($ind); ?></li>
                <?php endforeach; ?>
            </ul>

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

        <!-- SECTION: Course Syllabus — 10 Modules -->
        <section id="tc-curriculum" class="tc-section tc-syllabus tc-reveal tc-section--dark">
            <span class="tc-eyebrow">Curriculum</span>
            <h2 class="tc-section__title">Course Syllabus — 10 Modules</h2>
            <p class="tc-muted">A structured path from programming fundamentals to shipping real AI-powered
                applications.</p>
            <div class="tc-modgrid">
                <?php foreach ($tc_modules as $i => $mod): ?>
                    <div class="tc-modcard tc-reveal" style="--delay: <?php echo $i * 60; ?>ms">
                        <span class="tc-modcard__badge"><?php echo esc_html(sprintf('%02d', $i + 1)); ?></span>
                        <div class="tc-modcard__body">
                            <span class="tc-modcard__eyebrow">Module <?php echo (int) ($i + 1); ?></span>
                            <h3 class="tc-modcard__title"><?php echo esc_html($mod); ?></h3>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- SECTION: Tools & Technologies You'll Use — grouped pill lists -->
        <section id="tc-stack" class="tc-section tc-toolstack tc-reveal tc-section--dark">
            <span class="tc-eyebrow">Hands-On Stack</span>
            <h2 class="tc-section__title">Tools &amp; Technologies You'll Use</h2>
            <p class="tc-muted" style="max-width: 640px;">You'll work with the same AI tools, languages, and
                platforms that modern development teams use every day — applied on real project work, not just
                slides.</p>
            <?php foreach ($tc_stack_groups as $group_label => $items): ?>
                <h3 class="tc-career__subhead"><?php echo esc_html($group_label); ?></h3>
                <ul class="tc-pillrow">
                    <?php foreach ($items as $tech): ?>
                        <li class="tc-pill"><?php echo esc_html($tech['label']); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endforeach; ?>
            <div class="tc-toolstack__cta">
                <a class="tc-btn tc-btn--outline" href="#tc-curriculum">See the full curriculum</a>
            </div>
        </section>

        <!-- SECTION: Hands-On Projects -->
        <section id="tc-tracks" class="tc-section tc-projects tc-reveal tc-section--dark">
            <span class="tc-eyebrow">Apply What You Learn</span>
            <h2 class="tc-section__title">Hands-On Projects</h2>
            <p class="tc-muted" style="max-width: 640px;">Every module connects to practical build work. By
                graduation, you'll have shipped a portfolio of real AI-powered applications.</p>

            <div class="tc-services__grid tc-services__grid--dark">
                <?php foreach ($tc_projects as $i => $p): ?>
                    <article class="tc-darkcard tc-reveal" style="--delay: <?php echo $i * 70; ?>ms">
                        <span class="tc-servicecard__ic tc-servicecard__ic--<?php echo esc_attr($p['color']); ?>"><?php echo tc_icon($p['ic'], 24); ?></span>
                        <h3 class="tc-darkcard__title"><?php echo esc_html($p['title']); ?></h3>
                        <p class="tc-darkcard__text"><?php echo esc_html($p['text']); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>

            <h3 class="tc-career__subhead">What You'll Walk Away With</h3>
            <ul class="tc-checklist">
                <?php foreach ($tc_project_outcomes as $item): ?>
                    <li><span class="tc-checklist__ic"><?php echo tc_icon('check', 13); ?></span><?php echo esc_html($item); ?></li>
                <?php endforeach; ?>
            </ul>
        </section>

        <!-- SECTION: Enquiry — batch enquiry form -->
        <section id="tc-enquiry" class="tc-section tc-enquiry-section tc-reveal tc-section--dark">
            <span class="tc-eyebrow">Enrollment</span>
            <h2 class="tc-section__title">Batch Enquiry</h2>
            <p class="tc-muted" style="max-width: 640px;">New batches begin every month at our Hyderabad campus.
                Share a few details and our team will get back to you with batch and admission information.</p>

            <div class="tc-enquirycard">
                <h3 class="tc-enquirycard__title">Enquire About This Course</h3>
                <p class="tc-enquirycard__sub">Fill in a few details and our team will contact you with batch and
                    admission information.</p>

                <?php
                // Batch Enquiry form — Fluent Forms embed (mirrors the Apply/TPO forms in
                // page-apply.php / page-colleges.php). The acknowledgement/confirmation shown
                // after submit is configured per-form in wp-admin → Fluent Forms →
                // Settings → Confirmations. Submissions sync to the Google Sheet
                // automatically via inc/google-sheets-sync.php.
                // NOTE: id="3" follows Apply=1 / TPO=2. Confirm/replace with the real
                // "Batch Enquiry" form ID from wp-admin → Fluent Forms.
                if (function_exists('do_shortcode')) {
                    echo do_shortcode('[fluentform id="7"]');
                }
                ?>
                <a class="tc-enquiryform__wa" href="<?php echo esc_url($tc_enquiry_wa_url); ?>" target="_blank"
                    rel="noopener nofollow">
                    <svg viewBox="0 0 32 32" width="16" height="16" aria-hidden="true" focusable="false">
                        <path fill="currentColor"
                            d="M16.04 3.2c-7.1 0-12.86 5.76-12.86 12.86 0 2.27.6 4.49 1.73 6.44L3.2 28.8l6.49-1.7a12.8 12.8 0 0 0 6.35 1.62h.01c7.1 0 12.86-5.76 12.86-12.86S23.14 3.2 16.04 3.2zm0 23.5h-.01a10.6 10.6 0 0 1-5.4-1.48l-.39-.23-3.85 1.01 1.03-3.75-.25-.39a10.62 10.62 0 1 1 19.72-5.6c0 5.87-4.78 10.65-10.65 10.65zm6.16-7.97c-.34-.17-2-.99-2.31-1.1-.31-.11-.54-.17-.76.17-.22.34-.87 1.1-1.07 1.32-.2.23-.39.25-.73.08-.34-.17-1.43-.53-2.72-1.68-1-.9-1.68-2-1.88-2.34-.2-.34-.02-.52.15-.69.15-.15.34-.39.51-.59.17-.2.22-.34.34-.57.11-.23.06-.43-.03-.6-.08-.17-.76-1.84-1.05-2.52-.27-.66-.55-.57-.76-.58l-.65-.01c-.22 0-.59.08-.9.43-.31.34-1.18 1.16-1.18 2.82s1.21 3.27 1.38 3.5c.17.23 2.38 3.64 5.77 5.1.81.35 1.43.56 1.92.71.81.26 1.54.22 2.12.13.65-.1 2-.82 2.28-1.6.28-.79.28-1.46.2-1.6-.08-.14-.31-.23-.65-.4z" />
                    </svg>
                    Prefer WhatsApp? Chat with us instead
                </a>
            </div>
        </section>

    </div>
</div>

<?php get_footer();
