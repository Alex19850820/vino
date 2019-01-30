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
				<?php foreach ($atts['slider'] as $feedback):?>
				
	<!--					<div id="gallery">-->
	<!--						--><?php //foreach ($feedback['slide'] as $slide):?>
	<!--							<div class="item-masonry sizer4">-->
	<!--								<img src="--><?//=$slide['img']['url']?><!--" alt="">-->
	<!--								<div class="cover-item-gallery">-->
	<!--									<a href="">-->
	<!--										<i class="fa fa-search fa-2x">--><?//=$slide['h2']?><!--</i>-->
	<!--									</a>-->
	<!--								</div>-->
	<!--							</div>-->
	<!--						--><?php //endforeach;?>
	<!--					</div>-->
					<div>
					<div class="grid">
						<?php foreach ($feedback['slide'] as $slide):?>
							<div class="grid-item">
								<a class="grid-item__watch" href="<?=$slide['href']?>"><?=$slide['h2']?></a>

								<a class="grid-item__fancybox" href="<?=$slide['img']['url']?>" data-fancybox="images" data-caption="
										<div class='portfolio__block-caption'>
											<span></span>
										</div">
					
										<span class="magnifier">
											<img src="<?php bloginfo('template_url')?>/assets/img/full-size.svg" width="20" height="20" alt="">
										</span>
								</a>

								<a href="">
									<img src="<?=$slide['img']['url']?>" alt="">
								</a>
							</div>
						
<!--						<div class="grid-item grid-item--width2">-->
<!--							<a href="">-->
<!--								<i class="fa fa-search fa-2x">--><?//=$slide['h2']?><!--</i>-->
<!--							</a>-->
<!--						</div>-->
						
						<?php endforeach;?>
					
						
					</div>
					</div>
					
				<?php endforeach;?>
			</div>
		</div>
	</div>
</section>