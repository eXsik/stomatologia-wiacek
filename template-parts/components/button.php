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

	$extra = '';
	if ( function_exists( 'sw_booking_is_demo' ) && sw_booking_is_demo() && false !== strpos( (string) $url, 'sw-booking-demo' ) ) {
		$extra = sw_booking_trigger_attrs();
		$classes[] = 'sw-btn--arrow';
	} elseif ( 0 === strpos( (string) $url, 'http' ) ) {
		$extra = ' target="_blank" rel="noopener noreferrer"';
		if ( 'accent' === $style ) {
			$classes[] = 'sw-btn--arrow';
		}
	} elseif ( 'accent' === $style && false !== strpos( (string) $url, 'booking' ) ) {
		$classes[] = 'sw-btn--arrow';
	}

	printf(
		'<a href="%1$s" class="%2$s"%3$s>%4$s</a>',
		esc_url( $url ),
		esc_attr( implode( ' ', $classes ) ),
		$extra, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- fixed attrs from helper.
		esc_html( $label )
	);
}
