<?php
/**
 * Before/after metamorphoses — editorial homepage section.
 * Data: fixed ACF Free slots (gallery_1_* … gallery_3_*).
 *
 * @package StomatologiaWiacek
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$pairs = sw_get_gallery_pairs();
$has_pairs = sw_has_rows( $pairs );

if ( $has_pairs ) {
	$GLOBALS['sw_needs_gallery_script'] = true;
	// Homepage shows up to two cases; extras can power controls later.
	$pairs = array_slice( $pairs, 0, 2 );
}
?>
<section class="sw-gallery" id="metamorfozy" aria-labelledby="sw-gallery-heading">
	<div class="sw-container sw-gallery__layout">
		<div class="sw-gallery__intro">
			<p class="sw-gallery__eyebrow"><?php esc_html_e( 'Metamorfozy', 'stomatologia-wiacek' ); ?></p>
			<h2 id="sw-gallery-heading" class="sw-gallery__heading">
				<?php esc_html_e( 'Zobacz prawdziwe metamorfozy uśmiechów.', 'stomatologia-wiacek' ); ?>
			</h2>
			<p class="sw-gallery__note">
				<?php esc_html_e( 'Efekty zależą od indywidualnego planu leczenia i stanu wyjściowego.', 'stomatologia-wiacek' ); ?>
			</p>
		</div>

		<div class="sw-gallery__cases<?php echo $has_pairs ? '' : ' sw-gallery__cases--placeholder'; ?>">
			<?php if ( $has_pairs ) : ?>
				<?php foreach ( $pairs as $pair ) : ?>
					<figure class="sw-gallery__case">
						<div class="sw-gallery__pair">
							<div class="sw-gallery__shot">
								<?php sw_image( $pair['before'], 'sw-card', false, array( 'class' => 'sw-gallery__image' ) ); ?>
								<span class="sw-gallery__label"><?php esc_html_e( 'Przed', 'stomatologia-wiacek' ); ?></span>
							</div>
							<div class="sw-gallery__shot">
								<?php sw_image( $pair['after'], 'sw-card', false, array( 'class' => 'sw-gallery__image' ) ); ?>
								<span class="sw-gallery__label"><?php esc_html_e( 'Po', 'stomatologia-wiacek' ); ?></span>
							</div>
						</div>
						<?php if ( ! empty( $pair['label'] ) ) : ?>
							<figcaption class="sw-gallery__caption"><?php echo esc_html( $pair['label'] ); ?></figcaption>
						<?php endif; ?>
					</figure>
				<?php endforeach; ?>
			<?php else : ?>
				<figure class="sw-gallery__case sw-gallery__case--empty" aria-label="<?php esc_attr_e( 'Przykładowe porównanie przed i po', 'stomatologia-wiacek' ); ?>">
					<div class="sw-gallery__pair">
						<div class="sw-gallery__shot sw-gallery__shot--placeholder">
							<span class="sw-gallery__label"><?php esc_html_e( 'Przed', 'stomatologia-wiacek' ); ?></span>
						</div>
						<div class="sw-gallery__shot sw-gallery__shot--placeholder">
							<span class="sw-gallery__label"><?php esc_html_e( 'Po', 'stomatologia-wiacek' ); ?></span>
						</div>
					</div>
					<figcaption class="sw-gallery__caption">
						<?php esc_html_e( 'Dodaj pary zdjęć w polach galerii na stronie głównej.', 'stomatologia-wiacek' ); ?>
					</figcaption>
				</figure>
			<?php endif; ?>
		</div>
	</div>
</section>
