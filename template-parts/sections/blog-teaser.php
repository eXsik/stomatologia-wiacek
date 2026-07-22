<?php
/**
 * Blog / news teaser section — demoted from its dominant position on
 * the legacy site to a supporting late-page slot (see UX audit).
 * Data: standard WP_Query on native Posts (genuine blog content, not a CPT).
 *
 * @package StomatologiaWiacek
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$posts_query = new WP_Query( array(
	'post_type'      => 'post',
	'posts_per_page' => 3,
	'no_found_rows'  => true,
) );
?>
<section class="sw-blog-teaser" aria-labelledby="sw-blog-heading">
	<div class="sw-container">
		<h2 id="sw-blog-heading" class="sw-section-heading"><?php esc_html_e( 'Aktualności', 'stomatologia-wiacek' ); ?></h2>

		<?php if ( $posts_query->have_posts() ) : ?>
			<div class="sw-blog-teaser__grid">
				<?php while ( $posts_query->have_posts() ) : $posts_query->the_post(); ?>
					<?php get_template_part( 'template-parts/components/card-post' ); ?>
				<?php endwhile; ?>
			</div>
			<a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>" class="sw-link"><?php esc_html_e( 'Zobacz wszystkie wpisy', 'stomatologia-wiacek' ); ?></a>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
	</div>
</section>
