/**
 * Main script entry point. Loaded with defer, footer-enqueued.
 * Each module owns one behaviour and is only initialized if its
 * markup is present — no wasted work on pages that don't need it.
 */

import { initMobileMenu } from './modules/mobile-menu.js';
import { initStickyHeader } from './modules/sticky-header.js';
import { initFaqAccordion } from './modules/faq-accordion.js';

document.addEventListener( 'DOMContentLoaded', () => {
	initMobileMenu();
	initStickyHeader();
	initFaqAccordion();
} );

// initGallerySlider() is intentionally NOT imported here — it lives in
// its own conditionally-enqueued <script> (see inc/enqueue.php) so pages
// without a gallery never download it.
