<?php
/**
 * SEO metadata: <title>, meta description, Open Graph tags.
 *
 * Built from scratch rather than relying on a heavy plugin — appropriate
 * scope for a single-site portfolio build. In a real production handoff,
 * swapping this for Yoast/RankMath would be a reasonable recommendation
 * if the client needs more editorial control than a few ACF fields offer.
 *
 * @package StomatologiaWiacek
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Output <title>, meta description and Open Graph tags in wp_head.
 */
function sw_output_seo_meta() {
	global $post;

	$site_name = get_bloginfo( 'name' );
	$title       = '';
	$description = '';
	$image_id    = 0;
	$type        = 'website';

	if ( is_front_page() ) {
		$title       = $site_name . ' — Dentysta Ostrów Wielkopolski';
		$description = 'Nowoczesna, bezbolesna stomatologia w Ostrowie Wielkopolskim. Endodoncja mikroskopowa, implanty, stomatologia estetyczna. Umów wizytę online.';
	} elseif ( is_singular( 'service' ) ) {
		$title       = get_the_title() . ' — ' . $site_name;
		$description = has_excerpt() ? wp_strip_all_tags( get_the_excerpt() ) : wp_trim_words( wp_strip_all_tags( get_the_content() ), 30 );
		$image_id    = get_post_thumbnail_id();
		$type        = 'article';
	} elseif ( is_singular( 'post' ) ) {
		$title       = get_the_title() . ' — Blog ' . $site_name;
		$description = has_excerpt() ? wp_strip_all_tags( get_the_excerpt() ) : wp_trim_words( wp_strip_all_tags( get_the_content() ), 30 );
		$image_id    = get_post_thumbnail_id();
		$type        = 'article';
	} elseif ( is_singular() ) {
		$title       = get_the_title() . ' — ' . $site_name;
		$description = has_excerpt() ? wp_strip_all_tags( get_the_excerpt() ) : wp_trim_words( wp_strip_all_tags( get_the_content() ), 30 );
		$image_id    = get_post_thumbnail_id();
	} elseif ( is_post_type_archive( 'service' ) ) {
		$title       = 'Oferta — ' . $site_name;
		$description = 'Pełna oferta usług stomatologicznych: stomatologia estetyczna, endodoncja, implanty, protetyka i więcej.';
	} elseif ( is_404() ) {
		$title = 'Strona nie znaleziona — ' . $site_name;
	} else {
		$title = wp_get_document_title();
	}

	if ( empty( $description ) ) {
		$description = get_bloginfo( 'description' );
	}

	echo "\n<!-- SEO meta (theme: seo-meta.php) -->\n";
	echo '<title>' . esc_html( $title ) . '</title>' . "\n";
	echo '<meta name="description" content="' . esc_attr( wp_trim_words( $description, 30, '' ) ) . '">' . "\n";

	// Open Graph.
	echo '<meta property="og:site_name" content="' . esc_attr( $site_name ) . '">' . "\n";
	echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
	echo '<meta property="og:description" content="' . esc_attr( $description ) . '">' . "\n";
	echo '<meta property="og:type" content="' . esc_attr( $type ) . '">' . "\n";
	echo '<meta property="og:locale" content="pl_PL">' . "\n";
	echo '<meta property="og:url" content="' . esc_url( sw_current_url() ) . '">' . "\n";

	if ( $image_id ) {
		$img = wp_get_attachment_image_src( $image_id, 'sw-hero' );
		if ( $img ) {
			echo '<meta property="og:image" content="' . esc_url( $img[0] ) . '">' . "\n";
		}
	}

	echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
	echo "<!-- /SEO meta -->\n";
}
add_action( 'wp_head', 'sw_output_seo_meta', 1 );

/**
 * Prevent WordPress from also auto-printing its default <title> tag
 * output twice — we handle it manually above for full control.
 */
add_filter( 'pre_get_document_title', '__return_empty_string', 20 );

/**
 * Small helper: current full URL, used for og:url and canonical tags.
 */
function sw_current_url() {
	global $wp;
	return home_url( add_query_arg( array(), $wp->request ) );
}
