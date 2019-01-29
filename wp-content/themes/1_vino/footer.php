<div class="container-fluid footer">
		<div class="container">
			<div class="row">
				
				<div class="col-sm-3 ">
					<div class="footer_item">
						<a href="#"><img src="<?= bloginfo('template_directory'); ?>/img/logo.png" alt="" class="logo"></a>
					</div>
				</div>

				<div class="col-sm-3 ">
					<div class="footer_item">
						<?php
							wp_nav_menu(array(
							  'menu' => 'footer_menu', // название меню
							  'theme_location'  => 'footer_menu',
							  'container' => '', // контейнер для меню, по умолчанию 'div', в нашем случае ставим 'nav', пустая строка - нет контейнера
							  'container_class' => '', // класс для контейнера
							  'container_id' => '', // id для контейнера
							  'menu_class' => '', // класс для меню
							  'menu_id' => '', // id для меню
							));
						?>
					</div>
				</div>

				
				</div>

				<div class="col-sm-3 text-right">
					<div class="footer_item">
						<a href="#"><img src="<?= bloginfo('template_directory'); ?>/img/mail3.png" alt="" class="min_image"> <div class="min_text"><?php echo CFS()->get('email',10); ?></div> </a>
						<br>
						<a href="#"><img src="<?= bloginfo('template_directory'); ?>/img/phone2.png" alt="" class="min_image"> <div class="min_text"> <?php echo CFS()->get('phone',10); ?></div> </a>
					</div>
				</div>

			</div>
		</div>
	</div>


	<script type="text/javascript">
		$(document).ready(function(){
			$('#menu-head li').hover(
		        function (){
		           $("ul:first", this).slideDown(100);
		        },
		        function (){
		           $('ul:first', this).slideUp(100);
		        }
		     );
		});
	</script>


	<div class="hidden"></div>
	<!-- Mandatory for Responsive Bootstrap Toolkit to operate -->
	<div class="device-xs visible-xs"></div>
	<div class="device-sm visible-sm"></div>
	<div class="device-md visible-md"></div>
	<div class="device-lg visible-lg"></div>
	<!-- end mandatory -->
	<!--[if lt IE 9]>
	<script src="libs/html5shiv/es5-shim.min.js"></script>
	<script src="libs/html5shiv/html5shiv.min.js"></script>
	<script src="libs/html5shiv/html5shiv-printshiv.min.js"></script>
	<script src="libs/respond/respond.min.js"></script>
	<![endif]-->
	<!--
	<script src="libs/jquery/jquery-1.11.1.min.js"></script>
	<script src="libs/jquery-mousewheel/jquery.mousewheel.min.js"></script>
	<script src="libs/fancybox/jquery.fancybox.pack.js"></script>
	<script src="libs/waypoints/waypoints-1.6.2.min.js"></script>
	<script src="libs/scrollto/jquery.scrollTo.min.js"></script>
	<script src="libs/owl-carousel/owl.carousel.min.js"></script>
	<script src="libs/countdown/jquery.plugin.js"></script>
	<script src="libs/countdown/jquery.countdown.min.js"></script>
	<script src="libs/countdown/jquery.countdown-ru.js"></script>
	<script src="libs/landing-nav/navigation.js"></script>
	<script src="libs/bootstrap-toolkit/bootstrap-toolkit.min.js"></script>
	<script src="libs/maskedinput/jquery.maskedinput.min.js"></script>
	<script src="libs/equalheight/jquery.equalheight.js"></script>
	<script src="libs/stellar/jquery.stellar.min.js"></script>
	<script src="<?= bloginfo('template_directory'); ?>/js/common.js"></script>
-->

<!-- /Yandex.Metrika counter --><!-- /Yandex.Metrika counter -->
<!-- Google Analytics counter --><!-- /Google Analytics counter -->




<?php wp_footer(); ?>
<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter48924590 = new Ya.Metrika({
                    id:48924590,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/48924590" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

<!-- Google Analytics counter --><!-- /Google Analytics counter -->
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-121613041-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-121613041-1');
</script>

</body>
</html>