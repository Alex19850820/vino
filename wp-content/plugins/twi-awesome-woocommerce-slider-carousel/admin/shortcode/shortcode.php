<?php
return array(
__('TWI Advanced Grid/Slider/Carousel','twi_awesome_woo_slider_carousel') => array(
'elements' => array(
'twi_woo_shortcode' => array(
'title'   => __('TWI Advanced Grid/Slider/Carousel Shortcode', 'twi_awesome_woo_slider_carousel'),
'code'    => '[twi_woo_shortcode][/twi_woo_shortcode]',
'attributes' => array(
					array(
						'name'  => 'p_id',
						'type'  => 'select',
						'validation' => 'required',
						'label' => __('Setect your shortcode', 'twi_awesome_woo_slider_carousel'),
						'items' => array(
							          'data' => array(
											array(
												'source' => 'function',
												'value' => 'twi_get_woo_short',
											),
									),
								),
						'default' => '{{first}}',
						),
				),
			),
		),
	),

);