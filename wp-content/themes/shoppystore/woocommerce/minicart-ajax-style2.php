<?php 
/* header style 7 */
if ( !class_exists( 'WooCommerce' ) ) { 
	return false;
}
global $woocommerce; ?>
<div class="top-form top-form-minicart  minicart-product-style3 pull-right">
	<div class="top-minicart pull-right">
		<a class="cart-contents" href="<?php echo wc_get_cart_url(); ?>" title="<?php esc_attr_e('Просмотр корзины', 'shoppystore'); ?>"><?php if($woocommerce->cart->cart_contents_count > 1) {?><?php echo '<span class="minicart-number">'.$woocommerce->cart->cart_contents_count.'</span> ' . esc_html__('шт.', 'shoppystore') .' - '. $woocommerce->cart->get_cart_total(); ?><?php } else { ?>
			<?php echo '<span class="minicart-number">'.$woocommerce->cart->cart_contents_count.'</span> ' . esc_html__('шт.', 'shoppystore') .' - '. $woocommerce->cart->get_cart_total(); ?>
			<?php } ?>
		</a>
	
	</div>
	<?php if( count($woocommerce->cart->cart_contents) > 0 ){?>
	<div class="wrapp-minicart">
		<div class="minicart-padding">
		<div class="additems">
			<span><?php esc_html_e('Товары в корзине', 'shoppystore'); ?></span>
			<p><?php esc_html_e('Цена', 'shoppystore'); ?></p>
		</div>
			<ul class="minicart-content">
			<?php 
					foreach($woocommerce->cart->cart_contents as $cart_item_key => $cart_item): 
					$_product  = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
					$product_name = ( sw_woocommerce_version_check( '3.0' ) ) ? $_product->get_name() : $_product->get_title();
				?>
				<li>
					<a href="<?php echo get_permalink($cart_item['product_id']); ?>" class="product-image">
						<?php echo $_product->get_image( 'shop_thumbnail' ); ?>
					</a>				 
	<div class="detail-item">
    <div class="product-details"> 
    	<?php echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf( '<a href="%s" class="btn-remove" title="%s"><span></span></a>', esc_url( wc_get_cart_remove_url( $cart_item_key ) ), __( 'Удалить товар', 'shoppystore' ) ), $cart_item_key ); ?>           
        <a class="btn-edit" href="<?php echo wc_get_cart_url(); ?>" title="<?php esc_attr_e('Просмотр корзины', 'shoppystore'); ?>"><span></span></a>    
        <p class="product-name">
							<a href="<?php echo get_permalink($cart_item['product_id']); ?>"><?php echo esc_html( $product_name ); ?></a>
        </p>
        <div class="qty-number"><span><?php esc_html_e('Количество: ', 'shoppystore'); ?> </span><?php echo esc_html( $cart_item['quantity'] ); ?></div>
  
	</div>
	    
	<div class="product-details-bottom">
		 <span class="price"><?php echo $woocommerce->cart->get_product_subtotal($cart_item['data'], 1); ?></span>		        		        		    		
			
    </div>
	</div>
					
				</li>
			<?php
			endforeach;
			?>
			</ul>
			<div class="cart-checkout">
			    <div class="price-total">
				   <span class="label-price-total"><?php esc_html_e('Total:', 'shoppystore'); ?></span>
				   <span class="price-total-w"><span class="price"><?php echo $woocommerce->cart->get_cart_total(); ?></span></span>
				   
				</div>
				<div class="cart-link"><a href="<?php echo get_permalink(get_option('woocommerce_cart_page_id')); ?>" title="Корзина"><?php esc_html_e('Просмотр корзины', 'shoppystore'); ?></a></div>
				<div class="checkout-link"><a href="<?php echo get_permalink(get_option('woocommerce_checkout_page_id')); ?>" title="Оформить заказ"><?php esc_html_e('Оформить заказ', 'shoppystore'); ?></a></div>
			</div>
		</div>
	</div>
	<?php } ?>
</div>