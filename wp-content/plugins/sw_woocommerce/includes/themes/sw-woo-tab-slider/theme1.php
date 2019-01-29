<?php 
	if( $category == ''){
		return ;
	}
	
	$id = $this -> number;
	$id ++;
	$tag_id = 'sw_woo_tab_'. $id .rand().time();

	if( !is_array( $select_order ) ){
		$select_order = explode( ',', $select_order );
	}
?>
<div class="sw-woo-tab-style2 loading" id="<?php echo esc_attr( $tag_id ); ?>" >
	<div class="resp-tab" style="position:relative;">
		<div class="top-tab-slider clearfix">
			<div class="order-title">
				<?php echo '<h2>'. $term->name . '</h2>'; ?>
			</div>
			<ul class="nav nav-tabs">
			<?php 
					$tab_title = '';
					foreach( $select_order as $i  => $so ){						
						switch ($so) {
						case 'latest':
							$tab_title = __( 'Latest Products', 'sw_woocommerce' );
						break;
						case 'rating':
							$tab_title = __( 'Top Rating Products', 'sw_woocommerce' );
						break;
						case 'bestsales':
							$tab_title = __( 'Best Selling Products', 'sw_woocommerce' );
						break;						
						default:
							$tab_title = __( 'Featured Products', 'sw_woocommerce' );
						}
				?>
				<li <?php echo ( $i == 0 )? 'class="active"' : ''; ?>>
					<a href="#<?php echo $so . '_' . $id; ?>" data-toggle="tab">
						<?php echo esc_html( $tab_title ); ?>
					</a>
				</li>			
			<?php } ?>
			</ul>
		</div>		
		<div class="category-slider-content clearfix">	
			<div class="tab-content clearfix">	
			<!-- Product tab slider -->
			<?php foreach( $select_order as $i  => $so ){ ?>
				<div class="tab-pane <?php echo ( $i == 0 ) ? 'active' : ''; ?>" id="<?php echo $so . '_' . $id; ?>">
				<?php
					global $woocommerce;
					$default = array();
					if( $so == 'latest' ){
						$default = array(
							'post_type'	=> 'product',
							'tax_query' => array(
								array(
									'taxonomy'	=> 'product_cat',
									'field'		=> 'id',
									'operator' 	=> 'IN'
								)
							),
							'paged'		=> 1,
							'showposts'	=> $numberposts,
							'orderby'	=> 'date'
						);
					}
					if( $so == 'rating' ){
						$default = array(
							'post_type'		=> 'product',
							'tax_query' => array(
								array(
									'taxonomy'	=> 'product_cat',
									'field'		=> 'id',
									'operator' 	=> 'IN'
								)
							),
							'post_status' 	=> 'publish',
							'no_found_rows' => 1,					
							'showposts' 	=> $numberposts						
						);
						$default['meta_query'] = WC()->query->get_meta_query();
						if( sw_woocommerce_version_check( '2.7' ) ){
							$default['meta_key'] = '_wc_average_rating';
							$default['orderby'] = 'meta_value_num';
						}else{
							add_filter( 'posts_clauses',  array( WC()->query, 'order_by_rating_post_clauses' ) );
						}
					
					}
					if( $so == 'bestsales' ){
						$default = array(
							'post_type' 			=> 'product',
							'tax_query' => array(
								array(
									'taxonomy'	=> 'product_cat',
									'field'	=> 'id',
									'operator' => 'IN'
								)
							),
							'post_status' 			=> 'publish',
							'ignore_sticky_posts'   => 1,
							'paged'	=> 1,
							'showposts'				=> $numberposts,
							'meta_key' 		 		=> 'total_sales',
							'orderby' 		 		=> 'meta_value_num',
						);
					}
					if( $so == 'featured' ){
						$default = array(
							'post_type'	=> 'product',
							'tax_query' => array(
								array(
									'taxonomy'	=> 'product_cat',
									'field'	=> 'id',
									'operator' => 'IN'
								)
							),
							'post_status' 			=> 'publish',
							'ignore_sticky_posts'	=> 1,
							'posts_per_page' 		=> $numberposts,
							'orderby' 				=> $orderby,
							'order' 				=> $order,
							if( sw_woocommerce_version_check( '3.0' ) ){	
								$default['tax_query'][] = array(						
									'taxonomy' => 'product_visibility',
									'field'    => 'name',
									'terms'    => 'featured',
									'operator' => 'IN',	
								);
							}else{
								$default['meta_query'] = array(
									array(
										'key' 		=> '_featured',
										'value' 	=> 'yes'
									)					
								);				
							}
						);
					}
					$default = sw_check_product_visiblity( $default );
					$list = new WP_Query( $default );
					$max_page = $list -> max_num_pages;
					if( $so == 'rating' && !sw_woocommerce_version_check( '2.7' ) ){
						remove_filter( 'posts_clauses',  array( $this, 'order_by_rating_post_clauses' ) );
					}
				?>
					<div id="<?php echo $so.'_category_id_'.$category.$id; ?>" class="woo-tab-container-slider responsive-slider clearfix" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>"  data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
						<div class="resp-slider-container">
							<div class="slider responsive">
							<?php 
								$j = 0;
								$count_items 	= 0;
								$numb 			= ( $list->found_posts > 0 ) ? $list->found_posts : count( $list->posts );
								$count_items 	= ( $numberposts >= $numb ) ? $numb : $numberposts;
								while($list->have_posts()): $list->the_post();
								global $product, $post, $wpdb, $average;
								if( $j % $item_row == 0 ){
							?>
								<div class="item">
							<?php } ?>
									<div class="item-wrap">
										<div class="item-detail">										
											<div class="item-img products-thumb">											
												<!-- quickview & thumbnail  -->												
												<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
												<?php echo sw_quickview() ?>
											</div>										
											<div class="item-content">																							
												<!-- rating  -->
												<?php 
													$rating_count = $product->get_rating_count();
													$review_count = $product->get_review_count();
													$average      = $product->get_average_rating();
												?>
												<div class="reviews-content">
													<div class="star"><?php echo ( $average > 0 ) ?'<span style="width:'. ( $average*13 ).'px"></span>' : ''; ?></div>
													<div class="item-number-rating">
													
													</div>
												</div>	
												<!-- end rating  -->
												<h4><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>"><?php sw_trim_words( get_the_title(), $title_length ); ?></a></h4>								
												<!-- price -->
												<?php if ( $price_html = $product->get_price_html() ) : ?>
													<div class="item-price"><?php echo $price_html; ?></div>
												<?php endif; ?>
												<!-- price -->
												<!-- add to cart-->
												<div class="cart-button">
													<?php  woocommerce_template_loop_add_to_cart(); ?>
												</div>
											</div>
												<!-- add to cart, wishlist, compare -->
												<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
										</div>
									</div>
								<?php if( ( $j+1 ) % $item_row == 0 || ( $j+1 ) == $count_items ){?> </div><?php } ?>
								<?php $j++; endwhile; wp_reset_postdata();?>
							</div>
						</div>
					</div>			
				</div>
			<?php } ?>
			<!-- End product tab slider -->
			</div>
		</div>
	</div>
</div>