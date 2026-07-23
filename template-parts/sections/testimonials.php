<?php
/**
 * Testimonials — open editorial quotes (homepage).
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
	<div class="sw-container sw-testimonials__layout">
		<div class="sw-testimonials__intro">
			<p class="sw-testimonials__eyebrow"><?php esc_html_e( 'Opinie', 'stomatologia-wiacek' ); ?></p>
			<h2 id="sw-testimonials-heading" class="sw-testimonials__heading">
				<?php esc_html_e( 'Zaufanie naszych pacjentów.', 'stomatologia-wiacek' ); ?>
			</h2>
		</div>

		<?php if ( $testimonials->have_posts() ) : ?>
			<div class="sw-testimonials__quotes">
				<?php
				while ( $testimonials->have_posts() ) :
					$testimonials->the_post();
					$quote = '';
					if ( function_exists( 'get_field' ) ) {
						$quote = trim( (string) ( get_field( 'quote' ) ?: '' ) );
					}
					if ( '' === $quote ) {
						$quote = wp_trim_words( wp_strip_all_tags( get_the_content() ), 28 );
					}
					$treatment = function_exists( 'get_field' ) ? trim( (string) ( get_field( 'treatment' ) ?: '' ) ) : '';
					?>
					<figure class="sw-testimonials__item">
						<span class="sw-testimonials__mark" aria-hidden="true">&ldquo;</span>
						<blockquote class="sw-testimonials__quote">
							<p><?php echo esc_html( $quote ); ?></p>
						</blockquote>
						<figcaption class="sw-testimonials__author">
							<span class="sw-testimonials__name"><?php the_title(); ?></span>
							<?php if ( '' !== $treatment ) : ?>
								<span class="sw-testimonials__treatment"><?php echo esc_html( $treatment ); ?></span>
							<?php endif; ?>
						</figcaption>
					</figure>
				<?php endwhile; ?>
			</div>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
	</div>
</section>
