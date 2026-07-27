<?php
/**
 * Default about copy when the O nas page has no editor content.
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
	$intro = trim( (string) ( get_field( 'why_us_intro', sw_front_page_id() ) ?: '' ) );
}
if ( '' === $intro ) {
	$intro = __( 'Wierzymy, że spokojna rozmowa, precyzja i indywidualny plan leczenia budują zaufanie na lata. Gabinet w centrum Ostrowa Wielkopolskiego łączy nowoczesną diagnostikę z ludzkim podejściem — bez pośpiechu i bez zbędnego żargonu.', 'stomatologia-wiacek' );
}
?>
<section class="sw-about-intro" aria-labelledby="sw-about-intro-heading">
	<div class="sw-about-intro__layout">
		<div class="sw-about-intro__copy">
			<h2 id="sw-about-intro-heading" class="sw-about-intro__heading">
				<?php
				echo wp_kses(
					sprintf(
						/* translators: %s: emphasized word */
						__( 'Leczymy %s, nie tylko zęby.', 'stomatologia-wiacek' ),
						'<em class="sw-about-intro__emphasis">' . esc_html__( 'ludzi', 'stomatologia-wiacek' ) . '</em>'
					),
					array(
						'em' => array(
							'class' => true,
						),
					)
				);
				?>
			</h2>
			<p class="sw-about-intro__text"><?php echo esc_html( $intro ); ?></p>
		</div>

		<ul class="sw-about-intro__list">
			<?php foreach ( $points as $point ) : ?>
				<li class="sw-about-intro__item">
					<span class="sw-about-intro__check" aria-hidden="true"></span>
					<span><?php echo esc_html( $point['title'] ); ?></span>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
