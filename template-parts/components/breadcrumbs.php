<?php
/**
 * Visible breadcrumbs + matching BreadcrumbList JSON-LD, built from
 * the same $trail array so both stay in sync.
 * Included on inner pages/templates (page.php, single.php, archives) —
 * intentionally omitted on the homepage.
 *
 * @package StomatologiaWiacek
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$trail = array(
	array( 'label' => __( 'Strona główna', 'stomatologia-wiacek' ), 'url' => home_url( '/' ) ),
);

if ( is_singular( 'service' ) ) {
	$trail[] = array( 'label' => __( 'Oferta', 'stomatologia-wiacek' ), 'url' => get_post_type_archive_link( 'service' ) );
	$trail[] = array( 'label' => get_the_title(), 'url' => null );
} elseif ( is_post_type_archive( 'service' ) ) {
	$trail[] = array( 'label' => __( 'Oferta', 'stomatologia-wiacek' ), 'url' => null );
} elseif ( is_singular( 'post' ) ) {
	$trail[] = array( 'label' => __( 'Aktualności', 'stomatologia-wiacek' ), 'url' => get_permalink( get_option( 'page_for_posts' ) ) );
	$trail[] = array( 'label' => get_the_title(), 'url' => null );
} elseif ( is_page() ) {
	$trail[] = array( 'label' => get_the_title(), 'url' => null );
}
?>
<nav class="sw-breadcrumbs" aria-label="<?php esc_attr_e( 'Ścieżka nawigacji', 'stomatologia-wiacek' ); ?>">
	<ol>
		<?php foreach ( $trail as $i => $crumb ) : ?>
			<li>
				<?php if ( $crumb['url'] ) : ?>
					<a href="<?php echo esc_url( $crumb['url'] ); ?>"><?php echo esc_html( $crumb['label'] ); ?></a>
				<?php else : ?>
					<span aria-current="page"><?php echo esc_html( $crumb['label'] ); ?></span>
				<?php endif; ?>
			</li>
		<?php endforeach; ?>
	</ol>
</nav>
<?php sw_output_breadcrumb_schema( $trail ); ?>
