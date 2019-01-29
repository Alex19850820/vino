<?php do_action( 'before' ); ?>
<?php if ( class_exists( 'WooCommerce' ) ) { ?>
<?php global $woocommerce; ?>
<div class="top-login pull-left">
	<?php if ( ! is_user_logged_in() ) {  ?>
	<ul>
		<li>
		    	<?php echo ' <a href="javascript:void(0);" data-toggle="modal" data-target="#login_form"><span>'.esc_html__('Login', 'shoppystore').'</span></a> '; ?>

		</li>
	</ul>
	<?php } else{?>
		<div class="div-logined">
			<?php 
				$user_id = get_current_user_id();
				$user_info = get_userdata( $user_id );	
			?>
			<a href="<?php echo wp_logout_url( home_url('/') ); ?>" title="Logout"><?php esc_html_e('Logout', 'shoppystore'); ?></a>
		</div>
	<?php } ?>
</div>
<?php } ?>
