<?php 
	$widget_id = isset( $widget_id ) ? $widget_id : $this->generateID();
	$nav_id = 'nav_tabs_res'.$this->generateID();
?>
<div class="sw-woo-tab-cat-resp loading" id="<?php echo esc_attr( 'tab_listing_' . $widget_id ); ?>" >
	<?php
		if( $category == '' ){
			return '<div class="alert alert-warning alert-dismissible" role="alert">
			<a class="close" data-dismiss="alert">&times;</a>
			<p>'. esc_html__( 'Please select a category for SW Woocommerce Tab Category Slider. Layout ', 'sw_woocommerce' ) . $layout .'</p>
		</div></div>';
		}
		if( !is_array( $category ) ){
			$category = explode( ',', $category );
		}
	?>
	<div class="resp-tab" style="position:relative;">
		<div class="top-tab-slider clearfix">
			<div class="order-title pull-left">
				<?php
					echo '<span>' . $title1 . '</span>';
				?>
			</div>
			<button class="navbar-toggle collapsed pull-right" type="button" data-toggle="collapse" data-target="#<?php echo esc_attr($nav_id); ?>"  aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="fa fa-bar"></span>
				<span class="fa fa-bar"></span>
				<span class="fa fa-bar"></span>
			</button>
			<ul class="nav nav-tabs" id="<?php echo esc_attr($nav_id); ?>">
			<?php 
				$i = 1;
				foreach($category as $cat){
					$terms = get_term_by('slug', $cat, 'product_cat');
					if( $terms != NULL ){			
			?>
				<li class="<?php if( $i == $tab_active ){echo 'active'; }?>">
					<a href="#<?php echo esc_attr( $cat. '_' .$widget_id ) ?>" data-type="tab_ajax_listing" data-layout="<?php echo esc_attr( $layout );?>" data-length="<?php echo esc_attr( $title_length ) ?>"  data-ajaxurl="<?php echo esc_url( sw_ajax_url() ) ?>" data-category="<?php echo esc_attr( $cat ) ?>" data-toggle="tab" data-catload="ajax" data-number="<?php echo esc_attr( $numberposts ); ?>" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>">
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
					$terms = get_term_by('slug', $cat, 'product_cat');
					if( $terms != NULL ){				
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