<?php
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$post_cat = $_GET['search_category'];
	$s = $_GET['s'];	
	$args_product = array(
		's' => $s,
		'post_type'	=> 'post',
		'posts_per_page' => 8,
		'paged' => $paged
	);
	if( isset( $post_cat ) && $post_cat != '' ){
		$args_product['tax_query'] = array(
			array(
				'taxonomy'	=> 'category',
				'field'		=> 'id',
				'terms'	=> $post_cat				
			)
		);
	}
	$product_query = new wp_query( $args_product );
	if( $product_query -> have_posts() ){
?>
<div class="content-list-category container">
	<div class="content_list_product">
		<div class="products-wrapper">						
			<div class="blog-full-list">
			<?php 
				while( $product_query -> have_posts() ) : $product_query -> the_post();
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
			<!--Pagination-->
			<?php if ($product_query->max_num_pages > 1) : ?>
			<div class="pag-search ">
			<div class="pagination nav-pag pull-right">
				<ul class="list-inline">
					<?php if (get_previous_posts_link()) : ?>
					<li class="pagination">Page:
					</li>
					<?php else: ?>
					<li class="disabled pagination">Page:</li>
					<?php endif; ?>

					<?php 
						if ($paged < 3){
							$i = 1;
						}
						elseif ($paged < $product_query->max_num_pages - 2){
							$i = $paged -1 ;
						}
						else {
							$i = $product_query->max_num_pages - 3;
						}
						 
						if ($product_query->max_num_pages > $i + 3){
							$max = $i + 2;
						}
						else $max = $product_query->max_num_pages;

						if ($paged == 3 && $product_query->max_num_pages > 4) {?>
					<li><a href="<?php echo get_pagenum_link('1')?>">1</a></li>
					<?php }
						if ($paged > 3 && $product_query->max_num_pages > 4) {?>
							<li><a href="<?php echo get_pagenum_link('1')?>">1</a></li>
							<li><a>...</a></li>
						<?php }
						for ($i = 1; $i<= $max ; $i++){?>
					<?php if (($paged == $i) || ( $paged ==1 && $i==1)){?>
					<li class="disabled"><a><?php echo $i?> </a></li>
					<?php } else {?>
					<li><a href="<?php echo get_pagenum_link($i)?>"><?php echo $i?>
					</a></li>
					<?php }?>
					<?php }?>

					<?php if ($max < $product_query->max_num_pages) {?>
					<li><a>...</a></li>
					<li><a
						href="<?php echo get_pagenum_link($product_query->max_num_pages)?>"><?php echo $product_query->max_num_pages?>
					</a></li>
					<?php }?>

					<?php if (get_next_posts_link()) : ?>
					<li class="pagination"><?php next_posts_link(__('<i class="fa fa-caret-right"></i>', 'shoppystore')); ?>
					</li>
					<?php else: ?>
					<li class="disabled pagination"><a><?php esc_html_e('<i class="fa fa-caret-right"></i>', 'shoppystore'); ?>
					</a></li>
					<?php endif; ?>
				</ul>
			</div>
			</div>
			<?php endif; ?>
			<!--End Pagination-->
		</div>
	</div>
</div>
	<?php }else{ ?>
		<div class="alert alert-warning alert-dismissible" role="alert">
			<a class="close" data-dismiss="alert">&times;</a>
			<p><?php esc_html_e('Sorry, no results were found.', 'shoppystore'); ?></p>
		</div>
	<?php 
	}
	?>