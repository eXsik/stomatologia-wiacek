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
				<?php echo esc_html( sw_get_option( 'clinic_phone', '62 123 45 67' ) ); ?>
			</a>
			<a href="<?php echo esc_url( sw_get_option( 'booking_url', '#kontakt' ) ); ?>" class="sw-btn sw-btn--accent sw-header__cta"><?php esc_html_e( 'Umów wizytę', 'stomatologia-wiacek' ); ?></a>

			<button type="button" class="sw-nav-toggle" aria-expanded="false" aria-controls="sw-mobile-menu" data-sw-mobile-menu-toggle>
				<span class="sw-visually-hidden"><?php esc_html_e( 'Otwórz menu', 'stomatologia-wiacek' ); ?></span>
				<span class="sw-nav-toggle__bars" aria-hidden="true"></span>
			</button>
		</div>

	</div>

	<?php get_template_part( 'template-parts/layout/nav-mobile' ); ?>
</header>
