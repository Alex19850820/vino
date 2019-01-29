<?php if ( ! defined( 'FW' ) ) {
    die( 'Forbidden' );
}
/***
  * Верстка шорткода
  * весь контент лежит в переменной $atts
 *@var $atts array
 *
 **/

?>
<section id="cases" class="rd-cases">
	<div class="container">
		<h2><?=$atts['h2']?></h2>
		<div class="rd-cases block">
			<img src="<?php bloginfo('template_url')?>/img/case_mac2.png">
		</div>
		<div class="rd-cases block">
			<h2><?=$atts['h2_project']?>
				<a href="#" rel="nofollow"><img src="<?php bloginfo('template_url')?>/img/button_left.png"></a>
				<a href="#" rel="nofollow"><img src="<?php bloginfo('template_url')?>/img/button_right.png"></a>
			</h2>

			<hr>
			<p>
				<?=$atts['text']?>
			</p>
			<img src="<?php bloginfo('template_url')?>/img/button_cases.png"><a href="#" rel="nofollow"><span>+1100 уников</span></a>
			<img src="<?php bloginfo('template_url')?>/img/button_cases.png"><a href="#" rel="nofollow"><span>+5 позиций</span></a>
		</div>
		<div class="rd-cases block">
			<img src="<?php bloginfo('template_url')?>/img/case_graph.png">
		</div>
	</div>
</section>