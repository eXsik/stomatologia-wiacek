<?php
/**
 * Before/after metamorphoses — editorial homepage section with slider.
 * Data: fixed ACF Free slots (gallery_1_* … gallery_3_*).
 *
 * @package StomatologiaWiacek
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$pairs     = sw_get_gallery_pairs();
$has_pairs = sw_has_rows( $pairs );

if ( $has_pairs ) {
	$GLOBALS['sw_needs_gallery_script'] = true;
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

		<div class="sw-gallery__media">
			<?php if ( $has_pairs ) : ?>
				<div class="sw-gallery__slider" data-sw-gallery-slider>
					<div class="sw-gallery__track" data-sw-gallery-track>
						<?php foreach ( $pairs as $index => $pair ) : ?>
							<figure class="sw-gallery__case" data-sw-gallery-slide>
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
					</div>

					<?php if ( count( $pairs ) > 1 ) : ?>
						<div class="sw-gallery__controls">
							<button type="button" class="sw-gallery__nav sw-gallery__nav--prev" data-sw-gallery-prev aria-controls="sw-gallery-heading">
								<span class="sw-visually-hidden"><?php esc_html_e( 'Poprzednia metamorfoza', 'stomatologia-wiacek' ); ?></span>
								<span aria-hidden="true">←</span>
							</button>
							<button type="button" class="sw-gallery__nav sw-gallery__nav--next" data-sw-gallery-next aria-controls="sw-gallery-heading">
								<span class="sw-visually-hidden"><?php esc_html_e( 'Następna metamorfoza', 'stomatologia-wiacek' ); ?></span>
								<span aria-hidden="true">→</span>
							</button>
						</div>
					<?php endif; ?>
				</div>
			<?php else : ?>
				<div class="sw-gallery__cases sw-gallery__cases--placeholder">
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
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
