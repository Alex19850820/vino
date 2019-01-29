<?php
/**
 * Single Product Thumbnails
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-thumbnails.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version    3.3.3
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product, $woocommerce;

$attachment_ids = ( sw_woocommerce_version_check( '3.0' ) ) ? $product->get_gallery_image_ids() : $product->get_gallery_attachment_ids();
if( has_post_thumbnail() ) :
		$image_id = get_post_thumbnail_id();
		array_unshift( $attachment_ids, $image_id );
		$attachment_ids = array_unique( $attachment_ids );
	endif;
	if ( sizeof( $attachment_ids ) ) {
?>
	<div class="slider product-responsive-thumbnail" id="product_thumbnail_<?php echo esc_attr( $post->ID ); ?>">
		<?php foreach ( $attachment_ids as $attachment_id ) { ?>
		<div class="item-thumbnail-product">
			<div class="thumbnail-wrapper">
				<?php
				$image = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) );
				echo $image;
				?>
			</div>
		</div>
		<?php	}	?>
	</div>
<?php } ?>

