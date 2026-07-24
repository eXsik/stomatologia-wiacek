<?php
/**
 * Asset registration and enqueueing.
 *
 * In production, /assets/styles/ and /assets/scripts/ are compiled by a
 * build step (esbuild/PostCSS) into main.min.css / main.min.js. During
 * development the individual partials are enqueued for readability.
 * SW_THEME_VERSION busts cache on every deploy without manual renaming.
 *
 * @package StomatologiaWiacek
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function sw_enqueue_assets() {
	$is_dev = defined( 'WP_DEBUG' ) && WP_DEBUG;

	// Typography foundations (heading/body scale). Font stacks are CSS
	// fallbacks in _variables.css until local Source Serif 4 / Inter files exist.
	wp_enqueue_style(
		'sw-fonts',
		SW_THEME_URI . '/assets/styles/base/_typography.css',
		array(),
		SW_THEME_VERSION
	);

	// Main stylesheet.
	wp_enqueue_style(
		'sw-main',
		SW_THEME_URI . '/assets/styles/' . ( $is_dev ? 'main.css' : 'main.min.css' ),
		array( 'sw-fonts' ),
		SW_THEME_VERSION
	);

	// Main script — deferred, footer-enqueued, no jQuery dependency.
	wp_enqueue_script(
		'sw-main',
		SW_THEME_URI . '/assets/scripts/' . ( $is_dev ? 'main.js' : 'main.min.js' ),
		array(),
		SW_THEME_VERSION,
		array(
			'in_footer' => true,
			'strategy'  => 'defer',
		)
	);

	// Gallery slider script — only loaded on templates that actually
	// render a gallery, never sitewide. Flag is set via a global in the
	// template-part before get_footer() runs.
	if ( ! empty( $GLOBALS['sw_needs_gallery_script'] ) ) {
		wp_enqueue_script(
			'sw-gallery-slider',
			SW_THEME_URI . '/assets/scripts/modules/gallery-slider.js',
			array( 'sw-main' ),
			SW_THEME_VERSION,
			array( 'in_footer' => true, 'strategy' => 'defer' )
		);
	}
}
add_action( 'wp_enqueue_scripts', 'sw_enqueue_assets' );

/**
 * Output type="module" on our own scripts so native ES module
 * import/export syntax works without requiring a bundler step.
 * In production, a build step (esbuild) would instead bundle these
 * into a single classic script — this filter keeps local dev simple.
 */
function sw_module_script_tag( $tag, $handle, $src ) {
	$is_dev = defined( 'WP_DEBUG' ) && WP_DEBUG;

	// Dev main.js is a native ES module entry; production main.min.js is an esbuild IIFE bundle.
	if ( 'sw-main' === $handle && $is_dev ) {
		$tag = str_replace( ' src=', ' type="module" src=', $tag );
	}

	// Gallery slider is always loaded as an unbundled ES module.
	if ( 'sw-gallery-slider' === $handle ) {
		$tag = str_replace( ' src=', ' type="module" src=', $tag );
	}

	return $tag;
}
add_filter( 'script_loader_tag', 'sw_module_script_tag', 10, 3 );

/**
 * Deregister the core jQuery bundle on the front end. Nothing in this
 * theme depends on it; removing it trims an unnecessary request/payload.
 * Left commented as a documented decision — re-enable if a future plugin
 * (e.g. a booking widget) requires it.
 */
function sw_dequeue_jquery() {
	if ( ! is_admin() ) {
		wp_deregister_script( 'jquery' );
	}
}
add_action( 'wp_enqueue_scripts', 'sw_dequeue_jquery', 20 );

/**
 * Font preload — disabled while no local font files exist under assets/fonts/.
 * Re-enable (and point at real files) when Source Serif 4 / Inter binaries are added.
 */
function sw_preload_fonts() {
	// No-op: do not preload missing font files.
}
add_action( 'wp_head', 'sw_preload_fonts', 1 );

/**
 * Trim common front-end noise that hurts Best Practices / Performance.
 */
function sw_clean_head() {
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wp_shortlink_wp_head' );
}
add_action( 'after_setup_theme', 'sw_clean_head' );
