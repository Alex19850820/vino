<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
 global $post, $woocommerce, $product;
 $attachments 		= $product->get_gallery_attachment_ids();
?>
<div id="quickview-container-<?php the_ID(); ?>">
	<div class="quickview-container woocommerce">
		<?php
        global $product;
            /**
             * woocommerce_before_single_product hook
             *
             * @hooked woocommerce_show_messages - 10
             */
             do_action( 'woocommerce_before_single_product' );
        ?>
        <div itemscope itemtype="http://schema.org/Product" id="product-<?php the_ID(); ?>" <?php post_class("product single-product"); ?>>
           <div class="single-product-top clearfix">
				<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
			        <div id="product_img_<?php echo esc_attr( $post->ID ); ?>" class="product-images loading"  data-vertical="false">
						<div class="product-images-container clearfix thumbnail-bottom">
							<?php if( count( $attachments ) > 0 ){ ?>
							<!-- Image Slider -->
							<div class="slider product-responsive">
								<?php foreach ( $attachments as $key => $attachment ) { ?>
								<div class="item-img-slider">
									<div class="images">
										<?php  sw_label_sales(); ?>	
										<?php if ($product->is_on_sale()) : ?>

											<?php echo apply_filters('woocommerce_sale_flash', '<span class="onsale">'.esc_html__( 'Распродажа!', 'shoppystore' ).'</span>', $post, $product); ?>

										<?php endif; ?>
										<a href="<?php echo get_permalink( $post->ID ) ?> "><?php echo wp_get_attachment_image( $attachment, 'shop_single' ); ?></a>
									</div>
								</div>
								<?php } ?>
							</div>
							<!-- Thumbnail Slider -->
							<?php 
							   do_action('woocommerce_product_thumbnails'); 
							?>
							<?php }else{ ?>
								<?php $image_id = get_post_thumbnail_id(); $image_url = wp_get_attachment_image_src($image_id,'large', true); ?>
								<div class="single-img-product">
									<div class="images">
									<?php if ($product->is_on_sale()) : ?>

										<?php echo apply_filters('woocommerce_sale_flash', '<span class="onsale">'.esc_html__( 'Распродажа!', 'shoppystore' ).'</span>', $post, $product); ?>

									<?php endif; ?>
									<a title="<?php the_title(); ?>" href="<?php echo get_permalink( $post->ID )  ?>" ><?php the_post_thumbnail('shop_single'); ?></a>
									</div>
								</div>
							<?php } ?>
						</div>	
					</div>
				</div>
				<div class="product-summary col-lg-7 col-md-7 col-sm-12 col-xs-12">
					  
					<?php
						/**
						 * woocommerce_single_product_summary hook
						 *
						 * @hooked woocommerce_template_single_title - 5
						 * @hooked woocommerce_template_single_price - 10
						 * @hooked woocommerce_template_single_excerpt - 20
						 * @hooked woocommerce_template_single_add_to_cart - 30
						 * @hooked woocommerce_template_single_meta - 40
						 * @hooked woocommerce_template_single_sharing - 50
						 */
						do_action( 'woocommerce_single_product_summary' );
					?>
				</div>
           </div><!-- .summary -->
		</div>
        
        <?php do_action( 'woocommerce_after_single_product' ); ?>
        <div class="clearfix"></div>
    </div>
</div>
<?php
	global $woocommerce;
	$assets_path          = str_replace( array( 'http:', 'https:' ), '', WC()->plugin_url() ) . '/assets/';
	$frontend_script_path = $assets_path . 'js/frontend/';
	$wc_ajax_url 					= WC_AJAX::get_endpoint( "%%endpoint%%" );
	$admin_url 						= admin_url('admin-ajax.php');	
	$ya_dest_folder = ( function_exists( 'sw_wooswatches_construct' ) ) ? 'woocommerce' : 'woocommerce_select';
?> 

<script type='text/javascript'>
/* <![CDATA[ */
<?php

$woocommerce_params = apply_filters( 'woocommerce_params', array(
	'ajax'  => array(
		'url'	=> $admin_url
	)
) );

$_wpUtilSettings = apply_filters( '_wpUtilSettings', array(
	'ajax_url'                => $woocommerce->ajax_url(),
	'wc_ajax_url'         => 	$wc_ajax_url
) );


$wc_add_to_cart_variation_params = apply_filters( 'wc_add_to_cart_variation_params', array(
	'i18n_no_matching_variations_text' => esc_attr__( 'Sorry, no products matched your selection. Please choose a different combination.', 'shoppystore' ),
	'i18n_make_a_selection_text'       => esc_attr__( 'Please select some product options before adding this product to your cart.', 'shoppystore' ),
	'i18n_unavailable_text'            => esc_attr__( 'Sorry, this product is unavailable. Please choose a different combination.', 'shoppystore' )
) );

?>
var _wpUtilSettings 							= <?php echo json_encode($_wpUtilSettings); ?>;
var woocommerce_params 							= <?php echo json_encode($woocommerce_params); ?>;
var wc_add_to_cart_variation_params = <?php echo json_encode($wc_add_to_cart_variation_params); ?>;

/* ]]> */
<?php
$suffix               = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
$assets_path          = str_replace( array( 'http:', 'https:' ), '', $woocommerce->plugin_url() ) . '/assets/';
$frontend_script_path = $assets_path . 'js/frontend/';
?>

jQuery(document).ready(function($) {
	$.getScript("<?php echo $frontend_script_path . 'add-to-cart' . $suffix . '.js'; ?>");
	$.getScript("<?php echo $frontend_script_path . 'woocommerce' . $suffix . '.js'; ?>");
	$.getScript("<?php echo get_template_directory_uri() . '/js/'. $ya_dest_folder .'/add-to-cart-variation.min.js'; ?>");
});
</script>

<script type="text/javascript">
 jQuery( ".single_add_to_cart_button" ).attr( "title", "<?php esc_html_e( 'Add to cart', 'shoppystore' ) ?>" );
 jQuery( ".add_to_wishlist" ).attr( "title", "" );
 jQuery( ".compare" ).attr( "title", "<?php esc_html_e( 'Добавить к сравнению', 'shoppystore' ) ?>" );
</script>

<script type='text/javascript' src='<?php echo esc_url ( home_url('/') )?>wp-includes/js/wp-embed.min.js'></script>
<script type='text/javascript' src='<?php echo esc_url ( home_url('/') )?>wp-includes/js/underscore.min.js'></script>
<script type='text/javascript' src='<?php echo esc_url ( home_url('/') )?>wp-includes/js/wp-util.min.js'></script>