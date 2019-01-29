<?php
class Ya_Options_date extends Ya_Options{	
	
	/**
	 * Field Constructor.
	 *
	 * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
	 *
	 * @since Ya_Options 1.0
	*/
	function __construct($field = array(), $value ='', $parent){
		
		parent::__construct($parent->sections, $parent->args, $parent->extra_tabs);
		$this->field = $field;
		$this->value = $value;
		
		
	}//function
	
	
	
	/**
	 * Field Render Function.
	 *
	 * Takes the vars and outputs the HTML for the field in the settings
	 *
	 * @since Ya_Options 1.0
	*/
	function render(){
		
		$class = (isset($this->field['class']))? esc_attr( $this->field['class'] ):'';

		$placeholder = (isset($this->field['placeholder']))?' placeholder='.esc_attr($this->field['placeholder']).' ':'';
		
		echo '<input type="text" id="'.esc_attr( $this->field['id'] ).'" name="'.$this->args['opt_name'].'['.$this->field['id'].']"  '.esc_attr( $placeholder ).' value="'.esc_attr( $this->value ).'" class="'.$class.' ya-opts-datepicker" />';
		
		echo (isset($this->field['desc']) && !empty($this->field['desc']))?' <span class="description">'.esc_html( $this->field['desc'] ).'</span>':'';
		
	}//function
	
	
	
	/**
	 * Enqueue Function.
	 *
	 * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
	 *
	 * @since Ya_Options 1.0
	*/
	function enqueue(){ 
		wp_enqueue_style('ya-opts-jquery-ui-css', get_template_directory_uri() . '/lib/options/css/aristo.css', array(), null);	
		wp_enqueue_script(
			'ya-opts-field-date-js', 
			YA_OPTIONS_URL.'fields/date/field_date.js', 
			array('jquery', 'jquery-ui-core', 'jquery-ui-datepicker'),
			time(),
			true
		);
		
	}//function
	
}//class
?>