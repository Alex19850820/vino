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
<section class="rd-advantages" style="background: url(<?php bloginfo('template_url')?>/img/advantages.png) top center no-repeat;">
	<div class="container">
		<h2><?=$atts['h2']?></h2>
		<div class="row">
			<?php foreach ($atts['advantages'] as $advantage):?>
				<div class="rd-advantages block">
					<img src="<?=$advantage['img']['url']?>">
					<h2><?=$advantage['h2']?></h2>
					<p>
						<?=$advantage['text']?>
					</p>
				</div>
			<?php endforeach;?>
		</div>
	</div>
</section>