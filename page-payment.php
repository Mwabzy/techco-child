<?php
/**
 * Template Name: VisionONE — Payment
 *
 * Dedicated payment page: program selector, live fee summary (base + GST),
 * trust badges and no-refund notice.
 * NOTE: intentionally omits techco_child_page_banner() — the .tc-hero
 * below provides its own breadcrumb + title, mirrors other Visioner pages.
 * @package Techco Child
 */

if (!defined('ABSPATH')) {
	exit;
}

get_header();

/**
 * Program tracks — base prices (ex-GST) sourced from inc/pricing.php, the
 * single source of truth shared with page-fees.php and the CRM. Only the
 * presentation-only fields (features) live here.
 */
$tc_pay_plan_extras = array(
	'core' => array(
		'features' => array('Angular 18 + .NET 8 Web API', 'SQL Server data layer', 'Mini-ERP capstone', 'Placement & TPO support'),
	),
	'core-cloud' => array(
		'features' => array('Everything in Core Program', 'AWS & Azure fundamentals', 'CI/CD & live cloud deployment', 'Placement & TPO support'),
	),
	'core-genai' => array(
		'features' => array('Everything in Core Program', 'LLM APIs & prompt engineering', 'Agentic AI features', 'Placement & TPO support'),
	),
	'bundle' => array(
		'features' => array('All tracks combined', 'Cloud, GenAI & Agentic AI', 'Capstone + portfolio review', '1:1 mentor check-ins', 'Placement & TPO support'),
	),
);

$tc_pay_plans = array_map(function ($plan) use ($tc_pay_plan_extras) {
	$extra = $tc_pay_plan_extras[$plan['id']] ?? array();
	return array_merge(array(
		'id' => $plan['id'],
		'name' => $plan['name'],
		'weeks' => $plan['weeks'],
		'base' => '₹ ' . number_format($plan['base']),
		'base_raw' => $plan['base'],
		'gst_rate' => $plan['gst_rate'],
	), $extra);
}, tc_program_pricing());

$tc_pay_faqs = array(
	array('q' => 'Is GST included in the price?', 'a' => 'No — all prices shown are base amounts (ex-GST). GST at 18% is added at checkout. You will see the full breakdown before you pay.'),
	array('q' => 'Will I receive a GST invoice?', 'a' => 'Yes — a GST-compliant tax invoice is automatically emailed to you after successful payment, useful for employer or college reimbursement.'),
	array('q' => 'What is the refund policy?', 'a' => 'Our No-Refund policy applies once a seat is confirmed and payment is received. Please review it carefully before paying. We\'re happy to answer questions on a counselling call first.'),
	array('q' => 'Which payment methods are accepted?', 'a' => 'All major debit/credit cards, UPI (PhonePe, GPay, Paytm), internet banking, or a direct bank transfer (NEFT/RTGS/IMPS) are accepted.'),
);

/**
 * Bank account for direct NEFT/RTGS/IMPS transfers — same legal entity as
 * $tc_org in page-colleges.php / tc_terms_org_details() in inc/legal-content.php.
 */
$tc_bank_details = array(
	'account_name' => 'VisionOne Access Private Limited',
	'account_number' => '409849432034',
	'ifsc' => 'RATN0000331',
	'bank' => 'RBL Bank',
	'branch' => 'Jubilee Hills, Hyderabad',
);
$tc_bank_rows = array(
	array('label' => 'Account name', 'value' => $tc_bank_details['account_name'], 'copy' => false),
	array('label' => 'Account number', 'value' => $tc_bank_details['account_number'], 'copy' => true),
	array('label' => 'IFSC code', 'value' => $tc_bank_details['ifsc'], 'copy' => true),
	array('label' => 'Bank & branch', 'value' => $tc_bank_details['bank'] . ', ' . $tc_bank_details['branch'], 'copy' => false),
);
?>

<div id="primary" class="content-area page-content-area tc-page tc-payment-page pt-120 pb-120">
	<div class="container">

		<!-- SECTION: Hero -->
		<section class="tc-hero tc-texture-dots tc-reveal">
			<!-- Ambient glow orbs -->
			<div class="tc-glow-orb tc-glow-orb--blue" aria-hidden="true"></div>
			<div class="tc-glow-orb tc-glow-orb--orange" aria-hidden="true"></div>

			<nav class="tc-hero__crumbs" aria-label="Breadcrumb">
				<a href="<?php echo esc_url(home_url('/')); ?>">Home</a><span>›</span>
				<span class="tc-hero__crumbs-current">Pay Fees</span>
			</nav>

			<h1 class="tc-hero__title"><span class="tc-gradient-text tc-gradient-text--freeze">Pay your fees
					securely.</span></h1>
			<p class="tc-hero__sub">Select your programme below, review the fee summary, and complete your payment
				securely. All prices are base amounts — GST (18%) is added at checkout.</p>

			<div class="tc-hero__stats">
				<div class="tc-stat">
					<strong class="tc-stat__num" data-animate>Secure</strong>
					<span class="tc-stat__label">trusted payment gateway</span>
				</div>
				<div class="tc-stat tc-stat--divider">
					<strong class="tc-stat__num" data-animate>PCI-DSS</strong>
					<span class="tc-stat__label">compliant & encrypted</span>
				</div>
				<div class="tc-stat tc-stat--divider">
					<strong class="tc-stat__num" data-animate>GST Invoice</strong>
					<span class="tc-stat__label">sent after payment</span>
				</div>
			</div>
		</section>

		<!-- SECTION: Plan selector + payment -->
		<section class="tc-section tc-pay-section tc-reveal">
			<span class="tc-eyebrow">Select & Pay</span>
			<h2 class="tc-section__title">Choose your programme</h2>

			<div class="row tc-pay-layout">

				<!-- LEFT: Programme selector tabs -->
				<div class="col-lg-5 tc-reveal">
					<div class="tc-plan-selector" role="tablist" aria-label="Programme selection">
						<?php foreach ($tc_pay_plans as $i => $plan): ?>
							<button class="tc-plan-tab<?php echo $i === 0 ? ' tc-plan-tab--active' : ''; ?>" role="tab"
								aria-selected="<?php echo $i === 0 ? 'true' : 'false'; ?>"
								aria-controls="tc-pay-panel-<?php echo esc_attr($plan['id']); ?>"
								data-plan-id="<?php echo esc_attr($plan['id']); ?>"
								data-base="<?php echo esc_attr($plan['base_raw']); ?>"
								data-gst="<?php echo esc_attr($plan['gst_rate']); ?>"
								data-name="<?php echo esc_attr($plan['name']); ?>"
								id="tc-pay-tab-<?php echo esc_attr($plan['id']); ?>" type="button">
								<span class="tc-plan-tab__name"><?php echo esc_html($plan['name']); ?></span>
								<span class="tc-plan-tab__weeks tc-muted"><?php echo esc_html($plan['weeks']); ?></span>
								<span class="tc-plan-tab__price"><?php echo esc_html($plan['base']); ?> <small>+
										GST</small></span>
								<svg class="tc-plan-tab__arrow" viewBox="0 0 24 24" width="16" height="16" fill="none"
									stroke="currentColor" stroke-width="2">
									<path d="M9 18l6-6-6-6" />
								</svg>
							</button>
						<?php endforeach; ?>
					</div>
				</div>

				<!-- RIGHT: Fee summary -->
				<div class="col-lg-7 tc-reveal" style="--delay: 120ms">

					<?php foreach ($tc_pay_plans as $i => $plan): ?>
						<div class="tc-pay-panel<?php echo $i === 0 ? ' tc-pay-panel--active' : ''; ?>"
							id="tc-pay-panel-<?php echo esc_attr($plan['id']); ?>" role="tabpanel"
							aria-labelledby="tc-pay-tab-<?php echo esc_attr($plan['id']); ?>" <?php echo $i !== 0 ? 'hidden' : ''; ?>>

							<!-- Fee summary card -->
							<div class="tc-pay-summary">
								<div class="tc-pay-summary__header">
									<h3><?php echo esc_html($plan['name']); ?></h3>
									<span class="tc-pay-summary__weeks"><?php echo esc_html($plan['weeks']); ?></span>
								</div>
								<ul class="tc-checklist tc-pay-summary__features">
									<?php foreach ($plan['features'] as $feat): ?>
										<li><?php echo esc_html($feat); ?></li>
									<?php endforeach; ?>
								</ul>
								<div class="tc-pay-summary__breakdown">
									<div class="tc-pay-summary__row">
										<span>Base fee</span>
										<span><?php echo esc_html($plan['base']); ?></span>
									</div>
									<div class="tc-pay-summary__row">
										<span>GST (<?php echo esc_html($plan['gst_rate']); ?>%)</span>
										<span class="tc-pay-gst-value"
											data-base="<?php echo esc_attr($plan['base_raw']); ?>"
											data-gst="<?php echo esc_attr($plan['gst_rate']); ?>">
											<?php
											$gst_amount = round($plan['base_raw'] * $plan['gst_rate'] / 100);
											echo '₹ ' . number_format($gst_amount);
											?>
										</span>
									</div>
									<div class="tc-pay-summary__row tc-pay-summary__row--total">
										<span>Total payable</span>
										<span class="tc-pay-total-value"
											data-base="<?php echo esc_attr($plan['base_raw']); ?>"
											data-gst="<?php echo esc_attr($plan['gst_rate']); ?>">
											<?php
											$total = $plan['base_raw'] + $gst_amount;
											echo '₹ ' . number_format($total);
											?>
										</span>
									</div>
								</div>
							</div>

							<!-- No-Refund notice -->
							<div class="tc-pay-refund-notice">
								<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor"
									stroke-width="1.8" aria-hidden="true">
									<path
										d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
									<line x1="12" y1="9" x2="12" y2="13" />
									<line x1="12" y1="17" x2="12.01" y2="17" />
								</svg>
								<p><strong>No-Refund Policy:</strong> Fees are non-refundable once payment is confirmed.
									Please review the policy on our <a
										href="<?php echo esc_url(tc_tpl_url('page-fees.php', '/fees-batches/')); ?>">Fees
										&amp; Batches page</a> before proceeding. Read our <a href="#tc-modal-terms"
										data-tc-modal-open="terms">Terms and Conditions</a>.</p>
							</div>

						</div>
					<?php endforeach; ?>



				</div><!-- /col-lg-7 -->
			</div><!-- /row -->
		</section>

		<!-- SECTION: Bank Transfer -->
		<section class="tc-section tc-reveal">
			<span class="tc-eyebrow">Alternative Option</span>
			<h2 class="tc-section__title">Pay via Bank Transfer</h2>

			<div class="tc-payment-card tc-bank-card">
				<div class="tc-payment-card__head">
					<svg class="tc-payment-card__icon" viewBox="0 0 24 24" width="22" height="22" fill="none"
						stroke="currentColor" stroke-width="2" aria-hidden="true">
						<rect x="3" y="11" width="18" height="9" rx="1" />
						<path d="M3 11l9-7 9 7" />
						<path d="M7 15v2M12 15v2M17 15v2" />
					</svg>
					<div>
						<h3>Direct bank transfer</h3>
						<p class="tc-muted">Send an NEFT, RTGS or IMPS transfer to our company account.</p>
					</div>
				</div>

				<div class="tc-bank-card__details">
					<?php foreach ($tc_bank_rows as $row): ?>
						<div class="tc-bank-card__row">
							<span class="tc-bank-card__label">
								<?php echo esc_html($row['label']); ?>
							</span>
							<span class="tc-bank-card__value">
								<?php echo esc_html($row['value']); ?>
								<?php if ($row['copy']): ?>
									<button type="button" class="tc-bank-copy-btn" data-copy="
						<?php echo esc_attr($row['value']); ?>" aria-label="Copy <?php echo esc_attr(strtolower($row['label'])); ?>">
										<svg class="tc-bank-copy-btn__icon-copy" viewBox="0 0 24 24" width=" 16" height="16"
											fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
											<rect x="9" y="9" width="12" height="12" rx="2" />
											<path d="M5 15H4a1 1 0 01-1-1V4a1 1 0 011-1h10a1 1 0 011 1v1" />
										</svg>
										<svg class="tc-bank-copy-btn__icon-check" viewBox="0 0 24 24" width="16" height="16"
											fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
											<path d="M20 6L9 17l-5-5" />
										</svg>
									</button>
								<?php endif; ?>
							</span>
						</div>
					<?php endforeach; ?>
				</div>
				<p class="tc-placeholder-note">Please use your full name and phone number as the
					payment reference, then
					WhatsApp us the transaction ID to confirm your seat.</p>
			</div>
		</section>

		<!-- SECTION: FAQ -->
		<section class="tc-section tc-section--tint tc-faq-section tc-reveal">
			<span class="tc-eyebrow">Questions</span>
			<h2 class="tc-section__title">Payment FAQs</h2>
			<div class="tc-faq">
				<?php foreach ($tc_pay_faqs as $i => $faq): ?>
					<details class="tc-faq__item tc-reveal" style="--delay:
				<?php echo $i * 80; ?>ms" <?php echo $i === 0 ? ' open' : ''; ?>>
						<summary class="tc-faq__q">
							<?php echo esc_html($faq['q']); ?>
						</summary>
						<div class="tc-faq__body">
							<div class="tc-faq__body-inner">
								<p class="tc-faq__a tc-muted"><?php echo wp_kses_post($faq['a']); ?>
								</p>
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

			<h2>Need help choosing a plan?</h2>
			<p class="tc-cta-band__sub">Our team is happy to walk you through the options — reach out and we'll confirm
				your plan and batch over email &amp; WhatsApp.</p>
			<div class="tc-cta-band__actions">
				<a class="tc-btn tc-btn--primary"
					href="<?php echo esc_url(tc_tpl_url('page-apply.php', '/admissions-apply/') . '#tc-apply-form-anchor'); ?>">Apply
					First</a> <a class="tc-btn tc-btn--ghost"
					href="<?php echo esc_url(tc_tpl_url('page-fees.php', '/fees-batches/')); ?>">View Fees &amp;
					Batches</a>
			</div>
		</section>

	</div>
</div>

<script>
	(function () {
		// Plan tab switching — show/hide panels, update aria states
		var tabs = document.querySelectorAll('.tc-plan-tab');
		tabs.forEach(function (tab) {
			tab.addEventListener('click', function () {
				var targetId = 'tc-pay-panel-' + tab.dataset.planId;

				// Deactivate all tabs & hide all panels
				tabs.forEach(function (t) {
					t.classList.remove('tc-plan-tab--active');
					t.setAttribute('aria-selected', 'false');
				});
				document.querySelectorAll('.tc-pay-panel').forEach(function (p) {
					p.classList.remove('tc-pay-panel--active');
					p.setAttribute('hidden', '');
				});

				// Activate clicked tab & show its panel
				tab.classList.add('tc-plan-tab--active');
				tab.setAttribute('aria-selected', 'true');
				var panel = document.getElementById(targetId);
				if (panel) {
					panel.classList.add('tc-pay-panel--active');
					panel.removeAttribute('hidden');
				}
			});
		});
	})();
</script>

<?php tc_render_terms_modal(); ?>

<?php get_footer();
