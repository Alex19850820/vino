<?php
/***** Active Plugin ********/
require_once( get_template_directory().'/lib/class-tgm-plugin-activation.php' );

add_action( 'tgmpa_register', 'ya_register_required_plugins' );
function ya_register_required_plugins() {
    $plugins = array(
		array(
            'name'               => 'WooCommerce', 
            'slug'               => 'woocommerce', 
            'required'           => true, 
			'version'			 => '3.4.3'
        ),
        array(
            'name'               => 'bbPress', 
            'slug'               => 'bbpress', 
            'required'           => true, 
        ),
        array(
            'name'               => 'SW Woocommerce', 
            'slug'               => 'sw_woocommerce', 
            'source'             => get_template_directory_uri() . '/lib/plugins/sw_woocommerce.zip', 
            'required'           => true, 
			'version'            => '1.3.0'
        ),
        array(
            'name'               => 'SW Ajax WooCommerce Search', 
            'slug'               => 'sw_ajax_woocommerce_search', 
            'source'             => get_template_directory_uri() . '/lib/plugins/sw_ajax_woocommerce_search.zip', 
            'required'           => true, 
            'version'            => '1.1.4'
        ),
		array(
            'name'               => 'Sw Woocommerce Swatches', 
            'slug'               => 'sw_wooswatches', 
            'source'             => get_template_directory_uri() . '/lib/plugins/sw_wooswatches.zip', 
            'required'           => true, 
            'version'            => '1.0.5'
        ),
         array(
            'name'               => 'Social Login WordPress Plugin - AccessPress Social Login Lite', 
            'slug'               => 'accesspress-social-login-lite', 
            'required'           => false, 
        ),
		array(
            'name'               => 'MailChimp for WordPress Lite', 
            'slug'               => 'mailchimp-for-wp', 
            'required'           => true, 
        ),		
		array(
            'name'               => 'SW Core', 
            'slug'               => 'sw_core', 
            'source'             => get_template_directory_uri() . '/lib/plugins/sw_core.zip', 
            'required'           => true, 
			'version'            => '1.1.5'
        ),		
		array(
            'name'               => 'Visual Composer', 
            'slug'               => 'js_composer', 
            'source'             => get_template_directory_uri() . '/lib/plugins/js_composer.zip', 
            'required'           => true, 
			'version'            => '5.5'
						
        ),
		array(
            'name'               => 'One Click Demo Import', 
            'slug'               => 'one-click-demo-import', 
            'source'             => get_template_directory_uri() . '/lib/plugins/one-click-demo-import.zip', 
            'required'           => true, 
        ),
		array(
            'name'               => 'Revolution Slider', 
            'slug'               => 'revslider', 
            'source'             => get_template_directory_uri() . '/lib/plugins/revslider.zip', 
            'required'           => true, 
			'version'            => '5.4.7.4'
        ),
		
		array(
            'name'      		 => 'Contact Form 7',
            'slug'     			 => 'contact-form-7',
            'required' 			 => false,
        ), 
		array(
            'name'     			 => 'WordPress Importer',
            'slug'      		 => 'wordpress-importer',
            'required' 			 => true,
        ), 
		array(
            'name'      		 => 'YITH Woocommerce Compare',
            'slug'      		 => 'yith-woocommerce-compare',
            'required'			 => false
        ),
		array(
            'name'     			 => 'YITH Woocommerce Wishlist',
            'slug'      		 => 'yith-woocommerce-wishlist',
            'required' 			 => false
        ), 

    );
	if( ya_options()->getCpanelValue('developer_mode') ): 
		$plugins[] = array(
			'name'               => esc_html__( 'Less Compile', 'shoppystore' ), 
			'slug'               => 'lessphp', 
			'source'             => get_template_directory_uri() . '/lib/plugins/lessphp.zip', 
			'required'           => true, 
			'version'            => '4.0.0'
		);
	endif;
    $config = array();

    tgmpa( $plugins, $config );

}	