<?php
/**
Template Name: Страница товара
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
					<div class="price_page">Цена: <?php echo CFS()->get('price'); ?> руб</div>
					<a href="#" id="btn_zakaz">Заказать</a>
					<br><br>
					<?php echo CFS()->get('announce'); ?>
					<br>
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


	<script type="text/javascript">
		$(document).ready(function(){
			$('#field_url').val(document.location.href);
		});
	</script>

<?php get_footer(); ?>