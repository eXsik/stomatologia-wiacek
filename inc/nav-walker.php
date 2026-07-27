<?php
/**
 * Custom Walker_Nav_Menu for primary nav — flat top level + polished submenu.
 *
 * @package StomatologiaWiacek
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class SW_Nav_Walker extends Walker_Nav_Menu {

	public function start_lvl( &$output, $depth = 0, $args = null ) {
		$indent  = str_repeat( "\t", $depth );
		$classes = 0 === (int) $depth ? 'sw-submenu' : 'sw-submenu sw-submenu--nested';
		$output .= "\n{$indent}<ul class=\"{$classes}\">\n";
	}

	public function end_lvl( &$output, $depth = 0, $args = null ) {
		$indent  = str_repeat( "\t", $depth );
		$output .= "{$indent}</ul>\n";
	}

	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$has_children = in_array( 'menu-item-has-children', (array) $item->classes, true );
		$is_current   = function_exists( 'sw_nav_item_is_current' )
			? sw_nav_item_is_current( $item )
			: in_array( 'current-menu-item', (array) $item->classes, true );

		if ( $depth > 0 ) {
			$li_classes = array( 'sw-submenu__item' );
			if ( $is_current || in_array( 'current-menu-item', (array) $item->classes, true ) ) {
				$li_classes[] = 'is-current';
			}
			$link_class = 'sw-submenu__link';
		} else {
			$li_classes = array( 'sw-nav-item' );
			if ( $has_children ) {
				$li_classes[] = 'sw-nav-item--has-children';
			}
			$link_class = 'sw-nav-link';
		}

		$output .= '<li class="' . esc_attr( implode( ' ', $li_classes ) ) . '">';

		$attrs = array(
			'href'  => ! empty( $item->url ) ? $item->url : '#',
			'class' => $link_class,
		);

		if ( $is_current || ( $depth > 0 && in_array( 'current-menu-item', (array) $item->classes, true ) ) ) {
			$attrs['aria-current'] = 'page';
		}

		if ( 0 === (int) $depth && $has_children ) {
			$attrs['aria-haspopup'] = 'true';
			$attrs['aria-expanded'] = 'false';
			$attrs['data-sw-nav-parent'] = 'true';
		}

		$attr_string = '';
		foreach ( $attrs as $key => $value ) {
			$attr_string .= ' ' . $key . '="' . esc_attr( $value ) . '"';
		}

		$title = esc_html( $item->title );
		if ( 0 === (int) $depth && $has_children ) {
			$title .= ' <span class="sw-nav-link__caret" aria-hidden="true"></span>';
		}

		$output .= '<a' . $attr_string . '>' . $title . '</a>';
	}

	public function end_el( &$output, $item, $depth = 0, $args = null ) {
		$output .= "</li>\n";
	}
}
