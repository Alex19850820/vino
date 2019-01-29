<?php if (!have_posts()) : ?>
<?php get_template_part('templates/no-results'); ?>
<?php endif; ?>
<div class="blog-full-list">
<?php 
	while (have_posts()) : the_post(); 
	$post_format = get_post_format();
?>
	<div id="post-<?php the_ID();?>" <?php post_class( 'theme-clearfix' ); ?>>
		<div class="entry">
			<?php if (get_the_post_thumbnail()){?>
			<div class="entry-thumb pull-left">
				<a class="entry-hover" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">			
					<?php the_post_thumbnail("large")?>
				</a>
			</div>
			<?php }?>
			<div class="meta pull-left">
				    <span class="entry-share"></span>
					 <span class="entry-comment"></span>
					  <span class="entry-heart"></span>
			</div>
			<div class="entry-content">
				<div class="date-blog-left">
				    <div class="entry-date">
						<div class="d-blog">
							<?php echo	get_the_modified_date('d') ?>			
						</div>
						<div class="m-blog">
							<?php echo get_the_modified_date('m') ?>,<?php echo get_the_modified_date('Y') ?>
						</div>
					</div>
					<div class="entry-img"> 
					     <i class="fa fa-picture-o"></i>
					</div>
				</div>
			   <div  class="content-blog-right">
					<div class="title-blog">
						<h3>
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?> </a>
						</h3>
					</div>
					<div class="entry-meta">
						<span class="category-author"><i class="fa fa-user"></i><?php the_author_posts_link(); ?></span>
						<span class="entry-meta-category"><i class="fa fa-folder-open"></i><?php the_category(', '); ?></span>
						<span class="entry-comment">
						 <i class="fa fa-comments"></i><?php echo $post->comment_count .'<span>'. esc_html__(' comments', 'shoppystore').'</span>'; ?>
					    </span>
				    </div>
				 	<div class="entry-description">
						<?php 
							the_content('...');						
						?>
						 <div class="bl_read_more"><a href="<?php the_permalink(); ?>"><?php esc_html_e('Read more','shoppystore')?></a></div>			
						 <?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'shoppystore' ).'</span>', 'after' => '</div>' , 'link_before' => '<span>', 'link_after'  => '</span>' ) ); ?>
					</div>	
				</div>					
			</div>
		</div>
	</div>
<?php endwhile; ?>
</div>
<div class="clearfix"></div>
