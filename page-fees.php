<?php
/**
 * Template Name: Visioner — Fees & Batches
 *
 * Fee plans (incl. GST), batch schedule, EMI/no-refund policy, Razorpay slot.
 * NOTE: intentionally omits techco_child_page_banner() — the .tc-hero
 * below provides its own breadcrumb + title, mirrors page-apply.php.
 * @package Techco Child
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();

/**
 * CLAUDE CODE: Placeholder fees content — swap every figure/date below for
 * the real numbers from the Visioner deck (slides: Course Fees / Bulk
 * Pricing, Batch Schedule & Timings, Payment Plans & No-Refund Policy)
 * before launch. All amounts already read as GST-inclusive totals.
 */
$tc_plans = array(
	array(
		'name'       => 'Self-Paced',
		'tagline'    => 'Learn on your own schedule, full course access.',
		'total'      => '₹ 39,999',
		'base'       => '₹ 33,898',
		'gst'        => '₹ 6,101 GST (18%)',
		'features'   => array( 'Full curriculum access', 'Project files & assignments', 'Community access', 'Certificate of completion' ),
		'cta'        => 'Enrol Now',
		'recommended'=> false,
	),
	array(
		'name'       => 'Mentor-Led Cohort',
		'tagline'    => 'Live classes with mentors, the most popular path.',
		'total'      => '₹ 64,999',
		'base'       => '₹ 55,084',
		'gst'        => '₹ 9,915 GST (18%)',
		'features'   => array( 'Everything in Self-Paced', 'Live mentor-led sessions', 'Placement & TPO support', '1:1 mentor check-ins', 'Capstone project review' ),
		'cta'        => 'Enrol Now',
		'recommended'=> true,
	),
	array(
		'name'       => 'Bulk / College Batch',
		'tagline'    => 'For colleges enrolling a group of students.',
		'total'      => 'Custom pricing',
		'base'       => 'Volume discount applied',
		'gst'        => 'GST invoice provided',
		'features'   => array( 'Everything in Mentor-Led', 'Dedicated batch & timing', 'TPO progress dashboard', 'On-campus orientation' ),
		'cta'        => 'Talk to Us',
		'recommended'=> false,
	),
);

$tc_batches = array(
	array( 'name' => 'Cohort — July 2026',      'date' => 'Starts 6 Jul 2026',  'mode' => 'Weekday · Online',  'seats' => 'Few seats left' ),
	array( 'name' => 'Cohort — September 2026', 'date' => 'Starts 7 Sep 2026',  'mode' => 'Weekend · Hybrid',  'seats' => 'Open' ),
	array( 'name' => 'Cohort — November 2026',  'date' => 'Starts 2 Nov 2026',  'mode' => 'Weekday · Online',  'seats' => 'Open' ),
);

$tc_emi_plans = array(
	array( 'tenure' => '3 Months',  'amount' => '₹ 21,667 / mo', 'note' => 'No-cost EMI on eligible cards' ),
	array( 'tenure' => '6 Months',  'amount' => '₹ 10,834 / mo', 'note' => 'Standard processing fee applies' ),
	array( 'tenure' => '12 Months', 'amount' => '₹ 5,417 / mo',  'note' => 'Subject to bank approval' ),
);

$tc_faqs = array(
	array( 'q' => 'Are the prices shown inclusive of GST?',          'a' => 'Yes — every total shown above already includes 18% GST. The breakdown under each price is for your reference; there are no extra taxes or convenience fees at checkout.' ),
	array( 'q' => 'Can I pay in EMIs?',                               'a' => 'Yes. EMI tenures of 3, 6 and 12 months are available, including no-cost EMI on select cards. Exact eligibility is shown by your bank at checkout.' ),
	array( 'q' => 'What is the refund policy?',                      'a' => 'Our No-Refund policy applies once a seat is confirmed and payment is received — please review it carefully before paying. We\'re happy to answer questions on a counselling call first.' ),
	array( 'q' => 'Will I get a GST invoice?',                        'a' => 'Yes, a GST-compliant invoice is generated automatically after payment and emailed to you — useful if your employer or college is reimbursing the fee.' ),
	array( 'q' => 'Can I switch my batch after enrolling?',           'a' => 'Yes, one free batch switch is allowed up to 7 days before your cohort starts, subject to seat availability in the new batch.' ),
);
?>

<div id="primary" class="content-area page-content-area tc-page pt-120 pb-120">
	<div class="container">

		<!-- SECTION: Hero -->
		<section class="tc-hero">
			<nav class="tc-hero__crumbs" aria-label="Breadcrumb">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a><span>›</span>
				<span class="tc-hero__crumbs-current">Fees &amp; Batches</span>
			</nav>

			<h1 class="tc-hero__title">Transparent fees. No surprises.</h1>
			<p class="tc-hero__sub">Every price below is final and inclusive of GST. Choose a plan, pick
				a batch that fits your schedule, and pay securely online — in full or in EMIs.</p>

			<div class="tc-hero__stats">
				<div class="tc-stat">
					<strong class="tc-stat__num">18% GST</strong>
					<span class="tc-stat__label">included in every price</span>
				</div>
				<div class="tc-stat tc-stat--divider">
					<strong class="tc-stat__num">3 / 6 / 12 mo</strong>
					<span class="tc-stat__label">EMI tenures available</span>
				</div>
				<div class="tc-stat tc-stat--divider">
					<strong class="tc-stat__num">Zero</strong>
					<span class="tc-stat__label">hidden or convenience fees</span>
				</div>
			</div>
		</section>

		<!-- SECTION: Fee plans -->
		<section class="tc-section tc-fees">
			<span class="tc-eyebrow">Choose a plan</span>
			<h2 class="tc-section__title">Fee Plans</h2>
			<div class="row">
				<?php foreach ( $tc_plans as $plan ) : ?>
				<div class="col-lg-4">
					<div class="tc-price-card <?php echo $plan['recommended'] ? 'tc-price-card--recommended' : ''; ?>">
						<?php if ( $plan['recommended'] ) : ?>
							<span class="tc-price-card__tag">Most Popular</span>
						<?php endif; ?>
						<div class="tc-price-card__header">
							<h3 class="tc-price-card__name"><?php echo esc_html( $plan['name'] ); ?></h3>
							<p class="tc-price-card__tagline tc-muted"><?php echo esc_html( $plan['tagline'] ); ?></p>
						</div>
						<div class="tc-price-card__price">
							<span class="tc-price-card__price-amount"><?php echo esc_html( $plan['total'] ); ?></span>
						</div>
						<p class="tc-price-card__price-breakdown tc-muted">
							<?php echo esc_html( $plan['base'] ); ?> + <?php echo esc_html( $plan['gst'] ); ?>
						</p>
						<ul class="tc-checklist tc-price-card__features">
							<?php foreach ( $plan['features'] as $feature ) : ?>
								<li><?php echo esc_html( $feature ); ?></li>
							<?php endforeach; ?>
						</ul>
						<a class="tc-btn <?php echo $plan['recommended'] ? 'tc-btn--primary' : 'tc-btn--outline'; ?> tc-btn--block"
						   href="<?php echo esc_url( $plan['cta'] === 'Talk to Us' ? tc_tpl_url( 'page-colleges.php', '/for-colleges/' ) : tc_tpl_url( 'page-apply.php', '/admissions-apply/' ) ); ?>">
							<?php echo esc_html( $plan['cta'] ); ?>
						</a>
					</div>
				</div>
				<?php endforeach; ?>
			</div>

			<p class="tc-gst-note">
				<svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M9 12l2 2 4-4M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
				All prices shown include 18% GST. No convenience fees, ever.
			</p>
		</section>

		<!-- SECTION: Batch schedule -->
		<section class="tc-section tc-batches-section">
			<span class="tc-eyebrow">Plan ahead</span>
			<h2 class="tc-section__title">Batch Schedule &amp; Timings</h2>
			<p class="tc-muted tc-placeholder-note">*Dates shown are indicative — confirm before publishing.</p>
			<div class="tc-batches">
				<?php foreach ( $tc_batches as $b ) : ?>
				<div class="tc-batch-row">
					<div class="tc-batch-row__main">
						<h3 class="tc-batch-row__name"><?php echo esc_html( $b['name'] ); ?></h3>
						<span class="tc-muted"><?php echo esc_html( $b['date'] ); ?> · <?php echo esc_html( $b['mode'] ); ?></span>
					</div>
					<span class="tc-seats-badge"><?php echo esc_html( $b['seats'] ); ?></span>
				</div>
				<?php endforeach; ?>
			</div>
		</section>

		<!-- SECTION: EMI plans + refund policy -->
		<section class="tc-section tc-emi-section">
			<span class="tc-eyebrow">Pay your way</span>
			<h2 class="tc-section__title">EMI &amp; Payment Plans</h2>
			<div class="row">
				<div class="col-lg-7">
					<div class="tc-emi-grid">
						<?php foreach ( $tc_emi_plans as $emi ) : ?>
						<div class="tc-emi-card">
							<strong class="tc-emi-card__tenure"><?php echo esc_html( $emi['tenure'] ); ?></strong>
							<span class="tc-emi-card__amount"><?php echo esc_html( $emi['amount'] ); ?></span>
							<span class="tc-emi-card__note tc-muted"><?php echo esc_html( $emi['note'] ); ?></span>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
				<div class="col-lg-5">
					<div class="tc-refund-card">
						<h3>No-Refund Policy</h3>
						<!-- CLAUDE CODE: replace with the exact policy wording from slide 7. -->
						<p class="tc-muted">Once a seat is confirmed and payment is received, fees are
							non-refundable. We strongly encourage a free counselling call before you
							enrol so you're confident in the programme, batch and payment plan.</p>
					</div>
				</div>
			</div>
		</section>

		<!-- SECTION: Pay online -->
		<section class="tc-section tc-payment">
			<span class="tc-eyebrow">Checkout</span>
			<h2 class="tc-section__title">Pay Online</h2>
			<div class="tc-payment-card">
				<div class="tc-payment-card__head">
					<svg class="tc-payment-card__icon" viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M12 2l8 4v6c0 5-3.5 8.5-8 10-4.5-1.5-8-5-8-10V6l8-4z"/><path d="M9 12l2 2 4-4"/></svg>
					<div>
						<h3>Secure payment via Razorpay</h3>
						<p class="tc-muted">Cards, UPI, netbanking and EMI — all PCI-DSS compliant.</p>
					</div>
				</div>

				<div class="tc-razorpay-slot">
					<!-- CLAUDE CODE / KUWAYA: paste the Razorpay Payment Button snippet here.
					     Razorpay Dashboard → Payment Button → Generate → copy the <form>…<script> block.
					     It is a hosted button; no server code needed. Keep the live key on live only. -->
					<p class="tc-placeholder-note">[ Razorpay Payment Button goes here ]</p>
				</div>
			</div>
		</section>

		<!-- SECTION: FAQ -->
		<section class="tc-section tc-faq-section">
			<span class="tc-eyebrow">Questions</span>
			<h2 class="tc-section__title">Frequently asked questions</h2>
			<div class="tc-faq">
				<?php foreach ( $tc_faqs as $faq ) : ?>
				<details class="tc-faq__item">
					<summary class="tc-faq__q"><?php echo esc_html( $faq['q'] ); ?></summary>
					<p class="tc-faq__a tc-muted"><?php echo wp_kses_post( $faq['a'] ); ?></p>
				</details>
				<?php endforeach; ?>
			</div>
		</section>

		<!-- SECTION: CTA -->
		<section class="tc-section tc-cta-band text-center">
			<h2>Ready to lock your seat?</h2>
			<p class="tc-cta-band__sub">Apply now and our team will help you pick the right plan and
				batch — then confirm everything over email &amp; WhatsApp within 24 hours.</p>
			<div class="tc-cta-band__actions">
				<a class="tc-btn tc-btn--primary" href="<?php echo esc_url( tc_tpl_url( 'page-apply.php', '/admissions-apply/' ) ); ?>">Apply Now</a>
				<a class="tc-btn tc-btn--ghost" href="<?php echo esc_url( tc_tpl_url( 'page-program.php', '/program-curriculum/' ) ); ?>">View Curriculum</a>
			</div>
		</section>

	</div>
</div>

<?php get_footer();
