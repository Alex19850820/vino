<?php
/*
 * Single Product Rating
 *
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     3.1.0
*/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


global $product;

if ( get_option( 'woocommerce_enable_review_rating' ) === 'no' ) {
	return;
}
	$rating_count = $product->get_rating_count();
	$review_count = $product->get_review_count();
	$average      = $product->get_average_rating();
?>

<div class="reviews-content">
	<div class="star"><?php echo ( $average > 0 ) ?'<span style="width:'. ( $average*14 ).'px"></span>' : ''; ?></div>
		<a href="#reviews" class="woocommerce-review-link" rel="nofollow"><?php printf( _n( '%s Отзыв', '%s Отзывов', $rating_count, 'shoppystore' ), '<span class="count">' . $rating_count . '</span>' ); ?></a>
</div>


<?php $stock = ( $product->is_in_stock() )? 'in-stock' : 'out-stock' ; ?>
<div class="product-stock <?php echo esc_attr( $stock ); ?>">
	<?php  esc_html_e( 'Наличие', 'shoppystore' ); ?>:
	<span><?php echo ( $product->is_in_stock() )?  esc_html_e( 'В наличии', 'shoppystore' ) :  esc_html_e( 'Нет в наличии', 'shoppystore' ); ?></span>
</div>

<div class="product_meta">
	<?php do_action( 'woocommerce_product_meta_start' ); ?>
	<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>
	 <span class="sku_wrapper custom-font"><?php esc_html_e( 'Артикул:', 'shoppystore' ); ?> <span class="sku" itemprop="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'shoppystore' ); ?></span></span>
	<?php endif; ?>
	<?php do_action( 'woocommerce_product_meta_end' ); ?>
</div>