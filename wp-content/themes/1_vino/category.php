<?php get_header(); ?>

<div class="container">
	<br>
	<div class="row">
		<div class="col-md-3">
		 
		</div>
		<div class="col-md-9 text-center">
			<h2 class="page_title 222"><?php single_cat_title(); ?></h2>
			<div class="cat_desc">
				<?php echo category_description(); ?>
			</div>
		</div>
	</div>
	<br><br>
</div>

<?php get_footer(); ?>