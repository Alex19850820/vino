<?php 

if( $category != '' ){
	$default = array(
		'post_type'		=> 'product',
		'tax_query' => array(
			array(
				'taxonomy'	=> 'product_cat',
				'field'		=> 'slug',
				'terms'		=> $category,
				'operator' 	=> 'IN'
			)
		),
		'post_status' 	=> 'publish',
		'no_found_rows' => 1,					
		'showposts' 	=> $numberposts						
	);
}else{
	$default = array(
		'post_type'		=> 'product',		
		'post_status' 	=> 'publish',
		'no_found_rows' => 1,					
		'showposts' 	=> $numberposts						
	);
}

if( sw_woocommerce_version_check( '3.0' ) ){
	$default['meta_key'] = '_wc_average_rating';
	$default['orderby'] = 'meta_value_num';
}else{
	add_filter( 'posts_clauses',  array( WC()->query, 'order_by_rating_post_clauses' ) );
}

$default = sw_check_product_visiblity( $default );
$id = 'sw_toprated_'.rand().time();
$list = new WP_Query( $default );
do_action( 'before' ); 
if ( $list -> have_posts() ){
?>
	<div id="<?php echo $id; ?>" class="sw-woo-container-slider  responsive-slider toprated-product clearfix loading" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>"  data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
		<div class="resp-slider-container">
			<div class="box-slider-title">
				<?php echo '<h2><span>'. esc_html( $title1 ) .'</span></h2>'; ?>
			</div>
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
							<div class="item-img products-thumb col-lg-5 col-md-5 col-sm-6 col-xs-12">			
								<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
							</div>										
							<div class="item-content col-lg-7 col-md-7 col-sm-6 col-xs-12">	
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
								<!-- price -->
								<?php if ( $price_html = $product->get_price_html() ){?>
									<div class="item-price">
										<span>
											<?php echo $price_html; ?>
										</span>
									</div>
								<?php } ?>	
								<div class="item-except">
								<?php echo $content = wp_trim_words($post->post_content, $length, ' '); ?>
								</div>
								<!-- add to cart, wishlist, compare -->
								<div class="add-info">
								<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
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