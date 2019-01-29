<?php
$twi_woo_style = vp_metabox('twi_woo_mb_main.twi_woo_g_c_style');
$twi_woo_cats = vp_metabox('twi_woo_mb_main.cat');
$twi_temp_style = vp_metabox('twi_woo_mb_main.twi_temp_style');
$twi_woo_filter_main = vp_metabox('twi_woo_mb_main.twi_woo_filter_main');
$twi_woo_per_page = vp_metabox('twi_woo_mb_main.per_page');
$twi_full = vp_metabox('twi_woo_mb_main.forced_full_screen');
$cart_hide = vp_metabox('twi_woo_mb_main.cart');
$woo_orby = vp_metabox('twi_woo_mb_main.twi_pro_orderby');
$woo_order = vp_metabox('twi_woo_mb_main.twi_pro_order');
$gap = vp_metabox('twi_woo_mb_main.twi_woo_grid_gap');
$gutter = vp_metabox('twi_woo_mb_main.woo_gutter');

// Version 5.0
if($twi_woo_style != 'twi_woo_mansonry'){
    $woo_img_sizes = vp_option("twi_woo_options.woo_img_sizes");
}else{
    $woo_img_sizes = 'twi_woo_masonry';
}
$just_mar = vp_metabox('twi_woo_mb_main.just_mar');
$pro_dis_style = vp_metabox('twi_woo_mb_main.pro_dis_style');
if($pro_dis_style == NULL){
    $pro_dis_style == 'cat_wise';
}else{
    $pro_dis_style = vp_metabox('twi_woo_mb_main.pro_dis_style');
}
$spe_pro = vp_metabox('twi_woo_mb_main.spe_pro');

$woo_des = vp_metabox('twi_woo_mb_main.des');

$ti_hide = vp_metabox('twi_woo_mb_main.title');
if($ti_hide == NULL){
	$ti_hide = 'yes';
}else{
    $ti_hide = vp_metabox('twi_woo_mb_main.title');
}

$pr_hide = vp_metabox('twi_woo_mb_main.price_h_s');
if($pr_hide == NULL){
    $pr_hide = 'yes';
}else{
    $pr_hide = vp_metabox('twi_woo_mb_main.price_h_s');
}

$ra_hide = vp_metabox('twi_woo_mb_main.rating');
if($ra_hide == NULL){
   $ra_hide = 'yes';
}else{
   $ra_hide = vp_metabox('twi_woo_mb_main.rating');
}
$pagi_type = vp_metabox('twi_woo_mb_main.twi_woo_grid_group.0.pagi_type');
if( $pagi_type == null ){
    $pagi_type = "nor_page";
}else{
   $pagi_type = vp_metabox('twi_woo_mb_main.twi_woo_grid_group.0.pagi_type');
}
$cat_type = vp_metabox('twi_woo_mb_main.cat_type');
$sub_cat_dis = vp_metabox('twi_woo_mb_main.sub_cat_dis');
$twi_woo_preloader = vp_metabox('twi_woo_mb_main.preloader');
$load_txt = vp_metabox('twi_woo_mb_main.twi_woo_grid_group.0.twi_load_more_group.0.load_txt');
$up_loader = vp_metabox('twi_woo_mb_main.twi_woo_grid_group.0.twi_load_more_group.0.up_loader');
$done_txt = vp_metabox('twi_woo_mb_main.twi_woo_grid_group.0.twi_load_more_group.0.done_txt');

//Grids
$xlarge = vp_metabox('twi_woo_mb_main.twi_woo_grid_group.0.twi_woo_grid_desktop_big');
$large = vp_metabox('twi_woo_mb_main.twi_woo_grid_group.0.twi_woo_grid_desktop');
$medium = vp_metabox('twi_woo_mb_main.twi_woo_grid_group.0.twi_woo_grid_tablet');
$small = vp_metabox('twi_woo_mb_main.twi_woo_grid_group.0.twi_woo_grid_phone_big');
$default = vp_metabox('twi_woo_mb_main.twi_woo_grid_group.0.twi_woo_grid_phone');
$car_pagi = vp_metabox('twi_woo_mb_main.twi_woo_grid_group.0.pagination');

// Slider/Carousel
$autoplay = vp_metabox('twi_woo_mb_main.twi_carousel_group.0.autoplay');
$auto_time = vp_metabox('twi_woo_mb_main.twi_carousel_group.0.autoplaytime');
$items_gap = vp_metabox('twi_woo_mb_main.items_gap');
$l_desk = vp_metabox('twi_woo_mb_main.twi_carousel_group.0.large_desktop');
$desk = vp_metabox('twi_woo_mb_main.twi_carousel_group.0.desktop');
$tablet = vp_metabox('twi_woo_mb_main.twi_carousel_group.0.tablet');
$phone_big = vp_metabox('twi_woo_mb_main.twi_carousel_group.0.phone_big');
$phone = vp_metabox('twi_woo_mb_main.twi_carousel_group.0.phone');
$car_nav = vp_metabox('twi_woo_mb_main.twi_carousel_group.0.car_nav');
$car_page = vp_metabox('twi_woo_mb_main.twi_carousel_group.0.car_page');
$car_hover = vp_metabox('twi_woo_mb_main.twi_carousel_group.0.car_hover');
$nav_pos = vp_metabox('twi_woo_mb_main.twi_carousel_group.0.car_nav_group.0.nav_pos');
$nav_bg = vp_metabox('twi_woo_mb_main.twi_carousel_group.0.car_nav_group.0.nav_bg');
$nav_txt = vp_metabox('twi_woo_mb_main.twi_carousel_group.0.car_nav_group.0.nav_txt');
$nav_border = vp_metabox('twi_woo_mb_main.twi_carousel_group.0.car_nav_group.0.nav_border');
$nav_bor_wid = vp_metabox('twi_woo_mb_main.twi_carousel_group.0.car_nav_group.0.nav_bor_wid');
$nav_bg_h = vp_metabox('twi_woo_mb_main.twi_carousel_group.0.car_nav_group.0.nav_bg_h');
$nav_txt_h = vp_metabox('twi_woo_mb_main.twi_carousel_group.0.car_nav_group.0.nav_txt_h');
$nav_border_h = vp_metabox('twi_woo_mb_main.twi_carousel_group.0.car_nav_group.0.nav_border_h');
$nav_bor_rad = vp_metabox('twi_woo_mb_main.twi_carousel_group.0.car_nav_group.0.nav_bor_rad');
$pagi_bg = vp_metabox('twi_woo_mb_main.twi_carousel_group.0.car_page_group.0.pagi_bg');
$pagi_border = vp_metabox('twi_woo_mb_main.twi_carousel_group.0.car_page_group.0.pagi_border');
$pagi_bor_wid = vp_metabox('twi_woo_mb_main.twi_carousel_group.0.car_page_group.0.pagi_bor_wid');
$pagi_bg_h = vp_metabox('twi_woo_mb_main.twi_carousel_group.0.car_page_group.0.pagi_bg_h');
$pagi_border_h = vp_metabox('twi_woo_mb_main.twi_carousel_group.0.car_page_group.0.pagi_border_h');
$pagi_bor_rad = vp_metabox('twi_woo_mb_main.twi_carousel_group.0.car_page_group.0.pagi_bor_rad');
// Version 5.0
$row_count = vp_metabox('twi_woo_mb_main.row_count');
if( $row_count === '' ){
   $row_count = 1;
}else{
   $row_count = vp_metabox('twi_woo_mb_main.row_count');
}


// Slide Set
$slide_set_xlarge = vp_metabox('twi_woo_mb_main.twi_woo_slideset_group.0.large_desktop');
$slide_set_large = vp_metabox('twi_woo_mb_main.twi_woo_slideset_group.0.desktop');
$slide_set_medium = vp_metabox('twi_woo_mb_main.twi_woo_slideset_group.0.tablet');
$slide_set_small = vp_metabox('twi_woo_mb_main.twi_woo_slideset_group.0.phone_big');
$slide_set_autoplay = vp_metabox('twi_woo_mb_main.twi_woo_slideset_group.0.autoplay');
$slide_set_autoplaytime = vp_metabox('twi_woo_mb_main.twi_woo_slideset_group.0.autoplaytime')*1000;
$slide_set_animation = vp_metabox('twi_woo_mb_main.twi_woo_slideset_group.0.animation');
$slide_set_nav = vp_metabox('twi_woo_mb_main.twi_woo_slideset_group.0.nav');
$slide_set_page = vp_metabox('twi_woo_mb_main.twi_woo_slideset_group.0.page');
$slide_set_forced_cen = vp_metabox('twi_woo_mb_main.twi_woo_slideset_group.0.forced_cen');
$slide_set_hover_pause = vp_metabox('twi_woo_mb_main.twi_woo_slideset_group.0.hover_pause');

//Pagination
 $car_pagi_pos = vp_metabox('twi_woo_mb_main.twi_woo_grid_group.0.grid_pagi_settings.0.grid_pagi_pos');
 $text1 = vp_metabox('twi_woo_mb_main.twi_woo_grid_group.0.grid_pagi_settings.0.text1');
 $text2 = vp_metabox('twi_woo_mb_main.twi_woo_grid_group.0.grid_pagi_settings.0.text2');
 $bg1 = vp_metabox('twi_woo_mb_main.twi_woo_grid_group.0.grid_pagi_settings.0.bg1');
 $twi_bg2 = vp_metabox('twi_woo_mb_main.twi_woo_grid_group.0.grid_pagi_settings.0.bg2');
 $bor_col1 = vp_metabox('twi_woo_mb_main.twi_woo_grid_group.0.grid_pagi_settings.0.bor_col1');
 $bor_col2 = vp_metabox('twi_woo_mb_main.twi_woo_grid_group.0.grid_pagi_settings.0.bor_col2');
 $bor_width1 = vp_metabox('twi_woo_mb_main.twi_woo_grid_group.0.grid_pagi_settings.0.bor_width1');
 $bor_width2 = vp_metabox('twi_woo_mb_main.twi_woo_grid_group.0.grid_pagi_settings.0.bor_width2');
 $bor_rad = vp_metabox('twi_woo_mb_main.twi_woo_grid_group.0.grid_pagi_settings.0.bor_rad');
 $pad = vp_metabox('twi_woo_mb_main.twi_woo_grid_group.0.grid_pagi_settings.0.pad');

 //Normal
 if($twi_temp_style == 'normal'):
 $nor_font = vp_metabox('twi_woo_mb_main.nor_preview_group.0.font');
 $nor_style = vp_metabox('twi_woo_mb_main.nor_preview_group.0.style');
 $nor_weight = vp_metabox('twi_woo_mb_main.nor_preview_group.0.weight');
 $nor_con_pos = vp_metabox('twi_woo_mb_main.nor_preview_group.0.nor_con_pos');
 $fo_color = vp_metabox('twi_woo_mb_main.nor_preview_group.0.fo_color');
 $fo_size = vp_metabox('twi_woo_mb_main.nor_preview_group.0.fo_size');
 $nor_bg = vp_metabox('twi_woo_mb_main.nor_preview_group.0.nor_bg');
 $nor_border_width = vp_metabox('twi_woo_mb_main.nor_preview_group.0.nor_border_width');
 $nor_bor_col = vp_metabox('twi_woo_mb_main.nor_preview_group.0.nor_bor_col');
 $h3_txt_trans = vp_metabox('twi_woo_mb_main.nor_preview_group.0.h3_txt_trans');
 $h3_col = vp_metabox('twi_woo_mb_main.nor_preview_group.0.h3_col');
 $h3_col_hover = vp_metabox('twi_woo_mb_main.nor_preview_group.0.h3_col_hover');
 $h3_font_size = vp_metabox('twi_woo_mb_main.nor_preview_group.0.h3_font_size');
 $cart_bor_wid = vp_metabox('twi_woo_mb_main.nor_preview_group.0.cart_bor_wid');
 $cart_bor = vp_metabox('twi_woo_mb_main.nor_preview_group.0.cart_bor');
 $cart_bor_hover = vp_metabox('twi_woo_mb_main.nor_preview_group.0.cart_bor_hover');
 $cart_col = vp_metabox('twi_woo_mb_main.nor_preview_group.0.cart_col');
 $cart_col_hover = vp_metabox('twi_woo_mb_main.nor_preview_group.0.cart_col_hover');
 $cart_txt_trans = vp_metabox('twi_woo_mb_main.nor_preview_group.0.cart_txt_trans');
 $cart_bg = vp_metabox('twi_woo_mb_main.nor_preview_group.0.cart_bg');
 $cart_bg_hover = vp_metabox('twi_woo_mb_main.nor_preview_group.0.cart_bg_hover');
 $cart_bor_rad = vp_metabox('twi_woo_mb_main.nor_preview_group.0.cart_bor_rad');
 $cart_fo_size = vp_metabox('twi_woo_mb_main.nor_preview_group.0.cart_fo_size');
 $star_color = vp_metabox('twi_woo_mb_main.nor_preview_group.0.star_color');
 $st_si = vp_metabox('twi_woo_mb_main.nor_preview_group.0.st_si');
 $sale_txt = vp_metabox('twi_woo_mb_main.nor_preview_group.0.sale_txt');
 $sale_bg = vp_metabox('twi_woo_mb_main.nor_preview_group.0.sale_bg');
 $out_txt = vp_metabox('twi_woo_mb_main.nor_preview_group.0.out_txt');
 $out_bg = vp_metabox('twi_woo_mb_main.nor_preview_group.0.out_bg');
 $fe_txt = vp_metabox('twi_woo_mb_main.nor_preview_group.0.fe_txt');
 $fe_bg = vp_metabox('twi_woo_mb_main.nor_preview_group.0.fe_bg');
 $nor_border = vp_metabox('twi_woo_mb_main.nor_preview_group.0.nor_border');
 // Version 5.0.0
 $nor_des_col = vp_metabox('twi_woo_mb_main.nor_preview_group.0.des_col');
 $nor_des_font_size = vp_metabox('twi_woo_mb_main.nor_preview_group.0.des_font_size');
 $nor_des_line_height = vp_metabox('twi_woo_mb_main.nor_preview_group.0.des_line_height');
 endif;


 //Image Only
 if($twi_temp_style == 'img_only'):
 $nor_font = vp_metabox('twi_woo_mb_main.img_preview_group.0.font');
 $nor_style = vp_metabox('twi_woo_mb_main.img_preview_group.0.style');
 $nor_weight = vp_metabox('twi_woo_mb_main.img_preview_group.0.weight');
 $fo_color = vp_metabox('twi_woo_mb_main.img_preview_group.0.fo_color');
 $fo_size = vp_metabox('twi_woo_mb_main.img_preview_group.0.fo_size');
 $nor_border_width = vp_metabox('twi_woo_mb_main.img_preview_group.0.nor_border_width');
 $nor_bor_col = vp_metabox('twi_woo_mb_main.img_preview_group.0.nor_bor_col');
 $sale_txt = vp_metabox('twi_woo_mb_main.img_preview_group.0.sale_txt');
 $sale_bg = vp_metabox('twi_woo_mb_main.img_preview_group.0.sale_bg');
 $out_txt = vp_metabox('twi_woo_mb_main.img_preview_group.0.out_txt');
 $out_bg = vp_metabox('twi_woo_mb_main.img_preview_group.0.out_bg');
 $fe_txt = vp_metabox('twi_woo_mb_main.img_preview_group.0.fe_txt');
 $fe_bg = vp_metabox('twi_woo_mb_main.img_preview_group.0.fe_bg');
 $nor_border = vp_metabox('twi_woo_mb_main.img_preview_group.0.nor_border');
 endif;

//Hover
 if($twi_temp_style == 'hover'):
 $ho_font = vp_metabox('twi_woo_mb_main.hover_preview_group.0.font');
 $ho_style = vp_metabox('twi_woo_mb_main.hover_preview_group.0.style');
 $ho_weight = vp_metabox('twi_woo_mb_main.hover_preview_group.0.weight');
 $over_eff_ho = vp_metabox('twi_woo_mb_main.hover_preview_group.0.over_eff');
 $ho_cap_bg = vp_metabox('twi_woo_mb_main.hover_preview_group.0.nor_bg');
 $ho_img_eff = vp_metabox('twi_woo_mb_main.hover_preview_group.0.img_eff');
 $cart_an = vp_metabox('twi_woo_mb_main.hover_preview_group.0.cart_an');
 $title_an = vp_metabox('twi_woo_mb_main.hover_preview_group.0.title_an');
 $price_an = vp_metabox('twi_woo_mb_main.hover_preview_group.0.price_an');
 $rating_an = vp_metabox('twi_woo_mb_main.hover_preview_group.0.rating_an');
 $nor_border_width_ho = vp_metabox('twi_woo_mb_main.hover_preview_group.0.nor_border_width');
 $nor_bor_col_ho = vp_metabox('twi_woo_mb_main.hover_preview_group.0.nor_bor_col');
 $nor_border_ho = vp_metabox('twi_woo_mb_main.hover_preview_group.0.nor_border');
 $h3_txt_trans_ho = vp_metabox('twi_woo_mb_main.hover_preview_group.0.h3_txt_trans');
 $h3_col = vp_metabox('twi_woo_mb_main.hover_preview_group.0.h3_col');
 $h3_col_ho = vp_metabox('twi_woo_mb_main.hover_preview_group.0.h3_col_hover');
 $h3_font_size_ho = vp_metabox('twi_woo_mb_main.hover_preview_group.0.h3_font_size');
 $fo_size = vp_metabox('twi_woo_mb_main.hover_preview_group.0.fo_size');
 $fo_col = vp_metabox('twi_woo_mb_main.hover_preview_group.0.fo_color');
 $rt_size = vp_metabox('twi_woo_mb_main.hover_preview_group.0.st_si');
 $rt_col = vp_metabox('twi_woo_mb_main.hover_preview_group.0.star_color');
 $cart_col = vp_metabox('twi_woo_mb_main.hover_preview_group.0.cart_col');
 $cart_col_hover = vp_metabox('twi_woo_mb_main.hover_preview_group.0.cart_col_hover');
 $cart_bor_wid_ho = vp_metabox('twi_woo_mb_main.hover_preview_group.0.cart_bor_wid');
 $cart_bor = vp_metabox('twi_woo_mb_main.hover_preview_group.0.cart_bor');
 $cart_bor_hover = vp_metabox('twi_woo_mb_main.hover_preview_group.0.cart_bor_hover');
 $cart_txt_trans_ho = vp_metabox('twi_woo_mb_main.hover_preview_group.0.cart_txt_trans');
 $cart_bg = vp_metabox('twi_woo_mb_main.hover_preview_group.0.cart_bg');
 $cart_bg_hover = vp_metabox('twi_woo_mb_main.hover_preview_group.0.cart_bg_hover');
 $cart_fo_size_ho = vp_metabox('twi_woo_mb_main.hover_preview_group.0.cart_fo_size');
 $cart_bor_rad_ho = vp_metabox('twi_woo_mb_main.hover_preview_group.0.cart_bor_rad');
 $sale_txt_ho = vp_metabox('twi_woo_mb_main.hover_preview_group.0.sale_txt');
 $sale_bg_ho = vp_metabox('twi_woo_mb_main.hover_preview_group.0.sale_bg');
 $out_txt_ho = vp_metabox('twi_woo_mb_main.hover_preview_group.0.out_txt');
 $out_bg_ho = vp_metabox('twi_woo_mb_main.hover_preview_group.0.out_bg');
 $fe_txt_ho = vp_metabox('twi_woo_mb_main.hover_preview_group.0.fe_txt');
 $fe_bg_ho = vp_metabox('twi_woo_mb_main.hover_preview_group.0.fe_bg');
 // Version 5.0.0
 $ho_des_col = vp_metabox('twi_woo_mb_main.hover_preview_group.0.des_col');
 $ho_des_font_size = vp_metabox('twi_woo_mb_main.hover_preview_group.0.des_font_size');
 $ho_des_line_height = vp_metabox('twi_woo_mb_main.hover_preview_group.0.des_line_height');
 $des_an = vp_metabox('twi_woo_mb_main.hover_preview_group.0.des_an');
 endif;

 //Hover 2 - Version 5.0.0
 if($twi_temp_style == 'hover2'):
 $ho2_font = vp_metabox('twi_woo_mb_main.hover2_preview_group.0.font');
 $ho2_style = vp_metabox('twi_woo_mb_main.hover2_preview_group.0.style');
 $ho2_weight = vp_metabox('twi_woo_mb_main.hover2_preview_group.0.weight');
 $ho2_over_eff_ho = vp_metabox('twi_woo_mb_main.hover2_preview_group.0.overlay_eff');
 $ho2_ho_cap_bg = vp_metabox('twi_woo_mb_main.hover2_preview_group.0.nor_bg');
 $ho2_ho_img_eff = vp_metabox('twi_woo_mb_main.hover2_preview_group.0.img_eff');
 $ho2_cart_an = vp_metabox('twi_woo_mb_main.hover2_preview_group.0.cart_an');
 $ho2_title_an = vp_metabox('twi_woo_mb_main.hover2_preview_group.0.title_an');
 $ho2_price_an = vp_metabox('twi_woo_mb_main.hover2_preview_group.0.price_an');
 $ho2_rating_an = vp_metabox('twi_woo_mb_main.hover2_preview_group.0.rating_an');
 $ho2_nor_border_width_ho = vp_metabox('twi_woo_mb_main.hover2_preview_group.0.nor_border_width');
 $ho2_nor_bor_col_ho = vp_metabox('twi_woo_mb_main.hover2_preview_group.0.nor_bor_col');
 $ho2_nor_border_ho = vp_metabox('twi_woo_mb_main.hover2_preview_group.0.nor_border');
 $ho2_h3_txt_trans_ho = vp_metabox('twi_woo_mb_main.hover2_preview_group.0.h3_txt_trans');
 $ho2_h3_col = vp_metabox('twi_woo_mb_main.hover2_preview_group.0.h3_col');
 $ho2_h3_col_ho = vp_metabox('twi_woo_mb_main.hover2_preview_group.0.h3_col_hover');
 $ho2_h3_font_size_ho = vp_metabox('twi_woo_mb_main.hover2_preview_group.0.h3_font_size');
 $ho2_fo_size = vp_metabox('twi_woo_mb_main.hover2_preview_group.0.fo_size');
 $ho2_fo_col = vp_metabox('twi_woo_mb_main.hover2_preview_group.0.fo_color');
 $ho2_rt_size = vp_metabox('twi_woo_mb_main.hover2_preview_group.0.st_si');
 $ho2_rt_col = vp_metabox('twi_woo_mb_main.hover2_preview_group.0.star_color');
 $ho2_cart_col = vp_metabox('twi_woo_mb_main.hover2_preview_group.0.cart_col');
 $ho2_cart_col_hover = vp_metabox('twi_woo_mb_main.hover2_preview_group.0.cart_col_hover');
 $ho2_cart_bor_wid_ho = vp_metabox('twi_woo_mb_main.hover2_preview_group.0.cart_bor_wid');
 $ho2_cart_bor = vp_metabox('twi_woo_mb_main.hover2_preview_group.0.cart_bor');
 $ho2_cart_bor_hover = vp_metabox('twi_woo_mb_main.hover2_preview_group.0.cart_bor_hover');
 $ho2_cart_txt_trans_ho = vp_metabox('twi_woo_mb_main.hover2_preview_group.0.cart_txt_trans');
 $ho2_cart_bg = vp_metabox('twi_woo_mb_main.hover2_preview_group.0.cart_bg');
 $ho2_cart_bg_hover = vp_metabox('twi_woo_mb_main.hover2_preview_group.0.cart_bg_hover');
 $ho2_cart_fo_size_ho = vp_metabox('twi_woo_mb_main.hover2_preview_group.0.cart_fo_size');
 $ho2_cart_bor_rad_ho = vp_metabox('twi_woo_mb_main.hover2_preview_group.0.cart_bor_rad');
 $ho2_sale_txt_ho = vp_metabox('twi_woo_mb_main.hover2_preview_group.0.sale_txt');
 $ho2_sale_bg_ho = vp_metabox('twi_woo_mb_main.hover2_preview_group.0.sale_bg');
 $ho2_out_txt_ho = vp_metabox('twi_woo_mb_main.hover2_preview_group.0.out_txt');
 $ho2_out_bg_ho = vp_metabox('twi_woo_mb_main.hover2_preview_group.0.out_bg');
 $ho2_fe_txt_ho = vp_metabox('twi_woo_mb_main.hover2_preview_group.0.fe_txt');
 $ho2_fe_bg_ho = vp_metabox('twi_woo_mb_main.hover2_preview_group.0.fe_bg');
 // Version 5.0.0
 $ho2_ho_des_col = vp_metabox('twi_woo_mb_main.hover2_preview_group.0.des_col');
 $ho2_ho_des_font_size = vp_metabox('twi_woo_mb_main.hover2_preview_group.0.des_font_size');
 $ho2_ho_des_line_height = vp_metabox('twi_woo_mb_main.hover2_preview_group.0.des_line_height');
 $ho2_des_an = vp_metabox('twi_woo_mb_main.hover2_preview_group.0.des_an');
 endif;

// Overlay
 if($twi_temp_style == 'overlay'):
 $over_font = vp_metabox('twi_woo_mb_main.over_preview_group.0.font');
 $over_style = vp_metabox('twi_woo_mb_main.over_preview_group.0.style');
 $over_weight = vp_metabox('twi_woo_mb_main.over_preview_group.0.weight');
 $over_cap_bg = vp_metabox('twi_woo_mb_main.over_preview_group.0.nor_bg');
 $nor_border_width_over = vp_metabox('twi_woo_mb_main.over_preview_group.0.nor_border_width');
 $nor_bor_col_over = vp_metabox('twi_woo_mb_main.over_preview_group.0.nor_bor_col');
 $nor_border_over = vp_metabox('twi_woo_mb_main.over_preview_group.0.nor_border');
 $h3_txt_trans_over = vp_metabox('twi_woo_mb_main.over_preview_group.0.h3_txt_trans');
 $h3_col = vp_metabox('twi_woo_mb_main.over_preview_group.0.h3_col');
 $h3_col_over = vp_metabox('twi_woo_mb_main.over_preview_group.0.h3_col_hover');
 $h3_font_size_over = vp_metabox('twi_woo_mb_main.over_preview_group.0.h3_font_size');
 $fo_size = vp_metabox('twi_woo_mb_main.over_preview_group.0.fo_size');
 $fo_col = vp_metabox('twi_woo_mb_main.over_preview_group.0.fo_color');
 $rt_size = vp_metabox('twi_woo_mb_main.over_preview_group.0.st_si');
 $rt_col = vp_metabox('twi_woo_mb_main.over_preview_group.0.star_color');
 $cart_col = vp_metabox('twi_woo_mb_main.over_preview_group.0.cart_col');
 $cart_col_over = vp_metabox('twi_woo_mb_main.over_preview_group.0.cart_col_hover');
 $cart_bor_wid_over = vp_metabox('twi_woo_mb_main.over_preview_group.0.cart_bor_wid');
 $cart_bor = vp_metabox('twi_woo_mb_main.over_preview_group.0.cart_bor');
 $cart_bor_over = vp_metabox('twi_woo_mb_main.over_preview_group.0.cart_bor_hover');
 $cart_txt_trans_over = vp_metabox('twi_woo_mb_main.over_preview_group.0.cart_txt_trans');
 $cart_bg = vp_metabox('twi_woo_mb_main.over_preview_group.0.cart_bg');
 $cart_bg_over = vp_metabox('twi_woo_mb_main.over_preview_group.0.cart_bg_hover');
 $cart_fo_size_over = vp_metabox('twi_woo_mb_main.over_preview_group.0.cart_fo_size');
 $cart_bor_rad_over = vp_metabox('twi_woo_mb_main.over_preview_group.0.cart_bor_rad');
 $sale_txt_over = vp_metabox('twi_woo_mb_main.over_preview_group.0.sale_txt');
 $sale_bg_over = vp_metabox('twi_woo_mb_main.over_preview_group.0.sale_bg');
 $out_txt_over = vp_metabox('twi_woo_mb_main.over_preview_group.0.out_txt');
 $out_bg_over = vp_metabox('twi_woo_mb_main.over_preview_group.0.out_bg');
 $fe_txt_over = vp_metabox('twi_woo_mb_main.over_preview_group.0.fe_txt');
 $fe_bg_over = vp_metabox('twi_woo_mb_main.over_preview_group.0.fe_bg');
 // Version 5.0.0
 $over_des_col = vp_metabox('twi_woo_mb_main.over_preview_group.0.des_col');
 $over_des_font_size = vp_metabox('twi_woo_mb_main.over_preview_group.0.des_font_size');
 $over_des_line_height = vp_metabox('twi_woo_mb_main.over_preview_group.0.des_line_height');
 endif;
 
// Others
$out_pos = vp_metabox('twi_woo_mb_main.twi_woo_rib_main.0.twi_out_lab_pos');
$fe_pos = vp_metabox('twi_woo_mb_main.twi_woo_rib_main.0.twi_fe_lab_pos');
$rib_dis = vp_metabox('twi_woo_mb_main.twi_woo_rib_main.0.twi_rib_dis');

// Click Load More Button
if( $pagi_type == 'more' ){
   $font_cl = vp_metabox('twi_woo_mb_main.twi_woo_grid_group.0.twi_woo_click_load_more.0.font');
   if( $font_cl == NULL ){
      $font_cl = 'Roboto'; 
   }else{
      $font_cl = vp_metabox('twi_woo_mb_main.twi_woo_grid_group.0.twi_woo_click_load_more.0.font');   
   }
   $style_cl = vp_metabox('twi_woo_mb_main.twi_woo_grid_group.0.twi_woo_click_load_more.0.style');
   $weight_cl = vp_metabox('twi_woo_mb_main.twi_woo_grid_group.0.twi_woo_click_load_more.0.weight');
   $cl_bg = vp_metabox('twi_woo_mb_main.twi_woo_grid_group.0.twi_woo_click_load_more.0.cl_bg');
   $cl_bg_ho = vp_metabox('twi_woo_mb_main.twi_woo_grid_group.0.twi_woo_click_load_more.0.cl_bg_ho');
   $cl_bor_wid = vp_metabox('twi_woo_mb_main.twi_woo_grid_group.0.twi_woo_click_load_more.0.cl_bor_wid');
   $cl_bor_col = vp_metabox('twi_woo_mb_main.twi_woo_grid_group.0.twi_woo_click_load_more.0.cl_bor_col');
   $cl_bor_col_ho = vp_metabox('twi_woo_mb_main.twi_woo_grid_group.0.twi_woo_click_load_more.0.cl_bor_col_ho');
   $cl_bor_rad = vp_metabox('twi_woo_mb_main.twi_woo_grid_group.0.twi_woo_click_load_more.0.cl_bor_rad');
   $cl_fo_col = vp_metabox('twi_woo_mb_main.twi_woo_grid_group.0.twi_woo_click_load_more.0.cl_fo_col');
   $cl_fo_col_ho = vp_metabox('twi_woo_mb_main.twi_woo_grid_group.0.twi_woo_click_load_more.0.cl_fo_col_ho');
}
?>