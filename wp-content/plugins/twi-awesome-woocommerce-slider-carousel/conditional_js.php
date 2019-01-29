<?php 
/**
	* This script only for Upsell, Cross Sell and Relative prodouct Carousel.
*/


function twi_conditional_js(){ 
if(vp_option("twi_woo_options.twi_woo_upsell_off_on") == 1) :
?>
<script type="text/javascript">
			/* <![CDATA[ */
				jQuery(document).ready(function(){
				
				 jQuery( ".products li" ).parent().addClass('twi_woo_others_carousel');
				 <?php if(vp_option("twi_woo_options.twi_upsell_fw") == 'true'): ?>
				 jQuery( "ul.products" ).addClass('twi-forced-fullwidth');
				 <?php endif; ?>
                 jQuery('.upsells .twi_woo_others_carousel').TWIowlCarousel({
                    loop:true,
                    autoplayTimeout:<?php echo vp_option("twi_woo_options.upsell_au_time")*1000; ?>,
				    autoplay:<?php echo vp_option("twi_woo_options.twi_upsell_woo_autoplay"); ?>,
				    margin:<?php echo vp_option("twi_woo_options.upsell_pro_gap"); ?>,
				    responsiveClass:true,
				    nav:<?php echo vp_option("twi_woo_options.twi_upsell_woo_nav"); ?>,
                    navText:['<i class="twi-icon-chevron-left"></i>','<i class="twi-icon-chevron-right"></i>'],
                    dots:<?php echo vp_option("twi_woo_options.twi_upsell_woo_page"); ?>,
				    responsive:{
				        0:{
				            items:<?php echo vp_option("twi_woo_options.mobile_pro"); ?>
				        },
				        479:{
				            items:<?php echo vp_option("twi_woo_options.mobile_pro"); ?>
				        },
				        768:{
				            items:<?php echo vp_option("twi_woo_options.tablet_pro"); ?>
				        },
				        1200:{
				            items:<?php echo vp_option("twi_woo_options.desktop_pro"); ?>
				        }
				    }

	            });

					
				});
			/* ]]> */   
</script>
<?php 
 endif;
if(vp_option("twi_woo_options.twi_woo_crosssells_off_on") == 1) :
?>

<script type="text/javascript">
			/* <![CDATA[ */
				jQuery(document).ready(function(){
				
				 jQuery( ".products li" ).parent().addClass('twi_woo_others_carousel');
                 jQuery('.cross-sells .twi_woo_others_carousel').TWIowlCarousel({
                    loop:true,
                    autoplayTimeout:<?php echo vp_option("twi_woo_options.crosssells_au_time")*1000; ?>,
				    autoplay:<?php echo vp_option("twi_woo_options.twi_crosssells_woo_autoplay"); ?>,
				    margin:<?php echo vp_option("twi_woo_options.crosssells_pro_gap"); ?>,
				    responsiveClass:true,
				    nav:<?php echo vp_option("twi_woo_options.twi_crosssells_woo_nav"); ?>,
                    navText:['<i class="twi-icon-chevron-left"></i>','<i class="twi-icon-chevron-right"></i>'],
                    dots:<?php echo vp_option("twi_woo_options.twi_crosssells_woo_page"); ?>,
				    responsive:{
				        0:{
				            items:<?php echo vp_option("twi_woo_options.crosssells_mobile_pro"); ?>
				        },
				        479:{
				            items:<?php echo vp_option("twi_woo_options.crosssells_mobile_pro"); ?>
				        },
				        768:{
				            items:<?php echo vp_option("twi_woo_options.crosssells_tablet_pro"); ?>
				        },
				        1200:{
				            items:<?php echo vp_option("twi_woo_options.crosssells_desktop_pro"); ?>
				        }
				    }

	            });
					
				});
			/* ]]> */   
</script>
<?php 
 endif;

if(vp_option("twi_woo_options.twi_woo_related_off_on") == 1) :
?>

<script type="text/javascript">
			/* <![CDATA[ */
				jQuery(document).ready(function(){
				 jQuery( ".products li" ).parent().addClass('twi_woo_others_carousel');
                 <?php if(vp_option("twi_woo_options.twi_related_fw") == 'true'): ?>
				 jQuery( "ul.products" ).addClass('twi-forced-fullwidth');
				 <?php endif; ?>
				 jQuery('.related .twi_woo_others_carousel').TWIowlCarousel({
				    loop:true,
				    autoplayTimeout:<?php echo vp_option("twi_woo_options.related_au_time")*1000; ?>,
				    autoplay:<?php echo vp_option("twi_woo_options.twi_related_woo_autoplay"); ?>,
				    margin:<?php echo vp_option("twi_woo_options.related_pro_gap"); ?>,
				    responsiveClass:true,
				    nav:<?php echo vp_option("twi_woo_options.twi_related_woo_nav"); ?>,
                    navText:['<i class="twi-icon-chevron-left"></i>','<i class="twi-icon-chevron-right"></i>'],
                    dots:<?php echo vp_option("twi_woo_options.twi_related_woo_page"); ?>,
				    responsive:{
				        0:{
				            items:<?php echo vp_option("twi_woo_options.related_mobile_pro"); ?>
				        },
				        479:{
				            items:<?php echo vp_option("twi_woo_options.related_mobile_pro"); ?>
				        },
				        768:{
				            items:<?php echo vp_option("twi_woo_options.related_tablet_pro"); ?>
				        },
				        1200:{
				            items:<?php echo vp_option("twi_woo_options.related_desktop_pro"); ?>
				        }
				    }
				});
			});
			/* ]]> */   
</script>
<?php 
 endif;
  } 
 add_action("wp_footer","twi_conditional_js");	
?>
