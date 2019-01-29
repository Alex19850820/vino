<!DOCTYPE html>
<!--[if lt IE 7]><html lang="ru" class="lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if IE 7]><html lang="ru" class="lt-ie9 lt-ie8"><![endif]-->
<!--[if IE 8]><html lang="ru" class="lt-ie9"><![endif]-->
<!--[if gt IE 8]><!-->
<html lang="ru">
<!--<![endif]-->
<head>
	<meta charset="utf-8" />

	<title><?php wp_title('&laquo;', true, 'right'); ?> </title>
	<meta content="" name="description" />
	<meta content="" property="og:image" />
	<meta content="" property="og:description" />
	<meta content="" property="og:site_name" />
	<meta content="website" property="og:type" />

	<meta content="telephone=no" name="format-detection" />
	<meta http-equiv="x-rim-auto-match" content="none">

	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	
	<script src="<?= bloginfo('template_directory'); ?>/js/jquery-1.11.1.min.js"></script>
	<script src="<?= bloginfo('template_directory'); ?>/js/bootstrap.min.js"></script>
	<script src="<?= bloginfo('template_directory'); ?>/js/parallax.min.js"></script>
	<script src="<?= bloginfo('template_directory'); ?>/js/wow.min.js"></script>
	<script>
		new WOW().init();
		
	</script>

	<!--
	<script src="<?= bloginfo('template_directory'); ?>/js/aslider.js"></script>

	<script src="<?= bloginfo('template_directory'); ?>/js/sweetalert.min.js"></script>
	<link rel="stylesheet" href="<?= bloginfo('template_directory'); ?>/css/sweetalert.css" />

-->


<script src="<?= bloginfo('template_directory'); ?>/js/jquery.bxslider.min.js"></script>
<link rel="stylesheet" href="<?= bloginfo('template_directory'); ?>/css/jquery.bxslider.css" />


<link rel="stylesheet" href="<?= bloginfo('template_directory'); ?>/css/bootstrap.css" />
<link href="<?= bloginfo('template_directory'); ?>/css/animate.min.css" rel="stylesheet">



<link href="https://fonts.googleapis.com/css?family=Roboto:400,400i,500,500i,600,600i" rel="stylesheet"> 


<script src="<?= bloginfo('template_directory'); ?>/js/jquery.waterwheelCarousel.js"></script>

<script src="<?= bloginfo('template_directory'); ?>/js/slick.min.js"></script>
<link rel="stylesheet" href="<?= bloginfo('template_directory'); ?>/css/slick.css" />
<link rel="stylesheet" href="<?= bloginfo('template_directory'); ?>/css/slick-theme.css" />
<link rel="stylesheet" href="<?= bloginfo('template_directory'); ?>/style.css?<?php echo rand();?>" />


	<!--
<link rel="stylesheet" href="font-awesome-4.7.0/<?= bloginfo('template_directory'); ?>/css/font-awesome.min.css">


	<link href="<?= bloginfo('template_directory'); ?>/css/jquery.cardtabs.css" rel="stylesheet">
	<script src="<?= bloginfo('template_directory'); ?>/js/jquery.cardtabs.js"></script>
	<link rel="stylesheet" href="libs/bootstrap/bootstrap-grid-3.3.1.min.css" />
	<link rel="stylesheet" href="libs/font-awesome-4.2.0/<?= bloginfo('template_directory'); ?>/css/font-awesome.min.css" />
	<link rel="stylesheet" href="libs/fancybox/jquery.fancybox.css" />
	<link rel="stylesheet" href="libs/owl-carousel/owl.carousel.css" />
	<link rel="stylesheet" href="libs/countdown/jquery.countdown.css" />
	<link rel="stylesheet" href="<?= bloginfo('template_directory'); ?>/css/fonts.css" />
	<link rel="stylesheet" href="<?= bloginfo('template_directory'); ?>/css/main.css" />
	<link rel="stylesheet" href="<?= bloginfo('template_directory'); ?>/css/media.css" />
-->
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

	<div class="container-fluid top_line hidden-xs">
		<div class="container">
			<div class="row">
				<div class="col-sm-10 col-md-7">
					<?php
						wp_nav_menu(array(
						  'menu' => 'header_menu', // название меню
						  'theme_location'  => 'header_menu',
						  'container' => '', // контейнер для меню, по умолчанию 'div', в нашем случае ставим 'nav', пустая строка - нет контейнера
						  'container_class' => '', // класс для контейнера
						  'container_id' => '', // id для контейнера
						  'menu_class' => 'top_menu hidden-xs', // класс для меню
						  'menu_id' => 'menu-head', // id для меню
						));

					?>
				</div>

				<div class="hidden-sm col-md-3">
                    <a href="https://vk.com/mirvinokura" title="">
                      <i class="fa fa-vk" aria-hidden="true"></i>
                    </a>
					<a href="mailto:<?php echo CFS()->get('email',10); ?>"><img src="<?= bloginfo('template_directory'); ?>/img/mail.png" alt=""> <div class="mail"><?php echo CFS()->get('email',10); ?></div> </a>
				</div>
				<div class="col-sm-2">
					<div class="search_cont">
						<input type="text" id="search" name="search" placeholder="Поиск">
					
						<button class="search_btn" type="submit"></button>
					</div>
				</div>
			</div>
		</div>

	</div>

	<div class="container main_header">
		<div class="row">
			<div class="col-md-2 text-center">
				<a href="<?php echo get_site_url(); ?>"><img src="<?= bloginfo('template_directory'); ?>/img/logo.png" alt="" class="logo"></a>
			</div>
			<div class="col-md-6 text-center">
				<h3><?php echo CFS()->get('main_header',10); ?></h3>
			</div>
			<div class="col-md-4 text-center header-all hidden-xs">
				<div class="phone_number"><img src="<?= bloginfo('template_directory'); ?>/img/phone.png" alt="" class="phone"> <?php echo CFS()->get('phone',10); ?></div>
				<!-- shopping cart -->
<?php if (class_exists('woocommerce')) : ?>
	<div id="top-cart">
		<div class="top-cart-icon">
			<i class="fa fa-shopping-cart"></i>
			<a class="cart-items" href="/cart" title="Посмотреть корзину">
			<div class="cart-img-all">
				<img class="cart-img" src="/wp-content/themes/1_vino/img/cart.png" alt="" />
			</div>
			
				<div class="count"><div class="cart22">Корзина</div><?php echo sprintf(_n('%d товар', '%d товаров', WC()->cart->cart_contents_count, 'store'), WC()->cart->cart_contents_count); ?></div>
				
				</div>
			</a>
		</div>
	</div>
<?php endif; ?>
<!-- shopping cart end -->
			</div>
		</div>
	</div>

	