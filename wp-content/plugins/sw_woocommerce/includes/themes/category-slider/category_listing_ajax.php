<?php 
	global $wpdb;
	$widget_id = isset( $widget_id ) ? $widget_id : $this->generateID();
	$max_page = $this->sw_count_category( $numberposts );
?>
<div id="<?php echo 'ajax_listing_' . $widget_id; ?>" class="sw-ajax-categories">
	<?php	if( $title1 != '' ){ ?>
	<div class="block-title">
		<h3><span><?php echo $title1; ?></span></h3>
	</div>
	<?php } ?>
	<div class="resp-listing-container clearfix">
	<?php
		$terms = get_terms( 'product_cat', array( 'parent' => 0, 'hide_empty' => false, 'number' => $numberposts ) );
		foreach( $terms as $term ){
			if( $term ) :
				$thumbnail_id 	= get_woocommerce_term_meta( $term->term_id, 'thumbnail_id1', true );
				$thumb = wp_get_attachment_image( $thumbnail_id,'thubnail' );
				$thubnail = ( $thumb != '' ) ? $thumb : '<img src="'.esc_url( 'http://placehold.it/210x270' ) .'" alt=""/>';
	?>
			<div class="item item-product-cat">					
				<div class="item-image">
					<a href="<?php echo get_term_link( $term->term_id, 'product_cat' ); ?>"><?php echo $thubnail; ?></a>
					<div class="item-content">
						<h3><a href="<?php echo get_term_link( $term->term_id, 'product_cat' ); ?>"><?php echo esc_html( $term->name ); ?></a></h3>
					</div>
				</div>
			
			</div>
		<?php endif; ?>
	<?php } ?>
	</div>
	<a href="javascript:void(0)" class="btn-loadmore" data-maxpage="<?php echo esc_attr( $max_page ); ?>" data-ajaxurl="<?php echo esc_url( sw_ajax_url() ) ?>" data-number="<?php echo esc_attr( $numberposts ) ?>" data-title="<?php esc_html_e( 'Load More', 'sw_woocommerce' ) ?>" data-title_loaded="<?php esc_html_e( 'All Categories Loaded', 'sw_woocommerce' ) ?>"></a>
</div>		