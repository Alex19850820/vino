<?php get_header(); ?>

<div class="container-fluid main_banner" style="background-image: url(<?php echo CFS()->get('slider_pic',10); ?>)">
		<div class="container">
			<div class="row">
				<div class="col-md-3 col-sm-3">
					<div class="side_block hidden-xs">
						<a href="http://mirvinokura.ru/category/">
						<p class="side_title">КАТАЛОГ</p>
				    </a>
						<?php
							wp_nav_menu(array(
							  'menu' => 'sidebar_menu', // название меню
							  'theme_location'  => 'sidebar_menu',
							  'container' => '', // контейнер для меню, по умолчанию 'div', в нашем случае ставим 'nav', пустая строка - нет контейнера
							  'container_class' => '', // класс для контейнера
							  'container_id' => '', // id для контейнера
							  'menu_class' => 'hidden-xs', // класс для меню
							  'menu_id' => 'menu-head', // id для меню
							));
						?>
					</div>
				</div>
				<div class="col-md-3 col-sm-3"></div>
				<div class="col-md-9 col-sm-9">
					<div class="plashka">
						<h2><?php echo CFS()->get('title1',10); ?></h2>
						<h3><?php echo CFS()->get('title2',10); ?></h3>
						<br>
						<a href="<?php echo CFS()->get('slider_btn_url',10); ?>" class="main_button"><?php echo CFS()->get('slider_btn_caption',10); ?></a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-md-3"></div>
			<div class="col-md-9 text-center">
				<h1 class="page_title">
				<?php if ( is_shop()) : ?> 
			    <?php the_field('title_shop', 'option'); ?>
				<?php endif; ?>
				<?php if ( is_product()) : ?>
				 <?php the_title(); ?>
				<?php endif; ?>
				</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3"></div>
			<div class="col-md-9">
			<?php woocommerce_content(); ?>
			</div>
		</div>
	</div>
	

<?php get_footer(); ?>