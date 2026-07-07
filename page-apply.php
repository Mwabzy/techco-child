<?php
/**
 * Template Name: visionONE — Admissions / Apply
 *
 * Redesigned admissions funnel: gradient banner hero, value proposition,
 * eligibility, batch selection, application form + trust panel, FAQ, CTA.
 * NOTE: intentionally omits techco_child_page_banner() — the .tc-coursebanner
 * below provides its own hero, consistent with program/fees/colleges pages.
 * @package Techco Child
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();

/**
 * CLAUDE CODE: Placeholder admissions content — swap copy/dates for the
 * final deck wording before launch.
 */

$tc_eligibility = array(
	'Open to graduates, final-year students &amp; career-switchers',
	'No prior coding experience required — we start from fundamentals',
	'Basic computer literacy and a stable internet connection',
	'Comfortable committing 15–20 hrs/week for the duration of the cohort',
);

$tc_batches = array(
	array( 'name' => 'Cohort — July 2026',      'date' => 'Starts 6 Jul 2026',  'mode' => 'Online · Hybrid', 'seats' => 'Few seats left', 'badge' => 'urgent' ),
	array( 'name' => 'Cohort — September 2026', 'date' => 'Starts 7 Sep 2026',  'mode' => 'Online',          'seats' => 'Open', 'badge' => '' ),
	array( 'name' => 'Cohort — November 2026',  'date' => 'Starts 2 Nov 2026',  'mode' => 'Hybrid',          'seats' => 'Open', 'badge' => '' ),
);

$tc_faqs = array(
	array( 'q' => 'Do I need prior coding experience to apply?', 'a' => 'No. The programme is designed for absolute beginners and ramps up from web fundamentals.' ),
	array( 'q' => 'Is there a refund if I change my mind after enrolling?', 'a' => 'Our No-Refund policy applies once a seat is confirmed — please review it carefully before paying. We\'re happy to answer questions on a counselling call first.' ),
	array( 'q' => 'Can I pay in EMIs?', 'a' => 'Yes — EMI-friendly plans are available. Exact EMI amounts are on the Fees &amp; Batches page.' ),
	array( 'q' => 'Will I get a certificate?', 'a' => 'Yes, you receive a certificate of completion once you finish the capstone project.' ),
	array( 'q' => 'Is placement support included?', 'a' => 'Yes — every cohort includes placement &amp; TPO support as part of the programme.' ),
	array( 'q' => 'What if my preferred batch is full?', 'a' => 'We\'ll offer you the next available cohort and hold your application on file.' ),
);

// Why apply now — value propositions.
$tc_apply_why = array(
	array( 'ic' => 'award', 'color' => 'blue', 'title' => 'Industry mentors', 'text' => 'Learn from working engineers. Live code reviews and 1:1 guidance every week.' ),
	array( 'ic' => 'code', 'color' => 'violet', 'title' => 'Learn by building', 'text' => 'Ship features from day one. Real projects, reviewed live by working professionals.' ),
	array( 'ic' => 'briefcase', 'color' => 'amber', 'title' => 'Placement support', 'text' => 'Mock interviews, resume polish, GitHub showcase and TPO pipeline — included.' ),
	array( 'ic' => 'credit-card', 'color' => 'green', 'title' => 'Flexible fees', 'text' => 'Pay in EMIs. No-Cost EMI options on eligible cards. Transparent pricing.' ),
);
?>

<div id="primary" class="content-area page-content-area tc-page pt-120 pb-120">
	<div class="container">

		<!-- SECTION: Gradient banner hero (consistent with program/fees/colleges) -->
		<section class="tc-coursebanner tc-coursebanner--simple tc-reveal">
			<span class="tc-coursebanner__bg" data-parallax="10" aria-hidden="true"></span>
			<div class="tc-coursebanner__inner">
				<div class="tc-coursebanner__content" data-motion-in>
					<span class="tc-coursebanner__kicker">Admissions Open</span>
					<h1 class="tc-coursebanner__title">Apply in minutes. Confirm in 24 hours.</h1>
					<p class="tc-coursebanner__desc">Join a cohort of builders and learners. Our team will walk you through your best track, batch, and fees plan over a quick call.</p>
					<div class="tc-coursebanner__stats">
						<span class="tc-herostat"><strong>Next Intake</strong><span>6 Jul 2026</span></span>
						<span class="tc-herostat"><strong>24 hrs</strong><span>average response</span></span>
						<span class="tc-herostat"><strong>Limited</strong><span>seats per cohort</span></span>
					</div>
					<div class="tc-coursebanner__actions">
						<a class="tc-btn tc-btn--light" data-magnetic href="#tc-apply-form-anchor">Start Application</a>
						<a class="tc-btn tc-btn--ghost" href="<?php echo esc_url( tc_tpl_url( 'page-fees.php', '/fees-batches/' ) ); ?>">View Fees & Batches</a>
					</div>
				</div>
			</div>
		</section>

		<!-- SECTION: Why apply now — value propositions (colored icon cards) -->
		<section class="tc-section tc-apply-why tc-reveal">
			<h2 class="tc-section__title" style="text-align: center; margin-bottom: 0;">Why join visionONE</h2>
			<div class="tc-bento tc-bento--4col">
				<?php foreach ( $tc_apply_why as $i => $card ) : ?>
				<div class="tc-feature tc-reveal" style="--delay: <?php echo $i * 80; ?>ms">
					<span class="tc-feature__ic tc-feature__ic--<?php echo esc_attr( $card['color'] ); ?>"><?php echo tc_icon( $card['ic'], 24 ); ?></span>
					<h3><?php echo esc_html( $card['title'] ); ?></h3>
					<p class="tc-muted"><?php echo esc_html( $card['text'] ); ?></p>
				</div>
				<?php endforeach; ?>
			</div>
		</section>

		<!-- SECTION: Batch selection (improved card grid) -->
		<section class="tc-section tc-batches-section tc-reveal">
			<span class="tc-eyebrow">Plan ahead</span>
			<h2 class="tc-section__title">Choose your cohort</h2>
			<p class="tc-muted" style="max-width: 640px;">Dates are indicative. Our team will confirm your exact batch and schedule during the counselling call.</p>
			<div class="tc-batch-grid">
				<?php foreach ( $tc_batches as $i => $b ) : ?>
				<div class="tc-batch-card tc-reveal" style="--delay: <?php echo $i * 100; ?>ms">
					<div class="tc-batch-card__head">
						<h3 class="tc-batch-card__name"><?php echo esc_html( $b['name'] ); ?></h3>
						<?php if ( $b['badge'] === 'urgent' ) : ?>
							<span class="tc-batch-card__badge tc-batch-card__badge--urgent">Few seats left</span>
						<?php else : ?>
							<span class="tc-batch-card__badge">Open</span>
						<?php endif; ?>
					</div>
					<div class="tc-batch-card__body">
						<p class="tc-batch-card__detail"><strong><?php echo esc_html( $b['date'] ); ?></strong></p>
						<p class="tc-batch-card__detail tc-muted"><?php echo esc_html( $b['mode'] ); ?></p>
					</div>
					<a href="#tc-apply-form-anchor" class="tc-batch-card__link">Select this cohort →</a>
				</div>
				<?php endforeach; ?>
			</div>
		</section>

		<!-- SECTION: Application form + trust panel -->
		<section class="tc-section tc-apply-section tc-reveal" id="tc-apply-form-anchor">
			<div class="row">

				<!-- LEFT: the registration form -->
				<div class="col-lg-7 tc-reveal">
					<span class="tc-eyebrow">Apply now</span>
					<h2 class="tc-section__title">Let's get you started</h2>
					<p class="tc-muted" style="margin-bottom: 28px;">Tell us about yourself. Our team will follow up within 24 hours to discuss the best track, timing and payment plan for you.</p>
					<div class="tc-apply-form">
						<?php
						if ( function_exists( 'do_shortcode' ) ) {
							echo do_shortcode( '[fluentform id="1"]' );
						}
						?>
					</div>
				</div>

				<!-- RIGHT: trust panel + benefits -->
				<div class="col-lg-5 tc-reveal" style="--delay: 100ms">
					<aside class="tc-apply-panel">
						<h3 class="tc-apply-panel__title">What happens next</h3>
						<div class="tc-apply-panel__item">
							<span class="tc-apply-panel__num">1</span>
							<p><strong>Your application is reviewed</strong><br><span class="tc-muted">Our team reads your profile and notes.</span></p>
						</div>
						<div class="tc-apply-panel__item">
							<span class="tc-apply-panel__num">2</span>
							<p><strong>Counselling call scheduled</strong><br><span class="tc-muted">We call within 24 hours to discuss fit.</span></p>
						</div>
						<div class="tc-apply-panel__item">
							<span class="tc-apply-panel__num">3</span>
							<p><strong>Offer & seat confirmation</strong><br><span class="tc-muted">Get your offer letter and lock your seat.</span></p>
						</div>

						<hr class="tc-apply-panel__divider">

						<h4 class="tc-apply-panel__subhead">Download the brochure</h4>
						<div class="tc-brochure" data-state="locked">
							<p class="tc-brochure__locked">📄 Submit the form to unlock the download.</p>
							<a class="tc-btn tc-btn--primary tc-btn--block tc-brochure__link" href="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/files/Training_Brochure.pptx' ); ?>" download hidden>
								Download Brochure (PPTX)
							</a>
						</div>
					</aside>
				</div>

			</div>
		</section>

		<!-- SECTION: FAQ -->
		<section class="tc-section tc-section--tint tc-faq-section tc-reveal">
			<span class="tc-eyebrow">Questions</span>
			<h2 class="tc-section__title">Frequently asked questions</h2>
			<div class="tc-faq">
				<?php foreach ( $tc_faqs as $i => $faq ) : ?>
				<details class="tc-faq__item tc-reveal" style="--delay: <?php echo ( $i % 4 ) * 70; ?>ms" <?php echo $i === 0 ? 'open' : ''; ?>>
					<summary class="tc-faq__q"><?php echo esc_html( $faq['q'] ); ?></summary>
					<p class="tc-faq__a tc-muted"><?php echo wp_kses_post( $faq['a'] ); ?></p>
				</details>
				<?php endforeach; ?>
			</div>
		</section>

		<!-- SECTION: Final CTA -->
		<section class="tc-section tc-cta-band tc-reveal">
			<div class="tc-glow-orb tc-glow-orb--blue" aria-hidden="true"></div>
			<h2>Ready to start building?</h2>
			<p class="tc-cta-band__sub">Seats fill up each cohort. Apply now and lock yours within 24 hours.</p>
			<div class="tc-cta-band__actions">
				<a class="tc-btn tc-btn--primary" data-magnetic href="#tc-apply-form-anchor">Apply Now</a>
				<a class="tc-btn tc-btn--ghost" href="<?php echo esc_url( tc_tpl_url( 'page-program.php', '/program-curriculum/' ) ); ?>">View Curriculum</a>
			</div>
		</section>

	</div>
</div>

<?php get_footer();
