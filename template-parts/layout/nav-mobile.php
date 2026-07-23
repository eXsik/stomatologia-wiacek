<?php
/**
 * Off-canvas mobile navigation.
 * Focus is trapped here while open and returned to the toggle button
 * on close — handled by assets/scripts/modules/mobile-menu.js.
 *
 * @package StomatologiaWiacek
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div id="sw-mobile-menu" class="sw-mobile-menu" hidden>
	<div class="sw-mobile-menu__inner">
		<nav aria-label="<?php esc_attr_e( 'Menu główne (mobilne)', 'stomatologia-wiacek' ); ?>">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => false,
				'items_wrap'     => '<ul class="sw-mobile-menu__list">%3$s</ul>',
				'fallback_cb'    => false,
			) );
			?>
		</nav>
		<a href="<?php echo esc_url( sw_phone_href( sw_get_option( 'clinic_phone', '62 123 45 67' ) ) ); ?>" class="sw-btn sw-btn--outline sw-mobile-menu__phone">
			<?php echo esc_html( sw_get_option( 'clinic_phone', '62 123 45 67' ) ); ?>
		</a>
		<a href="<?php echo esc_url( sw_get_option( 'booking_url', '#kontakt' ) ); ?>" class="sw-btn sw-btn--accent sw-mobile-menu__cta"><?php esc_html_e( 'Umów wizytę', 'stomatologia-wiacek' ); ?></a>
	</div>
</div>
