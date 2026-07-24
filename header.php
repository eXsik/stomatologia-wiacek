<?php
/**
 * The header for the theme.
 * Loaded on every template via get_header().
 *
 * @package StomatologiaWiacek
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="sw-skip-link" href="#main"><?php esc_html_e( 'Przejdź do treści', 'stomatologia-wiacek' ); ?></a>

<header class="sw-header" id="site-header" data-sw-sticky-header>
	<div class="sw-container sw-header__inner">

		<div class="sw-header__logo">
			<a class="sw-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<span class="sw-visually-hidden"><?php bloginfo( 'name' ); ?></span>
				<span class="sw-logo__name" aria-hidden="true"><?php echo esc_html( 'WIĄCEK' ); ?></span>
				<span class="sw-logo__descriptor" aria-hidden="true"><?php echo esc_html( 'STOMATOLOGIA' ); ?></span>
			</a>
		</div>

		<nav class="sw-nav" aria-label="<?php esc_attr_e( 'Menu główne', 'stomatologia-wiacek' ); ?>">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => false,
				'items_wrap'     => '<ul class="sw-nav__list" role="menubar">%3$s</ul>',
				'walker'         => new SW_Nav_Walker(),
				'fallback_cb'    => false,
			) );
			?>
		</nav>

		<div class="sw-header__actions">
			<a href="<?php echo esc_url( sw_phone_href( sw_get_option( 'clinic_phone', '62 123 45 67' ) ) ); ?>" class="sw-header__phone">
				<span class="sw-visually-hidden"><?php esc_html_e( 'Zadzwoń: ', 'stomatologia-wiacek' ); ?></span>
				<svg class="sw-header__phone-icon" width="14" height="14" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
					<path fill="currentColor" d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1.1-.2 1.2.4 2.5.6 3.8.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1C10.6 21 3 13.4 3 4c0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.6.6 3.8.1.4 0 .8-.3 1.1L6.6 10.8z"/>
				</svg>
				<?php echo esc_html( sw_get_option( 'clinic_phone', '62 123 45 67' ) ); ?>
			</a>
			<a href="<?php echo esc_url( sw_booking_url() ); ?>" class="sw-btn sw-btn--accent sw-btn--arrow sw-header__cta"<?php echo sw_booking_trigger_attrs(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- attrs are fixed. ?>><?php esc_html_e( 'Umów wizytę', 'stomatologia-wiacek' ); ?></a>

			<button type="button" class="sw-nav-toggle" aria-expanded="false" aria-controls="sw-mobile-menu" data-sw-mobile-menu-toggle>
				<span class="sw-visually-hidden"><?php esc_html_e( 'Otwórz menu', 'stomatologia-wiacek' ); ?></span>
				<span class="sw-nav-toggle__bars" aria-hidden="true"></span>
			</button>
		</div>

	</div>

	<?php get_template_part( 'template-parts/layout/nav-mobile' ); ?>
</header>
