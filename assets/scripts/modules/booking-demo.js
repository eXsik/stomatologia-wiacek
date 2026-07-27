/**
 * Portfolio demo booking widget.
 * Opens when a CTA with [data-sw-booking-open] is clicked.
 */

export function initBookingDemo() {
	const demo = document.querySelector( '[data-sw-booking-demo]' );
	if ( ! demo ) {
		return;
	}

	const triggers = document.querySelectorAll( '[data-sw-booking-open]' );
	const closeEls = demo.querySelectorAll( '[data-sw-booking-close]' );
	const slots = demo.querySelectorAll( '[data-sw-booking-slot]' );
	const submit = demo.querySelector( '[data-sw-booking-submit]' );
	const success = demo.querySelector( '[data-sw-booking-success]' );
	let lastFocused = null;

	function getFocusable() {
		return demo.querySelectorAll(
			'button:not([disabled]), [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
		);
	}

	function openDemo( event ) {
		if ( event ) {
			event.preventDefault();
		}
		lastFocused = document.activeElement;
		demo.hidden = false;
		document.body.style.overflow = 'hidden';
		if ( success ) {
			success.hidden = true;
		}
		if ( submit ) {
			submit.hidden = false;
		}

		const focusable = getFocusable();
		if ( focusable.length ) {
			focusable[ 0 ].focus();
		}
	}

	function closeDemo() {
		demo.hidden = true;
		document.body.style.overflow = '';
		if ( lastFocused && typeof lastFocused.focus === 'function' ) {
			lastFocused.focus();
		}
	}

	triggers.forEach( ( trigger ) => {
		trigger.addEventListener( 'click', openDemo );
	} );

	closeEls.forEach( ( el ) => {
		el.addEventListener( 'click', closeDemo );
	} );

	slots.forEach( ( slot ) => {
		slot.addEventListener( 'click', () => {
			slots.forEach( ( other ) => {
				other.classList.remove( 'is-selected' );
				other.setAttribute( 'aria-pressed', 'false' );
			} );
			slot.classList.add( 'is-selected' );
			slot.setAttribute( 'aria-pressed', 'true' );
		} );
	} );

	if ( submit ) {
		submit.addEventListener( 'click', () => {
			submit.hidden = true;
			if ( success ) {
				success.hidden = false;
				success.focus?.();
			}
		} );
	}

	demo.addEventListener( 'keydown', ( event ) => {
		if ( event.key === 'Escape' ) {
			closeDemo();
			return;
		}

		if ( event.key !== 'Tab' || demo.hidden ) {
			return;
		}

		const focusable = Array.from( getFocusable() ).filter( ( el ) => ! el.hasAttribute( 'hidden' ) && el.offsetParent !== null );
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
	} );

	// Deep-link support: /#sw-booking-demo opens the widget on load.
	if ( window.location.hash === '#sw-booking-demo' ) {
		openDemo();
	}
}
