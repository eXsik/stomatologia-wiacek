<?php
/**
 * Trust bar section — 4 stat tiles.
 * Data: ACF repeater 'trust_stats' on the front page.
 *
 * @package StomatologiaWiacek
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$stats = get_field( 'trust_stats' );

if ( ! sw_has_rows( $stats ) ) {
	// Fallback demo content so the section is never empty during setup.
	$stats = array(
		array( 'icon' => 'star', 'value' => '4.9/5', 'label' => 'Ocena Google' ),
		array( 'icon' => 'years', 'value' => '15+ lat', 'label' => 'Doświadczenia' ),
		array( 'icon' => 'scanner', 'value' => 'Skaner 3D', 'label' => 'Bez odcisków' ),
		array( 'icon' => 'microscope', 'value' => 'Mikroskop', 'label' => 'Precyzyjne leczenie kanałowe' ),
	);
}
?>
<section class="sw-trust-bar" aria-label="<?php esc_attr_e( 'Zaufanie pacjentów', 'stomatologia-wiacek' ); ?>">
	<div class="sw-container sw-trust-bar__grid">
		<?php foreach ( $stats as $stat ) : ?>
			<div class="sw-trust-bar__item">
				<span class="sw-icon sw-icon--<?php echo esc_attr( $stat['icon'] ); ?>" aria-hidden="true"></span>
				<span class="sw-trust-bar__value"><?php echo esc_html( $stat['value'] ); ?></span>
				<span class="sw-trust-bar__label"><?php echo esc_html( $stat['label'] ); ?></span>
			</div>
		<?php endforeach; ?>
	</div>
</section>
