<?php
/**
 * 404 template.
 *
 * @package StomatologiaWiacek
 */

get_header();
?>
<main id="main">
	<?php
	get_template_part(
		'template-parts/components/page-hero',
		null,
		array(
			'eyebrow' => __( 'Błąd 404', 'stomatologia-wiacek' ),
			'title'   => __( 'Strona nie została znaleziona', 'stomatologia-wiacek' ),
			'lead'    => __( 'Ta strona mogła zostać przeniesiona lub usunięta. Spróbuj wyszukać to, czego szukasz, lub wróć na stronę główną.', 'stomatologia-wiacek' ),
		)
	);
	?>

	<div class="sw-container sw-404">
		<?php get_search_form(); ?>

		<ul class="sw-404__links">
			<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Strona główna', 'stomatologia-wiacek' ); ?></a></li>
			<li><a href="<?php echo esc_url( get_post_type_archive_link( 'service' ) ?: home_url( '/oferta/' ) ); ?>"><?php esc_html_e( 'Oferta', 'stomatologia-wiacek' ); ?></a></li>
			<li><a href="<?php echo esc_url( sw_get_theme_page_url( 'kontakt' ) ?: home_url( '/kontakt/' ) ); ?>"><?php esc_html_e( 'Kontakt', 'stomatologia-wiacek' ); ?></a></li>
		</ul>
	</div>
</main>
<?php get_footer(); ?>
