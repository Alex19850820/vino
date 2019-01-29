<?php
global $product;
    // if ($product->is_on_sale() && $twi_woo_style == 'twi_woo_grid'):
    //     echo '<a class="twi-ui top left ribbon label teal twi-sale">'.__('Sale!','twi_awesome_woo_slider_carousel').'</a>';
    // endif;
    if ($product->is_on_sale()):
        echo '<a class="twi-ui top left attached label teal twi-sale">'.__('Sale!','twi_awesome_woo_slider_carousel').'</a>';
    endif;
    if (!$product->is_in_stock()) {
        echo '<a class="twi-ui top right attached label red twi-out">'.__('Out of stock','twi_awesome_woo_slider_carousel').'</a>';
    }
    if( $product->is_featured() ) {
        echo '<a class="twi-ui bottom '.$fe_pos.' attached label teal twi-fea">'.__('Featured','twi_awesome_woo_slider_carousel').'</a>';
    }
?>