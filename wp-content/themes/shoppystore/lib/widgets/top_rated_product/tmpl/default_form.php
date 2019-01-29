<?php
$number    		= isset( $instance['numberposts'] ) ? intval($instance['numberposts']) : 5;
?>

<p>
	<label for="<?php echo $this->get_field_id('numberposts'); ?>"><?php esc_html_e('Number of Posts', 'shoppystore')?></label>
	<br />
	<input class="widefat"
		id="<?php echo $this->get_field_id('numberposts'); ?>"name="<?php echo $this->get_field_name('numberposts'); ?>" type="text"
		value="<?php echo esc_attr($number); ?>" />
</p>
