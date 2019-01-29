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
<section class="rd-service" id="service">
	<div class="container">
		<h2><?=$atts['h2']?></h2>
		<?php foreach ($atts['services'] as $service):?>
			<div class="rd-service photo">
				<img src="<?=$service['img']['url']?>" ><hr>
				<h2><?=$service['h2']?></h2>
			</div>
		<?php endforeach;?>
		<div class="rd-service photo">
			<a href="<?=$atts['href_all']?>">Все услуги</a>
		</div>
	</div>
</section>