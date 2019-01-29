<?php ; 

wp_reset_postdata();

	$default = array(
		'post_type'		=> 'product',		
		'post_status' 	=> 'publish',
		'no_found_rows' => 1,					
		'showposts' 	=> $numberposts	,
		'orderby' 				=> $orderby,
		'order' 				=> $order,
        'meta_query'     => array(
			array(
				'key'           => '_sale_price',
				'value'         => 0,
				'compare'       => '>',
				'type'          => 'numeric'
			),
			array(
				'key' => '_sale_price_dates_from',
				'value' => time(),
				'compare' => '<',
				'type' => 'NUMERIC'
			)
		)		
	);
if( $category != '' ){	
	$default['tax_query'] = array(
		array(
			'taxonomy'	=> 'product_cat',
			'field'		=> 'slug',
			'terms'		=> $category,
		)
	);
}
$default = sw_check_product_visiblity( $default );
$id = 'sw_toprated_'.rand().time();
$list = new WP_Query( $default );
$countdown_time = strtotime( $date );
$date = sw_timezone_offset( $countdown_time );
if ( $list -> have_posts() ){
?>
	<div id="<?php echo $id; ?>" class="sw-woo-container-slider  responsive-slider dailydeals-product clearfix loading" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>"  data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
		<div class="resp-slider-container">
			<div class="box-slider-title">
				<?php echo '<h2><span>'. esc_html( $title1 ) .'</span></h2>'; ?>
			</div>
            <div class="banner-countdown custom-font" data-date="<?php echo esc_attr( $date ); ?>" data-cdtime="<?php echo esc_attr( $countdown_time ); ?>"></div>
            <div class="hurry"><?php esc_html_e( 'Hurry, this deals ends in:', 'sw_woocommerce' ) ?></div>
			<div class="slider responsive">			
			<?php
					$i = 1;
					$count_items 	= 0;
					$numb 			= ( $list->found_posts > 0 ) ? $list->found_posts : count( $list->posts );
					$count_items 	= ( $numberposts >= $numb ) ? $numb : $numberposts;
					$i 				= 0;
					while($list->have_posts()): $list->the_post();global $product, $post;
					if( $i % $item_row == 0 ){
				?>
				<div class="item">
				<?php } ?>
					<div class="item-wrap">
						<div class="item-detail">										
							<div class="item-img products-thumb">	
								<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
							</div>										
							<div class="item-content">	
								<h4><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>"><?php sw_trim_words( get_the_title(), $title_length ); ?></a></h4>									
								<!-- rating  -->
								<?php 
									$rating_count = $product->get_rating_count();
									$review_count = $product->get_review_count();
									$average      = $product->get_average_rating();
								?>
								<div class="reviews-content">
									<div class="star"><?php echo ( $average > 0 ) ?'<span style="width:'. ( $average*11 ).'px"></span>' : ''; ?></div>
								</div>	
								<!-- end rating  -->						
							
								<div class="item-except">
								<?php echo $content = wp_trim_words($post->post_content, $length, ' '); ?>
								</div>
									<!-- price -->
								<?php if ( $price_html = $product->get_price_html() ){?>
									<div class="item-price">
										<span>
											<?php echo $price_html; ?>
										</span>
										<span class="sold">
										<?php		
										$units_sold = get_post_meta( $post->ID, 'total_sales', true );		
										echo esc_html__('Sold:','sw_woocommerce').'<b>'. $units_sold.'</b>';
										
										?>
										</span>
									</div>
								<?php } ?>	
								<!-- add to cart, wishlist, compare -->
								<div class="add-info">
								<?php woocommerce_template_loop_add_to_cart(); ?>
								<?php echo ya_add_loop_wishlist_link(); ?>
								<?php echo ya_add_loop_compare_link(); ?>
								<?php echo sw_quickview() ?>
								</div>
							</div>								
						</div>
					</div>
				<?php if( ( $i+1 ) % $item_row == 0 || ( $i+1 ) == $count_items ){?> </div><?php } ?>
			    <?php $i++; endwhile; wp_reset_postdata();?>
			</div>
		</div>					
	</div>
<?php
}	
?>