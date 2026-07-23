<?php
/**
 * Services section — editorial numbered list (homepage).
 * Data: WP_Query on the `service` CPT ordered by menu_order, limit 6.
 *
 * @package StomatologiaWiacek
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$services = new WP_Query( array(
	'post_type'      => 'service',
	'posts_per_page' => 6,
	'orderby'        => 'menu_order',
	'order'          => 'ASC',
	'no_found_rows'  => true,
) );

$detail_id = 0;
if ( function_exists( 'get_field' ) ) {
	$detail_id = (int) get_field( 'services_detail_image' );
}
if ( ! $detail_id ) {
	$detail_id = (int) get_post_thumbnail_id( (int) get_queried_object_id() );
}

$index = 0;
?>
<section class="sw-services" id="oferta" aria-labelledby="sw-services-heading">
	<div class="sw-container sw-services__layout">
		<div class="sw-services__intro">
			<p class="sw-services__eyebrow"><?php esc_html_e( 'Usługi', 'stomatologia-wiacek' ); ?></p>
			<h2 id="sw-services-heading" class="sw-services__heading">
				<?php esc_html_e( 'Kompleksowa opieka na najwyższym poziomie.', 'stomatologia-wiacek' ); ?>
			</h2>
			<figure class="sw-services__detail<?php echo $detail_id ? '' : ' sw-services__detail--placeholder'; ?>">
				<?php if ( $detail_id ) : ?>
					<?php
					sw_image(
						$detail_id,
						'sw-card',
						false,
						array(
							'class' => 'sw-services__detail-image',
							'alt'   => '',
						)
					);
					?>
				<?php else : ?>
					<span class="sw-visually-hidden"><?php esc_html_e( 'Dekoracja sekcji usług', 'stomatologia-wiacek' ); ?></span>
				<?php endif; ?>
			</figure>
		</div>

		<?php if ( $services->have_posts() ) : ?>
			<ul class="sw-services__list">
				<?php
				while ( $services->have_posts() ) :
					$services->the_post();
					$index++;
					$number  = str_pad( (string) $index, 2, '0', STR_PAD_LEFT );
					$excerpt = get_the_excerpt();
					if ( '' === trim( (string) $excerpt ) ) {
						$excerpt = wp_trim_words( wp_strip_all_tags( get_the_content() ), 14 );
					} else {
						$excerpt = wp_trim_words( $excerpt, 14 );
					}
					?>
					<li class="sw-services__item">
						<a class="sw-services__link" href="<?php the_permalink(); ?>">
							<span class="sw-services__number" aria-hidden="true"><?php echo esc_html( $number ); ?></span>
							<span class="sw-services__body">
								<span class="sw-services__title"><?php the_title(); ?></span>
								<?php if ( '' !== trim( (string) $excerpt ) ) : ?>
									<span class="sw-services__summary"><?php echo esc_html( $excerpt ); ?></span>
								<?php endif; ?>
							</span>
							<span class="sw-services__arrow" aria-hidden="true">→</span>
						</a>
					</li>
				<?php endwhile; ?>
			</ul>
		<?php else : ?>
			<p class="sw-services__empty"><?php esc_html_e( 'Usługi pojawią się tutaj wkrótce.', 'stomatologia-wiacek' ); ?></p>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
	</div>
</section>
