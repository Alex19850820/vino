<?php 

/**
	* Layout Default
	* @version     1.0.0
**/

$term_name = esc_html__( 'New Arrival', 'sw_woocommerce' );
$viewall = get_permalink( wc_get_page_id( 'shop' ) );	
$widget_id = isset( $widget_id ) ? $widget_id : 'sw_woo_slider_'.rand().time();
$default = array(
	'post_type' => 'product',
	'orderby' => $orderby,
	'order' => $order,
	'post_status' => 'publish',
	'showposts' => $numberposts
);
if( $category != '' ){
	$term = get_term_by( 'slug', $category, 'product_cat' );	
	if( $term ) :
		$term_name = $term->name;
	endif;
	
	$default['tax_query'] = array(
		array(
			'taxonomy'  => 'product_cat',
			'field'     => 'slug',
			'terms'     => $category )
	);	
}
$default = sw_check_product_visiblity( $default );
$id = 'sw_new_arrivals_'.rand().time();
$list = new WP_Query( $default );

if ( $list -> have_posts() ){ ?>
	<div id="<?php echo $id; ?>" class="style-moblie new_mobile <?php echo $style ?> clearfix">
		<div class="block-title">
			<h2><span><?php echo ( $title1 != '' ) ? $title1 : $term_name; ?></span></h2>
			<div class="woocommmerce-shop"><a href="<?php echo esc_url($viewall); ?>" title="Woocommerce Shop"><?php echo esc_html__('View all','sw_woocommerce');?></a></div>    
		</div>    
		  
		<div class="resp-slider-container">
			<div class="items-wrapper clearfix">	
			<?php 
				$count_items = 0;
				$count_items = ( $numberposts >= $list->found_posts ) ? $list->found_posts : $numberposts;
				$i = 0;
				while($list->have_posts()): $list->the_post();					
				global $product, $post;
				$class = ( $product->get_price_html() ) ? '' : 'item-nonprice';
				$symboy = get_woocommerce_currency_symbol( get_woocommerce_currency() );
				if( $i % $item_row == 0 ){
			?>
				<div class="item product <?php echo esc_attr( $class )?>" id="<?php echo 'product_'.$id.$post->ID; ?>">
				<?php } ?>
					<div class="item-wrap">
						<div class="item-detail">
							<div class="item-image">									
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php echo ya_product_thumbnail('shop_catalog'); ?></a>
							</div>
							<div class="item-content">
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
								<h4><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>"><?php sw_trim_words( get_the_title(), $title_length ); ?></a></h4>
								<!-- Price -->
								<?php if ( $price_html = $product->get_price_html() ){?>
								<div class="item-price">
									<span>
										<?php echo $price_html; ?>
									</span>
								</div>
								<?php } ?>								
							</div>															
						</div>
					</div>
				<?php if( ( $i+1 ) % $item_row == 0 || ( $i+1 ) == $count_items ){?> </div><?php } ?>
			<?php $i ++; endwhile; wp_reset_postdata();?>
			</div>
		</div>          
	</div>
	<?php
	}else{
		echo '<div class="alert alert-warning alert-dismissible" role="alert">
		<a class="close" data-dismiss="alert">&times;</a>
		<p>'. esc_html__( 'Has no product in this category', 'sw_woocommerce' ) .'</p>
	</div>';
	}
?>
