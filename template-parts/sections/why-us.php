<?php
/**
 * Manifest / why-us — editorial split with principles list and image.
 * Data: fixed ACF Free slots (why_us_1_* … why_us_3_*), why_us_intro, why_us_image.
 *
 * @package StomatologiaWiacek
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$points = sw_get_why_us_points();

if ( ! sw_has_rows( $points ) ) {
	$points = array(
		array( 'title' => 'Bezbolesne leczenie', 'description' => '' ),
		array( 'title' => 'Nowoczesny sprzęt', 'description' => '' ),
		array( 'title' => 'Indywidualne podejście', 'description' => '' ),
		array( 'title' => 'Spokojna atmosfera', 'description' => '' ),
	);
}

$intro = '';
if ( function_exists( 'get_field' ) ) {
	$intro = trim( (string) ( get_field( 'why_us_intro' ) ?: '' ) );
}
if ( '' === $intro ) {
	$intro = 'Wierzymy, że spokojna rozmowa, precyzja i indywidualny plan leczenia budują zaufanie na lata.';
}

$image_id = 0;
if ( function_exists( 'get_field' ) ) {
	$image_id = (int) get_field( 'why_us_image' );
}
?>
<section class="sw-manifest" aria-labelledby="sw-manifest-heading">
	<div class="sw-manifest__layout">
		<div class="sw-manifest__content">
			<p class="sw-manifest__eyebrow"><?php esc_html_e( 'Dlaczego my', 'stomatologia-wiacek' ); ?></p>
			<h2 id="sw-manifest-heading" class="sw-manifest__heading">
				<?php
				echo wp_kses(
					sprintf(
						/* translators: %s: emphasized word */
						__( 'Leczymy %s, nie tylko zęby.', 'stomatologia-wiacek' ),
						'<em class="sw-manifest__emphasis">' . esc_html__( 'ludzi', 'stomatologia-wiacek' ) . '</em>'
					),
					array(
						'em' => array(
							'class' => true,
						),
					)
				);
				?>
			</h2>
			<p class="sw-manifest__intro"><?php echo esc_html( $intro ); ?></p>

			<ul class="sw-manifest__list">
				<?php foreach ( $points as $point ) : ?>
					<li class="sw-manifest__item">
						<span class="sw-manifest__check" aria-hidden="true"></span>
						<span class="sw-manifest__item-text"><?php echo esc_html( $point['title'] ); ?></span>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>

		<div class="sw-manifest__media<?php echo $image_id ? '' : ' sw-manifest__media--placeholder'; ?>">
			<?php if ( $image_id ) : ?>
				<?php sw_image( $image_id, 'large', false, array( 'class' => 'sw-manifest__image' ) ); ?>
			<?php else : ?>
				<span class="sw-visually-hidden"><?php esc_html_e( 'Obraz sekcji w przygotowaniu', 'stomatologia-wiacek' ); ?></span>
			<?php endif; ?>
		</div>
	</div>
</section>
