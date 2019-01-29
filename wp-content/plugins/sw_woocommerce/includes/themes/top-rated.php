<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version 2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $product, $woocommerce_loop;

$col_lg 	= ya_options()->getCpanelValue('product_col_large');
$col_md 	= ya_options()->getCpanelValue('product_col_medium');
$col_sm	 	= ya_options()->getCpanelValue('product_col_sm');
$column1 	= 12 / $col_md;
$column2 	= 12 / $col_sm;
$class_col	= "";
$col_large 	= 0;
// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) ) {
	$col_large = 12 / $col_lg;
}else{
	$col_large = 12 / $woocommerce_loop['columns'];
}

// Ensure visibility
if ( ! $product || ! $product->is_visible() ) {
	return;
}



$class_col .= ' col-lg-'.$col_large.' col-md-6 col-sm-4 clearfix';
?>
<li <?php post_class($class_col); ?>>
	<div class="products-entry clearfix">
	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
		<div class="products-thumb">
			<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'shop-recommend' ); ?></a>
			<div class="products-content">	
			<div class="item-content">
				<h4><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"> <?php sw_trim_words( get_the_title(), $title_length ); ?> </a></h4>
			    <?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?>
				<?php if ( $price_html = $product->get_price_html() ){?>
				<div class="item-price">
					<span>
						<?php echo $price_html; ?>
					</span>
				</div>
				<?php } ?>
			</div>
		</div>
		</div>
	</div>
</li>