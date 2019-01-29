<?php
  // Woocommerce Default
  if($twi_temp_style == 'woo_style'):
?>
<h3><?php echo __('Sorry, this style is not available for this option.','twi_awesome_woo_slider_carousel'); ?></h3>
<?php
   endif;
  // Responsive Grids
  if($twi_temp_style == 'normal'):
?>
<h3><?php echo __('Sorry, this style is not available for this option.','twi_awesome_woo_slider_carousel'); ?></h3>
<?php
endif; 
wp_reset_postdata();
?>

<?php
  // Image Only
  if($twi_temp_style == 'img_only'):
?>
<?php
    $gwf   = new VP_Site_GoogleWebFont();
    $gwf->add($nor_font, $nor_style, $nor_weight);
    $links = $gwf->get_font_links();
	$link  = reset($links);

?>
<link href='<?php echo $link; ?>' rel='stylesheet' type='text/css'>
<div id = "twi-woo-img-wrap-<?php echo $twi_i; ?>" class="twi-justified-wrap twi_img_only twi-justified-grids woocommerce<?php if(($car_pagi == 'yes' && $pagi_type == 'more') || ($car_pagi == 'yes' && $pagi_type == 'infinite')){ ?> twi-load-more<?php } ?> <?php if($twi_full=='yes'){ echo 'twi-forced-fullwidth';}else{ echo 'undefine'; } ?>" data-margins = "<?php echo $just_mar; ?>" data-font="<?php echo $nor_font; ?>" data-style="<?php echo $nor_style; ?>" data-weight="<?php echo $nor_weight; ?>" data-sale-col="<?php echo $sale_txt; ?>" data-sale-bg="<?php echo $sale_bg; ?>" data-out-col="<?php echo $out_txt; ?>" data-out-bg="<?php echo $out_bg; ?>" data-fe-col="<?php echo $fe_txt; ?>" data-fe-bg="<?php echo $fe_bg; ?>" data-main-bor="<?php echo $nor_border; ?>px" data-nor-border="<?php echo $nor_border_width; ?>px solid <?php echo $nor_bor_col; ?>"<?php if(($car_pagi == 'yes' && $pagi_type == 'more') || ($car_pagi == 'yes' && $pagi_type == 'infinite')){ ?> data-method="<?php echo $pagi_type; ?>" data-pagi-type="<?php echo $pagi_type; ?>" data-load-txt="<?php echo $load_txt; ?>" data-load-img="<?php echo $up_loader; ?>" data-done-txt="<?php echo $done_txt; ?>"<?php } ?>>
	<?php
    require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/query/query.php');

	$loop = new WP_Query( $query_args );
		if ( $loop->have_posts() ) {
			while ( $loop->have_posts() ) : $loop->the_post();
		global $product;
	?>
	<div<?php if($pagi_type == 'more' || $pagi_type == 'infinite'){ ?> class="product"<?php } ?>>
       <?php
         require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/main/image_only_just.php');
       ?>
	</div>
	<?php 
      endwhile;
		} else {
			echo __( 'No products found' );
		}
	?>
</div>
<?php 
if($car_pagi == 'yes'){
	require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/query/pagination.php'); 
}
endif; 
wp_reset_postdata();
?>

<?php
  // Hover Effects
  if($twi_temp_style == 'hover'):
?>
<?php
   $gwf   = new VP_Site_GoogleWebFont();
   $gwf->add($ho_font, $ho_style, $ho_weight);
   $links = $gwf->get_font_links();
   $link  = reset($links);
?>
<link href='<?php echo $link; ?>' rel='stylesheet' type='text/css'>
<div class="woo-twi-justified <?php if($twi_full=='yes'){ echo 'twi-forced-fullwidth';}else{ echo 'undefine'; } ?>">
<div class="twi-justified-wrap twi-justified-grids woocommerce" data-margins = "<?php echo $just_mar; ?>">
	<?php
    require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/query/query.php');

	$loop = new WP_Query( $query_args );
		if ( $loop->have_posts() ) {
			while ( $loop->have_posts() ) : $loop->the_post();
		global $product;
	?>
	<div class="justified-item">
       <?php
         require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/main/hover-just.php');
       ?>
	</div>
	<?php 
      endwhile;
		} else {
			echo __( 'No products found' );
		}
	?>
</div>
</div>
<?php 
if($car_pagi == 'yes'){
	require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/query/pagination.php'); 
}
endif; 
wp_reset_postdata();
?>

<?php
  // Hover Effects
  if($twi_temp_style == 'overlay'):
?>
<?php
    $gwf   = new VP_Site_GoogleWebFont();
	$gwf->add($over_font, $over_style, $over_weight);
	$links = $gwf->get_font_links();
	$link  = reset($links);
?>
<link href='<?php echo $link; ?>' rel='stylesheet' type='text/css'>
<div class="woo-twi-justified <?php if($twi_full=='yes'){ echo 'twi-forced-fullwidth';}else{ echo 'undefine'; } ?>">
<div class="twi-justified-wrap twi-justified-grids woocommerce" data-margins = "<?php echo $just_mar; ?>">
	<?php
    require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/query/query.php');

	$loop = new WP_Query( $query_args );
		if ( $loop->have_posts() ) {
			while ( $loop->have_posts() ) : $loop->the_post();
		global $product;
	?>
	<div class="justified-item">
       <?php
         require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/main/overlay.php');
       ?>
	</div>
	<?php 
      endwhile;
		} else {
			echo __( 'No products found' );
		}
	?>
</div>
</div>
<?php 
if($car_pagi == 'yes'){
	require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/query/pagination.php'); 
}
endif; 
wp_reset_postdata();
?>
