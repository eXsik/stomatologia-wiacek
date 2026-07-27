<?php
/**
 * Template Name: Kontakt
 *
 * Custom page template for the Kontakt page — full map/form section.
 *
 * @package StomatologiaWiacek
 */

get_header();

$title = '';
$lead  = __( 'Zadzwoń, napisz lub umów wizytę — odpowiemy jasno i bez presji.', 'stomatologia-wiacek' );
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
			'eyebrow'        => __( 'Kontakt', 'stomatologia-wiacek' ),
			'title'          => $title,
			'lead'           => $lead,
			'aside_variant'  => 'contact',
		)
	);
	?>

	<?php get_template_part( 'template-parts/sections/contact-full' ); ?>
</main>
<?php
get_footer();
