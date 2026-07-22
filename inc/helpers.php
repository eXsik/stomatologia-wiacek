<?php
/**
 * Small shared utility functions used across multiple templates.
 * Keeping these centralised avoids copy-pasted logic in template-parts.
 *
 * @package StomatologiaWiacek
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Fetch a value from the ACF Options page with a safe fallback.
 * Used everywhere NAP/contact data is needed: header, footer,
 * contact section, JSON-LD schema — single source of truth.
 *
 * @param string $field_key ACF field name on the Options page.
 * @param mixed  $fallback  Value returned if ACF/field is unavailable.
 * @return mixed
 */
function sw_get_option( $field_key, $fallback = '' ) {
	if ( function_exists( 'get_field' ) ) {
		$value = get_field( $field_key, 'option' );
		if ( ! empty( $value ) ) {
			return $value;
		}
	}
	return $fallback;
}

/**
 * Format a Polish phone number as a tel: href, e.g. "62 123 45 67" -> "+4862123456­7".
 *
 * @param string $phone_display Human-readable phone number.
 * @return string
 */
function sw_phone_href( $phone_display ) {
	$digits = preg_replace( '/\D+/', '', $phone_display );
	if ( strlen( $digits ) === 9 ) {
		$digits = '48' . $digits; // assume PL country code if not present.
	}
	return 'tel:+' . $digits;
}

/**
 * Render a responsive <img> with explicit width/height (CLS prevention)
 * and lazy-loading, except when $eager is true (used for the LCP hero image).
 *
 * @param int    $attachment_id
 * @param string $size
 * @param bool   $eager
 * @param array  $attrs Extra attributes (e.g. class).
 */
function sw_image( $attachment_id, $size = 'sw-card', $eager = false, $attrs = array() ) {
	if ( ! $attachment_id ) {
		return;
	}

	$default_attrs = array(
		'loading' => $eager ? 'eager' : 'lazy',
		'decoding' => 'async',
	);

	if ( $eager ) {
		$default_attrs['fetchpriority'] = 'high';
	}

	echo wp_get_attachment_image(
		$attachment_id,
		$size,
		false,
		array_merge( $default_attrs, $attrs )
	);
}

/**
 * Truthy check for ACF repeater/relationship fields so templates can
 * write clean `if ( sw_has_rows( $field ) )` guards.
 *
 * @param mixed $rows
 * @return bool
 */
function sw_has_rows( $rows ) {
	return is_array( $rows ) && count( $rows ) > 0;
}
