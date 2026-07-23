<?php
/**
 * Featured doctor — full-width dark teal homepage band.
 * Data: front-page `featured_team_member`, fallback `featured_on_homepage`.
 *
 * @package StomatologiaWiacek
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$featured = function_exists( 'get_field' ) ? get_field( 'featured_team_member' ) : null;
$doctor   = null;

if ( $featured instanceof WP_Post ) {
	$doctor = $featured;
} elseif ( is_numeric( $featured ) ) {
	$doctor = get_post( (int) $featured );
} else {
	$fallback = new WP_Query( array(
		'post_type'      => 'team_member',
		'posts_per_page' => 1,
		'meta_key'       => 'featured_on_homepage',
		'meta_value'     => '1',
		'no_found_rows'  => true,
	) );
	if ( $fallback->have_posts() ) {
		$doctor = $fallback->posts[0];
	}
	wp_reset_postdata();
}

if ( ! $doctor ) {
	return;
}

$role    = function_exists( 'get_field' ) ? (string) ( get_field( 'role', $doctor->ID ) ?: '' ) : '';
$certs   = function_exists( 'get_field' ) ? (string) ( get_field( 'certifications', $doctor->ID ) ?: '' ) : '';
$bio     = trim( (string) $doctor->post_excerpt );
if ( '' === $bio ) {
	$bio = wp_trim_words( wp_strip_all_tags( $doctor->post_content ), 36 );
}

$qualifications = array();
if ( '' !== trim( $certs ) ) {
	$lines = preg_split( '/\r\n|\r|\n/', $certs );
	if ( is_array( $lines ) ) {
		foreach ( $lines as $line ) {
			$line = trim( $line );
			if ( '' !== $line ) {
				$qualifications[] = $line;
			}
		}
	}
}

if ( empty( $qualifications ) ) {
	$qualifications = array(
		__( 'Stomatologia zachowawcza', 'stomatologia-wiacek' ),
		__( 'Protetyka', 'stomatologia-wiacek' ),
		__( 'Planowanie leczenia implantologicznego', 'stomatologia-wiacek' ),
		__( 'Szkolenia krajowe i zagraniczne', 'stomatologia-wiacek' ),
	);
}

$team_url = get_post_type_archive_link( 'team_member' );
if ( ! $team_url ) {
	$team_url = get_permalink( $doctor );
}

$portrait_id = (int) get_post_thumbnail_id( $doctor->ID );
?>
<section class="sw-doctor-feature" aria-labelledby="sw-doctor-feature-heading">
	<div class="sw-container sw-doctor-feature__layout">
		<div class="sw-doctor-feature__portrait">
			<?php if ( $portrait_id ) : ?>
				<?php
				sw_image(
					$portrait_id,
					'large',
					false,
					array(
						'class' => 'sw-doctor-feature__image',
						'alt'   => get_the_title( $doctor ),
					)
				);
				?>
			<?php else : ?>
				<div class="sw-doctor-feature__image sw-doctor-feature__image--placeholder" aria-hidden="true"></div>
			<?php endif; ?>
		</div>

		<div class="sw-doctor-feature__bio">
			<p class="sw-doctor-feature__eyebrow"><?php esc_html_e( 'Nasz lekarz', 'stomatologia-wiacek' ); ?></p>
			<h2 id="sw-doctor-feature-heading" class="sw-doctor-feature__name">
				<?php echo esc_html( get_the_title( $doctor ) ); ?>
			</h2>
			<?php if ( '' !== $role ) : ?>
				<p class="sw-doctor-feature__role"><?php echo esc_html( $role ); ?></p>
			<?php endif; ?>
			<?php if ( '' !== $bio ) : ?>
				<p class="sw-doctor-feature__text"><?php echo esc_html( $bio ); ?></p>
			<?php endif; ?>
			<a class="sw-doctor-feature__cta" href="<?php echo esc_url( $team_url ); ?>">
				<?php esc_html_e( 'Poznaj cały zespół', 'stomatologia-wiacek' ); ?>
			</a>
		</div>

		<ul class="sw-doctor-feature__quals">
			<?php foreach ( $qualifications as $item ) : ?>
				<li class="sw-doctor-feature__qual"><?php echo esc_html( $item ); ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
