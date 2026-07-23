<?php
/**
 * Hero section — editorial asymmetric split (Scandinavian Editorial Premium).
 * Data: ACF fields on the front page (group_front_page — Hero tab).
 * When hero_media is set, the image is the LCP candidate: eager + high priority.
 * When missing, layout collapses to a single text column (no empty media column).
 *
 * Heading priority: split fields → hero_headline → PHP demo string.
 * Primary CTA URL: hero_cta_primary_link → booking_url → #kontakt.
 *
 * @package StomatologiaWiacek
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$eyebrow           = trim( (string) ( get_field( 'hero_eyebrow' ) ?: '' ) );
$heading_before   = trim( (string) ( get_field( 'hero_heading_before' ) ?: '' ) );
$heading_emphasis = trim( (string) ( get_field( 'hero_heading_emphasis' ) ?: '' ) );
$heading_after    = trim( (string) ( get_field( 'hero_heading_after' ) ?: '' ) );
$has_split        = ( '' !== $heading_before || '' !== $heading_emphasis || '' !== $heading_after );

$headline = '';
if ( ! $has_split ) {
	$headline = trim( (string) ( get_field( 'hero_headline' ) ?: '' ) );
	if ( '' === $headline ) {
		$headline = 'Stomatologia, której możesz zaufać.';
	}
}

$subheadline = get_field( 'hero_subheadline' ) ?: 'Nowoczesne leczenie, spokojne podejście i indywidualny plan terapii w centrum Ostrowa Wielkopolskiego.';
$hero_image  = get_field( 'hero_media' );
$cta1_label  = get_field( 'hero_cta_primary_label' ) ?: 'Umów wizytę';
$cta1_link   = trim( (string) ( get_field( 'hero_cta_primary_link' ) ?: '' ) );
if ( '' === $cta1_link ) {
	$cta1_link = sw_get_option( 'booking_url', '#kontakt' );
}
$cta2_label = get_field( 'hero_cta_secondary_label' ) ?: 'Poznaj ofertę';
$cta2_link  = get_field( 'hero_cta_secondary_link' ) ?: '#oferta';

$has_media     = ! empty( $hero_image );
$section_class = $has_media ? 'sw-hero' : 'sw-hero sw-hero--text-only';
?>
<section class="<?php echo esc_attr( $section_class ); ?>" aria-labelledby="sw-hero-heading">
	<div class="sw-hero__layout">
		<div class="sw-hero__content-column">
			<div class="sw-hero__content">
				<?php if ( '' !== $eyebrow ) : ?>
					<p class="sw-hero__eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
				<?php endif; ?>

				<h1 id="sw-hero-heading" class="sw-hero__heading">
					<?php if ( $has_split ) : ?>
						<?php if ( '' !== $heading_before ) : ?>
							<span class="sw-hero__heading-before"><?php echo esc_html( $heading_before ); ?></span>
						<?php endif; ?>
						<?php if ( '' !== $heading_emphasis ) : ?>
							<em class="sw-hero__heading-emphasis"><?php echo esc_html( $heading_emphasis ); ?></em>
						<?php endif; ?>
						<?php if ( '' !== $heading_after ) : ?>
							<span class="sw-hero__heading-after"><?php echo esc_html( $heading_after ); ?></span>
						<?php endif; ?>
					<?php else : ?>
						<?php echo esc_html( $headline ); ?>
					<?php endif; ?>
				</h1>

				<p class="sw-hero__subheading"><?php echo esc_html( $subheadline ); ?></p>

				<div class="sw-hero__ctas">
					<a href="<?php echo esc_url( $cta1_link ); ?>" class="sw-btn sw-btn--accent"><?php echo esc_html( $cta1_label ); ?></a>
					<a href="<?php echo esc_url( $cta2_link ); ?>" class="sw-btn sw-btn--ghost sw-hero__cta-secondary"><?php echo esc_html( $cta2_label ); ?></a>
				</div>
			</div>
		</div>

		<?php if ( $has_media ) : ?>
			<div class="sw-hero__media">
				<?php sw_image( $hero_image, 'sw-hero', true, array( 'class' => 'sw-hero__image' ) ); ?>
			</div>
		<?php endif; ?>
	</div>
</section>
