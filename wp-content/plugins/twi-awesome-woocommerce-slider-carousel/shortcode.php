<?php
function twi_woo_g_c_s_function($twi_woo_short,$content = null ){
	ob_start("twi_woo_removeWhitespace");
	extract( shortcode_atts( array(
		'p_id' => ''
	 ), $twi_woo_short) );

	 $args = array(
			'p' => $p_id, 
			'post_type' => 'twi_woo_g_car'
	 );
	 if($p_id != NULL ){
	 	
	 $the_query = new WP_Query($args);
	 // The Loop
	 if ($the_query->have_posts()) {
	 	while ( $the_query->have_posts() ) {
				$the_query->the_post();

	$i = mt_rand(1,10000);
	$uid = "woo_uid_".$i;
	$twi_i = mt_rand(1, 10000000);
	

	require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/variables/variables.php');

if( $pagi_type == 'more' ){
    $gwf   = new VP_Site_GoogleWebFont();
	$gwf->add($font_cl, $style_cl, $weight_cl);
    $links_cl = $gwf->get_font_links();
    $link_cl  = reset($links_cl);

	?>
	<link href='<?php echo $link_cl; ?>' rel='stylesheet' type='text/css'>
<?php } ?>
    <div id="twi-woo-main-wrapper-<?php echo $twi_i; ?>" class="twi-woo-main-wrapper<?php if( $pagi_type == 'more' ){ ?> twi-woo-click-more<?php } ?>"<?php if( $pagi_type == 'more' ){ ?> data-font = "<?php echo $font_cl; ?>" data-style = "<?php echo $style_cl; ?>" data-weight = "<?php echo $weight_cl; ?>" data-cl-bg = "<?php echo $cl_bg; ?>" data-cl-bg-ho = "<?php echo $cl_bg_ho; ?>" data-bor = "<?php echo $cl_bor_wid; ?>px solid <?php echo $cl_bor_col; ?>" data-bor-ho = "<?php echo $cl_bor_wid; ?>px solid <?php echo $cl_bor_col_ho; ?>" data-bor-rad = "<?php echo $cl_bor_rad; ?>px" data-font-color = "<?php echo $cl_fo_col; ?>" data-font-color-hover = "<?php echo $cl_fo_col_ho; ?>"<?php } ?>>
	<?php
    
    if($twi_woo_preloader == "yes" || $twi_woo_preloader == NULL){
	?>
    <div id="twi-woo-preloader-<?php echo $twi_i; ?>" class="twi-woo-preloader <?php if($twi_full=='yes'){ echo 'twi-forced-fullwidth';}else{ echo 'undefine'; } ?>">
	<?php
    }
 	 	if($twi_woo_style == 'twi_woo_grid'){
 	 		if($pro_dis_style == 'cat_showcase'){
                 require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/grid-cat.php');
 	 		}else{
 	 			if($car_pagi == 'yes' && $pagi_type == 'ajax_page'){
 	 				require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/ajax/grid.php');
 	 			}else{
 	 	            require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/grid.php');
 	 	        }
 	 		}
 	 	} //if Grid
 	 	if($twi_woo_style == 'twi_woo_slider' ){
 	 		if($pro_dis_style == 'cat_showcase'){
                require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/slider-cat.php');
 	 		}else{
 	 	        require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/slider.php');
 	 	    }
 	 	} //if Slider
 	 	if($twi_woo_style == 'twi_woo_mansonry' ){
 	 		if($pro_dis_style == 'cat_showcase'){
                require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/pinterest-cat.php');
 	 		}else{
 	 			if($car_pagi == 'yes' && $pagi_type == 'ajax_page'){
 	 				require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/ajax/pinterest.php');
 	 			}else{
 	 	            require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/pinterest.php');
 	 	        }
 	 	    }
 	 	} //if Pinterest
 	 	if($twi_woo_style == 'twi_woo_slideset' ){
 	 		if($pro_dis_style == 'cat_showcase'){
                require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/slideset-cat.php');
 	 		}else{
 	 	        require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/slideset.php');
 	 	    }
 	 	} //if Slide Set
 	 	if($twi_woo_style == 'twi_woo_justified' ){
 	 		if($pro_dis_style == 'cat_showcase'){
                require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/justified-cat.php');
 	 		}else{
 	 	        require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/justified.php');
 	 	    }
 	 	} //if Justified
        
        if($twi_woo_preloader == "yes" || $twi_woo_preloader == NULL){
 	 	?>
 	 	   </div>
 	 <?php
        }
     ?>
     </div>
     <?php
	do_action('twi_woo_g_c_s_function');

	    }
       // Content While Loop
     }
     //if Loop
    }else{
    	echo "<h5 style='color:red;'>You didn't select any any Grid/Slider/Carousel for your woocommerce products. Please create at least one Grid/Slider/Carousel first.</h5>";
    }
    //if NULL value
    wp_reset_query();
	$content = ob_get_clean();
	return $content;

}
add_shortcode('twi_woo_shortcode','twi_woo_g_c_s_function');
/*add_filter( 'widget_text', 'twi_woo_g_c_s_function');*/
?>