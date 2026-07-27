<?php
/**
 * Single Service CPT template (e.g. /oferta/protetyka/).
 *
 * @package StomatologiaWiacek
 */

get_header();
?>
<main id="main">
	<?php
	while ( have_posts() ) :
		the_post();

		$price_range = function_exists( 'get_field' ) ? trim( (string) get_field( 'price_range' ) ) : '';
		$for_whom    = function_exists( 'get_field' ) ? trim( (string) get_field( 'service_for_whom' ) ) : '';
		$benefits_raw = function_exists( 'get_field' ) ? (string) get_field( 'service_benefits' ) : '';
		$benefits    = array();
		if ( '' !== trim( $benefits_raw ) ) {
			$lines = preg_split( '/\r\n|\r|\n/', $benefits_raw );
			if ( is_array( $lines ) ) {
				foreach ( $lines as $line ) {
					$line = trim( $line );
					if ( '' !== $line ) {
						$benefits[] = $line;
					}
				}
			}
		}

		$lead = trim( (string) get_the_excerpt() );
		if ( '' === $lead ) {
			$lead = wp_trim_words( wp_strip_all_tags( get_the_content() ), 28 );
		}

		$related = new WP_Query( array(
			'post_type'      => 'service',
			'posts_per_page' => 3,
			'post__not_in'   => array( get_the_ID() ),
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
			'no_found_rows'  => true,
		) );
		$hero_args = array(
			'eyebrow'       => __( 'Usługa', 'stomatologia-wiacek' ),
			'title'         => get_the_title(),
			'lead'          => $lead,
			'price'         => $price_range,
			'show_actions'  => false,
		);

		if ( has_post_thumbnail() ) {
			$hero_args['media_id']      = (int) get_post_thumbnail_id();
			$hero_args['show_actions']  = true;
		} else {
			$hero_args['aside_variant'] = 'booking';
		}

		get_template_part( 'template-parts/components/page-hero', null, $hero_args );
		?>

		<div class="sw-container sw-single-service">
			<article <?php post_class( 'sw-single-service__layout' ); ?>>
				<div class="sw-single-service__main">
					<?php if ( ! empty( $benefits ) ) : ?>
						<section class="sw-service-benefits" aria-labelledby="sw-service-benefits-heading">
							<h2 id="sw-service-benefits-heading" class="sw-service-block__title">
								<?php esc_html_e( 'Co zyskujesz', 'stomatologia-wiacek' ); ?>
							</h2>
							<ul class="sw-service-benefits__list">
								<?php foreach ( $benefits as $benefit ) : ?>
									<li><?php echo esc_html( $benefit ); ?></li>
								<?php endforeach; ?>
							</ul>
						</section>
					<?php endif; ?>

					<?php if ( '' !== $for_whom ) : ?>
						<section class="sw-service-block" aria-labelledby="sw-service-for-whom-heading">
							<h2 id="sw-service-for-whom-heading" class="sw-service-block__title">
								<?php esc_html_e( 'Dla kogo?', 'stomatologia-wiacek' ); ?>
							</h2>
							<p class="sw-service-block__text"><?php echo esc_html( $for_whom ); ?></p>
						</section>
					<?php endif; ?>

					<?php if ( get_the_content() ) : ?>
						<section class="sw-service-block" aria-labelledby="sw-service-content-heading">
							<h2 id="sw-service-content-heading" class="sw-service-block__title">
								<?php esc_html_e( 'Jak wygląda leczenie', 'stomatologia-wiacek' ); ?>
							</h2>
							<div class="sw-single-service__content">
								<?php the_content(); ?>
							</div>
						</section>
					<?php endif; ?>
				</div>

				<aside class="sw-single-service__aside" aria-label="<?php esc_attr_e( 'Kontakt i wizyta', 'stomatologia-wiacek' ); ?>">
					<div class="sw-service-aside-card">
						<p class="sw-service-aside-card__eyebrow"><?php esc_html_e( 'Następny krok', 'stomatologia-wiacek' ); ?></p>
						<h2 class="sw-service-aside-card__title">
							<?php esc_html_e( 'Umów konsultację', 'stomatologia-wiacek' ); ?>
						</h2>
						<p class="sw-service-aside-card__text">
							<?php esc_html_e( 'Opowiedz o swoich oczekiwaniach — zaproponujemy spokojny, indywidualny plan.', 'stomatologia-wiacek' ); ?>
						</p>
						<a class="sw-btn sw-btn--accent sw-btn--arrow sw-service-aside-card__btn" href="<?php echo esc_url( sw_booking_url() ); ?>"<?php echo sw_booking_trigger_attrs(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
							<?php esc_html_e( 'Umów wizytę', 'stomatologia-wiacek' ); ?>
						</a>
						<a class="sw-service-aside-card__phone" href="<?php echo esc_url( sw_phone_href( sw_get_option( 'clinic_phone', '62 123 45 67' ) ) ); ?>">
							<?php echo esc_html( sw_get_option( 'clinic_phone', '62 123 45 67' ) ); ?>
						</a>
					</div>
				</aside>
			</article>

			<?php if ( $related->have_posts() ) : ?>
				<section class="sw-service-related" aria-labelledby="sw-service-related-heading">
					<div class="sw-archive__intro">
						<p class="sw-page-hero__eyebrow"><?php esc_html_e( 'Oferta', 'stomatologia-wiacek' ); ?></p>
						<h2 id="sw-service-related-heading" class="sw-archive__title">
							<?php esc_html_e( 'Inne usługi', 'stomatologia-wiacek' ); ?>
						</h2>
					</div>
					<div class="sw-services__grid">
						<?php
						while ( $related->have_posts() ) :
							$related->the_post();
							get_template_part( 'template-parts/components/card-service' );
						endwhile;
						wp_reset_postdata();
						?>
					</div>
				</section>
			<?php endif; ?>
		</div>
	<?php endwhile; ?>
</main>
<?php get_footer(); ?>
