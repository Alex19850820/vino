<?php 
	if( !is_array( $select_order ) ){
		$select_order = explode( ',', $select_order );
	}
	$widget_id = isset( $widget_id ) ? $widget_id : $this->generateID();
	$term = get_term_by( 'slug', $category, 'product_cat' );	
?>
<div class="sw-woo-tab loading" id="<?php echo esc_attr( 'woo_tab_' . $widget_id ); ?>">
	<div class="resp-tab" style="position:relative;">				
		<div class="category-slider-content clearfix">
			<div class="top-tab-slider clearfix">			
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
					<li <?php echo ( $i == ( $tab_active -1 ) )? 'class="active"' : ''; ?>>
						<a href="#<?php echo esc_attr( $so. '_' .$widget_id ) ?>" data-type="so_ajax" data-layout="<?php echo esc_attr( $layout );?>" data-row="<?php echo esc_attr( $item_row ) ?>"  data-length="<?php echo esc_attr( $title_length ) ?>" data-ajaxurl="<?php echo esc_url( sw_ajax_url() ) ?>" data-category="<?php echo esc_attr( $category ) ?>" data-toggle="tab" data-sorder="<?php echo esc_attr( $so ); ?>" data-catload="ajax" data-number="<?php echo esc_attr( $numberposts ); ?>" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>"  data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
							<?php echo esc_html( $tab_title ); ?>
						</a>
					</li>				
				<?php } ?>
				</ul>
			<div class="tab-content clearfix">				
			<!-- Product tab slider -->
			<?php 
				foreach( $select_order as $i  => $so ){ 
	
			?>
				<div class="tab-pane <?php echo ( $i == ( $tab_active -1 ) ) ? 'active in' : ''; ?>" id="<?php echo esc_attr( $so. '_' .$widget_id ) ?>"></div>
			<?php } ?>
			<!-- End product tab slider -->
			</div>
		</div>
	</div>
</div>
</div>