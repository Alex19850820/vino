<?php
global $woocommerce;
//if ( 0 != $loop->found_posts):
?>
<div class="dp-sorter">
<p class="dp-result-count">
<?php
    

	$paged    = max( 1, $loop->get( 'paged' ) );
	$per_page = $loop->get( 'posts_per_page' );
	$total    = $loop->found_posts;
	$first    = ( $per_page * $paged ) - $per_page + 1;
	$last     = min( $total, $loop->get( 'posts_per_page' ) * $paged );

	if ( 1 == $total ) {
		echo __( 'Showing the single result', 'twi_awesome_woo_slider_carousel');
	} elseif ( $total <= $per_page || -1 == $per_page ) {
		echo sprintf( __( 'Showing all %d results', 'twi_awesome_woo_slider_carousel'), $total );
	} else {
		echo sprintf( _x( 'Showing %1$d–%2$d of %3$d results', '%1$d = first, %2$d = last, %3$d = total', 'twi_awesome_woo_slider_carousel'), $first, $last, $total );
	}

    echo '</p>';
    
    // Per page
    echo '<form class="dp-form-sorter" method="get"><div class="sort_dp_catalog_orderby">';    
        // Keep query string vars intact
        foreach ( $_GET as $key => $val ) {
                if ( 'orderby' == $key||'perpage' == $key)
                        continue;

                if (is_array($val)) {
                        foreach($val as $innerVal) {
                                $result.='<input type="hidden" name="' .  $key . '[]" value="' . $innerVal . '" />';
                        }

                } else {
                        $result.='<input type="hidden" name="' . $key  . '" value="' .  $val  . '" />';
                }
        }
        echo '<select name="orderby" class="dpOrderby">';
			$catalog_orderby = apply_filters( 'dp_catalog_orderby', array(
				'default' => __( 'Sort By Default Order', 'twi_awesome_woo_slider_carousel'),
				'popularity' => __( 'Sort by popularity', 'twi_awesome_woo_slider_carousel'),
				'newness'     => __( 'Sort by newness', 'twi_awesome_woo_slider_carousel'),
				'oldest'       => __( 'Sort by oldest', 'twi_awesome_woo_slider_carousel'),
				'nameaz'      => __( 'Sort by name: a to z', 'twi_awesome_woo_slider_carousel'),
				'nameza' => __( 'Sort by name: z to a', 'twi_awesome_woo_slider_carousel'),
				'lowhigh' => __( 'Sort by price: low to high', 'twi_awesome_woo_slider_carousel'),
				'highlow'     => __( 'Sort by price: high to low', 'twi_awesome_woo_slider_carousel'),
				'skulowhigh'       => __( 'Sort by SKU: low to high', 'twi_awesome_woo_slider_carousel'),
				'skuhighlow'      => __( 'Sort by SKU: high to low', 'twi_awesome_woo_slider_carousel'),
				'stocklowhigh' => __( 'Sort by stock: low to high', 'twi_awesome_woo_slider_carousel'),
				'stockhighlow'       => __( 'Sort by stock: high to low', 'twi_awesome_woo_slider_carousel'),
				'random'      => __( 'Sort by random', 'twi_awesome_woo_slider_carousel')
			) );

			if ( get_option( 'woocommerce_enable_review_rating' ) == 'no' )
				unset( $catalog_orderby['rating'] );
                        $orderby=!empty($_GET['orderby'])?$_GET['orderby']:'';
			foreach ( $catalog_orderby as $id => $name ){
                            
                            echo '<option value="' . esc_attr( $id ) . '" ' . selected( $orderby, $id, false ) . '>' . esc_attr( $name ) . '</option>';
                        }
		
	echo '</select></div><div class="sort_perpage">';
        echo __( 'Show ', 'twi_awesome_woo_slider_carousel').'<select name="perpage" class="dpPerpage">';
		
			$catalog_perpage = apply_filters( 'dp_catalog_perpage', array(
                'default' => __( 'Default', 'twi_awesome_woo_slider_carousel'),
				'4' => __( '4', 'twi_awesome_woo_slider_carousel'),
				'8' => __( '8', 'twi_awesome_woo_slider_carousel'),
				'12'=> __( '12', 'twi_awesome_woo_slider_carousel'),
				'15'  => __( '15', 'twi_awesome_woo_slider_carousel'),
				'30'      => __( '30', 'twi_awesome_woo_slider_carousel'),
				'80' => __( '80', 'twi_awesome_woo_slider_carousel'),
                                '-1' => __( 'All', 'twi_awesome_woo_slider_carousel'),
			) );

			if ( get_option( 'woocommerce_enable_review_rating' ) == 'no' )
				unset( $catalog_perpage['rating'] );
                        $perpage=!empty($_GET['perpage'])?$_GET['perpage']:'';
			foreach ( $catalog_perpage as $id => $name )
				echo '<option value="' . esc_attr( $id ) . '" ' . selected( $perpage, $id, false ) . '>' . esc_attr( $name ) . '</option>';
		
	echo '</select> '.__( 'per page', 'twi_awesome_woo_slider_carousel').'</div>';
	
        
//	$result.='<input type="hidden" name="dppage" value="1"/>';
    echo '</form>';
    
    

   
echo '</div>';
//endif;