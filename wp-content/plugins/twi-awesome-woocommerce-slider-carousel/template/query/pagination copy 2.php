<?php 
if ( $loop->max_num_pages <= 1 )
	return;
if ( get_query_var('paged') ) {
    $paged = get_query_var('paged');
 } else if ( get_query_var('page') ) {
    $paged = get_query_var('page');
 } else{
    $paged = 1;
 }
  /** 
   * We construct the pagination arguments to enter into our paginate_links
   * function. 
   */
  $pagination_args = array(
    'base'            => esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) ),
    'format'          => '?paged=%#%',
    'total'           => $loop->max_num_pages,
    'current'         => max( 1, $paged ),
    'show_all'        => false,
    'end_size'        => 3,
    'mid_size'        => 3,
    'prev_next'       => true,
    'prev_text' 	=> '<i class="twi-icon-chevron-left"></i>',
	  'next_text' 	=> '<i class="twi-icon-chevron-right"></i>',
    'type'  => 'array',
    'add_args'        => false,
    'add_fragment'    => '',
  );

  $paginate_links = paginate_links( $pagination_args);

  //if( is_array( $paginate_links ) ) {
?>
   <ul class="twi-pagination twi-pagination-<?php echo $car_pagi_pos; ?> gp<?php echo $twi_i; ?>" data-id= ".gp<?php echo $twi_i; ?>" data-text1="<?php echo $text1; ?>" data-text2="<?php echo $text2; ?>" data-bg1="<?php echo $bg1; ?>" data-bg2="<?php echo $twi_bg2; ?>" data-bor1="<?php echo $bor_width1.'px solid '.$bor_col1; ?>" data-bor2="<?php echo $bor_width2.'px solid '.$bor_col2; ?>" data-rad="<?php echo $bor_rad; ?>%" data-pad="<?php echo $pad; ?>px">
<?php
	    foreach ( $paginate_links as $page ) {
	            echo "<li>$page</li>";
	    }
	    echo '</ul>';
	    //echo "<p class='twi-float-right'>Page " . $paged . " of " . $numpages . "</p> ";
    //}
