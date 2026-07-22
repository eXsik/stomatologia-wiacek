<?php
/**
 * Hero section.
 * Data: ACF fields on the front page (group_front_page — Hero tab).
 * Background image is the LCP candidate: loaded eager + high priority.
 *
 * @package StomatologiaWiacek
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$headline    = get_field( 'hero_headline' ) ?: 'Nowoczesna stomatologia bez stresu w Ostrowie Wielkopolskim';
$subheadline = get_field( 'hero_subheadline' ) ?: 'Bezbolesne leczenie, nowoczesny sprzęt i indywidualne podejście — od ponad 15 lat w centrum Ostrowa Wielkopolskiego.';
$hero_image  = get_field( 'hero_media' );
$cta1_label  = get_field( 'hero_cta_primary_label' ) ?: 'Umów wizytę';
$cta1_link   = get_field( 'hero_cta_primary_link' ) ?: '#kontakt';
$cta2_label  = get_field( 'hero_cta_secondary_label' ) ?: 'Zobacz ofertę';
$cta2_link   = get_field( 'hero_cta_secondary_link' ) ?: '#oferta';
?>
<section class="sw-hero" aria-labelledby="sw-hero-heading">
	<div class="sw-hero__media">
		<?php if ( $hero_image ) : ?>
			<?php sw_image( $hero_image, 'sw-hero', true, array( 'class' => 'sw-hero__image' ) ); ?>
		<?php endif; ?>
	</div>

	<div class="sw-container sw-hero__content">
		<h1 id="sw-hero-heading" class="sw-hero__heading"><?php echo esc_html( $headline ); ?></h1>
		<p class="sw-hero__subheading"><?php echo esc_html( $subheadline ); ?></p>

		<div class="sw-hero__ctas">
			<a href="<?php echo esc_url( $cta1_link ); ?>" class="sw-btn sw-btn--accent sw-btn--lg"><?php echo esc_html( $cta1_label ); ?></a>
			<a href="<?php echo esc_url( $cta2_link ); ?>" class="sw-btn sw-btn--outline sw-btn--lg"><?php echo esc_html( $cta2_label ); ?></a>
		</div>
	</div>
</section>
