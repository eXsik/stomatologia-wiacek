<?php
/**
 * JSON-LD structured data output.
 *
 * - Dentist / LocalBusiness: sitewide, built from Dane gabinetu settings
 *   so schema and visible NAP data can never drift apart.
 * - FAQPage: generated dynamically from the FAQ CPT loop, only on
 *   templates that render the FAQ accordion.
 * - BreadcrumbList: generated from the same data as the visible
 *   breadcrumbs component.
 *
 * @package StomatologiaWiacek
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Dentist / LocalBusiness schema — output sitewide in the footer.
 */
function sw_output_dentist_schema() {
	$hours_rows = sw_get_option( 'clinic_hours', array() );
	$opening_hours = array();

	if ( sw_has_rows( $hours_rows ) ) {
		foreach ( $hours_rows as $row ) {
			if ( empty( $row['day'] ) || empty( $row['open'] ) || empty( $row['close'] ) ) {
				continue;
			}
			$opening_hours[] = array(
				'@type'     => 'OpeningHoursSpecification',
				'dayOfWeek' => $row['day'],
				'opens'     => $row['open'],
				'closes'    => $row['close'],
			);
		}
	}

	$schema = array(
		'@context'      => 'https://schema.org',
		'@type'         => 'Dentist',
		'name'          => get_bloginfo( 'name' ),
		'image'         => get_site_icon_url(),
		'url'           => home_url( '/' ),
		'telephone'     => sw_get_option( 'clinic_phone' ),
		'email'         => sw_get_option( 'clinic_email' ),
		'address'       => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => sw_get_option( 'clinic_address' ),
			'addressLocality' => 'Ostrów Wielkopolski',
			'addressCountry' => 'PL',
		),
		'medicalSpecialty' => 'Dentistry',
	);

	$lat = sw_get_option( 'clinic_lat' );
	$lng = sw_get_option( 'clinic_lng' );
	if ( $lat && $lng ) {
		$schema['geo'] = array(
			'@type'     => 'GeoCoordinates',
			'latitude'  => $lat,
			'longitude' => $lng,
		);
	}

	if ( ! empty( $opening_hours ) ) {
		$schema['openingHoursSpecification'] = $opening_hours;
	}

	$rating = sw_get_option( 'google_rating' );
	$review_count = sw_get_option( 'google_review_count' );
	if ( $rating && $review_count ) {
		$schema['aggregateRating'] = array(
			'@type'       => 'AggregateRating',
			'ratingValue' => $rating,
			'reviewCount' => $review_count,
		);
	}

	$socials = array_filter( array(
		sw_get_option( 'social_facebook' ),
		sw_get_option( 'social_instagram' ),
	) );
	if ( ! empty( $socials ) ) {
		$schema['sameAs'] = array_values( $socials );
	}

	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}
add_action( 'wp_footer', 'sw_output_dentist_schema' );

/**
 * FAQPage schema — call this from template-parts/sections/faq.php
 * right after the visible accordion, passing the same WP_Query results
 * so schema and UI can never drift apart.
 *
 * @param WP_Post[] $faq_posts
 */
function sw_output_faq_schema( $faq_posts ) {
	if ( empty( $faq_posts ) ) {
		return;
	}

	$items = array();
	foreach ( $faq_posts as $faq_post ) {
		$items[] = array(
			'@type' => 'Question',
			'name'  => get_the_title( $faq_post ),
			'acceptedAnswer' => array(
				'@type' => 'Answer',
				'text'  => wp_strip_all_tags( apply_filters( 'the_content', $faq_post->post_content ) ),
			),
		);
	}

	$schema = array(
		'@context'   => 'https://schema.org',
		'@type'      => 'FAQPage',
		'mainEntity' => $items,
	);

	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}

/**
 * BreadcrumbList schema — call this from the breadcrumbs component,
 * passing the same trail array used to render the visible breadcrumbs.
 *
 * @param array $trail Array of ['label' => string, 'url' => string|null].
 */
function sw_output_breadcrumb_schema( $trail ) {
	if ( empty( $trail ) ) {
		return;
	}

	$items = array();
	foreach ( $trail as $index => $crumb ) {
		$item = array(
			'@type'    => 'ListItem',
			'position' => $index + 1,
			'name'     => $crumb['label'],
		);
		if ( ! empty( $crumb['url'] ) ) {
			$item['item'] = $crumb['url'];
		}
		$items[] = $item;
	}

	$schema = array(
		'@context'        => 'https://schema.org',
		'@type'           => 'BreadcrumbList',
		'itemListElement' => $items,
	);

	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}
