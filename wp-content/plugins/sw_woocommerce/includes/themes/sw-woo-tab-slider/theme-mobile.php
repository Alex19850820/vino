<?php 
	if( !is_array( $select_order ) ){
		$select_order = explode( ',', $select_order );
	}
	
	$widget_id = isset( $widget_id ) ? $widget_id : $this->generateID();
	$viewall = get_permalink( wc_get_page_id( 'shop' ) );	
	$term = get_term_by( 'slug', $category, 'product_cat' );	
?>
<div class="sw-tab-mobile style-moblie" id="<?php echo esc_attr( $widget_id ); ?>" >
	<div class="resp-tab" style="position:relative;">
		<div class="top-tab-slider clearfix">
			<div class="woocommmerce-shop"><a href="<?php echo esc_url( $viewall ); ?>" title="<?php esc_html_e( 'Woocommerce Shop', 'sw_woocommerce' ) ?>"><?php echo esc_html__('View all','sw_woocommerce');?></a></div>
			<ul class="nav nav-tabs">
				<?php 
						$tab_title = '';
						foreach( $select_order as $i  => $so ){						
							switch ($so) {
							case 'latest':
								$tab_title = __( 'Latest Products', 'sw_woocommerce' );
							break;
							case 'rating':
								$tab_title = __( 'Top Rating', 'sw_woocommerce' );
							break;
							case 'bestsales':
								$tab_title = __( 'Best Selling', 'sw_woocommerce' );
							break;						
							default:
								$tab_title = __( 'Featured Products', 'sw_woocommerce' );
							}
					?>
					<li <?php echo ( $i == ( $tab_active -1 ) )? 'class="active"' : ''; ?>>
						<a href="#<?php echo esc_attr( $so. '_' .$widget_id ) ?>" data-type="so_ajax" data-layout="<?php echo esc_attr( $layout );?>" data-row="<?php echo esc_attr( $item_row ) ?>" data-length="<?php echo esc_attr( $title_length ) ?>" data-ajaxurl="<?php echo esc_url( sw_ajax_url() ) ?>" data-category="<?php echo esc_attr( $category ) ?>" data-toggle="tab" data-sorder="<?php echo esc_attr( $so ); ?>" data-catload="ajax" data-number="<?php echo esc_attr( $numberposts ); ?>" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>"  data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
							<?php echo esc_html( $tab_title ); ?>
						</a>
					</li>			
				<?php } ?>
			</ul>
		</div>		
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
