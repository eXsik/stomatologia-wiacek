<?php
/**
 * Service card component — used inside the loop in services-grid.php.
 *
 * @package StomatologiaWiacek
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$icon = get_field( 'icon' ) ?: 'aesthetic';
?>
<article class="sw-card sw-card--service">
	<a href="<?php the_permalink(); ?>" class="sw-card__link">
		<span class="sw-icon sw-icon--<?php echo esc_attr( $icon ); ?>" aria-hidden="true"></span>
		<h3 class="sw-card__title"><?php the_title(); ?></h3>
		<p class="sw-card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 14 ) ); ?></p>
		<span class="sw-card__cta"><?php esc_html_e( 'Dowiedz się więcej', 'stomatologia-wiacek' ); ?></span>
	</a>
</article>
