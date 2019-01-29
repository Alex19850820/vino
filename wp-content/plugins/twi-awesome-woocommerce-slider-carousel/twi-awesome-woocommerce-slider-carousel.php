<?php
/*
    Plugin Name: TWI Awesome Woocommerce Grid/Slider/Carousel
	Plugin URI: http://khairul-alam.com
	Description: Simple, easy and super flexible Awesome Woocommerce Grid/Slider/Carousel plugin for wordpress by TWI.
	Version: 5.0.3
	Author: Khairul Alam
	Author URI: http://khairul-alam.com
*/
include_once(ABSPATH . 'wp-admin/includes/plugin.php');
if (is_plugin_active('woocommerce/woocommerce.php')) {
	define('TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR', plugin_dir_path(__FILE__));
	define('TWI_AWESOME_WOO_SLIDER_CAROUSEL_URL', plugin_dir_url(__FILE__));
	
		require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/config.php');
		require_once (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/lang.php');
		require_once (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/cp/cp.php');
		require_once (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/cp/duplicate.php');
		require_once (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/scripts_load.php');
		
		if ( is_admin() ) {
		   require_once (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/update-notifier.php');
		}
		
		require_once (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/shortcode.php');
		
		require_once (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/widget.php');

		require_once (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/settings/replace.php');
		
		if(vp_option("twi_woo_options.twi_woo_related_off_on") == 1) :
		   require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/related_pro.php');
	    endif;
}
if (is_plugin_inactive('woocommerce/woocommerce.php')) {
	function twi_woo_admin_notice() {
	    ?>
	    <div class="error">
	        <p><?php _e( '<i><b><span style="color:#9C5D90">You must need to install "Woocommerce" plugin first to show the options of "TWI Awesome Woocommerce Grid/Slider/Carousel" plugin.</span></b></i>','twi_awesome_woo_slider_carousel'); ?></p>
	    </div>
	    <?php
	}
	add_action( 'all_admin_notices', 'twi_woo_admin_notice' );
}
function twi_woo_removeWhitespace($buffer) {

    $search = array(
        '/\>[^\S ]+/s',  // strip whitespaces after tags, except space
        '/[^\S ]+\</s',  // strip whitespaces before tags, except space
        '/(\s)+/s'       // shorten multiple whitespace sequences
    );

    $replace = array(
        '>',
        '<',
        '\\1'
    );

    $buffer = preg_replace($search, $replace, $buffer);

    return $buffer;
}
?>