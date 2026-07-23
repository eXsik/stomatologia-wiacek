<?php
/**
 * The footer for the theme.
 * Loaded on every template via get_footer().
 *
 * @package StomatologiaWiacek
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$footer_services = new WP_Query( array(
	'post_type'      => 'service',
	'posts_per_page' => 6,
	'orderby'        => 'menu_order',
	'order'          => 'ASC',
	'no_found_rows'  => true,
) );

$privacy_url = function_exists( 'get_privacy_policy_url' ) ? get_privacy_policy_url() : '';
?>
	<footer class="sw-footer">
		<div class="sw-container sw-footer__grid">

			<div class="sw-footer__brand">
				<a class="sw-footer__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<span class="sw-footer__logo-name" aria-hidden="true"><?php echo esc_html( 'WIĄCEK' ); ?></span>
					<span class="sw-footer__logo-descriptor" aria-hidden="true"><?php echo esc_html( 'STOMATOLOGIA' ); ?></span>
					<span class="sw-visually-hidden"><?php bloginfo( 'name' ); ?></span>
				</a>
				<div class="sw-footer__socials">
					<?php if ( sw_get_option( 'social_instagram' ) ) : ?>
						<a href="<?php echo esc_url( sw_get_option( 'social_instagram' ) ); ?>" aria-label="<?php esc_attr_e( 'Instagram', 'stomatologia-wiacek' ); ?>">Instagram</a>
					<?php endif; ?>
					<?php if ( sw_get_option( 'social_facebook' ) ) : ?>
						<a href="<?php echo esc_url( sw_get_option( 'social_facebook' ) ); ?>" aria-label="<?php esc_attr_e( 'Facebook', 'stomatologia-wiacek' ); ?>">Facebook</a>
					<?php endif; ?>
				</div>
			</div>

			<div class="sw-footer__col">
				<h2 class="sw-footer__heading"><?php esc_html_e( 'Nawigacja', 'stomatologia-wiacek' ); ?></h2>
				<?php
				wp_nav_menu( array(
					'theme_location' => 'footer',
					'container'      => false,
					'items_wrap'     => '<ul class="sw-footer__menu">%3$s</ul>',
					'fallback_cb'    => false,
				) );
				?>
			</div>

			<div class="sw-footer__col">
				<h2 class="sw-footer__heading"><?php esc_html_e( 'Usługi', 'stomatologia-wiacek' ); ?></h2>
				<?php if ( $footer_services->have_posts() ) : ?>
					<ul class="sw-footer__menu">
						<?php
						while ( $footer_services->have_posts() ) :
							$footer_services->the_post();
							?>
							<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
						<?php endwhile; ?>
					</ul>
				<?php endif; ?>
				<?php wp_reset_postdata(); ?>
			</div>

			<div class="sw-footer__col">
				<h2 class="sw-footer__heading"><?php esc_html_e( 'Godziny otwarcia', 'stomatologia-wiacek' ); ?></h2>
				<ul class="sw-footer__hours">
					<?php
					$hours = sw_get_option( 'clinic_hours', array() );
					if ( sw_has_rows( $hours ) ) :
						foreach ( $hours as $row ) :
							if ( empty( $row['day'] ) || empty( $row['open'] ) || empty( $row['close'] ) ) {
								continue;
							}
							?>
							<li>
								<span><?php echo esc_html( $row['day'] ); ?></span>
								<span><?php echo esc_html( $row['open'] . '–' . $row['close'] ); ?></span>
							</li>
							<?php
						endforeach;
					endif;
					?>
				</ul>
			</div>

			<div class="sw-footer__col">
				<h2 class="sw-footer__heading"><?php esc_html_e( 'Kontakt', 'stomatologia-wiacek' ); ?></h2>
				<p class="sw-footer__contact-line"><?php echo esc_html( sw_get_option( 'clinic_address', 'ul. Przykładowa 1, 63-400 Ostrów Wielkopolski' ) ); ?></p>
				<p class="sw-footer__contact-line">
					<a href="<?php echo esc_url( sw_phone_href( sw_get_option( 'clinic_phone', '62 123 45 67' ) ) ); ?>">
						<?php echo esc_html( sw_get_option( 'clinic_phone', '62 123 45 67' ) ); ?>
					</a>
				</p>
				<p class="sw-footer__contact-line">
					<a href="mailto:<?php echo esc_attr( sw_get_option( 'clinic_email' ) ); ?>">
						<?php echo esc_html( sw_get_option( 'clinic_email' ) ); ?>
					</a>
				</p>
			</div>

		</div>

		<div class="sw-container sw-footer__legal">
			<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'Wszelkie prawa zastrzeżone.', 'stomatologia-wiacek' ); ?></p>
			<div class="sw-footer__legal-links">
				<?php if ( $privacy_url ) : ?>
					<a href="<?php echo esc_url( $privacy_url ); ?>"><?php esc_html_e( 'Polityka prywatności', 'stomatologia-wiacek' ); ?></a>
				<?php endif; ?>
				<p class="sw-footer__disclaimer"><?php esc_html_e( 'Niekomercyjny projekt portfolio — koncepcja redesignu.', 'stomatologia-wiacek' ); ?></p>
			</div>
		</div>
	</footer>

	<?php get_template_part( 'template-parts/layout/sticky-cta-bar' ); ?>

	<?php wp_footer(); ?>
</body>
</html>
