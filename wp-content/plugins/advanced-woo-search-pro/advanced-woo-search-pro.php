<?php

/*
Plugin Name: Advanced Woo Search PRO
Description: Advance ajax WooCommerce product search.
Version: 1.34
Author: ILLID
Author URI: https://advanced-woo-search.com/
Text Domain: aws
WC requires at least: 3.0.0
WC tested up to: 3.4.0
*/


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'AWS_PRO_VERSION', '1.34' );

define( 'AWS_PRO_DIR', dirname( __FILE__ ) );
define( 'AWS_PRO_URL', plugins_url( '', __FILE__ ) );

define( 'AWS_INDEX_TABLE_NAME', 'aws_index' );
define( 'AWS_CACHE_TABLE_NAME', 'aws_cache' );


if ( ! class_exists( 'AWS_PRO_Main' ) ) :

/**
 * Main plugin class
 *
 * @class AWS_PRO_Main
 */
final class AWS_PRO_Main {

	/**
	 * @var AWS_PRO_Main The single instance of the class
	 */
	protected static $_instance = null;
        
    /**
     * @var AWS_PRO_Main Cache instance
     */
    public $cache = null;

	/**
	 * Main AWS_PRO_Main Instance
	 *
	 * Ensures only one instance of AWS_PRO_Main is loaded or can be loaded.
	 *
	 * @static
	 * @return AWS_PRO_Main - Main instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Constructor
	 */
	public function __construct() {

		$this->includes();

		add_filter( 'widget_text', 'do_shortcode' );

		add_shortcode( 'aws_search_form', array( $this, 'markup' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'load_scripts' ) );

		add_filter( 'plugin_action_links', array( $this, 'add_settings_link' ), 10, 2 );

        load_plugin_textdomain( 'aws', false, dirname( plugin_basename( __FILE__ ) ). '/languages/' );

        add_action( 'init', array( $this, 'init' ), 0 );

	}

    /**
     * Include required core files used in admin and on the frontend.
     */
    public function includes() {
        include_once( 'includes/class-aws-helpers.php' );
        include_once( 'includes/class-aws-versions.php' );
        include_once( 'includes/class-aws-table.php' );
		include_once( 'includes/class-aws-markup.php' );
		include_once( 'includes/class-aws-search.php' );
		include_once( 'includes/class-aws-admin-fields.php' );
        include_once( 'includes/class-aws-admin.php' );
        include_once( 'includes/class-aws-cache.php' );
		include_once( 'includes/class-aws-admin-ajax.php' );
        include_once( 'includes/class-aws-search-page.php' );
        include_once( 'includes/class-aws-order.php' );
        include_once( 'includes/class-aws-translate.php' );
        include_once( 'includes/widget.php' );
    }

	/*
	 * Generate search box markup
	 */
	public function markup( $atts = array() ) {

        extract( shortcode_atts( array(
        	'id' => 1,
        ), $atts ) );

		$markup = new AWS_Markup( $id );

		return $markup->markup();
	}

    /*
	 * Sort products
	 */
    public function order( $products, $order_by ) {

        $order = new AWS_Order( $products, $order_by );

        return $order->result();

    }
        
    /*
     * Init plugin classes
     */
    public function init() {
        $this->cache = AWS_Cache::factory();
    }

	/*
	 * Load assets for search form
	 */
	public function load_scripts() {
		wp_enqueue_style( 'aws-style', AWS_PRO_URL . '/assets/css/common.css', array(), AWS_PRO_VERSION );
		wp_enqueue_script( 'aws-script', AWS_PRO_URL . '/assets/js/common.js', array('jquery'), AWS_PRO_VERSION, true );
    }

	/*
	 * Add settings link to plugins
	 */
	public function add_settings_link( $links, $file ) {
		$plugin_base = plugin_basename( __FILE__ );

		if ( $file == $plugin_base ) {
			$setting_link = '<a href="' . admin_url('admin.php?page=aws-options') . '">'.__( 'Settings', 'aws' ).'</a>';
			array_unshift( $links, $setting_link );
		}

		return $links;
	}

    /*
     * Get plugin settings
     */
    public function get_settings( $name = 0, $form_id = 0, $filter_id = 0, $depends = false ) {

        if ( $depends && ! AWS_Helpers::is_plugin_active( $depends ) ) {
            return false;
        }

        $plugin_options = get_option( 'aws_pro_settings' );

        if ( $name && $form_id ) {
            if ( $filter_id ) {
				$return_value = isset( $plugin_options[ $form_id ]['filters'][ $filter_id ][ $name ] ) ? $plugin_options[ $form_id ]['filters'][ $filter_id ][ $name ] : '';
                return $return_value;
            } else {
				$return_value = isset( $plugin_options[ $form_id ][ $name ] ) ? $plugin_options[ $form_id ][ $name ] : '';
				return $return_value;
            }
        } else {
            return $plugin_options;
        }

    }

}

endif;

/**
 * Returns the main instance of AWS_PRO_Main
 *
 * @return AWS_PRO_Main
 */
function AWS_PRO() {
    return AWS_PRO_Main::instance();
}


/*
 * Check if WooCommerce is active
 */
if ( ! aws_pro_is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
    add_action( 'admin_notices', 'aws_pro_install_woocommerce_admin_notice' );
} elseif ( aws_pro_is_plugin_active( 'advanced-woo-search/advanced-woo-search.php' ) ) {
    add_action( 'admin_notices', 'aws_pro_disable_old_version' );
} else {
    add_action( 'woocommerce_loaded', 'aws_pro_init' );
}


/*
 * Check whether the plugin is active by checking the active_plugins list.
 */
function aws_pro_is_plugin_active( $plugin ) {
    return in_array( $plugin, (array) get_option( 'active_plugins', array() ) ) || aws_pro_is_plugin_active_for_network( $plugin );
}


/*
 * Check whether the plugin is active for the entire network
 */
function aws_pro_is_plugin_active_for_network( $plugin ) {
    if ( !is_multisite() )
        return false;

    $plugins = get_site_option( 'active_sitewide_plugins');
    if ( isset($plugins[$plugin]) )
        return true;

    return false;
}

/*
 * Error notice if WooCommerce plugin is not active
 */
function aws_pro_install_woocommerce_admin_notice() {
	?>
	<div class="error">
		<p><?php _e( 'Advanced Woo Search plugin is enabled but not effective. It requires WooCommerce in order to work.', 'aws' ); ?></p>
	</div>
	<?php
}

/*
 * Error notice if WooCommerce plugin is not active
 */
function aws_pro_disable_old_version() {
    ?>
    <div class="error">
        <p><?php _e( 'Advanced Woo Search PRO plugin is enabled but not effective. Please disable the lite version of plugin.', 'aws' ); ?></p>
    </div>
<?php
}

/*
 * Init AWS plugin
 */
function aws_pro_init() {
    AWS_PRO();
}