<?php
/**
 * Template Name: page-4
 */

?>
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
<div class="cat-main">
<div class="container">
<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-9">
			<?php $ids = array( 82, 86, 76 );  ?>
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
</div>
<?php get_footer(); ?>