<?php
require_once dirname( __FILE__ ) . '/class.settings-api.php';

/**
 * WordPress settings API demo class
 *
 * @author Tareq Hasan
 */
if ( !class_exists('WeDevs_Settings_API_Test' ) ):
class WeDevs_Settings_API_Test {

    private $settings_api;

    function __construct() {
        $this->settings_api = new WeDevs_Settings_API;

        add_action( 'admin_init', array($this, 'admin_init') );
        add_action( 'admin_menu', array($this, 'admin_menu') );
    }

    function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    function admin_menu() {
        add_options_page( 'TWI Woo Settings', 'TWI Woo Settings', 'delete_posts', 'settings_woo_main', array($this, 'plugin_page') );
    }

    function get_settings_sections() {
        $sections = array(
            array(
                'id' => 'twi_woo_framework_settings',
                'title' => __( 'Framework Install', 'twi_awesome_woo_slider_carousel' )
            ),
            array(
                'id' => 'twi_woo_main_settings',
                'title' => __( 'Preloader Settings', 'twi_awesome_woo_slider_carousel' )
            )
        );
        return $sections;
    }

    /**
     * Returns all the settings fields
     *
     * @return array settings fields
     */
    function get_settings_fields() {
        $settings_fields = array(
            'twi_woo_framework_settings' => array(
                array(
                    'name' => 'woo_frame_y_n',
                    'label' => __( 'Framework Install ?', 'twi_awesome_woo_slider_carousel' ),
                    'type' => 'radio',
                    'default' => 'no',
                    'options' => array(
                        'yes' => 'Yes',
                        'no' => 'No'
                    )
                )
            ),
            'twi_woo_main_settings' => array(
                array(
	                'name' => 'woo_page_y_n',
	                'label' => __( 'Preloader Active ?', 'twi_awesome_woo_slider_carousel' ),
	                'type' => 'radio',
	                'default' => 'no',
	                'options' => array(
	                    'yes' => 'Yes',
	                    'no' => 'No'
	                )
	            )
            ),
        );

        return $settings_fields;
    }

    function plugin_page() {
        echo '<div class="wrap">';

        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();

        echo '</div>';
    }

    /**
     * Get all the pages
     *
     * @return array page names with key value pairs
     */
    function get_pages() {
        $pages = get_pages();
        $pages_options = array();
        if ( $pages ) {
            foreach ($pages as $page) {
                $pages_options[$page->ID] = $page->post_title;
            }
        }

        return $pages_options;
    }

}
endif;

$settings = new WeDevs_Settings_API_Test();