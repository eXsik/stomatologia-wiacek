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
?>
	<footer class="sw-footer">
		<div class="sw-container sw-footer__grid">

			<div class="sw-footer__col">
				<p class="sw-footer__logo"><?php bloginfo( 'name' ); ?></p>
				<p><?php echo esc_html( sw_get_option( 'clinic_address', 'ul. Przykładowa 1, 63-400 Ostrów Wielkopolski' ) ); ?></p>
				<a href="<?php echo esc_url( sw_phone_href( sw_get_option( 'clinic_phone', '62 123 45 67' ) ) ); ?>"><?php echo esc_html( sw_get_option( 'clinic_phone', '62 123 45 67' ) ); ?></a><br>
				<a href="mailto:<?php echo esc_attr( sw_get_option( 'clinic_email' ) ); ?>"><?php echo esc_html( sw_get_option( 'clinic_email' ) ); ?></a>
			</div>

			<div class="sw-footer__col">
				<h2 class="sw-footer__heading"><?php esc_html_e( 'Nawigacja', 'stomatologia-wiacek' ); ?></h2>
				<?php
				wp_nav_menu( array(
					'theme_location' => 'footer',
					'container'      => false,
					'items_wrap'     => '<ul>%3$s</ul>',
					'fallback_cb'    => false,
				) );
				?>
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
							<li><span><?php echo esc_html( $row['day'] ); ?></span> <span><?php echo esc_html( $row['open'] . '–' . $row['close'] ); ?></span></li>
							<?php
						endforeach;
					endif;
					?>
				</ul>
			</div>

			<div class="sw-footer__col">
				<h2 class="sw-footer__heading"><?php esc_html_e( 'Obserwuj nas', 'stomatologia-wiacek' ); ?></h2>
				<div class="sw-footer__socials">
					<?php if ( sw_get_option( 'social_facebook' ) ) : ?>
						<a href="<?php echo esc_url( sw_get_option( 'social_facebook' ) ); ?>" aria-label="Facebook">Facebook</a>
					<?php endif; ?>
					<?php if ( sw_get_option( 'social_instagram' ) ) : ?>
						<a href="<?php echo esc_url( sw_get_option( 'social_instagram' ) ); ?>" aria-label="Instagram">Instagram</a>
					<?php endif; ?>
				</div>
			</div>

		</div>

		<div class="sw-container sw-footer__legal">
			<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'Wszelkie prawa zastrzeżone.', 'stomatologia-wiacek' ); ?></p>
			<p class="sw-footer__disclaimer"><?php esc_html_e( 'To jest niekomercyjny projekt portfolio — koncepcja redesignu, niepowiązana oficjalnie z gabinetem.', 'stomatologia-wiacek' ); ?></p>
		</div>
	</footer>

	<?php get_template_part( 'template-parts/layout/sticky-cta-bar' ); ?>

	<?php wp_footer(); ?>
</body>
</html>
