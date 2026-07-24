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
 * Fetch a clinic setting from the native Dane gabinetu options page.
 * Used everywhere NAP/contact data is needed: header, footer,
 * contact section, JSON-LD schema — single source of truth.
 *
 * @param string $field_key Option key (e.g. clinic_phone, clinic_hours).
 * @param mixed  $fallback  Value returned if the option is empty.
 * @return mixed
 */
function sw_get_option( $field_key, $fallback = '' ) {
	$options = get_option( 'sw_clinic', array() );
	if ( ! is_array( $options ) ) {
		$options = array();
	}

	if ( array_key_exists( $field_key, $options ) && '' !== $options[ $field_key ] && null !== $options[ $field_key ] ) {
		// Empty arrays (e.g. clinic_hours with no rows) should fall through.
		if ( is_array( $options[ $field_key ] ) && empty( $options[ $field_key ] ) ) {
			return $fallback;
		}
		return $options[ $field_key ];
	}

	return $fallback;
}

/**
 * Build trust-bar stats from fixed ACF Free slots (trust_1_* … trust_4_*).
 *
 * @return array<int, array{icon:string,value:string,label:string}>
 */
function sw_get_trust_stats() {
	$stats = array();

	if ( ! function_exists( 'get_field' ) ) {
		return $stats;
	}

	for ( $i = 1; $i <= 4; $i++ ) {
		$value = get_field( 'trust_' . $i . '_value' );
		if ( empty( $value ) ) {
			continue;
		}
		$stats[] = array(
			'value' => $value,
			'label' => get_field( 'trust_' . $i . '_label' ) ?: '',
		);
	}

	return $stats;
}

/**
 * Build why-us points from fixed ACF Free slots (why_us_1_* … why_us_3_*).
 *
 * @return array<int, array{title:string,description:string}>
 */
function sw_get_why_us_points() {
	$points = array();

	if ( ! function_exists( 'get_field' ) ) {
		return $points;
	}

	for ( $i = 1; $i <= 3; $i++ ) {
		$title = get_field( 'why_us_' . $i . '_title' );
		if ( empty( $title ) ) {
			continue;
		}
		$points[] = array(
			'title'       => $title,
			'description' => get_field( 'why_us_' . $i . '_description' ) ?: '',
		);
	}

	return $points;
}

/**
 * Build gallery before/after pairs from fixed ACF Free slots (gallery_1_* … gallery_3_*).
 *
 * @return array<int, array{before:int,after:int,label:string}>
 */
function sw_get_gallery_pairs() {
	$pairs = array();

	if ( ! function_exists( 'get_field' ) ) {
		return $pairs;
	}

	for ( $i = 1; $i <= 3; $i++ ) {
		$before = get_field( 'gallery_' . $i . '_before' );
		$after  = get_field( 'gallery_' . $i . '_after' );
		if ( empty( $before ) || empty( $after ) ) {
			continue;
		}
		$pairs[] = array(
			'before' => $before,
			'after'  => $after,
			'label'  => get_field( 'gallery_' . $i . '_label' ) ?: '',
		);
	}

	return $pairs;
}

/**
 * Format a Polish phone number as a tel: href, e.g. "62 123 45 67" -> "tel:+48621234567".
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
 * Whether booking CTAs should open the in-theme demo widget.
 * Real Booksy / ZnanyLekarz URL in Dane gabinetu disables the demo.
 *
 * @return bool
 */
function sw_booking_is_demo() {
	$configured = sw_get_option( 'booking_url', '' );
	return ! ( is_string( $configured ) && '' !== trim( $configured ) );
}

/**
 * Global booking CTA URL.
 * Empty clinic setting → demo modal hash (portfolio ZnanyLekarz-style widget).
 * Configured URL → external scheduler (opens in new tab via trigger attrs).
 *
 * @return string Sanitized URL safe for href attributes.
 */
function sw_booking_url() {
	if ( ! sw_booking_is_demo() ) {
		return esc_url( trim( (string) sw_get_option( 'booking_url', '' ) ) );
	}

	// home_url + fragment survives esc_url(); bare "#…" does not.
	return esc_url( home_url( '/#sw-booking-demo' ) );
}

/**
 * Extra attributes for booking links (demo open vs external tab).
 *
 * @return string Space-prefixed HTML attributes.
 */
function sw_booking_trigger_attrs() {
	if ( sw_booking_is_demo() ) {
		return ' data-sw-booking-open';
	}

	return ' target="_blank" rel="noopener noreferrer"';
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
		'loading'  => $eager ? 'eager' : 'lazy',
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
 * Truthy check for array-based field collections so templates can
 * write clean `if ( sw_has_rows( $field ) )` guards.
 *
 * @param mixed $rows
 * @return bool
 */
function sw_has_rows( $rows ) {
	return is_array( $rows ) && count( $rows ) > 0;
}
