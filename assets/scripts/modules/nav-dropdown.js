/**
 * Desktop dropdown: touch/click toggle for parents with children.
 * Hover/focus-within still works via CSS; this covers coarse pointers.
 */

export function initNavDropdown() {
	const items = document.querySelectorAll( '.sw-nav .sw-nav-item--has-children' );
	if ( ! items.length ) {
		return;
	}

	function closeAll( except ) {
		items.forEach( ( item ) => {
			if ( item === except ) {
				return;
			}
			item.classList.remove( 'is-open' );
			const link = item.querySelector( ':scope > [data-sw-nav-parent]' );
			if ( link ) {
				link.setAttribute( 'aria-expanded', 'false' );
			}
		} );
	}

	items.forEach( ( item ) => {
		const link = item.querySelector( ':scope > [data-sw-nav-parent]' );
		if ( ! link ) {
			return;
		}

		link.addEventListener( 'click', ( event ) => {
			const isCoarse = window.matchMedia( '(hover: none), (pointer: coarse)' ).matches;
			const isOpen = item.classList.contains( 'is-open' );

			// On touch / no-hover: first tap opens, second follows the link.
			if ( isCoarse && ! isOpen ) {
				event.preventDefault();
				closeAll( item );
				item.classList.add( 'is-open' );
				link.setAttribute( 'aria-expanded', 'true' );
			}
		} );

		item.addEventListener( 'mouseenter', () => {
			link.setAttribute( 'aria-expanded', 'true' );
		} );
		item.addEventListener( 'mouseleave', () => {
			if ( ! item.classList.contains( 'is-open' ) ) {
				link.setAttribute( 'aria-expanded', 'false' );
			}
		} );
	} );

	document.addEventListener( 'click', ( event ) => {
		if ( ! event.target.closest( '.sw-nav-item--has-children' ) ) {
			closeAll();
		}
	} );

	document.addEventListener( 'keydown', ( event ) => {
		if ( event.key === 'Escape' ) {
			closeAll();
		}
	} );
}
