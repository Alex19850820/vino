<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$sidebar = ya_options() -> getCpanelValue('sidebar_product');
$ya_header_style 	= ya_options()->getCpanelValue('header_style');
$pdetail_layout = ya_options() -> getCpanelValue('pdetail_layout');
?>
<?php get_header( $ya_header_style ) ?>

<div class="container">
<div class="row sidebar-row">
<?php if ( ( is_active_sidebar_YA('left-detail-product') && $sidebar == 'left' ) || ( is_active_sidebar_YA('left-detail-product') && $sidebar == 'lr' ) ):
	$left_span_class = 'col-lg-'.ya_options()->getCpanelValue('sidebar_left_expand');
	$left_span_class .= ' col-md-'.ya_options()->getCpanelValue('sidebar_left_expand_md');
	$left_span_class .= ' col-sm-'.ya_options()->getCpanelValue('sidebar_left_expand_sm');
	$left_span_class .= ' col-xs-'.ya_options()->getCpanelValue('sidebar_left_expand_xs');
?>
<aside id="left" class="sidebar <?php echo esc_attr($left_span_class); ?>">
	<?php dynamic_sidebar('left-detail-product'); ?>
</aside>

<?php endif; ?>
<div id="contents-detail" <?php ya_content_detail_product(); ?> role="main">
	<?php
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action('woocommerce_before_main_content');
	?>
	<?php if ($pdetail_layout == 'default') { ?>
		<div class="single-product clearfix">
			<?php while ( have_posts() ) : the_post(); ?>

				<?php wc_get_template_part( 'content', 'single-product' ); ?>

			<?php endwhile; // end of the loop. ?>
		
		</div>
	<?php }else { ?>
	     <div class="single-product <?php echo $pdetail_layout ?> clearfix">
		
			<?php while ( have_posts() ) : the_post(); ?>

				<?php wc_get_template_part( 'content', 'single-product-'.$pdetail_layout.'' ); ?>

			<?php endwhile; // end of the loop. ?>
		
		</div>
	<?php } ?>
	<?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action('woocommerce_after_main_content');
	?>
</div>
<!--- contents-detail --->
<?php if ( ( is_active_sidebar_YA('right-detail-product') && $sidebar == 'right' ) || ( is_active_sidebar_YA('right-detail-product') && $sidebar == 'lr' ) ):
	$right_span_class = 'col-lg-'.ya_options()->getCpanelValue('sidebar_right_expand');
	$right_span_class .= ' col-md-'.ya_options()->getCpanelValue('sidebar_right_expand_md');
	$right_span_class .= ' col-sm-'.ya_options()->getCpanelValue('sidebar_right_expand_sm');
?>
<aside id="right" class="sidebar <?php echo esc_attr($right_span_class); ?>">
	<?php dynamic_sidebar('right-detail-product'); ?>
</aside>
<?php endif; ?>
<?php if ($pdetail_layout == 'full3') { ?>
  <div class="full3 col-md-12">
    <?php dynamic_sidebar('bottom-detail-product') ; ?>
  </div>
<?php } ?>
</div>
</div>
<?php get_template_part('footer'); ?>

<!--<img src="--><?php //the_post_thumbnail_url(); ?><!--">-->
<!---->
<?php //while ( have_posts() ) : the_post();
//	get_template_part( 'template/singlep', get_post_type() );
//	/*the_post_navigation();*/
//endwhile; ?>
<?php get_post_gallery_images($post) ;?>