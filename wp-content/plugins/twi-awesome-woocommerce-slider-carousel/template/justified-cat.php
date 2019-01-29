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

  $taxonomyName = "product_cat";
    if($cat_type == 'cat_type'){ 
            $parent_terms = get_terms($taxonomyName, array('parent' => 0, 'orderby' => 'name', 'hide_empty' => true));
    }else{
            $parent_terms = get_terms($taxonomyName, array('parent' => $sub_cat_dis, 'orderby' => 'name', 'hide_empty' => true));
    }

?>
<link href='<?php echo $link; ?>' rel='stylesheet' type='text/css'>
<div id = "twi-woo-img-wrap-<?php echo $twi_i; ?>" class="twi-justified-wrap twi_img_only twi-justified-grids woocommerce <?php if($twi_full=='yes'){ echo 'twi-forced-fullwidth';}else{ echo 'undefine'; } ?>" data-margins = "<?php echo $just_mar; ?>" data-font="<?php echo $nor_font; ?>" data-style="<?php echo $nor_style; ?>" data-weight="<?php echo $nor_weight; ?>" data-sale-col="<?php echo $sale_txt; ?>" data-sale-bg="<?php echo $sale_bg; ?>" data-out-col="<?php echo $out_txt; ?>" data-out-bg="<?php echo $out_bg; ?>" data-fe-col="<?php echo $fe_txt; ?>" data-fe-bg="<?php echo $fe_bg; ?>" data-main-bor="<?php echo $nor_border; ?>px" data-nor-border="<?php echo $nor_border_width; ?>px solid <?php echo $nor_bor_col; ?>"<?php if(($car_pagi == 'yes' && $pagi_type == 'more') || ($car_pagi == 'yes' && $pagi_type == 'infinite')){ ?> data-method="<?php echo $pagi_type; ?>" data-pagi-type="<?php echo $pagi_type; ?>" data-load-txt="<?php echo $load_txt; ?>" data-load-img="<?php echo $up_loader; ?>" data-done-txt="<?php echo $done_txt; ?>"<?php } ?>>
  <?php
       foreach ($parent_terms as $pterm) {
  ?>
  <div class="justified-item">
       <?php
         require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/main/image_only_cat.php');
       ?>
  </div>
  <?php 
    }
  ?>
</div>
<?php 
if($car_pagi == 'yes'){
   
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

   $taxonomyName = "product_cat";
    if($cat_type == 'cat_type'){ 
            $parent_terms = get_terms($taxonomyName, array('parent' => 0, 'orderby' => 'name', 'hide_empty' => true));
    }else{
            $parent_terms = get_terms($taxonomyName, array('parent' => $sub_cat_dis, 'orderby' => 'name', 'hide_empty' => true));
    }
?>
<link href='<?php echo $link; ?>' rel='stylesheet' type='text/css'>
<div id = "twi-woo-hover-wrap-<?php echo $twi_i; ?>" class="woo-twi-justified twi_ho_eff <?php if($twi_full=='yes'){ echo 'twi-forced-fullwidth';}else{ echo 'undefine'; } ?>" data-font="<?php echo $ho_font; ?>" data-style="<?php echo $ho_style; ?>" data-weight="<?php echo $ho_weight; ?>" data-cap-bg="<?php echo $ho_cap_bg; ?>" data-img-eff="<?php echo $ho_img_eff; ?>" data-bor="<?php echo $nor_border_width_ho; ?>px solid <?php echo $nor_bor_col_ho; ?>" data-bor-rad="<?php echo $nor_border_ho; ?>%" data-ti-te="<?php echo $h3_txt_trans_ho; ?>" data-col="<?php echo $h3_col; ?>" data-col-ho="<?php echo $h3_col_ho; ?>" data-font-si="<?php echo $h3_font_size_ho; ?>px" data-pr-fo="<?php echo $fo_size; ?>px" data-pr-col="<?php echo $fo_col; ?>" data-rt-fo="<?php echo $rt_size; ?>px" data-rt-col="<?php echo $rt_col; ?>" data-ca-bo="<?php echo $cart_bor_wid_ho; ?>px solid <?php echo $cart_bor; ?>" data-ca-bo-ho="<?php echo $cart_bor_wid_ho; ?>px solid <?php echo $cart_bor_hover; ?>" data-ca-col="<?php echo $cart_col; ?>" data-ca-col-ho="<?php echo $cart_col_hover; ?>" data-ca-te="<?php echo $cart_txt_trans_ho; ?>" data-ca-bg="<?php echo $cart_bg; ?>" data-ca-bg-ho="<?php echo $cart_bg_hover; ?>" data-ca-fo="<?php echo $cart_fo_size_ho; ?>px" data-ca-rad="<?php echo $cart_bor_rad_ho; ?>px" data-sale-col="<?php echo $sale_txt_ho; ?>" data-sale-bg="<?php echo $sale_bg_ho; ?>" data-out-col="<?php echo $out_txt_ho; ?>" data-out-bg="<?php echo $out_bg_ho; ?>" data-fe-col="<?php echo $fe_txt_ho; ?>" data-fe-bg="<?php echo $fe_bg_ho; ?>" data-des-col="<?php echo $ho_des_col; ?>" data-des-font="<?php echo $ho_des_font_size; ?>px" data-des-ln="<?php echo $ho_des_line_height; ?>px"<?php if(($car_pagi == 'yes' && $pagi_type == 'more') || ($car_pagi == 'yes' && $pagi_type == 'infinite')){ ?> data-method="<?php echo $pagi_type; ?>" data-pagi-type="<?php echo $pagi_type; ?>" data-load-txt="<?php echo $load_txt; ?>" data-load-img="<?php echo $up_loader; ?>" data-done-txt="<?php echo $done_txt; ?>"<?php } ?>>
<div class="twi-justified-wrap twi-justified-grids woocommerce" data-margins = "<?php echo $just_mar; ?>">
  <?php
       foreach ($parent_terms as $pterm) {
  ?>
  <div class="justified-item">
       <?php
         require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/main/hover-cat.php');
       ?>
  </div>
  <?php 
    }
  ?>
</div>
</div>
<?php 
if($car_pagi == 'yes'){
   
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

  $taxonomyName = "product_cat";
    if($cat_type == 'cat_type'){ 
            $parent_terms = get_terms($taxonomyName, array('parent' => 0, 'orderby' => 'name', 'hide_empty' => true));
    }else{
            $parent_terms = get_terms($taxonomyName, array('parent' => $sub_cat_dis, 'orderby' => 'name', 'hide_empty' => true));
    }
?>
<link href='<?php echo $link; ?>' rel='stylesheet' type='text/css'>
<div id = "twi-woo-over-wrap-<?php echo $twi_i; ?>" class="woo-twi-justified twi_woo_over <?php if($twi_full=='yes'){ echo 'twi-forced-fullwidth';}else{ echo 'undefine'; } ?>" data-font="<?php echo $over_font; ?>" data-style="<?php echo $over_style; ?>" data-weight="<?php echo $over_weight; ?>" data-cap-bg="<?php echo $over_cap_bg; ?>" data-bor="<?php echo $nor_border_width_over; ?>px solid <?php echo $nor_bor_col_over; ?>" data-bor-rad="<?php echo $nor_border_over; ?>%" data-ti-te="<?php echo $h3_txt_trans_over; ?>" data-col="<?php echo $h3_col; ?>" data-col-ho="<?php echo $h3_col_over; ?>" data-font-si="<?php echo $h3_font_size_over; ?>px" data-pr-fo="<?php echo $fo_size; ?>px" data-pr-col="<?php echo $fo_col; ?>" data-rt-fo="<?php echo $rt_size; ?>px" data-rt-col="<?php echo $rt_col; ?>" data-ca-bo="<?php echo $cart_bor_wid_over; ?>px solid <?php echo $cart_bor; ?>" data-ca-bo-ho="<?php echo $cart_bor_wid_over; ?>px solid <?php echo $cart_bor_over; ?>" data-ca-col="<?php echo $cart_col; ?>" data-ca-col-ho="<?php echo $cart_col_over; ?>" data-ca-te="<?php echo $cart_txt_trans_over; ?>" data-ca-bg="<?php echo $cart_bg; ?>" data-ca-bg-ho="<?php echo $cart_bg_over; ?>" data-ca-fo="<?php echo $cart_fo_size_over; ?>px" data-ca-rad="<?php echo $cart_bor_rad_over; ?>px" data-sale-col="<?php echo $sale_txt_over; ?>" data-sale-bg="<?php echo $sale_bg_over; ?>" data-out-col="<?php echo $out_txt_over; ?>" data-out-bg="<?php echo $out_bg_over; ?>" data-fe-col="<?php echo $fe_txt_over; ?>" data-fe-bg="<?php echo $fe_bg_over; ?>" data-des-col="<?php echo $over_des_col; ?>" data-des-font="<?php echo $over_des_font_size; ?>px" data-des-ln="<?php echo $over_des_line_height; ?>px"<?php if(($car_pagi == 'yes' && $pagi_type == 'more') || ($car_pagi == 'yes' && $pagi_type == 'infinite')){ ?> data-method="<?php echo $pagi_type; ?>" data-pagi-type="<?php echo $pagi_type; ?>" data-load-txt="<?php echo $load_txt; ?>" data-load-img="<?php echo $up_loader; ?>" data-done-txt="<?php echo $done_txt; ?>"<?php } ?>>
<div class="twi-justified-wrap twi-justified-grids woocommerce" data-margins = "<?php echo $just_mar; ?>">
  <?php
       foreach ($parent_terms as $pterm) {
  ?>
  <div class="justified-item">
       <?php
         require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/main/overlay-cat.php');
       ?>
  </div>
  <?php 
    }
  ?>
</div>
</div>
<?php 
if($car_pagi == 'yes'){
   
}
endif; 
wp_reset_postdata();
?>
