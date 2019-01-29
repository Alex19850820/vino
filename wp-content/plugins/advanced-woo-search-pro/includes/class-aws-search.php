<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'AWS_Search' ) ) :

/**
 * Class for plugin search action
 */
class AWS_Search {

    /**
     * @var AWS_Search Array of all plugin data $data
     */
    private $data = array();

    /**
     * @var AWS_Search ID of current form instance $form_id
     */
    private $form_id = 0;

    /**
     * @var AWS_Search ID of current filter $filter_id
     */
    private $filter_id = 0;

    /**
     * Return a singleton instance of the current class
     *
     * @return object
     */
    public static function factory() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new self();
            $instance->setup();
        }

        return $instance;
    }

    /**
     * Constructor
     */
    public function __construct() {}

    /**
     * Setup actions and filters for all things settings
     */
    public function setup() {

        $this->data['settings'] = get_option( 'aws_pro_settings' );

        add_action( 'wp_ajax_aws_action', array( $this, 'action_callback' ) );
        add_action( 'wp_ajax_nopriv_aws_action', array( $this, 'action_callback' ) );

    }

    /*
     * AJAX call action callback
     */
    public function action_callback() {

        echo json_encode( $this->search() );

        die;

    }

    /*
     * AJAX call action callback
     */
    public function search( $keyword = '' ) {

        global $wpdb;

        $this->form_id   = $_REQUEST['id'];
        $this->filter_id = $_REQUEST['filter'];

        $cache = AWS_PRO()->get_settings( 'cache', $this->form_id );
        $special_chars = AWS_Helpers::get_special_chars();

        $s = $keyword ? esc_attr( $keyword ) : esc_attr( $_REQUEST['keyword'] );
        $s = htmlspecialchars_decode( $s );
        $s = stripslashes( $s );
        $s = str_replace( array( "\r", "\n" ), '', $s );
        $s = str_replace( $special_chars, '', $s );
        $s = trim( $s );

        $cache_option_name = '';
            
        if ( $cache === 'true' && ! $keyword ) {
            $cache_option_name = AWS_PRO()->cache->get_cache_name( $s, $this->form_id, $this->filter_id );
            $res = AWS_PRO()->cache->get_from_cache_table( $cache_option_name );
            if ( $res ) {
                $cached_value = json_decode( $res );
                if ( $cached_value && ! empty( $cached_value ) ) {
                    return $cached_value;
                }
            }
        }

        $categories_array = array();
        $tags_array = array();
        $brands_array = array();

        $search_logic       = AWS_PRO()->get_settings( 'search_logic', $this->form_id );
        $style              = AWS_PRO()->get_settings( 'style', $this->form_id,  $this->filter_id );
        $outofstock         = AWS_PRO()->get_settings( 'outofstock', $this->form_id,  $this->filter_id );
        $product_visibility = AWS_PRO()->get_settings( 'product_visibility', $this->form_id,  $this->filter_id );
        $show_cats          = AWS_PRO()->get_settings( 'show_cats', $this->form_id,  $this->filter_id );
        $show_tags          = AWS_PRO()->get_settings( 'show_tags', $this->form_id,  $this->filter_id );
        $show_brands        = AWS_PRO()->get_settings( 'show_brands_archive', $this->form_id, $this->filter_id, 'woocommerce-brands/woocommerce-brands.php' );
        $results_num        = $keyword ? apply_filters( 'aws_page_results', 100 ) : AWS_PRO()->get_settings( 'results_num', $this->form_id,  $this->filter_id );
        $exclude_rel        = AWS_PRO()->get_settings( 'exclude_rel', $this->form_id,  $this->filter_id );
        $exclude_cats       = AWS_PRO()->get_settings( 'exclude_cats', $this->form_id,  $this->filter_id );
        $exclude_tags       = AWS_PRO()->get_settings( 'exclude_tags', $this->form_id,  $this->filter_id );
        $exclude_products   = AWS_PRO()->get_settings( 'exclude_products', $this->form_id,  $this->filter_id );

        $this->data['s']                  = $s;
        $this->data['search_terms']       = array();
        $this->data['search_in']          = $this->set_search_in();
        $this->data['results_num']        = $results_num ? $results_num : 10;
        $this->data['search_logic']       = $search_logic ? $search_logic : 'or';
        $this->data['exclude_rel']        = $exclude_rel;
        $this->data['exclude_cats']       = $exclude_cats;
        $this->data['exclude_tags']       = $exclude_tags;
        $this->data['exclude_products']   = $exclude_products;
        $this->data['outofstock']         = $outofstock;
        $this->data['product_visibility'] = $product_visibility;


        $search_array = array_unique( explode( ' ', $s ) );

        if ( is_array( $search_array ) && ! empty( $search_array ) ) {
            foreach ( $search_array as $search_term ) {
                $search_term = trim( $search_term );
                if ( $search_term ) {
                    $this->data['search_terms'][] = $search_term;
                }
            }
        }

        if ( empty( $this->data['search_terms'] ) ) {
            $this->data['search_terms'][] = '';
        }


        $posts_ids = $this->query_index_table();
        $products_array = $this->get_products( $posts_ids );

        /**
         * Filters array of products before they displayed in search results
         *
         * @since 1.31
         *
         * @param array $products_array Array of products results
         * @param string $s Search query
         */
        $products_array = apply_filters( 'aws_search_results_products', $products_array, $s );

        if ( $show_cats === 'true' ) {

            $categories_array = $this->get_taxonomies( 'product_cat' );

            /**
             * Filters array of product categories before they displayed in search results
             *
             * @since 1.31
             *
             * @param array $categories_array Array of products categories
             * @param string $s Search query
             */
            $categories_array = apply_filters( 'aws_search_results_categories', $categories_array, $s );

        }

        if ( $show_tags === 'true' ) {

            $tags_array = $this->get_taxonomies( 'product_tag' );

            /**
             * Filters array of product tags before they displayed in search results
             *
             * @since 1.31
             *
             * @param array $tags_array Array of products tags
             * @param string $s Search query
             */
            $tags_array = apply_filters( 'aws_search_results_tags', $tags_array, $s );

        }

        if ( $show_brands === 'true' ) {

            $brands_array = $this->get_taxonomies( 'product_brand' );

            /**
             * Filters array of product brands before they displayed in search results
             *
             * @since 1.31
             *
             * @param array $brands_array Array of products brands
             * @param string $s Search query
             */
            $brands_array = apply_filters( 'aws_search_results_brands', $brands_array, $s );

        }

        $result_array = array(
            'cats'     => $categories_array,
            'tags'     => $tags_array,
            'brands'   => $brands_array,
            'products' => $products_array,
            'style'    => $style,
            'sql'      => $this->data['sql']
        );

        /**
         * Filters array of all results data before they displayed in search results
         *
         * @since 1.32
         *
         * @param array $brands_array Array of products data
         * @param string $s Search query
         */
        $result_array = apply_filters( 'aws_search_results_all', $result_array, $s );

        if ( $cache === 'true' && ! $keyword ) {
            AWS_PRO()->cache->insert_into_cache_table( $cache_option_name, $result_array );
        }

        return $result_array;

    }

    /*
     * Query product taxonomies
     */
    private function get_taxonomies( $taxonomy ) {

        global $wpdb;

        $result_array = array();
        $search_array = array();
        $excludes = '';
        $search_query = '';
        $search_logic = $this->data['search_logic'];
        $search_logic_operator = 'OR';

        $filtered_terms = AWS_Helpers::filter_stopwords( array_count_values( $this->data['search_terms'] ) );

        if ( $filtered_terms && ! empty( $filtered_terms ) ) {
            foreach ( $filtered_terms as $search_term => $search_term_count ) {
                $like = '%' . $wpdb->esc_like($search_term) . '%';
                $search_array[] = $wpdb->prepare('( name LIKE %s )', $like);
            }
        } else {
            return $result_array;
        }

        if ( $search_logic === 'and' ) {
            $search_logic_operator = 'AND';
        }

        $search_query .= sprintf( ' AND ( %s )', implode( sprintf( ' %s ', $search_logic_operator ), $search_array ) );

        $sql = "
			SELECT
				distinct($wpdb->terms.name),
				$wpdb->terms.term_id,
				$wpdb->term_taxonomy.taxonomy,
				$wpdb->term_taxonomy.count
			FROM
				$wpdb->terms
				, $wpdb->term_taxonomy
			WHERE 1 = 1
				{$search_query}
				AND $wpdb->term_taxonomy.taxonomy = '{$taxonomy}'
				AND $wpdb->term_taxonomy.term_id = $wpdb->terms.term_id
			$excludes
			LIMIT 0, 10";


        $search_results = $wpdb->get_results( $sql );

        if ( ! empty( $search_results ) && !is_wp_error( $search_results ) ) {

            foreach ( $search_results as $result ) {

                $term_image = '';

                if ( ! $result->count > 0 ) {
                    continue;
                }

                if ( function_exists( 'wpml_object_id_filter' )  ) {
                    $term = wpml_object_id_filter( $result->term_id, $result->taxonomy );
                    if ( $term != $result->term_id ) {
                        continue;
                    }
                } else {
                    $term = get_term( $result->term_id, $result->taxonomy );
                }

                if ( $term != null && !is_wp_error( $term ) ) {
                    $term_link = get_term_link( $term );

                    if ( $taxonomy === 'product_brand' ) {
                        $term_image = AWS_Helpers::get_term_thumbnail( $result->term_id );
                    }

                } else {
                    continue;
                }

                $new_result = array(
                    'name'     => $result->name,
                    'count'    => $result->count,
                    'link'     => $term_link,
                    'image'    => $term_image
                );

                $result_array[] = $new_result;

            }

        }

        return $result_array;

    }

    /*
     * Query in index table
     */
    private function query_index_table() {

        global $wpdb;

        $table_name = $wpdb->prefix . AWS_INDEX_TABLE_NAME;

        $search_logic       = $this->data['search_logic'];
        $search_in_arr      = $this->data['search_in'];
        $results_num        = $this->data['results_num'];
        $exclude_rel        = $this->data['exclude_rel'];
        $exclude_cats       = $this->data['exclude_cats'];
        $exclude_tags       = $this->data['exclude_tags'];
        $exclude_products   = $this->data['exclude_products'];
        $outofstock         = $this->data['outofstock'];
        $product_visibility = $this->data['product_visibility'];


        $reindex_version = get_option( 'aws_pro_reindex_version' );

        $query = array();

        $query['search']           = '';
        $query['source']           = '';
        $query['relevance']        = '';
        $query['exclude_terms']    = '';
        $query['exclude_products'] = '';
        $query['stock']            = '';
        $query['visibility']       = '';
        $query['lang']             = '';
        $query['having']           = '';

        $search_array = array();
        $source_array = array();
        $relevance_array = array();
        $new_relevance_array = array();


        foreach ( $this->data['search_terms'] as $search_term ) {

            $search_term_len = strlen( $search_term );


            $relevance_title        = 200 + 20 * $search_term_len;
            $relevance_content      = 35 + 4 * $search_term_len;
            $relevance_title_like   = 40 + 2 * $search_term_len;
            $relevance_content_like = 35 + 1 * $search_term_len;


            if ( $search_logic === 'and' ) {
                $search_term_like = $search_term;
            } else {
                $search_term_like = preg_replace( '/(s|es|ies)$/i', '', $search_term );
            }

            $like = '%' . $wpdb->esc_like( $search_term_like ) . '%';


            if ( ( $search_term_len > 1 || ! $search_term_len ) && $search_logic !== 'and' ) {
                $search_array[] = $wpdb->prepare( '( term LIKE %s )', $like );
            } else {
                $search_array[] = $wpdb->prepare( '( term = "%s" )', $search_term );
            }

            foreach ( $search_in_arr as $search_in_term ) {

                switch ( $search_in_term ) {

                    case 'title':
                        $relevance_array['title'][] = $wpdb->prepare( "( case when ( term_source = 'title' AND term = '%s' ) then {$relevance_title} * count else 0 end )", $search_term );
                        $relevance_array['title'][] = $wpdb->prepare( "( case when ( term_source = 'title' AND term LIKE %s ) then {$relevance_title_like} * count else 0 end )", $like );
                        break;

                    case 'content':
                        $relevance_array['content'][] = $wpdb->prepare( "( case when ( term_source = 'content' AND term = '%s' ) then {$relevance_content} * count else 0 end )", $search_term );
                        $relevance_array['content'][] = $wpdb->prepare( "( case when ( term_source = 'content' AND term LIKE %s ) then {$relevance_content_like} * count else 0 end )", $like );
                        break;

                    case 'excerpt':
                        $relevance_array['content'][] = $wpdb->prepare( "( case when ( term_source = 'excerpt' AND term = '%s' ) then {$relevance_content} * count else 0 end )", $search_term );
                        $relevance_array['content'][] = $wpdb->prepare( "( case when ( term_source = 'excerpt' AND term LIKE %s ) then {$relevance_content_like} * count else 0 end )", $like );
                        break;

                    case 'category':
                        $relevance_array['category'][] = $wpdb->prepare( "( case when ( term_source = 'category' AND term = '%s' ) then 35 else 0 end )", $search_term );
                        $relevance_array['category'][] = $wpdb->prepare( "( case when ( term_source = 'category' AND term LIKE %s ) then 5 else 0 end )", $like );
                        break;

                    case 'tag':
                        $relevance_array['tag'][] = $wpdb->prepare( "( case when ( term_source = 'tag' AND term = '%s' ) then 35 else 0 end )", $search_term );
                        $relevance_array['tag'][] = $wpdb->prepare( "( case when ( term_source = 'tag' AND term LIKE %s ) then 5 else 0 end )", $like );
                        break;

                    case 'sku':
                        $relevance_array['sku'][] = $wpdb->prepare( "( case when ( term_source = 'sku' AND term = '%s' ) then 300 else 0 end )", $search_term );
                        $relevance_array['sku'][] = $wpdb->prepare( "( case when ( term_source = 'sku' AND term LIKE %s ) then 50 else 0 end )", $like );
                        break;

                    default:
                        $relevance_array[$search_in_term][] = $wpdb->prepare( "( case when ( term_source = '%s' AND term = '%s' ) then 35 else 0 end )", $search_in_term, $search_term );
                        $relevance_array[$search_in_term][] = $wpdb->prepare( "( case when ( term_source = '%s' AND term LIKE %s ) then 5 else 0 end )", $search_in_term, $like );

                }

            }

        }


        // Sort 'relevance' queries in the array by search priority
        foreach ( $search_in_arr as $search_in_item ) {
            if ( isset( $relevance_array[$search_in_item] ) ) {
                $new_relevance_array[$search_in_item] = implode( ' + ', $relevance_array[$search_in_item] );
            }
        }

        foreach ( $search_in_arr as $search_in_term ) {
            $source_array[] = "term_source = '{$search_in_term}'";
        }

        $query['relevance'] .= sprintf( ' (SUM( %s )) ', implode( ' + ', $new_relevance_array ) );
        $query['search'] .= sprintf( ' AND ( %s )', implode( ' OR ', $search_array ) );
        $query['source'] .= sprintf( ' AND ( %s )', implode( ' OR ', $source_array ) );

        if ( $outofstock === 'false' ) {
            $query['stock'] .= " AND in_stock = 1";
        } elseif ( $outofstock === 'out' ) {
            $query['stock'] .= " AND in_stock = 0";
        }


        if ( $product_visibility ) {

            $visibility_array = array();

            foreach( $product_visibility as $visibility => $is_active ) {
                if ( $is_active ) {
                    $like = '%' . $wpdb->esc_like( $visibility ) . '%';
                    $visibility_array[] = $wpdb->prepare( '( visibility LIKE %s )', $like );
                }
            }

            //$query['visibility'] .= " AND ( visibility LIKE '%hidden%' )";

            $query['visibility'] .= sprintf( ' AND ( %s )', implode( ' OR ', $visibility_array ) );

        }


        // Exclude products from certain terms
        
        $exclude_array = array();
        $exclude_relation = ( $exclude_rel === 'exclude' ) ? 'NOT IN' : 'IN';
        $exclude_relation = apply_filters( 'aws_exclude_relation', $exclude_relation );

        $exclude_cats = apply_filters( 'aws_cats_filter', $exclude_cats );
        $exclude_tags = apply_filters( 'aws_tags_filter', $exclude_tags );


        if ( $exclude_cats || $exclude_tags ) {

            $exclude_terms = '0';

            $exclude_cats = trim( $exclude_cats );
            $exclude_cats = trim( $exclude_cats, ',' );

            $exclude_tags = trim( $exclude_tags );
            $exclude_tags = trim( $exclude_tags, ',' );

            if ( $exclude_cats && ! preg_match( "/[^\\d^,^\\s]/i", $exclude_cats ) ) {
                $exclude_terms = $exclude_terms . $exclude_cats;
            }

            if ( $exclude_tags && ! preg_match( "/[^\\d^,^\\s]/i", $exclude_tags ) ) {
                $exclude_terms = $exclude_terms . ', ' . $exclude_tags;
            }

            $exclude_array['exclude_terms'] = "( id {$exclude_relation} (
               SELECT object_id FROM $wpdb->term_relationships
               WHERE term_taxonomy_id IN ( select term_taxonomy_id from $wpdb->term_taxonomy WHERE term_id IN ({$exclude_terms}))
            ) )";   
               
        }

        // Exclude certain products

        $exclude_products = apply_filters( 'aws_products_filter', $exclude_products );

        if ( $exclude_products && ! preg_match( "/[^\\d^,^\\s]/i", $exclude_products ) ) {

            $exclude_products = trim( $exclude_products );
            $exclude_products = trim( $exclude_products, ',' );

            $exclude_array['exclude_products'] = "( id {$exclude_relation} (
               {$exclude_products}
            ) )";

        }
        
        if ( $exclude_array ) {
            $exclude_word = ( $exclude_rel === 'exclude' ) ? ' AND ' : ' OR ';
            $query['exclude_terms'] .= sprintf( ' AND ( %s )', implode( $exclude_word, $exclude_array ) );
        }


        // Exclude certain products with special filter
        $exclude_products_filter = apply_filters( 'aws_exclude_products', array() );

        if ( $exclude_products_filter && ! empty( $exclude_products_filter ) ) {
            $query['exclude_terms'] .= sprintf( ' AND ( id NOT IN ( %s ) )', implode( ',', $exclude_products_filter ) );
        }



        if ( ( defined( 'ICL_SITEPRESS_VERSION' ) || function_exists( 'pll_current_language' ) ) && $reindex_version && version_compare( $reindex_version, '1.02', '>=' ) ) {

            $current_lang = false;

            if ( has_filter('wpml_current_language') ) {
                $current_lang = apply_filters( 'wpml_current_language', NULL );
            } elseif ( function_exists( 'pll_current_language' ) ) {
                $current_lang = pll_current_language();
            }

            if ( $current_lang ) {
                $query['lang'] .= $wpdb->prepare( " AND ( lang LIKE %s OR lang = '' )", $current_lang );
            }

        } elseif( function_exists( 'qtranxf_getLanguage' ) ) {

            $current_lang = qtranxf_getLanguage();

            if ( $current_lang ) {
                $query['lang'] .= $wpdb->prepare( " AND ( lang LIKE %s OR lang = '' )", $current_lang );
            }

        }


        if ( $search_logic === 'and' ) {
            $terms_number = count( $this->data['search_terms'] );
            if ( $terms_number ) {
                $having_count = $terms_number - 1;
                if ( $having_count < 0 ) {
                    $having_count = 0;
                }
                $query['having'] = sprintf( ' having count(distinct term) > %s', $having_count );
            }
        }


        $sql = "SELECT
                    distinct ID,
                    {$query['relevance']} as relevance
                FROM
                    {$table_name}
                WHERE
                    type = 'product'
                {$query['source']}
                {$query['search']}
                {$query['exclude_terms']}
                {$query['stock']}
                {$query['visibility']}
                {$query['lang']}
                GROUP BY ID
                {$query['having']}
                ORDER BY 
                    relevance DESC
		LIMIT 0, {$results_num}
		";
      
                
        $this->data['sql'] = $sql;

        $posts_ids = $this->get_posts_ids( $sql );

        return $posts_ids;

    }

    /*
     * Set sources to search_in option
     */
    private function set_search_in() {

        $search_in      = AWS_PRO()->get_settings( 'search_in', $this->form_id,  $this->filter_id );
        $search_in_attr = AWS_PRO()->get_settings( 'search_in_attr', $this->form_id,  $this->filter_id );
        $search_in_tax  = AWS_PRO()->get_settings( 'search_in_tax', $this->form_id,  $this->filter_id );
        $search_in_meta = AWS_PRO()->get_settings( 'search_in_meta', $this->form_id,  $this->filter_id );

        $search_in_arr = array();
        $search_in_temp = array();

        if ( is_array( $search_in ) ) {
            foreach( $search_in as $search_in_source => $search_in_active ) {
                if ( $search_in_active ) {
                    $search_in_arr[] = $search_in_source;
                }
            }
        } else {
            $search_in_arr = explode( ',',  $search_in );
        }

        // Search in title if all options is disabled
        if ( ! $search_in || ( is_array( $search_in_arr ) && empty( $search_in_arr ) ) ) {
            $search_in_arr = array( 'title' );
        }

        if ( $search_in_arr && is_array( $search_in_arr ) && ! empty( $search_in_arr ) ) {
            foreach ( $search_in_arr as $search_source ) {
                switch ( $search_source ) {

                    case 'attr':

                        $available_attributes = AWS_Helpers::get_attributes();

                        if ( $available_attributes && ! empty( $available_attributes ) ) {
                            if ( $search_in_attr && is_array( $search_in_attr ) && ! empty( $search_in_attr ) ) {
                                foreach( $available_attributes as $available_attribute_val => $available_attribute_label ) {
                                    if ( isset( $search_in_attr[$available_attribute_val] ) && $search_in_attr[$available_attribute_val] ) {
                                        $search_in_temp[] = $available_attribute_val;
                                    }
                                }
                            }
                        }

                        break;

                    case 'tax':

                        $available_tax = AWS_Helpers::get_taxonomies();

                        if ( $available_tax && ! empty( $available_tax ) ) {
                            if ( $search_in_tax && is_array( $search_in_tax ) && ! empty( $search_in_tax ) ) {
                                foreach( $available_tax as $available_tax_val => $available_tax_label ) {
                                    if ( isset( $search_in_tax[$available_tax_val] ) && $search_in_tax[$available_tax_val] ) {
                                        $search_in_temp[] = $available_tax_val;
                                    }
                                }
                            }
                        }

                        break;

                    case 'meta':

                        $available_meta = AWS_Helpers::get_custom_fields();

                        if ( $available_meta && ! empty( $available_meta ) ) {
                            if ( $search_in_meta && is_array( $search_in_meta ) && ! empty( $search_in_meta ) ) {
                                foreach( $available_meta as $available_meta_val => $available_meta_label ) {
                                    if ( isset( $search_in_meta[$available_meta_val] ) && $search_in_meta[$available_meta_val] ) {
                                        $search_in_temp[] = $available_meta_val;
                                    }
                                }
                            }
                        }

                        break;

                    default:
                        $search_in_temp[] = $search_source;

                }
            }
        }

        return $search_in_temp;

    }

    /*
     * Get array of included to search result posts ids
     */
    private function get_posts_ids( $sql ) {

        global $wpdb;

        $posts_ids = array();

        $search_results = $wpdb->get_results( $sql );


        if ( !empty( $search_results ) && !is_wp_error( $search_results ) && is_array( $search_results ) ) {
            foreach ( $search_results as $search_result ) {
                $post_id = intval( $search_result->ID );
                if ( ! in_array( $post_id, $posts_ids ) ) {
                    $posts_ids[] = $post_id;
                }
            }
        }

        unset( $search_results );

        return $posts_ids;

    }

    /*
     * Get products info
     */
    private function get_products( $posts_ids ) {

        $products_array = array();

        if ( count( $posts_ids ) > 0 ) {

            $excerpt_source    = AWS_PRO()->get_settings( 'desc_source', $this->form_id );

            $mark_search_words = AWS_PRO()->get_settings( 'mark_words', $this->form_id, $this->filter_id );
            $style             = AWS_PRO()->get_settings( 'style', $this->form_id, $this->filter_id );
            $show_excerpt      = AWS_PRO()->get_settings( 'show_excerpt', $this->form_id, $this->filter_id );
            $excerpt_length    = AWS_PRO()->get_settings( 'excerpt_length', $this->form_id, $this->filter_id );
            $show_price        = AWS_PRO()->get_settings( 'show_price', $this->form_id, $this->filter_id );
            $show_sale         = AWS_PRO()->get_settings( 'show_sale', $this->form_id, $this->filter_id );
            $show_sku          = AWS_PRO()->get_settings( 'show_sku', $this->form_id, $this->filter_id );
            $show_stock_status = AWS_PRO()->get_settings( 'show_stock', $this->form_id, $this->filter_id );
            $show_image        = AWS_PRO()->get_settings( 'show_image', $this->form_id, $this->filter_id );
            $show_cats         = AWS_PRO()->get_settings( 'show_result_cats', $this->form_id, $this->filter_id );
            $show_brands       = AWS_PRO()->get_settings( 'show_result_brands', $this->form_id, $this->filter_id, 'woocommerce-brands/woocommerce-brands.php' );
            $show_rating       = AWS_PRO()->get_settings( 'show_rating', $this->form_id, $this->filter_id );
            $show_featured     = AWS_PRO()->get_settings( 'show_featured', $this->form_id, $this->filter_id );
            $show_variations   = AWS_PRO()->get_settings( 'show_variations', $this->form_id, $this->filter_id );


            foreach ( $posts_ids as $post_id ) {

                $product = wc_get_product( $post_id );

                if( ! is_a( $product, 'WC_Product' ) ) {
                    continue;
                }

                $post_data = get_post( $post_id );

                $title = $product->get_title();
                $title = AWS_Helpers::html2txt( $title );

                $excerpt = '';
                $price   = '';
                $on_sale = '';
                $sku = '';
                $stock_status = '';
                $image = '';
                $categories = '';
                $brands = '';
                $rating = '';
                $is_featured = '';
                $reviews = '';
                $variations = '';

                if ( $show_excerpt === 'true' ) {
                    $excerpt = ( $excerpt_source === 'excerpt' && $post_data->post_excerpt ) ? $post_data->post_excerpt : $post_data->post_content;
                    $excerpt = AWS_Helpers::html2txt( $excerpt );
                    $excerpt = str_replace('"', "'", $excerpt);
                    $excerpt = strip_shortcodes( $excerpt );
                    $excerpt = AWS_Helpers::strip_shortcodes( $excerpt );
                }

                if ( $mark_search_words === 'true'  ) {

                    $marked_content = $this->mark_search_words( $title, $excerpt );

                    $title = $marked_content['title'];

                    if ( $marked_content['content'] ) {
                        $excerpt = $marked_content['content'];
                    } else {
                        $excerpt = wp_trim_words( $excerpt, $excerpt_length, '...' );
                    }

                } else {
                    $excerpt = wp_trim_words( $excerpt, $excerpt_length, '...' );
                }

                if ( $show_price === 'true' ) {
                    $price = $product->get_price_html();
                }

                if ( $show_sale === 'true' ) {
                    $on_sale = $product->is_on_sale();
                }

                if ( $show_sku === 'true' ) {
                    $sku = $product->get_sku();
                }
                
                if ( $show_stock_status === 'true' || $show_stock_status === 'quantity' ) {
                    if ( $product->is_in_stock() ) {
                        
                        if ( $show_stock_status === 'quantity' && $product->get_stock_quantity() ) {
                            $stock_status = array(
                                'status' => true,
                                'text'   => $product->get_stock_quantity() . ' ' . __( 'in stock', 'aws' )
                            );
                        } else {
                            $stock_status = array(
                                'status' => true,
                                'text'   => __( 'In stock', 'aws' )
                            );
                        }
                       
                    } else {
                        $stock_status = array(
                            'status' => false,
                            'text'   => __( 'Out of stock', 'aws' )
                        );
                    }
                }
              
                if ( $show_image === 'true' ) {
                    $image_size = ( $style === 'style-big-grid' ) ? 'normal' : 'thumbnail';
                    $image = $this->get_image( $product, $image_size, $post_data );
                }

                if ( $show_cats === 'true' ) {
                    $categories = $this->get_terms_list( $post_id, 'product_cat' );
                }

                if ( $show_brands === 'true' ) {
                    $brands = AWS_Helpers::get_product_brands( $post_id );
                }

                if ( $show_rating === 'true' ) {
                    $rating = $product->get_average_rating();
                    $rating = $rating ? $rating * 20 : '';
                    $reviews = sprintf( _nx( '1 Review', '%1$s Reviews', $product->get_review_count(), 'product reviews', 'aws' ), number_format_i18n( $product->get_review_count() ) );
                }

                if ( $show_featured === 'true' ) {
                    $is_featured = $product->is_featured();
                }

                if ( $show_variations === 'true' ) {
                    if ( $product->is_type( 'variable' ) ) {
                        $var = new WC_Product_Variable( $post_id );
                        $variations_array = $var->get_variation_attributes();
                        $variations = array();

                        foreach ( $variations_array as $variation_key => $variation_value ) {
                            $attr_tax = get_taxonomy( $variation_key );
                            if ( ! is_wp_error( $attr_tax ) && $attr_tax ) {
                                $attr_terms = get_the_terms( $post_id, $variation_key );
                                if ( ! is_wp_error( $attr_terms ) && ! empty( $attr_terms ) ) {
                                    $attr_terms_array = array();
                                    foreach ( $attr_terms as $attr_term ) {
                                        if ( in_array( $attr_term->slug, $variation_value ) ) {
                                            $attr_terms_array[] = $attr_term->name;
                                        }
                                    }

                                    if ( ! empty( $attr_terms_array ) ) {
                                        $variations[$attr_tax->labels->singular_name] = $attr_terms_array;
                                    }

                                }
                            }
                        }

                    }
                }


                $tags = $this->get_terms_list( $post_id, 'product_tag' );

                $f_price   = $product->get_price();
                $f_rating  = $product->get_average_rating();
                $f_reviews = $product->get_review_count();

                $title   = apply_filters( 'aws_title_search_result', $title, $post_id, $product );
                $excerpt = apply_filters( 'aws_excerpt_search_result', $excerpt, $post_id, $product );

                $new_result = array(
                    'title'        => $title,
                    'excerpt'      => $excerpt,
                    'link'         => get_permalink( $post_id ),
                    'image'        => $image,
                    'price'        => $price,
                    'categories'   => $categories,
                    'tags'         => $tags,
                    'brands'       => $brands,
                    'on_sale'      => $on_sale,
                    'sku'          => $sku,
                    'stock_status' => $stock_status,
                    'featured'     => $is_featured,
                    'rating'       => $rating,
                    'reviews'      => $reviews,
                    'variations'   => $variations,
                    'f_price'      => $f_price,
                    'f_rating'     => $f_rating,
                    'f_reviews'    => $f_reviews,
                    'post_data'    => $post_data
                );

                $products_array[] = $new_result;

            }

        }

        return $products_array;

    }

    /*
	 * Get string with current product terms
	 *
	 * @return string List of terms
	 */
    private function get_terms_list( $id, $taxonomy ) {

        $terms = get_the_terms( $id, $taxonomy );

        if ( is_wp_error( $terms ) ) {
            return '';
        }

        if ( empty( $terms ) ) {
            return '';
        }

        $cats_array_temp = array();

        foreach ( $terms as $term ) {
            $cats_array_temp[] = $term->name;
        }

        return implode( ', ', $cats_array_temp );

    }

    /*
     * Get product image
     *
     * @return string Image url
     */
    private function get_image( $product, $image_size, $post_data ) {

        $image_sources = AWS_PRO()->get_settings( 'image_source', $this->form_id );
        $default_img   = AWS_PRO()->get_settings( 'default_img', $this->form_id );

        $post_id = $post_data->ID;

        $image_sources_array = explode( ',', $image_sources );

        $image_src = '';

        if ( empty( $image_sources_array ) ) {
            return '';
        }

        foreach ( $image_sources_array as $image_source ) {

            switch( $image_source ) {

                case 'featured';

                    $post_thumbnail_id = get_post_thumbnail_id( $post_id );
                    $thumb_url_array = wp_get_attachment_image_src( $post_thumbnail_id, $image_size );
                    $image_src = $thumb_url_array[0];

                    break;

                case 'gallery';

                    $gallery_images_array = method_exists( $product, 'get_gallery_image_ids' ) ? $product->get_gallery_image_ids() : ( method_exists( $product, 'get_gallery_attachment_ids' ) ? $product->get_gallery_attachment_ids() : array() );

                    if ( ! empty( $gallery_images_array ) ) {
                        $gallery_url_array = wp_get_attachment_image_src( $gallery_images_array[0], $image_size );
                        $image_src = $gallery_url_array[0];
                    }

                    break;

                case 'content';

                    $image_src = $this->scrap_img( $post_data->post_content );

                    break;

                case 'description';

                    $image_src = $this->scrap_img( $post_data->post_excerpt );

                    break;

                case 'default';

                    $image_src = $default_img;

                    break;

            }

            if ( $image_src ) {
                break;
            }

        }

        return $image_src;

    }

    /*
     * Scrap img src from string
     *
     * @return string Image src url
     */
    private function scrap_img( $content ) {
        preg_match( '|<img.*?src=[\'"](.*?)[\'"].*?>|i', $content, $matches );
        $result = ( isset( $matches[1] ) && $matches[1] ) ? $matches[1] : '';
        return $result;
    }

    /*
     * Mark search words
     */
    private function mark_search_words( $title, $content ) {

        $pattern = array();
        $exact_pattern = array();
        $exact_words = array();
        $words = array();

        foreach( $this->data['search_terms'] as $search_in ) {

            $exact_words[] = '\b' . $search_in . '\b';
            $exact_pattern[] = '(\b' . $search_in . '\b)+';

            if ( strlen( $search_in ) > 1 ) {
                $pattern[] = '(' . $search_in . ')+';
                $words[] = $search_in;
            } else {
                $pattern[] = '\b[' . $search_in . ']{1}\b';
                $words[] = '\b' . $search_in . '\b';
            }

        }

        usort( $exact_words, array( $this, 'sort_by_length' ) );
        $exact_words = implode( '|', $exact_words );

        usort( $words, array( $this, 'sort_by_length' ) );
        $words = implode( '|', $words );

        usort( $exact_pattern, array( $this, 'sort_by_length' ) );
        $exact_pattern = implode( '|', $exact_pattern );
        $exact_pattern = sprintf( '/%s/i', $exact_pattern );

        usort( $pattern, array( $this, 'sort_by_length' ) );
        $pattern = implode( '|', $pattern );
        $pattern = sprintf( '/%s/i', $pattern );


        preg_match( '/([^.?!]*?)(' . $exact_words . '){1}(.*?[.!?])/i', $content, $matches );

        if ( ! isset( $matches[0] ) ) {
            preg_match( '/([^.?!]*?)(' . $words . '){1}(.*?[.!?])/i', $content, $matches );
        }

        if ( ! isset( $matches[0] ) ) {
            preg_match( '/([^.?!]*?)(.*?)(.*?[.!?])/i', $content, $matches );
        }


        if ( isset( $matches[0] ) ) {

            $content = $matches[0];

            // Trim to long content
            if (str_word_count(strip_tags($content)) > 34) {

                if (str_word_count(strip_tags($matches[3])) > 34) {
                    $matches[3] = wp_trim_words($matches[3], 30, '...');
                }

                $content = '...' . $matches[2] . $matches[3];

            }

        } else {

            $content = '';

        }

        $title_has_exact = preg_match( '/(' . $exact_words . '){1}/i', $title );
        $content_has_exact = preg_match( '/(' . $exact_words . '){1}/i', $content );


        if ( $title_has_exact === 1 || $content_has_exact === 1 ) {
            $title = preg_replace($exact_pattern, '<strong>${0}</strong>', $title );
            $content = preg_replace($exact_pattern, '<strong>${0}</strong>', $content );
        } else {
            $title = preg_replace($pattern, '<strong>${0}</strong>', $title );
            $content = preg_replace( $pattern, '<strong>${0}</strong>', $content );
        }


        return array(
            'title'   => $title,
            'content' => $content
        );

    }

    /*
     * Sort array by its values length
     */
    private function sort_by_length( $a, $b ) {
        return strlen( $b ) - strlen( $a );
    }

    /*
     * Check if the terms are suitable for searching
     */
    private function parse_search_terms( $terms ) {

        $strtolower = function_exists( 'mb_strtolower' ) ? 'mb_strtolower' : 'strtolower';
        $checked = array();

        $stopwords = $this->get_search_stopwords();

        foreach ( $terms as $term ) {

            // Avoid single A-Z.
            if ( ! $term || ( 1 === strlen( $term ) && preg_match( '/^[a-z]$/i', $term ) ) )
                continue;

            if ( in_array( call_user_func( $strtolower, $term ), $stopwords, true ) )
                continue;

            $checked[] = $term;
        }

        return $checked;

    }

    /*
     * Get array of stopwords
     */
    private function get_search_stopwords() {

        $stopwords = array( 'about','an','are','as','at','be','by','com','for','from','how','in','is','it','of','on','or','that','the','this','to','was','what','when','where','who','will','with','www' );

        return $stopwords;

    }

}

endif;


AWS_Search::factory();

function aws_search( $keyword = '' ) {
    return AWS_Search::factory()->search( $keyword );
}