<?php get_template_part('header'); ?>
<?php $ya_sidebar_template = ya_options()->getCpanelValue('sidebar_blog') ;?>
	<div class="container">
		<div class="row sidebar-row">
<?php if ( is_active_sidebar_YA('left-blog') && $ya_sidebar_template != 'right_sidebar' && $ya_sidebar_template !='full' ):
	$left_span_class = 'col-lg-'.ya_options()->getCpanelValue('sidebar_left_expand');
	$left_span_class .= ' col-md-'.ya_options()->getCpanelValue('sidebar_left_expand_md');
	$left_span_class .= ' col-sm-'.ya_options()->getCpanelValue('sidebar_left_expand_sm');
?>
<aside id="left" class="sidebar <?php echo esc_attr($left_span_class); ?>">
	<?php dynamic_sidebar('left-blog'); ?>
</aside>

<?php endif; ?>

<div class="single main <?php ya_content_blog(); ?>" >
<?php while (have_posts()) : the_post(); ?>
  <?php setPostViews(get_the_ID()); ?>
  <div <?php post_class(); ?>>
  <div class="entry">
	<?php $pfm = get_post_format();?>
    <header class="header-single">
		<?php if( $pfm == '' || $pfm == 'image' ){?>
	  <?php if( has_post_thumbnail() ){ ?>
	  <div class="single-thumb">
		<?php the_post_thumbnail(); ?>
	  </div>
	  <?php } }?>
	
    </header>
    <div class="entry-content">
	<h1 class="entry-title"><?php the_title(); ?></h1>
		<div class="entry-meta">
		                <span class="entry-date"><i class="fa fa-clock-o"></i><?php the_time('j M Y')?></span>
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
	  <div class="single-content">
		  <?php the_content(); ?>
		  <!-- Tag -->
		  <?php if(get_the_tag_list()) { ?>
		  <div class="single-tag">
				<?php echo get_the_tag_list('<span>Tags: </span>',', ','');  ?>
		  </div>
		  <?php } ?>
	  </div>
	  <!-- Social -->
	  <?php get_social(); ?>
	  <div class="single-bottom"> 
			  <!-----  author ----------->
			<div id="authorarea">
			    <div class="author-title">
				   <h3><?php esc_html_e('About the Author', 'shoppystore'); ?></h3>
				</div>
				<?php echo get_avatar( get_the_author_meta( 'user_email' ), 70 ); ?>
					
				<div class="authorinfo">
					<p class="author-email"><?php the_author_meta( 'email' ); ?></p>
					<p class="author-meta"><?php the_author_meta( 'description' ); ?></p>
				</div>
			</div>
		  <!-- Relate Post -->
		  <?php 
			$ya_sb_blog = ya_options()->getCpanelValue('sidebar_blog');
			$related_class = '';
			$related_numb = 3;
			if( $ya_sb_blog == 'left_sidebar' || $ya_sb_blog == 'right_sidebar' ){
				$related_class .= 'col-lg-4 col-md-4 col-sm-4';
				$related_numb = 3;
			}else if( $ya_sb_blog == 'lr_sidebar' ){
				$related_class .= 'col-lg-6 col-md-6 col-sm-6';
				$related_numb = 2;
			}else if( $ya_sb_blog == 'full' ){
				$related_class .= 'col-lg-3 col-md-3 col-sm-6';
				$related_numb = 4;
			}
			global $post;
			global $related_term;
			$categories = get_the_category($post->ID);								
			$category_ids = array();
			foreach($categories as $individual_category) {$category_ids[] = $individual_category->term_id;}
			if ($categories) {
			$related = array(
				'category__in' => $category_ids,
				'post__not_in' => array($post->ID),
				'showposts'=> $related_numb,
				'orderby'	=> 'rand',	
				'ignore_sticky_posts'=>1
			   );
			?>
		  <div class="single-post-relate clear">
		    <div class="relate-title">
				<h3><?php esc_html_e('Related Post', 'shoppystore'); ?></h3>
			</div>
				<div class="row">
				<?php
					$related_term = new WP_Query($related);
					while($related_term -> have_posts()):$related_term -> the_post();
				?>
					<div class="<?php echo esc_attr( $related_class ); ?>">
						<div class="item-relate-img">
							<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail'); ?></a>
						</div>
						<div class="item-relate-content">
							<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
						</div>
					</div>
				<?php
					endwhile;
					wp_reset_postdata();
				?>
				</div>
	         </div>
	   <?php } ?>
    <?php comments_template('/templates/comments.php'); ?>
	</div>
  </div>
</div>
</div>
<?php endwhile; ?>
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
<?php get_template_part('footer'); ?>
