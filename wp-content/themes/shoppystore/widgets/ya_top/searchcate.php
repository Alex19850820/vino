<form method="get" id="searchform_special" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
	<div class="form-search">
		<?php
		$ya_taxonomy = class_exists( 'WooCommerce' ) ? 'product_cat' : 'category';
		$ya_posttype = class_exists( 'WooCommerce' ) ? 'product' : 'post';
		$args = array(
			'type' => 'post',
			'parent' => 0,
			'orderby' => 'id',
			'order' => 'ASC',
			'hide_empty' => false,
			'hierarchical' => 1,
			'exclude' => '',
			'include' => '',
			'number' => '',
			'taxonomy' => $ya_taxonomy,
			'pad_counts' => false
		);
		$product_categories = get_categories($args);
		if( count( $product_categories ) > 0 ){
		?>
		<div class="cat-wrapper">
			<div class="selector" id="uniform-cat">
			<label class="label-search">
				<select name="search_category" class="s1_option">
					<option value=""><?php esc_html_e( 'All Categories', 'shoppystore' ) ?></option>
					<?php foreach( $product_categories as $cat ) {
						$selected = ( isset($_GET['search_category'] ) && ($_GET['search_category'] == $cat->term_id )) ? 'selected=selected' : '';
					echo '<option value="'. esc_attr( $cat-> term_id ) .'" '.$selected.'>' . esc_html( $cat->name ). '</option>';
					}
					?>
				</select>
			</label>
			</div>
		</div>
		<?php } ?>
		<div class="input-search">
		<?php do_action( 'wpml_add_language_form_field' ) ?>
		<input type="text" value="<?php echo get_search_query(); ?>" name="s" id="s" placeholder="<?php esc_html_e( 'Search for products', 'shoppystore' ); ?>" />
		</div>
		<button type="submit" title="Search" class="fa fa-search button-search-pro form-button"></button>
		<input type="hidden" name="search_posttype" value="<?php echo esc_attr( $ya_posttype ) ?>" />
	</div>
</form>