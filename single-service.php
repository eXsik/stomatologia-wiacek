<?php
/**
 * Single Service CPT template (e.g. /oferta/implanty/).
 * Demonstrates the section-based pattern extends beyond the homepage.
 *
 * @package StomatologiaWiacek
 */

get_header();
?>
<main id="main">
	<div class="sw-container sw-single-service">
		<?php get_template_part( 'template-parts/components/breadcrumbs' ); ?>

		<?php while ( have_posts() ) : the_post(); ?>
			<?php
			$icon        = get_field( 'icon' ) ?: 'aesthetic';
			$price_range = get_field( 'price_range' );
			?>
			<article <?php post_class( 'sw-single-service__article' ); ?>>
				<header class="sw-single-service__header">
					<span class="sw-icon sw-icon--<?php echo esc_attr( $icon ); ?>" aria-hidden="true"></span>
					<h1><?php the_title(); ?></h1>
					<?php if ( $price_range ) : ?>
						<p class="sw-single-service__price"><?php echo esc_html( $price_range ); ?></p>
					<?php endif; ?>
				</header>

				<?php if ( has_post_thumbnail() ) : ?>
					<?php sw_image( get_post_thumbnail_id(), 'sw-hero', false ); ?>
				<?php endif; ?>

				<div class="sw-single-service__content">
					<?php the_content(); ?>
				</div>

				<div class="sw-single-service__cta">
					<?php sw_button( __( 'Umów wizytę', 'stomatologia-wiacek' ), home_url( '/#kontakt' ), 'accent', 'lg' ); ?>
				</div>
			</article>
		<?php endwhile; ?>
	</div>
</main>
<?php get_footer(); ?>
