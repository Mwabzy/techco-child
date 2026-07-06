<?php
/**
 * Template Name: visionONE — Study Materials
 *
 * Gated portal for enrolled students. Logged-in users see the downloadable
 * study materials grid. Logged-out visitors see a login wall.
 *
 * Materials are stored in the WordPress Media Library. Replace each
 * '#MATERIAL_URL' placeholder in the $tc_materials array with the actual
 * URL from Media Library → Copy Link.
 *
 * Access control: WordPress login (is_user_logged_in()). Any registered
 * WP user can access. To restrict further (e.g. to a specific role),
 * add a role check after the is_user_logged_in() call below.
 *
 * NOTE: intentionally omits techco_child_page_banner() — the .tc-hero
 * below provides its own breadcrumb + title, mirrors other Visioner pages.
 * @package Techco Child
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();

$tc_is_logged_in  = is_user_logged_in();
$tc_current_user  = $tc_is_logged_in ? wp_get_current_user() : null;
$tc_display_name  = $tc_is_logged_in ? esc_html( $tc_current_user->display_name ) : '';

// Login URL — redirect back to this page after successful login.
$tc_login_url = wp_login_url( get_permalink() );

/**
 * Study materials organised by module / week.
 * CLAUDE CODE / KUWAYA: For each material:
 *   1. Upload the file to WordPress Media Library (Dashboard → Media → Add New).
 *   2. Click the uploaded file → copy the "File URL".
 *   3. Paste the URL into the corresponding 'url' value below.
 *   4. Set 'type' to 'PDF', 'ZIP', 'Video', or 'Slides' — the badge colour
 *      changes automatically via CSS.
 */
$tc_modules = array(
	array(
		'module'    => 'Module 1 — Web Fundamentals',
		'materials' => array(
			array( 'title' => 'HTML & CSS Reference Guide',      'desc' => 'Core markup, Flexbox, Grid and responsive patterns.',       'type' => 'PDF',    'url' => '#MATERIAL_URL' ),
			array( 'title' => 'Module 1 Slides',                  'desc' => 'Lecture slides covering HTML5 elements and CSS selectors.', 'type' => 'Slides', 'url' => '#MATERIAL_URL' ),
			array( 'title' => 'Starter Boilerplate',              'desc' => 'Pre-configured project scaffold with build tooling.',       'type' => 'ZIP',    'url' => '#MATERIAL_URL' ),
		),
	),
	array(
		'module'    => 'Module 2 — Angular 18',
		'materials' => array(
			array( 'title' => 'Angular 18 Cheatsheet',            'desc' => 'Components, directives, signals and routing at a glance.', 'type' => 'PDF',    'url' => '#MATERIAL_URL' ),
			array( 'title' => 'Module 2 Slides',                  'desc' => 'Full lecture deck — standalone components to state.',      'type' => 'Slides', 'url' => '#MATERIAL_URL' ),
			array( 'title' => 'Angular Starter Project',           'desc' => 'Scaffold Angular 18 app wired to a mock REST API.',       'type' => 'ZIP',    'url' => '#MATERIAL_URL' ),
		),
	),
	array(
		'module'    => 'Module 3 — .NET 8 & Web API',
		'materials' => array(
			array( 'title' => '.NET 8 Web API Reference',          'desc' => 'Controllers, middleware, DI and EF Core patterns.',       'type' => 'PDF',    'url' => '#MATERIAL_URL' ),
			array( 'title' => 'Module 3 Slides',                   'desc' => 'Lecture deck covering REST design and auth flows.',       'type' => 'Slides', 'url' => '#MATERIAL_URL' ),
		),
	),
	array(
		'module'    => 'Module 4 — SQL Server',
		'materials' => array(
			array( 'title' => 'SQL Server Quick Reference',        'desc' => 'DDL, DML, stored procedures and query optimisation.',    'type' => 'PDF',    'url' => '#MATERIAL_URL' ),
			array( 'title' => 'Module 4 Slides',                   'desc' => 'Lecture deck covering schema design and indexing.',      'type' => 'Slides', 'url' => '#MATERIAL_URL' ),
		),
	),
	array(
		'module'    => 'Module 5 — Capstone & Career',
		'materials' => array(
			array( 'title' => 'Mini-ERP Project Spec',             'desc' => 'Full requirements, wireframes and grading rubric.',      'type' => 'PDF',    'url' => '#MATERIAL_URL' ),
			array( 'title' => 'Resume & LinkedIn Checklist',       'desc' => 'Job-search checklist curated by the TPO team.',         'type' => 'PDF',    'url' => '#MATERIAL_URL' ),
		),
	),
);

// Type → CSS modifier map
$tc_type_mod = array(
	'PDF'    => 'tc-mat-badge--pdf',
	'ZIP'    => 'tc-mat-badge--zip',
	'Video'  => 'tc-mat-badge--video',
	'Slides' => 'tc-mat-badge--slides',
);
?>

<div id="primary" class="content-area page-content-area tc-page tc-resources-page pt-120 pb-120">
	<div class="container">

		<!-- SECTION: Hero -->
		<section class="tc-hero tc-texture-dots tc-reveal">
			<div class="tc-glow-orb tc-glow-orb--blue" aria-hidden="true"></div>
			<div class="tc-glow-orb tc-glow-orb--orange" aria-hidden="true"></div>

			<nav class="tc-hero__crumbs" aria-label="Breadcrumb">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a><span>›</span>
				<span class="tc-hero__crumbs-current">Study Materials</span>
			</nav>

			<?php if ( $tc_is_logged_in ) : ?>
				<h1 class="tc-hero__title">
					<span class="tc-gradient-text tc-gradient-text--freeze">
						Welcome back, <?php echo $tc_display_name; ?>.
					</span>
				</h1>
				<p class="tc-hero__sub">Your study materials are ready to download. Work through each module at your own pace and keep your notes alongside the reference guides.</p>
			<?php else : ?>
				<h1 class="tc-hero__title">
					<span class="tc-gradient-text tc-gradient-text--freeze">Study Materials</span>
				</h1>
				<p class="tc-hero__sub">Course materials are available exclusively for enrolled students. Log in with your visionONE account to access your downloads.</p>
			<?php endif; ?>
		</section>

		<?php if ( $tc_is_logged_in ) : ?>

			<!-- SECTION: Materials grid (logged-in view) -->
			<?php foreach ( $tc_modules as $mi => $mod ) : ?>
			<section class="tc-section tc-mat-module tc-reveal<?php echo $mi % 2 === 1 ? ' tc-section--tint' : ''; ?>" style="--delay: <?php echo $mi * 80; ?>ms">
				<span class="tc-eyebrow">Module <?php echo $mi + 1; ?></span>
				<h2 class="tc-section__title"><?php echo esc_html( $mod['module'] ); ?></h2>
				<div class="tc-mat-grid">
					<?php foreach ( $mod['materials'] as $j => $mat ) :
						$type_mod = isset( $tc_type_mod[ $mat['type'] ] ) ? $tc_type_mod[ $mat['type'] ] : '';
					?>
					<div class="tc-mat-card tc-reveal" style="--delay: <?php echo $j * 100; ?>ms">
						<div class="tc-mat-card__top">
							<span class="tc-mat-badge <?php echo esc_attr( $type_mod ); ?>"><?php echo esc_html( $mat['type'] ); ?></span>
							<h3 class="tc-mat-card__title"><?php echo esc_html( $mat['title'] ); ?></h3>
							<p class="tc-mat-card__desc tc-muted"><?php echo esc_html( $mat['desc'] ); ?></p>
						</div>
						<div class="tc-mat-card__foot">
							<?php if ( $mat['url'] !== '#MATERIAL_URL' ) : ?>
								<a class="tc-btn tc-btn--primary tc-btn--sm" href="<?php echo esc_url( $mat['url'] ); ?>" download target="_blank" rel="noopener">
									<svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
									Download
								</a>
							<?php else : ?>
								<span class="tc-mat-card__coming-soon">Coming soon</span>
							<?php endif; ?>
						</div>
					</div>
					<?php endforeach; ?>
				</div>
			</section>
			<?php endforeach; ?>

		<?php else : ?>

			<!-- SECTION: Lock screen (logged-out view) -->
			<section class="tc-section tc-locked-screen tc-reveal">
				<div class="tc-lock-card">
					<div class="tc-lock-card__icon" aria-hidden="true">
						<svg viewBox="0 0 24 24" width="40" height="40" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
					</div>
					<h2 class="tc-lock-card__title">Enrolled students only</h2>
					<p class="tc-lock-card__desc tc-muted">Study materials are available exclusively to visionONE students. Log in with the credentials sent to you after enrolment.</p>
					<a class="tc-btn tc-btn--primary tc-lock-card__login-btn" href="<?php echo esc_url( $tc_login_url ); ?>">
						<svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
						Log In to Your Account
					</a>
					<p class="tc-lock-card__help tc-muted">
						Haven't received your login credentials?
						<a href="<?php echo esc_url( tc_tpl_url( 'page-apply.php', '/admissions-apply/' ) ); ?>">Contact admissions →</a>
					</p>
				</div>
			</section>

		<?php endif; ?>

		<!-- SECTION: CTA -->
		<section class="tc-section tc-cta-band text-center tc-reveal">
			<div class="tc-glow-orb tc-glow-orb--blue" aria-hidden="true"></div>
			<div class="tc-glow-orb tc-glow-orb--orange" aria-hidden="true"></div>

			<?php if ( $tc_is_logged_in ) : ?>
				<h2>Ready to apply what you've learnt?</h2>
				<p class="tc-cta-band__sub">Reach out to your mentor on WhatsApp or check the batch dashboard for your next live session.</p>
				<div class="tc-cta-band__actions">
					<a class="tc-btn tc-btn--primary" href="<?php echo esc_url( home_url( '/' ) ); ?>">Back to Home</a>
				</div>
			<?php else : ?>
				<h2>Not enrolled yet?</h2>
				<p class="tc-cta-band__sub">Apply now and our team will help you get started — confirming your seat, batch and login credentials within 24 hours.</p>
				<div class="tc-cta-band__actions">
					<a class="tc-btn tc-btn--primary" href="<?php echo esc_url( tc_tpl_url( 'page-apply.php', '/admissions-apply/' ) ); ?>">Apply Now</a>
					<a class="tc-btn tc-btn--ghost"    href="<?php echo esc_url( tc_tpl_url( 'page-fees.php', '/fees-batches/' ) ); ?>">View Fees &amp; Batches</a>
				</div>
			<?php endif; ?>
		</section>

	</div>
</div>

<?php get_footer();
