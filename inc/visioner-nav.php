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
		'page-payment.php',
	);

	$current = is_page() ? (string) get_page_template_slug(get_queried_object_id()) : '';
	if (!in_array($current, $targets, true)) {
		return;
	}

	$tpl_url = function ($tpl, $fallback) {
		return function_exists('tc_tpl_url') ? tc_tpl_url($tpl, $fallback) : home_url($fallback);
	};

	// The whole site now lives on this one page — every link below is an
	// in-page anchor. The other Visioner templates (program/fees/apply/
	// colleges) are no longer linked from nav; they stay in the codebase
	// untouched but are effectively retired from the user journey.
	$home_url = $tpl_url('page-home.php', '/');
	$enquiry_url = $home_url . '#tc-enquiry';

	$items = array(
		'Home' => array('url' => $home_url, 'tpl' => 'page-home.php'),
		'Overview' => array('url' => $home_url . '#tc-why', 'tpl' => ''),
		'Careers' => array('url' => $home_url . '#tc-careers', 'tpl' => ''),
		'Curriculum' => array('url' => $home_url . '#tc-curriculum', 'tpl' => ''),
		'Tools' => array('url' => $home_url . '#tc-stack', 'tpl' => ''),
		'Projects' => array('url' => $home_url . '#tc-tracks', 'tpl' => ''),
		'Enquiry' => array('url' => $enquiry_url, 'tpl' => ''),
	);

	// Reuse the site's WhatsApp line (same filters as the floating widget) for the nav's WhatsApp button.
	$wa_number = apply_filters('techco_child_wa_number', '918143533434');
	$wa_msg = apply_filters('techco_child_wa_message', 'Hi VisionONE, I\'d like to know more about the Full Stack Training program.');
	$talk_url = $wa_number ? 'https://wa.me/' . rawurlencode($wa_number) . '?text=' . rawurlencode($wa_msg) : $enquiry_url;
	?>
	<header class="tc-nav" id="tc-nav">
		<div class="container tc-nav__inner">

			<a class="tc-nav__brand" href="<?php echo esc_url($home_url); ?>" aria-label="VisionONE — home">
				<img class="tc-nav__brand-logo"
					src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/logo.png'); ?>" alt=""
					aria-hidden="true">
				<span class="tc-nav__brand-text">Vision<span class="tc-nav__brand-text-accent">ONE</span></span>
			</a>

			<div class="tc-nav__collapse" id="tc-nav-menu">

				<!-- Centered primary links -->
				<nav class="tc-nav__menu" aria-label="Primary">
					<ul class="tc-nav__list">
						<?php foreach ($items as $label => $cfg):
							$is_active = ($cfg['tpl'] !== '' && $cfg['tpl'] === $current);
							$classes = 'tc-nav__link' . ($is_active ? ' is-active' : '');
							?>
							<li>
								<a class="<?php echo esc_attr($classes); ?>" href="<?php echo esc_url($cfg['url']); ?>" <?php echo $is_active ? 'aria-current="page"' : ''; ?>>
									<?php echo esc_html($label); ?>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</nav>

				<!-- Right-side actions -->
				<div class="tc-nav__actions">
					<a class="tc-nav__wa" href="<?php echo esc_url($talk_url); ?>" target="_blank" rel="noopener nofollow">
						<svg viewBox="0 0 32 32" width="16" height="16" aria-hidden="true" focusable="false">
							<path fill="currentColor"
								d="M16.04 3.2c-7.1 0-12.86 5.76-12.86 12.86 0 2.27.6 4.49 1.73 6.44L3.2 28.8l6.49-1.7a12.8 12.8 0 0 0 6.35 1.62h.01c7.1 0 12.86-5.76 12.86-12.86S23.14 3.2 16.04 3.2zm0 23.5h-.01a10.6 10.6 0 0 1-5.4-1.48l-.39-.23-3.85 1.01 1.03-3.75-.25-.39a10.62 10.62 0 1 1 19.72-5.6c0 5.87-4.78 10.65-10.65 10.65zm6.16-7.97c-.34-.17-2-.99-2.31-1.1-.31-.11-.54-.17-.76.17-.22.34-.87 1.1-1.07 1.32-.2.23-.39.25-.73.08-.34-.17-1.43-.53-2.72-1.68-1-.9-1.68-2-1.88-2.34-.2-.34-.02-.52.15-.69.15-.15.34-.39.51-.59.17-.2.22-.34.34-.57.11-.23.06-.43-.03-.6-.08-.17-.76-1.84-1.05-2.52-.27-.66-.55-.57-.76-.58l-.65-.01c-.22 0-.59.08-.9.43-.31.34-1.18 1.16-1.18 2.82s1.21 3.27 1.38 3.5c.17.23 2.38 3.64 5.77 5.1.81.35 1.43.56 1.92.71.81.26 1.54.22 2.12.13.65-.1 2-.82 2.28-1.6.28-.79.28-1.46.2-1.6-.08-.14-.31-.23-.65-.4z" />
						</svg>
						WhatsApp
					</a>
					<a class="tc-nav__cta" href="<?php echo esc_url($enquiry_url); ?>" data-magnetic>Enquire Now</a>
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
		})();
	</script>
	<?php
}
