<?php 
	if( $category == '' ){
		return '<div class="alert alert-warning alert-dismissible" role="alert">
			<a class="close" data-dismiss="alert">&times;</a>
			<p>'. esc_html__( 'Please select a category for SW Woocommerce Tab Category Slider. Layout ', 'sw_woocommerce' ) . $layout .'</p>
		</div>';
	}
	
	$widget_id = isset( $widget_id ) ? $widget_id : $this->generateID();
	if( !is_array( $select_order ) ){
		$select_order = explode( ',', $select_order );
	}
	$term = get_term($category, 'product_cat');	
?>
<div class="sw-woo-tab-banner-top woo-tab-group loading" id="<?php echo esc_attr( 'tab_child_'.$widget_id ); ?>" >
	<div class="resp-tab clearfix">	
		<div class="top-tab-slider">
			<?php if( $term ) : ?>
			<div class="order-title">
				<?php echo '<span>'. $term->name . '</span>'; ?>
			</div>
			<?php endif; ?>
			<ul class="nav nav-tabs" id="<?php echo 'nav_'.$widget_id; ?>">
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
				<li <?php echo ( $i == ( $tab_active -1 ) )? 'class="active"' : ''; ?>>
					<a href="#<?php echo esc_attr( $so. '_' .$widget_id ) ?>" data-type="so_ajax_child" data-layout="<?php echo esc_attr( $layout );?>" data-row="<?php echo esc_attr( $item_row ) ?>" data-length="<?php echo esc_attr( $title_length ) ?>" data-ajaxurl="<?php echo esc_url( sw_ajax_url() ) ?>" data-category="<?php echo esc_attr( $category ) ?>" data-toggle="tab" data-sorder="<?php echo esc_attr( $so ); ?>" data-catload="ajax" data-number="<?php echo esc_attr( $numberposts ); ?>" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>"  data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
						<?php echo esc_html( $tab_title ); ?>
					</a>
				</li>	
			<?php } ?>
			</ul>			
		</div>		
		<div class="category-slider-content">
			<div class="tab-content">
              	<!-- Banner top -->
				<?php	
					if( $banner_slide != '' ){ 
					if( !is_array( $banner_slide ) ){
						$banner_slide = explode( ',', $banner_slide );
					}
				?>
					<div class="banner-top-cate clearfix">
						<ul class="bottom-category-banner">
							<?php foreach( $banner_slide as $key => $item ){  ?>
								<li>
								<?php
										$banner_thumb = wp_get_attachment_image( $item, 'full' );
										echo '<a href="#">'.$banner_thumb.'</a>';
								?>
								</li>
							<?php } ?>
						</ul>
					</div>
				<?php				
					}
				?>
				<!-- End Banner top -->			
			<!-- Product tab slider -->
			<?php 
				foreach( $select_order as $i  => $so ){ 
	
			?>
				<div class="tab-pane <?php echo ( $i == ( $tab_active -1 ) ) ? 'active in' : ''; ?>" id="<?php echo esc_attr( $so. '_' .$widget_id ) ?>"></div>
			<?php } ?>
			<!-- End product tab slider -->
					
			</div>
						<!-- Get child category -->
						<?php 
							if( $term ) :
							$termchild 		= get_terms( 'product_cat', array( 'parent' => $term->term_id, 'hide_empty' => 0, 'number' => 3 ) );
							if( count( $termchild ) > 0 ){
						?>
							<div class="childcat-content pull-left">
								<?php 
									echo '<ul>';
									foreach ( $termchild as $key => $child ) {
										echo '<li><a href="' . get_term_link( $child->term_id, 'product_cat' ) . '">' . $child->name . '</a></li>';
									}
									echo '</ul>';
								?>
							</div>
							<?php } ?>
						<?php endif; ?>
						<!-- End get child category -->		
		</div>
	</div>
</div>