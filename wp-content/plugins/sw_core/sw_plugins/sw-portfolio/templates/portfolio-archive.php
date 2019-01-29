<?php $ya_header_style 	= ya_options()->getCpanelValue('header_style'); ?>
<?php get_header( $ya_header_style ) ?>
<?php 
	$p_imgintro = ya_options()->getCpanelValue( 'portfolio_imgintro' );
?>
<div class="container">
	<div class="portfolio-intro">
		
	<?php
	if( $p_imgintro != '' ){
		echo '<img src="' . $p_imgintro . '"/>';
	}
	echo '<h2 class="p-title">'. __( 'Portfolio', 'sw_core' ) .'</h2>';
	if ( function_exists( 'ya_breadcrumb' ) ){
		ya_breadcrumb( '<div class="breadcrumbs theme-clearfix">', '</div>' );
	} 

	?>
	</div>
</div>

	<div class="container">
		<?php			
			$portfolio 		= array();
			$attributes 	= '';
			$number 		= 8;
			$orderby 		= 'date'; 
			$order			= '';
			$portfolio_id 	= ya_options()->getCpanelValue( 'portfolio_id' );
			$style			= ya_options()->getCpanelValue( 'p_style' );
			$col1	 		= ya_options()->getCpanelValue( 'p_col_large' );
			$col2		 	= ya_options()->getCpanelValue( 'p_col_medium' );
			$col3			= ya_options()->getCpanelValue( 'p_col_sm' );
			$col4			= ya_options()->getCpanelValue( 'p_col_xs' );			
			$pf_id			= 'ya_portfolio';
			if( count( $portfolio_id  ) > 0 ){
				$portfolio = $portfolio_id;
			}else{
				$terms = get_terms( 'portfolio_cat' );
				foreach( $terms as $k => $term ){
					$portfolio[$k] = $term -> term_id;
				}
			}
			include( plugin_dir_path( __FILE__ ) . 'portfolio-item.php' );
		?>
	</div>
<?php get_footer() ?>