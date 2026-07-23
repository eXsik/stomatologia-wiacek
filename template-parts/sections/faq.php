<?php
/**
 * FAQ accordion section — editorial split on homepage.
 * Data: WP_Query on the `faq` CPT. Uses native <details>/<summary>.
 *
 * @package StomatologiaWiacek
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$faqs = new WP_Query( array(
	'post_type'      => 'faq',
	'posts_per_page' => 6,
	'orderby'        => 'menu_order',
	'order'          => 'ASC',
	'no_found_rows'  => true,
) );
?>
<section class="sw-faq" aria-labelledby="sw-faq-heading">
	<div class="sw-container sw-faq__layout">
		<div class="sw-faq__intro">
			<p class="sw-faq__eyebrow"><?php esc_html_e( 'FAQ', 'stomatologia-wiacek' ); ?></p>
			<h2 id="sw-faq-heading" class="sw-faq__heading">
				<?php esc_html_e( 'Najczęściej zadawane pytania.', 'stomatologia-wiacek' ); ?>
			</h2>
		</div>

		<?php if ( $faqs->have_posts() ) : ?>
			<div class="sw-faq__list">
				<?php while ( $faqs->have_posts() ) : $faqs->the_post(); ?>
					<details class="sw-faq__item">
						<summary class="sw-faq__question"><?php the_title(); ?></summary>
						<div class="sw-faq__answer"><?php the_content(); ?></div>
					</details>
				<?php endwhile; ?>
			</div>
			<?php sw_output_faq_schema( $faqs->posts ); ?>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
	</div>
</section>
