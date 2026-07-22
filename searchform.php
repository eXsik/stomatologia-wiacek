<?php
/**
 * Custom search form, output via get_search_form().
 *
 * @package StomatologiaWiacek
 */
?>
<form role="search" method="get" class="sw-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="sw-search-field" class="sw-visually-hidden"><?php esc_html_e( 'Szukaj', 'stomatologia-wiacek' ); ?></label>
	<input type="search" id="sw-search-field" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'Szukaj…', 'stomatologia-wiacek' ); ?>">
	<button type="submit"><?php esc_html_e( 'Szukaj', 'stomatologia-wiacek' ); ?></button>
</form>
