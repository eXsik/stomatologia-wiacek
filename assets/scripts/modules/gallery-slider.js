/**
 * Before/after gallery teaser — horizontal swipe on mobile.
 * This script is enqueued conditionally (see inc/enqueue.php) and only
 * ever loads on templates that actually render a gallery, never sitewide.
 */

export function initGallerySlider() {
	const rows = document.querySelectorAll( '[data-sw-gallery-slider]' );

	rows.forEach( ( row ) => {
		row.setAttribute( 'tabindex', '0' );
		row.setAttribute( 'role', 'region' );
		row.setAttribute( 'aria-label', 'Galeria przed i po — przewiń, aby zobaczyć więcej' );

		// Enable momentum-style horizontal scroll on touch devices via CSS
		// (scroll-snap, defined in the component's CSS); this module only
		// adds keyboard arrow-key support for parity.
		row.addEventListener( 'keydown', ( event ) => {
			if ( event.key === 'ArrowRight' ) {
				row.scrollBy( { left: 240, behavior: 'smooth' } );
			} else if ( event.key === 'ArrowLeft' ) {
				row.scrollBy( { left: -240, behavior: 'smooth' } );
			}
		} );
	} );
}

// This file is enqueued standalone (see inc/enqueue.php) rather than
// imported from main.js, so it initializes itself on load.
document.addEventListener( 'DOMContentLoaded', initGallerySlider );
