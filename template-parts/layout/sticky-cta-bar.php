<?php
/**
 * Fixed mobile-only bottom bar: call + book, always reachable.
 * Hidden on desktop via CSS (see components/_buttons.css / layout rules).
 *
 * @package StomatologiaWiacek
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="sw-sticky-cta" data-sw-sticky-cta>
	<a href="<?php echo esc_url( sw_phone_href( sw_get_option( 'clinic_phone', '62 123 45 67' ) ) ); ?>" class="sw-sticky-cta__call">
		<?php esc_html_e( 'Zadzwoń', 'stomatologia-wiacek' ); ?>
	</a>
	<a href="<?php echo esc_url( sw_booking_url() ); ?>" class="sw-sticky-cta__book"<?php echo sw_booking_trigger_attrs(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
		<?php esc_html_e( 'Umów wizytę', 'stomatologia-wiacek' ); ?>
	</a>
</div>
