<?php 

if( $category == '' ){
	return '<div class="alert alert-warning alert-dismissible" role="alert">
		<a class="close" data-dismiss="alert">&times;</a>
		<p>'. esc_html__( 'Please select a category for SW Woocommerce Category Slider. Layout ', 'sw_woocommerce' ) . $layout .'</p>
	</div>';
}

if( !is_array( $category ) ){
	$category = explode( ',', $category );
}
$widget_id = isset( $widget_id ) ? $widget_id : 'category_slide_'. $this->generateID();
?>
<div id="<?php echo $widget_id; ?>" class="responsive-slider sw-woo-container-slider loading"  data-lg="<?php echo esc_attr( $columns ); ?>" data-row="<?php echo esc_attr( $item_row ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>"  data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
		<div class="block-title">
			<span class="page-title-slider"><?php echo $title1; ?></span>
		</div>
		<div class="resp-slider-container">
			<div class="slider responsive">
			<?php 
				$i = 0;
				foreach( $category as $cat ){
					$term = get_term_by('slug', $cat, 'product_cat');						
					if( $term ) :
					$thumbnail_id 	= absint( get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true ));
					$thumb = wp_get_attachment_image( $thumbnail_id, array(350, 230) );
					if( $i % $item_row == 0 ) {
			?>
				<div class="item item-product-cat">					
			<?php }?>
					<div class="item-image">
						<?php echo $thumb; ?>
						<h3><a href="<?php echo get_term_link( $term->term_id, 'product_cat' ); ?>"><?php echo esc_html( $term->name ); ?></a></h3>
					</div>
				<?php if( ( $i+1 ) % $item_row == 0 || ( $i+1 ) == count( $category ) ){?> </div><?php } ?>
				<?php $i++; endif; ?>
			<?php } ?>
			</div>
		</div>
	</div>		