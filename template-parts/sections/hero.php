<?php
/**
 * Hero section — editorial asymmetric split (Scandinavian Editorial Premium).
 * Data: ACF fields on the front page (group_front_page — Hero tab).
 * When hero_media is set, the image is the LCP candidate: eager + high priority.
 * When missing, layout collapses to a single text column (no empty media column).
 *
 * @package StomatologiaWiacek
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$headline    = get_field( 'hero_headline' ) ?: 'Stomatologia, której możesz zaufać.';
$subheadline = get_field( 'hero_subheadline' ) ?: 'Nowoczesne leczenie, spokojne podejście i indywidualny plan terapii w centrum Ostrowa Wielkopolskiego.';
$hero_image  = get_field( 'hero_media' );
$cta1_label  = get_field( 'hero_cta_primary_label' ) ?: 'Umów wizytę';
$cta1_link   = get_field( 'hero_cta_primary_link' ) ?: '#kontakt';
$cta2_label  = get_field( 'hero_cta_secondary_label' ) ?: 'Poznaj ofertę';
$cta2_link   = get_field( 'hero_cta_secondary_link' ) ?: '#oferta';

$has_media     = ! empty( $hero_image );
$section_class = $has_media ? 'sw-hero' : 'sw-hero sw-hero--text-only';
?>
<section class="<?php echo esc_attr( $section_class ); ?>" aria-labelledby="sw-hero-heading">
	<div class="sw-container sw-hero__layout">
		<div class="sw-hero__content">
			<h1 id="sw-hero-heading" class="sw-hero__heading"><?php echo esc_html( $headline ); ?></h1>
			<p class="sw-hero__subheading"><?php echo esc_html( $subheadline ); ?></p>

			<div class="sw-hero__ctas">
				<a href="<?php echo esc_url( $cta1_link ); ?>" class="sw-btn sw-btn--accent sw-btn--lg"><?php echo esc_html( $cta1_label ); ?></a>
				<a href="<?php echo esc_url( $cta2_link ); ?>" class="sw-btn sw-btn--outline sw-btn--lg"><?php echo esc_html( $cta2_label ); ?></a>
			</div>
		</div>

		<?php if ( $has_media ) : ?>
			<div class="sw-hero__media">
				<?php sw_image( $hero_image, 'sw-hero', true, array( 'class' => 'sw-hero__image' ) ); ?>
			</div>
		<?php endif; ?>
	</div>
</section>
