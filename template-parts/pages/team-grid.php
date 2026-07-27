<?php
/**
 * Shared team grid for O nas / Zespół pages.
 *
 * @package StomatologiaWiacek
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$team = new WP_Query( array(
	'post_type'      => 'team_member',
	'posts_per_page' => 12,
	'orderby'        => 'menu_order',
	'order'          => 'ASC',
	'no_found_rows'  => true,
) );

$use_demo = ! $team->have_posts();
$hide_intro = ! empty( $args['hide_intro'] );
$demo_team = array(
	array(
		'name' => __( 'dr Anna Wiącek', 'stomatologia-wiacek' ),
		'role' => __( 'Stomatolog, właściciel gabinetu', 'stomatologia-wiacek' ),
		'bio'  => __( 'Specjalizuje się w stomatologii zachowawczej i estetycznej. Stawia na spokojną komunikację i plan leczenia krok po kroku.', 'stomatologia-wiacek' ),
	),
	array(
		'name' => __( 'dr Piotr Kowalski', 'stomatologia-wiacek' ),
		'role' => __( 'Chirurg stomatolog', 'stomatologia-wiacek' ),
		'bio'  => __( 'Implantologia i chirurgia stomatologiczna. Precyzja, bezpieczeństwo i jasne wyjaśnienie każdego etapu zabiegu.', 'stomatologia-wiacek' ),
	),
	array(
		'name' => __( 'Magdalena Nowak', 'stomatologia-wiacek' ),
		'role' => __( 'Higienistka stomatologiczna', 'stomatologia-wiacek' ),
		'bio'  => __( 'Profilaktyka, higienizacja i edukacja pacjentów. Pomaga utrzymać zdrowy uśmiech między wizytami.', 'stomatologia-wiacek' ),
	),
);
?>
<section class="sw-team" aria-labelledby="sw-team-heading">
	<?php if ( ! $hide_intro ) : ?>
		<div class="sw-archive__intro">
			<p class="sw-page-hero__eyebrow"><?php esc_html_e( 'Zespół', 'stomatologia-wiacek' ); ?></p>
			<h2 id="sw-team-heading" class="sw-archive__title">
				<?php esc_html_e( 'Ludzie, którym ufają pacjenci.', 'stomatologia-wiacek' ); ?>
			</h2>
			<?php if ( $use_demo ) : ?>
				<p class="sw-archive__lead"><?php esc_html_e( 'Poniżej przykładowe profile zespołu — w produkcji zastąp je realnymi danymi w panelu Zespół.', 'stomatologia-wiacek' ); ?></p>
			<?php endif; ?>
		</div>
	<?php else : ?>
		<h2 id="sw-team-heading" class="sw-visually-hidden"><?php esc_html_e( 'Zespół', 'stomatologia-wiacek' ); ?></h2>
	<?php endif; ?>

	<div class="sw-team-grid">
		<?php if ( $use_demo ) : ?>
			<?php foreach ( $demo_team as $member ) : ?>
				<article class="sw-team-card">
					<figure class="sw-team-card__photo sw-team-card__photo--empty" aria-hidden="true"></figure>
					<div class="sw-team-card__body">
						<h3 class="sw-team-card__name"><?php echo esc_html( $member['name'] ); ?></h3>
						<p class="sw-team-card__role"><?php echo esc_html( $member['role'] ); ?></p>
						<p class="sw-team-card__text"><?php echo esc_html( $member['bio'] ); ?></p>
					</div>
				</article>
			<?php endforeach; ?>
		<?php else : ?>
			<?php
			while ( $team->have_posts() ) :
				$team->the_post();
				$role = function_exists( 'get_field' ) ? (string) ( get_field( 'role' ) ?: '' ) : '';
				$bio  = trim( (string) get_the_excerpt() );
				if ( '' === $bio ) {
					$bio = wp_trim_words( wp_strip_all_tags( get_the_content() ), 40 );
				}
				$photo_id = (int) get_post_thumbnail_id();
				?>
				<article class="sw-team-card">
					<figure class="sw-team-card__photo<?php echo $photo_id ? '' : ' sw-team-card__photo--empty'; ?>">
						<?php if ( $photo_id ) : ?>
							<?php
							sw_image(
								$photo_id,
								'large',
								false,
								array(
									'alt' => get_the_title(),
								)
							);
							?>
						<?php endif; ?>
					</figure>
					<div class="sw-team-card__body">
						<h3 class="sw-team-card__name"><?php the_title(); ?></h3>
						<?php if ( '' !== $role ) : ?>
							<p class="sw-team-card__role"><?php echo esc_html( $role ); ?></p>
						<?php endif; ?>
						<?php if ( '' !== $bio ) : ?>
							<p class="sw-team-card__text"><?php echo esc_html( $bio ); ?></p>
						<?php endif; ?>
					</div>
				</article>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
		<?php endif; ?>
	</div>
</section>
