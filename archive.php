<?php
/**
 * Fallback archive template — blog listings.
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
			'eyebrow' => __( 'Blog', 'stomatologia-wiacek' ),
			'title'   => get_the_archive_title(),
			'lead'    => get_the_archive_description() ? wp_strip_all_tags( get_the_archive_description() ) : __( 'Aktualności, porady i krótkie wpisy z gabinetu.', 'stomatologia-wiacek' ),
		)
	);
	?>

	<div class="sw-container sw-archive">
		<?php if ( have_posts() ) : ?>
			<div class="sw-blog-teaser__grid">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'template-parts/components/card-post' ); ?>
				<?php endwhile; ?>
			</div>
			<?php the_posts_pagination(); ?>
		<?php else : ?>
			<p><?php esc_html_e( 'Brak wpisów.', 'stomatologia-wiacek' ); ?></p>
		<?php endif; ?>
	</div>
</main>
<?php get_footer(); ?>
