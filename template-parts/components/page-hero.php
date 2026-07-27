<?php
/**
 * Unified editorial page hero — inner pages, archives, single service.
 *
 * Args:
 * - eyebrow (string)
 * - title (string) — plain text H1
 * - title_html (string) — alternative H1 with markup (e.g. <em>)
 * - lead (string)
 * - aside_variant (string) — preset for right panel
 * - aside (array) — explicit aside data (overrides variant)
 * - media_id (int) — optional featured image column instead of aside card
 * - show_actions (bool) — booking + back links (single service)
 * - price (string) — optional price line under lead
 *
 * @package StomatologiaWiacek
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$eyebrow        = isset( $args['eyebrow'] ) ? trim( (string) $args['eyebrow'] ) : '';
$title          = isset( $args['title'] ) ? trim( (string) $args['title'] ) : '';
$title_html     = isset( $args['title_html'] ) ? (string) $args['title_html'] : '';
$lead           = isset( $args['lead'] ) ? trim( (string) $args['lead'] ) : '';
$aside_variant  = isset( $args['aside_variant'] ) ? sanitize_key( $args['aside_variant'] ) : '';
$media_id       = isset( $args['media_id'] ) ? (int) $args['media_id'] : 0;
$show_actions   = ! empty( $args['show_actions'] );
$price          = isset( $args['price'] ) ? trim( (string) $args['price'] ) : '';

$aside = isset( $args['aside'] ) && is_array( $args['aside'] ) ? $args['aside'] : array();
if ( empty( $aside ) && '' !== $aside_variant ) {
	$aside = sw_page_hero_aside( $aside_variant );
}

$has_media  = $media_id > 0;
$has_aside  = ! $has_media && isset( $aside['type'] ) && 'none' !== $aside['type'];
$hero_class = 'sw-page-hero';
if ( $has_media ) {
	$hero_class .= ' sw-page-hero--media';
}
?>
<header class="<?php echo esc_attr( $hero_class ); ?>">
	<div class="sw-container sw-page-hero__shell">
		<?php get_template_part( 'template-parts/components/breadcrumbs' ); ?>

		<div class="sw-page-hero__layout">
			<div class="sw-page-hero__copy">
				<?php if ( '' !== $eyebrow ) : ?>
					<p class="sw-page-hero__eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
				<?php endif; ?>

				<h1 class="sw-page-hero__title">
					<?php
					if ( '' !== $title_html ) {
						echo wp_kses_post( $title_html );
					} else {
						echo esc_html( $title );
					}
					?>
				</h1>

				<?php if ( '' !== $lead ) : ?>
					<p class="sw-page-hero__lead"><?php echo esc_html( $lead ); ?></p>
				<?php endif; ?>

				<?php if ( '' !== $price ) : ?>
					<p class="sw-page-hero__price"><?php echo esc_html( $price ); ?></p>
				<?php endif; ?>

				<?php if ( $show_actions ) : ?>
					<div class="sw-page-hero__actions">
						<a class="sw-btn sw-btn--accent sw-btn--arrow" href="<?php echo esc_url( sw_booking_url() ); ?>"<?php echo sw_booking_trigger_attrs(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
							<?php esc_html_e( 'Umów wizytę', 'stomatologia-wiacek' ); ?>
						</a>
						<a class="sw-btn sw-btn--ghost" href="<?php echo esc_url( get_post_type_archive_link( 'service' ) ?: home_url( '/oferta/' ) ); ?>">
							<?php esc_html_e( 'Wszystkie usługi', 'stomatologia-wiacek' ); ?>
						</a>
					</div>
				<?php endif; ?>
			</div>

			<?php if ( $has_media ) : ?>
				<figure class="sw-page-hero__media">
					<?php
					sw_image(
						$media_id,
						'sw-hero',
						false,
						array(
							'class' => 'sw-page-hero__image',
							'alt'   => $title,
						)
					);
					?>
				</figure>
			<?php elseif ( $has_aside ) : ?>
				<aside class="sw-page-hero__aside" aria-label="<?php echo esc_attr( $aside['aria_label'] ?? __( 'Podsumowanie', 'stomatologia-wiacek' ) ); ?>">
					<?php if ( 'contact' === $aside['type'] ) : ?>
						<p class="sw-page-hero__aside-label"><?php esc_html_e( 'Zadzwoń', 'stomatologia-wiacek' ); ?></p>
						<a class="sw-page-hero__aside-phone" href="<?php echo esc_url( sw_phone_href( $aside['phone'] ) ); ?>">
							<?php echo esc_html( $aside['phone'] ); ?>
						</a>
						<p class="sw-page-hero__aside-note"><?php echo esc_html( $aside['address'] ); ?></p>
						<a class="sw-btn sw-btn--accent sw-btn--arrow sw-page-hero__aside-btn" href="<?php echo esc_url( sw_booking_url() ); ?>"<?php echo sw_booking_trigger_attrs(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
							<?php esc_html_e( 'Umów wizytę', 'stomatologia-wiacek' ); ?>
						</a>
					<?php elseif ( 'booking' === $aside['type'] ) : ?>
						<p class="sw-page-hero__aside-label"><?php esc_html_e( 'Pierwszy krok', 'stomatologia-wiacek' ); ?></p>
						<p class="sw-page-hero__aside-note"><?php esc_html_e( 'Umów konsultację — omówimy plan leczenia bez presji i w przejrzystym języku.', 'stomatologia-wiacek' ); ?></p>
						<a class="sw-btn sw-btn--accent sw-btn--arrow sw-page-hero__aside-btn" href="<?php echo esc_url( sw_booking_url() ); ?>"<?php echo sw_booking_trigger_attrs(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
							<?php esc_html_e( 'Umów wizytę', 'stomatologia-wiacek' ); ?>
						</a>
					<?php elseif ( 'stat' === $aside['type'] ) : ?>
						<p class="sw-page-hero__stat">
							<span class="sw-page-hero__stat-value"><?php echo esc_html( $aside['stat_value'] ?? '' ); ?></span>
							<span class="sw-page-hero__stat-label"><?php echo esc_html( $aside['stat_label'] ?? '' ); ?></span>
						</p>
						<?php if ( ! empty( $aside['note'] ) ) : ?>
							<p class="sw-page-hero__aside-note"><?php echo esc_html( $aside['note'] ); ?></p>
						<?php endif; ?>
					<?php endif; ?>
				</aside>
			<?php else : ?>
				<div class="sw-page-hero__accent" aria-hidden="true">
					<span class="sw-page-hero__accent-line"></span>
				</div>
			<?php endif; ?>
		</div>
	</div>
</header>
