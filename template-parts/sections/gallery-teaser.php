<?php
/**
 * Before/after gallery teaser.
 * Data: fixed ACF Free slots (gallery_1_* … gallery_3_*) on the front page.
 * Sets a flag so enqueue.php conditionally loads gallery-slider.js —
 * this script is never shipped on pages without a gallery.
 *
 * @package StomatologiaWiacek
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$pairs = sw_get_gallery_pairs();

if ( sw_has_rows( $pairs ) ) {
	$GLOBALS['sw_needs_gallery_script'] = true;
}
?>
<section class="sw-gallery-teaser" aria-labelledby="sw-gallery-heading">
	<div class="sw-container">
		<h2 id="sw-gallery-heading" class="sw-section-heading"><?php esc_html_e( 'Efekty naszej pracy', 'stomatologia-wiacek' ); ?></h2>

		<?php if ( sw_has_rows( $pairs ) ) : ?>
			<div class="sw-gallery-teaser__row" data-sw-gallery-slider>
				<?php foreach ( $pairs as $pair ) : ?>
					<figure class="sw-gallery-teaser__pair">
						<?php sw_image( $pair['before'], 'sw-card' ); ?>
						<?php sw_image( $pair['after'], 'sw-card' ); ?>
						<figcaption><?php echo esc_html( $pair['label'] ?? '' ); ?></figcaption>
					</figure>
				<?php endforeach; ?>
			</div>
			<a href="<?php echo esc_url( get_post_type_archive_link( 'service' ) ); ?>" class="sw-link"><?php esc_html_e( 'Zobacz pełną galerię', 'stomatologia-wiacek' ); ?></a>
		<?php else : ?>
			<p><?php esc_html_e( 'Galeria pojawi się tutaj wkrótce.', 'stomatologia-wiacek' ); ?></p>
		<?php endif; ?>
	</div>
</section>
