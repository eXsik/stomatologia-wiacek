/**
 * Mobile off-canvas menu.
 * - Toggles visibility + aria-expanded on the trigger button.
 * - Traps focus inside the menu while open (accessibility requirement).
 * - Closes on Escape and returns focus to the trigger button.
 */

export function initMobileMenu() {
	const toggle = document.querySelector( '[data-sw-mobile-menu-toggle]' );
	const menu = document.getElementById( 'sw-mobile-menu' );

	if ( ! toggle || ! menu ) {
		return;
	}

	let lastFocused = null;

	function getFocusable() {
		return menu.querySelectorAll(
			'a[href], button:not([disabled]), input, textarea, select, [tabindex]:not([tabindex="-1"])'
		);
	}

	function openMenu() {
		lastFocused = document.activeElement;
		menu.hidden = false;
		toggle.setAttribute( 'aria-expanded', 'true' );
		document.body.style.overflow = 'hidden';

		const focusable = getFocusable();
		if ( focusable.length ) {
			focusable[ 0 ].focus();
		}
	}

	function closeMenu() {
		menu.hidden = true;
		toggle.setAttribute( 'aria-expanded', 'false' );
		document.body.style.overflow = '';
		if ( lastFocused ) {
			lastFocused.focus();
		}
	}

	toggle.addEventListener( 'click', () => {
		const isOpen = toggle.getAttribute( 'aria-expanded' ) === 'true';
		isOpen ? closeMenu() : openMenu();
	} );

	menu.addEventListener( 'keydown', ( event ) => {
		if ( event.key === 'Escape' ) {
			closeMenu();
			return;
		}

		// Focus trap: keep Tab cycling within the open menu.
		if ( event.key === 'Tab' ) {
			const focusable = Array.from( getFocusable() );
			if ( ! focusable.length ) {
				return;
			}
			const first = focusable[ 0 ];
			const last = focusable[ focusable.length - 1 ];

			if ( event.shiftKey && document.activeElement === first ) {
				event.preventDefault();
				last.focus();
			} else if ( ! event.shiftKey && document.activeElement === last ) {
				event.preventDefault();
				first.focus();
			}
		}
	} );

	// Close when a menu link is followed (mobile nav is a full-screen
	// overlay, so leaving it open after navigation would trap the user).
	menu.querySelectorAll( 'a' ).forEach( ( link ) => {
		link.addEventListener( 'click', closeMenu );
	} );
}
