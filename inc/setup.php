<?php
/**
 * Core theme setup: theme supports, nav menus, image sizes, sidebars.
 *
 * @package StomatologiaWiacek
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register theme supports and navigation menus.
 */
function sw_setup() {
	// Translation ready.
	load_theme_textdomain( 'stomatologia-wiacek', SW_THEME_DIR . '/languages' );

	// Core supports.
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'custom-logo', array(
		'height'      => 60,
		'width'       => 220,
		'flex-height' => true,
		'flex-width'  => true,
	) );

	// Image sizes used across the site — deliberately small, purposeful set
	// rather than relying on WP's default bloat of unused crops.
	add_image_size( 'sw-card', 640, 480, true );      // service / testimonial / post cards.
	add_image_size( 'sw-hero', 1920, 1080, true );     // hero background.
	add_image_size( 'sw-avatar', 200, 200, true );     // team member photos.

	// Navigation menus.
	register_nav_menus( array(
		'primary' => __( 'Menu główne', 'stomatologia-wiacek' ),
		'footer'  => __( 'Menu w stopce', 'stomatologia-wiacek' ),
	) );
}
add_action( 'after_setup_theme', 'sw_setup' );

/**
 * Disable the WordPress core emoji script/style — not needed, saves
 * a render-blocking request and inline CSS on every page load.
 */
function sw_disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
}
add_action( 'init', 'sw_disable_emojis' );

/**
 * Drop false "current" state on hash / same-page custom links.
 * One-page menus often point at /#kontakt etc.; WordPress marks those
 * as current-menu-item on the front page and the nav stays underlined.
 *
 * @param array   $classes Menu item classes.
 * @param WP_Post $item    Menu item.
 * @return array
 */
function sw_nav_menu_css_class( $classes, $item ) {
	if ( ! sw_nav_item_is_current( $item ) ) {
		$classes = array_diff(
			$classes,
			array(
				'current-menu-item',
				'current_page_item',
				'current-menu-ancestor',
				'current-menu-parent',
			)
		);
	}

	return $classes;
}
add_filter( 'nav_menu_css_class', 'sw_nav_menu_css_class', 10, 2 );

/**
 * Whether a menu item should expose "current" UI (underline / aria-current).
 * Hash links to the front page are never treated as current.
 *
 * @param object $item Menu item.
 * @return bool
 */
function sw_nav_item_is_current( $item ) {
	if ( ! is_object( $item ) || empty( $item->classes ) || ! is_array( $item->classes ) ) {
		return false;
	}

	if ( ! in_array( 'current-menu-item', $item->classes, true ) ) {
		return false;
	}

	$url = isset( $item->url ) ? (string) $item->url : '';
	if ( '' === $url ) {
		return true;
	}

	// Front-page section anchors must not stay permanently underlined.
	if ( false !== strpos( $url, '#' ) ) {
		$path = (string) wp_parse_url( $url, PHP_URL_PATH );
		if ( '' === $path || '/' === $path ) {
			return false;
		}
	}

	return true;
}
