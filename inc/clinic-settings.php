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
 * Normalize clinic hours to 7 weekday rows (stable day labels).
 *
 * @param mixed $saved Saved clinic_hours value.
 * @return array<int, array{day:string,open:string,close:string}>
 */
function sw_normalize_clinic_hours( $saved ) {
	$defaults = sw_clinic_defaults()['clinic_hours'];
	$saved    = is_array( $saved ) ? array_values( $saved ) : array();
	$hours    = array();

	foreach ( $defaults as $i => $default_row ) {
		$row = isset( $saved[ $i ] ) && is_array( $saved[ $i ] ) ? $saved[ $i ] : array();
		$hours[] = array(
			'day'   => $default_row['day'],
			'open'  => isset( $row['open'] ) ? sanitize_text_field( (string) $row['open'] ) : (string) $default_row['open'],
			'close' => isset( $row['close'] ) ? sanitize_text_field( (string) $row['close'] ) : (string) $default_row['close'],
		);
	}

	return $hours;
}

/**
 * Clinic opening hours — always 7 normalized rows.
 *
 * @return array<int, array{day:string,open:string,close:string}>
 */
function sw_get_clinic_hours() {
	return sw_normalize_clinic_hours( sw_get_option( 'clinic_hours', array() ) );
}

/**
 * Short Polish weekday label for compact summaries.
 *
 * @param string $day Full day name.
 * @return string
 */
function sw_clinic_day_abbr( $day ) {
	$map = array(
		'Poniedziałek' => 'Pon',
		'Wtorek'       => 'Wt',
		'Środa'        => 'Śr',
		'Czwartek'     => 'Czw',
		'Piątek'       => 'Pt',
		'Sobota'       => 'Sob',
		'Niedziela'    => 'Nd',
	);

	return isset( $map[ $day ] ) ? $map[ $day ] : $day;
}

/**
 * Compress weekday indices into ranges (e.g. 0,2,3,5,6 → "Pon, Śr–Czw, So–Nd").
 *
 * @param array<int, array{index:int,abbr:string}> $days Day entries with stable weekday index.
 * @return string
 */
function sw_format_day_index_ranges( $days ) {
	if ( empty( $days ) ) {
		return '';
	}

	usort(
		$days,
		static function ( $a, $b ) {
			return (int) $a['index'] <=> (int) $b['index'];
		}
	);

	$parts   = array();
	$run     = array( $days[0] );
	$day_cnt = count( $days );

	for ( $i = 1; $i < $day_cnt; $i++ ) {
		$prev = $run[ count( $run ) - 1 ];
		$curr = $days[ $i ];
		if ( (int) $curr['index'] === (int) $prev['index'] + 1 ) {
			$run[] = $curr;
			continue;
		}
		$parts[] = sw_format_day_run( $run );
		$run     = array( $curr );
	}
	$parts[] = sw_format_day_run( $run );

	return implode( ', ', $parts );
}

/**
 * @param array<int, array{index:int,abbr:string}> $run Consecutive days.
 * @return string
 */
function sw_format_day_run( $run ) {
	$first = $run[0]['abbr'];
	$last  = $run[ count( $run ) - 1 ]['abbr'];

	if ( 1 === count( $run ) ) {
		return $first;
	}

	return $first . '–' . $last;
}

/**
 * Opening-hours summary lines for CTA (one schedule group per line).
 *
 * Works with mixed hours: identical days are grouped (e.g. "Wt, Pt 08:00–16:00");
 * if every day differs, each day becomes its own line.
 *
 * @return string[]
 */
function sw_get_clinic_hours_summary_lines() {
	$groups = array();

	foreach ( sw_get_clinic_hours() as $index => $row ) {
		if ( '' === $row['open'] || '' === $row['close'] ) {
			continue;
		}

		$key = $row['open'] . '|' . $row['close'];
		if ( ! isset( $groups[ $key ] ) ) {
			$groups[ $key ] = array(
				'open'  => $row['open'],
				'close' => $row['close'],
				'days'  => array(),
			);
		}

		$groups[ $key ]['days'][] = array(
			'index' => (int) $index,
			'abbr'  => sw_clinic_day_abbr( $row['day'] ),
		);
	}

	if ( empty( $groups ) ) {
		return array( __( 'Pon–Pt 09:00–17:00', 'stomatologia-wiacek' ) );
	}

	$lines = array();
	foreach ( $groups as $group ) {
		$lines[] = sprintf(
			'%1$s %2$s–%3$s',
			sw_format_day_index_ranges( $group['days'] ),
			$group['open'],
			$group['close']
		);
	}

	return $lines;
}

/**
 * Compact single-line opening-hours summary (joined schedule groups).
 *
 * @return string
 */
function sw_get_clinic_hours_summary() {
	return implode( ' · ', sw_get_clinic_hours_summary_lines() );
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
		$input['clinic_hours'] = array_values( $input['clinic_hours'] );
	}
	$output['clinic_hours'] = sw_normalize_clinic_hours( $input['clinic_hours'] ?? array() );

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
	$hours   = sw_normalize_clinic_hours( $options['clinic_hours'] ?? array() );
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
			<style>
				.sw-clinic-hours { max-width: 560px; }
				.sw-clinic-hours th:nth-child(1),
				.sw-clinic-hours td:nth-child(1) { width: 36%; }
				.sw-clinic-hours th:nth-child(2),
				.sw-clinic-hours th:nth-child(3),
				.sw-clinic-hours td:nth-child(2),
				.sw-clinic-hours td:nth-child(3) { width: 32%; }
				.sw-clinic-hours .sw-clinic-hours__time {
					box-sizing: border-box;
					width: 7.5rem;
					min-width: 7.5rem;
					padding: 0.35rem 0.5rem;
					font-size: 14px;
					font-variant-numeric: tabular-nums;
					letter-spacing: 0.02em;
				}
				.sw-clinic-hours .sw-clinic-hours__day {
					font-weight: 600;
				}
			</style>
			<table class="widefat striped sw-clinic-hours">
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
							<td>
								<span class="sw-clinic-hours__day"><?php echo esc_html( $row['day'] ); ?></span>
								<input type="hidden" name="sw_clinic[clinic_hours][<?php echo esc_attr( (string) $i ); ?>][day]" value="<?php echo esc_attr( $row['day'] ); ?>">
							</td>
							<td>
								<input
									name="sw_clinic[clinic_hours][<?php echo esc_attr( (string) $i ); ?>][open]"
									type="text"
									value="<?php echo esc_attr( $row['open'] ); ?>"
									class="sw-clinic-hours__time"
									placeholder="09:00"
									inputmode="numeric"
									autocomplete="off"
								>
							</td>
							<td>
								<input
									name="sw_clinic[clinic_hours][<?php echo esc_attr( (string) $i ); ?>][close]"
									type="text"
									value="<?php echo esc_attr( $row['close'] ); ?>"
									class="sw-clinic-hours__time"
									placeholder="17:00"
									inputmode="numeric"
									autocomplete="off"
								>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<p class="description"><?php esc_html_e( 'Zostaw otwarcie i zamknięcie puste, aby oznaczyć dzień jako zamknięty w stopce / schema.', 'stomatologia-wiacek' ); ?></p>

			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}
