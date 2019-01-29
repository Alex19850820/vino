<?php if (!defined('FW')) {
    die('Forbidden');
}
/**
 * Кастомные поля (опции) для типов поста
 * @link Список всех возможных опицй http://manual.unyson.io/en/latest/options/built-in/introduction.html
 */
$options = [
	'main' => [
		'type' => 'box',
		'title' => __('Текст для банка', '{domain}'),
		'options' => [
			'img'=> [
				'type' => 'upload',
				'label' => __('Лого', '{domain}'),
				'desc'  => __('Выберите фото', '{domain}'),
				'help'  => __('Выберите фото', '{domain}'),
				'images_only' => true,
			],
			'name' => [
				'type' => 'text',
				'label' => __('Название банка', '{domain}'),
				'desc'  => __('Введите название банка', '{domain}'),
			],
			'background' => [
				'type'  => 'select',
				'value' => '',
				'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
				'label' => __('Фон банка', '{domain}'),
				'desc'  => __('Description', '{domain}'),
				'help'  => __('Help tip', '{domain}'),
				'choices' => [
					'' => '---',
					'sber' => __('Фон Сбербанк', '{domain}'),
					'vtb' => __('Фон ВТБ', '{domain}'),
					'rebirth' => __('Фон МКБ', '{domain}'),
					'raif' => __('Фон Райфайзен', '{domain}'),
					'born' => __('Фон Банк Возрождение', '{domain}'),
					'cap' => __('Фон Банк Капитал', '{domain}'),
					'sel' => __('Фон Банк Россельхозбанк', '{domain}'),
					'war' => __('Фон Открытие', '{domain}'),
					'bin' => __('Фон Бин Банк', '{domain}'),
				],
			],
			'mortgage' => [
				'type' => 'text',
				'label' => __('Условия ипотеки', '{domain}'),
				'value' => '',
			],
			'license' => [
				'type' => 'text',
				'label' => __('Лицензия', '{domain}'),
				'value' => '',
			],
			'rate' => [
				'type' => 'text',
				'label' => __('Процентная ставка', '{domain}'),
				'value' => '',
			],
			'term' => [
				'type' => 'text',
				'label' => __('Срок займа', '{domain}'),
				'value' => '',
			],
		],
	],
];
