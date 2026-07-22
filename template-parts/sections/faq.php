<?php
/**
 * FAQ accordion section.
 * Data: WP_Query on the `faq` CPT. Uses native <details>/<summary> so
 * the expand/collapse behaviour works with zero JavaScript; a small
 * enhancement script only adds smoother open/close animation.
 * FAQPage JSON-LD is generated from the exact same query results,
 * so visible content and schema can never drift apart.
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
	<div class="sw-container sw-faq__inner">
		<h2 id="sw-faq-heading" class="sw-section-heading"><?php esc_html_e( 'Najczęściej zadawane pytania', 'stomatologia-wiacek' ); ?></h2>

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
