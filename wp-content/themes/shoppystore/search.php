<?php $ya_header_style 	= ya_options()->getCpanelValue('header_style'); ?>

<?php get_header( $ya_header_style ) ?>
<div class="container">
    <div class="listing-title">			
			<h1><span><?php ya_title(); ?></span></h1>				
	</div>
	<?php
		
		$post_type = isset( $_GET['search_posttype'] ) ? $_GET['search_posttype'] : '';
		if( isset( $post_type ) &&  locate_template( 'templates/search-' . $post_type . '.php' ) ){
			get_template_part( 'templates/search', $post_type );
		}else{
			get_template_part('templates/content');
		}
	?>
</div>
<?php get_footer(); ?>