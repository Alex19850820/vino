<?php 
	$ya_copyright_text = ya_options()->getCpanelValue('footer_copyright');
	$ya_footer_payment = ya_options()->getCpanelValue('footer_payment');
	$ya_page_footer   	 =  ( get_post_meta( get_the_ID(), 'page_footer_style', true ) != '' ) ? get_post_meta( get_the_ID(), 'page_footer_style', true ) : ya_options()->getCpanelValue( 'footer_style' );
	$ya_footer_style = ya_options()->getCpanelValue( 'footer_style' );
	$ya_footer_widget = ya_options()->getCpanelValue('footer_widget');
?>
	<!-- BEGIN: footer -->
	<div id="yt_footer" class="yt-footer wrap">		   
			<?php 
			if( !$ya_footer_widget && $ya_page_footer != '' ) { 
			$ya_footer_page = get_post( $ya_page_footer );
				if( $ya_footer_page ) {
				$ya_footer_style = $ya_footer_page->post_name;
				$ya_footer_style = explode('-', $ya_footer_style); ?>
				<div class="yt-footer-wrap-<?php echo $ya_footer_style['1']?>">
					<div class="container">
							 <?php echo get_the_content_by_id( $ya_page_footer ); ?>
					</div>
					<div class="footer-bottom">
						<div class="footer-bottom-content container clearfix">
							<div class="copyright-footer pull-left">
							<?php if( $ya_copyright_text == '' ) : ?>
								&copy; <?php echo date('Y'); ?> <?php echo wp_kses(__('<a href=Интернет Магазин МИР ВИНОКУРА>ИП Тулуевский П.М.</a> ОГРНИП 317774600569901','ИНН 774317214450'),'a') ?>
							<?php else : ?>
								<?php echo wp_kses( $ya_copyright_text, array( 'a' => array( 'href' => array(), 'title' => array(), 'class' => array() ), 'p' => array()  ) ) ; ?>
							<?php endif; ?>
							</div>				
							<div class="payment">
								<?php if( $ya_footer_payment == '' ) : ?>
								<ul class="payment-method pull-right">
									<li><a class="payment1" title="Payment Method" href="#"></a></li>
									<li><a class="payment2" title="Payment Method" href="#"></a></li>
									<li><a class="payment3" title="Payment Method" href="#"></a></li>
									<li><a class="payment4" title="Payment Method" href="#"></a></li>
								</ul>
								<?php else : ?>
									<?php echo stripslashes( $ya_footer_payment ); ?>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>
				<?php } else { ;?>	
			<div class="yt-footer-wrap-<?php echo $ya_footer_style ?>">
			<?php if (is_active_sidebar_YA('above-footer') && $ya_footer_style != 'style5'){ ?>
			<div class="footer-top">
				<div class="container">
					<div class="row">					
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">				
							<?php dynamic_sidebar('above-footer'); ?>			
						</div>
					</div>
				</div>
			</div>
			<?php } ?>
			<?php if (is_active_sidebar_YA('above-footer-1') && $ya_footer_style == 'style5' ){ ?>
			<div class="footer-top-1">
				<div class="container">
					<div class="row">								
						<?php dynamic_sidebar('above-footer-1'); ?>			
					</div>
				</div>
			</div>
			<?php } ?>
			<?php if($ya_footer_style == 'style5') { ?>
			<!-- FOOTER SEVICER -->
			<?php if ( is_active_sidebar_YA('footer1') ){ ?>
			<div class="footer-bottom-sevicer">
				<div class="container">														
					<?php dynamic_sidebar('footer1'); ?>									
				</div>
			</div>
			<?php } } ?>	
			<?php if($ya_footer_style == 'style9') { ?>
			<!-- FOOTER SEVICER -->
			
			<?php if ( is_active_sidebar_YA('footer2') ){ ?>
				
			<div class="footer-middle">
				<div class="container">														
					<?php dynamic_sidebar('footer2'); ?>									
				</div>
			</div>
			<?php } } ?>
			<?php if($ya_footer_style != 'style9') { ?>	
			<?php if ( is_active_sidebar_YA('footer') ){ ?>
			<div class="footer-middle">
				<div class="container">													
					<?php dynamic_sidebar('footer'); ?>					
				</div>
			</div>
			<?php } }?>
			<?php if($ya_footer_style != 'style5') { ?>
		<!-- FOOTER SEVICER -->
			<?php if ( is_active_sidebar_YA('footer1') ){ ?>
			<div class="footer-bottom-sevicer">
				<div class="container">														
					<?php dynamic_sidebar('footer1'); ?>									
				</div>
			</div>
			<?php } } ?>	
		<!-- FOOTER TAGS -->	
			<?php if (is_active_sidebar_YA('floating')){ ?>
			<div class="footer-bottom-tag">
				<div class="container">
					<div class="block-tags">
						<div class="block-title">
							<strong><span><?php esc_html_e( 'Hot Tags', 'shoppystore' ) ?></span></strong>
						</div>
						<div class="block-content">																		
								<?php dynamic_sidebar('floating'); ?>
														
						</div>
					</div>
				</div>
			</div>
			<?php }  ?>
		</div>
		<!-- FOOTER BOTTOM -->
		<div class="footer-bottom">
			<div class="footer-bottom-content container clearfix">
				<div class="copyright-footer pull-left">
				<?php if( $ya_copyright_text == '' ) : ?>
					&copy; <?php echo date('Y'); ?> <?php echo wp_kses(__('<a href=Интернет Магазин МИР ВИНОКУРА>ИП Тулуевский П.М.</a> ОГРНИП 317774600569901','ИНН 774317214450'),'a') ?>
				<?php else : ?>
					<?php echo wp_kses( $ya_copyright_text, array( 'a' => array( 'href' => array(), 'title' => array(), 'class' => array() ), 'p' => array()  ) ) ; ?>
				<?php endif; ?>
				</div>				
				<div class="payment">
					<?php if( $ya_footer_payment == '' ) : ?>
					<ul class="payment-method pull-right">
						<li><a class="payment1" title="Payment Method" href="#"></a></li>
						<li><a class="payment2" title="Payment Method" href="#"></a></li>
						<li><a class="payment3" title="Payment Method" href="#"></a></li>
						<li><a class="payment4" title="Payment Method" href="#"></a></li>
					</ul>
					<?php else : ?>
						<?php echo stripslashes( $ya_footer_payment ); ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php } ?>
		</div>
		<!--end: FOOTER TAGS -->	    
		
	</div>
	<!-- end : footer wrap-->
