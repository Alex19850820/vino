<?php get_header(); ?>

	<div class="container">
		<br>
		<div class="row">
			<div class="col-md-3"></div>
			<div class="col-md-9 text-center">
				<h1 class="page_title"><?php the_title(); ?></h1>
			</div>
		</div>
		<br><br>
		<div class="row">
			<div class="col-md-3"></div>
			<div class="col-md-9">
				<?php if (have_posts()): while (have_posts()): the_post(); ?>
					<?php the_content(); ?>
				<?php endwhile; endif; ?>
			</div>
		</div>
	</div>

<?php get_footer(); ?>