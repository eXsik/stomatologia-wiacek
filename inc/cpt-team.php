<?php
/**
 * Custom Post Type: Team Member (Zespół).
 *
 * Purpose: dentist(s) and staff profiles, powering the homepage
 * "Poznaj lekarza" teaser and the full team grid on /o-nas/.
 *
 * @package StomatologiaWiacek
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function sw_register_cpt_team_member() {
	$labels = array(
		'name'          => __( 'Zespół', 'stomatologia-wiacek' ),
		'singular_name' => __( 'Członek zespołu', 'stomatologia-wiacek' ),
		'add_new_item'  => __( 'Dodaj członka zespołu', 'stomatologia-wiacek' ),
		'edit_item'     => __( 'Edytuj profil', 'stomatologia-wiacek' ),
		'all_items'     => __( 'Zespół', 'stomatologia-wiacek' ),
		'menu_name'     => __( 'Zespół', 'stomatologia-wiacek' ),
	);

	register_post_type( 'team_member', array(
		'labels'       => $labels,
		'public'       => true,
		'has_archive'  => false, // team is displayed on /o-nas/, not its own archive URL.
		'rewrite'      => array( 'slug' => 'zespol', 'with_front' => false ),
		'menu_icon'    => 'dashicons-groups',
		'supports'     => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
		'show_in_rest' => true,
		'menu_position' => 6,
	) );
}
add_action( 'init', 'sw_register_cpt_team_member' );
