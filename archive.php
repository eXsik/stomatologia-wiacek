<?php
/**
 * Fallback archive template — blog category/tag listings, or any
 * archive without a more specific template (e.g. archive-service.php).
 *
 * @package StomatologiaWiacek
 */

get_header();
?>
<main id="main">
	<div class="sw-container sw-archive">
		<?php get_template_part( 'template-parts/components/breadcrumbs' ); ?>

		<h1 class="sw-section-heading"><?php the_archive_title(); ?></h1>

		<?php if ( have_posts() ) : ?>
			<div class="sw-blog-teaser__grid">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'template-parts/components/card-post' ); ?>
				<?php endwhile; ?>
			</div>
			<?php the_posts_pagination(); ?>
		<?php else : ?>
			<p><?php esc_html_e( 'Brak wpisów.', 'stomatologia-wiacek' ); ?></p>
		<?php endif; ?>
	</div>
</main>
<?php get_footer(); ?>
