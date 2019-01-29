<?php 

$widget_id = isset( $widget_id ) ? $widget_id : 'sw_portfolio_product_'.rand().time();
if( $category == '' ){
	return '<div class="alert alert-warning alert-dismissible" role="alert">
	<a class="close" data-dismiss="alert">&times;</a>
	<p>'. esc_html__( 'Please select a category for SW Woocommerce Tab Category Slider. Layout ', 'sw_woocommerce' ) . $layout .'</p>
</div>';
}
if( !is_array( $category ) ){
	$category = explode( ',', $category );
}	

$col_lg = 12 / $columns;
$col_md = 12 / $columns1;
$col_sm = 12 / $columns2;
$class_col = ' col-lg-'.$col_lg.' col-md-'.$col_md.' col-sm-'.$col_sm.' col-xs-12';
?>
<div id="<?php echo esc_attr( $widget_id ); ?>" class="sw-portfolio-product <?php echo $style; ?>">
	<!-- Title & description -->
	<?php if( $title != '' || $description != '' ){ ?>
	<div class="portfolio-desc">
		<div class="title-custom" >
			<?php
			$titles = strpos($title, ' ');
			$title = ($titles !== false) ? '<span>' . substr($title, 0, $titles) . '</span>' .' '. substr($title, $titles + 1): $title ;
			echo '<h2>'. $title .'</h2>';
			?>
			<?php echo ( $description != '' ) ? '<div class="p-desc desc-custom">'. $description .'</div>' : ""; ?>
		</div>
	</div>
	<?php } ?>
	<!-- Tab  -->
	<div class="product-tab">
			<button class="navbar-toggle collapsed pull-right" type="button" data-toggle="collapse" data-target="#tab_<?php echo esc_attr( $widget_id ); ?>"  aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="fa fa-bar"></span>
					<span class="fa fa-bar"></span>
					<span class="fa fa-bar"></span>
			</button>
		<ul class="nav nav-tabs" id="tab_<?php echo esc_attr( $widget_id ); ?>">
			<li class="selected" data-product-filter="*" data-href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>"><?php _e( 'All', 'sw_woocommerce' ); ?></li>
			<?php
			foreach( $category as $cat_id ){
				$cat = get_term_by( 'slug', $cat_id, 'product_cat' );
				if( $cat ) :
					echo '<li class="custom-font" data-product-filter=".'. $cat -> slug.'" data-href="'. get_term_link( $cat->term_id, 'product_cat' ) .'">' .esc_html( $cat -> name ). '</li>';
				endif;
			}
			?>
		</ul>
		<div class="portfolio-hr"></div>
	</div>
	<div class="portfolio-product-wrapper">
		<ul id="container_<?php echo esc_attr( $widget_id ); ?>" class="portfolio-product-content portfolio-product-grid clearfix">
			<?php
			$default = array(
				'post_type'	=> 'product',
				'tax_query'	=> array(
					array(
						'taxonomy'	=> 'product_cat',
						'field'		=> 'slug',
						'terms'		=> $category
						) 
					),
				'orderby' => $orderby,
				'order' => $order,
				'post_status' => 'publish',
				'showposts' => $numberposts
				);
			$list = new WP_Query( $default );
			$max_page = $list -> max_num_pages;
			while( $list->have_posts() ) : $list->the_post();
			global $product, $post;
			$pterms	= get_the_terms( $post->ID, 'product_cat' );
			$term_str = '';
			if( count($pterms) > 0 ){
				foreach( $pterms as $key => $term ){
					$term_str .= $term -> slug . ' ';
				}
			}
			?>
			<li class="portfolio-product-item <?php echo esc_attr( $term_str . $class_col ); ?>" >
				<div class="item-wrap">
					<div class="item-img products-thumb">	
						<?php echo ya_product_thumbnail('full') ?>
						<div class="add-info">
							<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
							<!-- quickview & thumbnail  -->
							<?php echo sw_quickview() ?>
							<!-- end quickview & thumbnail  -->
						</div>
					
					</div>	
				    <div class="item-content">	
                            <h4><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>"><?php sw_trim_words( get_the_title(), $title_length ); ?></a></h4>															
							<!-- price -->
							<?php if ( $price_html = $product->get_price_html() ){?>
								<div class="item-price">
									<span>
										<?php echo $price_html; ?>
									</span>
								</div>
							<?php } ?>	
					</div>					
				</div>
			</li>
		<?php endwhile; wp_reset_postdata(); ?>
	</ul>
	<?php if( $btmore == 'default' ) : ?>
		<div class="bt-more item-pmore">
			<a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>"><?php esc_html_e( 'Explore All Themes', 'sw_woocommerce' ); ?></a>
		</div>
	<?php else : ?>
		<div class="bt-more item-pajax">
			<a href="javascript:void(0)" data-ajaxurl="<?php echo admin_url( 'admin-ajax.php' ) ?>" data-maxpage="<?php echo esc_attr( $max_page ) ?>" data-attributes="<?php echo esc_attr( $class_col ) ?>" data-number="<?php echo esc_attr( $numberposts ) ?>" data-categories="<?php echo esc_attr( implode( ',', $category ) ) ?>" data-order="<?php echo esc_attr( $order ) ?>" data-orderby="<?php echo esc_attr( $orderby ) ?>" data-label-loaded="<?php esc_attr_e( 'All Item Loaded', 'sw_woocommerce' ); ?>"><?php esc_html_e( 'Load More', 'sw_woocommerce' ); ?></a>
		</div>
	<?php endif; ?>
</div>
</div>
