<?php
/**
 * Template Name: Kontakt
 *
 * Custom page template for the Kontakt page — full map/form section.
 * Homepage uses the compact contact CTA band instead.
 *
 * @package StomatologiaWiacek
 */

get_header();
?>
<main id="main">
	<div class="sw-container sw-page">
		<?php get_template_part( 'template-parts/components/breadcrumbs' ); ?>

		<?php while ( have_posts() ) : the_post(); ?>
			<h1 class="sw-page__title"><?php the_title(); ?></h1>
			<div class="sw-page__content"><?php the_content(); ?></div>
		<?php endwhile; ?>
	</div>

	<?php get_template_part( 'template-parts/sections/contact-full' ); ?>
</main>
<?php get_footer(); ?>
