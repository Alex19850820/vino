<?php if (!have_posts()) : ?>
<?php get_template_part('templates/no-results'); ?>
<?php endif; ?>
<div class="blog-content-list">
<?php 
	while (have_posts()) : the_post(); 
	$post_format = get_post_format();
?>
	<div id="post-<?php the_ID();?>" <?php post_class( 'theme-clearfix' ); ?>>
		<div class="entry clearfix">
			<?php if (get_the_post_thumbnail()){?>
			<div class="entry-thumb pull-left">
				<a class="entry-hover" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">			
					<?php the_post_thumbnail("thumbnail")?>
				</a>
			</div>
			<?php }?>
			<div class="entry-content">
			 
				<div class="title-blog">
					<h3>
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?> </a>
					</h3>
				</div>
				<div class="meta-tag">
					<?php if( has_tag() ){ ?><span class="tag-blog"><?php the_tags(); ?><?php } ?></span>
					<span class="category-blog"><?php esc_html_e('Categories: ', 'shoppystore'); ?><?php the_category(', '); ?></span>
				</div>
				   <span class="entry-date">
						<i class="fa fa-calendar"></i><?php echo ( get_the_title() ) ? date( 'l, F j, Y',strtotime($post->post_date)) : '<a href="'.get_the_permalink().'">'.date( 'l, F j, Y',strtotime($post->post_date)).'</a>'; ?>
					</span>
				<div class="entry-description">
					<?php 
												
						if ( preg_match('/<!--more(.*?)?-->/', $post->post_content, $matches) ) {
							$content = explode($matches[0], $post->post_content, 2);
							$content = $content[0];
							$content = wp_trim_words($post->post_content,50, '...');
							echo $content;	
						} else {
							the_content('...');
						}		
					?>
				</div>
				<?php 
                    $comment_count = $post->comment_count;
                    if($comment_count > 1) {
				?>
				<span class="entry-comment">
						 <?php echo $post->comment_count .'<span>'. esc_html__(' Comments', 'shoppystore').'</span>'; ?>
				</span>
				<?php }else { ?>
				<span class="entry-comment">
						 <?php echo $post->comment_count .'<span>'. esc_html__(' Comment', 'shoppystore').'</span>'; ?>
				</span>	
				<?php } ?>
				|
				<span class="category-author"><?php esc_html_e('Posted By', 'shoppystore'); ?> <?php the_author_posts_link(); ?></span>
			    
				 <?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'shoppystore' ).'</span>', 'after' => '</div>' , 'link_before' => '<span>', 'link_after'  => '</span>' ) ); ?>
			</div>
		</div>
	</div>
<?php endwhile; ?>
</div>
<div class="clearfix"></div>