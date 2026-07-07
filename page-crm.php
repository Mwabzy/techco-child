<?php
/**
 * Template Name: visionONE — CRM
 *
 * Private, admins-only applications CRM. Reads/writes applicant records that
 * live in the Google Sheet (via the Apps Script Web App, see inc/crm/).
 * Hard-guarded before any output: logged-out visitors are sent to login,
 * logged-in non-admins get a 403. The parent theme header/footer are
 * suppressed for this template (see tc_disable_techco_header() in
 * functions.php) so this renders as a self-contained dashboard.
 *
 * @package Techco Child
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! is_user_logged_in() ) {
	auth_redirect();
}
if ( ! current_user_can( TC_CRM_CAP ) ) {
	wp_die( esc_html__( 'You do not have permission to access this page.', 'techco-child' ), 403 );
}

$tc_crm_boot = tc_crm_boot_data();

get_header();
?>

<div id="primary" class="content-area page-content-area tc-page tc-crm-page">
<div class="tc-crm" id="tc-crm" data-app>

	<!-- Top bar -->
	<header class="tc-crm__topbar">
		<div class="tc-crm__brand">
			<span class="tc-crm__brand-mark">vision<span class="tc-crm__brand-accent">ONE</span></span>
			<span class="tc-crm__brand-sep">/</span>
			<span class="tc-crm__brand-name">Applications CRM</span>
		</div>

		<nav class="tc-crm__tabs" role="tablist" aria-label="CRM sections">
			<button class="tc-crm__tab is-active" type="button" role="tab" data-view="overview" aria-selected="true">Overview</button>
			<button class="tc-crm__tab" type="button" role="tab" data-view="pipeline" aria-selected="false">Pipeline</button>
			<button class="tc-crm__tab" type="button" role="tab" data-view="reports" aria-selected="false">Reports</button>
		</nav>

		<div class="tc-crm__topbar-actions">
			<span class="tc-crm__user"><?php echo esc_html( $tc_crm_boot['user'] ); ?></span>
			<button class="tc-crm__btn tc-crm__btn--ghost" type="button" data-action="refresh">
				<svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M21 2v6h-6"/><path d="M3 12a9 9 0 0115-6.7L21 8"/><path d="M3 22v-6h6"/><path d="M21 12a9 9 0 01-15 6.7L3 16"/></svg>
				Refresh
			</button>
			<a class="tc-crm__btn tc-crm__btn--ghost" href="<?php echo esc_url( home_url( '/' ) ); ?>">Back to site</a>
		</div>
	</header>

	<?php if ( ! empty( $tc_crm_boot['error'] ) ) : ?>
	<div class="tc-crm__banner tc-crm__banner--error">
		<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
		<span><?php echo esc_html( $tc_crm_boot['error'] ); ?></span>
	</div>
	<?php endif; ?>

	<main class="tc-crm__main">

		<!-- OVERVIEW -->
		<section class="tc-crm__view is-active" data-view-panel="overview">
			<div class="tc-crm__stats" data-el="stats"></div>
			<div class="tc-crm__charts">
				<div class="tc-crm-card tc-crm-card--wide">
					<h3 class="tc-crm-card__title">Submissions over time</h3>
					<div class="tc-crm-chart" data-chart="timeline"></div>
				</div>
				<div class="tc-crm-card">
					<h3 class="tc-crm-card__title">Pipeline funnel</h3>
					<div class="tc-crm-chart" data-chart="funnel"></div>
				</div>
				<div class="tc-crm-card">
					<h3 class="tc-crm-card__title">Batch demand</h3>
					<div class="tc-crm-chart" data-chart="batch"></div>
				</div>
				<div class="tc-crm-card">
					<h3 class="tc-crm-card__title">Course interest</h3>
					<div class="tc-crm-chart" data-chart="course"></div>
				</div>
				<div class="tc-crm-card">
					<h3 class="tc-crm-card__title">Mode of training</h3>
					<div class="tc-crm-chart" data-chart="mode"></div>
				</div>
				<div class="tc-crm-card">
					<h3 class="tc-crm-card__title">Source breakdown</h3>
					<div class="tc-crm-chart" data-chart="source"></div>
				</div>
			</div>
		</section>

		<!-- PIPELINE -->
		<section class="tc-crm__view" data-view-panel="pipeline">
			<div class="tc-crm__toolbar">
				<input class="tc-crm__search" type="search" placeholder="Search name, email, phone…" data-el="search">
				<select class="tc-crm__select" data-el="filter-status"><option value="">All statuses</option></select>
				<select class="tc-crm__select" data-el="filter-batch"><option value="">All batches</option></select>
				<select class="tc-crm__select" data-el="filter-course"><option value="">All courses</option></select>
				<div class="tc-crm__view-toggle">
					<button class="tc-crm__view-toggle-btn is-active" type="button" data-table-view="table">Table</button>
					<button class="tc-crm__view-toggle-btn" type="button" data-table-view="board">Board</button>
				</div>
			</div>
			<div class="tc-crm__pipeline-body" data-el="pipeline-body"></div>
		</section>

		<!-- REPORTS -->
		<section class="tc-crm__view" data-view-panel="reports">
			<div class="tc-crm__toolbar">
				<label class="tc-crm__field">From <input type="date" data-el="report-from"></label>
				<label class="tc-crm__field">To <input type="date" data-el="report-to"></label>
				<select class="tc-crm__select" data-el="report-status"><option value="">All statuses</option></select>
				<select class="tc-crm__select" data-el="report-batch"><option value="">All batches</option></select>
				<select class="tc-crm__select" data-el="report-course"><option value="">All courses</option></select>
				<button class="tc-crm__btn tc-crm__btn--primary" type="button" data-action="export-csv">Export CSV</button>
			</div>
			<div class="tc-crm__stats" data-el="report-stats"></div>
			<div class="tc-crm-card tc-crm-card--wide">
				<h3 class="tc-crm-card__title">Filtered results</h3>
				<div class="tc-crm__table-wrap" data-el="report-table"></div>
			</div>
		</section>

	</main>

	<div class="tc-crm__toast" data-el="toast" aria-live="polite"></div>
	<div class="tc-crm-modal" data-el="detail-modal" hidden></div>
</div>
</div>

<script>
	window.tcCrmData = <?php echo wp_json_encode( $tc_crm_boot ); ?>;
</script>

<?php get_footer(); ?>
