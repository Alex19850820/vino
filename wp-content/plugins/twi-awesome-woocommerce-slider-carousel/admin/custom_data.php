<?php
VP_Security::instance()->whitelist_function('twi_woo_st_dep_grid');

function twi_woo_st_dep_grid($value)
{
	if($value === 'twi_woo_grid' || $value === 'twi_woo_mansonry')
		return true;
	return false;
}
VP_Security::instance()->whitelist_function('twi_woo_gap');
function twi_woo_gap($value)
{
	if( $value === 'twi_woo_grid' || $value === 'twi_woo_slideset' )
		return true;
	return false;
}
VP_Security::instance()->whitelist_function('twi_woo_car_gap');
function twi_woo_car_gap($value)
{
	if($value === 'twi_woo_slider')
		return true;
	return false;
}
VP_Security::instance()->whitelist_function('twi_woo_gutter');
function twi_woo_gutter($value)
{
	if($value === 'twi_woo_mansonry')
		return true;
	return false;
}
VP_Security::instance()->whitelist_function('twi_slider_dep');

function twi_slider_dep($value)
{
	if($value === 'twi_woo_slider')
		return true;
	return false;
}
VP_Security::instance()->whitelist_function('twi_car_nav_set');

function twi_car_nav_set($value)
{
	if($value === 'true')
		return true;
	return false;
}
VP_Security::instance()->whitelist_function('twi_get_woo_short');
function twi_get_woo_short()
{
	$wp_posts = get_posts(array(
		'post_type' => 'twi_woo_g_car',
		'posts_per_page' => -1,
	));

	$result = array();
	foreach ($wp_posts as $post)
	{
		$result[] = array('value' => $post->ID, 'label' => $post->post_title);
	}
	return $result;
}
function twi_get_categories()
{
	$taxonomy = 'product_cat';
    $terms = get_terms( $taxonomy, '' );

	$res = array();
	foreach ($terms as $term)
	{
		$res[] = array('value' => $term->slug, 'label' => $term->name);
	}
	return $res;
}
VP_Security::instance()->whitelist_function('pagi_show_fun');

function pagi_show_fun($value1,$value2)
{
	if( ($value1 === 'yes' && $value2 === 'nor_page') ||  ($value1 === 'yes' && $value2 === 'ajax_page') )
		return true;
	return false;
}

VP_Security::instance()->whitelist_function('load_more_pagi_fun');

function load_more_pagi_fun($value1,$value2)
{
	if( ($value1 === 'yes' && $value2 === 'infinite') ||  ($value1 === 'yes' && $value2 === 'more') )
		return true;
	return false;
}

VP_Security::instance()->whitelist_function('pagi_type_fun');

function pagi_type_fun($value)
{
	if( $value === 'yes' )
		return true;
	return false;
}
VP_Security::instance()->whitelist_function('twi_page_show_dep');

function twi_page_show_dep($value)
{
	if($value === 'true')
		return true;
	return false;
}
VP_Security::instance()->whitelist_function('woo_grid_pagi_fun');

function woo_grid_pagi_fun($pos,$text1,$bg1,$bor_col1,$bor_width1,$text2,$bg2,$bor_col2,$bor_width2,$bor_rad,$pad){
	ob_start(); ?>
     <style>
		.twi-pagination li a,.twi-pagination li.twi-active span{
			border-radius: <?php echo $bor_rad; ?>%;
			padding: <?php echo $pad; ?>px;
			width: 20px;
            height: 20px;
		}
		.twi-pagination li a{
			border: <?php echo $bor_width1; ?>px solid <?php echo $bor_col1; ?>;
		}
		.twi-pagination li a:hover,.twi-pagination li.twi-active span{
			border: <?php echo $bor_width2; ?>px solid <?php echo $bor_col2; ?>;
		}
		.twi-pagination li a{
			color: <?php echo $text1; ?>;
			background: <?php echo $bg1; ?>;
		}
		.twi-pagination li.twi-active span,.twi-pagination li a:hover{
			background: <?php echo $bg2; ?>;
			color: <?php echo $text2; ?>;
		}
     </style>
     <ul class="twi-pagination twi-pagination-<?php echo $pos; ?>">
	    <li><a href="#" class="prev page-numbers"><i class="twi-icon-chevron-left"></i></a></li>
        <li><a href="#" class="page-numbers">1</a></li>
        <li class="twi-active"><span class="page-numbers current">2</span></li>
        <li><a href="#" class="page-numbers">3</a></li>
        <li><a href="#" class="next page-numbers"><i class="twi-icon-chevron-right"></i></a></li>
    </ul>
	<?php return ob_get_clean();
}

VP_Security::instance()->whitelist_function('woo_car_nav_fun');

function woo_car_nav_fun($nav_bg,$nav_txt,$nav_border,$nav_bor_wid,$nav_bor_rad,$nav_bg_h,$nav_txt_h,$nav_border_h){
	ob_start(); ?>
     <style>
        .owl-prev,.owl-next {
		    background: <?php echo $nav_bg; ?>;
		    border: <?php echo $nav_bor_wid; ?>px solid <?php echo $nav_border; ?>!important;
		    color: <?php echo $nav_txt; ?>;
		    border-radius: <?php echo $nav_bor_rad; ?>%;
		}
		.owl-prev:hover,.owl-next:hover {
		    background: <?php echo $nav_bg_h; ?>;
		    border: <?php echo $nav_bor_wid; ?>px solid <?php echo $nav_border_h; ?>!important;
		    color: <?php echo $nav_txt_h; ?>;
		}
     </style>
     <div class="owl-theme">
	     <div class="owl-controls">
	     	<div class="owl-nav">
	     		<div class="owl-prev" style="">
	     			<i class="twi-icon-chevron-left"></i>
	     		</div>
	     		<div class="owl-next" style="">
	     			<i class="twi-icon-chevron-right"></i>
	     		</div>
	     	</div>
	     </div>
     </div>
	<?php return ob_get_clean();
}

VP_Security::instance()->whitelist_function('woo_car_pagi_fun');

function woo_car_pagi_fun($pagi_bg,$pagi_border,$pagi_bor_wid,$pagi_bor_rad,$pagi_bg_h,$pagi_border_h){
	ob_start(); ?>
     <style>
		.owl-theme .owl-dots .owl-dot span{
		    background: <?php echo $pagi_bg; ?>;
		    border: <?php echo $pagi_bor_wid; ?>px solid <?php echo $pagi_border; ?>;
		    border-radius: <?php echo $pagi_bor_rad; ?>%;
		}
		.owl-theme .owl-dots .owl-dot span:hover,.owl-theme .owl-dots .owl-dot.active span{
			background: <?php echo $pagi_bg_h; ?>;
			border: <?php echo $pagi_bor_wid; ?>px solid <?php echo $pagi_border_h; ?>;
		}
     </style>
     <div class="owl-theme">
	     <div class="owl-controls">
	     	<div class="owl-dots">
	     		<div class="owl-dot">
	     			<span></span>
	     		</div>
	     		<div class="owl-dot active">
	     			<span></span>
	     		</div>
	     		<div class="owl-dot">
	     			<span></span>
	     		</div>
	     	</div>
	     </div>
     </div>
	<?php return ob_get_clean();
}
VP_Security::instance()->whitelist_function('woo_no_pre_fun');

function woo_no_pre_fun($value)
{
	if($value === 'normal')
		return true;
	return false;
}
VP_Security::instance()->whitelist_function('woo_nor_live_preview');

function woo_nor_live_preview($font,$style,$weight,$nor_bg,$nor_border,$nor_bor_col,$nor_border_width,$nor_con_pos,$h3_col,$h3_col_hover,$h3_font_size,$h3_txt_trans,$fo_color,$fo_size,$star_color,$cart_col,$cart_col_hover,$cart_bg,$cart_bg_hover,$cart_bor,$cart_bor_hover,$cart_bor_wid,$cart_txt_trans,$cart_bor_rad,$cart_fo_size,$sale_bg,$sale_txt,$out_bg,$out_txt,$fe_bg,$fe_txt,$st_si,$des_col,$des_font_size,$des_line_height){
	ob_start(); 
    $gwf   = new VP_Site_GoogleWebFont();
	$gwf->add($font, $style, $weight);
	$links = $gwf->get_font_links();
	$link  = reset($links);
	?>
	<link href='<?php echo $link; ?>' rel='stylesheet' type='text/css'>
     <style>
		.nor .twi-panel{
			color: <?php echo $fo_color; ?>!important;
			background: <?php echo $nor_bg; ?>!important; 
			border:<?php echo $nor_border_width; ?>px solid <?php echo $nor_bor_col; ?>!important;
			border-radius: <?php echo $nor_border; ?>px!important;
		}
       .nor .twi_pro_title a,.nor .twi-panel,.nor .twi_cart a,.nor .twi_pro_des p{
			font-family: <?php echo $font; ?>!important;
			font-style: <?php echo $style; ?>!important;
			font-weight: <?php echo $weight; ?>!important;
		}
		.nor .twi_pro_title a{
			text-transform: <?php echo $h3_txt_trans; ?>!important;
			color: <?php echo $h3_col; ?>!important;
			font-size: <?php echo $h3_font_size; ?>px!important;
		}
		.nor .twi_pro_title a:hover{
            color: <?php echo $h3_col_hover; ?>!important;
		}
		.nor .twi_pro_des p{
			color: <?php echo $des_col; ?> !important;
			font-size: <?php echo $des_font_size; ?>px !important;
			line-height: <?php echo $des_line_height; ?>px !important;
			margin-left: 5px;
		}
		.nor .twi-price{
			font-size: <?php echo $fo_size; ?>px!important;
		}
		.nor .twi-rating{
            color: <?php echo $star_color; ?>!important;
            font-size: <?php echo $st_si; ?>px!important;
		}
		.nor .twi_cart a {
		    border: <?php echo $cart_bor_wid; ?>px solid <?php echo $cart_bor; ?>!important;
		    color: <?php echo $cart_col; ?>!important;
		    text-transform: <?php echo $cart_txt_trans; ?>!important;
		    background: <?php echo $cart_bg; ?>!important;
		    border-radius: <?php echo $cart_bor_rad; ?>px!important; 
		    font-size: <?php echo $cart_fo_size; ?>px!important;
		}
		.nor .twi_cart a:hover {
		    border: <?php echo $cart_bor_wid; ?>px solid <?php echo $cart_bor_hover; ?>!important;
		    color: <?php echo $cart_col_hover; ?>!important;
		    background: <?php echo $cart_bg_hover; ?>!important;
		}
		.nor .twi-sale{
		  background-color: <?php echo $sale_bg; ?> !important;
		  border-color: <?php echo $sale_bg; ?> !important;
		  color: <?php echo $sale_txt; ?> !important;
		}
		.nor .twi-out{
		  background-color: <?php echo $out_bg; ?> !important;
		  border-color: <?php echo $out_bg; ?> !important;
		  color: <?php echo $out_txt; ?> !important;
		}
		.nor .twi-fea{
		  background-color: <?php echo $fe_bg; ?> !important;
		  border-color: <?php echo $fe_bg; ?> !important;
		  color: <?php echo $fe_txt; ?> !important;
		}
		.nor .twi-fea,.nor .twi-sale {
		    border-bottom-right-radius: <?php echo $nor_border; ?>px!important;
		    border-top-left-radius: <?php echo $nor_border; ?>px!important;
		}
		.nor .twi-out {
		    border-top-right-radius: <?php echo $nor_border; ?>px!important;
		    border-bottom-left-radius: <?php echo $nor_border; ?>px!important;
		}
		.nor .twi-panel-teaser img{
			border-top-right-radius: <?php echo $nor_border; ?>px!important;
			border-top-left-radius: <?php echo $nor_border; ?>px!important;
		}
     </style>
     <div class="nor">
	     <div class="twi-panel twi-panel-box twi-text-<?php echo $nor_con_pos; ?>">
				<a class="twi-ui top left attached label teal twi-sale">Sale!</a>
				<a class="twi-ui top right attached label red twi-out">Out of stock</a>
				<a class="twi-ui bottom right attached label teal twi-fea">Featured</a>		    
				<div class="twi-panel-teaser twi-rib">
				   <a href="#"><img src="<?php echo TWI_AWESOME_WOO_SLIDER_CAROUSEL_URL; ?>/images/demo.jpg"></a>
			    </div>
			    <div class="twi-details">
				    <h3 class="twi_pro_title">
					    <a href="#">Product 1</a>
				     </h3>
				     <div class="twi_pro_des">
					    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
					 </div>
				     <div class="twi-price">
				     	<del><span class="amount"><?php echo get_woocommerce_currency_symbol(); ?>120.00</span></del> 
				     	<ins><span class="amount"><?php echo get_woocommerce_currency_symbol(); ?>100.00</span></ins>
				     </div>
				     <div class="twi-rating">
				     	<i class="twi-icon-star"></i>
				     	<i class="twi-icon-star"></i>
				     	<i class="twi-icon-star"></i>
				     	<i class="twi-icon-star-half-o"></i>
				     	<i class="twi-icon-star-o"></i>
			        </div>
			        <div class="twi_cart twi-own-<?php echo $nor_con_pos; ?>">
				     	<a href="#">Add to cart</a>
				    </div>
			</div>
		</div>
	</div>
	<?php return ob_get_clean();
}

VP_Security::instance()->whitelist_function('woo_img_pre_fun');

function woo_img_pre_fun($value)
{
	if($value === 'img_only')
		return true;
	return false;
}

VP_Security::instance()->whitelist_function('woo_img_live_preview');

function woo_img_live_preview($font_img,$style_img,$weight_img,$nor_border_img,$nor_bor_col_img,$nor_border_width_img,$sale_bg_img,$sale_txt_img,$out_bg_img,$out_txt_img,$fe_bg_img,$fe_txt_img){
	ob_start(); 
    $gwf   = new VP_Site_GoogleWebFont();
	$gwf->add($font_img, $style_img, $weight_img);
	$links_img = $gwf->get_font_links();
	$link_img  = reset($links_img);
	?>
	<link href='<?php echo $link_img; ?>' rel='stylesheet' type='text/css'>
     <style>
		.twi_ho .twi-panel{
			color: <?php echo $fo_color_img; ?>!important; 
			border:<?php echo $nor_border_width_img; ?>px solid <?php echo $nor_bor_col_img; ?>!important;
			font-family: <?php echo $font_img; ?>!important;
			font-style: <?php echo $style_img; ?>!important;
			font-weight: <?php echo $weight_img; ?>!important;
			border-radius: <?php echo $nor_border_img; ?>px!important;
		}
		.twi_ho .twi-sale{
		  background-color: <?php echo $sale_bg_img; ?> !important;
		  border-color: <?php echo $sale_bg_img; ?> !important;
		  color: <?php echo $sale_txt_img; ?> !important;
		}
		.twi_ho .twi-out{
		  background-color: <?php echo $out_bg_img; ?> !important;
		  border-color: <?php echo $out_bg_img; ?> !important;
		  color: <?php echo $out_txt_img; ?> !important;
		}
		.twi_ho .twi-fea{
		  background-color: <?php echo $fe_bg_img; ?> !important;
		  border-color: <?php echo $fe_bg_img; ?> !important;
		  color: <?php echo $fe_txt_img; ?> !important;
		}
		.twi_ho .twi-fea,.twi_ho .twi-sale {
		    border-bottom-right-radius: <?php echo $nor_border_img; ?>px!important;
		    border-top-left-radius: <?php echo $nor_border_img; ?>px!important;
		}
		.twi_ho .twi-out {
		    border-top-right-radius: <?php echo $nor_border_img; ?>px!important;
		    border-bottom-left-radius: <?php echo $nor_border_img; ?>px!important;
		}
		.twi_ho .twi-panel-teaser img{
			border-top-right-radius: <?php echo $nor_border_img; ?>px!important;
			border-top-left-radius: <?php echo $nor_border_img; ?>px!important;
		}
     </style>
     <div class="twi_ho">
	     <div class="twi-panel twi-panel-box twi_img_only">
				<a class="twi-ui top left attached label teal twi-sale">Sale!</a>
				<a class="twi-ui top right attached label red twi-out">Out of stock</a>
				<a class="twi-ui bottom right attached label teal twi-fea">Featured</a>		    
				<div class="twi-panel-teaser twi-rib">
				   <a href="#"><img src="<?php echo TWI_AWESOME_WOO_SLIDER_CAROUSEL_URL; ?>images/demo.jpg"></a>
			    </div>
		</div>
	</div>
	<?php return ob_get_clean();
}
VP_Security::instance()->whitelist_function('woo_hover_pre_fun');

function woo_hover_pre_fun($value)
{
	if($value === 'hover')
		return true;
	return false;
}
VP_Security::instance()->whitelist_function('woo_hover_live_preview');

function woo_hover_live_preview($font_ho,$style_ho,$weight_ho,$nor_bg_ho,$nor_border_ho,$nor_bor_col_ho,$nor_border_width_ho,$h3_col_ho,$h3_col_hover_ho,$h3_font_size_ho,$h3_txt_trans_ho,$fo_color_ho,$fo_size,$star_color,$cart_col,$cart_col_hover,$cart_bg,$cart_bg_hover,$cart_bor,$cart_bor_hover,$cart_bor_wid_ho,$cart_txt_trans_ho,$cart_bor_rad_ho,$cart_fo_size_ho,$sale_bg_ho,$sale_txt_ho,$out_bg_ho,$out_txt_ho,$fe_bg_ho,$fe_txt_ho,$st_si_ho,$over_eff_ho,$img_eff_ho,$title_an,$price_an,$rating_an,$cart_an,$des_col,$des_font_size,$des_line_height,$des_an){
	ob_start(); 
    $gwf   = new VP_Site_GoogleWebFont();
	$gwf->add($font_ho, $style_ho, $weight_ho);
	$links_ho = $gwf->get_font_links();
	$link_ho  = reset($links_ho);
	?>
	<link href='<?php echo $link_ho; ?>' rel='stylesheet' type='text/css'>
     <style>
		.admin_hover_wrap .pic-twi-caption{
			background: <?php echo $nor_bg_ho; ?> !important;
			color: <?php echo $fo_color_ho; ?> !important;
		}
		.admin_hover_wrap .pic-twi{
			border: <?php echo $nor_border_width_ho; ?>px solid <?php echo $nor_bor_col_ho; ?>;
			border-radius: <?php echo $nor_border_ho; ?>%;
		}
       .admin_hover_wrap .twi_pro_title a,.admin_hover_wrap .twi-panel,.twi_cart a,.admin_hover_wrap .twi-price,.admin_hover_wrap .twi-sale,.admin_hover_wrap .twi-fea,.admin_hover_wrap .twi-out,.twi_pro_des p{
			font-family: <?php echo $font_ho; ?> !important;
			font-style: <?php echo $style_ho; ?> !important;
			font-weight: <?php echo $weight_ho; ?> !important;
		}
		.admin_hover_wrap .twi_pro_title a{
			text-transform: <?php echo $h3_txt_trans_ho; ?> !important;
			color: <?php echo $h3_col_ho; ?> !important;
			font-size: <?php echo $h3_font_size_ho; ?>px !important;
		}
		.admin_hover_wrap .twi_pro_title a:hover{
            color: <?php echo $h3_col_hover_ho; ?> !important;
		}
		.admin_hover_wrap .twi_pro_des p{
			color: <?php echo $des_col; ?> !important;
			font-size: <?php echo $des_font_size; ?>px !important;
			line-height: <?php echo $des_line_height; ?>px !important;
		}
		.admin_hover_wrap .twi-price{
			font-size: <?php echo $fo_size; ?>px !important;
			color: <?php echo $fo_color_ho; ?> !important;
		}
		.admin_hover_wrap .twi-rating{
            color: <?php echo $star_color; ?> !important;
            font-size: <?php echo $st_si_ho; ?>px !important;
		}
		.admin_hover_wrap .twi_cart a {
		    border: <?php echo $cart_bor_wid_ho; ?>px solid <?php echo $cart_bor; ?> !important;
		    color: <?php echo $cart_col; ?> !important;
		    text-transform: <?php echo $cart_txt_trans_ho; ?> !important;
		    background: <?php echo $cart_bg; ?> !important;
		    border-radius: <?php echo $cart_bor_rad_ho; ?>px !important; 
		    font-size: <?php echo $cart_fo_size_ho; ?>px !important;
		}
		.admin_hover_wrap .twi_cart a:hover {
		    border: <?php echo $cart_bor_wid_ho; ?>px solid <?php echo $cart_bor_hover; ?> !important;
		    color: <?php echo $cart_col_hover; ?> !important;
		    background: <?php echo $cart_bg_hover; ?> !important;
		}
		.admin_hover_wrap .twi-sale{
		  background-color: <?php echo $sale_bg_ho; ?> !important;
		  border-color: <?php echo $sale_bg_ho; ?> !important;
		  color: <?php echo $sale_txt_ho; ?> !important;
		}
		.admin_hover_wrap .twi-out{
		  background-color: <?php echo $out_bg_ho; ?> !important;
		  border-color: <?php echo $out_bg_ho; ?> !important;
		  color: <?php echo $out_txt_ho; ?> !important;
		}
		.admin_hover_wrap .twi-fea{
		  background-color: <?php echo $fe_bg_ho; ?> !important;
		  border-color: <?php echo $fe_bg_ho; ?> !important;
		  color: <?php echo $fe_txt_ho; ?> !important;
		}
		.admin_hover_wrap .twi-fea,.admin_hover_wrap .twi-sale {
		    border-bottom-right-radius: <?php echo $nor_border_ho; ?>px !important;
		    border-top-left-radius: <?php echo $nor_border_ho; ?>px !important;
		}
		.admin_hover_wrap .twi-out {
		    border-top-right-radius: <?php echo $nor_border_ho; ?>px !important;
		    border-bottom-left-radius: <?php echo $nor_border_ho; ?>px !important;
		}
		.admin_hover_wrap .twi-panel-teaser img{
			border-top-right-radius: <?php echo $nor_border_ho; ?>px !important;
			border-top-left-radius: <?php echo $nor_border_ho; ?>px !important;
		}
     </style>
     <div class="twi_js_code">
	     <script type="text/javascript">
	     jQuery(document).ready(function(){       
		       jQuery('.pic-twi-caption').each(function() {
		         jQuery(this).hover(function(){
		           jQuery( ".twi_cart" ).addClass("animated <?php echo $cart_an; ?>");
		           jQuery( ".twi_pro_title" ).addClass("animated <?php echo $title_an; ?>");
		           jQuery( ".twi_pro_des" ).addClass("animated <?php echo $des_an; ?>");
		           jQuery( ".twi-price" ).addClass("animated <?php echo $price_an; ?>");
		           jQuery( ".twi-rating" ).addClass("animated <?php echo $rating_an; ?>");
		         },function(){
		             jQuery( ".twi_cart" ).removeClass("animated <?php echo $cart_an; ?>");
		             jQuery( ".twi_pro_title" ).removeClass("animated <?php echo $title_an; ?>");
		             jQuery( ".twi_pro_des" ).removeClass("animated <?php echo $des_an; ?>");
		             jQuery( ".twi-price" ).removeClass("animated <?php echo $price_an; ?>");
		             jQuery( ".twi-rating" ).removeClass("animated <?php echo $rating_an; ?>");
		         });   
		     });
		 });
	     </script>
	 </div>
     <div class="admin_hover_wrap">
	     <div class="pic-twi twi-overlay-hover">
	            <a class="twi-ui top left attached label teal twi-sale">Sale!</a>
				<a class="twi-ui top right attached label red twi-out">Out of stock</a>
				<a class="twi-ui bottom right attached label teal twi-fea">Featured</a>		    
				<div class="twi-panel-teaser twi-rib">
				   <a href="#"><img src="<?php echo TWI_AWESOME_WOO_SLIDER_CAROUSEL_URL; ?>images/demo.jpg" class="<?php echo $img_eff_ho; ?>"></a>
			    </div>
			    <div class="pic-twi-caption <?php echo $over_eff_ho; ?>">
			    <div class="twi-details twi-overlay-panel twi-flex twi-flex-center twi-flex-middle twi-text-center twi-flex-column">
				    <h3 class="twi_pro_title">
					    <a href="#">Product 1</a>
				     </h3>
				     <div class="twi_pro_des">
				         <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
				     </div>
				     <div class="twi-price">
				     	<del><span class="amount"><?php echo get_woocommerce_currency_symbol(); ?>120.00</span></del> 
				     	<ins><span class="amount"><?php echo get_woocommerce_currency_symbol(); ?>100.00</span></ins>
				     </div>
				     <div class="twi-rating">
				     	<i class="twi-icon-star"></i>
				     	<i class="twi-icon-star"></i>
				     	<i class="twi-icon-star"></i>
				     	<i class="twi-icon-star-half-o"></i>
				     	<i class="twi-icon-star-o"></i>
			        </div>
			        <div class="twi_cart">
				     	<a href="#">Add to cart</a>
				    </div>
			 </div>
		 </div>
		</div>
	</div>
	<?php return ob_get_clean();
}

VP_Security::instance()->whitelist_function('woo_over_pre_fun');

function woo_over_pre_fun($value)
{
	if($value === 'overlay')
		return true;
	return false;
}

VP_Security::instance()->whitelist_function('woo_over_live_preview');

function woo_over_live_preview($font_over,$style_over,$weight_over,$nor_bg_over,$nor_border_over,$nor_bor_col_over,$nor_border_width_over,$h3_col_over,$h3_col_overver_over,$h3_font_size_over,$h3_txt_trans_over,$fo_color_over,$fo_size,$star_color,$cart_col,$cart_col_overver,$cart_bg,$cart_bg_overver,$cart_bor,$cart_bor_overver,$cart_bor_wid_over,$cart_txt_trans_over,$cart_bor_rad_over,$cart_fo_size_over,$sale_bg_over,$sale_txt_over,$out_bg_over,$out_txt_over,$fe_bg_over,$fe_txt_over,$st_si_over,$des_col,$des_font_size,$des_line_height){
	ob_start(); 
    $gwf   = new VP_Site_GoogleWebFont();
	$gwf->add($font_over, $style_over, $weight_over);
	$links_over = $gwf->get_font_links();
	$link_over  = reset($links_over);
	?>
	<link href='<?php echo $link_over; ?>' rel='stylesheet' type='text/css'>
     <style>
		.admin_over_wrap .twi-overlay-background{
			background: <?php echo $nor_bg_over; ?> !important;
			color: <?php echo $fo_color_over; ?> !important;
		}
		.admin_over_wrap .twi-overlay{
			border: <?php echo $nor_border_width_over; ?>px solid <?php echo $nor_bor_col_over; ?>;
			border-radius: <?php echo $nor_border_over; ?>%;		
		}
       .admin_over_wrap .twi_pro_title a,.admin_over_wrap .twi-panel,.twi_cart a,.admin_over_wrap .twi-price,.admin_over_wrap .twi-sale,.admin_over_wrap .twi-fea,.admin_over_wrap .twi-out,.admin_over_wrap p{
			font-family: <?php echo $font_over; ?> !important;
			font-style: <?php echo $style_over; ?> !important;
			font-weight: <?php echo $weight_over; ?> !important;
		}
		.admin_over_wrap .twi_pro_title a{
			text-transform: <?php echo $h3_txt_trans_over; ?> !important;
			color: <?php echo $h3_col_over; ?> !important;
			font-size: <?php echo $h3_font_size_over; ?>px !important;
		}
		.admin_over_wrap .twi_pro_title a:hover{
            color: <?php echo $h3_col_overver_over; ?> !important;
		}
		.admin_over_wrap .twi_pro_des p{
			color: <?php echo $des_col; ?> !important;
			font-size: <?php echo $des_font_size; ?>px !important;
			line-height: <?php echo $des_line_height; ?>px !important;
		}
		.admin_over_wrap .twi-price{
			font-size: <?php echo $fo_size; ?>px !important;
			color: <?php echo $fo_color_over; ?> !important;
		}
		.admin_over_wrap .twi-rating{
            color: <?php echo $star_color; ?> !important;
            font-size: <?php echo $st_si_over; ?>px !important;
		}
		.admin_over_wrap .twi_cart a {
		    border: <?php echo $cart_bor_wid_over; ?>px solid <?php echo $cart_bor; ?> !important;
		    color: <?php echo $cart_col; ?> !important;
		    text-transform: <?php echo $cart_txt_trans_over; ?> !important;
		    background: <?php echo $cart_bg; ?> !important;
		    border-radius: <?php echo $cart_bor_rad_over; ?>px !important; 
		    font-size: <?php echo $cart_fo_size_over; ?>px !important;
		}
		.admin_over_wrap .twi_cart a:hover {
		    border: <?php echo $cart_bor_wid_over; ?>px solid <?php echo $cart_bor_overver; ?> !important;
		    color: <?php echo $cart_col_overver; ?> !important;
		    background: <?php echo $cart_bg_overver; ?> !important;
		}
		.admin_over_wrap .twi-sale{
		  background-color: <?php echo $sale_bg_over; ?> !important;
		  border-color: <?php echo $sale_bg_over; ?> !important;
		  color: <?php echo $sale_txt_over; ?> !important;
		}
		.admin_over_wrap .twi-out{
		  background-color: <?php echo $out_bg_over; ?> !important;
		  border-color: <?php echo $out_bg_over; ?> !important;
		  color: <?php echo $out_txt_over; ?> !important;
		}
		.admin_over_wrap .twi-fea{
		  background-color: <?php echo $fe_bg_over; ?> !important;
		  border-color: <?php echo $fe_bg_over; ?> !important;
		  color: <?php echo $fe_txt_over; ?> !important;
		}
		.admin_over_wrap .twi-fea,.admin_overver_wrap .twi-sale {
		    border-bottom-right-radius: <?php echo $nor_border_over; ?>px !important;
		    border-top-left-radius: <?php echo $nor_border_over; ?>px !important;
		}
		.admin_over_wrap .twi-out {
		    border-top-right-radius: <?php echo $nor_border_over; ?>px !important;
		    border-bottom-left-radius: <?php echo $nor_border_over; ?>px !important;
		}
		.admin_over_wrap .twi-panel-teaser img{
			border-top-right-radius: <?php echo $nor_border_over; ?>px !important;
			border-top-left-radius: <?php echo $nor_border_over; ?>px !important;
		}
     </style>
     <div class="admin_over_wrap">
        <figure class="twi-overlay">
        	<a class="twi-ui top left attached label teal twi-sale">Sale!</a>
			<a class="twi-ui top right attached label red twi-out">Out of stock</a>
			<a class="twi-ui bottom right attached label teal twi-fea">Featured</a>
            <a href="#"><img src="<?php echo TWI_AWESOME_WOO_SLIDER_CAROUSEL_URL; ?>images/demo.jpg"></a>
                <figcaption class="twi-overlay-panel twi-overlay-background twi-flex twi-flex-center twi-flex-middle twi-text-center">
                    <div class="twi_pro_detail">
                         <h3 class="twi_pro_title">
					        <a href="#">Product 1</a>
					     </h3>
					     <div class="twi_pro_des">
					         <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
					     </div>
					     <div class="twi-price">
					     	<del><span class="amount"><?php echo get_woocommerce_currency_symbol(); ?>120.00</span></del> 
					     	<ins><span class="amount"><?php echo get_woocommerce_currency_symbol(); ?>100.00</span></ins>
					     </div>
					     <div class="twi-rating">
					     	<i class="twi-icon-star"></i>
					     	<i class="twi-icon-star"></i>
					     	<i class="twi-icon-star"></i>
					     	<i class="twi-icon-star-half-o"></i>
					     	<i class="twi-icon-star-o"></i>
				        </div>
				        <div class="twi_cart">
					     	<a href="#">Add to cart</a>
					    </div>
                    </div>
                </figcaption>
        </figure>
	</div>
	<?php return ob_get_clean();
}


// Version 5 Start
VP_Security::instance()->whitelist_function('woo_sl_grid_styles');
function woo_sl_grid_styles() {
	return array(
		array('label' => __('Responsive Grid', 'twi_awesome_woo_slider_carousel'), 'value' => 'twi_woo_grid'),
		array('label' => __('Masonry Grid (Pinterest Style)', 'twi_awesome_woo_slider_carousel'), 'value' => 'twi_woo_mansonry'),
		//array('label' => __('Justified Gird', 'twi_awesome_woo_slider_carousel'), 'value' => 'twi_woo_justified'),
		array('label' => __('Slider/Carousel', 'twi_awesome_woo_slider_carousel'), 'value' => 'twi_woo_slider'),
		array('label' => __('Slide Set', 'twi_awesome_woo_slider_carousel'), 'value' => 'twi_woo_slideset'),
	);
}

VP_Security::instance()->whitelist_function('woo_sl_grid_gap');
function woo_sl_grid_gap() {
	return array(
		array('label' => __('Normal', 'twi_awesome_woo_slider_carousel'), 'value' => 'normal'),
		array('label' => __('Medium', 'twi_awesome_woo_slider_carousel'), 'value' => 'medium'),
		array('label' => __('Small', 'twi_awesome_woo_slider_carousel'), 'value' => 'small'),
		array('label' => __('Collapse', 'twi_awesome_woo_slider_carousel'), 'value' => 'collapse'),
	);
}

VP_Security::instance()->whitelist_function('woo_sl_grid_no');
function woo_sl_grid_no() {
	return array(
		array('label' => __('1', 'twi_awesome_woo_slider_carousel'), 'value' => '1'),
		array('label' => __('2', 'twi_awesome_woo_slider_carousel'), 'value' => '2'),
		array('label' => __('3', 'twi_awesome_woo_slider_carousel'), 'value' => '3'),
		array('label' => __('4', 'twi_awesome_woo_slider_carousel'), 'value' => '4'),
		array('label' => __('5', 'twi_awesome_woo_slider_carousel'), 'value' => '5'),
		array('label' => __('6', 'twi_awesome_woo_slider_carousel'), 'value' => '6'),
		array('label' => __('10', 'twi_awesome_woo_slider_carousel'), 'value' => '10'),
	);
}

VP_Security::instance()->whitelist_function('woo_sl_styles');
function woo_sl_styles() {
	return array(
		array('label' => __('Left', 'twi_awesome_woo_slider_carousel'), 'value' => 'left'),
		array('label' => __('Right', 'twi_awesome_woo_slider_carousel'), 'value' => 'right'),
	);
}

VP_Security::instance()->whitelist_function('woo_sl_grid_yes_no');
function woo_sl_grid_yes_no() {
	return array(
		array('label' => __('Yes', 'twi_awesome_woo_slider_carousel'), 'value' => 'yes'),
		array('label' => __('No', 'twi_awesome_woo_slider_carousel'), 'value' => 'no'),
	);
}

VP_Security::instance()->whitelist_function('woo_sl_grid_true_false');
function woo_sl_grid_true_false() {
	return array(
		array('label' => __('Yes', 'twi_awesome_woo_slider_carousel'), 'value' => 'true'),
		array('label' => __('No', 'twi_awesome_woo_slider_carousel'), 'value' => 'false'),
	);
}

VP_Security::instance()->whitelist_function('woo_sl_pagi_pos');
function woo_sl_pagi_pos() {
	return array(
		array('label' => __('Left', 'twi_awesome_woo_slider_carousel'), 'value' => 'left'),
		array('label' => __('Center', 'twi_awesome_woo_slider_carousel'), 'value' => 'center'),
		array('label' => __('Right', 'twi_awesome_woo_slider_carousel'), 'value' => 'right'),
	);
}

VP_Security::instance()->whitelist_function('woo_sl_nav_pos');
function woo_sl_nav_pos() {
	return array(
		array('label' => __('Bottom Center', 'twi_awesome_woo_slider_carousel'), 'value' => 'nav_b_c'),
		array('label' => __('Bottom Left', 'twi_awesome_woo_slider_carousel'), 'value' => 'nav_b_l'),
		array('label' => __('Bottom Right', 'twi_awesome_woo_slider_carousel'), 'value' => 'nav_b_r'),
		array('label' => __('Top Center', 'twi_awesome_woo_slider_carousel'), 'value' => 'nav_t_c'),
		array('label' => __('Top Left', 'twi_awesome_woo_slider_carousel'), 'value' => 'nav_t_l'),
		array('label' => __('Top Right', 'twi_awesome_woo_slider_carousel'), 'value' => 'nav_t_r'),
	);
}

VP_Security::instance()->whitelist_function('woo_sl_order_by');
function woo_sl_order_by() {
	return array(
		array('label' => __('Title', 'twi_awesome_woo_slider_carousel'), 'value' => 'title'),
		array('label' => __('ID', 'twi_awesome_woo_slider_carousel'), 'value' => 'ID'),
		array('label' => __('Price', 'twi_awesome_woo_slider_carousel'), 'value' => 'price'),
		array('label' => __('SKU', 'twi_awesome_woo_slider_carousel'), 'value' => 'sku'),
		array('label' => __('Date', 'twi_awesome_woo_slider_carousel'), 'value' => 'date'),
		array('label' => __('Random', 'twi_awesome_woo_slider_carousel'), 'value' => 'rand'),
		array('label' => __('Featured', 'twi_awesome_woo_slider_carousel'), 'value' => 'featured'),
		array('label' => __('Products on sale', 'twi_awesome_woo_slider_carousel'), 'value' => 'pro_on_sale'),
		array('label' => __('Latest/Recent products', 'twi_awesome_woo_slider_carousel'), 'value' => 'recent_pro'),
		array('label' => __('Recent Viewed products', 'twi_awesome_woo_slider_carousel'), 'value' => 'recent_view'),
		array('label' => __('Best Sellers', 'twi_awesome_woo_slider_carousel'), 'value' => 'best_sellers'),
	);
}

VP_Security::instance()->whitelist_function('woo_sl_grid_pro_dis_style');
function woo_sl_grid_pro_dis_style() {
	return array(
		array('label' => __('Category/Categories Wise', 'twi_awesome_woo_slider_carousel'), 'value' => 'cat_wise'),
		array('label' => __('Specific Products', 'twi_awesome_woo_slider_carousel'), 'value' => 'spe_pro'),
		array('label' => __('Category Showcase', 'twi_awesome_woo_slider_carousel'), 'value' => 'cat_showcase'),
	);
}

VP_Security::instance()->whitelist_function('woo_cat_type');
function woo_cat_type() {
	return array(
		array('label' => __('Categories', 'twi_awesome_woo_slider_carousel'), 'value' => 'cat_type'),
		array('label' => __('Sub-category', 'twi_awesome_woo_slider_carousel'), 'value' => 'sub_cat_type'),
	);
}

VP_Security::instance()->whitelist_function('woo_sl_pro_order');
function woo_sl_pro_order() {
	return array(
		array('label' => __('Ascending', 'twi_awesome_woo_slider_carousel'), 'value' => 'asc'),
		array('label' => __('Descending', 'twi_awesome_woo_slider_carousel'), 'value' => 'desc'),
	);
}

VP_Security::instance()->whitelist_function('woo_sl_temp_style');
function woo_sl_temp_style() {
	return array(
		array('label' => __('Normal Style', 'twi_awesome_woo_slider_carousel'), 'value' => 'normal'),
		array('label' => __('Woocommerce Style (Not Suitable for all themes)', 'twi_awesome_woo_slider_carousel'), 'value' => 'woo_style'),
		array('label' => __('Hover Effects', 'twi_awesome_woo_slider_carousel'), 'value' => 'hover'),
		array('label' => __('Hover Effects 2', 'twi_awesome_woo_slider_carousel'), 'value' => 'hover2'),
		array('label' => __('Overlay', 'twi_awesome_woo_slider_carousel'), 'value' => 'overlay'),
		//array('label' => __('Slide Effects', 'twi_awesome_woo_slider_carousel'), 'value' => 'slide'),
		array('label' => __('Only Image', 'twi_awesome_woo_slider_carousel'), 'value' => 'img_only'),
	);
}

VP_Security::instance()->whitelist_function('woo_sl_txt_trans');
function woo_sl_txt_trans() {
	return array(
		array('label' => __('Uppercase', 'twi_awesome_woo_slider_carousel'), 'value' => 'uppercase'),
		array('label' => __('Lowercase', 'twi_awesome_woo_slider_carousel'), 'value' => 'lowercase'),
		array('label' => __('Inherit', 'twi_awesome_woo_slider_carousel'), 'value' => 'inherit'),
		array('label' => __('Capitalize', 'twi_awesome_woo_slider_carousel'), 'value' => 'capitalize'),
	);
}

VP_Security::instance()->whitelist_function('woo_sl_over_eff');
function woo_sl_over_eff() {
	return array(
		array('label' => __('Fade', 'twi_awesome_woo_slider_carousel'), 'value' => 'fade'),
		array('label' => __('Bottom To Top', 'twi_awesome_woo_slider_carousel'), 'value' => 'bottom-to-top'),
		array('label' => __('Top to Bottom', 'twi_awesome_woo_slider_carousel'), 'value' => 'top-to-bottom'),
		array('label' => __('Left to Right', 'twi_awesome_woo_slider_carousel'), 'value' => 'left-to-right'),
		array('label' => __('Right to Left', 'twi_awesome_woo_slider_carousel'), 'value' => 'right-to-left'),
		array('label' => __('Open Down', 'twi_awesome_woo_slider_carousel'), 'value' => 'open-down'),
		array('label' => __('Open Left', 'twi_awesome_woo_slider_carousel'), 'value' => 'open-left'),
		array('label' => __('Open Right', 'twi_awesome_woo_slider_carousel'), 'value' => 'open-right'),
		array('label' => __('Come Right', 'twi_awesome_woo_slider_carousel'), 'value' => 'come-right'),
		array('label' => __('Come Left', 'twi_awesome_woo_slider_carousel'), 'value' => 'come-left'),
	);
}

VP_Security::instance()->whitelist_function('woo_sl_img_eff');
function woo_sl_img_eff() {
	return array(
		array('label' => __('Normal', 'twi_awesome_woo_slider_carousel'), 'value' => 'twi-img-normal'),
		array('label' => __('Fade', 'twi_awesome_woo_slider_carousel'), 'value' => 'twi-overlay-fade'),
		array('label' => __('Scale', 'twi_awesome_woo_slider_carousel'), 'value' => 'twi-overlay-scale'),
		array('label' => __('Spin', 'twi_awesome_woo_slider_carousel'), 'value' => 'twi-overlay-spin'),
		array('label' => __('Grayscale (Before Hover)', 'twi_awesome_woo_slider_carousel'), 'value' => 'twi-overlay-grayscale'),
		array('label' => __('Grayscale (After Hover)', 'twi_awesome_woo_slider_carousel'), 'value' => 'twi-overlay-twi-grayscale'),
	);
}

VP_Security::instance()->whitelist_function('woo_sl_animations_sets');
function woo_sl_animations_sets() {
	return array(
		array('label' => __('No animation', 'twi_awesome_woo_slider_carousel'), 'value' => 'no-animtion'),
		array('label' => __('Bounce', 'twi_awesome_woo_slider_carousel'), 'value' => 'bounce'),
		array('label' => __('Flash', 'twi_awesome_woo_slider_carousel'), 'value' => 'flash'),
		array('label' => __('Pulse', 'twi_awesome_woo_slider_carousel'), 'value' => 'pulse'),
		array('label' => __('Rubber Band', 'twi_awesome_woo_slider_carousel'), 'value' => 'rubberBand'),
		array('label' => __('Shake', 'twi_awesome_woo_slider_carousel'), 'value' => 'shake'),
		array('label' => __('Swing', 'twi_awesome_woo_slider_carousel'), 'value' => 'swing'),
		array('label' => __('Tada', 'twi_awesome_woo_slider_carousel'), 'value' => 'tada'),
		array('label' => __('Wobble', 'twi_awesome_woo_slider_carousel'), 'value' => 'wobble'),
		array('label' => __('Bounce In', 'twi_awesome_woo_slider_carousel'), 'value' => 'bounceIn'),
		array('label' => __('Bounce In Down', 'twi_awesome_woo_slider_carousel'), 'value' => 'bounceInDown'),
		array('label' => __('Bounce In Left', 'twi_awesome_woo_slider_carousel'), 'value' => 'bounceInLeft'),
		array('label' => __('Bounce In Right', 'twi_awesome_woo_slider_carousel'), 'value' => 'bounceInRight'),
		array('label' => __('Bounce In Up', 'twi_awesome_woo_slider_carousel'), 'value' => 'bounceInUp'),
		array('label' => __('Fade In', 'twi_awesome_woo_slider_carousel'), 'value' => 'fadeIn'),
		array('label' => __('Fade In Down', 'twi_awesome_woo_slider_carousel'), 'value' => 'fadeInDown'),
		array('label' => __('Fade In Down Big', 'twi_awesome_woo_slider_carousel'), 'value' => 'fadeInDownBig'),
		array('label' => __('Fade In Left', 'twi_awesome_woo_slider_carousel'), 'value' => 'fadeInLeft'),
		array('label' => __('Fade In Left Big', 'twi_awesome_woo_slider_carousel'), 'value' => 'fadeInLeftBig'),
		array('label' => __('Fade In Right', 'twi_awesome_woo_slider_carousel'), 'value' => 'fadeInRight'),
		array('label' => __('Fade In Right Big', 'twi_awesome_woo_slider_carousel'), 'value' => 'fadeInRightBig'),
		array('label' => __('Fade In Up', 'twi_awesome_woo_slider_carousel'), 'value' => 'fadeInUp'),
		array('label' => __('Fade In Up Big', 'twi_awesome_woo_slider_carousel'), 'value' => 'fadeInUpBig'),
		array('label' => __('Flip', 'twi_awesome_woo_slider_carousel'), 'value' => 'flip'),
		array('label' => __('Flip In X', 'twi_awesome_woo_slider_carousel'), 'value' => 'flipInX'),
		array('label' => __('Flip In Y', 'twi_awesome_woo_slider_carousel'), 'value' => 'flipInY'),
		array('label' => __('Light Speed In', 'twi_awesome_woo_slider_carousel'), 'value' => 'lightSpeedIn'),
		array('label' => __('Rotate In', 'twi_awesome_woo_slider_carousel'), 'value' => 'rotateIn'),
		array('label' => __('Rotate In Down Left', 'twi_awesome_woo_slider_carousel'), 'value' => 'rotateInDownLeft'),
		array('label' => __('Rotate In Down Right', 'twi_awesome_woo_slider_carousel'), 'value' => 'rotateInDownRight'),
		array('label' => __('Rotate In Up Left', 'twi_awesome_woo_slider_carousel'), 'value' => 'rotateInUpLeft'),
		array('label' => __('Rotate In Up Right', 'twi_awesome_woo_slider_carousel'), 'value' => 'rotateInUpRight'),
		array('label' => __('Slide In Down', 'twi_awesome_woo_slider_carousel'), 'value' => 'slideInDown'),
		array('label' => __('Slide In Left', 'twi_awesome_woo_slider_carousel'), 'value' => 'slideInLeft'),
		array('label' => __('Slide In Right', 'twi_awesome_woo_slider_carousel'), 'value' => 'slideInRight'),
		array('label' => __('Hinge', 'twi_awesome_woo_slider_carousel'), 'value' => 'hinge'),
		array('label' => __('Roll In', 'twi_awesome_woo_slider_carousel'), 'value' => 'rollIn'),
	);
}

VP_Security::instance()->whitelist_function('cat_wise_dep');
function cat_wise_dep($value)
{
	if($value === 'cat_wise')
		return true;
	return false;
}

VP_Security::instance()->whitelist_function('spe_pro_dep');
function spe_pro_dep($value)
{
	if($value === 'spe_pro')
		return true;
	return false;
}

VP_Security::instance()->whitelist_function('twi_get_pro_list');
function twi_get_pro_list()
{
	$wp_posts = get_posts(array(
		'post_type' => 'product',
		'posts_per_page' => -1,
	));

	$result = array();
	foreach ($wp_posts as $post)
	{
		$result[] = array('value' => $post->ID, 'label' => $post->post_title);
	}
	return $result;
}

VP_Security::instance()->whitelist_function('twi_woo_st_dep_slideset');

function twi_woo_st_dep_slideset($value)
{
	if($value === 'twi_woo_slideset')
		return true;
	return false;
}

VP_Security::instance()->whitelist_function('woo_slideset_ani');
function woo_slideset_ani() {
	return array(
		array('label' => __('Fade', 'twi_awesome_woo_slider_carousel'), 'value' => 'fade'),
		array('label' => __('Scale', 'twi_awesome_woo_slider_carousel'), 'value' => 'scale'),
		array('label' => __('Slide Horizontal', 'twi_awesome_woo_slider_carousel'), 'value' => 'slide-horizontal'),
		array('label' => __('Slide Vertical', 'twi_awesome_woo_slider_carousel'), 'value' => 'slide-vertical'),
		array('label' => __('Slide Top', 'twi_awesome_woo_slider_carousel'), 'value' => 'slide-top'),
		array('label' => __('Slide Bottom', 'twi_awesome_woo_slider_carousel'), 'value' => 'slide-bottom'),
	);
}

VP_Security::instance()->whitelist_function('woo_pagination_type');
function woo_pagination_type() {
	return array(
		array('label' => __('Normal Pagination', 'twi_awesome_woo_slider_carousel'), 'value' => 'nor_page'),
		//array('label' => __('Next/Previous Pagination', 'twi_awesome_woo_slider_carousel'), 'value' => 'nxt_prev'),
		array('label' => __('AJAX Pagination', 'twi_awesome_woo_slider_carousel'), 'value' => 'ajax_page'),
		array('label' => __('Click Load More', 'twi_awesome_woo_slider_carousel'), 'value' => 'more'),
		array('label' => __('Scroll Load More', 'twi_awesome_woo_slider_carousel'), 'value' => 'infinite'),
	);
}

VP_Security::instance()->whitelist_function('woo_slider_row');
function woo_slider_row() {
	return array(
		array('label' => __('1', 'twi_awesome_woo_slider_carousel'), 'value' => '1'),
		array('label' => __('2', 'twi_awesome_woo_slider_carousel'), 'value' => '2'),
		array('label' => __('3', 'twi_awesome_woo_slider_carousel'), 'value' => '3'),
		array('label' => __('4', 'twi_awesome_woo_slider_carousel'), 'value' => '4'),
		array('label' => __('5', 'twi_awesome_woo_slider_carousel'), 'value' => '5'),
	);
}

VP_Security::instance()->whitelist_function('woo_cat_type_dep');

function woo_cat_type_dep($value)
{
	if($value === 'cat_showcase')
		return true;
	return false;
}

VP_Security::instance()->whitelist_function('sub_cat_type_dep');

function sub_cat_type_dep($value1,$value2)
{
	if($value1 === 'sub_cat_type' && $value2 === 'cat_showcase')
		return true;
	return false;
}
function twi_woo_get_categories()
{
	$taxonomy = 'product_cat';
    $terms = get_terms( $taxonomy, '' );

	$res = array();
	foreach ($terms as $term)
	{
		$res[] = array('value' => $term->term_id, 'label' => $term->name);
	}
	return $res;
}

VP_Security::instance()->whitelist_function('twi_woo_justified_mar');
function twi_woo_justified_mar($value)
{
	if($value === 'twi_woo_justified')
		return true;
	return false;
}

VP_Security::instance()->whitelist_function('woo_img_sizes');
function woo_img_sizes() {
	return array(
		array('label' => __('Custom Size', 'twi_awesome_woo_slider_carousel'), 'value' => 'twi_woo_thumbnail'),
		array('label' => __('Shop Catalog (Woocommmerce)', 'twi_awesome_woo_slider_carousel'), 'value' => 'shop_catalog'),
		array('label' => __('Shop Single (Woocommmerce)', 'twi_awesome_woo_slider_carousel'), 'value' => 'shop_single'),
		array('label' => __('Shop Thumbnail (Woocommmerce)', 'twi_awesome_woo_slider_carousel'), 'value' => 'shop_thumbnail'),
	);
}

VP_Security::instance()->whitelist_function('cus_img_size_dep');

function cus_img_size_dep($value1)
{
	if($value1 === 'twi_woo_thumbnail')
		return true;
	return false;
}

VP_Security::instance()->whitelist_function('woo_own_img_size');

function woo_own_img_size($value)
{
	if($value === 'shop_catalog' || $value === 'shop_single' || $value === 'shop_thumbnail')
		return true;
	return false;
}

/* Hover Set 2*/
VP_Security::instance()->whitelist_function('woo_hover2_pre_fun');

function woo_hover2_pre_fun($value)
{
	if($value === 'hover2')
		return true;
	return false;
}

VP_Security::instance()->whitelist_function('twi_woo_ho2_eff');

function twi_woo_ho2_eff() {
	return array(
		array('label' => __('Effect 1', 'twi_awesome_woo_slider_carousel'), 'value' => '1'),
		array('label' => __('Effect 2', 'twi_awesome_woo_slider_carousel'), 'value' => '2'),
		array('label' => __('Effect 3', 'twi_awesome_woo_slider_carousel'), 'value' => '3'),
		array('label' => __('Effect 4', 'twi_awesome_woo_slider_carousel'), 'value' => '4'),
		array('label' => __('Effect 5', 'twi_awesome_woo_slider_carousel'), 'value' => '5'),
		array('label' => __('Effect 6', 'twi_awesome_woo_slider_carousel'), 'value' => '6'),
		array('label' => __('Effect 7', 'twi_awesome_woo_slider_carousel'), 'value' => '7'),
		array('label' => __('Effect 8', 'twi_awesome_woo_slider_carousel'), 'value' => '8'),
		array('label' => __('Effect 9', 'twi_awesome_woo_slider_carousel'), 'value' => '9'),
		array('label' => __('Effect 10', 'twi_awesome_woo_slider_carousel'), 'value' => '10'),
		array('label' => __('Effect 11', 'twi_awesome_woo_slider_carousel'), 'value' => '11'),
		array('label' => __('Effect 12', 'twi_awesome_woo_slider_carousel'), 'value' => '12'),
		array('label' => __('Effect 13', 'twi_awesome_woo_slider_carousel'), 'value' => '13'),
		array('label' => __('Effect 14', 'twi_awesome_woo_slider_carousel'), 'value' => '14'),
		array('label' => __('Effect 15', 'twi_awesome_woo_slider_carousel'), 'value' => '15'),
		array('label' => __('Effect 16', 'twi_awesome_woo_slider_carousel'), 'value' => '16'),
		array('label' => __('Effect 17', 'twi_awesome_woo_slider_carousel'), 'value' => '17'),
		array('label' => __('Effect 18', 'twi_awesome_woo_slider_carousel'), 'value' => '18'),
		array('label' => __('Effect 19', 'twi_awesome_woo_slider_carousel'), 'value' => '19'),
		array('label' => __('Effect 20', 'twi_awesome_woo_slider_carousel'), 'value' => '20'),
		array('label' => __('Effect 21', 'twi_awesome_woo_slider_carousel'), 'value' => '21'),
		array('label' => __('Effect 22', 'twi_awesome_woo_slider_carousel'), 'value' => '22'),
	);
}

VP_Security::instance()->whitelist_function('twi_woo_ho2_img');

function twi_woo_ho2_img() {
	return array(
		array('label' => __('Effect 1', 'twi_awesome_woo_slider_carousel'), 'value' => '1'),
		array('label' => __('Effect 2', 'twi_awesome_woo_slider_carousel'), 'value' => '2'),
		array('label' => __('Effect 3', 'twi_awesome_woo_slider_carousel'), 'value' => '3'),
		array('label' => __('Effect 4', 'twi_awesome_woo_slider_carousel'), 'value' => '4'),
		array('label' => __('Effect 5', 'twi_awesome_woo_slider_carousel'), 'value' => '5'),
		array('label' => __('Effect 6', 'twi_awesome_woo_slider_carousel'), 'value' => '6'),
		array('label' => __('Effect 7', 'twi_awesome_woo_slider_carousel'), 'value' => '7'),
		array('label' => __('Effect 8 (Grayscale)', 'twi_awesome_woo_slider_carousel'), 'value' => '8'),
		array('label' => __('Effect 9 (Grayscale - Hover)', 'twi_awesome_woo_slider_carousel'), 'value' => '9'),
	);
}

VP_Security::instance()->whitelist_function('twi_woo_hover_set2');

function twi_woo_hover_set2($font,$style,$weight,$nor_bg,$nor_border,$nor_bor_col,$nor_border_width,$h3_col,$h3_col_hover,$h3_font_size,$h3_txt_trans,$fo_color,$fo_size,$star_color,$cart_col,$cart_col_hover,$cart_bg,$cart_bg_hover,$cart_bor,$cart_bor_hover,$cart_bor_wid,$cart_txt_trans,$cart_bor_rad,$cart_fo_size,$sale_bg,$sale_txt,$out_bg,$out_txt,$fe_bg,$fe_txt,$st_si,$overlay_eff,$img_eff,$title_an,$price_an,$rating_an,$cart_an,$des_col,$des_font_size,$des_line_height,$des_an){
	ob_start(); 
    $gwf   = new VP_Site_GoogleWebFont();
	$gwf->add($font, $style, $weight);
	$links = $gwf->get_font_links();
	$link  = reset($links);
	?>
	<link href='<?php echo $link; ?>' rel='stylesheet' type='text/css'>
    <style>
    .twi_woo_hover2_con h3 a,.twi_woo_hover2_con p,.twi_woo_hover2_con .amount,.twi_woo_hover2_con .twi_cart a,.admin_over_wrap2 .twi-ui{
		font-family: <?php echo $font; ?> !important;
		font-style: <?php echo $style; ?> !important;
		font-weight: <?php echo $weight; ?> !important;
	}
	.admin_over_wrap2 .twi_pro_title a{
		text-transform: <?php echo $h3_txt_trans; ?> !important;
		color: <?php echo $h3_col; ?> !important;
		font-size: <?php echo $h3_font_size; ?>px !important;
	}
	.admin_over_wrap2 .twi_pro_title a:hover{
        color: <?php echo $h3_col_hover; ?> !important;
	}
	.admin_over_wrap2 .twi_pro_des p{
		color: <?php echo $des_col; ?> !important;
		font-size: <?php echo $des_font_size; ?>px !important;
		line-height: <?php echo $des_line_height; ?>px !important;
	}
	.admin_over_wrap2 .twi-price{
		font-size: <?php echo $fo_size; ?>px !important;
		color: <?php echo $fo_color; ?> !important;
	}
	.admin_over_wrap2 .twi-rating{
        color: <?php echo $star_color; ?> !important;
        font-size: <?php echo $st_si; ?>px !important;
	}
	.admin_over_wrap2 .twi_cart a {
		border: <?php echo $cart_bor_wid; ?>px solid <?php echo $cart_bor; ?> !important;
		color: <?php echo $cart_col; ?> !important;
		text-transform: <?php echo $cart_txt_trans; ?> !important;
		background: <?php echo $cart_bg; ?> !important;
		border-radius: <?php echo $cart_bor_rad; ?>px !important; 
		font-size: <?php echo $cart_fo_size; ?>px !important;
	}
	.admin_over_wrap2 .twi_cart a:hover {
		border: <?php echo $cart_bor_wid; ?>px solid <?php echo $cart_bor_hover; ?> !important;
		color: <?php echo $cart_col_hover; ?> !important;
		background: <?php echo $cart_bg_hover; ?> !important;
	}
	.admin_over_wrap2 .twi-sale{
		background-color: <?php echo $sale_bg; ?> !important;
		border-color: <?php echo $sale_bg; ?> !important;
		color: <?php echo $sale_txt; ?> !important;
	}
	.admin_over_wrap2 .twi-out{
		background-color: <?php echo $out_bg; ?> !important;
		border-color: <?php echo $out_bg; ?> !important;
		color: <?php echo $out_txt; ?> !important;
	}
	.admin_over_wrap2 .twi-fea{
		background-color: <?php echo $fe_bg; ?> !important;
		border-color: <?php echo $fe_bg; ?> !important;
	    color: <?php echo $fe_txt; ?> !important;
	}
	.admin_over_wrap2 .twi-fea,.admin_overver_wrap .twi-sale {
		border-bottom-right-radius: <?php echo $nor_border; ?>px !important;
		border-top-left-radius: <?php echo $nor_border; ?>px !important;
	}
    .admin_over_wrap2 .twi-out {
		border-top-right-radius: <?php echo $nor_border; ?>px !important;
		border-bottom-left-radius: <?php echo $nor_border; ?>px !important;
	}
	.admin_over_wrap2 .twi-panel-teaser img{
		border-top-right-radius: <?php echo $nor_border; ?>px !important;
		border-top-left-radius: <?php echo $nor_border; ?>px !important;
	}
    .admin_over_wrap2 .twi_hover_effect1,
	.admin_over_wrap2 .twi_hover_effect2,
	.admin_over_wrap2 .twi_hover_effect3:after,
	.admin_over_wrap2 .twi_hover_effect3:before,
	.admin_over_wrap2 .twi_hover_effect4:after,
	.admin_over_wrap2 .twi_hover_effect4:before,
	.admin_over_wrap2 .twi_hover_effect5,
	.admin_over_wrap2 .twi_hover_effect6:after,
	.admin_over_wrap2 .twi_hover_effect6:before,
	.admin_over_wrap2 .twi_hover_effect7:after,
	.admin_over_wrap2 .twi_hover_effect7:before,
	.admin_over_wrap2 .twi_hover_effect8,
	.admin_over_wrap2 .twi_hover_effect9,
	.admin_over_wrap2 .twi_hover_effect10,
	.admin_over_wrap2 .twi_hover_effect11,
	.admin_over_wrap2 .twi_hover_effect12,
	.admin_over_wrap2 .twi_hover_effect13,
	.admin_over_wrap2 .twi_hover_effect14,
	.admin_over_wrap2 .twi_hover_effect15,
	.admin_over_wrap2 .twi_hover_effect16,
	.admin_over_wrap2 .twi_hover_effect17,
	.admin_over_wrap2 .twi_hover_effect_a_18:before,
	.admin_over_wrap2 .twi_hover_effect_a_18:after,
	.admin_over_wrap2 .twi_hover_effect_b_18:before,
	.admin_over_wrap2 .twi_hover_effect_b_18:after,
	.admin_over_wrap2 .twi_hover_effect19,
	.admin_over_wrap2 .twi_hover_effect20,
	.admin_over_wrap2 .twi_hover_effect21,
	.admin_over_wrap2 .twi_hover_effect22{
		background: <?php echo $nor_bg; ?>!important;
	}
    .twi_img_effect1,.twi_img_effect2,.twi_img_effect3,.twi_img_effect4,.twi_img_effect5,.twi_img_effect8,.twi_img_effect9{
    	border-radius: <?php echo $nor_border; ?>%;
    }
    .twi-hover-wrap{ border: <?php echo $nor_border_width; ?>px solid <?php echo $nor_bor_col; ?>; }
    </style>
    <div class="twi_js_code">
	     <script type="text/javascript">
	     jQuery(document).ready(function(){       
		       jQuery('.twi_woo_hover2_con').each(function() {
		         jQuery(this).hover(function(){
		           jQuery( ".twi_cart" ).addClass("animated <?php echo $cart_an; ?>");
		           jQuery( ".twi_pro_title" ).addClass("animated <?php echo $title_an; ?>");
		           jQuery( ".twi_pro_des" ).addClass("animated <?php echo $des_an; ?>");
		           jQuery( ".twi-price" ).addClass("animated <?php echo $price_an; ?>");
		           jQuery( ".twi-rating" ).addClass("animated <?php echo $rating_an; ?>");
		         },function(){
		             jQuery( ".twi_cart" ).removeClass("animated <?php echo $cart_an; ?>");
		             jQuery( ".twi_pro_title" ).removeClass("animated <?php echo $title_an; ?>");
		             jQuery( ".twi_pro_des" ).removeClass("animated <?php echo $des_an; ?>");
		             jQuery( ".twi-price" ).removeClass("animated <?php echo $price_an; ?>");
		             jQuery( ".twi-rating" ).removeClass("animated <?php echo $rating_an; ?>");
		         });   
		     });
		 });
	     </script>
	 </div>

    <div class="admin_over_wrap2">
        <div class="twi-hover-wrap twi_img_effect<?php echo $img_eff; ?>">
            <a class="twi-ui top left attached label teal twi-sale">Sale!</a>
			<a class="twi-ui top right attached label red twi-out">Out of stock</a>
			<a class="twi-ui bottom right attached label teal twi-fea">Featured</a>
            <img src="<?php echo TWI_AWESOME_WOO_SLIDER_CAROUSEL_URL; ?>/images/demo.jpg" alt="Live Preview">
            <?php if($overlay_eff != '18'){ ?>
                <div class="twi_hover_effect<?php echo $overlay_eff; ?>"></div>
            <?php }else{ ?>
	            <div class="twi_hover_effect_a_<?php echo $overlay_eff; ?>"></div>
	            <div class="twi_hover_effect_b_<?php echo $overlay_eff; ?>"></div>
            <?php } ?>
            <div class="twi_woo_hover2_con">
               <div class="twi-details twi-overlay-panel twi-flex twi-flex-center twi-flex-middle twi-text-center twi-flex-column">
				    <h3 class="twi_pro_title">
					    <a href="#">Product 1</a>
				     </h3>
				     <div class="twi_pro_des">
				         <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
				     </div>
				     <div class="twi-price">
				     	<del><span class="amount"><?php echo get_woocommerce_currency_symbol(); ?>120.00</span></del> 
				     	<ins><span class="amount"><?php echo get_woocommerce_currency_symbol(); ?>100.00</span></ins>
				     </div>
				     <div class="twi-rating">
				     	<i class="twi-icon-star"></i>
				     	<i class="twi-icon-star"></i>
				     	<i class="twi-icon-star"></i>
				     	<i class="twi-icon-star-half-o"></i>
				     	<i class="twi-icon-star-o"></i>
			        </div>
			        <div class="twi_cart">
				     	<a href="#">Add to cart</a>
				    </div>
			 </div>
            </div>
        </div>
    </div>

	<?php return ob_get_clean();
}

VP_Security::instance()->whitelist_function('click_more_pre_dep');

function click_more_pre_dep($value1,$value2)
{
	if( $value1 === 'yes' && $value2 === 'more' )
		return true;
	return false;
}

VP_Security::instance()->whitelist_function('twi_woo_click_bu');

function twi_woo_click_bu($font,$style,$weight,$cl_bg,$cl_bg_ho,$cl_bor_wid,$cl_bor_col,$cl_bor_col_ho,$cl_bor_rad){
	ob_start();
	$gwf   = new VP_Site_GoogleWebFont();
	$gwf->add($font, $style, $weight);
	$links = $gwf->get_font_links();
	$link  = reset($links);
	?>
	 <link href='<?php echo $link; ?>' rel='stylesheet' type='text/css'>
     <style>
         .twi_load_lore_bu{
         	text-decoration: none;
         	font-family: "<?php echo $font; ?>";
         	font-style: <?php echo $style; ?>;
         	font-weight: <?php echo $weight; ?>;
         	margin: 50px auto;
		    text-align: center;
		    width: 150px;
		    background: <?php echo $cl_bg; ?>;
		    border: <?php echo $cl_bor_wid; ?>px solid <?php echo $cl_bor_col; ?>;
		    border-radius: <?php echo $cl_bor_rad; ?>px;
         }
         .twi_load_lore_bu:hover{
         	background: <?php echo $cl_bg_ho; ?>;
         	border: <?php echo $cl_bor_wid; ?>px solid <?php echo $cl_bor_col_ho; ?>;
         }
     </style>
     <div class="twi_load_lore_bu_main">
	     <a href="#" class="twi_load_lore_bu">Load More</a>
     </div>
	<?php return ob_get_clean();
}


?>