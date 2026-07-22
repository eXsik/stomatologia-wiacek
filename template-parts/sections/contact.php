<?php
/**
 * Contact section — map, NAP, and contact form.
 * Data: ACF Options page (address, phone, hours, map coordinates).
 * Form uses a native <form> posting to admin-post.php with a hidden
 * honeypot field (visually + ARIA hidden) for lightweight spam protection.
 *
 * @package StomatologiaWiacek
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$lat = sw_get_option( 'clinic_lat', '51.6486' );
$lng = sw_get_option( 'clinic_lng', '17.8126' );
?>
<section class="sw-contact" id="kontakt" aria-labelledby="sw-contact-heading">
	<div class="sw-container sw-contact__layout">

		<div class="sw-contact__map">
			<iframe
				title="<?php esc_attr_e( 'Mapa — lokalizacja gabinetu', 'stomatologia-wiacek' ); ?>"
				src="https://www.google.com/maps?q=<?php echo esc_attr( $lat . ',' . $lng ); ?>&z=15&output=embed"
				width="100%" height="100%" style="border:0" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
			</iframe>
		</div>

		<div class="sw-contact__details">
			<h2 id="sw-contact-heading" class="sw-section-heading"><?php esc_html_e( 'Skontaktuj się z nami', 'stomatologia-wiacek' ); ?></h2>

			<address class="sw-contact__nap">
				<p><?php echo esc_html( sw_get_option( 'clinic_address' ) ); ?></p>
				<p><a href="<?php echo esc_url( sw_phone_href( sw_get_option( 'clinic_phone', '62 123 45 67' ) ) ); ?>"><?php echo esc_html( sw_get_option( 'clinic_phone', '62 123 45 67' ) ); ?></a></p>
				<p><a href="mailto:<?php echo esc_attr( sw_get_option( 'clinic_email' ) ); ?>"><?php echo esc_html( sw_get_option( 'clinic_email' ) ); ?></a></p>
			</address>

			<form class="sw-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<input type="hidden" name="action" value="sw_contact_form">
				<?php wp_nonce_field( 'sw_contact_form', 'sw_contact_nonce' ); ?>

				<div class="sw-form__field">
					<label for="sw-name"><?php esc_html_e( 'Imię i nazwisko', 'stomatologia-wiacek' ); ?></label>
					<input type="text" id="sw-name" name="name" required autocomplete="name">
				</div>

				<div class="sw-form__field">
					<label for="sw-phone"><?php esc_html_e( 'Telefon lub e-mail', 'stomatologia-wiacek' ); ?></label>
					<input type="text" id="sw-phone" name="contact" required autocomplete="tel">
				</div>

				<div class="sw-form__field">
					<label for="sw-message"><?php esc_html_e( 'Wiadomość', 'stomatologia-wiacek' ); ?></label>
					<textarea id="sw-message" name="message" rows="4" required></textarea>
				</div>

				<!-- Honeypot: hidden from sighted and AT users, bots often fill every field. -->
				<div class="sw-form__honeypot" aria-hidden="true">
					<label for="sw-website">Website</label>
					<input type="text" id="sw-website" name="website" tabindex="-1" autocomplete="off">
				</div>

				<button type="submit" class="sw-btn sw-btn--accent"><?php esc_html_e( 'Wyślij wiadomość', 'stomatologia-wiacek' ); ?></button>
			</form>
		</div>

	</div>
</section>
