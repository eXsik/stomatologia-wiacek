<?php
/**
 * Portfolio demo booking widget (ZnanyLekarz / Booksy style).
 * Fictional clinic data only — not connected to a real practitioner.
 * Shown when Dane gabinetu → booking_url is empty.
 *
 * @package StomatologiaWiacek
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'sw_booking_is_demo' ) || ! sw_booking_is_demo() ) {
	return;
}

$slots = array( '09:00', '10:30', '12:00', '14:15', '16:00' );
?>
<div
	id="sw-booking-demo"
	class="sw-booking-demo"
	hidden
	role="dialog"
	aria-modal="true"
	aria-labelledby="sw-booking-demo-title"
	data-sw-booking-demo
>
	<div class="sw-booking-demo__backdrop" data-sw-booking-close tabindex="-1"></div>

	<div class="sw-booking-demo__panel">
		<div class="sw-booking-demo__head">
			<div>
				<p class="sw-booking-demo__badge"><?php esc_html_e( 'DEMO · integracja rezerwacji', 'stomatologia-wiacek' ); ?></p>
				<h2 id="sw-booking-demo-title" class="sw-booking-demo__title">
					<?php esc_html_e( 'Umów wizytę online', 'stomatologia-wiacek' ); ?>
				</h2>
			</div>
			<button type="button" class="sw-booking-demo__close" data-sw-booking-close>
				<span class="sw-visually-hidden"><?php esc_html_e( 'Zamknij', 'stomatologia-wiacek' ); ?></span>
				<span aria-hidden="true">&times;</span>
			</button>
		</div>

		<p class="sw-booking-demo__note">
			<?php esc_html_e( 'To demonstracyjny widget w stylu ZnanyLekarz / Booksy. Dane poniżej są fikcyjne — nie rezerwują prawdziwej wizyty.', 'stomatologia-wiacek' ); ?>
		</p>

		<div class="sw-booking-demo__doctor">
			<div class="sw-booking-demo__avatar" aria-hidden="true">AD</div>
			<div>
				<p class="sw-booking-demo__name"><?php esc_html_e( 'lek. dent. Anna Demo', 'stomatologia-wiacek' ); ?></p>
				<p class="sw-booking-demo__meta"><?php esc_html_e( 'Stomatologia zachowawcza · Ostrów Wielkopolski (dane testowe)', 'stomatologia-wiacek' ); ?></p>
			</div>
		</div>

		<div class="sw-booking-demo__day">
			<p class="sw-booking-demo__label"><?php esc_html_e( 'Najbliższy termin (przykład)', 'stomatologia-wiacek' ); ?></p>
			<p class="sw-booking-demo__date"><?php echo esc_html( wp_date( 'l, j F Y', strtotime( '+1 weekday' ) ) ); ?></p>
		</div>

		<div class="sw-booking-demo__slots" role="group" aria-label="<?php esc_attr_e( 'Godziny demonstracyjne', 'stomatologia-wiacek' ); ?>">
			<?php foreach ( $slots as $index => $slot ) : ?>
				<button
					type="button"
					class="sw-booking-demo__slot<?php echo 0 === $index ? ' is-selected' : ''; ?>"
					data-sw-booking-slot
					aria-pressed="<?php echo 0 === $index ? 'true' : 'false'; ?>"
				>
					<?php echo esc_html( $slot ); ?>
				</button>
			<?php endforeach; ?>
		</div>

		<button type="button" class="sw-btn sw-btn--accent sw-booking-demo__submit" data-sw-booking-submit>
			<?php esc_html_e( 'Potwierdź termin (demo)', 'stomatologia-wiacek' ); ?>
		</button>

		<p class="sw-booking-demo__success" data-sw-booking-success hidden>
			<?php esc_html_e( 'Demo zakończone — w produkcji ten krok przekazałby rezerwację do ZnanyLekarz / Booksy.', 'stomatologia-wiacek' ); ?>
		</p>

		<p class="sw-booking-demo__hint">
			<?php esc_html_e( 'Na żywo: wklej prawdziwy URL w Dane gabinetu → URL rezerwacji, a przyciski otworzą zewnętrzny kalendarz.', 'stomatologia-wiacek' ); ?>
		</p>
	</div>
</div>
