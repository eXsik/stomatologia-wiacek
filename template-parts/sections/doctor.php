<?php
/**
 * Doctor / team teaser — right-hand column of the "Dlaczego my" band.
 * Data: relationship field 'featured_team_member' on the front page,
 * falling back to the CPT's own 'featured_on_homepage' flag if unset.
 *
 * @package StomatologiaWiacek
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$featured = get_field( 'featured_team_member' );
$doctor   = null;

if ( sw_has_rows( $featured ) ) {
	$doctor = $featured[0];
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
}
?>
<div class="sw-doctor-teaser">
	<h2 class="sw-section-heading"><?php esc_html_e( 'Poznaj lekarza', 'stomatologia-wiacek' ); ?></h2>

	<?php if ( $doctor ) : ?>
		<div class="sw-doctor-teaser__card">
			<?php sw_image( get_post_thumbnail_id( $doctor->ID ), 'sw-avatar', false, array( 'class' => 'sw-doctor-teaser__photo' ) ); ?>
			<div>
				<p class="sw-doctor-teaser__name"><?php echo esc_html( get_the_title( $doctor ) ); ?></p>
				<p class="sw-doctor-teaser__role"><?php echo esc_html( get_field( 'role', $doctor->ID ) ); ?></p>
				<p class="sw-doctor-teaser__bio"><?php echo esc_html( wp_trim_words( wp_strip_all_tags( $doctor->post_content ), 20 ) ); ?></p>
				<a href="<?php echo esc_url( get_permalink( $doctor ) ); ?>" class="sw-link"><?php esc_html_e( 'Poznaj cały zespół', 'stomatologia-wiacek' ); ?></a>
			</div>
		</div>
	<?php else : ?>
		<p><?php esc_html_e( 'Poznaj nasz zespół już wkrótce.', 'stomatologia-wiacek' ); ?></p>
	<?php endif; ?>
</div>
