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
		'value' => '',
		'label' => __('Заголовок', '{domain}'),
	],
	'slider' => [
		'type' => 'addable-popup',
		'label' => __('Добавить слайдер', '{domain}'),
		'template' => '{{- h2 }}',
		'size' => 'large', // small, medium, large
		'limit' => 0, // limit the number of popup`s that can be added
		'add-button-text' => __('добавить', '{domain}'),
		'sortable' => true,
		'popup-options' => [
			'h2'     => [
				'type'  => 'text',
				'   value' => 'Текст',
				'   label' => __('Название экрана слайда(номер)', '{domain}'),
			],
			'slide' => [
				'type' => 'addable-popup',
				'label' => __('Добавить слайд', '{domain}'),
				'template' => '{{- h2 }}',
				'size' => 'large', // small, medium, large
				'limit' => 0, // limit the number of popup`s that can be added
				'add-button-text' => __('добавить', '{domain}'),
				'sortable' => true,
				'popup-options' => [
					'img'     => [
						'type'  => 'upload',
						'value' => '',
						'label' => __('Добавить картинку', '{domain}'),
						'images_only' => true,
					],
					'h2'     => [
						'type'  => 'text',
						'value' => 'Текст',
						'label' => __('Текст для слайда', '{domain}'),
					],
					'href'     => [
						'type'  => 'text',
						'value' => '',
						'label' => __('Сылка', '{domain}'),
					],
				],
			],
		]
	]
];