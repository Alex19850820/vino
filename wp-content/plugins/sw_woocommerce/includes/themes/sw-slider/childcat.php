<?php 

/**
	* Layout Child Category
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
	<div id="<?php echo $widget_id; ?>" class="sw-woo-container-slider responsive-slider woo-slider-<?php echo $layout ?> loading" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>"  data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
		<div class="block-title clearfix">
		<?php 
		$title = '';
		$title1 =  $term_name;
		$titles = strpos($title1, '&');
		if( $titles ) {
			$title =  '<span>' . substr($title1, 0, $titles) . '</span>' .' <span class="text-color">'. str_replace('amp;','&',substr($title1, $titles + 1)).'</span>';
		}else{
			$title = $title1;
		}
		echo $title;
		
		if( $term ) :
				$termchild 		= get_terms( 'product_cat', array( 'parent' => $term->term_id, 'hide_empty' => 0, 'number' => $number_child ) );
				if( count( $termchild ) > 0 ){
			?>	
			<div class="childcat-slider">				
				<div class="childcat-content">
				<?php 					
					echo '<ul>';
					foreach ( $termchild as $key => $child ) {
						echo '<li><a href="' . get_term_link( $child->term_id, 'product_cat' ) . '">' . $child->name . '</a></li>';
					}
					echo '</ul>';
				?>
				</div>
			</div>
			<?php } ?>
		<?php endif; ?>
		</div>          
		<div class="resp-slider-container <?php echo ( $img_align == 'right' ) ? 'img-right' : ''; ?>">
		<div class="row">
		<div class="left-child col-lg-3 col-md-3">
		<a class="img-class" href="#" title="<?php echo esc_attr( $term->name ) ?>"><?php   echo wp_get_attachment_image( $image, 'full' ) ?></a>
		</div>
		<div class="right-childs col-lg-9 col-md-9 col-sm-12">
		<div class="rw-margin">
			<div class="slider responsive">	
			<?php 
				$count_items = 0;
				$count_items = ( $numberposts >= $list->found_posts ) ? $list->found_posts : $numberposts;
				$i = 0;
				while($list->have_posts()): $list->the_post();global $product, $post; 
				if( $i % $item_row == 0 ){
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
										<?php echo $review_count; _e(' Review(s)', 'sw_woocommerce');?>
									</div>
								</div>	
								<!-- end rating  -->
								<h4><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>"><?php sw_trim_words( get_the_title(), $title_length ); ?></a></h4>								
								<?php if ( $price_html = $product->get_price_html() ){?>
								<div class="item-price">
									<span>
										<?php echo $price_html; ?>
									</span>
								</div>
								<?php } ?>
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
	</div>
	<?php
	}
?>