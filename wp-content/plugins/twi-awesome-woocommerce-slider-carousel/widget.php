<?php
class TWI_WOO_Grid_Slider_Carousel_Widget extends WP_Widget{
	 function __construct(){
		  parent::__construct(
		      'twi_woo_widget',
		      __('Woo Grid/Slider/Carousel','twi_awesome_woo_slider_carousel'),
		      array(
		         'classname' => 'twi-woo-grid-car-slider-widget',
		         'description' => __('This is widget for TWI Woocommerce Grid/Slider/Carousel.','twi_awesome_woo_slider_carousel')
		      )
		  );
	 }

	 function form($instance){
	     $instance = wp_parse_args((array)$instance, array(
			'title' => '',
			'twi_hide_title' => '',
			'sh_id' => ''
		 ));
		 $title = strip_tags($instance['title']);
		 $twi_hide_title = $instance['twi_hide_title']; 
		 $sh_id = $instance['sh_id'];
		 
		 include(TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/widget/form.php');	 
	 }

	 function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = strip_tags( stripcslashes($new_instance['title']) );
		$instance['twi_hide_title'] = $new_instance['twi_hide_title'];
		$instance['sh_id'] = $new_instance['sh_id'];
		
		return $instance;
	 }
	 
	 function widget($args,$instance){
		 include(TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/widget/view.php');
	 }

}
add_action('widgets_init',create_function('','register_widget("TWI_WOO_Grid_Slider_Carousel_Widget");') );
?>