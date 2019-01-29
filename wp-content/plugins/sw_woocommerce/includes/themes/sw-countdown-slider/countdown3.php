<?php
	$default = array(
		'post_type' => 'product',	
		'meta_query' => array(
			array(
				'key' => '_sale_price',
				'value' => 0,
				'compare' => '>',
				'type' => 'NUMERIC'
			),
			array(
				'key' => '_sale_price_dates_from',
				'value' => time(),
				'compare' => '<',
				'type' => 'NUMERIC'
			),
			array(
				'key' => '_sale_price_dates_to',
				'value' => time(),
				'compare' => '>',
				'type' => 'NUMERIC'
			)
		),
		'orderby' => $orderby,
		'order' => $order,
		'post_status' => 'publish',
		'showposts' => $numberposts	
	);
	if( $category != '' ){
		$default['tax_query'] = array(
			array(
				'taxonomy'  => 'product_cat',
				'field'     => 'slug',
				'terms'     => $category ));
	}
	$default = sw_check_product_visiblity( $default );
	$id = 'sw-count-down_'.rand().time();
	$list = new WP_Query( $default );
	$thumb = wp_get_attachment_image( $images3, 'full' );
	if ( $list -> have_posts() ){
 ?>
	<div class="countdown-slider-thumb-left">
		<div id="<?php echo $id; ?>" class="sw-woo-container-slider responsive-slider cowntdown-layout-3 countdown-style2 loading" data-lg="<?php echo esc_attr( $columns ); ?>" data-dots = "<?php echo $dots ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>"  data-autoplay="<?php echo esc_attr( $autoplay ); ?>">       
			<div class="imgleft  img-effect">
				 <a href="<?php echo $link3?>" target="_blank">
					<?php echo $thumb; ?>
				 </a>
			</div>	
			<div class="resp-slider-container">
				<?php if( $title1 != '' ) {?>
					<div class="box-slider-title">
						<?php echo '<h2><span>'. esc_html( $title1 ) .'</span></h2>'; ?>
					</div>
				<?php }?>
				<div class="slider responsive">	
				<?php 
					$count_items = 0;
					$count_items = ($numberposts >= $list->found_posts) ? $list->found_posts : $numberposts;
					$i = 0;
					while($list->have_posts()): $list->the_post();					
					global $product, $post, $wpdb, $average;
					$start_time 	= get_post_meta( $post->ID, '_sale_price_dates_from', true );
					$countdown_date = get_post_meta( $post->ID, '_sale_price_dates_to', true );	
					if( $i % $item_row == 0 ){
				?>
					<div class="item item-countdown" id="<?php echo 'product_'.$id.$post->ID; ?>">
					<?php } ?>
						<div class="item-wrap">
							<div class="item-detail">
								<div class="item-img products-thumb">
                                    <div class="add-info">
										<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
										<!-- quickview & thumbnail  -->
										<?php echo sw_quickview(); ?>
										<!-- end quickview & thumbnail  -->
									</div>								
									<!-- quickview & thumbnail  -->
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
									     <div class="star"><?php echo ( $average > 0 ) ?'<span style="width:'. ( $average*12 ).'px"></span>' : ''; ?></div>
									</div>									
									<!-- end rating  -->
									<!-- Price -->
									<?php if ( $price_html = $product->get_price_html() ){?>								
									<div class="item-price">
										<span>
											<?php echo $price_html; ?>
										</span>
									</div>
									<?php } ?>
									<div class="product-countdown-style1" data-date="<?php echo esc_attr( $countdown_date ); ?>"  data-starttime="<?php echo esc_attr( $start_time ); ?>"></div>
								</div>
							</div>
						</div>
					<?php if( ( $i+1 ) % $item_row == 0 || ( $i+1 ) == $count_items ){?> </div><?php } ?>
				<?php $i ++; endwhile; wp_reset_postdata();?>
				</div>
			</div>            
		</div>
	</div>
<?php
} 
?>