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

/**
 * Echoes the Privacy Policy prose block. Content is a DRAFT — pending legal
 * review before it's relied on for real applicants.
 */
function tc_render_privacy_content()
{
	$tc_org = tc_terms_org_details();
	?>
	<div class="tc-legal">

		<h2>1. Who we are</h2>
		<p>This Privacy Policy explains how <?php echo esc_html( $tc_org['name'] ); ?> ("VisionONE", "we", "us")
			collects, uses and protects the personal information you provide when you submit an application, enquire about
			a program, or make a payment.</p>

		<h2>2. Information we collect</h2>
		<p>When you complete our Apply form we collect the details you enter — such as your name, email address, phone and
			WhatsApp number, city, education and work background, program preferences and your responses to the form's
			questions. We also collect payment-related information when you enrol.</p>

		<h2>3. How we use your information</h2>
		<p>We use your information to review your application, contact you about admission, schedule counselling calls,
			process fees, send program-related updates, and — where you have agreed — share relevant offers. We do not
			sell your personal information.</p>

		<h2>4. Who we share it with</h2>
		<p>Your data may be processed by trusted service providers that help us operate (for example, our form, email,
			spreadsheet and payment tools). They may only use it to provide those services to us, under appropriate
			safeguards.</p>

		<h2>5. Data retention and security</h2>
		<p>We keep your information for as long as needed to support your application and enrolment, and to meet legal or
			accounting obligations. We apply reasonable technical and organisational measures to protect it against
			unauthorised access, loss or misuse.</p>

		<h2>6. Your choices</h2>
		<p>You may ask us to access, correct or delete your personal information, or to stop sending you marketing
			messages, by contacting us using the details below. Opting out of marketing does not affect messages required
			to process your application.</p>

		<h2>7. Contact us</h2>
		<p>
			<?php echo esc_html( $tc_org['name'] ); ?><br>
			<?php echo esc_html( $tc_org['addr'] ); ?><br>
			Email: <a
				href="mailto:<?php echo esc_attr( $tc_org['email'] ); ?>"><?php echo esc_html( $tc_org['email'] ); ?></a> ·
			Phone: <a
				href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $tc_org['phone'] ) ); ?>"><?php echo esc_html( $tc_org['phone'] ); ?></a>
		</p>
	</div>
	<?php
}

/**
 * Echoes the Consent statement prose block — explains what the "I consent to
 * being contacted" checkbox means. DRAFT, pending legal review.
 */
function tc_render_consent_content()
{
	$tc_org = tc_terms_org_details();
	?>
	<div class="tc-legal">

		<h2>Consent to be contacted</h2>
		<p>By ticking the consent box on the application form, you agree that <?php echo esc_html( $tc_org['name'] ); ?>
			and its authorised representatives may contact you using the phone number, WhatsApp number and email address
			you provide.</p>

		<h2>What you are consenting to</h2>
		<p>We may reach out by phone call, WhatsApp message or email to discuss your application, arrange a counselling
			call, share program details, batch schedules, fee information and reminders relevant to your enquiry.</p>

		<h2>Why we need it</h2>
		<p>This consent lets us respond to your application quickly and guide you through admission. It is separate from
			any marketing consent — you can agree to be contacted about your application without agreeing to receive
			promotional offers.</p>

		<h2>Withdrawing consent</h2>
		<p>You can withdraw your consent at any time by telling us on a call, replying "STOP" to a message, or emailing
			<a href="mailto:<?php echo esc_attr( $tc_org['email'] ); ?>"><?php echo esc_html( $tc_org['email'] ); ?></a>.
			See our Privacy Policy for how we handle your information.</p>
	</div>
	<?php
}

/**
 * Echoes the Privacy Policy modal. Output once per page, then trigger with:
 *   <a href="#tc-modal-privacy" data-tc-modal-open="privacy">Privacy Policy</a>
 */
function tc_render_privacy_modal()
{
	?>
	<div class="tc-modal" id="tc-modal-privacy" aria-hidden="true" role="dialog" aria-modal="true"
		aria-labelledby="tc-modal-privacy-title">
		<div class="tc-modal__overlay" data-tc-modal-close></div>
		<div class="tc-modal__dialog" role="document">
			<div class="tc-modal__header">
				<h2 class="tc-modal__title" id="tc-modal-privacy-title">Privacy Policy</h2>
				<button type="button" class="tc-modal__close" data-tc-modal-close aria-label="Close">
					<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"
						aria-hidden="true">
						<line x1="18" y1="6" x2="6" y2="18" />
						<line x1="6" y1="6" x2="18" y2="18" />
					</svg>
				</button>
			</div>
			<div class="tc-modal__body">
				<?php tc_render_privacy_content(); ?>
			</div>
		</div>
	</div>
	<?php
}

/**
 * Echoes the Consent modal. Output once per page, then trigger with:
 *   <a href="#tc-modal-consent" data-tc-modal-open="consent">consent</a>
 */
function tc_render_consent_modal()
{
	?>
	<div class="tc-modal" id="tc-modal-consent" aria-hidden="true" role="dialog" aria-modal="true"
		aria-labelledby="tc-modal-consent-title">
		<div class="tc-modal__overlay" data-tc-modal-close></div>
		<div class="tc-modal__dialog" role="document">
			<div class="tc-modal__header">
				<h2 class="tc-modal__title" id="tc-modal-consent-title">Consent</h2>
				<button type="button" class="tc-modal__close" data-tc-modal-close aria-label="Close">
					<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"
						aria-hidden="true">
						<line x1="18" y1="6" x2="6" y2="18" />
						<line x1="6" y1="6" x2="18" y2="18" />
					</svg>
				</button>
			</div>
			<div class="tc-modal__body">
				<?php tc_render_consent_content(); ?>
			</div>
		</div>
	</div>
	<?php
}
