<?php //!is_front_page() && get_template_part('templates/page', 'header'); ?>

<?php get_template_part('header'); ?>
<?php $ya_sidebar_template = ya_options()->getCpanelValue('sidebar_blog') ;?>
<div class="container">
<div class="row">
<?php if ( is_active_sidebar_YA('left-blog') && $ya_sidebar_template != 'right_sidebar' && $ya_sidebar_template !='full' ):
	$left_span_class = 'col-lg-'.ya_options()->getCpanelValue('sidebar_left_expand');
	$left_span_class .= ' col-md-'.ya_options()->getCpanelValue('sidebar_left_expand_md');
	$left_span_class .= ' col-sm-'.ya_options()->getCpanelValue('sidebar_left_expand_sm');
?>
<aside id="left" class="sidebar <?php echo esc_attr($left_span_class); ?>">
	<?php dynamic_sidebar('left-blog'); ?>
</aside>

<?php endif; ?>

<div class="category-contents <?php ya_content_blog(); ?>">
	<div class="category-header">
		<h1 class="entry-title"><?php echo ya_title();?></h1>
		<?php 
			if( category_description() ){
				echo '<div class="category-desc">'.category_description().'</div>';
			}
		?>
	</div>
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
					   <span class="entry-date">
							<i class="fa fa-calendar"></i><?php echo ( get_the_title() ) ? date( 'l, F j, Y',strtotime($post->post_date)) : '<a href="'.get_the_permalink().'">'.date( 'l, F j, Y',strtotime($post->post_date)).'</a>'; ?>
						</span>
					<div class="entry-description">
						<?php 
													
							if ( preg_match('/<!--more(.*?)?-->/', $post->post_content, $matches) ) {
								$content = explode($matches[0], $post->post_content, 2);
								$content = $content[0];
								$content = wp_trim_words($post->post_content,80, '...');
								echo $content;	
							} else {
								echo wp_trim_words($post->post_content,80, '...');
							}		
						?>
					</div>
					<span class="entry-comment">
							 <?php echo $post->comment_count .'<span>'. esc_html__(' Комментарии', 'shoppystore').'</span>'; ?>
					</span>
					|
					<span class="category-author"><?php esc_html_e('Сообщение от', 'shoppystore'); ?> <?php the_author_posts_link(); ?></span>
					
					 <?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Страницы:', 'shoppystore' ).'</span>', 'after' => '</div>' , 'link_before' => '<span>', 'link_after'  => '</span>' ) ); ?>
				</div>
			</div>
		</div>
	<?php endwhile; ?>
	</div>
	<div class="clearfix"></div>
	<?php get_template_part('templates/pagination'); ?>
</div>
<?php if ( is_active_sidebar_YA('right-blog') && $ya_sidebar_template !='left_sidebar' && $ya_sidebar_template !='full' ):
	$right_span_class = 'col-lg-'.ya_options()->getCpanelValue('sidebar_right_expand');
	$right_span_class .= ' col-md-'.ya_options()->getCpanelValue('sidebar_right_expand_md');
	$right_span_class .= ' col-sm-'.ya_options()->getCpanelValue('sidebar_right_expand_sm');
?>
<aside id="right" class="sidebar <?php echo esc_attr($right_span_class); ?>">
	<?php dynamic_sidebar('right-blog'); ?>
</aside>
<?php endif; ?>
</div>
</div>
</div>
<?php get_template_part('footer'); ?>
<? Php echo do_shortcode ('[show_theme_switch_link]'); ?> 
