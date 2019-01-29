<?php
global $woocommerce;
$number    = isset( $instance['number'] ) ? intval($instance['number']) : 5;
$orderby   = isset( $instance['orderby'] )     	? strip_tags($instance['orderby']) : 'ID';
$order     = isset( $instance['order'] )       	? strip_tags($instance['order']) : 'ASC';
?>
<p>
	<label for="<?php echo $this->get_field_id('number'); ?>"><?php esc_html_e('Number of Posts', 'shoppystore')?></label>
	<br />
	<input class="widefat"
		id="<?php echo $this->get_field_id('number'); ?>"name="<?php echo $this->get_field_name('number'); ?>" type="text"
		value="<?php echo esc_attr($number); ?>" />
</p>
<p>
	<label for="<?php echo $this->get_field_id('orderby'); ?>"><?php esc_html_e('Orderby', 'shoppystore')?></label>
	<br />
	<?php $allowed_keys = array('name' => 'Name', 'author' => 'Author', 'date' => 'Date', 'title' => 'Title', 'modified' => 'Modified', 'parent' => 'Parent', 'ID' => 'ID', 'rand' =>'Rand', 'comment_count' => 'Comment Count'); ?>
	<select class="widefat"
		id="<?php echo $this->get_field_id('orderby'); ?>"
		name="<?php echo $this->get_field_name('orderby'); ?>">
		<?php
		$option ='';
		foreach ($allowed_keys as $value => $key) :
			$option .= '<option value="' . $value . '" ';
			if ($value == $orderby){
				$option .= 'selected="selected"';
			}
			$option .=  '>'.$key.'</option>';
		endforeach;
		echo $option;
		?>
	</select>
</p>

<p>
	<label for="<?php echo $this->get_field_id('order'); ?>"><?php esc_html_e('Order', 'shoppystore')?></label>
	<br />
	<select class="widefat"
		id="<?php echo $this->get_field_id('order'); ?>" name="<?php echo $this->get_field_name('order'); ?>">
		<option value="DESC" <?php if ($order=='DESC'){?> selected="selected"
		<?php } ?>>
			<?php esc_html_e('Descending', 'shoppystore')?>
		</option>
		<option value="ASC" <?php if ($order=='ASC'){?> selected="selected"	<?php } ?>>
			<?php esc_html_e('Ascending', 'shoppystore')?>
		</option>
	</select>
</p>
