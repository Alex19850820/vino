<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'AWS_Admin_Ajax' ) ) :

    /**
     * Class for plugin admin ajax hooks
     */
    class AWS_Admin_Ajax {

        /*
         * Constructor
         */
        public function __construct() {

            add_action( 'wp_ajax_aws-renameForm', array( &$this, 'rename_form' ) );

            add_action( 'wp_ajax_aws-copyForm', array( &$this, 'copy_form' ) );

            add_action( 'wp_ajax_aws-deleteForm', array( &$this, 'delete_form' ) );

            add_action( 'wp_ajax_aws-addForm', array( &$this, 'add_form' ) );

            add_action( 'wp_ajax_aws-addFilter', array( &$this, 'add_filter' ) );

            add_action( 'wp_ajax_aws-copyFilter', array( &$this, 'copy_filter' ) );

            add_action( 'wp_ajax_aws-deleteFilter', array( &$this, 'delete_filter' ) );

            add_action( 'wp_ajax_aws-orderFilter', array( &$this, 'order_filter' ) );

            add_action( 'wp_ajax_aws-changeState', array( &$this, 'change_state' ) );

        }

        /*
         * Ajax hook for form renaming
         */
        public function rename_form() {

            $instance_id = $_POST['id'];
            $form_name   = $_POST['name'];

            $settings = $this->get_settings();

            $settings[$instance_id]['search_instance'] = $form_name;

            update_option( 'aws_pro_settings', $settings );

            die;
        }

        /*
         * Ajax hook for form coping
         */
        public function copy_form() {

            $instance_id = $_POST['id'];

            $instances_number = get_option( 'aws_instances' );
            $instances_number++;

            $settings = $this->get_settings();
            $instance_settings = $settings[$instance_id];

            $instance_settings['search_instance'] = $instance_settings['search_instance'] . ' (copy)';

            $settings[$instances_number] = $instance_settings;

            update_option( 'aws_instances', $instances_number );
            update_option( 'aws_pro_settings', $settings );

            /**
             * Fires after search form instance was create/copy/delete
             *
             * @since 1.33
             *
             * @param array $settings Array of plugin settings
             * @param string $ Action type
             * @param string $instance_id Form instance id
             */
            do_action( 'aws_form_changed', $settings, 'copy_form', $instance_id );

            die;
        }

        /*
         * Ajax hook for form deleting
         */
        public function delete_form() {

            $instance_id = $_POST['id'];

            $settings = $this->get_settings();

            unset( $settings[$instance_id] );

            update_option( 'aws_pro_settings', $settings );

            /**
             * Fires after search form instance was create/copy/delete
             *
             * @since 1.33
             *
             * @param array $settings Array of plugin settings
             * @param string $ Action type
             * @param string $instance_id Form instance id
             */
            do_action( 'aws_form_changed', $settings, 'delete_form', $instance_id );

            do_action( 'aws_cache_clear', $instance_id );

            die;
        }

        /*
         * Ajax hook for form adding
         */
        public function add_form() {

            $instances_number = get_option( 'aws_instances' );
            $instances_number++;

            $settings = $this->get_settings();

            $options = $this->options_array();
            $default_settings = array();

            foreach ( $options as $section_name => $section ) {
                foreach ($section as $values) {

                    if ( isset( $values['type'] ) && $values['type'] === 'heading' ) {
                        continue;
                    }

                    if ( isset( $values['type'] ) && ( $values['type'] === 'checkbox' || $values['type'] === 'table' ) ) {
                        foreach ( $values['choices'] as $key => $val ) {

                            if ( $section_name === 'results' ) {
                                $default_settings['filters']['1'][$values['id']][$key] = $values['value'][$key];
                            } else {
                                $default_settings[$values['id']][$key] = $values['value'][$key];
                            }

                        }
                        continue;
                    }

                    if ( $section_name === 'results' ) {
                        $default_settings['filters']['1'][$values['id']] = $values['value'];
                        continue;
                    }

                    $default_settings[$values['id']] = $values['value'];

                    if (isset( $values['sub_option'])) {
                        $default_settings[$values['sub_option']['id']] = $values['sub_option']['value'];
                    }
                }
            }

            $settings[$instances_number] = $default_settings;

            update_option( 'aws_instances', $instances_number );
            update_option( 'aws_pro_settings', $settings );

            /**
             * Fires after search form instance was create/copy/delete
             *
             * @since 1.33
             *
             * @param array $settings Array of plugin settings
             * @param string $ Action type
             * @param string $instance_id Form instance id
             */
            do_action( 'aws_form_changed', $settings, 'add_form', $instances_number );

            die;

        }

        /*
         * Ajax hook for filter adding
         */
        public function add_filter() {

            $instance_id = $_POST['instanceId'];

            $settings = $this->get_settings();
            $filter_id = ++$settings[$instance_id]['filter_num'];

            $options = $this->options_array();
            $filter_options = $options['results'];

            foreach ($filter_options as $values) {

                if ( $values['type'] === 'heading' ) {
                    continue;
                }

                $settings[$instance_id]['filters'][$filter_id][$values['id']] = $values['value'];

            }

            $settings[$instance_id]['filters'][$filter_id]['filter_name'] = __( 'New Filter', 'aws' );

            update_option( 'aws_pro_settings', $settings );

            /**
             * Fires after search form filter was create/copy/delete
             *
             * @since 1.33
             *
             * @param array $settings Array of plugin settings
             * @param string $ Action type
             * @param string $instance_id Form instance id
             * @param string $filter_id Filter id
             */
            do_action( 'aws_filters_changed', $settings, 'add_filter', $instance_id, $filter_id );

            die;

        }

        /*
         * Ajax hook for filter coping
         */
        public function copy_filter() {

            $instance_id = $_POST['instanceId'];
            $filter      = $_POST['filterId'];

            $settings = $this->get_settings();
            $filter_id = ++$settings[$instance_id]['filter_num'];

            $filter_settings = $settings[$instance_id]['filters'][$filter];

            $filter_settings['filter_name'] = $filter_settings['filter_name'] . ' (copy)';

            $settings[$instance_id]['filters'][$filter_id] = $filter_settings;

            update_option( 'aws_pro_settings', $settings );

            /**
             * Fires after search form filter was create/copy/delete
             *
             * @since 1.33
             *
             * @param array $settings Array of plugin settings
             * @param string $ Action type
             * @param string $instance_id Form instance id
             * @param string $filter_id Filter id
             */
            do_action( 'aws_filters_changed', $settings, 'copy_filter', $instance_id, $filter );

            die;
        }

        /*
         * Ajax hook for filter deleting
         */
        public function delete_filter() {

            $instance_id = $_POST['instanceId'];
            $filter      = $_POST['filterId'];

            $settings = $this->get_settings();

            unset( $settings[$instance_id]['filters'][$filter] );

            update_option( 'aws_pro_settings', $settings );

            /**
             * Fires after search form filter was create/copy/delete
             *
             * @since 1.33
             *
             * @param array $settings Array of plugin settings
             * @param string $ Action type
             * @param string $instance_id Form instance id
             * @param string $filter_id Filter id
             */
            do_action( 'aws_filters_changed', $settings, 'delete_filter', $instance_id, $filter );

            do_action( 'aws_cache_clear', $instance_id, $filter );

            die;
        }

        /*
         * Ajax hook for filter deleting
         */
        public function order_filter() {

            $instance_id = $_POST['instanceId'];
            $order       = $_POST['order'];

            $order = json_decode( $order );

            $settings = $this->get_settings();

            $filters = $settings[$instance_id]['filters'];

            $new_filters_array = array();

            foreach ( $order as $filter_id ) {
                $new_filters_array[$filter_id] = $filters[$filter_id];
            }

            $settings[$instance_id]['filters'] = $new_filters_array;

            update_option( 'aws_pro_settings', $settings );

            die;
        }

        /*
         * Change option state
         */
        public function change_state() {

            $instance_id = $_POST['instanceId'];
            $filter      = $_POST['filterId'];
            $setting     = $_POST['setting'];
            $option      = $_POST['option'];
            $state       = $_POST['state'];

            $settings = $this->get_settings();

            $settings[$instance_id]['filters'][$filter][$setting][$option] = $state ? 0 : 1;

            update_option( 'aws_pro_settings', $settings );

            do_action( 'aws_cache_clear', $instance_id, $filter );

            die;

        }

        /*
         * Get plugin settings
         */
        private function get_settings() {
            $plugin_options = AWS_PRO()->get_settings();
            return $plugin_options;
        }

        /*
         * Options array that generate settings page
         */
        public function options_array() {
            return AWS_Helpers::options_array();
        }

    }

endif;


new AWS_Admin_Ajax();