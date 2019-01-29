<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
function _filter_theme_disable_default_shortcodes( $to_disable ) {
	$to_disable[] = 'accordion';
	$to_disable[] = 'button';
	$to_disable[] = 'calendar';
	$to_disable[] = 'call_to_action';
	$to_disable[] = 'contact_form';
	$to_disable[] = 'column';
	$to_disable[] = 'divider';
	$to_disable[] = 'icon';
	$to_disable[] = 'icon_box';
	$to_disable[] = 'map';
	$to_disable[] = 'media_image';
	$to_disable[] = 'media_video';
	$to_disable[] = 'notification';
	$to_disable[] = 'row';
	$to_disable[] = 'section';
	$to_disable[] = 'special_heading';
	$to_disable[] = 'table';
	$to_disable[] = 'tabs';
	$to_disable[] = 'team_member';
	$to_disable[] = 'testimonials';
	$to_disable[] = 'text_block';
	$to_disable[] = 'widget_area';
	$to_disable[] = 'size_block2';
	$to_disable[] = 'size_block3';
	return $to_disable;
}
add_filter( 'fw_ext_shortcodes_disable_shortcodes', '_filter_theme_disable_default_shortcodes' );