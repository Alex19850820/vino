<?php 
/*
	* Name: Dokan Vendor Hook
	* Develop: SmartAddons
*/

add_action( 'wp', 'ya_dokan_hook' );
function ya_dokan_hook(){
	 if ( dokan_is_store_page () ) {
		remove_action( 'woocommerce_before_main_content', 'ya_banner_listing', 10 );
	}
}
