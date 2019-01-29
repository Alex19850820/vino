<?php
$loop = new WP_Query( $query_args );
if ( $loop->have_posts() ) {
	while ( $loop->have_posts() ) : $loop->the_post();
if($twi_woo_style == 'twi_woo_slider' ){
?>
<div class="item">
<?php
}
		wc_get_template_part( 'content', 'product' );
if($twi_woo_style == 'twi_woo_slider' ){
?>
</div>
<?php
}
	endwhile;
} else {
	echo __( 'No products found' );
}
wp_reset_postdata();
?>