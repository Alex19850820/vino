<?php $ya_header_style 	= ya_options()->getCpanelValue('header_style'); ?>
<?php get_header( $ya_header_style ) ?>
<?php 
	$p_imgintro = ya_options()->getCpanelValue( 'portfolio_imgintro' );
?>
<div class="container">
	<div class="portfolio-intro">
		
	<?php
	if( $p_imgintro != '' ){
		echo '<img src="' . $p_imgintro . '"/>';
	}
	echo '<h1>'. __( 'Portfolio', 'sw_core' ) .'</h1>';

	?>
	</div>
</div>
<div class="container">
	<div id="main" class="main">
	<?php 
		while (have_posts()) : the_post(); 
		global $post;
		$skill 		= get_post_meta( $post->ID, 'skill', true );	
		$p_url 		= get_post_meta( $post->ID, 'p_url', true );
		$copyright 	= get_post_meta( $post->ID, 'copyright', true );
		$terms 		= get_the_terms( $post->ID, 'portfolio_cat' );
		$term_str 	= '';
		foreach( $terms as $key => $term ){
			$str = ( $key == 0 ) ? '' : ', ';
			$term_str .= $str . '<a href="'. get_term_link( $term->term_id, 'portfolio_cat' ) .'">'. $term->name .'</a>';
		}
	?>
		<div <?php post_class(); ?>>
		<!-- Content Portfolio -->
			<div class="portfolio-top">
				<h1 class="portfolio-title"><?php the_title(); ?></h1>
				<div class="portfolio-content clearfix">
				<?php if( has_post_thumbnail() ){ ?>
					<div class="single-thumbnail pull-left">
						<?php the_post_thumbnail( 'large' ); ?>
					</div>
					<?php } ?>
					<div class="single-portfolio-content">
						<h3><?php esc_html_e( 'Project Description', 'sw_core' ); ?></h2>
						<div class="single-description">
							<?php the_content(); ?>
						</div>
						<h3><?php esc_html_e( 'Project Detail', 'sw_core' ); ?></h2>
						<div class="portfolio-meta">
							<?php if( $skill != '' ){ ?>
								<div class="pmeta-item">
									<?php echo '<span>'.__( 'Skill Needed', 'sw_core' ).':</span> '. esc_html( $skill ); ?>
								</div>
							<?php } ?>
							<?php if( $skill != '' ){ ?>
								<div class="pmeta-item">
									<?php echo '<span>'.__( 'Category', 'sw_core' ).':</span> '. $term_str; ?>
								</div>
							<?php } ?>
							<?php if( $p_url != '' ){ ?>
								<div class="pmeta-item">
									<?php echo '<span>'.__( 'URL', 'sw_core' ).':</span> <a href="'. esc_html( $p_url ) .'">'. esc_html( $p_url ) .'</a>' ; ?>
								</div>
							<?php } ?>
							<?php if( $copyright != '' ){ ?>
								<div class="pmeta-item">
									<?php echo '<span>'.__( 'Copyright', 'sw_core' ).':</span> '. esc_html( $copyright ); ?>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
			<!-- End Content Portfolio -->			
			<!-- Related Portfolio -->
			<?php 
				global $related_term;
				$categories = get_the_terms( $post->ID, 'portfolio_cat' );								
				$category_ids = array();
				foreach( $categories as $individual_category ) {$category_ids[] = $individual_category->term_id;}
				if ( $categories ) {
				$related = array(
					'post_type'	   => 'portfolio',
					'tax_query' => array(
						array(
							'taxonomy' => 'portfolio_cat',
							'field' => 'term_id',
							'terms' => $category_ids
						)
					),
					'post__not_in' => array( $post->ID ),
					'showposts'	   => 4,
					'orderby'	   => 'rand',	
					'ignore_sticky_posts'=> 1
				);				
				$query = new wp_query( $related );
				//var_dump( $query );
				if( $query -> have_posts() ){
			?>
			<!-- Comment Portfolio -->
			<?php if (comments_open()){ ?>
			<div class="comment-form">				
				<?php comments_template('/templates/comments.php'); ?>
			</div>
			<?php } ?>
			<!-- End Comment Portfolio -->
			<div class="related-portfolio">
				<h2 class="p-title"><?php esc_html_e( 'Related Project' ); ?></h2>
				 <!-- Relate Post -->			
				<div class="related-items clearfix">
				<?php while( $query -> have_posts() ) : $query -> the_post(); ?>
					<div class="related-item pull-left">
						<div class="item-img">
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'thumbnail' ); ?></a>
							<h4><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h4>
						</div>
					</div>
				<?php endwhile; wp_reset_postdata(); ?>
				</div>			
			</div>
			<?php } } ?>
			<!-- End Related Portfolio -->
			
		</div>
	<?php endwhile; ?>
	</div>
</div>
<?php get_footer() ?>