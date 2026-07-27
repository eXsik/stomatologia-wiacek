<?php
/**
 * Single blog post template (Aktualności).
 * Handles native `post` singles; single-service.php handles Service CPT
 * entries separately since they need a different layout (no author box,
 * different schema type, related-services module instead of related posts).
 *
 * @package StomatologiaWiacek
 */

get_header();
?>
<main id="main">
	<div class="sw-container sw-single">
		<?php get_template_part( 'template-parts/components/breadcrumbs' ); ?>

		<?php while ( have_posts() ) : the_post(); ?>
			<article <?php post_class( 'sw-single__article' ); ?>>
				<header class="sw-single__header">
					<h1 class="sw-single__title"><?php the_title(); ?></h1>
					<time class="sw-single__date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
				</header>

				<?php if ( has_post_thumbnail() ) : ?>
					<div class="sw-single__thumbnail">
						<?php sw_image( get_post_thumbnail_id(), 'sw-hero', false ); ?>
					</div>
				<?php endif; ?>

				<div class="sw-single__content">
					<?php the_content(); ?>
				</div>
			</article>
		<?php endwhile; ?>
	</div>
</main>
<?php get_footer(); ?>
