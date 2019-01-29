<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
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
 * @version 3.1.0
 */


	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	global $post, $woocommerce, $product;
	$ya_direction 		= ya_options()->getCpanelValue( 'direction' );
	$sidebar_product 	= ya_options()->getCpanelValue( 'sidebar_product' );
	$pdetail_layout = ya_options()->getCpanelValue( 'pdetail_layout' );
	$attachments 		= array();
?>
<div id="product_img_<?php echo esc_attr( $post->ID ); ?>" class="woocommerce-product-gallery woocommerce-product-gallery--with-images images product-images loading" data-rtl="<?php echo ( is_rtl() || $ya_direction == 'rtl' )? 'true' : 'false';?>" data-vertical="<?php echo ( ($sidebar_product == 'full' && $pdetail_layout == 'default') ||( $sidebar_product == 'full' && $pdetail_layout == 'full1') || ( $sidebar_product == 'lr' && $pdetail_layout == 'full3') ) ? 'true' : 'false'; ?>">
	<figure class="woocommerce-product-gallery__wrapper">
		<?php  sw_label_sales(); ?>
	<div class="product-images-container clearfix <?php echo ( ($sidebar_product == 'full' && $pdetail_layout == 'default') ||( $sidebar_product == 'full' && $pdetail_layout == 'full1') || ( $sidebar_product == 'lr' && $pdetail_layout == 'full3') ) ? 'thumbnail-left' : 'thumbnail-bottom'; ?>">
		<?php
			if( has_post_thumbnail() ){
				$attachments = ( sw_woocommerce_version_check( '3.0' ) ) ? $product->get_gallery_image_ids() : $product->get_gallery_attachment_ids();
				$image_id 	 = get_post_thumbnail_id();
				array_unshift( $attachments, $image_id );
		?>
		<?php
			if( ($sidebar_product == 'full' && $pdetail_layout == 'default') || ($sidebar_product == 'full' && $pdetail_layout == 'full1') || ( $sidebar_product == 'lr' && $pdetail_layout == 'full3') ){
				do_action('woocommerce_product_thumbnails');
			}
		?>
		<!-- Image Slider -->
		<div class="slider product-responsive">

			<?php
				foreach ( $attachments as $key => $attachment ) {
				$full_size_image  = wp_get_attachment_image_src( $attachment, 'full' );
				$thumbnail_post   = get_post( $attachment );
				$image_title      = $thumbnail_post->post_content;

				$attributes = array(
					'class' => 'wp-post-image',
					'title'                   => $image_title,
					'data-src'                => $full_size_image[0],
					'data-large_image'        => $full_size_image[0],
					'data-large_image_width'  => $full_size_image[1],
					'data-large_image_height' => $full_size_image[2],
				);
			?>
			<div class="item-img-slider">

					<div data-thumb="<?php echo wp_get_attachment_image_url( $attachment, 'shop_thumbnail' ) ?>" class="woocommerce-product-gallery__image">
					<?php if ($product->is_on_sale()) : ?>

						<?php echo apply_filters('woocommerce_sale_flash', '<span class="onsale">'.esc_html__( 'Распродажа!', 'shoppystore' ).'</span>', $post, $product); ?>

					<?php endif; ?>
						<a href="<?php echo wp_get_attachment_url( $attachment ) ?>"><?php echo wp_get_attachment_image( $attachment, 'shop_single', false, $attributes ); ?></a>
					</div>
			</div>
			<?php } ?>
		</div>
		<!-- Thumbnail Slider -->
		<?php
			if( $sidebar_product == 'left' || $sidebar_product == 'right' || ($sidebar_product == 'full' && $pdetail_layout == 'full2') ){
				do_action('woocommerce_product_thumbnails');
			}
		?>
		<?php }else{
				echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src(), __( 'Placeholder', 'shoppystore' ) ), $post->ID );
			}
		?>
	</div>
	</figure>
</div>