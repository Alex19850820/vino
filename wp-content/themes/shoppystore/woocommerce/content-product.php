<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $product, $woocommerce_loop, $post;

?>
<li <?php post_class(ya_product_attribute()); ?>>
	<div class="products-entry clearfix">
	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
		<div class="products-thumb">
			<?php
				/**
				 * woocommerce_before_shop_loop_item_title hook
				 *
				 * @hooked woocommerce_show_product_loop_sale_flash - 10
				 * @hooked woocommerce_template_loop_product_thumbnail - 10
				 */
				sw_label_sales();
				do_action( 'woocommerce_before_shop_loop_item_title' );
			
			?>

			<?php
				if( function_exists( 'ya_options' ) ){
						$quickview = ya_options()->getCpanelValue( 'product_quickview' );
					}
				if( $quickview ):

			    $nonce = wp_create_nonce("ya_quickviewproduct_nonce");
				$link = admin_url('admin-ajax.php?ajax=true&amp;action=ya_quickviewproduct&amp;post_id='.$post->ID.'&amp;nonce='.$nonce);
				$linkcontent ='<a href="'. $link .'" data-fancybox-type="ajax" class="fancybox fancybox.ajax sm_quickview_handler-list" title="Быстрый просмотр товара">'.apply_filters( 'out_of_stock_add_to_cart_text', __( 'Quick View', 'shoppystore' ) ).'</a>';
				echo $linkcontent;
                endif;

				?>

		</div>
		<div class="products-content">
				<div class="item-content">
				<h4><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?> </a></h4>
			    <?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?>
				<?php if ( $price_html = $product->get_price_html() ){?>
				<div class="item-price">
					<span>
						<?php echo $price_html; ?>
					</span>
				</div>
				<?php } ?>
				<div class="desc std">
				<?php echo apply_filters( 'woocommerce_short_description', $post->post_excerpt ) ?>
				</div>
				<div class="item-bottom clearfix">
					<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
				</div>
				<?php
				/**
				 * woocommerce_after_shop_loop_item_title hook
				 *
				 * @hooked woocommerce_template_loop_price - 10
				 */
				?>
			</div>
		</div>
	</div>
</li>