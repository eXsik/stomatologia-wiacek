<?php
/**
 * Page template: Zespół — team grid.
 *
 * Template Name: Zespół
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
	$lead = __( 'Poznaj lekarzy i personel, którzy dbają o spokój, precyzję i przejrzystą komunikację na każdym etapie leczenia.', 'stomatologia-wiacek' );
}
?>
<main id="main">
	<?php
	get_template_part(
		'template-parts/components/page-hero',
		null,
		array(
			'eyebrow'        => __( 'Zespół', 'stomatologia-wiacek' ),
			'title'          => $title,
			'lead'           => $lead,
			'aside_variant'  => 'team',
		)
	);
	?>

	<div class="sw-container sw-page">
		<?php
		get_template_part(
			'template-parts/pages/team-grid',
			null,
			array( 'hide_intro' => true )
		);
		?>
	</div>
</main>
<?php
get_footer();
