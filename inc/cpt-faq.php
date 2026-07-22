<?php
/**
 * Custom Post Type: FAQ (Pytania i odpowiedzi).
 *
 * Purpose: structured Q&A pairs powering both the homepage accordion
 * and FAQPage JSON-LD schema — guarantees visible content and schema
 * never drift out of sync, since both read from the same source.
 *
 * @package StomatologiaWiacek
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function sw_register_cpt_faq() {
	$labels = array(
		'name'          => __( 'FAQ', 'stomatologia-wiacek' ),
		'singular_name' => __( 'Pytanie', 'stomatologia-wiacek' ),
		'add_new_item'  => __( 'Dodaj pytanie', 'stomatologia-wiacek' ),
		'edit_item'     => __( 'Edytuj pytanie', 'stomatologia-wiacek' ),
		'all_items'     => __( 'FAQ', 'stomatologia-wiacek' ),
		'menu_name'     => __( 'FAQ', 'stomatologia-wiacek' ),
	);

	register_post_type( 'faq', array(
		'labels'       => $labels,
		'public'       => true,
		'has_archive'  => false,
		'rewrite'      => array( 'slug' => 'faq', 'with_front' => false ),
		'menu_icon'    => 'dashicons-editor-help',
		'supports'     => array( 'title', 'editor', 'page-attributes' ), // title = question, editor = answer, menu_order = display order.
		'show_in_rest' => true,
		'menu_position' => 8,
	) );
}
add_action( 'init', 'sw_register_cpt_faq' );
