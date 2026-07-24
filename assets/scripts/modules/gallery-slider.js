/**
 * Before/after gallery — one case at a time with prev/next controls.
 */

export function initGallerySlider() {
	const sliders = document.querySelectorAll( '[data-sw-gallery-slider]' );

	sliders.forEach( ( slider ) => {
		const track = slider.querySelector( '[data-sw-gallery-track]' );
		const slides = slider.querySelectorAll( '[data-sw-gallery-slide]' );
		const prev = slider.querySelector( '[data-sw-gallery-prev]' );
		const next = slider.querySelector( '[data-sw-gallery-next]' );

		if ( ! track || slides.length < 2 ) {
			return;
		}

		let index = 0;

		function goTo( nextIndex ) {
			index = ( nextIndex + slides.length ) % slides.length;
			const target = slides[ index ];
			if ( ! target ) {
				return;
			}
			track.scrollTo( {
				left: target.offsetLeft,
				behavior: 'smooth',
			} );
		}

		if ( prev ) {
			prev.addEventListener( 'click', () => goTo( index - 1 ) );
		}
		if ( next ) {
			next.addEventListener( 'click', () => goTo( index + 1 ) );
		}

		track.addEventListener( 'scroll', () => {
			const left = track.scrollLeft;
			let closest = 0;
			let closestDist = Infinity;
			slides.forEach( ( slide, i ) => {
				const dist = Math.abs( slide.offsetLeft - left );
				if ( dist < closestDist ) {
					closestDist = dist;
					closest = i;
				}
			} );
			index = closest;
		}, { passive: true } );

		track.setAttribute( 'tabindex', '0' );
		track.setAttribute( 'role', 'region' );
		track.setAttribute( 'aria-label', 'Galeria przed i po' );

		track.addEventListener( 'keydown', ( event ) => {
			if ( event.key === 'ArrowRight' ) {
				event.preventDefault();
				goTo( index + 1 );
			} else if ( event.key === 'ArrowLeft' ) {
				event.preventDefault();
				goTo( index - 1 );
			}
		} );
	} );
}

document.addEventListener( 'DOMContentLoaded', initGallerySlider );
