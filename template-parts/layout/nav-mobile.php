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
		<div class="sw-mobile-menu__top">
			<a class="sw-logo sw-mobile-menu__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<span class="sw-visually-hidden"><?php bloginfo( 'name' ); ?></span>
				<span class="sw-logo__name" aria-hidden="true"><?php echo esc_html( 'WIĄCEK' ); ?></span>
				<span class="sw-logo__descriptor" aria-hidden="true"><?php echo esc_html( 'STOMATOLOGIA' ); ?></span>
			</a>
			<button type="button" class="sw-mobile-menu__close" data-sw-mobile-menu-close>
				<span class="sw-visually-hidden"><?php esc_html_e( 'Zamknij menu', 'stomatologia-wiacek' ); ?></span>
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
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
		<a href="<?php echo esc_url( sw_booking_url() ); ?>" class="sw-btn sw-btn--accent sw-btn--arrow sw-mobile-menu__cta"<?php echo sw_booking_trigger_attrs(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php esc_html_e( 'Umów wizytę', 'stomatologia-wiacek' ); ?></a>
	</div>
</div>
