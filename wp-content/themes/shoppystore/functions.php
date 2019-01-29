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