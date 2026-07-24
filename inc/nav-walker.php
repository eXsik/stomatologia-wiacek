<?php
/**
 * Custom Walker_Nav_Menu producing accessible markup for the primary
 * nav, including aria-current, aria-expanded on submenu toggles, and
 * a semantic <ul>/<li> structure the mega-menu CSS hooks into.
 *
 * @package StomatologiaWiacek
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class SW_Nav_Walker extends Walker_Nav_Menu {

	public function start_lvl( &$output, $depth = 0, $args = null ) {
		$indent = str_repeat( "\t", $depth );
		$output .= "\n{$indent}<ul class=\"sw-submenu\" role=\"menu\">\n";
	}

	public function end_lvl( &$output, $depth = 0, $args = null ) {
		$indent = str_repeat( "\t", $depth );
		$output .= "{$indent}</ul>\n";
	}

	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$has_children = in_array( 'menu-item-has-children', $item->classes, true );
		$classes = array( 'sw-nav-item' );
		if ( $has_children ) {
			$classes[] = 'sw-nav-item--has-children';
		}

		$output .= '<li class="' . esc_attr( implode( ' ', $classes ) ) . '">';

		$attrs = array(
			'href'  => ! empty( $item->url ) ? $item->url : '',
			'class' => 'sw-nav-link',
		);

		if ( function_exists( 'sw_nav_item_is_current' ) ? sw_nav_item_is_current( $item ) : in_array( 'current-menu-item', $item->classes, true ) ) {
			$attrs['aria-current'] = 'page';
		}

		if ( $has_children ) {
			$attrs['aria-haspopup'] = 'true';
			$attrs['aria-expanded'] = 'false';
		}

		$attr_string = '';
		foreach ( $attrs as $key => $value ) {
			$attr_string .= ' ' . $key . '="' . esc_attr( $value ) . '"';
		}

		$output .= '<a' . $attr_string . '>' . esc_html( $item->title ) . '</a>';
	}

	public function end_el( &$output, $item, $depth = 0, $args = null ) {
		$output .= "</li>\n";
	}
}
