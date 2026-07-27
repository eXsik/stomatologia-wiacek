/**
 * FAQ accordion — smooth height animation on top of native
 * <details>/<summary>. This is a progressive enhancement only:
 * the accordion is fully functional (expands/collapses, accessible,
 * keyboard-operable) with zero JavaScript via the native element.
 * This module just adds a smoother open/close transition than the
 * native instant show/hide.
 */

export function initFaqAccordion() {
	const items = document.querySelectorAll( '.sw-faq__item' );

	if ( ! items.length || ! ( 'animate' in Element.prototype ) ) {
		return; // Skip enhancement on unsupported browsers — native behaviour still works.
	}

	items.forEach( ( details ) => {
		const summary = details.querySelector( '.sw-faq__question' );
		const answer = details.querySelector( '.sw-faq__answer' );

		summary.addEventListener( 'click', ( event ) => {
			event.preventDefault();

			if ( details.open ) {
				collapse( details, answer );
			} else {
				expand( details, answer );
			}
		} );
	} );

	function expand( details, answer ) {
		details.open = true;
		const height = answer.scrollHeight;
		answer.animate(
			[ { height: '0px', opacity: 0 }, { height: height + 'px', opacity: 1 } ],
			{ duration: 180, easing: 'ease' }
		);
	}

	function collapse( details, answer ) {
		const height = answer.scrollHeight;
		const anim = answer.animate(
			[ { height: height + 'px', opacity: 1 }, { height: '0px', opacity: 0 } ],
			{ duration: 150, easing: 'ease' }
		);
		anim.onfinish = () => {
			details.open = false;
		};
	}
}
