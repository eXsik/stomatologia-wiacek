<?php
/**
 * Custom Post Type: Testimonial (Opinia pacjenta).
 *
 * Purpose: structured patient reviews independent of any single external
 * platform. Powers the homepage testimonials carousel.
 *
 * @package StomatologiaWiacek
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function sw_register_cpt_testimonial() {
	$labels = array(
		'name'          => __( 'Opinie pacjentów', 'stomatologia-wiacek' ),
		'singular_name' => __( 'Opinia', 'stomatologia-wiacek' ),
		'add_new_item'  => __( 'Dodaj opinię', 'stomatologia-wiacek' ),
		'edit_item'     => __( 'Edytuj opinię', 'stomatologia-wiacek' ),
		'all_items'     => __( 'Opinie pacjentów', 'stomatologia-wiacek' ),
		'menu_name'     => __( 'Opinie', 'stomatologia-wiacek' ),
	);

	register_post_type( 'testimonial', array(
		'labels'       => $labels,
		'public'       => true,
		'has_archive'  => false,
		'rewrite'      => array( 'slug' => 'opinie', 'with_front' => false ),
		'menu_icon'    => 'dashicons-star-filled',
		'supports'     => array( 'title' ), // "title" stores the patient name/initials; quote + rating are ACF fields.
		'show_in_rest' => true,
		'menu_position' => 7,
	) );
}
add_action( 'init', 'sw_register_cpt_testimonial' );
