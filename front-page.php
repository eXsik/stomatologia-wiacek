<?php
/**
 * Front page template — fixed editorial section order.
 * Section order is intentional in code (not Flexible Content).
 * See docs/architecture.md.
 *
 * @package StomatologiaWiacek
 */

get_header();

// Establish global $post so ACF get_field() reads homepage meta
// (this template never enters The Loop otherwise).
if ( have_posts() ) {
	the_post();
}
?>

<main id="main">
	<?php
	get_template_part( 'template-parts/sections/hero' );
	get_template_part( 'template-parts/sections/trust-bar' );
	get_template_part( 'template-parts/sections/services-grid' );
	get_template_part( 'template-parts/sections/why-us' );
	get_template_part( 'template-parts/sections/doctor' );
	get_template_part( 'template-parts/sections/gallery-teaser' );
	get_template_part( 'template-parts/sections/testimonials' );
	get_template_part( 'template-parts/sections/faq' );
	get_template_part( 'template-parts/sections/contact' );
	?>
</main>

<?php
wp_reset_postdata();
get_footer();
?>
