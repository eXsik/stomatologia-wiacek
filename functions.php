<?php
/**
 * Theme bootstrap.
 *
 * This file intentionally does almost nothing except require the
 * single-responsibility modules in /inc/. Keeping functions.php thin
 * makes the codebase easy to navigate: one concern per file.
 *
 * @package StomatologiaWiacek
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // No direct access.
}

define( 'SW_THEME_VERSION', '1.0.0' );
define( 'SW_THEME_DIR', get_template_directory() );
define( 'SW_THEME_URI', get_template_directory_uri() );

$sw_modules = array(
	'inc/setup.php',           // theme_support, menus, image sizes.
	'inc/enqueue.php',         // CSS / JS registration.
	'inc/helpers.php',         // shared utility functions.
	'inc/clinic-settings.php', // Dane gabinetu settings (ACF Free — no Options Page).
	'inc/cpt-services.php',    // Services custom post type.
	'inc/cpt-team.php',        // Team Members custom post type.
	'inc/cpt-testimonials.php',// Testimonials custom post type.
	'inc/cpt-faq.php',         // FAQ custom post type.
	'inc/acf-fields.php',      // ACF Free field group registration.
	'inc/nav-walker.php',      // accessible custom nav walker.
	'inc/seo-meta.php',        // title / meta description / Open Graph.
	'inc/seo-schema.php',      // JSON-LD: Dentist, LocalBusiness, FAQPage, Breadcrumb.
	'inc/contact-form.php',    // admin-post.php handler for the native contact form.
	'template-parts/components/button.php', // defines sw_button() — a function, not markup, so it's required once here rather than fetched via get_template_part.
);

foreach ( $sw_modules as $sw_module ) {
	$path = SW_THEME_DIR . '/' . $sw_module;
	if ( file_exists( $path ) ) {
		require_once $path;
	}
}
