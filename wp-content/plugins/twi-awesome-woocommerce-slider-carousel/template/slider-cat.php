<?php
  // Woocommerce Default
  if($twi_temp_style == 'woo_style'):
?>
<h3><?php echo __('Sorry, this style is not available for category showcase.','twi_awesome_woo_slider_carousel'); ?></h3>
<?php
   endif;
  // Responsive Grids
  if($twi_temp_style == 'normal'):
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
<?php if($car_page == 'true'){ ?>
<style type="text/css">.woo_slider_<?php echo $twi_i; ?> .owl-dot.active span{background: <?php echo $pagi_bg_h;?>!important; border:<?php echo $pagi_bor_wid; ?>px solid <?php echo $pagi_border_h; ?>!important;}</style>
<?php } ?>
<div id = "twi-woo-nor-wrap-<?php echo $twi_i; ?>" class="twi_woo_nor twi-woo-slider woocommerce woo_slider_<?php echo $twi_i; ?> <?php if($twi_full=='yes'){ echo 'twi-forced-fullwidth';}else{ echo 'undefine'; } ?> <?php if($car_nav=='true'){ echo $nav_pos; } ?>" data-id=".woo_slider_<?php echo $twi_i; ?>" data-autoplay="<?php echo $autoplay; ?>" data-gap="<?php echo $items_gap; ?>" data-l-desk="<?php echo $l_desk; ?>" data-desk="<?php echo $desk; ?>" data-tablet="<?php echo $tablet; ?>" data-phone-big="<?php echo $phone_big; ?>" data-phone="<?php echo $phone; ?>" data-nav="<?php echo $car_nav; ?>" data-page="<?php echo $car_page; ?>" data-hover="<?php echo $car_hover; ?>" data-time="<?php echo $auto_time*1000; ?>" data-nav-bg="<?php echo $nav_bg;?>" data-nav-ar="<?php echo $nav_txt; ?>" data-nav-border="<?php echo $nav_bor_wid; ?>px solid <?php echo $nav_border; ?>" data-nav-bg-h="<?php echo $nav_bg_h;?>" data-nav-ar-h="<?php echo $nav_txt_h; ?>" data-nav-border-h="<?php echo $nav_bor_wid; ?>px solid <?php echo $nav_border_h; ?>" data-nav-rad="<?php echo $nav_bor_rad; ?>%" data-pagi-bg="<?php echo $pagi_bg;?>" data-pagi-border="<?php echo $pagi_bor_wid; ?>px solid <?php echo $pagi_border; ?>" data-pagi-bg-h="<?php echo $pagi_bg_h;?>" data-pagi-border-h="<?php echo $pagi_bor_wid; ?>px solid <?php echo $pagi_border_h; ?>" data-pagi-rad="<?php echo $pagi_bor_rad; ?>%" data-font="<?php echo $nor_font; ?>" data-style="<?php echo $nor_style; ?>" data-weight="<?php echo $nor_weight; ?>" data-fo-color="<?php echo $fo_color; ?>" data-nor-bg="<?php echo $nor_bg; ?>" data-fo-size="<?php echo $fo_size; ?>px" data-nor-border="<?php echo $nor_border_width; ?>px solid <?php echo $nor_bor_col; ?>" data-ti-trans="<?php echo $h3_txt_trans; ?>" data-ti-col="<?php echo $h3_col; ?>" data-ti-si="<?php echo $h3_font_size; ?>px" data-ti-col-h="<?php echo $h3_col_hover; ?>" data-cart-bor="<?php echo $cart_bor_wid; ?>px solid <?php echo $cart_bor; ?>" data-cart-bor-h="<?php echo $cart_bor_wid; ?>px solid <?php echo $cart_bor_hover; ?>" data-cart-col="<?php echo $cart_col; ?>" data-cart-col-h="<?php echo $cart_col_hover; ?>" data-cart-trans="<?php echo $cart_txt_trans; ?>" data-cart-bg="<?php echo $cart_bg; ?>" data-cart-bg-h="<?php echo $cart_bg_hover; ?>" data-cart-rad="<?php echo $cart_bor_rad; ?>px" data-cart-si="<?php echo $cart_fo_size; ?>px" data-star-col="<?php echo $star_color; ?>" data-sale-col="<?php echo $sale_txt; ?>" data-sale-bg="<?php echo $sale_bg; ?>" data-out-col="<?php echo $out_txt; ?>" data-out-bg="<?php echo $out_bg; ?>" data-fe-col="<?php echo $fe_txt; ?>" data-fe-bg="<?php echo $fe_bg; ?>" data-main-bor="<?php echo $nor_border; ?>px" data-st-si="<?php echo $st_si; ?>px" data-des-col="<?php echo $nor_des_col; ?>" data-des-font="<?php echo $nor_des_font_size; ?>px" data-des-ln="<?php echo $nor_des_line_height; ?>px">
	<?php
       $it = 1;
       $itemstwi= $row_count;

       foreach ($parent_terms as $pterm) {
	?>
	<?php if( $row_count != 1 ){
           $itemcount=( ((int)$it-1) % (int)$itemstwi) +1;
           if ($itemcount == 1) echo '<div class="item twi-grid">';
        } else {
           echo '<div class="item">';
        } ?>
        <?php if( $row_count != 1 ){ ?>
        <div class="twi-width-1-1" style="margin-bottom: <?php echo $items_gap; ?>px">
        <?php } ?>
	<?php
	         require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/main/normal-cat.php');
	?>
	<?php if( $row_count != 1 ){ ?>
        </div>
        <?php } ?>
        
      <?php if( $row_count != 1 ){
           if ($itemcount == $itemstwi) echo '</div>';
        } else {
           echo '</div>';
        } 

        $it++; 

        ?>
	<?php
	    }
    ?>
</div>
</div>
<?php endif; ?>

<?php 
   // Only Image
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
<?php if($car_page == 'true'){ ?>
<style type="text/css">.woo_slider_<?php echo $twi_i; ?> .owl-dot.active span{background: <?php echo $pagi_bg_h;?>!important; border:<?php echo $pagi_bor_wid; ?>px solid <?php echo $pagi_border_h; ?>!important;}</style>
<?php } ?>
<div id = "twi-woo-img-wrap-<?php echo $twi_i; ?>" class="twi-woo-slider twi_img_only woocommerce woo_slider_<?php echo $twi_i; ?> <?php if($twi_full=='yes'){ echo 'twi-forced-fullwidth';}else{ echo 'undefine'; } ?> <?php if($car_nav=='true'){ echo $nav_pos; } ?>" data-id=".woo_slider_<?php echo $twi_i; ?>" data-autoplay="<?php echo $autoplay; ?>" data-gap="<?php echo $items_gap; ?>" data-l-desk="<?php echo $l_desk; ?>" data-desk="<?php echo $desk; ?>" data-tablet="<?php echo $tablet; ?>" data-phone-big="<?php echo $phone_big; ?>" data-phone="<?php echo $phone; ?>" data-nav="<?php echo $car_nav; ?>" data-page="<?php echo $car_page; ?>" data-hover="<?php echo $car_hover; ?>" data-time="<?php echo $auto_time*1000; ?>" data-nav-bg="<?php echo $nav_bg;?>" data-nav-ar="<?php echo $nav_txt; ?>" data-nav-border="<?php echo $nav_bor_wid; ?>px solid <?php echo $nav_border; ?>" data-nav-bg-h="<?php echo $nav_bg_h;?>" data-nav-ar-h="<?php echo $nav_txt_h; ?>" data-nav-border-h="<?php echo $nav_bor_wid; ?>px solid <?php echo $nav_border_h; ?>" data-nav-rad="<?php echo $nav_bor_rad; ?>%" data-pagi-bg="<?php echo $pagi_bg;?>" data-pagi-border="<?php echo $pagi_bor_wid; ?>px solid <?php echo $pagi_border; ?>" data-pagi-bg-h="<?php echo $pagi_bg_h;?>" data-pagi-border-h="<?php echo $pagi_bor_wid; ?>px solid <?php echo $pagi_border_h; ?>" data-pagi-rad="<?php echo $pagi_bor_rad; ?>%" data-font="<?php echo $nor_font; ?>" data-style="<?php echo $nor_style; ?>" data-weight="<?php echo $nor_weight; ?>" data-sale-col="<?php echo $sale_txt; ?>" data-sale-bg="<?php echo $sale_bg; ?>" data-out-col="<?php echo $out_txt; ?>" data-out-bg="<?php echo $out_bg; ?>" data-fe-col="<?php echo $fe_txt; ?>" data-fe-bg="<?php echo $fe_bg; ?>" data-main-bor="<?php echo $nor_border; ?>px" data-nor-border="<?php echo $nor_border_width; ?>px solid <?php echo $nor_bor_col; ?>">
	<?php
       $it = 1;
       $itemstwi= $row_count;

       foreach ($parent_terms as $pterm) {
	?>
	<?php if( $row_count != 1 ){
           $itemcount=( ((int)$it-1) % (int)$itemstwi) +1;
           if ($itemcount == 1) echo '<div class="item twi-grid">';
        } else {
           echo '<div class="item">';
        } ?>
        <?php if( $row_count != 1 ){ ?>
        <div class="twi-width-1-1" style="margin-bottom: <?php echo $items_gap; ?>px">
        <?php } ?>
       <?php
         require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/main/image_only_cat.php');
       ?>
	<?php if( $row_count != 1 ){ ?>
        </div>
        <?php } ?>
        
      <?php if( $row_count != 1 ){
           if ($itemcount == $itemstwi) echo '</div>';
        } else {
           echo '</div>';
        } 

        $it++; 

        ?>
	<?php 
		}
	?>
</div>
</div>
<?php endif; ?>

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
<?php if($car_page == 'true'){ ?>
<style type="text/css">.woo_slider_<?php echo $twi_i; ?> .owl-dot.active span{background: <?php echo $pagi_bg_h;?>!important; border:<?php echo $pagi_bor_wid; ?>px solid <?php echo $pagi_border_h; ?>!important;}</style>
<?php } ?>
<div id = "twi-woo-hover-wrap-<?php echo $twi_i; ?>" class="twi_ho_eff twi-woo-slider woocommerce woo_slider_<?php echo $twi_i; ?> <?php if($twi_full=='yes'){ echo 'twi-forced-fullwidth';}else{ echo 'undefine'; } ?> <?php if($car_nav=='true'){ echo $nav_pos; } ?>" data-id=".woo_slider_<?php echo $twi_i; ?>" data-autoplay="<?php echo $autoplay; ?>" data-gap="<?php echo $items_gap; ?>" data-l-desk="<?php echo $l_desk; ?>" data-desk="<?php echo $desk; ?>" data-tablet="<?php echo $tablet; ?>" data-phone-big="<?php echo $phone_big; ?>" data-phone="<?php echo $phone; ?>" data-nav="<?php echo $car_nav; ?>" data-page="<?php echo $car_page; ?>" data-hover="<?php echo $car_hover; ?>" data-time="<?php echo $auto_time*1000; ?>" data-nav-bg="<?php echo $nav_bg;?>" data-nav-ar="<?php echo $nav_txt; ?>" data-nav-border="<?php echo $nav_bor_wid; ?>px solid <?php echo $nav_border; ?>" data-nav-bg-h="<?php echo $nav_bg_h;?>" data-nav-ar-h="<?php echo $nav_txt_h; ?>" data-nav-border-h="<?php echo $nav_bor_wid; ?>px solid <?php echo $nav_border_h; ?>" data-nav-rad="<?php echo $nav_bor_rad; ?>%" data-pagi-bg="<?php echo $pagi_bg;?>" data-pagi-border="<?php echo $pagi_bor_wid; ?>px solid <?php echo $pagi_border; ?>" data-pagi-bg-h="<?php echo $pagi_bg_h;?>" data-pagi-border-h="<?php echo $pagi_bor_wid; ?>px solid <?php echo $pagi_border_h; ?>" data-pagi-rad="<?php echo $pagi_bor_rad; ?>%" data-font="<?php echo $ho_font; ?>" data-style="<?php echo $ho_style; ?>" data-weight="<?php echo $ho_weight; ?>" data-cap-bg="<?php echo $ho_cap_bg; ?>" data-img-eff="<?php echo $ho_img_eff; ?>" data-bor="<?php echo $nor_border_width_ho; ?>px solid <?php echo $nor_bor_col_ho; ?>" data-bor-rad="<?php echo $nor_border_ho; ?>%" data-ti-te="<?php echo $h3_txt_trans_ho; ?>" data-col="<?php echo $h3_col; ?>" data-col-ho="<?php echo $h3_col_ho; ?>" data-font-si="<?php echo $h3_font_size_ho; ?>px" data-pr-fo="<?php echo $fo_size; ?>px" data-pr-col="<?php echo $fo_col; ?>" data-rt-fo="<?php echo $rt_size; ?>px" data-rt-col="<?php echo $rt_col; ?>" data-ca-bo="<?php echo $cart_bor_wid_ho; ?>px solid <?php echo $cart_bor; ?>" data-ca-bo-ho="<?php echo $cart_bor_wid_ho; ?>px solid <?php echo $cart_bor_hover; ?>" data-ca-col="<?php echo $cart_col; ?>" data-ca-col-ho="<?php echo $cart_col_hover; ?>" data-ca-te="<?php echo $cart_txt_trans_ho; ?>" data-ca-bg="<?php echo $cart_bg; ?>" data-ca-bg-ho="<?php echo $cart_bg_hover; ?>" data-ca-fo="<?php echo $cart_fo_size_ho; ?>px" data-ca-rad="<?php echo $cart_bor_rad_ho; ?>px" data-sale-col="<?php echo $sale_txt_ho; ?>" data-sale-bg="<?php echo $sale_bg_ho; ?>" data-out-col="<?php echo $out_txt_ho; ?>" data-out-bg="<?php echo $out_bg_ho; ?>" data-fe-col="<?php echo $fe_txt_ho; ?>" data-fe-bg="<?php echo $fe_bg_ho; ?>" data-des-col="<?php echo $ho_des_col; ?>" data-des-font="<?php echo $ho_des_font_size; ?>px" data-des-ln="<?php echo $ho_des_line_height; ?>px">
	<?php
       $it = 1;
       $itemstwi= $row_count;

       foreach ($parent_terms as $pterm) {
	?>
	<?php if( $row_count != 1 ){
           $itemcount=( ((int)$it-1) % (int)$itemstwi) +1;
           if ($itemcount == 1) echo '<div class="item twi-grid">';
        } else {
           echo '<div class="item">';
        } ?>
        <?php if( $row_count != 1 ){ ?>
        <div class="twi-width-1-1" style="margin-bottom: <?php echo $items_gap; ?>px">
        <?php } ?>
       <?php
         require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/main/hover-cat.php');
       ?>
	<?php if( $row_count != 1 ){ ?>
        </div>
        <?php } ?>
        
      <?php if( $row_count != 1 ){
           if ($itemcount == $itemstwi) echo '</div>';
        } else {
           echo '</div>';
        } 

        $it++; 

        ?>
	<?php 
		}
	?>
</div>
</div>
<?php endif; ?>

<?php 
   // Hover Set 2 Effects
   if($twi_temp_style == 'hover2'):
?>
<?php
   $gwf   = new VP_Site_GoogleWebFont();
   $gwf->add($ho2_font, $ho2_style, $ho2_weight);
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
<?php if($car_page == 'true'){ ?>
<style type="text/css">.woo_slider_<?php echo $twi_i; ?> .owl-dot.active span{background: <?php echo $pagi_bg_h;?>!important; border:<?php echo $pagi_bor_wid; ?>px solid <?php echo $pagi_border_h; ?>!important;}</style>
<?php } ?>
<div id = "twi-woo-hover2-wrap-<?php echo $twi_i; ?>" class="twi_ho2_eff twi-woo-slider woocommerce woo_slider_<?php echo $twi_i; ?> <?php if($twi_full=='yes'){ echo 'twi-forced-fullwidth';}else{ echo 'undefine'; } ?> <?php if($car_nav=='true'){ echo $nav_pos; } ?>" data-id=".woo_slider_<?php echo $twi_i; ?>" data-autoplay="<?php echo $autoplay; ?>" data-gap="<?php echo $items_gap; ?>" data-l-desk="<?php echo $l_desk; ?>" data-desk="<?php echo $desk; ?>" data-tablet="<?php echo $tablet; ?>" data-phone-big="<?php echo $phone_big; ?>" data-phone="<?php echo $phone; ?>" data-nav="<?php echo $car_nav; ?>" data-page="<?php echo $car_page; ?>" data-hover="<?php echo $car_hover; ?>" data-time="<?php echo $auto_time*1000; ?>" data-nav-bg="<?php echo $nav_bg;?>" data-nav-ar="<?php echo $nav_txt; ?>" data-nav-border="<?php echo $nav_bor_wid; ?>px solid <?php echo $nav_border; ?>" data-nav-bg-h="<?php echo $nav_bg_h;?>" data-nav-ar-h="<?php echo $nav_txt_h; ?>" data-nav-border-h="<?php echo $nav_bor_wid; ?>px solid <?php echo $nav_border_h; ?>" data-nav-rad="<?php echo $nav_bor_rad; ?>%" data-pagi-bg="<?php echo $pagi_bg;?>" data-pagi-border="<?php echo $pagi_bor_wid; ?>px solid <?php echo $pagi_border; ?>" data-pagi-bg-h="<?php echo $pagi_bg_h;?>" data-pagi-border-h="<?php echo $pagi_bor_wid; ?>px solid <?php echo $pagi_border_h; ?>" data-pagi-rad="<?php echo $pagi_bor_rad; ?>%" data-font="<?php echo $ho2_font; ?>" data-style="<?php echo $ho2_style; ?>" data-weight="<?php echo $ho2_weight; ?>" data-cap-bg="<?php echo $ho2_ho_cap_bg; ?>" data-bor="<?php echo $ho2_nor_border_width_ho; ?>px solid <?php echo $ho2_nor_bor_col_ho; ?>" data-bor-rad="<?php echo $ho2_nor_border_ho; ?>%" data-ti-te="<?php echo $ho2_h3_txt_trans_ho; ?>" data-col="<?php echo $ho2_h3_col; ?>" data-col-ho="<?php echo $ho2_h3_col_ho; ?>" data-font-si="<?php echo $ho2_h3_font_size_ho; ?>px" data-pr-fo="<?php echo $ho2_fo_size; ?>px" data-pr-col="<?php echo $ho2_fo_col; ?>" data-rt-fo="<?php echo $ho2_rt_size; ?>px" data-rt-col="<?php echo $ho2_rt_col; ?>" data-ca-bo="<?php echo $ho2_cart_bor_wid_ho; ?>px solid <?php echo $ho2_cart_bor; ?>" data-ca-bo-ho="<?php echo $ho2_cart_bor_wid_ho; ?>px solid <?php echo $ho2_cart_bor_hover; ?>" data-ca-col="<?php echo $ho2_cart_col; ?>" data-ca-col-ho="<?php echo $ho2_cart_col_hover; ?>" data-ca-te="<?php echo $ho2_cart_txt_trans_ho; ?>" data-ca-bg="<?php echo $ho2_cart_bg; ?>" data-ca-bg-ho="<?php echo $ho2_cart_bg_hover; ?>" data-ca-fo="<?php echo $ho2_cart_fo_size_ho; ?>px" data-ca-rad="<?php echo $ho2_cart_bor_rad_ho; ?>px" data-sale-col="<?php echo $ho2_sale_txt_ho; ?>" data-sale-bg="<?php echo $ho2_sale_bg_ho; ?>" data-out-col="<?php echo $ho2_out_txt_ho; ?>" data-out-bg="<?php echo $ho2_out_bg_ho; ?>" data-fe-col="<?php echo $ho2_fe_txt_ho; ?>" data-fe-bg="<?php echo $ho2_fe_bg_ho; ?>" data-des-col="<?php echo $ho2_ho_des_col; ?>" data-des-font="<?php echo $ho2_ho_des_font_size; ?>px" data-des-ln="<?php echo $ho2_ho_des_line_height; ?>px">
  <?php
       $it = 1;
       $itemstwi= $row_count;

       foreach ($parent_terms as $pterm) {
  ?>
  <?php if( $row_count != 1 ){
           $itemcount=( ((int)$it-1) % (int)$itemstwi) +1;
           if ($itemcount == 1) echo '<div class="item twi-grid">';
        } else {
           echo '<div class="item">';
        } ?>
        <?php if( $row_count != 1 ){ ?>
        <div class="twi-width-1-1" style="margin-bottom: <?php echo $items_gap; ?>px">
        <?php } ?>
       <?php
         require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/main/hover2-cat.php');
       ?>
  <?php if( $row_count != 1 ){ ?>
        </div>
        <?php } ?>
        
      <?php if( $row_count != 1 ){
           if ($itemcount == $itemstwi) echo '</div>';
        } else {
           echo '</div>';
        } 

        $it++; 

        ?>
  <?php 
    }
  ?>
</div>
</div>
<?php endif; ?>

<?php 
   // Overlay Effects
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
<?php if($car_page == 'true'){ ?>
<style type="text/css">.woo_slider_<?php echo $twi_i; ?> .owl-dot.active span{background: <?php echo $pagi_bg_h;?>!important; border:<?php echo $pagi_bor_wid; ?>px solid <?php echo $pagi_border_h; ?>!important;}</style>
<?php } ?>
<div id = "twi-woo-over-wrap-<?php echo $twi_i; ?>" class="twi_woo_over twi-woo-slider woocommerce woo_slider_<?php echo $twi_i; ?> <?php if($twi_full=='yes'){ echo 'twi-forced-fullwidth';}else{ echo 'undefine'; } ?> <?php if($car_nav=='true'){ echo $nav_pos; } ?>" data-id=".woo_slider_<?php echo $twi_i; ?>" data-autoplay="<?php echo $autoplay; ?>" data-gap="<?php echo $items_gap; ?>" data-l-desk="<?php echo $l_desk; ?>" data-desk="<?php echo $desk; ?>" data-tablet="<?php echo $tablet; ?>" data-phone-big="<?php echo $phone_big; ?>" data-phone="<?php echo $phone; ?>" data-nav="<?php echo $car_nav; ?>" data-page="<?php echo $car_page; ?>" data-hover="<?php echo $car_hover; ?>" data-time="<?php echo $auto_time*1000; ?>" data-nav-bg="<?php echo $nav_bg;?>" data-nav-ar="<?php echo $nav_txt; ?>" data-nav-border="<?php echo $nav_bor_wid; ?>px solid <?php echo $nav_border; ?>" data-nav-bg-h="<?php echo $nav_bg_h;?>" data-nav-ar-h="<?php echo $nav_txt_h; ?>" data-nav-border-h="<?php echo $nav_bor_wid; ?>px solid <?php echo $nav_border_h; ?>" data-nav-rad="<?php echo $nav_bor_rad; ?>%" data-pagi-bg="<?php echo $pagi_bg;?>" data-pagi-border="<?php echo $pagi_bor_wid; ?>px solid <?php echo $pagi_border; ?>" data-pagi-bg-h="<?php echo $pagi_bg_h;?>" data-pagi-border-h="<?php echo $pagi_bor_wid; ?>px solid <?php echo $pagi_border_h; ?>" data-pagi-rad="<?php echo $pagi_bor_rad; ?>%" data-font="<?php echo $over_font; ?>" data-style="<?php echo $over_style; ?>" data-weight="<?php echo $over_weight; ?>" data-cap-bg="<?php echo $over_cap_bg; ?>" data-bor="<?php echo $nor_border_width_over; ?>px solid <?php echo $nor_bor_col_over; ?>" data-bor-rad="<?php echo $nor_border_over; ?>%" data-ti-te="<?php echo $h3_txt_trans_over; ?>" data-col="<?php echo $h3_col; ?>" data-col-ho="<?php echo $h3_col_over; ?>" data-font-si="<?php echo $h3_font_size_over; ?>px" data-pr-fo="<?php echo $fo_size; ?>px" data-pr-col="<?php echo $fo_col; ?>" data-rt-fo="<?php echo $rt_size; ?>px" data-rt-col="<?php echo $rt_col; ?>" data-ca-bo="<?php echo $cart_bor_wid_over; ?>px solid <?php echo $cart_bor; ?>" data-ca-bo-ho="<?php echo $cart_bor_wid_over; ?>px solid <?php echo $cart_bor_over; ?>" data-ca-col="<?php echo $cart_col; ?>" data-ca-col-ho="<?php echo $cart_col_over; ?>" data-ca-te="<?php echo $cart_txt_trans_over; ?>" data-ca-bg="<?php echo $cart_bg; ?>" data-ca-bg-ho="<?php echo $cart_bg_over; ?>" data-ca-fo="<?php echo $cart_fo_size_over; ?>px" data-ca-rad="<?php echo $cart_bor_rad_over; ?>px" data-sale-col="<?php echo $sale_txt_over; ?>" data-sale-bg="<?php echo $sale_bg_over; ?>" data-out-col="<?php echo $out_txt_over; ?>" data-out-bg="<?php echo $out_bg_over; ?>" data-fe-col="<?php echo $fe_txt_over; ?>" data-fe-bg="<?php echo $fe_bg_over; ?>" data-des-col="<?php echo $over_des_col; ?>" data-des-font="<?php echo $over_des_font_size; ?>px" data-des-ln="<?php echo $over_des_line_height; ?>px">
	<?php
       $it = 1;
       $itemstwi= $row_count;

       foreach ($parent_terms as $pterm) {
	?>
	<?php if( $row_count != 1 ){
           $itemcount=( ((int)$it-1) % (int)$itemstwi) +1;
           if ($itemcount == 1) echo '<div class="item twi-grid">';
        } else {
           echo '<div class="item">';
        } ?>
        <?php if( $row_count != 1 ){ ?>
        <div class="twi-width-1-1" style="margin-bottom: <?php echo $items_gap; ?>px">
        <?php } ?>
       <?php
         require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/main/overlay-cat.php');
       ?>
	<?php if( $row_count != 1 ){ ?>
        </div>
        <?php } ?>
        
      <?php if( $row_count != 1 ){
           if ($itemcount == $itemstwi) echo '</div>';
        } else {
           echo '</div>';
        } 

        $it++; 

        ?>
	<?php 
		}
	?>
</div>
</div>
<?php endif; ?>