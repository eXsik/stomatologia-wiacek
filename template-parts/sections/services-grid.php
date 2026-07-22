<?php
/**
 * Services grid section.
 * Data: WP_Query on the `service` CPT — adding a new service in the
 * admin requires zero template changes.
 *
 * @package StomatologiaWiacek
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$services = new WP_Query( array(
	'post_type'      => 'service',
	'posts_per_page' => 8,
	'orderby'        => 'menu_order',
	'order'          => 'ASC',
	'no_found_rows'  => true,
) );
?>
<section class="sw-services" id="oferta" aria-labelledby="sw-services-heading">
	<div class="sw-container">
		<h2 id="sw-services-heading" class="sw-section-heading"><?php esc_html_e( 'Nasza oferta', 'stomatologia-wiacek' ); ?></h2>

		<?php if ( $services->have_posts() ) : ?>
			<div class="sw-services__grid">
				<?php while ( $services->have_posts() ) : $services->the_post(); ?>
					<?php get_template_part( 'template-parts/components/card-service' ); ?>
				<?php endwhile; ?>
			</div>
		<?php else : ?>
			<p><?php esc_html_e( 'Usługi pojawią się tutaj wkrótce.', 'stomatologia-wiacek' ); ?></p>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
	</div>
</section>
