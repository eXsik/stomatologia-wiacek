<?php
/**
 * Homepage contact CTA band — compact booking conversion strip.
 * Full map/form lives in contact-full.php (Kontakt page template).
 *
 * @package StomatologiaWiacek
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$phone         = sw_get_option( 'clinic_phone', '62 123 45 67' );
$address       = sw_get_option( 'clinic_address', 'ul. Przykładowa 1, 63-400 Ostrów Wielkopolski' );
$booking       = sw_booking_url();
$hours_lines   = sw_get_clinic_hours_summary_lines();
?>
<section class="sw-contact-cta" id="kontakt" aria-labelledby="sw-contact-cta-heading">
	<div class="sw-container sw-contact-cta__inner">
		<div class="sw-contact-cta__copy">
			<h2 id="sw-contact-cta-heading" class="sw-contact-cta__heading">
				<?php esc_html_e( 'Umów się na wizytę', 'stomatologia-wiacek' ); ?>
			</h2>
			<p class="sw-contact-cta__text">
				<?php esc_html_e( 'Zadzwoń lub zarezerwuj termin online — odpowiemy szybko i bez zbędnych formalności.', 'stomatologia-wiacek' ); ?>
			</p>
		</div>

		<div class="sw-contact-cta__meta">
			<div class="sw-contact-cta__block">
				<span class="sw-contact-cta__label"><?php esc_html_e( 'Telefon', 'stomatologia-wiacek' ); ?></span>
				<a class="sw-contact-cta__value" href="<?php echo esc_url( sw_phone_href( $phone ) ); ?>">
					<?php echo esc_html( $phone ); ?>
				</a>
			</div>
			<div class="sw-contact-cta__block">
				<span class="sw-contact-cta__label"><?php esc_html_e( 'Godziny', 'stomatologia-wiacek' ); ?></span>
				<ul class="sw-contact-cta__hours">
					<?php foreach ( $hours_lines as $line ) : ?>
						<li><?php echo esc_html( $line ); ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div class="sw-contact-cta__block">
				<span class="sw-contact-cta__label"><?php esc_html_e( 'Adres', 'stomatologia-wiacek' ); ?></span>
				<span class="sw-contact-cta__value"><?php echo esc_html( $address ); ?></span>
			</div>
		</div>

		<div class="sw-contact-cta__action">
			<a class="sw-btn sw-btn--accent sw-btn--arrow sw-contact-cta__btn" href="<?php echo esc_url( $booking ); ?>"<?php echo sw_booking_trigger_attrs(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
				<?php esc_html_e( 'Umów wizytę', 'stomatologia-wiacek' ); ?>
			</a>
		</div>
	</div>
</section>
