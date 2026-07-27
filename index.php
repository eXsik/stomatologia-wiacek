<?php
/**
 * Fallback template required by WordPress core. Should rarely render
 * in practice since front-page.php, page.php, single.php, archive.php
 * and 404.php cover every real scenario in this theme.
 *
 * @package StomatologiaWiacek
 */

get_header();
?>
<main id="main">
	<div class="sw-container">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'template-parts/components/card-post' ); ?>
			<?php endwhile; ?>
		<?php else : ?>
			<p><?php esc_html_e( 'Brak treści.', 'stomatologia-wiacek' ); ?></p>
		<?php endif; ?>
	</div>
</main>
<?php get_footer(); ?>
