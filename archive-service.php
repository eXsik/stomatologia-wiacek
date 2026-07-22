<?php
/**
 * Service archive template — /oferta/ index, reuses the same
 * card-service component as the homepage grid for visual consistency.
 *
 * @package StomatologiaWiacek
 */

get_header();
?>
<main id="main">
	<div class="sw-container sw-archive">
		<?php get_template_part( 'template-parts/components/breadcrumbs' ); ?>

		<h1 class="sw-section-heading"><?php esc_html_e( 'Oferta', 'stomatologia-wiacek' ); ?></h1>

		<?php if ( have_posts() ) : ?>
			<div class="sw-services__grid">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'template-parts/components/card-service' ); ?>
				<?php endwhile; ?>
			</div>
			<?php the_posts_pagination(); ?>
		<?php endif; ?>
	</div>
</main>
<?php get_footer(); ?>
