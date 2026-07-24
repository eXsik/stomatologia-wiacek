<?php
/**
 * Trust bar section — 4 stat tiles.
 * Data: fixed ACF Free slots (trust_1_* … trust_4_*) on the front page.
 *
 * @package StomatologiaWiacek
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$stats = sw_get_trust_stats();

if ( ! sw_has_rows( $stats ) ) {
	// Fallback demo content so the section is never empty during setup.
	$stats = array(
		array( 'value' => '4.9/5', 'label' => 'Ocena Google' ),
		array( 'value' => '15+ lat', 'label' => 'Doświadczenia' ),
		array( 'value' => 'Skaner 3D', 'label' => 'Bez odcisków' ),
		array( 'value' => 'Mikroskop', 'label' => 'Precyzyjne leczenie kanałowe' ),
	);
}
?>
<section class="sw-trust-bar" aria-label="<?php esc_attr_e( 'Zaufanie pacjentów', 'stomatologia-wiacek' ); ?>">
	<div class="sw-container sw-trust-bar__grid">
		<?php foreach ( $stats as $stat ) : ?>
			<div class="sw-trust-bar__item">
				<span class="sw-trust-bar__value"><?php echo esc_html( $stat['value'] ); ?></span>
				<span class="sw-trust-bar__label"><?php echo esc_html( $stat['label'] ); ?></span>
			</div>
		<?php endforeach; ?>
	</div>
</section>
