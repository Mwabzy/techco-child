<?php
/**
 * ------------------------------------------------------------------
 * Visioner top navigation bar.
 * ------------------------------------------------------------------
 * The Visioner page templates hide the parent Techco header (see the
 * tc_disable_techco_header filter in functions.php), so they have no
 * site nav. This injects a lightweight sticky nav — links resolved via
 * tc_tpl_url() so they always point at the right published page — into
 * wp_body_open, only on those templates.
 *
 * To add/remove a link, edit $items below. To show the nav on more
 * templates, add their slug to $targets.
 *
 * @package Techco Child
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'wp_body_open', 'tc_render_visioner_nav', 5 );

function tc_render_visioner_nav() {

	// Only on the Visioner templates (which hide the parent header).
	$targets = array(
		'page-home.php',
		'page-program.php',
		'page-fees.php',
		'page-apply.php',
		'page-colleges.php',
	);

	$current = is_page() ? (string) get_page_template_slug( get_queried_object_id() ) : '';
	if ( ! in_array( $current, $targets, true ) ) {
		return;
	}

	// label => [ template, fallback-slug, is-cta ]
	$items = array(
		'Home'           => array( 'page-home.php',     '/',              false ),
		'Program'        => array( 'page-program.php',  '/program/',      false ),
		'Fees & Batches' => array( 'page-fees.php',     '/fees-batches/', false ),
		'For Colleges'   => array( 'page-colleges.php', '/for-colleges/', false ),
		'Apply Now'      => array( 'page-apply.php',    '/apply/',        true  ),
	);

	$home_url = function_exists( 'tc_tpl_url' ) ? tc_tpl_url( 'page-home.php', '/' ) : home_url( '/' );
	?>
	<header class="tc-nav" id="tc-nav">
		<div class="container tc-nav__inner">

			<a class="tc-nav__brand" href="<?php echo esc_url( $home_url ); ?>">
				<span class="tc-nav__brand-mark">V</span>
				<span class="tc-nav__brand-text">Visioner</span>
			</a>

			<button class="tc-nav__toggle" type="button" aria-expanded="false"
				aria-controls="tc-nav-menu" aria-label="Toggle menu">
				<span class="tc-nav__toggle-bar"></span>
				<span class="tc-nav__toggle-bar"></span>
				<span class="tc-nav__toggle-bar"></span>
			</button>

			<nav class="tc-nav__menu" id="tc-nav-menu" aria-label="Primary">
				<ul class="tc-nav__list">
					<?php foreach ( $items as $label => $cfg ) :
						list( $tpl, $fallback, $is_cta ) = $cfg;
						$url       = function_exists( 'tc_tpl_url' ) ? tc_tpl_url( $tpl, $fallback ) : home_url( $fallback );
						$is_active = ( $tpl === $current );
						$classes   = 'tc-nav__link';
						if ( $is_cta )    { $classes .= ' tc-nav__link--cta'; }
						if ( $is_active ) { $classes .= ' is-active'; }
						?>
						<li>
							<a class="<?php echo esc_attr( $classes ); ?>"
								href="<?php echo esc_url( $url ); ?>"
								<?php echo $is_active ? 'aria-current="page"' : ''; ?>>
								<?php echo esc_html( $label ); ?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</nav>

		</div>
	</header>
	<script>
	(function () {
		var nav = document.getElementById('tc-nav');
		if (!nav) return;
		var btn = nav.querySelector('.tc-nav__toggle');
		btn.addEventListener('click', function () {
			var open = nav.classList.toggle('is-open');
			btn.setAttribute('aria-expanded', open ? 'true' : 'false');
		});
		// Shrink/elevate on scroll.
		window.addEventListener('scroll', function () {
			nav.classList.toggle('is-scrolled', window.scrollY > 8);
		}, { passive: true });
	})();
	</script>
	<?php
}
