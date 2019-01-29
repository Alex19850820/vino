<?php
function woo_related_products_limit() {
  global $product;
	
	$args['posts_per_page'] = 6;
	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'jk_related_products_args' );
  function jk_related_products_args( $args ) {

	$args['posts_per_page'] = vp_option("twi_woo_options.related_total_pro"); // 4 related products
	$args['columns'] = 1; // arranged in 2 columns
	return $args;
}

?>