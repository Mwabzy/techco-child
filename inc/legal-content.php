<?php
/**
 * ------------------------------------------------------------------
 * Terms and Conditions — shared content + modal wrapper.
 * ------------------------------------------------------------------
 * Single source of truth for the T&C copy, used by:
 *   - page-terms.php (standalone page)
 *   - the in-page "read it here" modal on page-apply.php and
 *     page-payment.php (triggered via data-tc-modal-open="terms",
 *     see assets/js/custom.js's initTcModals()).
 *
 * @package Techco Child
 */

if (!defined('ABSPATH')) {
	exit;
}

/**
 * Official VisionOne entity details, used in the Terms document's
 * liability/contact section (mirrors $tc_org in page-payment.php).
 */
function tc_terms_org_details()
{
	return array(
		'name' => 'VisionOne Access Private Limited',
		'addr' => 'Plot No: 3-225, 4th Floor, Mahendra Mindspace, Kavuri Hills, Phase 2, Madhapur, Hyderabad, Telangana – 500033',
		'email' => 'marketing@visionerpsolutions.com',
		'phone' => '+91 8143533434',
		'gstin' => '36AALCV9084F1ZR',
		'cin' => 'U62011TS2026PTC211545',
	);
}

/**
 * Echoes the .tc-legal prose block. Content is a DRAFT — pending legal
 * review before it's relied on for real applicants.
 */
function tc_render_terms_content()
{
	$tc_org = tc_terms_org_details();
	$tc_terms_updated = 'Draft — not yet published';
	?>
	<div class="tc-legal">

		<h2>1. Acceptance of terms</h2>
		<p>By submitting an application through our Apply form, or by enrolling in and paying for any VisionONE program, you
			agree to be bound by these Terms and Conditions. If you do not agree with any part of these terms, please do not
			submit an application.</p>

		<h2>2. Eligibility and admission</h2>
		<p>Admission into a VisionONE program is at the discretion of VisionOne Access Private Limited. Submitting an
			application does not guarantee a seat — our team will confirm eligibility, batch availability and program fit
			before an offer is extended. Applicants must provide accurate and complete information in the application form.
		</p>

		<h2>3. Fees and payment</h2>
		<p>Program fees, applicable GST and payment plans are listed on our <a
				href="<?php echo esc_url(tc_tpl_url('page-fees.php', '/fees-batches/')); ?>">Fees &amp; Batches page</a>
			and on the <a href="<?php echo esc_url(tc_tpl_url('page-payment.php', '/pay/')); ?>">Payment page</a>. A
			seat is confirmed only once payment is received. Fees are non-refundable once a seat is confirmed — see the
			No-Refund Policy referenced on the Payment page for full details.</p>

		<h2>4. Course delivery and changes</h2>
		<p>VisionONE may, from time to time, adjust batch timings, delivery mode (online/on-campus), instructors or
			curriculum content to maintain program quality. We will make reasonable efforts to notify enrolled students of
			any material change in advance.</p>

		<h2>5. Code of conduct</h2>
		<p>Students are expected to engage respectfully with instructors, mentors and fellow students. VisionONE reserves
			the right to suspend or terminate access to a program, without refund, in cases of harassment, academic
			dishonesty, or other serious misconduct.</p>

		<h2>6. Intellectual property</h2>
		<p>All course materials, slides, starter code, videos and other content provided as part of a VisionONE program
			remain the intellectual property of VisionOne Access Private Limited and are licensed to enrolled students for
			personal, non-commercial learning use only. Redistribution or resale of course materials is prohibited.</p>

		<h2>7. Limitation of liability</h2>
		<p>VisionONE provides training and placement support on a best-effort basis and does not guarantee employment
			outcomes. To the extent permitted by law, VisionOne Access Private Limited's liability arising from your use of
			our programs is limited to the fees paid for the relevant program.</p>
		<p>
			<?php echo esc_html($tc_org['name']); ?><br>
			<?php echo esc_html($tc_org['addr']); ?><br>
			GSTIN: <?php echo esc_html($tc_org['gstin']); ?> · CIN: <?php echo esc_html($tc_org['cin']); ?><br>
			Email: <a
				href="mailto:<?php echo esc_attr($tc_org['email']); ?>"><?php echo esc_html($tc_org['email']); ?></a> ·
			Phone: <a
				href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $tc_org['phone'])); ?>"><?php echo esc_html($tc_org['phone']); ?></a>
		</p>
	</div>
	<?php
}

/**
 * Echoes a self-contained modal (backdrop + dialog) wrapping
 * tc_render_terms_content(). Output this once per page, then trigger it
 * from anywhere on that page with:
 *   <a href="#tc-modal-terms" data-tc-modal-open="terms">Terms and Conditions</a>
 * See initTcModals() in assets/js/custom.js for the open/close behaviour.
 */
function tc_render_terms_modal()
{
	?>
	<div class="tc-modal" id="tc-modal-terms" aria-hidden="true" role="dialog" aria-modal="true"
		aria-labelledby="tc-modal-terms-title">
		<div class="tc-modal__overlay" data-tc-modal-close></div>
		<div class="tc-modal__dialog" role="document">
			<div class="tc-modal__header">
				<h2 class="tc-modal__title" id="tc-modal-terms-title">Terms and Conditions</h2>
				<button type="button" class="tc-modal__close" data-tc-modal-close aria-label="Close">
					<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"
						aria-hidden="true">
						<line x1="18" y1="6" x2="6" y2="18" />
						<line x1="6" y1="6" x2="18" y2="18" />
					</svg>
				</button>
			</div>
			<div class="tc-modal__body">
				<?php tc_render_terms_content(); ?>
			</div>
		</div>
	</div>
	<?php
}
