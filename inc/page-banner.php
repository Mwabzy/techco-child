<?php
/**
 * Reusable page banner / title bar.
 * Mirrors Techco parent's .breadcrumb.page-banner so coded pages match native pages.
 *
 * Usage: techco_child_page_banner( 'Page Title', 'Optional subtitle' );
 *
 * @package Techco Child
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! function_exists( 'techco_child_page_banner' ) ) {
    function techco_child_page_banner( $title = '', $subtitle = '' ) {
        if ( empty( $title ) ) {
            $title = get_the_title();
        }
        ?>
        <div class="breadcrumb page-banner pos-rel">
            <div class="container">
                <div class="breadcrumb__content text-center">
                    <h2 class="breadcrumb__title"><?php echo esc_html( $title ); ?></h2>
                    <?php if ( ! empty( $subtitle ) ) : ?>
                        <p class="breadcrumb__subtitle"><?php echo esc_html( $subtitle ); ?></p>
                    <?php endif; ?>
                    <?php if ( function_exists( 'bcn_display' ) ) : ?>
                        <div class="breadcrumb-container"><?php bcn_display(); ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
    }
}
