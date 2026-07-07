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

if (!defined('ABSPATH')) {
	exit;
}

add_action('wp_body_open', 'tc_render_visioner_nav', 5);

function tc_render_visioner_nav()
{

	// Only on the Visioner templates (which hide the parent header).
	$targets = array(
		'page-home.php',
		'page-program.php',
		'page-fees.php',
		'page-apply.php',
		'page-colleges.php',
	);

	$current = is_page() ? (string) get_page_template_slug(get_queried_object_id()) : '';
	if (!in_array($current, $targets, true)) {
		return;
	}

	// Centered primary links. label => [ template, fallback-slug ]
	$items = array(
		'Home' => array('page-home.php', '/'),
		'Program' => array('page-program.php', '/program/'),
		'Fees & Batches' => array('page-fees.php', '/fees-batches/'),
		'For Colleges' => array('page-colleges.php', '/for-colleges/'),
	);

	// "Explore" dropdown inside the search pill — jumps to the main sections.
	$explore = array(
		'Program' => array('page-program.php', '/program/'),
		'Fees & Batches' => array('page-fees.php', '/fees-batches/'),
		'For Colleges' => array('page-colleges.php', '/for-colleges/'),
	);

	$tpl_url = function ($tpl, $fallback) {
		return function_exists('tc_tpl_url') ? tc_tpl_url($tpl, $fallback) : home_url($fallback);
	};

	$home_url  = $tpl_url('page-home.php', '/');
	$apply_url = $tpl_url('page-apply.php', '/apply/');
	$prog_url  = $tpl_url('page-program.php', '/program-curriculum/');

	// Course-content search index (query → curriculum module anchor).
	$tc_search = array(
		'url'   => $prog_url,
		'items' => function_exists('tc_program_search_index') ? tc_program_search_index() : array(),
	);

	// Reuse the site's WhatsApp line (same filters as the floating widget) for "Talk to us".
	$wa_number = apply_filters('techco_child_wa_number', '918143533535');
	$wa_msg    = apply_filters('techco_child_wa_message', 'Hi visionONE, I\'d like to know more about the Full Stack Training program.');
	$talk_url  = $wa_number ? 'https://wa.me/' . rawurlencode($wa_number) . '?text=' . rawurlencode($wa_msg) : $apply_url;
	?>
	<header class="tc-nav" id="tc-nav">
		<div class="container tc-nav__inner">

			<a class="tc-nav__brand" href="<?php echo esc_url($home_url); ?>" aria-label="VisionONE — home">
				<img class="tc-nav__brand-logo"
					src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/logo.png'); ?>" alt=""
					aria-hidden="true">
				<span class="tc-nav__brand-text">vision<span class="tc-nav__brand-text-accent">ONE</span></span>
			</a>

			<div class="tc-nav__collapse" id="tc-nav-menu">

				<!-- Search pill with an Explore sections dropdown -->
				<form class="tc-nav__search" role="search" method="get" action="<?php echo esc_url($home_url); ?>">
					<div class="tc-nav__search-field">
						<span class="tc-nav__search-ic" aria-hidden="true">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
								stroke-width="2" stroke-linecap="round" stroke-linejoin="round" focusable="false">
								<circle cx="11" cy="11" r="8" />
								<line x1="21" y1="21" x2="16.65" y2="16.65" />
							</svg>
						</span>
						<input class="tc-nav__search-input" type="search" name="s" placeholder="Want to learn?"
							aria-label="Search the site" autocomplete="off" aria-autocomplete="list"
							aria-controls="tc-nav-search-suggestions" aria-expanded="false">
						<div class="tc-nav__search-suggestions" id="tc-nav-search-suggestions" role="listbox" aria-label="Suggested topics" hidden></div>
					</div>
					<details class="tc-nav__explore">
						<summary>Explore <?php echo tc_icon('chevron-down', 16); ?></summary>
						<ul class="tc-nav__explore-menu">
							<?php foreach ($explore as $label => $cfg):
								list($tpl, $fallback) = $cfg; ?>
								<li><a href="<?php echo esc_url($tpl_url($tpl, $fallback)); ?>"><?php echo esc_html($label); ?></a></li>
							<?php endforeach; ?>
						</ul>
					</details>
				</form>

				<!-- Centered primary links -->
				<nav class="tc-nav__menu" aria-label="Primary">
					<ul class="tc-nav__list">
						<?php foreach ($items as $label => $cfg):
							list($tpl, $fallback) = $cfg;
							$url = $tpl_url($tpl, $fallback);
							$is_active = ($tpl === $current);
							$classes = 'tc-nav__link' . ($is_active ? ' is-active' : '');
							?>
							<li>
								<a class="<?php echo esc_attr($classes); ?>" href="<?php echo esc_url($url); ?>" <?php echo $is_active ? 'aria-current="page"' : ''; ?>>
									<?php echo esc_html($label); ?>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</nav>

				<!-- Right-side actions -->
				<div class="tc-nav__actions">
					<a class="tc-nav__signin" href="<?php echo esc_url($talk_url); ?>" target="_blank"
						rel="noopener nofollow">Talk to us</a>
					<a class="tc-nav__cta" href="<?php echo esc_url($apply_url); ?>" data-magnetic>Apply Now</a>
				</div>

			</div>

			<button class="tc-nav__toggle" type="button" aria-expanded="false" aria-controls="tc-nav-menu"
				aria-label="Toggle menu">
				<span class="tc-nav__toggle-bar"></span>
				<span class="tc-nav__toggle-bar"></span>
				<span class="tc-nav__toggle-bar"></span>
			</button>

		</div>
	</header>
	<script>
		window.TC_SEARCH = <?php echo wp_json_encode( $tc_search, JSON_HEX_TAG | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE ); ?>;
	</script>
	<script>
		(function () {
			var nav = document.getElementById('tc-nav');
			if (!nav) return;
			var btn = nav.querySelector('.tc-nav__toggle');
			btn.addEventListener('click', function () {
				var open = nav.classList.toggle('is-open');
				btn.setAttribute('aria-expanded', open ? 'true' : 'false');
			});
			// Elevate on scroll.
			window.addEventListener('scroll', function () {
				nav.classList.toggle('is-scrolled', window.scrollY > 8);
			}, { passive: true });
			// Close the "Explore" dropdown on outside click or Escape.
			var explore = nav.querySelector('.tc-nav__explore');
			if (explore) {
				document.addEventListener('click', function (e) {
					if (explore.open && !explore.contains(e.target)) explore.open = false;
				});
				document.addEventListener('keydown', function (e) {
					if (e.key === 'Escape' && explore.open) explore.open = false;
				});
			}
		})();
	</script>
	<?php
}
