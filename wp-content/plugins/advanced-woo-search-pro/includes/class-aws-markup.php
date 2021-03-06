<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'AWS_Markup' ) ) :

    /**
     * Class for plugin search action
     */
    class AWS_Markup {

        /**
         * @var AWS_Markup ID of current form instance $form_id
         */
        private $form_id;

        /*
         * Constructor
         */
        public function __construct( $id = 1 ) {

            $this->form_id = $id;

        }

        /*
         * Generate search box markup
         */
        public function markup() {

            global $wpdb;

            $table_name = $wpdb->prefix . AWS_INDEX_TABLE_NAME;

            if ( $wpdb->get_var( "SHOW TABLES LIKE '{$table_name}'" ) != $table_name ) {
                echo 'Please go to <a href="' . admin_url( 'admin.php?page=aws-options' ) . '">plugins settings page</a> and click on "Reindex table" button.';
                return;
            }

            if ( ! $this->is_instance_exist() ) {
                return;
            }


            $placeholder   = AWS_Helpers::translate( 'search_field_text_' . $this->form_id, AWS_PRO()->get_settings( 'search_field_text', $this->form_id ) );
            $notfound_text = AWS_Helpers::translate( 'not_found_text_' . $this->form_id, AWS_PRO()->get_settings( 'not_found_text', $this->form_id ) );
            $min_chars     = AWS_PRO()->get_settings( 'min_chars', $this->form_id );
            $show_loader   = AWS_PRO()->get_settings( 'show_loader', $this->form_id );
            $show_more     = AWS_PRO()->get_settings( 'show_more', $this->form_id );
            $show_page     = AWS_PRO()->get_settings( 'show_page', $this->form_id );
            $buttons_order = AWS_PRO()->get_settings( 'buttons_order', $this->form_id );
            $target_blank  = AWS_PRO()->get_settings( 'target_blank', $this->form_id );
            $use_analytics = AWS_PRO()->get_settings( 'use_analytics', $this->form_id );
            $show_addon    = AWS_PRO()->get_settings( 'show_addon', $this->form_id );
            $filters       = AWS_PRO()->get_settings( 'filters', $this->form_id );

            $filter_name   = AWS_Helpers::translate( 'filter_name_' . $this->form_id . '_1', $filters['1']['filter_name'] );

            $show_filters = ( count( $filters ) > 1 );

            $filters_arr = array();

            foreach ( $filters as $filter_id => $filter_opts ) {
                $filter_names = AWS_Helpers::translate( 'filter_name_' . $this->form_id . '_' . $filter_id, $filter_opts['filter_name'] );
                $filters_arr['filters'][][$filter_id] = $filter_names;
            }

            $url_array = parse_url( home_url() );
            $url_query_parts = array();

            if ( isset( $url_array['query'] ) && $url_array['query'] ) {
                parse_str( $url_array['query'], $url_query_parts );
            }

            $params_string = '';

            $params = array(
                'data-id'            => $this->form_id,
                'data-url'           => admin_url('admin-ajax.php'),
                'data-siteurl'       => home_url(),
                'data-show-loader'   => $show_loader,
                'data-show-more'     => $show_more,
                'data-show-page'     => $show_page,
                'data-buttons-order' => $buttons_order,
                'data-target-blank'  => $target_blank,
                'data-use-analytics' => $use_analytics,
                'data-min-chars'     => $min_chars,
                'data-filters'       => $show_filters ? str_replace( '"', "'", json_encode( $filters_arr ) ) : false,
                'data-notfound'      => str_replace( '"',"'", $notfound_text ),
                'data-more'          => __( 'View all results', 'aws' ),
                'data-sku'           => __( 'SKU', 'aws' )
            );

            foreach( $params as $key => $value ) {
                $params_string .= $key . '="' . $value . '" ';
            }

            $markup = '';
            $markup .= '<div class="aws-container" ' . $params_string . '>';
            $markup .= '<form class="aws-search-form" action="' . home_url() . '" method="get" role="search" >';

            $markup .= '<div class="aws-wrapper">';

            if ( $show_addon === 'true' ) {
                $markup .= '<div class="aws-suggest">';
                $markup .= '<div class="aws-suggest__keys"></div>';
                $markup .= '<div class="aws-suggest__addon"></div>';
                $markup .= '</div>';
            }

            $markup .= '<input  type="text" name="s" value="' . get_search_query() . '" class="aws-search-field" placeholder="' . $placeholder . '" autocomplete="off" />';
            $markup .= '<input type="hidden" name="post_type" value="product">';
            $markup .= '<input type="hidden" name="type_aws" value="true">';
            $markup .= '<input type="hidden" name="id" value="' . $this->form_id . '">';
            $markup .= '<input type="hidden" name="filter" class="awsFilterHidden" value="1">';

            if ( $url_query_parts ) {
                foreach( $url_query_parts as $url_query_key => $url_query_value  ) {
                    $markup .= '<input type="hidden" name="' . $url_query_key . '" value="' . $url_query_value . '">';
                }
            }

            $markup .= '<div class="aws-search-clear">';
                $markup .= '<span aria-label="Clear Search">×</span>';
            $markup .= '</div>';

            $markup .= '</div>';

            if ( $show_filters ) {
                $markup .= '<div class="aws-main-filter aws-form-btn">';
                    $markup .= '<div class="aws-main-filter-inner">';
                        $markup .= '<span class="aws-main-filter__current">' . $filter_name . '</span>';
                    $markup .= '</div>';
                $markup .= '</div>';
            }

            if ( $buttons_order && $buttons_order !== '1' && $buttons_order !== '3' ) {

                $markup .= '<div class="aws-search-btn aws-form-btn">';
                    $markup .= '<span class="aws-search-btn_icon">';
                        $markup .= '<svg focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">';
                            $markup .= '<path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path>';
                        $markup .= '</svg>';
                    $markup .= '</span>';
                $markup .= '</div>';

            }

            $markup .= '</form>';
            $markup .= '</div>';

            return apply_filters( 'aws_searchbox_markup', $markup );

        }

        /*
         * Check if instance still exist
         */
        private function is_instance_exist() {
            $plugin_options = get_option( 'aws_pro_settings' );
            return isset( $plugin_options[ $this->form_id ] );
        }

    }

endif;