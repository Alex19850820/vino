<?php 
	$default = array(
		'post_type' => 'partner',
		'orderby' => $orderby,
		'order' => $order,
		'post_status' => 'publish',
		'showposts' => $numberposts
	);
	if( $partner_id != '' || $partner_id != 0 ){
		$default['tax_query'] = array(
			array(
				'taxonomy'	=> 'partners',
				'field'		=> 'id',
				'terms'		=> $partner_id
			)
		);
	}
	$id = rand().time();
	$list = new WP_Query( $default );
if ( $list -> have_posts() ){
?>
	<div id="sw_partner_<?php echo esc_attr( $id ) ?>" class="<?php echo $el_class ?> responsive-slider sw-partner-container-slider loading clearfix" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>" data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
		<div class="title-home"><?php if( $title != '' ) { ?><h2><?php echo esc_html($title); ?></h2><?php } ?></div> 
		<div class="resp-slider-container">
			<div class="slider responsive">
			<?php
				$count_items = ($numberposts >= $list->found_posts) ? $list->found_posts : $numberposts;
				$i = 0;
				while($list->have_posts()): $list->the_post();
				global  $post;
				$link = get_post_meta( $post->ID, 'link', true );
				$target = get_post_meta( $post->ID, 'target', true );
				$description = get_post_meta( $post->ID, 'description', true );
					if( $i % $item_row == 0 ){
			?>
				<div class="item">
					<?php } ?>
					<div class="item-wrap">							
						<?php if(has_post_thumbnail()){ ?>
							<div class="item-img item-height">
								<div class="item-img-info">
									<a href="<?php echo esc_url( $link ); ?>" title="<?php the_title_attribute();?>" target="<?php echo $target; ?>">
										<?php the_post_thumbnail(); ?>
									</a>
								</div>
							</div>
						<?php } ?>
						<?php if( $description != '' ){ ?>
							<div class="item-desc">
								<?php echo $description; ?>
							</div>		
						<?php } ?>
					</div>
					<?php if( ( $i+1 ) % $item_row == 0 || ( $i+1 ) == $count_items ){?> </div><?php } ?>
			<?php $i ++; endwhile; wp_reset_query();?>
			</div>
		</div>
	</div>
<?php
}
?>