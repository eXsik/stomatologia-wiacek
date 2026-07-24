<?php
/**
 * Clinic data settings page (WordPress Settings API).
 *
 * Replaces the ACF Options Page so global NAP / hours / socials work
 * with ACF Free. Values are stored in the `sw_clinic` option and read
 * via sw_get_option() — same API used by header, footer, contact, schema.
 *
 * @package StomatologiaWiacek
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default clinic option values.
 *
 * @return array
 */
function sw_clinic_defaults() {
	return array(
		'clinic_phone'            => '62 123 45 67',
		'clinic_email'            => '',
		'clinic_address'          => 'ul. Przykładowa 1, 63-400 Ostrów Wielkopolski',
		'clinic_lat'              => '',
		'clinic_lng'              => '',
		'booking_url'             => '',
		'social_facebook'         => '',
		'social_instagram'        => '',
		'google_rating'           => '',
		'google_review_count'     => '',
		'clinic_hours'            => array(
			array( 'day' => 'Poniedziałek', 'open' => '09:00', 'close' => '17:00' ),
			array( 'day' => 'Wtorek', 'open' => '09:00', 'close' => '17:00' ),
			array( 'day' => 'Środa', 'open' => '09:00', 'close' => '17:00' ),
			array( 'day' => 'Czwartek', 'open' => '09:00', 'close' => '17:00' ),
			array( 'day' => 'Piątek', 'open' => '09:00', 'close' => '17:00' ),
			array( 'day' => 'Sobota', 'open' => '', 'close' => '' ),
			array( 'day' => 'Niedziela', 'open' => '', 'close' => '' ),
		),
	);
}

/**
 * Register the Dane gabinetu settings page.
 */
function sw_register_clinic_settings_page() {
	add_menu_page(
		__( 'Dane gabinetu', 'stomatologia-wiacek' ),
		__( 'Dane gabinetu', 'stomatologia-wiacek' ),
		'manage_options',
		'sw-clinic-settings',
		'sw_render_clinic_settings_page',
		'dashicons-admin-generic',
		59
	);
}
add_action( 'admin_menu', 'sw_register_clinic_settings_page' );

/**
 * Register setting + sanitize callback.
 */
function sw_register_clinic_setting() {
	register_setting(
		'sw_clinic_settings',
		'sw_clinic',
		array(
			'type'              => 'array',
			'sanitize_callback' => 'sw_sanitize_clinic_options',
			'default'           => sw_clinic_defaults(),
		)
	);
}
add_action( 'admin_init', 'sw_register_clinic_setting' );

/**
 * Sanitize clinic options on save.
 *
 * @param mixed $input Raw POST data.
 * @return array
 */
function sw_sanitize_clinic_options( $input ) {
	$defaults = sw_clinic_defaults();
	$input    = is_array( $input ) ? $input : array();
	$output   = $defaults;

	$output['clinic_phone']        = isset( $input['clinic_phone'] ) ? sanitize_text_field( $input['clinic_phone'] ) : '';
	$output['clinic_email']        = isset( $input['clinic_email'] ) ? sanitize_email( $input['clinic_email'] ) : '';
	$output['clinic_address']      = isset( $input['clinic_address'] ) ? sanitize_text_field( $input['clinic_address'] ) : '';
	$output['clinic_lat']          = isset( $input['clinic_lat'] ) ? sanitize_text_field( $input['clinic_lat'] ) : '';
	$output['clinic_lng']          = isset( $input['clinic_lng'] ) ? sanitize_text_field( $input['clinic_lng'] ) : '';
	$output['booking_url']         = isset( $input['booking_url'] ) ? esc_url_raw( $input['booking_url'] ) : '';
	$output['social_facebook']     = isset( $input['social_facebook'] ) ? esc_url_raw( $input['social_facebook'] ) : '';
	$output['social_instagram']    = isset( $input['social_instagram'] ) ? esc_url_raw( $input['social_instagram'] ) : '';
	$output['google_rating']       = isset( $input['google_rating'] ) ? sanitize_text_field( $input['google_rating'] ) : '';
	$output['google_review_count'] = isset( $input['google_review_count'] ) ? absint( $input['google_review_count'] ) : '';

	$hours = array();
	if ( ! empty( $input['clinic_hours'] ) && is_array( $input['clinic_hours'] ) ) {
		foreach ( $input['clinic_hours'] as $row ) {
			if ( ! is_array( $row ) ) {
				continue;
			}
			$day   = isset( $row['day'] ) ? sanitize_text_field( $row['day'] ) : '';
			$open  = isset( $row['open'] ) ? sanitize_text_field( $row['open'] ) : '';
			$close = isset( $row['close'] ) ? sanitize_text_field( $row['close'] ) : '';
			if ( '' === $day && '' === $open && '' === $close ) {
				continue;
			}
			$hours[] = array(
				'day'   => $day,
				'open'  => $open,
				'close' => $close,
			);
		}
	}
	$output['clinic_hours'] = $hours;

	return $output;
}

/**
 * Render the settings page markup.
 */
function sw_render_clinic_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$options = wp_parse_args( get_option( 'sw_clinic', array() ), sw_clinic_defaults() );
	$hours   = ! empty( $options['clinic_hours'] ) && is_array( $options['clinic_hours'] )
		? $options['clinic_hours']
		: sw_clinic_defaults()['clinic_hours'];

	// Pad to 7 rows for a predictable admin form.
	while ( count( $hours ) < 7 ) {
		$hours[] = array( 'day' => '', 'open' => '', 'close' => '' );
	}
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Dane gabinetu', 'stomatologia-wiacek' ); ?></h1>
		<p><?php esc_html_e( 'Globalne dane NAP, godzin i social media — używane w nagłówku, stopce, kontakcie i JSON-LD.', 'stomatologia-wiacek' ); ?></p>

		<form method="post" action="options.php">
			<?php settings_fields( 'sw_clinic_settings' ); ?>

			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><label for="sw_clinic_phone"><?php esc_html_e( 'Telefon', 'stomatologia-wiacek' ); ?></label></th>
					<td><input name="sw_clinic[clinic_phone]" type="text" id="sw_clinic_phone" value="<?php echo esc_attr( $options['clinic_phone'] ); ?>" class="regular-text"></td>
				</tr>
				<tr>
					<th scope="row"><label for="sw_clinic_email"><?php esc_html_e( 'E-mail', 'stomatologia-wiacek' ); ?></label></th>
					<td><input name="sw_clinic[clinic_email]" type="email" id="sw_clinic_email" value="<?php echo esc_attr( $options['clinic_email'] ); ?>" class="regular-text"></td>
				</tr>
				<tr>
					<th scope="row"><label for="sw_clinic_address"><?php esc_html_e( 'Adres', 'stomatologia-wiacek' ); ?></label></th>
					<td><input name="sw_clinic[clinic_address]" type="text" id="sw_clinic_address" value="<?php echo esc_attr( $options['clinic_address'] ); ?>" class="large-text"></td>
				</tr>
				<tr>
					<th scope="row"><label for="sw_clinic_booking_url"><?php esc_html_e( 'URL rezerwacji', 'stomatologia-wiacek' ); ?></label></th>
					<td>
						<input name="sw_clinic[booking_url]" type="url" id="sw_clinic_booking_url" value="<?php echo esc_attr( $options['booking_url'] ); ?>" class="regular-text" placeholder="https://www.znanylekarz.pl/...">
						<p class="description"><?php esc_html_e( 'Puste = demonstracyjny widget rezerwacji (dane testowe). Wklej URL ZnanyLekarz / Booksy, aby otwierać prawdziwy kalendarz.', 'stomatologia-wiacek' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="sw_clinic_lat"><?php esc_html_e( 'Szerokość geogr. (lat)', 'stomatologia-wiacek' ); ?></label></th>
					<td><input name="sw_clinic[clinic_lat]" type="text" id="sw_clinic_lat" value="<?php echo esc_attr( $options['clinic_lat'] ); ?>" class="regular-text"></td>
				</tr>
				<tr>
					<th scope="row"><label for="sw_clinic_lng"><?php esc_html_e( 'Długość geogr. (lng)', 'stomatologia-wiacek' ); ?></label></th>
					<td><input name="sw_clinic[clinic_lng]" type="text" id="sw_clinic_lng" value="<?php echo esc_attr( $options['clinic_lng'] ); ?>" class="regular-text"></td>
				</tr>
				<tr>
					<th scope="row"><label for="sw_clinic_fb"><?php esc_html_e( 'Facebook URL', 'stomatologia-wiacek' ); ?></label></th>
					<td><input name="sw_clinic[social_facebook]" type="url" id="sw_clinic_fb" value="<?php echo esc_attr( $options['social_facebook'] ); ?>" class="regular-text"></td>
				</tr>
				<tr>
					<th scope="row"><label for="sw_clinic_ig"><?php esc_html_e( 'Instagram URL', 'stomatologia-wiacek' ); ?></label></th>
					<td><input name="sw_clinic[social_instagram]" type="url" id="sw_clinic_ig" value="<?php echo esc_attr( $options['social_instagram'] ); ?>" class="regular-text"></td>
				</tr>
				<tr>
					<th scope="row"><label for="sw_clinic_rating"><?php esc_html_e( 'Ocena Google', 'stomatologia-wiacek' ); ?></label></th>
					<td><input name="sw_clinic[google_rating]" type="text" id="sw_clinic_rating" value="<?php echo esc_attr( $options['google_rating'] ); ?>" class="small-text" placeholder="4.9"></td>
				</tr>
				<tr>
					<th scope="row"><label for="sw_clinic_reviews"><?php esc_html_e( 'Liczba opinii Google', 'stomatologia-wiacek' ); ?></label></th>
					<td><input name="sw_clinic[google_review_count]" type="number" id="sw_clinic_reviews" value="<?php echo esc_attr( $options['google_review_count'] ); ?>" class="small-text" min="0"></td>
				</tr>
			</table>

			<h2><?php esc_html_e( 'Godziny otwarcia', 'stomatologia-wiacek' ); ?></h2>
			<table class="widefat striped" style="max-width:640px">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Dzień', 'stomatologia-wiacek' ); ?></th>
						<th><?php esc_html_e( 'Otwarcie', 'stomatologia-wiacek' ); ?></th>
						<th><?php esc_html_e( 'Zamknięcie', 'stomatologia-wiacek' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $hours as $i => $row ) : ?>
						<tr>
							<td><input name="sw_clinic[clinic_hours][<?php echo esc_attr( (string) $i ); ?>][day]" type="text" value="<?php echo esc_attr( $row['day'] ?? '' ); ?>" class="regular-text"></td>
							<td><input name="sw_clinic[clinic_hours][<?php echo esc_attr( (string) $i ); ?>][open]" type="text" value="<?php echo esc_attr( $row['open'] ?? '' ); ?>" class="small-text" placeholder="09:00"></td>
							<td><input name="sw_clinic[clinic_hours][<?php echo esc_attr( (string) $i ); ?>][close]" type="text" value="<?php echo esc_attr( $row['close'] ?? '' ); ?>" class="small-text" placeholder="17:00"></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<p class="description"><?php esc_html_e( 'Zostaw otwarcie i zamknięcie puste, aby ukryć dany dzień w stopce / schema.', 'stomatologia-wiacek' ); ?></p>

			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}
