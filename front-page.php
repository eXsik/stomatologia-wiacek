<?php
/**
 * Front page template — maps 1:1 to the approved homepage wireframe.
 * Section order is intentionally fixed in code rather than exposed as
 * client-editable Flexible Content (see architecture doc §6).
 *
 * @package StomatologiaWiacek
 */

get_header();
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

<?php get_footer(); ?>
