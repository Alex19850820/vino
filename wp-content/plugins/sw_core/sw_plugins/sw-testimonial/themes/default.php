<?php 
	$ya_direction = ya_options()->getCpanelValue('direction');
	$default = array(
		'post_type' => 'testimonial',
		'orderby' => $orderby,
		'order' => $order,
		'post_status' => 'publish',
		'showposts' => $numberposts
	);
	$id = rand().time();
	$list = new WP_Query( $default );
if ( $list -> have_posts() ){
?>
	<div id="sw_testimonial_<?php echo esc_attr( $id ) ?>" class="responsive-slider client-wrapper-b sw-testimonial-slider  <?php echo esc_html($el_class); ?> loading clearfix" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>" data-rtl="<?php echo ( is_rtl() || $ya_direction == 'rtl' )? 'true' : 'false';?>" data-autoplay="<?php echo esc_attr( $autoplay ); ?>" data-dots="<?php echo esc_attr($dots); ?>">
		<div class="title-home"><h2><?php echo esc_html($title); ?></h2></div>
		<div class="resp-slider-container">
			<div class="slider responsive">
			<?php
				$count_items = ($numberposts >= $list->found_posts) ? $list->found_posts : $numberposts;
				$i = 0;
				while($list->have_posts()): $list->the_post();
				global  $post;
				$au_name = get_post_meta( $post->ID, 'au_name', true );
				$au_url  = get_post_meta( $post->ID, 'au_url', true );
				$au_info = get_post_meta( $post->ID, 'au_info', true );
				$link = get_post_meta( $post->ID, 'link', true );
				$target = get_post_meta( $post->ID, 'target', true );
					if( $i % $item_row == 0 ){
			?>
				<div class="item">
					<?php } ?>
					<div class="item-wrap">							
						<?php if(has_post_thumbnail()){ ?>
							<div class="item-img item-height">
								<div class="image-client">
									<a href="<?php echo esc_url( $link ); ?>" title="<?php the_title_attribute();?>" target="<?php echo $target; ?>">
										<?php the_post_thumbnail(); ?>
									</a>
								</div>
							</div>
						<?php } ?>
						<div class="name-client">
                        <h2><a href="<?php echo $au_url ?>" title="<?php the_title_attribute();?>"><?php echo esc_html($au_name) ?></a></h2>
						<div class="info-client"><?php echo esc_html($au_info) ?></div>
					    </div>
						<div class="client-comment">
							<?php	
								$text = get_the_content($post->ID);
								$content = wp_trim_words($text, $length);
								echo esc_html($content);
							?>
						</div>
						
				    </div>
					<?php if( ( $i+1 ) % $item_row == 0 || ( $i+1 ) == $count_items ){?> </div><?php } ?>
			<?php $i ++; endwhile; wp_reset_query();?>
			</div>
		</div>
	</div>
<?php
}
?>