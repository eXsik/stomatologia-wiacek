<?php
/**
 * Custom Post Type: Service (Usługa / Oferta).
 *
 * Purpose: each dental service is an independently manageable entity
 * (title, excerpt, icon, description) so the practice can add/retire
 * services and edit copy without a developer. Powers the homepage
 * services grid and /oferta/ archive + single service pages.
 *
 * @package StomatologiaWiacek
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function sw_register_cpt_service() {
	$labels = array(
		'name'               => __( 'Usługi', 'stomatologia-wiacek' ),
		'singular_name'      => __( 'Usługa', 'stomatologia-wiacek' ),
		'add_new_item'       => __( 'Dodaj nową usługę', 'stomatologia-wiacek' ),
		'edit_item'          => __( 'Edytuj usługę', 'stomatologia-wiacek' ),
		'all_items'          => __( 'Wszystkie usługi', 'stomatologia-wiacek' ),
		'menu_name'          => __( 'Usługi', 'stomatologia-wiacek' ),
	);

	register_post_type( 'service', array(
		'labels'        => $labels,
		'public'        => true,
		'has_archive'   => true,
		'rewrite'       => array( 'slug' => 'oferta', 'with_front' => false ),
		'menu_icon'     => 'dashicons-plus-alt',
		'supports'      => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' ),
		'show_in_rest'  => true, // Gutenberg + REST for potential headless/editor use.
		'menu_position' => 5,
	) );
}
add_action( 'init', 'sw_register_cpt_service' );
