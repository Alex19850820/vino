<?php if (!defined('FW')) {
    die('Forbidden');
}
/**
 * Опции (поля) шорткода
 * @link Список всех возможных опицй http://manual.unyson.io/en/latest/options/built-in/introduction.html
 */
$options = [
//    //ключ - slug опции, к которому будем обращаться во view
    //значение - массив конфигураций для опции
	'h2'     => [
		'type'  => 'text',
		'value' => 'Кейсы',
		'label' => __('Заголовок', '{domain}'),
	],
	'requests' => [
		'type' => 'addable-popup',
		'label' => __('Добавить запрос ', '{domain}'),
		'template' => '{{- h2 }}',
		'size' => 'large', // small, medium, large
		'limit' => 0, // limit the number of popup`s that can be added
		'add-button-text' => __('добавить', '{domain}'),
		'sortable' => true,
		'popup-options' => [
			'h2'     => [
				'type'  => 'text',
				'value' => '',
				'label' => __('Название запроса', '{domain}'),
			],
			'values'     => [
				'type'  => 'text',
				'value' => '',
				'label' => __('Значение', '{domain}'),
			],
			'val_all'     => [
				'type'  => 'text',
				'value' => '',
				'label' => __('Все значение за период', '{domain}'),
			],
			'type' => ['type'  => 'select',
			'value' => 'line',
			'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
			'label' => __('Тип графика', '{domain}'),
			'desc'  => __('Description', '{domain}'),
			'help'  => __('Help tip', '{domain}'),
			'choices' => array(
				'' => '---',
				'line' => __('Линейный', '{domain}'),
				'bar' => __('Столбики', '{domain}'),
			),
			],
			'color' => array(
				'type'  => 'color-picker',
				'value' => '#FF0000',
				'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
				// palette colors array
				'palettes' => array( 'rgb(0,128,0)', 'rgb(255, 99, 132)', '#2489eb' ),
				'label' => __('Цвет графика', '{domain}'),
				'desc'  => __('Description', '{domain}'),
				'help'  => __('Help tip', '{domain}'),
			),
		]
	],
	/*'title'     => [
		'type'  => 'text',
		'value' => 'наши результаты',
		'label' => __('Заголовок', '{domain}'),
	],
	'img'     => [
		'type'  => 'upload',
		'value' => '',
		'label' => __('Добавить картинку', '{domain}'),
		'images_only' => true,
	],
	'title2'     => [
		'type'  => 'text',
		'value' => 'Наша миссия - Ваша красота',
		'label' => __('Заголовок поста', '{domain}'),
	],*/
//	'house' => [
//		'type' => 'addable-popup',
//		'label' => __('Добавить информацию', '{domain}'),
//		'template' => '{{- h2 }}',
//		'size' => 'large', // small, medium, large
//		'limit' => 0, // limit the number of popup`s that can be added
//		'add-button-text' => __('добавить', '{domain}'),
//		'sortable' => true,
//		'popup-options' => [
////			'img'     => [
////				'type'  => 'upload',
////				'value' => '',
////				'label' => __('Добавить картинку здания', '{domain}'),
////				'images_only' => true,
////			],
////			'h2'     => [
////				'type'  => 'text',
////				'value' => '',
////				'label' => __('Заголовок', '{domain}'),
////			],
//			'price'     => [
//				'type'  => 'text',
//				'value' => 'от <span>2</span> млн. руб.',
//				'label' => __('Цена', '{domain}'),
//			],
//			'area'     => [
//				'type'  => 'text',
//				'value' => 'от 184 500 р./м<sup>2</sup>',
//				'label' => __('Цена за кв метр', '{domain}'),
//			],
//			'city'     => [
//				'type'  => 'text',
//				'value' => '',
//				'label' => __('Город', '{domain}'),
//			],
//			'md'     => [
//				'type'  => 'text',
//				'value' => '',
//				'label' => __('Микрорайон', '{domain}'),
//			],
//			'info'     => [
//				'type'  => 'text',
//				'value' => '',
//				'label' => __('Текст ссылки', '{domain}'),
//				'desc'  => __('Подробнее или еще или узнать больше...', '{domain}'),
//				'help'  => __('Введите текст', '{domain}'),
//			],
//			'href'     => [
//				'type'  => 'text',
//				'value' => '',
//				'label' => __('Ссылка', '{domain}'),
//				'desc'  => __('Введите адрес на который будет ссылаться страница', '{domain}'),
//				'help'  => __('Введите страницу', '{domain}'),
//			],
//		],
//	],
//
];