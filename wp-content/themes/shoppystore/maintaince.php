<?php get_template_part('templates/head'); ?>
<?php  $maintaince_attr = ( ya_options()->getCpanelValue( 'maintaince_background' ) != '' ) ? 'style="background: url( '. esc_url( ya_options()->getCpanelValue( 'maintaince_background' ) ) .' )"' : ''; ?>
<body class="sw-shoppy">
	<div class="body-wrapper" <?php echo $maintaince_attr; ?>>
		<div class="header-maintaince">
			<div class="header-logo">
				<div class="container">
					<div class="row">
						<h1>
							<?php $main_logo = ya_options()->getCpanelValue( 'sitelogo' ); ?>
							<a  href="<?php echo esc_url( home_url( '/' ) ); ?>">
								<?php if( $main_logo != '' ){ ?>
									<img src="<?php echo esc_url( $main_logo ); ?>" alt="<?php bloginfo('name'); ?>"/>
								<?php }else{
									$logo = get_template_directory_uri().'/assets/img/maintaince/logo.png';
								?>
									<img src="<?php echo esc_url( $logo ); ?>" alt="<?php bloginfo('name'); ?>"/>
								<?php } ?>
							</a>
						</h1>
					</div>
				</div>
			</div>
		</div>
	
		<div id="main-content" class="main-content">
			<div class="container">
				<div class="page-top">
					<?php echo stripslashes( ya_options()->getCpanelValue( 'maintaince_content' ) ); ?>
				</div>
				<div class="page-bottom">
				
					<div id="countdown-container" class="countdown-container"></div>
					<?php if( ya_options()->getCpanelValue( 'maintaince_form' ) != '' ): ?> 
					<div class="form-subscribers">
						<div class="form-wrap">
							<?php echo do_shortcode( ya_options()->getCpanelValue( 'maintaince_form' ) ); ?>
						</div>
					</div>
					<?php endif; ?>
					
					<!-- Social Link -->
					<?php ya_social_link() ?>
				
				</div>
			</div>
		</div>	
		<?php $ya_copyright_text 	 = ya_options()->getCpanelValue( 'footer_copyright' );  ?>
		<div class="copyright">
			<address>
				<?php if( $ya_copyright_text == '' ) : ?>
					&copy;<?php echo date('Y') .' '. esc_html__( 'Shoppystore Themes Demo Store.All Rights Reserved.Designed by ','shoppystore' ); ?><a class="mysite" href="<?php echo esc_url( 'http://wpthemego.com/' ); ?>"><?php esc_html_e('WPThemeGo.Com','shoppystore');?></a>
				<?php else: ?>
					<?php echo wp_kses( $ya_copyright_text, array( 'a' => array( 'href' => array(), 'title' => array(), 'class' => array() ), 'p' => array()  ) ) ; ?>
				<?php endif; ?>
			</address>
		</div>
	</div>
<?php wp_footer(); ?>	
</body>
</html>