<?php
/**
 * Enqueue scripts and stylesheets
 *
 */

function ya_scripts() {	
	$include_css =  ya_options()->getCpanelValue('include_css');
	$scheme_meta = get_post_meta( get_the_ID(), 'scheme', true );
	$scheme 		 = ( $scheme_meta != '' && $scheme_meta != 'none' && is_page() ) ? $scheme_meta : ya_options()->getCpanelValue('scheme');
	$page_metabox_hometemp = get_post_meta( get_the_ID(), 'page_home_template', true );
	
	
	// $css_url = get_template_directory_uri();
	// if( ya_options()->getCpanelValue('developer_mode') ){
		$css_url = get_stylesheet_directory_uri();
	// }
	if ($scheme ){		
		$app_css = $css_url . '/css/app-'.$scheme.'.css';
		if( $page_metabox_hometemp && !$include_css ) {
			$app_css_page = $css_url . '/css/'.$page_metabox_hometemp.'-'.$scheme.'.css';
		}
		if( $include_css ){
			$app_css_page = $css_url . '/css/homepage-'.$scheme.'.css';
		}
	} else {
		$app_css = $css_url . '/css/app-default.css';
		if( $page_metabox_hometemp && !$include_css ) {
			$app_css_page = $css_url . '/css/'.$page_metabox_hometemp.'-default.css';
		}
		if( $include_css ){
			$app_css_page = $css_url . '/css/homepage-default.css';
		}		
	}
	
	
	wp_enqueue_style( 'vino-style-css', get_template_directory_uri() . '/assets/css/style.css' );

	wp_enqueue_style( 'vino-css-slick', get_template_directory_uri() . '/assets/css/slick.css' );

	wp_enqueue_style( 'vino-css-slick-theme', get_template_directory_uri() . '/assets/css/slick-theme.css' );
	
	
	wp_register_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), null);
	wp_register_style('ya_photobox_css', get_template_directory_uri() . '/css/photobox.css', array(), null);	
	wp_register_style('rtl_css', get_template_directory_uri() . '/css/rtl.css', array(), null);
	wp_register_style('ya_theme_css', $app_css, array(), null);
	if( $page_metabox_hometemp || $include_css ) {
		wp_register_style('ya_theme_page', $app_css_page, array(), null);
	}
	wp_register_style('lightbox_css', get_template_directory_uri() . '/css/jquery.fancybox.css', array(), null);
	wp_register_style('ya_theme_responsive_css', get_template_directory_uri() . '/css/app-responsive.css', array(), null);
	/* register script */

	wp_register_script('modernizr', get_template_directory_uri() . '/js/modernizr-2.6.2.min.js', false, null, false);
	wp_register_script('bootstrap_js', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), null, true);
	wp_register_script('photobox_js', get_template_directory_uri() . '/js/photobox.js', array('jquery'), null, true);
	wp_register_script('jquery-cookie', get_template_directory_uri() . '/js/plugins.js', array('jquery'), null, true);	
	wp_register_script('lightbox_js', get_template_directory_uri() . '/js/jquery.fancybox.pack.js', array('jquery'), null, true);
	wp_register_script('ya_accordion',get_template_directory_uri().'/js/jquery.accordion.js',array(),null,true);
	wp_register_script('megamenu_js', get_template_directory_uri() . '/js/megamenu.js', array(), null, true);
	wp_register_script('quantity_js', get_template_directory_uri() . '/js/wc-quantity-increment.min.js', array('jquery'), null, true);
	wp_register_script('ya_theme_js', get_template_directory_uri() . '/js/main.js', array('bootstrap_js'), null, true);
	/* enqueue script & style */
	if ( !is_admin() ){	
		wp_dequeue_style('fontawesome_css');
		wp_dequeue_style('yith-wcwl-font-awesome');
		wp_dequeue_style('tabcontent_styles');
		wp_dequeue_style('slick_slider_css');
		wp_enqueue_style('bootstrap');	
		if( is_rtl() || ya_options()->getCpanelValue('direction') == 'rtl' ){
			wp_enqueue_style('rtl_css');
		}
		wp_enqueue_script('jquery-cookie');
		wp_enqueue_script('lightbox_js');
		wp_enqueue_style('custom_css');
		wp_enqueue_style('slick_css');
		wp_enqueue_style('lightbox_css');
		wp_enqueue_script('slick');
		wp_enqueue_script('masonry_js');
		wp_enqueue_script('quantity_js');
		
		wp_enqueue_style('ya_theme_css');
		wp_enqueue_style('ya_theme_page');
		wp_enqueue_style('ya_theme_responsive_css');
		
		/* Load style.css from child theme */
		if (is_child_theme()) {
			wp_enqueue_style('yatheme_child_css', get_stylesheet_uri(), false, null);
		}
	}
	if (is_single() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}		
	
	$is_category = is_category() && !is_category('blog');
	wp_enqueue_script('modernizr');
	$translation_text = array(
		'cart_text' 		 => esc_html__( 'Add To Cart', 'shoppystore' ),
		'compare_text' 	 => esc_html__( 'Compare', 'shoppystore' ),
		'wishlist_text'  => esc_html__( 'WishList', 'shoppystore' ),
		'quickview_text' => esc_html__( 'QuickView', 'shoppystore' ),
		'ajax_url' => admin_url( 'admin-ajax.php', 'relative' ), 
		'redirect' => get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ),
		'message' => esc_html__( 'Please enter your usename and password', 'shoppystore' ),
	);

	wp_localize_script( 'ya_theme_js', 'custom_text', $translation_text ); 
	wp_enqueue_script( 'ya_theme_js', get_template_directory_uri() . '/js/main.js', array(), null, true );
	
	if( ya_options()-> getCpanelValue( 'menu_type' ) == 'mega' ){
		wp_enqueue_script('megamenu_js');	
	}
	
	/*
	** Preload
	*/
	$preload_page = ya_options()->getCpanelValue( 'preload_active_page' );
	$page_id = get_the_ID();
	if( 1 == ya_options()->getCpanelValue( 'preload_active' ) &&( is_array( $preload_page ) && in_array( $page_id, $preload_page ) ) ){
		wp_enqueue_script('preload_script', get_template_directory_uri() . '/js/pathLoader.js', array(), null, true);
	}
	
	/*
	** Maintaince Mode
	*/
	if( !is_user_logged_in() && ya_options()->getCpanelValue('maintaince_enable') ){ 
		$output = '';
		$countdown = ya_options()->getCpanelValue('maintaince_date');
		if( $countdown != '' ):
			$output .= 'jQuery(function($){
			"use strict";
			function ya_check_height(){
				var W_height = $( window ).height();
				if( W_height > 767) {
					setTimeout(function(){
						var cm_height = $( window ).height();
						var cm_target = $( "body > .body-wrapper" );
						cm_target.css( "height", cm_height );
					}, 1000);
				}
			}
			$(window).on( "load", function(){
				ya_check_height();
			});
				$(document).ready(function(){ 
					var end_date = new Date( "'. esc_js( $countdown ) .'" ).getTime()/1000;
					$("#countdown-container").ClassyCountdown({
						theme: "white", 
						end: end_date, 
						now: $.now()/1000,
						labelsOptions: {
							lang: {
							days: "Days",
							hours: "Hours",
							minutes: "Mins",
							seconds: "Secs"
							},
							style: "font-size: 0.5em;"
						},
					});
				});
			});';
		endif;
		wp_enqueue_style('countdown_css', get_template_directory_uri() . '/css/jquery.classycountdown.min.css', array(), null);
		wp_enqueue_style('maintaince_css', get_template_directory_uri() . '/css/style-maintaince.css', array(), null);
		wp_register_script('countdown',get_template_directory_uri(). '/js/maintaince/jquery.classycountdown.min.js', array(), null, true);
		wp_enqueue_script( 'knob', get_template_directory_uri(). '/js/maintaince/jquery.knob.js', array(), null, true);	
		wp_enqueue_script( 'throttle',get_template_directory_uri() . '/js/maintaince/jquery.throttle.js', array(), null, true);	
		wp_enqueue_script( 'countdown' );
		wp_add_inline_script( 'countdown', $output );
	}
	
	
	/*
	** Dequeue and enqueue css, js mobile
	*/
	if( ya_mobile_check() ) :
		if( is_front_page() || is_home() ) :
			wp_dequeue_script( 'prettyPhoto' );
			wp_dequeue_script( 'prettyPhoto-init' );
			wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
		endif;
		
		if( !ya_options()->getCpanelValue( 'mobile_jquery' ) ) :
			wp_dequeue_script( 'tp-tools' );
			wp_dequeue_script( 'revmin' );
		endif;
		
		$overflow_text = array(
			'more_text' => esc_html__( 'More...', 'shoppystore' ),
		);
		wp_register_script('menu-overflow', get_template_directory_uri() . '/js/menu-overflow.js', array(), null, true);
		wp_localize_script( 'menu-overflow', 'menu_text', $overflow_text );
		wp_enqueue_script( 'menu-overflow' );
		
		wp_dequeue_style( 'jquery-colorbox' );
		wp_dequeue_style( 'colorbox' );
		wp_dequeue_script( 'jquery-colorbox' );
		wp_dequeue_script( 'isotope_script' );
		wp_dequeue_script( 'megamenu_js' );
		wp_dequeue_script( 'moneyjs' );
		wp_dequeue_script( 'preload_script' );
		wp_dequeue_script( 'accountingjs' );
		wp_dequeue_script( 'yith-woocompare-main' );
	endif;
}
add_action('wp_enqueue_scripts', 'ya_scripts', 100);
