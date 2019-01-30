<?php  

if ( !defined('SW_THEME') ){
	define( 'SW_THEME', 'shoppystore' );
}
/**
 * Variables
 */
require_once (get_template_directory().'/lib/defines.php');

/**
 * Roots includes
 */
require_once (get_template_directory().'/lib/classes.php');		// Utility functions
require_once (get_template_directory().'/lib/utils.php');			// Utility functions
require_once (get_template_directory().'/lib/init.php');			// Initial theme setup and constants
require_once (get_template_directory().'/lib/mobile-layout.php');
require_once (get_template_directory().'/lib/cleanup.php');		// Cleanup
require_once (get_template_directory().'/lib/nav.php');			// Custom nav modifications
require_once (get_template_directory().'/lib/widgets.php');		// Sidebars and widgets
require_once (get_template_directory().'/lib/scripts.php');		// Scripts and stylesheets
require_once (get_template_directory().'/lib/plugin-requirement.php');			// Custom functions
require_once (get_template_directory().'/lib/metabox.php');	// Custom functions
require_once ( get_template_directory().'/lib/import/sw-import.php' );

if( class_exists( 'WooCommerce' ) ){
	require_once (get_template_directory().'/lib/plugins/currency-converter/currency-converter.php'); // currency converter
	require_once (get_template_directory().'/lib/woocommerce-hook.php');	// Utility functions
	if( class_exists( 'WC_Vendors' ) ) :
		require_once ( get_template_directory().'/lib/wc-vendor-hook.php' );			/** WC Vendor **/
	endif;
	
	if( class_exists( 'WeDevs_Dokan' ) ) :
		require_once ( get_template_directory().'/lib/dokan-vendor-hook.php' );			/** Dokan Vendor **/
	endif;
	
	if( class_exists( 'WCMp' ) ) :
		require_once ( get_template_directory().'/lib/wc-marketplace-hook.php' );			/** WC MarketPlace Vendor **/
	endif;
}

/* add image thumbnail latest blog */
add_image_size( 'ya-latest-blog', 316, 255, true);
add_image_size('shop-recommend', 170, 126, true);
add_image_size( 'ya_cat_thumb_mobile', 210, 270, true );
function ya_template_load( $template ){ 
	if( !is_user_logged_in() && ya_options()->getCpanelValue('maintaince_enable') ){
		$template = get_template_part( 'maintaince' );
	}
	return $template;
}

add_filter( 'template_include', 'ya_template_load' );
add_filter('the_content', 'do_shortcode');
add_filter('widget_text', 'do_shortcode');

function vino_scripts() {
	/*
   * Подключаем стили:
   * Аргументы:
   * 1) название стиля (может быть любым)
   * 2) путь к файлу
   */
	// для локальных стилей
//
//	wp_enqueue_style( 'vino-style-css', get_template_directory_uri() . '/assets/css/style.css' );
//
//	wp_enqueue_style( 'vino-css-slick', get_template_directory_uri() . '/assets/css/slick.css' );
//
//	wp_enqueue_style( 'vino-css-slick-theme', get_template_directory_uri() . '/assets/css/slick-theme.css' );

//	wp_enqueue_script( 'vino-jquery', get_template_directory_uri() . '/assets/js/jquery-3.2.1.min.js', [], '20151215', true);

	wp_enqueue_script( 'vino-js-slick', get_template_directory_uri() . '/assets/js/slick.min.js', [], '', true );
	
	wp_enqueue_script( 'vino-fancybox', 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.js', [], '', true );
	wp_enqueue_script( 'vino-dotdotdot', get_template_directory_uri() . '/assets/js/jquery.dotdotdot.js', [], '', true );
	
	wp_enqueue_script( 'vino-js_imageloaded', get_template_directory_uri() . '/assets/js/imagesloaded.pkgd.min.js', [], '', true );
	
	wp_enqueue_script( 'vino-js_masonry', get_template_directory_uri() . '/assets/js/masonry.pkgd.min.js', [], '', true );
//
	wp_enqueue_script( 'vino-js_my_script', get_template_directory_uri() . '/assets/js/my_script.js', [], '', true );

	/*
    * Добавляем возможность отправлять AJAX-запросы к скриптам
    * Аргументы:
    * 1) название скрипта, в котором будем писать ajax
    * 2) название объекта, к которому будем обращаться в файле скрипта
    * 3) элементы объекта, которые нам нужны (путь к обработчику аякса, путь к папке темы)
    */
	wp_localize_script( 'vino-js_my_script', 'myajax',
		[
			'url' => admin_url( 'admin-ajax.php' ),
			'template' => get_template_directory_uri()
		]
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'vino_scripts');

//function my_deregister_java () {
//
//		wp_deregister_script ( 'jquery' );
//}
//add_action ( 'wp_print_scripts', 'my_deregister_java', 100 );