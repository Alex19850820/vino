<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $ya_detect;
	$mobile_check   = ya_options()->getCpanelValue( 'mobile_enable' );
	if( !empty( $ya_detect ) && ( $ya_detect->isMobile() ) && $mobile_check &&  is_single() ) : ?>
	<p class="avatar-user">
		<?php
			 echo get_avatar( $current_user->ID, 155 );
		?>
	</p>
<?php endif; ?>
<p>
	<?php
		echo sprintf( esc_attr__( 'Здравствуйте %s%s%s (это не %2$s? %sСменить аккаунт%s)', 'shoppystore' ), '<strong>', esc_html( $current_user->display_name ), '</strong>', '<a href="' . esc_url( wc_logout_url( wc_get_page_permalink( 'myaccount' ) ) ) . '">', '</a>' );
	?>
</p>

<p>
	<?php
		echo sprintf( esc_attr__( 'На панели управления вашей учетной записью вы можете просмотреть свои %1$sпоследние заказы%2$s, управлять своими %3$sпочтовыми и платежными адресами%2$s и %4$sредактировать свои пароли и данные учетной записи%2$s.', 'shoppystore' ), '<a href="' . esc_url( wc_get_endpoint_url( 'orders' ) ) . '">', '</a>', '<a href="' . esc_url( wc_get_endpoint_url( 'edit-address' ) ) . '">', '<a href="' . esc_url( wc_get_endpoint_url( 'edit-account' ) ) . '">' );
	?>
</p>

<?php
	/**
	 * My Account dashboard.
	 *
	 * @since 2.6.0
	 */
	do_action( 'woocommerce_account_dashboard' );

	/**
	 * Deprecated woocommerce_before_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_before_my_account' );

	/**
	 * Deprecated woocommerce_after_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_after_my_account' );
?>
