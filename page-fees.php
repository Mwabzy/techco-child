<?php
/**
 * Template Name: visionONE — Fees & Batches
 *
 * Fee plans (+ GST), batch schedule, no-refund policy, Razorpay slot.
 * NOTE: intentionally omits techco_child_page_banner() — the .tc-hero
 * below provides its own breadcrumb + title, mirrors page-apply.php.
 * @package Techco Child
 */

if (!defined('ABSPATH')) {
	exit;
}

get_header();

/**
 * CLAUDE CODE: Placeholder fees content — swap every figure/date below for
 * the real numbers from the Visioner deck (slides: Course Fees / Bulk
 * Pricing, Batch Schedule & Timings, No-Refund Policy) before launch.
 * Amounts shown are BASE prices (ex-GST). GST (18%) is added at checkout.
 *
 * One card per program track (mirrors the exit points on page-program.php's
 * "Choose your track" section), each mentor-led and priced on its own.
 */
/**
 * Pricing (name/weeks/base) is sourced from inc/pricing.php — the single
 * source of truth shared with page-payment.php and the CRM. Only the
 * presentation-only fields (tagline/features/cta/recommended) live here.
 */
$tc_plan_extras = array(
	'core' => array(
		'tagline' => 'Angular, .NET, SQL Server and a Mini-ERP capstone.',
		'features' => array('Angular 18 + .NET 8 Web API', 'SQL Server data layer', 'Auth, security & REST', 'Mini-ERP build + capstone', 'Placement & TPO support'),
		'cta' => 'Enrol Now',
		'recommended' => false,
	),
	'core-cloud' => array(
		'tagline' => 'Everything in Core, deployed live on AWS & Azure.',
		'features' => array('Everything in Core Program', 'AWS & Azure fundamentals', 'CI/CD pipelines', 'Live cloud deployment', 'Placement & TPO support'),
		'cta' => 'Enrol Now',
		'recommended' => false,
	),
	'core-genai' => array(
		'tagline' => 'Core plus LLM APIs and agentic workflows.',
		'features' => array('Everything in Core Program', 'LLM APIs & prompt engineering', 'Agentic AI features', 'Real-world AI project', 'Placement & TPO support'),
		'cta' => 'Enrol Now',
		'recommended' => false,
	),
	'bundle' => array(
		'tagline' => 'Full stack + Cloud + GenAI + Agentic AI — our flagship track.',
		'features' => array('Everything in every track above', 'Cloud, GenAI & Agentic AI combined', 'Capstone + portfolio review', '1:1 mentor check-ins', 'Placement & TPO support'),
		'cta' => 'Enrol Now',
		'recommended' => true,
	),
);

$tc_plans = array_map(function ($plan) use ($tc_plan_extras) {
	$extra = $tc_plan_extras[$plan['id']] ?? array();
	return array_merge(array(
		'name' => $plan['name'],
		'weeks' => $plan['weeks'],
		'base' => '₹ ' . number_format($plan['base']),
	), $extra);
}, tc_program_pricing());

$tc_bulk_plan = array(
	'name' => 'Bulk / College Batch',
	'tagline' => 'Custom pricing for colleges enrolling a group of students, on any track above.',
	'features' => array('Volume discount applied', 'Dedicated batch & timing', 'TPO progress dashboard', 'On-campus orientation', 'GST invoice provided'),
);

$tc_batches = array(
	array('name' => 'Cohort — July 2026', 'date' => 'Starts 6 Jul 2026', 'mode' => 'Weekday · Online', 'seats' => 'Few seats left'),
	array('name' => 'Cohort — September 2026', 'date' => 'Starts 7 Sep 2026', 'mode' => 'Weekend · Hybrid', 'seats' => 'Open'),
	array('name' => 'Cohort — November 2026', 'date' => 'Starts 2 Nov 2026', 'mode' => 'Weekday · Online', 'seats' => 'Open'),
);

$tc_faqs = array(
	array('q' => 'Are the prices shown inclusive of GST?', 'a' => 'No — every price shown is the base amount (exclusive of GST). GST at 18% will be calculated and added at checkout. A GST-compliant invoice is generated automatically after payment and emailed to you.'),
	array('q' => 'What is the refund policy?', 'a' => 'Our No-Refund policy applies once a seat is confirmed and payment is received — please review it carefully before paying. We\'re happy to answer questions on a counselling call first.'),
	array('q' => 'Will I get a GST invoice?', 'a' => 'Yes, a GST-compliant invoice is generated automatically after payment and emailed to you — useful if your employer or college is reimbursing the fee.'),
	array('q' => 'Can I switch my batch after enrolling?', 'a' => 'Yes, one free batch switch is allowed up to 7 days before your cohort starts, subject to seat availability in the new batch.'),
);
?>

<div id="primary" class="content-area page-content-area tc-page pt-120 pb-120">
	<div class="container">

		<!-- SECTION: Hero — gradient banner (consistent with the program page) -->
		<nav class="tc-hero__crumbs tc-coursebanner__crumbs" aria-label="Breadcrumb">
			<a href="<?php echo esc_url(home_url('/')); ?>">Home</a><span>›</span>
			<span class="tc-hero__crumbs-current">Fees &amp; Batches</span>
		</nav>

		<section class="tc-coursebanner tc-coursebanner--simple tc-reveal">
			<span class="tc-coursebanner__bg" data-parallax="10" aria-hidden="true"></span>
			<div class="tc-coursebanner__inner">
				<div class="tc-coursebanner__content" data-motion-in>
					<span class="tc-coursebanner__kicker">Fees &amp; Batches</span>
					<h1 class="tc-coursebanner__title">Transparent fees. No surprises.</h1>
					<p class="tc-coursebanner__desc">All prices are base amounts — GST (18%) is added at checkout.
						Choose a plan, pick a batch that fits your schedule, and pay securely online.</p>
					<div class="tc-coursebanner__stats">
						<span class="tc-herostat"><strong>+ GST</strong><span>18% added at checkout</span></span>
						<span class="tc-herostat"><strong>GST Invoice</strong><span>sent automatically</span></span>
						<span class="tc-herostat"><strong>Zero</strong><span>hidden or convenience fees</span></span>
					</div>
				</div>
			</div>
		</section>

		<!-- SECTION: Fee plans -->
		<section class="tc-section tc-fees tc-reveal">
			<span class="tc-eyebrow">Choose your track</span>
			<h2 class="tc-section__title">Fee Plans — Per Program</h2>
			<p class="tc-muted tc-fees__lead">Core is the 10-week spine — bolt on Cloud and AI, or take the
				Complete Bundle. All prices are base amounts (ex-GST). GST at 18% is added at checkout.</p>
			<?php // Per-track colour accent (blue / violet / amber / green). ?>
			<?php $tc_plan_accents = array('#2496ED', '#6D4AE0', '#C77700', '#0E9F6E'); ?>
			<div class="row tc-fees__grid">
				<?php foreach ($tc_plans as $i => $plan): ?>
					<div class="col-lg-3 col-md-6 tc-reveal" style="--delay: <?php echo $i * 120; ?>ms">
						<div class="tc-price-card <?php echo $plan['recommended'] ? 'tc-price-card--recommended' : ''; ?>"
							data-tilt style="--accent: <?php echo esc_attr($tc_plan_accents[$i % 4]); ?>;">
							<?php if ($plan['recommended']): ?>
								<span class="tc-price-card__tag">Most Popular</span>
							<?php endif; ?>
							<span class="tc-price-card__weeks"><?php echo esc_html($plan['weeks']); ?></span>
							<div class="tc-price-card__header">
								<h3 class="tc-price-card__name"><?php echo esc_html($plan['name']); ?></h3>
								<p class="tc-price-card__tagline tc-muted"><?php echo esc_html($plan['tagline']); ?></p>
							</div>
							<div class="tc-price-card__price">
								<span class="tc-price-card__price-amount"><?php echo esc_html($plan['base']); ?></span>
							</div>
							<p class="tc-price-card__price-breakdown tc-muted">
								+ GST (18%)
							</p>
							<ul class="tc-checklist tc-price-card__features">
								<?php foreach ($plan['features'] as $feature): ?>
									<li><?php echo esc_html($feature); ?></li>
								<?php endforeach; ?>
							</ul>
							<a class="tc-btn <?php echo $plan['recommended'] ? 'tc-btn--primary' : 'tc-btn--outline'; ?> tc-btn--block"
								href="<?php echo esc_url(tc_tpl_url('page-apply.php', '/admissions-apply/') . '#tc-apply-form-anchor'); ?>">
								<?php echo esc_html($plan['cta']); ?>
							</a>
						</div>
					</div>
				<?php endforeach; ?>
			</div>

			<p class="tc-gst-note">
				<svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"
					aria-hidden="true">
					<path d="M9 12l2 2 4-4M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
				</svg>
				All prices are base amounts (ex-GST). GST at 18% is added at checkout. No convenience fees, ever.
			</p>

			<!-- Bulk / college pricing banner -->
			<div class="tc-bulk-banner tc-reveal">
				<div class="tc-bulk-banner__text">
					<h3><?php echo esc_html($tc_bulk_plan['name']); ?></h3>
					<p class="tc-muted"><?php echo esc_html($tc_bulk_plan['tagline']); ?></p>
					<ul class="tc-bulk-banner__features">
						<?php foreach ($tc_bulk_plan['features'] as $feature): ?>
							<li><?php echo esc_html($feature); ?></li>
						<?php endforeach; ?>
					</ul>
				</div>
				<a class="tc-btn tc-btn--outline tc-bulk-banner__cta"
					href="<?php echo esc_url(tc_tpl_url('page-colleges.php', '/for-colleges/')); ?>">Talk to Us</a>
			</div>
		</section>

		<!-- SECTION: Batch schedule -->
		<section class="tc-section tc-section--tint tc-batches-section tc-reveal">
			<span class="tc-eyebrow">Plan ahead</span>
			<h2 class="tc-section__title">Batch Schedule &amp; Timings</h2>
			<p class="tc-muted tc-placeholder-note">Dates shown are indicative — confirm before publishing.</p>
			<div class="tc-batches">
				<?php foreach ($tc_batches as $i => $b): ?>
					<div class="tc-batch-row tc-reveal" style="--delay: <?php echo $i * 100; ?>ms">
						<div class="tc-batch-row__main">
							<h3 class="tc-batch-row__name"><?php echo esc_html($b['name']); ?></h3>
							<span class="tc-muted"><?php echo esc_html($b['date']); ?> ·
								<?php echo esc_html($b['mode']); ?></span>
						</div>
						<span
							class="tc-seats-badge<?php echo ($b['seats'] === 'Few seats left') ? ' tc-seats-badge--urgent' : ''; ?>"><?php echo esc_html($b['seats']); ?></span>
					</div>
				<?php endforeach; ?>
			</div>
		</section>

		<!-- SECTION: No-Refund Policy -->
		<section class="tc-section tc-refund-section tc-reveal">
			<div class="tc-refund-card tc-refund-card--standalone tc-reveal">
				<div class="tc-refund-card__icon" aria-hidden="true">
					<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor"
						stroke-width="1.8">
						<path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
						<line x1="12" y1="9" x2="12" y2="13" />
						<line x1="12" y1="17" x2="12.01" y2="17" />
					</svg>
				</div>
				<div class="tc-refund-card__body">
					<h3>No-Refund Policy</h3>
					<!-- CLAUDE CODE: replace with the exact policy wording from slide 7. -->
					<p class="tc-muted">Once a seat is confirmed and payment is received, fees are
						non-refundable. We strongly encourage a free counselling call before you
						enrol so you're confident in the programme, batch and payment plan.</p>
				</div>
			</div>
		</section>

		<!-- SECTION: Pay online -->
		<section class="tc-section tc-payment tc-reveal">
			<span class="tc-eyebrow">Checkout</span>
			<h2 class="tc-section__title">Pay Online</h2>
			<div class="tc-payment-card">
				<div class="tc-payment-card__head">
					<svg class="tc-payment-card__icon" viewBox="0 0 24 24" width="22" height="22" fill="none"
						stroke="currentColor" stroke-width="2" aria-hidden="true">
						<path d="M12 2l8 4v6c0 5-3.5 8.5-8 10-4.5-1.5-8-5-8-10V6l8-4z" />
						<path d="M9 12l2 2 4-4" />
					</svg>
					<div>
						<h3>Secure payment via Razorpay</h3>
						<p class="tc-muted">Cards, UPI and netbanking — all PCI-DSS compliant.</p>
					</div>
				</div>

				<!-- Trust badges -->
				<div class="tc-trust-badges">
					<div class="tc-trust-badge">
						<span class="tc-trust-badge__icon" aria-hidden="true">
							<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor"
								stroke-width="1.8">
								<path d="M12 2l8 4v6c0 5-3.5 8.5-8 10-4.5-1.5-8-5-8-10V6l8-4z" />
							</svg>
						</span>
						<span>Secure</span>
					</div>
					<div class="tc-trust-badge">
						<span class="tc-trust-badge__icon" aria-hidden="true">
							<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor"
								stroke-width="1.8">
								<rect x="3" y="11" width="18" height="11" rx="2" />
								<path d="M7 11V7a5 5 0 0110 0v4" />
							</svg>
						</span>
						<span>Encrypted</span>
					</div>
					<div class="tc-trust-badge">
						<span class="tc-trust-badge__icon" aria-hidden="true">
							<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor"
								stroke-width="1.8">
								<path d="M9 12l2 2 4-4" />
								<circle cx="12" cy="12" r="10" />
							</svg>
						</span>
						<span>PCI-DSS</span>
					</div>
					<div class="tc-trust-badge">
						<span class="tc-trust-badge__icon" aria-hidden="true">
							<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor"
								stroke-width="1.8">
								<rect x="1" y="4" width="22" height="16" rx="2" />
								<path d="M1 10h22" />
							</svg>
						</span>
						<span>GST Invoice</span>
					</div>
				</div>
			</div>
		</section>

		<!-- SECTION: FAQ -->
		<section class="tc-section tc-section--tint tc-faq-section tc-reveal">
			<span class="tc-eyebrow">Questions</span>
			<h2 class="tc-section__title">Frequently asked questions</h2>
			<div class="tc-faq">
				<?php foreach ($tc_faqs as $i => $faq): ?>
					<details class="tc-faq__item tc-reveal" style="--delay: <?php echo $i * 80; ?>ms">
						<summary class="tc-faq__q"><?php echo esc_html($faq['q']); ?></summary>
						<div class="tc-faq__body">
							<div class="tc-faq__body-inner">
								<p class="tc-faq__a tc-muted"><?php echo wp_kses_post($faq['a']); ?></p>
							</div>
						</div>
					</details>
				<?php endforeach; ?>
			</div>
		</section>

		<!-- SECTION: CTA -->
		<section class="tc-section tc-cta-band text-center tc-reveal">
			<!-- Ambient glow orbs -->
			<div class="tc-glow-orb tc-glow-orb--blue" aria-hidden="true"></div>
			<div class="tc-glow-orb tc-glow-orb--orange" aria-hidden="true"></div>

			<h2>Ready to lock your seat?</h2>
			<p class="tc-cta-band__sub">Apply now and our team will help you pick the right plan and
				batch — then confirm everything over email &amp; WhatsApp within 24 hours.</p>
			<div class="tc-cta-band__actions">
				<a class="tc-btn tc-btn--primary"
					href="<?php echo esc_url(tc_tpl_url('page-apply.php', '/admissions-apply/') . '#tc-apply-form-anchor'); ?>">Apply Now</a>
				<a class="tc-btn tc-btn--ghost"
					href="<?php echo esc_url(tc_tpl_url('page-program.php', '/program-curriculum/')); ?>">View
					Curriculum</a>
			</div>
		</section>

	</div>
</div>

<?php get_footer();
