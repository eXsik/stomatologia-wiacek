<?php
/**
 * Ensure core portfolio pages exist and map nav hash links to real URLs.
 *
 * @package StomatologiaWiacek
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registered theme pages (slug → template).
 *
 * @return array<string, array{title:string,template:string,content:string}>
 */
function sw_get_required_pages() {
	return array(
		'o-nas'       => array(
			'title'    => __( 'O nas', 'stomatologia-wiacek' ),
			'template' => 'templates/page-about.php',
			'content'  => '',
		),
		'zespol'      => array(
			'title'    => __( 'Zespół', 'stomatologia-wiacek' ),
			'template' => 'templates/page-team.php',
			'content'  => '',
		),
		'metamorfozy' => array(
			'title'    => __( 'Metamorfozy', 'stomatologia-wiacek' ),
			'template' => 'templates/page-gallery.php',
			'content'  => '',
		),
		'faq'         => array(
			'title'    => __( 'FAQ', 'stomatologia-wiacek' ),
			'template' => 'templates/page-faq.php',
			'content'  => '',
		),
		'kontakt'     => array(
			'title'    => __( 'Kontakt', 'stomatologia-wiacek' ),
			'template' => 'templates/page-contact.php',
			'content'  => '',
		),
	);
}

/**
 * Create or fix a page by slug.
 *
 * @param string $slug Page slug.
 * @param array  $args title, template, content.
 * @return int Page ID or 0.
 */
function sw_upsert_theme_page( $slug, $args ) {
	$existing = get_page_by_path( $slug, OBJECT, 'page' );

	if ( $existing instanceof WP_Post ) {
		$page_id = (int) $existing->ID;
		if ( ! empty( $args['template'] ) ) {
			$current_template = get_post_meta( $page_id, '_wp_page_template', true );
			if ( $current_template !== $args['template'] ) {
				update_post_meta( $page_id, '_wp_page_template', $args['template'] );
			}
		}
		return $page_id;
	}

	$page_id = wp_insert_post(
		array(
			'post_title'   => $args['title'],
			'post_name'    => $slug,
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => $args['content'] ?? '',
		),
		true
	);

	if ( is_wp_error( $page_id ) || ! $page_id ) {
		return 0;
	}

	if ( ! empty( $args['template'] ) ) {
		update_post_meta( $page_id, '_wp_page_template', $args['template'] );
	}

	return (int) $page_id;
}

/**
 * Seed all required pages.
 */
function sw_seed_required_pages() {
	foreach ( sw_get_required_pages() as $slug => $config ) {
		sw_upsert_theme_page( $slug, $config );
	}
}

/**
 * Seed on admin (once) and theme switch.
 */
function sw_seed_required_pages_admin() {
	if ( wp_installing() || ! is_admin() ) {
		return;
	}

	if ( get_option( 'sw_required_pages_v2' ) ) {
		return;
	}

	sw_seed_required_pages();
	update_option( 'sw_required_pages_v2', 1, false );
}
add_action( 'admin_init', 'sw_seed_required_pages_admin' );

function sw_seed_required_pages_on_activation() {
	sw_seed_required_pages();
	update_option( 'sw_required_pages_v2', 1, false );
}
add_action( 'after_switch_theme', 'sw_seed_required_pages_on_activation' );

/**
 * Front-end: ensure pages exist before nav resolves.
 */
function sw_seed_pages_on_frontend() {
	if ( is_admin() || wp_doing_ajax() || wp_doing_cron() ) {
		return;
	}

	sw_seed_required_pages();
}
add_action( 'init', 'sw_seed_pages_on_frontend', 4 );

/**
 * Map homepage section hashes to real page URLs when pages exist.
 *
 * @param string $url Menu item URL.
 * @return string
 */
function sw_resolve_internal_url( $url ) {
	if ( ! is_string( $url ) || '' === $url ) {
		return $url;
	}

	$hash = '';
	if ( false !== strpos( $url, '#' ) ) {
		$hash = strtolower( ltrim( strstr( $url, '#' ), '#' ) );
	}

	if ( '' === $hash ) {
		return $url;
	}

	$page_slugs = array(
		'zespol'            => 'zespol',
		'metamorfozy'       => 'metamorfozy',
		'faq'               => 'faq',
		'kontakt'           => 'kontakt',
		'kontakt-formularz' => 'kontakt',
		'o-nas'             => 'o-nas',
	);

	if ( isset( $page_slugs[ $hash ] ) ) {
		$page = get_page_by_path( $page_slugs[ $hash], OBJECT, 'page' );
		if ( $page instanceof WP_Post ) {
			return get_permalink( $page );
		}
	}

	if ( 'uslugi' === $hash ) {
		$archive = get_post_type_archive_link( 'service' );
		if ( $archive ) {
			return $archive;
		}
	}

	if ( 'opinie' === $hash ) {
		return home_url( '/#opinie' );
	}

	return $url;
}

/**
 * Rewrite primary/footer menu hash links to subpages.
 *
 * @param array $items Menu items.
 * @param mixed $args  Menu args.
 * @return array
 */
function sw_resolve_nav_menu_urls( $items, $args ) {
	$location = is_object( $args ) && isset( $args->theme_location ) ? $args->theme_location : '';

	if ( ! in_array( $location, array( 'primary', 'footer' ), true ) ) {
		return $items;
	}

	foreach ( $items as $item ) {
		if ( isset( $item->url ) ) {
			$item->url = sw_resolve_internal_url( $item->url );
		}
	}

	return $items;
}
add_filter( 'wp_nav_menu_objects', 'sw_resolve_nav_menu_urls', 10, 2 );

/**
 * Fallback primary nav when no menu assigned.
 *
 * @return void
 */
function sw_primary_nav_fallback() {
	sw_render_theme_nav_list( 'sw-nav__list', 'sw-nav-item', 'sw-nav-link' );
}

/**
 * Fallback mobile nav list.
 *
 * @return void
 */
function sw_mobile_nav_fallback() {
	sw_render_theme_nav_list( 'sw-mobile-menu__list', 'sw-nav-item', 'sw-nav-link' );
}

/**
 * Echo default theme navigation links.
 *
 * @param string $ul_class   List class.
 * @param string $li_class   Item class.
 * @param string $link_class Link class.
 */
function sw_render_theme_nav_list( $ul_class, $li_class, $link_class ) {
	$links = array(
		array(
			'label' => __( 'O nas', 'stomatologia-wiacek' ),
			'url'   => sw_get_theme_page_url( 'o-nas' ),
		),
		array(
			'label' => __( 'Usługi', 'stomatologia-wiacek' ),
			'url'   => get_post_type_archive_link( 'service' ) ?: home_url( '/oferta/' ),
		),
		array(
			'label' => __( 'Zespół', 'stomatologia-wiacek' ),
			'url'   => sw_get_theme_page_url( 'zespol' ),
		),
		array(
			'label' => __( 'Metamorfozy', 'stomatologia-wiacek' ),
			'url'   => sw_get_theme_page_url( 'metamorfozy' ),
		),
		array(
			'label' => __( 'FAQ', 'stomatologia-wiacek' ),
			'url'   => sw_get_theme_page_url( 'faq' ),
		),
		array(
			'label' => __( 'Kontakt', 'stomatologia-wiacek' ),
			'url'   => sw_get_theme_page_url( 'kontakt' ),
		),
	);

	echo '<ul class="' . esc_attr( $ul_class ) . '">';
	foreach ( $links as $link ) {
		if ( empty( $link['url'] ) ) {
			continue;
		}
		echo '<li class="' . esc_attr( $li_class ) . '"><a class="' . esc_attr( $link_class ) . '" href="' . esc_url( $link['url'] ) . '">' . esc_html( $link['label'] ) . '</a></li>';
	}
	echo '</ul>';
}

/**
 * Fallback footer nav.
 *
 * @return void
 */
function sw_footer_nav_fallback() {
	$links = array(
		array(
			'label' => __( 'O nas', 'stomatologia-wiacek' ),
			'url'   => sw_get_theme_page_url( 'o-nas' ),
		),
		array(
			'label' => __( 'Usługi', 'stomatologia-wiacek' ),
			'url'   => get_post_type_archive_link( 'service' ) ?: home_url( '/oferta/' ),
		),
		array(
			'label' => __( 'Zespół', 'stomatologia-wiacek' ),
			'url'   => sw_get_theme_page_url( 'zespol' ),
		),
		array(
			'label' => __( 'Kontakt', 'stomatologia-wiacek' ),
			'url'   => sw_get_theme_page_url( 'kontakt' ),
		),
	);

	echo '<ul class="sw-footer__menu">';
	foreach ( $links as $link ) {
		if ( empty( $link['url'] ) ) {
			continue;
		}
		echo '<li><a href="' . esc_url( $link['url'] ) . '">' . esc_html( $link['label'] ) . '</a></li>';
	}
	echo '</ul>';
}
