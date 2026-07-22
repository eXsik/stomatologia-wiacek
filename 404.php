<?php
/**
 * 404 template — branded, includes search + links back to key pages
 * instead of a bare "not found" dead end, to keep lost visitors
 * (e.g. from an old indexed .html URL) converting rather than bouncing.
 *
 * @package StomatologiaWiacek
 */

get_header();
?>
<main id="main">
	<div class="sw-container sw-404">
		<h1><?php esc_html_e( 'Strona nie została znaleziona', 'stomatologia-wiacek' ); ?></h1>
		<p><?php esc_html_e( 'Ta strona mogła zostać przeniesiona lub usunięta. Spróbuj wyszukać to, czego szukasz, lub wróć na stronę główną.', 'stomatologia-wiacek' ); ?></p>

		<?php get_search_form(); ?>

		<ul class="sw-404__links">
			<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Strona główna', 'stomatologia-wiacek' ); ?></a></li>
			<li><a href="<?php echo esc_url( get_post_type_archive_link( 'service' ) ); ?>"><?php esc_html_e( 'Oferta', 'stomatologia-wiacek' ); ?></a></li>
			<li><a href="<?php echo esc_url( home_url( '/#kontakt' ) ); ?>"><?php esc_html_e( 'Kontakt', 'stomatologia-wiacek' ); ?></a></li>
		</ul>
	</div>
</main>
<?php get_footer(); ?>
