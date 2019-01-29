<?php
add_action('after_setup_theme', 'twi_awesome_woo_slider_carousel');

function twi_awesome_woo_slider_carousel()
{
	load_theme_textdomain('twi_awesome_woo_slider_carousel', plugins_url() . '/lang/');
}