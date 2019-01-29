<?php 

/*
	* Name: Metabox Category
	* Develope: Smartaddons
*/

	$ya_taxies = ya_options()->getCpanelValue( 'tax_select' );
	/* Add Custom field to category product */
	if( !empty( $ya_taxies ) ){
		foreach( $ya_taxies as $ya_tax ){
			add_action( $ya_tax . '_add_form_fields', 'ya_category_fields', 200 );
			add_action( $ya_tax . '_edit_form_fields', 'ya_edit_category_fields', 200 );
		}
		add_action( 'created_term', 'ya_save_category_fields', 10, 3 );
		add_action( 'edit_terms', 'ya_save_category_fields', 10, 3 );
	}
	
	function ya_category_fields(){
		$number  = array( 0 => esc_html__( 'Select column', 'shoppystore' ), 1, 2, 3, 4 );
		$sidebar = array( 
			'left'	=> esc_html__( 'Left Sidebar', 'shoppystore' ),
			'full' => esc_html__( 'Full Layout', 'shoppystore' ),		
			'right' => esc_html__( 'Right Sidebar', 'shoppystore' )
		);
?>
	<div class="form-field">
		<label><?php  esc_html_e( 'Sidebar Product Layout', 'shoppystore' ) ?></label>
		<select id="term_sidebar" name="term_sidebar">
			<?php 
				foreach( $sidebar as $k => $v ){
					echo '<option value="'.esc_attr( $k ).'">'.esc_html( $v ).'</option>';
				}
			?>
		</select>
	</div>

	<div class="form-field">
		<label><?php  esc_html_e( 'Select column for desktop screen', 'shoppystore' ) ?></label>
		<select id="term_col_lg" name="term_col_lg">
			<?php 
				foreach( $number as $k => $v ){
					echo '<option value="'.esc_attr( $k ).'">'.esc_html( $v ).'</option>';
				}
			?>
		</select>
	</div>
	
	<div class="form-field">
		<label><?php  esc_html_e( 'Select column for small desktop screen', 'shoppystore' ) ?></label>
		<select id="term_col_md" name="term_col_md">
			<?php 
				foreach( $number as $k => $v ){
					echo '<option value="'.esc_attr( $k ).'">'.esc_html( $v ).'</option>';
				}
			?>
		</select>
	</div>
	
	<div class="form-field">
		<label><?php  esc_html_e( 'Select column for tablet screen', 'shoppystore' ) ?></label>
		<select id="term_col_sm" name="term_col_sm">
			<?php 
				foreach( $number as $k => $v ){
					echo '<option value="'.esc_attr( $k ).'">'.esc_html( $v ).'</option>';
				}
			?>
		</select>
	</div>
<?php 
	}
	function ya_edit_category_fields( $term ){
		$number = array( 0 => esc_html__( 'Select column', 'shoppystore' ), 1, 2, 3, 4 );
		$sidebar = array( 
			'left'	=> esc_html__( 'Left Sidebar', 'shoppystore' ),
			'full' => esc_html__( 'Full Layout', 'shoppystore' ),		
			'right' => esc_html__( 'Right Sidebar', 'shoppystore' )
		);
		
		$term_col_lg  = get_term_meta( $term->term_id, 'term_col_lg', true );
		$term_col_md  = get_term_meta( $term->term_id, 'term_col_md', true );
		$term_col_sm  = get_term_meta( $term->term_id, 'term_col_sm', true );
		$term_sidebar = get_term_meta( $term->term_id, 'term_sidebar', true );
		
?>
	<tr class="form-field">
		<th scope="row" valign="top"><label><?php  esc_html_e( 'Sidebar Product Layout', 'shoppystore' ) ?></label></th>
		<td>	
			<select id="term_sidebar" name="term_sidebar">
				<?php 
					foreach( $sidebar as $k => $v ){
						echo '<option value="'.esc_attr( $k ).'" '.selected( $term_sidebar, $k, false ).'>'.esc_html( $v ).'</option>';
					}
				?>
			</select>
		</td>
	</tr>

	<tr class="form-field">
		<th scope="row" valign="top"><label><?php  esc_html_e( 'Select column for desktop screen', 'shoppystore' ) ?></label></th>
		<td>
			<select id="term_col_lg" name="term_col_lg">
				<?php 
					foreach( $number as $k => $v ){
						echo '<option value="'.esc_attr( $k ).'" '.selected( $term_col_lg, $k, false ).'>'.esc_html( $v ).'</option>';
					}
				?>
			</select>
			<div class="clear"></div>
		</td>
	</tr>
	<tr class="form-field">
		<th scope="row" valign="top"><label><?php  esc_html_e( 'Select column for medium desktop screen', 'shoppystore' ) ?></label></th>
		<td>
			<select id="term_col_md" name="term_col_md">
				<?php 
					foreach( $number as $k => $v ){
						echo '<option value="'.esc_attr( $k ).'" '.selected( $term_col_md, $k, false ).'>'.esc_html( $v ).'</option>';
					}
				?>
			</select>
			<div class="clear"></div>
		</td>
	</tr>
	<tr class="form-field">
		<th scope="row" valign="top"><label><?php  esc_html_e( 'Select column for tablet screen', 'shoppystore' ) ?></label></th>
		<td>
			<select id="term_col_sm" name="term_col_sm">
				<?php 
					foreach( $number as $k => $v ){
						echo '<option value="'.esc_attr( $k ).'" '.selected( $term_col_sm, $k, false ).'>'.esc_html( $v ).'</option>';
					}
				?>
			</select>
			<div class="clear"></div>
		</td>
	</tr>
<?php 
	}

	function ya_save_category_fields( $term_id, $tt_id = '', $taxonomy = '', $prev_value = '' ){
		$term_args = array( 'term_col_lg', 'term_col_md', 'term_col_sm', 'term_sidebar','sale_of' );
		foreach( $term_args as $value ){
			if( isset( $_POST[$value] ) ) {
				$term_value = '';
				if( preg_match_all( "/col/", $value, $output ) ){
					$term_value = intval( $_POST[$value] );
				}else{
					$term_value = esc_attr( $_POST[$value] );
				}
        update_term_meta( $term_id, $value, $term_value, $prev_value );
			}
		}
	}