<?php
    global $woocommerce;
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    //$twi_woo_search = (!empty($_GET['twi_woo_search ' ]))? $_GET['twi_woo_search ' ] :$twi_woo_search = '';
 if( $pro_dis_style == 'cat_wise' || $pro_dis_style == NULL ) {
	if($twi_woo_cats == NULL){
        if($woo_orby == 'title'){
		     $query_args = array(
	                'post_type' => 'product',
	                'paged' => $paged,
				    'post_status' => 'publish',
				    'orderby' => 'title',
				    'meta_key' => '',
					'ignore_sticky_posts'   => 1,
					//'s'=> $twi_woo_search,
					'order' => $woo_order,
					'posts_per_page' => $twi_woo_per_page
	         );
         }
         if($woo_orby == 'date'){
		     $query_args = array(
	                'post_type' => 'product',
	                'paged' => $paged,
				    'post_status' => 'publish',
				    'orderby' => 'date',
				    'meta_key' => '',
					'ignore_sticky_posts'   => 1,
					//'s'=> $twi_woo_search,
					'order' => $woo_order,
					'posts_per_page' => $twi_woo_per_page
	         );
         }
         if($woo_orby == 'price'){
		     $query_args = array(
	                'post_type' => 'product',
	                'paged' => $paged,
				    'post_status' => 'publish',
				    'orderby' => 'meta_value_num',
				    'meta_key' => '_price',
					'ignore_sticky_posts'   => 1,
					//'s'=> $twi_woo_search,
					'order' => $woo_order,
					'posts_per_page' => $twi_woo_per_page
	         );
         }
         if($woo_orby == 'sku'){
		     $query_args = array(
	                'post_type' => 'product',
	                'paged' => $paged,
				    'post_status' => 'publish',
				    'orderby' => 'meta_value',
				    'meta_key' => '_sku',
					'ignore_sticky_posts'   => 1,
					//'s'=> $twi_woo_search,
					'order' => $woo_order,
					'posts_per_page' => $twi_woo_per_page
	         );
         }
         if($woo_orby == 'rand'){
		     $query_args = array(
	                'post_type' => 'product',
	                'paged' => $paged,
				    'post_status' => 'publish',
				    'orderby' => 'rand',
				    'meta_key' => '',
					'ignore_sticky_posts'   => 1,
					//'s'=> $twi_woo_search,
					'order' => 'rand',
					'posts_per_page' => $twi_woo_per_page
	         );
         }
         if($woo_orby == 'featured'){
		     $query_args = array(
	                'post_type' => 'product',
	                'paged' => $paged,
				    'post_status' => 'publish',
				    'meta_key' => '_featured',
                    'meta_value' => 'yes',
					'ignore_sticky_posts'   => 1,
					//'s'=> $twi_woo_search,
					'order' => $woo_order,
					'posts_per_page' => $twi_woo_per_page
	         );
         }
         if($woo_orby == 'pro_on_sale'){
            $product_ids_on_sale = woocommerce_get_product_ids_on_sale();
	        $product_ids_on_sale[] = 0;		
	        $meta_query = $woocommerce->query->get_meta_query();
         	$query_args = array(
				    'posts_per_page' 	=> $twi_woo_per_page,
					'no_found_rows' => 1,
					'post_status' 	=> 'publish',
					'post_type' 	=> 'product',
					//'s'=> $twi_woo_search,
					'paged' => $paged,
					'order' 		=> $woo_order,
					'meta_query' 	=> $meta_query,
					'post__in'		=> $product_ids_on_sale
			);
         }
         if($woo_orby == 'recent_pro'){
         	$query_args = array(
                    'post_type' => 'product',
                    'paged' => $paged,
			        'post_status' => 'publish',
			        'order' => 'desc',
					'ignore_sticky_posts' => 1,
					//'s'=> $twi_woo_search,
					'posts_per_page' => $twi_woo_per_page
            );
         }
        if($woo_orby == 'best_sellers'){
         	$query_args = array(
                'post_type' => 'product',
                'paged' => $paged,
				'post_status' => 'publish',
				'ignore_sticky_posts'   => 1,
				//'s'=> $twi_woo_search,
				'posts_per_page' => $twi_woo_per_page,
				'order' 		=> $woo_order,
				'meta_key' 		=> 'total_sales',
    			'orderby' 		=> 'meta_value_num'
            );
        }
        if($woo_orby == 'top_rated'){
            add_filter( 'posts_clauses',  array( $woocommerce->query, 'order_by_rating_post_clauses' ) );
	        $query_args = array(
	        	'posts_per_page' => $twi_woo_per_page,
	        	'paged' => $paged, 
	        	'order' => $woo_order,
	        	'no_found_rows' => 1, 
	        	//'s'=> $twi_woo_search,
	        	'post_status' => 'publish', 
	        	'post_type' => 'product' 
	        );
		    $query_args['meta_query'] = array();

	        $query_args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
	        $query_args['meta_query'][] = $woocommerce->query->visibility_meta_query();
	    }
	     if($woo_orby == 'recent_view'){
	 		$viewed_products = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) ? (array) explode( '|', $_COOKIE['woocommerce_recently_viewed'] ) : array();
	 		$viewed_products = array_filter( array_map( 'absint', $viewed_products ) );
	 		if ( empty( $viewed_products ) )
	 				return __( 'You have not viewed any product yet!', 'twi_awesome_woo_slider_carousel' );
	 		//if( !isset( $twi_woo_per_page ) ? $number = 5 : $number = $twi_woo_per_page )
	 	    $query_args = array(
	 	    				'posts_per_page' => $twi_woo_per_page, 
	 	    				'no_found_rows'  => 1, 
	 	    				'post_status'    => 'publish', 
	 	    				'post_type'      => 'product', 
	 	    				'post__in'       => $viewed_products
	 	    				);
	 		$query_args['meta_query']   = array();
	 		$query_args['meta_query'][] = WC()->query->stock_status_meta_query();
	 		$query_args['meta_query']   = array_filter( $query_args['meta_query'] );
	     }
	 }else{
	 	if($woo_orby == 'title'){
		    $query_args = array(
				'post_type' => 'product',
				'paged' => $paged,
				'post_status' => 'publish',
				'orderby' => 'title',
				'meta_key' => '',
				'tax_query' => array(
								array(
									'taxonomy' => 'product_cat',
									'field' => 'slug',
									'terms' => $twi_woo_cats
									)
								),
				'ignore_sticky_posts'   => 1,
				//'s'=> $twi_woo_search,
				'order' => $woo_order,
				'posts_per_page' => $twi_woo_per_page
			);
	    }
	    if($woo_orby == 'date'){
		    $query_args = array(
				'post_type' => 'product',
				'paged' => $paged,
				'post_status' => 'publish',
				'orderby' => 'date',
				'meta_key' => '',
				'tax_query' => array(
								array(
									'taxonomy' => 'product_cat',
									'field' => 'slug',
									'terms' => $twi_woo_cats
									)
								),
				'ignore_sticky_posts'   => 1,
				//'s'=> $twi_woo_search,
				'order' => $woo_order,
				'posts_per_page' => $twi_woo_per_page
			);
	    }
	    if($woo_orby == 'price'){
		    $query_args = array(
				'post_type' => 'product',
				'paged' => $paged,
				'post_status' => 'publish',
				'orderby' => 'meta_value_num',
				'meta_key' => '_price',
				'tax_query' => array(
								array(
									'taxonomy' => 'product_cat',
									'field' => 'slug',
									'terms' => $twi_woo_cats
									)
								),
				'ignore_sticky_posts'   => 1,
				//'s'=> $twi_woo_search,
				'order' => $woo_order,
				'posts_per_page' => $twi_woo_per_page
			);
	    }
	    if($woo_orby == 'sku'){
		    $query_args = array(
				'post_type' => 'product',
				'paged' => $paged,
				'post_status' => 'publish',
				'orderby' => 'meta_value',
				'meta_key' => '_sku',
				'tax_query' => array(
								array(
									'taxonomy' => 'product_cat',
									'field' => 'slug',
									'terms' => $twi_woo_cats
									)
								),
				'ignore_sticky_posts'   => 1,
				//'s'=> $twi_woo_search,
				'order' => $woo_order,
				'posts_per_page' => $twi_woo_per_page
			);
	    }
	    if($woo_orby == 'rand'){
		    $query_args = array(
				'post_type' => 'product',
				'paged' => $paged,
				'post_status' => 'publish',
				'orderby' => 'rand',
				'meta_key' => '',
				'tax_query' => array(
								array(
									'taxonomy' => 'product_cat',
									'field' => 'slug',
									'terms' => $twi_woo_cats
									)
								),
				'ignore_sticky_posts'   => 1,
				//'s'=> $twi_woo_search,
				'order' => 'rand',
				'posts_per_page' => $twi_woo_per_page
			);
	    }
	    if($woo_orby == 'featured'){
		    $query_args = array(
				'post_type' => 'product',
				'paged' => $paged,
				'post_status' => 'publish',
				'order' => $woo_order,
				'meta_key' => '_featured',
                'meta_value' => 'yes',
				'tax_query' => array(
								array(
									'taxonomy' => 'product_cat',
									'field' => 'slug',
									'terms' => $twi_woo_cats
									)
								),
				'ignore_sticky_posts'   => 1,
				//'s'=> $twi_woo_search,
				'posts_per_page' => $twi_woo_per_page
			);
	    }
	    if($woo_orby == 'pro_on_sale'){
            $product_ids_on_sale = woocommerce_get_product_ids_on_sale();
	        $product_ids_on_sale[] = 0;		
	        $meta_query = $woocommerce->query->get_meta_query();
		    $query_args = array(
				'post_type' => 'product',
				'paged' => $paged,
				'post_status' => 'publish',
				'order' => $woo_order,
				'tax_query' => array(
								array(
									'taxonomy' => 'product_cat',
									'field' => 'slug',
									'terms' => $twi_woo_cats
									)
								),
				'ignore_sticky_posts'   => 1,
				//'s'=> $twi_woo_search,
				'meta_query' 	=> $meta_query,
				'post__in'		=> $product_ids_on_sale,
				'posts_per_page' => $twi_woo_per_page
			);
	    }
	    if($woo_orby == 'recent_pro'){
		    $query_args = array(
				'post_type' => 'product',
				'paged' => $paged,
				'post_status' => 'publish',
				'order' => 'desc',
				'posts_per_page' => $twi_woo_per_page,
				//'s'=> $twi_woo_search,
				'tax_query' => array(
								array(
									'taxonomy' => 'product_cat',
									'field' => 'slug',
									'terms' => $twi_woo_cats
									)
								),
				'ignore_sticky_posts'   => 1
			);
	    }
	    if($woo_orby == 'best_sellers'){
		    $query_args = array(
				'post_type' => 'product',
				'paged' => $paged,
				'post_status' => 'publish',
				'posts_per_page' => $twi_woo_per_page,
				'meta_key' 		=> 'total_sales',
				'order' => $woo_order,
				//'s'=> $twi_woo_search,
    			'orderby' 		=> 'meta_value_num',
				'tax_query' => array(
								array(
									'taxonomy' => 'product_cat',
									'field' => 'slug',
									'terms' => $twi_woo_cats
									)
								),
				'ignore_sticky_posts'   => 1
			);
	    }

	    if($woo_orby == 'top_rated'){
            add_filter( 'posts_clauses',  array( $woocommerce->query, 'order_by_rating_post_clauses' ) );
	        $query_args = array(
	        	'posts_per_page' => $twi_woo_per_page, 
	        	'no_found_rows' => 1, 
	        	//'s'=> $twi_woo_search,
	        	'post_status' => 'publish',
	        	'paged' => $paged, 
	        	'order' => $woo_order,
	        	'tax_query' => array(
								array(
									'taxonomy' => 'product_cat',
									'field' => 'slug',
									'terms' => $twi_woo_cats
									)
								),
	        	'post_type' => 'product' 
	        );
		    $query_args['meta_query'] = array();
	        $query_args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
	        $query_args['meta_query'][] = $woocommerce->query->visibility_meta_query();
	    }
	    if($woo_orby == 'recent_view'){
			$viewed_products = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) ? (array) explode( '|', $_COOKIE['woocommerce_recently_viewed'] ) : array();
			$viewed_products = array_filter( array_map( 'absint', $viewed_products ) );

			if ( empty( $viewed_products ) )
					return __( 'You have not viewed any product yet!', 'twi_awesome_woo_slider_carousel' );
			if( !isset( $twi_woo_per_page ) ? $number = 5 : $number = $twi_woo_per_page )
		    $query_args = array(
		    				'posts_per_page' => $number, 
		    				'no_found_rows'  => 1, 
		    				'post_status'    => 'publish', 
		    				'post_type'      => 'product', 
		    				'order' => $woo_order,
	        		        'tax_query' => array(
								array(
									'taxonomy' => 'product_cat',
									'field' => 'slug',
									'terms' => $twi_woo_cats
									)
								),
		    				'post__in'       => $viewed_products
		    				);
			$query_args['meta_query']   = array();
			$query_args['meta_query'][] = WC()->query->stock_status_meta_query();
			$query_args['meta_query']   = array_filter( $query_args['meta_query'] );
	    }
	}
} // Cat Wise

elseif( $pro_dis_style == 'spe_pro' ) {

	$query_args = array(
	    'post__in' => $spe_pro,
	    'orderby' => 'post__in',
	    'paged' => $paged,
	    'post_type' => 'product',
	    'post_status' => 'publish',
	    'posts_per_page' => $twi_woo_per_page
    );

} // Sepecial Products
if(!empty($_GET['twi_filter'])){
    global $wp_query;
    $query_args['product_cat']=get_query_var('product_cat');
    $query_args['product_tag']=get_query_var('product_tag');
}
?>