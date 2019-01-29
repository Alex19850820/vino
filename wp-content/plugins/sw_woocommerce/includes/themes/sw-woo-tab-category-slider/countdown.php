<?php 
	$column=12/$columns;
	$column1=12/$columns1;
	$column2=12/$columns2;
	$column3=12/$columns3;
	$column4=12/$columns4;
 ?>
<div id="<?php echo $select_order.'_category_id_'.$cat; ?>" class="sw-woo-container-slider countdown-style2">       
	<div class="slider-wrapper clearfix">
		<!-- Slider Countdown -->
		<div class="row">
			<div class="resp-slider-container">			
				<div class="responsive">	
				<?php 
					$count_items = 0;
					$count_items = ( $numberposts >= $list->found_posts ) ? $list->found_posts : $numberposts;
					$i = 0;
					while($list->have_posts()): $list->the_post();					
					global $product, $post;
					$start_time 	= get_post_meta( $post->ID, '_sale_price_dates_from', true );
					$countdown_date = get_post_meta( $post->ID, '_sale_price_dates_to', true );	
					
				?>
					<div class="item item-countdown col-lg-<?php echo $column ?> col-md-<?php echo $column1 ?> col-sm-<?php echo $column2 ?> col-xs-<?php echo $column3 ?>" id="<?php echo 'product_'.$id.$post->ID; ?>">
						<div class="item-wrap">
							<div class="item-detail">									
								<div class="item-img products-thumb">											
									<!-- quickview & thumbnail  -->													
									<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
									<?php echo sw_quickview() ?>
								</div>										
								<div class="item-content">
								<div class="product-countdown-style1" data-date="<?php echo esc_attr( $countdown_date ); ?>"  data-starttime="<?php echo esc_attr( $start_time ); ?>"></div>	
									<!-- rating  -->
									<?php 
										$rating_count = $product->get_rating_count();
										$review_count = $product->get_review_count();
										$average      = $product->get_average_rating();
									?>
									<div class="reviews-content">
										<div class="star"><?php echo ( $average > 0 ) ?'<span style="width:'. ( $average*13 ).'px"></span>' : ''; ?></div>										
									</div>	
									<!-- end rating  -->
									<h4><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>"><?php sw_trim_words( get_the_title(), $title_length ); ?></a></h4>																			
									<!-- price -->
									<?php if ( $price_html = $product->get_price_html() ) : ?>
										<div class="item-price"><?php echo $price_html; ?></div>
									<?php endif; ?>						
									<!-- price -->
								</div>												
							</div> 
						</div>
					</div>
				<?php $i ++; endwhile; wp_reset_postdata();?>
				</div>
			</div>
		</div>
	</div>
</div>