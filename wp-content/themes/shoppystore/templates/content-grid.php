<?php if (!have_posts()) : ?>
<?php get_template_part('templates/no-results'); ?>
<?php endif; ?>
<?php
	$ya_blog_columns = ya_options()->getCpanelValue('blog_column');	
	$col = 'col-sm-'.(12/$ya_blog_columns).' theme-clearfix';
	global $instance;
?>
<div class="row grid-blog">
<?php 
	while (have_posts()) : the_post(); 
	$format = get_post_format();
	global $post;
?>
	<div id="post-<?php the_ID();?>" <?php post_class($col); ?>>
		<div class="entry clearfix">
			<?php if( $format == '' || $format == 'image' ){?>
				<?php if ( get_the_post_thumbnail() ){?>
				<div class="entry-thumb">	
					<div class="entry-thumb-content">
						<a class="entry-hover" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
							<?php the_post_thumbnail( 'large' )?>				
						</a>	
					</div>
				</div>
				
			<?php }else{ ?>
				<div class="entry-thumb">
					<a class="entry-hover" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
						<div class="img_over">
							<img src="<?php echo get_template_directory_uri().'/assets/img/format/medium-'.$format.'.png'; ?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>" />
						</div>
					</a>
				</div>
			<?php } ?>

			<div class="entry-content">				
				<div class="title-blog">
					<h3>
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?> </a>
					</h3>
				</div>
				<div class="entry-meta">
						<span class="category-author"><i class="fa fa-user"></i><?php the_author_posts_link(); ?></span>
						<span class="entry-meta-category"><i class="fa fa-folder-open"></i><?php the_category(', '); ?></span>
						<?php 
		                    $comment_count = $post->comment_count;
		                    if($comment_count > 1) {
						?>
						<span class="entry-comment">
						     <i class="fa fa-comments"></i><?php echo $post->comment_count .'<span>'. esc_html__(' comments', 'shoppystore').'</span>'; ?>
						</span>
						<?php }else { ?>
						<span class="entry-comment">
						     <i class="fa fa-comments"></i><?php echo $post->comment_count .'<span>'. esc_html__(' comment', 'shoppystore').'</span>'; ?>
						</span>
						<?php } ?>
				</div>
				<div class="entry-summary">
					<?php 												
						if ( preg_match('/<!--more(.*?)?-->/', $post->post_content, $matches) ) {
							$content = explode($matches[0], $post->post_content, 2);
							$content = $content[0];
							$content = wp_trim_words($post->post_content, 22, '...');
							echo $content;	
						} else {
							the_content('...');
						}		
					?>	
				</div>
				 <?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'shoppystore' ).'</span>', 'after' => '</div>' , 'link_before' => '<span>', 'link_after'  => '</span>' ) ); ?>
			</div>
			<?php } elseif( !$format == ''){?>
				<div class="entry-thumb">	
						<?php if( $format == 'video' || $format == 'audio' ){ ?>	
							<?php echo ( $format == 'video' ) ? '<div class="video-wrapper">'. get_entry_content_asset($post->ID) . '</div>' : get_entry_content_asset($post->ID); ?>										
						<?php } ?>

						<?php if( $format == 'gallery' ) { 
							if(preg_match_all('/\[gallery(.*?)?\]/', get_post($instance['post_id'])->post_content, $matches)){
								$attrs = array();
								if (count($matches[1])>0){
									foreach ($matches[1] as $m){
										$attrs[] = shortcode_parse_atts($m);
									}
								}
								if (count($attrs)> 0){
									foreach ($attrs as $attr){
										if (is_array($attr) && array_key_exists('ids', $attr)){
											$ids = $attr['ids'];
											break;
										}
									}
								}
							?>
							<div class="entry-thumb">
								<div id="gallery_slider_<?php echo $post->ID; ?>" class="carousel slide gallery-slider" data-interval="0">	
									<div class="carousel-inner">
										<?php
											$ids = explode(',', $ids);						
											foreach ( $ids as $i => $id ){ ?>
												<div class="item<?php echo ( $i== 0 ) ? ' active' : '';  ?>">			
														<?php echo wp_get_attachment_image($id, 'full'); ?>
												</div>
											<?php }	?>
									</div>
									<a href="#gallery_slider_<?php echo $post->ID; ?>" class="left carousel-control" data-slide="prev"><?php esc_html_e( 'Prev', 'shoppystore' ) ?></a>
									<a href="#gallery_slider_<?php echo $post->ID; ?>" class="right carousel-control" data-slide="next"><?php esc_html_e( 'Next', 'shoppystore' ) ?></a>
								</div>
							</div>
							<?php }	?>							
						<?php } ?>

						<?php if( $format == 'quote' ) { ?>
						<?php } ?>
				</div>
					<div class="entry-content">
						<div class="title-blog">
							<h3>
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?> </a>
							</h3>
						</div>
						<div class="entry-meta">
							<span class="category-author"><i class="fa fa-user"></i><?php the_author_posts_link(); ?></span>
							<span class="entry-meta-category"><i class="fa fa-folder-open"></i><?php the_category(', '); ?></span>
							<?php 
			                    $comment_count = $post->comment_count;
			                    if($comment_count > 1) {
							?>
							<span class="entry-comment">
							     <i class="fa fa-comments"></i><?php echo $post->comment_count .'<span>'. esc_html__(' comments', 'shoppystore').'</span>'; ?>
							</span>
							<?php }else { ?>
							<span class="entry-comment">
							     <i class="fa fa-comments"></i><?php echo $post->comment_count .'<span>'. esc_html__(' comment', 'shoppystore').'</span>'; ?>
							</span>
							<?php } ?>
				        </div>
						<div class="entry-summary">
						  <?php the_content( '...' ); ?>
						</div>					
					</div>
				
			<?php } ?>
				
		</div>
	</div>
<?php endwhile; ?>
</div>
<div class="clearfix"></div>


