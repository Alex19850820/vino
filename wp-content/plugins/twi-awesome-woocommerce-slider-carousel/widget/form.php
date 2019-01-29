<p>
<label><?php _e('Title:','twi_awesome_woo_slider_carousel'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
</p>

<p>
<label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'twi_hide_title' ); ?>" name="<?php echo $this->get_field_name( 'twi_hide_title' ); ?>" type="checkbox" value="1" <?php checked( 1, $twi_hide_title, true); ?> />
		<?php _e('Hide title','twi_awesome_woo_slider_carousel'); ?>
</label>
</p>

<p>
<label><?php _e('Select Your Shortcode:','twi_awesome_woo_slider_carousel'); ?></label>
       <br />
<select id="<?php
		echo $this->get_field_id( 'sh_id' ); ?>" name="<?php
		echo $this->get_field_name( 'sh_id' ); ?>">
       <?php
		$wp_posts = get_posts(array(
			'post_type' => 'twi_woo_g_car',
			'posts_per_page' => -1,
		));
	foreach($wp_posts as $post) {
	  echo "<option value='" . $post->ID . "'" . selected($sh_id,$post->ID) . ">" . $post->post_title. "</option>";
	}

?>
</select>
</p>