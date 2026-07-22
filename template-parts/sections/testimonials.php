<?php
/**
 * Testimonials / patient reviews section.
 * Data: WP_Query on the `testimonial` CPT.
 *
 * @package StomatologiaWiacek
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$testimonials = new WP_Query( array(
	'post_type'      => 'testimonial',
	'posts_per_page' => 3,
	'orderby'        => 'date',
	'order'          => 'DESC',
	'no_found_rows'  => true,
) );
?>
<section class="sw-testimonials" aria-labelledby="sw-testimonials-heading">
	<div class="sw-container">
		<h2 id="sw-testimonials-heading" class="sw-section-heading"><?php esc_html_e( 'Opinie pacjentów', 'stomatologia-wiacek' ); ?></h2>

		<?php if ( $testimonials->have_posts() ) : ?>
			<div class="sw-testimonials__grid">
				<?php while ( $testimonials->have_posts() ) : $testimonials->the_post(); ?>
					<?php get_template_part( 'template-parts/components/card-testimonial' ); ?>
				<?php endwhile; ?>
			</div>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
	</div>
</section>
