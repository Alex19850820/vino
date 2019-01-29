<?php
/**
	* Layout Child Category 2
	* @version     1.0.0
**/

if( $category == '' ){
	return '<div class="alert alert-warning alert-dismissible" role="alert">
		<a class="close" data-dismiss="alert">&times;</a>
		<p>'. esc_html__( 'Please select a category for SW Woo Slider. Layout ', 'sw_woocommerce' ) . $layout .'</p>
	</div>';
}
$widget_id = isset( $widget_id ) ? $widget_id : 'sw_woo_slider_'.rand().time();

$default = array();
if( $category != '' ){
	$default = array(
		'post_type' => 'product',
		'tax_query' => array(
		array(
			'taxonomy'  => 'product_cat',
			'field'     => 'slug',
			'terms'     => $category ) ),
		'orderby' => $orderby,
		'order' => $order,
		'post_status' => 'publish',
		'showposts' => $numberposts
	);
}

$term_name = '';
$term = get_term_by( 'slug', $category, 'product_cat' );
if( $term ) :
	$term_name = $term->name;
endif;
$default = sw_check_product_visiblity( $default );
$list = new WP_Query( $default );
if ( $list -> have_posts() ){ ?>
	<div id="<?php echo $widget_id; ?>" class="sw-woo-container-slider responsive-slider woo-slider-childcat2 loading" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>"  data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
		<div class="childcat-slider-content clearfix">
			<!-- Child Categories -->
			<div class="child-cat-content pull-left">
				<div class="box-slider-title">
					<h2><span><?php echo $term_name; ?></span></h2>
				</div>
			<?php 
				if( $term ) :
					$args = array(
						'child_of' => $term->term_id,
						'taxonomy' => 'product_cat',
						'hide_empty' => 0,
						'hierarchical' => true,
						'depth'  => 4,
						'title_li' => ''
						);
					wp_list_categories( $args );
				endif;
			?>
			</div>
			<!-- image --> 
			<div class="child-cat-right clearfix">
				<?php
					if( $image != '' ) :
				?>
				<div class="item-category-img pull-left">
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>">
					<?php echo wp_get_attachment_image( $image, 'full' ) ?>
				</a>
				</div>
				<?php endif; ?>
				<!-- Slider -->
				<div class="resp-slider-container">
					<div class="slider responsive">	
					<?php 
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
                                     	<h4><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>"><?php sw_trim_words( get_the_title(), $title_length ); ?></a></h4>								
										<?php if ( $price_html = $product->get_price_html() ){?>
										<div class="item-price">
											<span>
												<?php echo $price_html; ?>
											</span>
										</div>
										<?php } ?>	
										<div class="item-img-inner">
											<!-- quickview & thumbnail  -->
											<?php the_post_thumbnail('shop-recommend'); ?>
											<?php echo sw_quickview() ?>
											<?php  sw_label_sales() ?>
										</div>
									</div>										
									<div class="item-content">																				
										<!-- rating  -->
										<!-- end rating  -->
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
		</div>
	</div>
	<?php
	}
?>