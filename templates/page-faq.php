<?php
/**
 * Page template: FAQ — accordion section.
 *
 * Template Name: FAQ
 *
 * @package StomatologiaWiacek
 */

get_header();

$title = '';
$lead  = __( 'Krótkie odpowiedzi na pytania, które pacjenci zadają najczęściej przed pierwszą wizytą.', 'stomatologia-wiacek' );
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
			'eyebrow'        => __( 'FAQ', 'stomatologia-wiacek' ),
			'title'          => $title,
			'lead'           => $lead,
			'aside_variant'  => 'faq',
		)
	);
	?>

	<?php get_template_part( 'template-parts/sections/faq' ); ?>
</main>
<?php
get_footer();
