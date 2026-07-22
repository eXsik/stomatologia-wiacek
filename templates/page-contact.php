<?php
/**
 * Template Name: Kontakt
 *
 * Custom page template assigned to the Kontakt page — reuses the same
 * contact section as the homepage so the map/form/NAP markup and its
 * JSON-LD only exist in one place.
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

	<?php get_template_part( 'template-parts/sections/contact' ); ?>
</main>
<?php get_footer(); ?>
