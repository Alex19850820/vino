<?php
/**
Template Name: Страница блога
Template Post Type: post, page
 */
?>

<?php get_header(); ?>

	<div class="container">
		<br>
		<div class="row">
			<div class="col-md-3"></div>
			<div class="col-md-9 text-center">
				<h2 class="page_title"><?php the_title(); ?></h2>
			</div>
		</div>
		<br><br>

		<div class="row">
			<div class="col-md-3"></div>
			<div class="col-md-4">
				<div class="blog_pic" style="background-image: url(<?php echo CFS()->get('image'); ?>)"></div>
			</div>
			<div class="col-md-5">
				<div class="blog_announce">
					<?php echo CFS()->get('announce'); ?>
				</div>
				
			</div>
		</div>

		<br>

		<div class="row">
			<div class="col-md-3"></div>
			<div class="col-md-9">
				<div class="blog_content">
					<?php if (have_posts()): while (have_posts()): the_post(); ?>
						<?php the_content(); ?>
					<?php endwhile; endif; ?>
				</div>
				
			</div>
		</div>
	</div>

<?php get_footer(); ?>