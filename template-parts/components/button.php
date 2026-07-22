<?php
/**
 * Button component helper — a thin function wrapper so button markup
 * (and future changes to it, e.g. adding an icon slot) lives in one
 * place instead of being hand-typed in every template.
 *
 * Usage: sw_button( 'Umów wizytę', '#kontakt', 'accent', 'lg' );
 *
 * @package StomatologiaWiacek
 *
 * @param string $label Button text.
 * @param string $url   Destination URL.
 * @param string $style 'accent' | 'outline' | 'ghost'.
 * @param string $size  '' | 'lg'.
 */
function sw_button( $label, $url, $style = 'accent', $size = '' ) {
	$classes = array( 'sw-btn', 'sw-btn--' . $style );
	if ( $size ) {
		$classes[] = 'sw-btn--' . $size;
	}
	printf(
		'<a href="%1$s" class="%2$s">%3$s</a>',
		esc_url( $url ),
		esc_attr( implode( ' ', $classes ) ),
		esc_html( $label )
	);
}
