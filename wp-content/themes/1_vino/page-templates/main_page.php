<?php
/**
Template Name: Главная страница
Template Post Type: post, page
 */
?>
<?php get_header(); ?>

<div class="container-fluid main_banner" style="background-image: url(<?php echo CFS()->get('slider_pic',10); ?>)">
		<div class="container">
			<div class="row">
				<div class="col-md-3 col-sm-5">
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
				<div class="col-md-1 col-1"></div>
				<div class="col-md-8 col-sm-7">
					<div class="plashka">
						<h1><?php echo CFS()->get('title1',10); ?></h1>
						<h3><?php echo CFS()->get('title2',10); ?></h3>
						<br>
						<a href="<?php echo CFS()->get('slider_btn_url',10); ?>" class="main_button"><?php echo CFS()->get('slider_btn_caption',10); ?></a>
					</div>
				</div>
			</div>
		</div>
	</div>
<div class="cat-main">
<div class="container">
<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-9">
			<?php $ids = array();  ?>
			<?php $items_main = new WP_Query( array(
				'post_type' => 'product',
				'order' => 'ASC',
				'orderby' => 'rand',
				'post__in' => $ids
			)); ?>
			<?php while ($items_main->have_posts()) : $items_main->the_post(); ?>	
			
				<div class="col-md-4 tovar_item_a">
							<a href="<?php the_permalink(); ?>">
								<div class="tovar_item">
									<div class="tovar_caption"><?php $product_cat = get_the_term_list( get_the_ID(), 'product_cat', '', ', ' ); ?><?php echo $product_cat = strip_tags( $product_cat ); ?></div>
									<div class="tovar_pic"><?php the_post_thumbnail(); ?></div>
								    <div class="tovat_title"><?php the_title(); ?></div>
							        <div class="tovar_price">										
									 <?php global $product; ?>   									
									 <?php if ($product->is_type( 'simple' )) : ?>
									 <p class="price price-main"><?php echo $product->get_price_html(); ?></p>
									 <?php endif; ?>									
									 <?php if($product->product_type=='variable') : ?>
									 Цена <?php echo $variation_min_price = $product->get_variation_price('min'); ?> руб.
									 <?php endif; ?>			
								    </div>	
									
								</div>
						   </a>	
			    </div>
			<?php endwhile; ?>
		</div>
	</div>
</div>
</div>

	<div role="form" class="wpcf7" id="wpcf7-f20-p21-o1" lang="ru-RU" dir="ltr">
<div class="screen-reader-response"></div>

	<form action="#wpcf7-f20-p21-o1" method="post" novalidate="novalidate" class="wpcf7-form">
		<div style="display: none;">
			<input type="hidden" name="_wpcf7" value="20" />
			<input type="hidden" name="_wpcf7_version" value="4.7" />
			<input type="hidden" name="_wpcf7_locale" value="ru_RU" />
			<input type="hidden" name="_wpcf7_unit_tag" value="wpcf7-f20-p21-o1" />
			<input type="hidden" name="_wpnonce" value="3b1cd1ee55" />
		</div>
		<div class="container-fluid form1" style="background-image: url(<?= bloginfo('template_directory'); ?>/img/form_bg.jpg)">
			<div class="container">
				<div class="row">
					<div class="col-md-12 text-center">
						<h3 class="form_title">ФОРМА ОБРАТНОЙ СВЯЗИ</h3>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2"></div>
					<div class="col-md-4">
						<input type="text" class="in_name" name="your-name" placeholder="Ваше имя">
						<br>
					</div>
					<div class="col-md-4">
						<input type="text" class="in_name" name="your-email" placeholder="Ваш e-mail">
						<br>
					</div>
				</div>

				<div class="row">
					<div class="col-md-2"></div>
					<div class="col-md-8 text-center">
						<textarea name="your-message" class="textbox" id="" cols="30" rows="5" placeholder="Сообщение"></textarea>
						<br>
						<button class="form_btn">ОТПРАВИТЬ</button>
						<br>
							<div class="wpcf7-response-output wpcf7-display-none"></div>
						<br>
					</div>
				</div>

			</div>
		</div>
	</form>
	</div>


	
	<div class="container-fluid blog_main">
		<div class="container">
			<div class="clearfix"></div>
			<div class="row white_bottom">
				<div class="col-md-6">
					<h3>СТАТЬИ</h3>
				</div>
				<div class="col-md-6 text-right">
					<a href="#"><h5>Все статьи</h5></a>
				</div>
			</div>

			<div class="row">


				<?php query_posts('cat=8&showposts=3'); ?>
				<?php if (have_posts()): ?>
					<?php while (have_posts()): the_post(); ?>

						<div class="col-md-4">
							<a href="<?php the_permalink(); ?>">
								<div class="blog_item">
									<div class="blog_pic" style="background-image: url(<?php echo CFS()->get('image'); ?>)"></div>
									<div class="blog_date"><?php echo get_the_date(); ?></div>
									<h4><?php the_title(); ?></h4>
									<div class="blog_text">
										<?php echo CFS()->get('announce'); ?>
									</div>
								</div>
							</a>
						</div>

					<?php endwhile; ?>
				<?php endif; ?>

			</div>

		</div>
	</div>

	<div class="container about">
		<div class="row">
			<div class="col-md-12">
				<h3>О нас</h3>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="about_text">
					<?php echo CFS()->get('about',10); ?>
				</div>
				<br><br>
			</div>
		</div>
	</div>

<?php get_footer(); ?>