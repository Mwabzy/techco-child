<?php
/**
 * Template Name: VisionONE — Terms and Conditions
 *
 * Standalone Terms & Conditions document, linked from the Apply form's
 * "Terms and Conditions" checkbox (see tc_apply_form_link_terms_field()
 * in inc/google-sheets-sync.php). Content below is a DRAFT — it must be
 * reviewed and signed off by VisionOne's legal counsel before this page
 * is relied on for real applicants.
 * NOTE: intentionally omits techco_child_page_banner() — the .tc-hero
 * below provides its own breadcrumb + title, mirrors other Visioner pages.
 * @package Techco Child
 */

if (!defined('ABSPATH')) {
	exit;
}

get_header();
?>

<div id="primary" class="content-area page-content-area tc-page pt-120 pb-120">
	<div class="container">

		<nav class="tc-hero__crumbs tc-coursebanner__crumbs" aria-label="Breadcrumb">
			<a href="<?php echo esc_url(home_url('/')); ?>">Home</a><span>›</span>
			<span class="tc-hero__crumbs-current">Terms and Conditions</span>
		</nav>

		<section class="tc-coursebanner tc-coursebanner--simple tc-reveal">
			<span class="tc-coursebanner__bg" data-parallax="10" aria-hidden="true"></span>
			<div class="tc-coursebanner__inner">
				<div class="tc-coursebanner__content" data-motion-in>
					<span class="tc-coursebanner__kicker">VisionONE Training</span>
					<h1 class="tc-coursebanner__title">Terms and Conditions</h1>
					<p class="tc-coursebanner__desc">Please read these terms carefully before submitting an application
						or enrolling in a VisionONE program.</p>
				</div>
			</div>
		</section>

		<div class="row tc-program-body">
			<div class="col-12 tc-program-content">

				<section class="tc-section tc-reveal">
					<?php tc_render_terms_content(); ?>
				</section>

			</div>
		</div>

	</div>
</div>

<?php get_footer(); ?>