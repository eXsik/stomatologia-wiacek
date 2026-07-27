/**
 * Main script entry point. Loaded with defer, footer-enqueued.
 * Each module owns one behaviour and is only initialized if its
 * markup is present — no wasted work on pages that don't need it.
 */

import { initMobileMenu } from './modules/mobile-menu.js';
import { initStickyHeader } from './modules/sticky-header.js';
import { initFaqAccordion } from './modules/faq-accordion.js';
import { initBookingDemo } from './modules/booking-demo.js';
import { initGallerySlider } from './modules/gallery-slider.js';
import { initNavDropdown } from './modules/nav-dropdown.js';

document.addEventListener( 'DOMContentLoaded', () => {
	initMobileMenu();
	initStickyHeader();
	initFaqAccordion();
	initBookingDemo();
	initGallerySlider();
	initNavDropdown();
} );