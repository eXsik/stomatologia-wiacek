<?php
/**
 * Service archive template — /oferta/
 *
 * @package StomatologiaWiacek
 */

get_header();
?>
<main id="main">
	<?php
	get_template_part(
		'template-parts/components/page-hero',
		null,
		array(
			'eyebrow'        => __( 'Oferta', 'stomatologia-wiacek' ),
			'title_html'     => sprintf(
				/* translators: %s: emphasized word */
				__( 'Kompleksowa %s', 'stomatologia-wiacek' ),
				'<em>' . esc_html__( 'stomatologia', 'stomatologia-wiacek' ) . '</em>'
			),
			'lead'           => __( 'Od profilaktyki po implanty — przejrzysty plan leczenia, spokojna atmosfera i indywidualne podejście.', 'stomatologia-wiacek' ),
			'aside_variant'  => 'services',
		)
	);
	?>

	<div class="sw-container sw-archive">
		<?php if ( have_posts() ) : ?>
			<div class="sw-services__grid">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'template-parts/components/card-service' ); ?>
				<?php endwhile; ?>
			</div>
			<?php the_posts_pagination(); ?>
		<?php else : ?>
			<p><?php esc_html_e( 'Wkrótce uzupełnimy listę usług.', 'stomatologia-wiacek' ); ?></p>
		<?php endif; ?>
	</div>
</main>
<?php get_footer(); ?>
