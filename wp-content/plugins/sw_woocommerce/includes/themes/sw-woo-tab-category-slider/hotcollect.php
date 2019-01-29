<?php 
	
	$widget_id = isset( $widget_id ) ? $widget_id : $this->generateID();
	if( $category == '' ){
		return '<div class="alert alert-warning alert-dismissible" role="alert">
			<a class="close" data-dismiss="alert">&times;</a>
			<p>'. esc_html__( 'Please select a category for SW Woocommerce Tab Category Slider. Layout ', 'sw_woocommerce' ) . $layout .'</p>
		</div>';
	}
	if( !is_array( $category ) ){
		$category = explode( ',', $category );
	}
	$nav_id = 'nav_categories_'.rand().time();
?>
<div class="sw-woo-tab-cat loading" id="<?php echo 'tab_slider_' . esc_attr( $widget_id ); ?>" >
	<div class="resp-tab" style="position:relative;">
		<div class="top-tab-slider clearfix">
			<div class="order-title">
				<?php
					echo '<span>'. $title1 .'</span>';
				?>
			</div>
			<ul class="nav nav-tabs" id="<?php echo esc_attr($nav_id); ?>">
			<?php 
				$i = 1;
				foreach($category as $cat){
					$terms = get_term_by('id', $cat, 'product_cat');
					if( $terms ){			
			?>
				<li class="<?php if( $i == $tab_active ){echo 'active'; }?>">
					<a href="#<?php echo esc_attr( $cat. '_' .$widget_id ) ?>" data-type="tab_ajax" data-layout="<?php echo esc_attr( $layout );?>" data-row="<?php echo esc_attr( $item_row ) ?>" data-length="<?php echo esc_attr( $title_length ) ?>" data-ajaxurl="<?php echo esc_url( sw_ajax_url() ) ?>" data-category="<?php echo esc_attr( $cat ) ?>" data-toggle="tab" data-sorder="<?php echo esc_attr( $select_order ); ?>" data-catload="ajax" data-number="<?php echo esc_attr( $numberposts ); ?>" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>"  data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
						<?php echo $terms->name; ?>
					</a>
				</li>	
				<?php $i ++; ?>
			<?php } } ?>
			</ul>
		</div>
		<div class="tab-content">
			<?php 
				$j = 1;
				foreach($category as $cat){
					$terms = get_term_by('id', $cat, 'product_cat');
					if( $terms ){				
			?>
			<div class="tab-pane<?php if( ( $j == $tab_active )){ echo ' active in'; } ?>" id="<?php echo esc_attr( $cat. '_' .$widget_id ) ?>"></div>
					<?php $j ++; ?>
			<?php
					}
				}
			?>
		</div>
	</div>
</div>