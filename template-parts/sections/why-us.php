<?php
/**
 * "Dlaczego my" differentiators section.
 * Data: small ACF repeater — not a CPT, unlikely to need full CMS treatment.
 *
 * @package StomatologiaWiacek
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$points = get_field( 'why_us_points' );

if ( ! sw_has_rows( $points ) ) {
	$points = array(
		array( 'title' => 'Bezbolesne leczenie', 'description' => 'Nowoczesne znieczulenie i delikatne podejście do każdego pacjenta.' ),
		array( 'title' => 'Nowoczesny sprzęt', 'description' => 'Skaner 3D, tomografia CBCT i mikroskop zabiegowy.' ),
		array( 'title' => 'Indywidualne podejście', 'description' => 'Plan leczenia dopasowany do Twoich potrzeb i budżetu.' ),
	);
}
?>
<section class="sw-why-us" aria-labelledby="sw-why-us-heading">
	<div class="sw-container sw-why-us__layout">
		<div class="sw-why-us__content">
			<h2 id="sw-why-us-heading" class="sw-section-heading"><?php esc_html_e( 'Dlaczego my', 'stomatologia-wiacek' ); ?></h2>
			<ul class="sw-why-us__list">
				<?php foreach ( $points as $point ) : ?>
					<li class="sw-why-us__item">
						<h3><?php echo esc_html( $point['title'] ); ?></h3>
						<p><?php echo esc_html( $point['description'] ); ?></p>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php get_template_part( 'template-parts/sections/doctor' ); ?>
	</div>
</section>
