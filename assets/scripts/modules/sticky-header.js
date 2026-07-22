/**
 * Sticky header shrink-on-scroll effect.
 * Uses IntersectionObserver against a 1px sentinel instead of a scroll
 * event listener — avoids main-thread scroll-jank and is the more
 * performant modern pattern for this kind of state toggle.
 */

export function initStickyHeader() {
	const header = document.querySelector( '[data-sw-sticky-header]' );

	if ( ! header ) {
		return;
	}

	// Insert a 1px sentinel right before the header to detect when the
	// page has scrolled past the top.
	const sentinel = document.createElement( 'div' );
	sentinel.style.position = 'absolute';
	sentinel.style.top = '0';
	sentinel.style.height = '1px';
	sentinel.setAttribute( 'aria-hidden', 'true' );
	header.parentNode.insertBefore( sentinel, header );

	const observer = new IntersectionObserver(
		( entries ) => {
			entries.forEach( ( entry ) => {
				header.classList.toggle( 'is-scrolled', ! entry.isIntersecting );
			} );
		},
		{ threshold: 0 }
	);

	observer.observe( sentinel );
}
