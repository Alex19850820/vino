<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
/*
 * Настройки сайта (телефоны, соц-сети и пр.)
 * Список всех возможных опицй http://manual.unyson.io/en/latest/options/built-in/introduction.html
 */
$options = [
	'logo_header' => [
		'title'   => __( 'Логотип', '{domain}' ),
		'options' => [
			'img_logo' => [
				'type'  => 'upload',
				'label' => __( 'Логотип', '{domain}' ),
				'value' => '',
				'images_only' => true,
			]
		],
	],
	'panel_contacts' => [
		'title'   => __( 'Контакты', '{domain}' ),
		'options' => [
			'phone' => [
				'type'  => 'text',
				'label' => __( 'Телефон', '{domain}' ),
				'value' => '+ 1234 586 789 ',
			],
			'email' => [
				'type'  => 'text',
				'label' => __( 'E-mail', '{domain}' ),
				'value' => 'example@gmail.ru',
			],
			'menu_main' => [
				'type' => 'addable-popup',
				'label' => __('Редактировать меню', '{domain}'),
				'template' => '{{- m1 }}',
				'size' => 'large', // small, medium, large
				'limit' => 0, // limit the number of popup`s that can be added
				'add-button-text' => __('добавить', '{domain}'),
				'sortable' => true,
				'popup-options' => [
					'm1' => [
						'type'  => 'text',
						'label' => __( 'Главная страница', '{domain}' ),
						'value' => 'Главная',
					],
					'm2' => [
						'type'  => 'text',
						'label' => __( 'О нас', '{domain}' ),
						'value' => 'О нас',
					],
					'm3' => [
						'type'  => 'text',
						'label' => __( 'Наши проекты', '{domain}' ),
						'value' => 'Наши проекты',
					],
					'm4' => [
						'type'  => 'text',
						'label' => __( 'Контакты', '{domain}' ),
						'value' => 'Контакты',
					],
				],
			],
			'vk' => [
				'type'  => 'text',
				'label' => __( 'VK', '{domain}' ),
				'value' => '',
			],
			'facebook' => [
				'type'  => 'text',
				'label' => __( 'Facebook', '{domain}' ),
				'value' => '',
			],
			'telegram' => [
				'type'  => 'text',
				'label' => __( 'Telegram', '{domain}' ),
				'value' => '',
			],
			'twitter' => [
				'type'  => 'text',
				'label' => __( 'Twitter', '{domain}' ),
				'value' => '',
			],
			'instagram' => [
				'type'  => 'text',
				'label' => __( 'Instagram', '{domain}' ),
				'value' => '',
			],
			'google' => [
				'type'  => 'text',
				'label' => __( 'Google', '{domain}' ),
				'value' => '',
			],
		],
	],
	'panel_services' => [
		'title'   => __( 'Меню услуги', '{domain}' ),
		'options' => [
			'menu_services' => [
				'type' => 'addable-popup',
				'label' => __('Редактировать меню', '{domain}'),
				'template' => '{{- h2 }}',
				'size' => 'large', // small, medium, large
				'limit' => 0, // limit the number of popup`s that can be added
				'add-button-text' => __('добавить', '{domain}'),
				'sortable' => true,
				'popup-options' => [
					'h2' => [
						'type'  => 'text',
						'label' => __( 'Название меню', '{domain}' ),
						'value' => '',
					],
					'href' => [
						'type'  => 'text',
						'label' => __( 'Ссылка', '{domain}' ),
						'value' => '',
					],
				],
			],
		],
	],
	'footer' => [
		'title'   => __( 'Футер', '{domain}' ),
		'options' => [
			'more' => [
				'type'  => 'text',
				'label' => __( 'Текст', '{domain}' ),
				'value' => '',
			],
			'order' => [
				'type'  => 'text',
				'label' => __( 'Текст', '{domain}' ),
				'value' => '',
			],
			'horder' => [
				'type'  => 'text',
				'label' => __( 'Ссылка', '{domain}' ),
				'value' => '#',
			],
			'new_build' => [
				'type' => 'addable-popup',
				'label' => __('Добавить информацию', '{domain}'),
				'template' => '{{- text }}',
				'size' => 'large', // small, medium, large
				'limit' => 0, // limit the number of popup`s that can be added
				'add-button-text' => __('добавить', '{domain}'),
				'sortable' => true,
				'popup-options' => [
					'text' => [
						'type'  => 'text',
						'label' => __( 'Заголовок блока', '{domain}' ),
						'value' => '',
					],
					'new_build' => [
						'type' => 'addable-popup',
						'label' => __('Добавить информацию блока', '{domain}'),
						'template' => '{{- text }}',
						'size' => 'large', // small, medium, large
						'limit' => 0, // limit the number of popup`s that can be added
						'add-button-text' => __('добавить', '{domain}'),
						'sortable' => true,
						'popup-options' => [
							'text' => [
								'type'  => 'text',
								'label' => __( 'Текст', '{domain}' ),
								'value' => '',
							],
							'href' => [
									'type'  => 'text',
									'label' => __( 'Ссылка', '{domain}' ),
									'value' => '#',
							],
						],
					],
				],
			],
		],
	],
];


