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
<section class="rd-case-graph" style="">
	<div class="container">
		<h2><?=$atts['h2']?></h2>
		<p>
			Задача проекта: увеличить охват аудитории, повысить узнаваемость бренда
		</p>
		<div class="rd-graph">
			<h2 id="allGraph">График продвижения</h2>
			<div id="resGraph">
				<canvas id="myChart" width="600" height="400"></canvas>
			</div>
		</div>
		<div class="rd-case-info">
			<h2>Статистика продвижения</h2>
			<span>Сайт: <a>http://automotors.com</a></span>
			<table class="table">
<!--				<thead>-->
<!--				<tr>-->
<!--					<th scope="col">Название запроса</th>-->
<!--					<th scope="col">Значение</th>-->
<!--				</tr>-->
<!--				</thead>-->
				<tbody>
				<?php foreach ($atts['requests'] as $request):?>
					<tr>
						<th scope="row">
							<a rel="nofollow"  data-color="<?=$request['color']?>" class="mGraph" data-type="<?=$request['type']?>" data-val="<?=$request['val_all']?>"><?=$request['h2']?></a>
						</th>
						<td><?=$request['values']?></td>
					</tr>
				<?php endforeach;?>
				</tbody>
			</table>
		</div>
	</div>
</section>