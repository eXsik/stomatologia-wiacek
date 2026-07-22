<?php
/**
 * Generic page template — used for any WP Page without a more specific
 * custom template (e.g. O nas, Polityka prywatności).
 *
 * @package StomatologiaWiacek
 */

get_header();
?>
<main id="main">
	<div class="sw-container sw-page">
		<?php get_template_part( 'template-parts/components/breadcrumbs' ); ?>

		<?php while ( have_posts() ) : the_post(); ?>
			<article <?php post_class( 'sw-page__article' ); ?>>
				<h1 class="sw-page__title"><?php the_title(); ?></h1>
				<div class="sw-page__content">
					<?php the_content(); ?>
				</div>
			</article>
		<?php endwhile; ?>
	</div>
</main>
<?php get_footer(); ?>
