<?php 
	do_action( 'before' ); 
?>
<?php if ( (class_exists( 'WooCommerce' ) ) ) { ?>
<?php get_template_part( 'woocommerce/minicart-ajax' ); ?>
<?php } ?>