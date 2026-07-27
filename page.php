<?php
/**
 * Generic page template — pages without a custom template.
 *
 * @package StomatologiaWiacek
 */

get_header();

while ( have_posts() ) :
	the_post();
	$lead = trim( (string) get_the_excerpt() );
	?>
<main id="main">
	<?php
	get_template_part(
		'template-parts/components/page-hero',
		null,
		array(
			'title' => get_the_title(),
			'lead'  => $lead,
		)
	);
	?>

	<div class="sw-container sw-page">
		<article <?php post_class( 'sw-page__article' ); ?>>
			<?php if ( has_post_thumbnail() ) : ?>
				<figure class="sw-page__media">
					<?php
					sw_image(
						get_post_thumbnail_id(),
						'large',
						false,
						array( 'alt' => get_the_title() )
					);
					?>
				</figure>
			<?php endif; ?>
			<div class="sw-page__content">
				<?php the_content(); ?>
			</div>
		</article>
	</div>
</main>
	<?php
endwhile;

get_footer();
