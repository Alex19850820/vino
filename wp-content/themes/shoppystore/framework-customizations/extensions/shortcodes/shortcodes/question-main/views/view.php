<?php if ( ! defined( 'FW' ) ) {
    die( 'Forbidden' );
}
/***
  * Верстка шорткода
  * весь контент лежит в переменной $atts
 *@var $atts array
 *
 **/
//$s=0;
//$all = count($atts['questions']);
//$r = ceil($all/10);
//echo wp_registration_url();
//http://seoelement.ru/secretpage/?action=register
?>
<section class="rd-quest">
	<div class="container">
		<h2><?=$atts['h2']?></h2>
		<div class="rd-question">
				<div class="rd-quest-head">
					<?php  foreach ($atts['questions'] as $question):?>
						<span style="width: 160px; display: inline-block; text-align: center; "><?=$question['name_row']?></span>
					<?php endforeach;?>
				</div>
				<div id="questions">
					<?php $n=0; foreach ($atts['questions'] as $question):?>
						<div class="rd-left-row">
							<span><?=$question['name_row']?></span>
							<?php foreach ($question['question'] as $item): $n++;?>
								<div class="rowlink">
									<div class="filterable-cell">
										<a class="getAnswer" data-answer="<?=$item['answer']?>" rel="nofollow" data-answer="<?=$item['answer']?>">
											<?=$n?> <?=$item['question']?>
										</a>
									</div>
								</div>
							<?php  endforeach;?>
						</div>
					<?php endforeach;?>
				</div>
		</div>
		<div class="rd-answer">
			<p><label for="answer">Ответ</label><br>
				<textarea readonly id="answer" name="comment" cols="40" rows="5"></textarea>
			</p>
		</div>
	</div>
</section>