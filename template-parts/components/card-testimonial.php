<?php
/**
 * Testimonial card component — used inside the loop in testimonials.php.
 *
 * @package StomatologiaWiacek
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$rating    = (int) get_field( 'rating' );
$quote     = get_field( 'quote' );
$treatment = get_field( 'treatment' );
?>
<figure class="sw-card sw-card--testimonial">
	<div class="sw-card__rating" aria-label="<?php echo esc_attr( sprintf( /* translators: %d: star rating */ __( 'Ocena: %d na 5 gwiazdek', 'stomatologia-wiacek' ), $rating ) ); ?>">
		<?php echo str_repeat( '★', $rating ) . str_repeat( '☆', 5 - $rating ); ?>
	</div>
	<blockquote class="sw-card__quote">
		<p>&bdquo;<?php echo esc_html( $quote ); ?>&rdquo;</p>
	</blockquote>
	<figcaption class="sw-card__author">
		<?php the_title(); ?><?php if ( $treatment ) : ?> — <?php echo esc_html( $treatment ); ?><?php endif; ?>
	</figcaption>
</figure>
