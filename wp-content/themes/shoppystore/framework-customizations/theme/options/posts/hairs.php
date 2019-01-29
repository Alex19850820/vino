<?php if (!defined('FW')) {
    die('Forbidden');
}
/**
 * Кастомные поля (опции) для типов поста
 * @link Список всех возможных опицй http://manual.unyson.io/en/latest/options/built-in/introduction.html
 */
$options = [
    'box' => [
        'type' => 'box',
        'title' => __('Наши работы', '{domain}'),
        'options' => [
	        'works'     => array(
		        'type'  => 'addable-option',
		        'label' => __('Работы', '{domain}'),
		        'desc'  => __('выберите изображение', '{domain}'),
		        'option' => array(
			        'type'  => 'upload',
			        'label' => __('Изображение', '{domain}'),
			        'images_only' => true,
		        ),
		        'add-button-text' => __('Добавить', '{domain}'),
		        'sortable' => true,
	        )
        ],
    ],
];
