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
<section id="feedbacks" class="rd-feedback" style="background: url(<?php bloginfo('template_url')?>/img/feedback_sec.png) top center no-repeat;">
	<div class="container">
		<h2><?=$atts['h2']?></h2>
		<div class="row">
			<div class="responsive slider">
			<?php foreach ($atts['feedbacks'] as $feedback):?>
				<div>
					<div class="rd-feedback block">
						<img  class="rd-feedback round" src="<?=$feedback['img']['url']?>">
						<h2><?=$feedback['h2']?></h2>
						<p>
							<?=$feedback['text']?>
						</p>
					</div>
				</div>
			<?php endforeach;?>
			</div>
		</div>
	</div>
</section>