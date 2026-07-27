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
 * Front page ID for ACF fields when called outside / after the loop.
 *
 * @return int
 */
function sw_front_page_id() {
	if ( is_front_page() ) {
		$queried = (int) get_queried_object_id();
		if ( $queried > 0 ) {
			return $queried;
		}
	}

	return (int) get_option( 'page_on_front' );
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

	$page_id = sw_front_page_id();

	for ( $i = 1; $i <= 4; $i++ ) {
		$value = get_field( 'trust_' . $i . '_value', $page_id );
		if ( empty( $value ) ) {
			continue;
		}
		$stats[] = array(
			'value' => $value,
			'label' => get_field( 'trust_' . $i . '_label', $page_id ) ?: '',
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

	$page_id = sw_front_page_id();

	for ( $i = 1; $i <= 3; $i++ ) {
		$title = get_field( 'why_us_' . $i . '_title', $page_id );
		if ( empty( $title ) ) {
			continue;
		}
		$points[] = array(
			'title'       => $title,
			'description' => get_field( 'why_us_' . $i . '_description', $page_id ) ?: '',
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

	$page_id = sw_front_page_id();

	for ( $i = 1; $i <= 3; $i++ ) {
		$before = get_field( 'gallery_' . $i . '_before', $page_id );
		$after  = get_field( 'gallery_' . $i . '_after', $page_id );
		if ( empty( $before ) || empty( $after ) ) {
			continue;
		}
		$pairs[] = array(
			'before' => $before,
			'after'  => $after,
			'label'  => get_field( 'gallery_' . $i . '_label', $page_id ) ?: '',
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

/**
 * Permalink for a theme-managed page slug (o-nas, zespol, kontakt…).
 *
 * @param string $slug Page slug.
 * @return string Empty when page does not exist.
 */
function sw_get_theme_page_url( $slug ) {
	$page = get_page_by_path( $slug, OBJECT, 'page' );
	if ( ! $page instanceof WP_Post ) {
		return '';
	}

	return get_permalink( $page );
}

/**
 * Aside panel data for the unified page hero component.
 *
 * @param string $variant Preset key: services, team, gallery, faq, contact, about, booking.
 * @return array{type:string,stat_value?:string,stat_label?:string,note?:string,aria_label?:string,phone?:string,address?:string}
 */
function sw_page_hero_aside( $variant ) {
	$variant = sanitize_key( $variant );

	switch ( $variant ) {
		case 'services':
			$count = (int) wp_count_posts( 'service' )->publish;
			return array(
				'type'        => 'stat',
				'stat_value'  => (string) max( 1, $count ),
				'stat_label'  => __( 'obszarów leczenia', 'stomatologia-wiacek' ),
				'note'        => __( 'Każda usługa opisana jasno — bez ukrytych kroków i zbędnego żargonu.', 'stomatologia-wiacek' ),
				'aria_label'  => __( 'Podsumowanie oferty', 'stomatologia-wiacek' ),
			);

		case 'team':
			$count = (int) wp_count_posts( 'team_member' )->publish;
			if ( $count < 1 ) {
				$count = 3;
			}
			return array(
				'type'        => 'stat',
				'stat_value'  => (string) $count,
				'stat_label'  => __( 'specjalistów w zespole', 'stomatologia-wiacek' ),
				'note'        => __( 'Lekarze, higienistki i personel recepcji — jeden spokojny, spójny standard opieki.', 'stomatologia-wiacek' ),
				'aria_label'  => __( 'Podsumowanie zespołu', 'stomatologia-wiacek' ),
			);

		case 'gallery':
			$pairs = sw_get_gallery_pairs();
			$count = sw_has_rows( $pairs ) ? count( $pairs ) : 3;
			return array(
				'type'        => 'stat',
				'stat_value'  => (string) $count,
				'stat_label'  => __( 'przykładowych metamorfoz', 'stomatologia-wiacek' ),
				'note'        => __( 'Przed i po — zawsze z indywidualnym planem leczenia, nie „efektem na siłę”.', 'stomatologia-wiacek' ),
				'aria_label'  => __( 'Galeria metamorfoz', 'stomatologia-wiacek' ),
			);

		case 'faq':
			$count = (int) wp_count_posts( 'faq' )->publish;
			if ( $count < 1 ) {
				$count = 6;
			}
			return array(
				'type'        => 'stat',
				'stat_value'  => (string) $count,
				'stat_label'  => __( 'najczęstszych pytań', 'stomatologia-wiacek' ),
				'note'        => __( 'Jasne odpowiedzi przed pierwszą wizytą — bez żargonu i bez presji.', 'stomatologia-wiacek' ),
				'aria_label'  => __( 'FAQ', 'stomatologia-wiacek' ),
			);

		case 'contact':
			return array(
				'type'        => 'contact',
				'phone'       => sw_get_option( 'clinic_phone', '62 123 45 67' ),
				'address'     => sw_get_option( 'clinic_address', 'ul. Przykładowa 1, 63-400 Ostrów Wielkopolski' ),
				'aria_label'  => __( 'Dane kontaktowe', 'stomatologia-wiacek' ),
			);

		case 'about':
			return array(
				'type'        => 'stat',
				'stat_value'  => __( 'Ostrów', 'stomatologia-wiacek' ),
				'stat_label'  => __( 'Wlkp. · centrum miasta', 'stomatologia-wiacek' ),
				'note'        => __( 'Nowoczesny gabinet, spokojna atmosfera i komunikacja, która buduje zaufanie.', 'stomatologia-wiacek' ),
				'aria_label'  => __( 'O gabinetu', 'stomatologia-wiacek' ),
			);

		case 'booking':
			return array(
				'type'        => 'booking',
				'aria_label'  => __( 'Umów wizytę', 'stomatologia-wiacek' ),
			);

		default:
			return array(
				'type' => 'none',
			);
	}
}
