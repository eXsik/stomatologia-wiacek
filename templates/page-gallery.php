<?php
/**
 * Page template: Metamorfozy — gallery section.
 *
 * Template Name: Metamorfozy
 *
 * @package StomatologiaWiacek
 */

get_header();

$title = '';
$lead  = __( 'Realne efekty leczenia — zawsze z indywidualnym planem i transparentną rozmową o możliwościach.', 'stomatologia-wiacek' );
if ( have_posts() ) {
	the_post();
	$title = get_the_title();
	$raw   = trim( wp_strip_all_tags( get_the_excerpt() ) );
	if ( '' !== $raw ) {
		$lead = $raw;
	}
}
?>
<main id="main">
	<?php
	get_template_part(
		'template-parts/components/page-hero',
		null,
		array(
			'eyebrow'        => __( 'Metamorfozy', 'stomatologia-wiacek' ),
			'title'          => $title,
			'lead'           => $lead,
			'aside_variant'  => 'gallery',
		)
	);
	?>

	<?php get_template_part( 'template-parts/sections/gallery-teaser' ); ?>
</main>
<?php
get_footer();
