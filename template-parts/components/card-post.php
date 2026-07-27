<?php
/**
 * Blog post card component — used inside the loop in blog-teaser.php
 * and on the blog archive template.
 *
 * @package StomatologiaWiacek
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<article class="sw-card sw-card--post">
	<a href="<?php the_permalink(); ?>" class="sw-card__link">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php sw_image( get_post_thumbnail_id(), 'sw-card', false, array( 'class' => 'sw-card__image' ) ); ?>
		<?php endif; ?>
		<time class="sw-card__date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
		<h3 class="sw-card__title"><?php the_title(); ?></h3>
		<p class="sw-card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 16 ) ); ?></p>
	</a>
</article>
