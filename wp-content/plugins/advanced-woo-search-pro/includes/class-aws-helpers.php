<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


if ( ! class_exists( 'AWS_Helpers' ) ) :

/**
 * Class for plugin help methods
 */
class AWS_Helpers {

    /*
     * Retrieves thumbnail url for term
     */
    static public function get_term_thumbnail( $term_id ) {

        $thumb_src = '';
        $thumbnail_id = function_exists( 'get_term_meta' ) ? get_term_meta( $term_id, 'thumbnail_id', true ) : get_metadata( 'woocommerce_term', $term_id, 'thumbnail_id', true );

        if ( $thumbnail_id ) {
            $thumb = wp_get_attachment_image_src( $thumbnail_id, 'thumbnail' );
            if ( ! empty( $thumb ) ) {
                $thumb_src = current( $thumb );
            }
        }

        return $thumb_src;

    }

    /*
     * Get array of products categories
     */
    static public function get_categories() {

        $option_array = array();

        $args = array(
            'taxonomy' => 'product_cat'
        );

        $categories = get_categories( $args );

        if ( ! empty( $categories ) ) {
            foreach ( $categories as $category ) {
                $option_array[$category->cat_ID] = $category->category_nicename;
            }
        }

        return $option_array;

    }

    /*
     * Get array of products categories
     */
    static public function get_tags() {

        $option_array = array();

        $tags = get_terms( 'product_tag' );

        if ( ! empty( $tags ) ) {
            foreach ( $tags as $tag ) {
                $option_array[$tag->term_id] = $tag->name;
            }
        }

        return $option_array;

    }

    /*
     * Get array of products
     */
    static public function get_products() {

        $option_array = array();

        $args = array(
            'posts_per_page'  => -1,
            'post_type'       => 'product'
        );

        $products = get_posts( $args );

        if ( ! empty( $products ) ) {
            foreach ( $products as $product ) {
                $option_array[$product->ID] = $product->post_title;
            }
        }

        return $option_array;

    }

    /*
     * Get product brands
     *
     * @return array Brands
     */
    static public function get_product_brands( $id ) {

        $terms = get_the_terms( $id, 'product_brand' );

        if ( is_wp_error( $terms ) ) {
            return '';
        }

        if ( empty( $terms ) ) {
            return '';
        }

        $brands_array = array();

        foreach ( $terms as $term ) {

            $thumb_src = AWS_Helpers::get_term_thumbnail( $term->term_id );

            $brands_array[] = array(
                'name'  => $term->name,
                'image' => $thumb_src
            );

        }

        return $brands_array;

    }

    /*
     * Get array of products attributes
     */
    static public function get_attributes( $values = false ) {

        $attributes_array = array();

        if ( function_exists( 'wc_get_attribute_taxonomies' ) ) {
            $attributes = wc_get_attribute_taxonomies();

            if ( $attributes && ! empty( $attributes ) ) {
                foreach( $attributes as $attribute ) {
                    $attribute_name = 'attr_' . wc_attribute_taxonomy_name( $attribute->attribute_name );
                    $attributes_array[$attribute_name] = $values ? 1 : $attribute->attribute_label . ' (' . wc_attribute_taxonomy_name( $attribute->attribute_name ) . ')';
                }
            }

        }

        $attributes_array['attr_custom'] = $values ? 1 : __( 'Custom product attributes', 'aws' );

        return $attributes_array;

    }

    /*
     * Get array of products taxonomies
     */
    static public function get_taxonomies( $values = false, $prefix = true ) {

        $taxonomy_objects = get_object_taxonomies( 'product', 'objects' );
        $taxonomies_array = array();

        foreach( $taxonomy_objects as $taxonomy_object ) {
            if ( in_array( $taxonomy_object->name, array( 'product_cat', 'product_tag', 'product_type', 'product_visibility', 'product_shipping_class' ) ) ) {
                continue;
            }

            if ( strpos( $taxonomy_object->name, 'pa_' ) === 0 ) {
                continue;
            }

            $tax_name = $prefix ? 'tax_' . $taxonomy_object->name : $taxonomy_object->name;
            $taxonomies_array[$tax_name] = $values ? 1 : $taxonomy_object->label . ' (' . $taxonomy_object->name . ')';

        }

        return $taxonomies_array;

    }

    /*
     * Get array of products custom fields
     */
    static public function get_custom_fields( $values = false ) {
        global $wpdb;

        $query = "
            SELECT DISTINCT meta_key
            FROM $wpdb->postmeta
            WHERE meta_key NOT LIKE '\_%'
            AND meta_key NOT LIKE 'attribute_pa%'
            AND meta_key NOT LIKE 'wc_productdata_options'
            AND meta_key NOT LIKE 'total_sales'
            ORDER BY meta_key ASC
        ";

        $wp_es_fields = $wpdb->get_results( $query );
        $meta_keys = array();

        if ( is_array( $wp_es_fields ) && !empty( $wp_es_fields ) ) {
            foreach ( $wp_es_fields as $field ) {
                if ( isset( $field->meta_key ) ) {
                    $meta_name = 'meta_' . strtolower( $field->meta_key );
                    $meta_keys[$meta_name] = $values ? 0 : $field->meta_key;
                }
            }
        }

        /**
         * Filter results of SQL query for meta keys
         * @since 1.32
         * @param array $meta_keys array of meta keys
         */
        return apply_filters( 'aws_meta_keys', $meta_keys );

    }

    /*
     * Recursively implode multi-dimensional arrays
     */
    static public function recursive_implode( $separator, $array ) {

        $output = " ";

        foreach ( $array as $av ) {
            if ( is_array( $av ) ) {
                $output .= AWS_Helpers::recursive_implode( $separator, $av );
            } else {
                $output .= $separator.$av;
            }

        }

        return trim( $output );

    }

    /*
     * Get instance page url
     */
    static public function get_settings_instance_page_url( $part = false ) {
        $instance_id       = isset( $_GET['aws_id'] ) ? $_GET['aws_id'] : 0;
        $current_filter_id = isset( $_GET['filter'] ) ? $_GET['filter'] : 1;

        $instance_page = admin_url( 'admin.php?page=aws-options&tab=results&aws_id=' . $instance_id . '&filter=' . $current_filter_id );

        if ( $part ) {
            $instance_page = $instance_page . $part;
        }

        return $instance_page;
    }

    /*
     * Removes scripts, styles, html tags
     */
    static public function html2txt( $str ) {
        $search = array(
            '@<script[^>]*?>.*?</script>@si',
            '@<[\/\!]*?[^<>]*?>@si',
            '@<style[^>]*?>.*?</style>@siU',
            '@<![\s\S]*?--[ \t\n\r]*>@'
        );
        $str = preg_replace( $search, '', $str );

        $str = esc_attr( $str );
        $str = stripslashes( $str );
        $str = str_replace( array( "\r", "\n" ), ' ', $str );

        $str = str_replace( array(
            "Â·",
            "â€¦",
            "â‚¬",
            "&shy;"
        ), "", $str );

        return $str;
    }

    /*
     * Strip shortcodes
     */
    static public function strip_shortcodes( $str ) {
        $str = preg_replace( '#\[[^\]]+\]#', '', $str );
        return $str;
    }

    /*
     * Check if index table exist
     */
    static public function is_table_not_exist() {

        global $wpdb;

        $table_name = $wpdb->prefix . AWS_INDEX_TABLE_NAME;

        return ( $wpdb->get_var( "SHOW TABLES LIKE '{$table_name}'" ) != $table_name );

    }

    /*
     * Get amount of indexed products
     */
    static public function get_indexed_products_count() {

        global $wpdb;

        $table_name = $wpdb->prefix . AWS_INDEX_TABLE_NAME;

        $indexed_products = 0;

        if ( $wpdb->get_var( "SHOW TABLES LIKE '{$table_name}'" ) === $table_name ) {

            $sql = "SELECT COUNT(*) FROM {$table_name} GROUP BY ID;";

            $indexed_products = $wpdb->query( $sql );

        }

        return $indexed_products;

    }

    /*
     * Check if index table has new terms columns
     */
    static public function is_index_table_has_terms() {

        global $wpdb;

        $table_name =  $wpdb->prefix . AWS_INDEX_TABLE_NAME;

        $return = false;

        if ( $wpdb->get_var( "SHOW TABLES LIKE '{$table_name}'" ) === $table_name ) {

            $columns = $wpdb->get_row("
                SELECT * FROM {$table_name} LIMIT 0, 1
            ", ARRAY_A );

            if ( $columns && ! isset( $columns['term_id'] ) ) {
                $return = 'no_terms';
            } else {
                $return = 'has_terms';
            }

        }

        return $return;

    }

    /*
     * Add term_id column to index table
     */
    static public function add_term_id_column() {

        if ( AWS_Helpers::is_index_table_has_terms() == 'no_terms' ) {

            global $wpdb;
            $table_name = $wpdb->prefix . AWS_INDEX_TABLE_NAME;

            $wpdb->query("
                ALTER TABLE {$table_name}
                ADD COLUMN `term_id` BIGINT(20) UNSIGNED NOT NULL DEFAULT 0
            ");

        }

    }

    /*
     * Get index table specific source name from taxonomy name
     *
     * @return string Source name
     */
    static public function get_source_name( $taxonomy ) {

        $source_name = '';

        if ( $taxonomy === 'product_cat' ) {
            $source_name = 'category';
        }
        elseif ( $taxonomy === 'product_tag' ) {
            $source_name = 'tag';
        }
        elseif ( strpos( $taxonomy, 'pa_' ) === 0 ) {
            $source_name = 'attr_' . $taxonomy;
        }
        else {
            $taxonomies = AWS_Helpers::get_taxonomies( false, false );

            if ( $taxonomies && ! empty( $taxonomies ) && isset( $taxonomies[$taxonomy] ) ) {
                $source_name = 'tax_' . $taxonomy;
            }

        }

        return $source_name;

    }

    /*
     * Get special characters that must be striped
     */
    static public function get_special_chars() {

        $chars = array(
            '-',
            '_',
            '|',
            '+',
            '`',
            '~',
            '!',
            '@',
            '#',
            '$',
            '%',
            '^',
            '&',
            '*',
            '(',
            ')',
            '\\',
            '?',
            ';',
            ':',
            "'",
            '"',
            ".",
            ",",
            "<",
            ">",
            "{",
            "}",
            "/",
            "[",
            "]",
            "’",
            "“",
            "”"
        );

        return apply_filters( 'aws_special_chars', $chars );

    }

    /*
     * Replace stopwords
     */
    static public function filter_stopwords( $str_array ) {

        $stopwords = get_option( 'aws_pro_stopwords' );

        if ( $stopwords && $str_array && ! empty( $str_array ) ) {
            $stopwords_array = explode( ',', $stopwords );
            if ( $stopwords_array && ! empty( $stopwords_array ) ) {

                $stopwords_array = array_map( 'trim', $stopwords_array );

                foreach ( $str_array as $str_word => $str_count ) {
                    if ( in_array( $str_word, $stopwords_array ) ) {
                        unset( $str_array[$str_word] );
                    }
                }

            }
        }

        return $str_array;

    }

    /*
     * Wrapper for WPML print
     *
     * @return string Source name
     */
    static public function translate( $name, $value ) {

        if ( function_exists( 'icl_t' ) ) {
            return icl_t( 'aws', $name, $value );
        }

        return $value;

    }

    /*
     * Check whether the plugin is active by checking the active_plugins list.
     */
    static public function is_plugin_active( $plugin ) {

        return in_array( $plugin, (array) get_option( 'active_plugins', array() ) ) || AWS_Helpers::is_plugin_active_for_network( $plugin );

    }

    /*
     * Check whether the plugin is active for the entire network
     */
    static public function is_plugin_active_for_network( $plugin ) {
        if ( !is_multisite() )
            return false;

        $plugins = get_site_option( 'active_sitewide_plugins');
        if ( isset($plugins[$plugin]) )
            return true;

        return false;
    }

    /*
     * Options array that generate settings page
     */
    static public function options_array() {

        include AWS_PRO_DIR .'/includes/options.php';

        return $options;
    }

}

endif;