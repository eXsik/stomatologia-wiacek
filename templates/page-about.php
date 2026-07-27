<?php
/**
 * Page template: O nas / Zespół — editorial intro + team grid.
 *
 * Template Name: O nas / Zespół
 *
 * @package StomatologiaWiacek
 */

get_header();

$title = '';
$lead  = '';
if ( have_posts() ) {
	the_post();
	$title = get_the_title();
	$raw   = wp_strip_all_tags( get_the_excerpt() );
	if ( '' === $raw ) {
		$raw = wp_trim_words( wp_strip_all_tags( get_the_content() ), 28 );
	}
	$lead = $raw;
}
if ( '' === $lead ) {
	$lead = __( 'Gabinet stomatologiczny w centrum Ostrowa Wielkopolskiego — nowoczesne leczenie, spokojne podejście i przejrzysta komunikacja.', 'stomatologia-wiacek' );
}
?>
<main id="main">
	<?php
	get_template_part(
		'template-parts/components/page-hero',
		null,
		array(
			'eyebrow'        => __( 'Gabinet', 'stomatologia-wiacek' ),
			'title'          => $title,
			'lead'           => $lead,
			'aside_variant'  => 'about',
		)
	);
	?>

	<div class="sw-container sw-page">
		<?php get_template_part( 'template-parts/pages/about-intro' ); ?>

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

			<?php if ( get_the_content() ) : ?>
				<div class="sw-page__content">
					<?php the_content(); ?>
				</div>
			<?php endif; ?>
		</article>

		<?php get_template_part( 'template-parts/pages/team-grid' ); ?>
	</div>
</main>
<?php
get_footer();
