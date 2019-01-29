(function( $ ) {
		
		$(function() {

			/*! Main Functionality for Settings SlideOut */
			jQuery('document').ready(function() {
				var a = jQuery('#rev_addon_gal_settings_slideout');
				punchgs.TweenLite.set(a,{xPercent:"+100%", autoAlpha:0, display:"none"});

				jQuery('body').on('click', '#rs-dash-addons-slide-out-trigger_revslider-gallery-addon', function() {
					//hide all wrappers
					jQuery('.rs-sbs-slideout-wrapper').each(function(){
						punchgs.TweenLite.to(jQuery(this),0.4,{xPercent:"+100%", autoAlpha:0, display:"none",overwrite:"auto",ease:punchgs.Power3.easeInOut});
					});

					//display slideout
					var a = jQuery('#rev_addon_gal_settings_slideout'),
						b = jQuery('.rs-dash-addons');						
					punchgs.TweenLite.to(a,0.4,{xPercent:"0%", autoAlpha:1, display:"block",overwrite:"auto",ease:punchgs.Power3.easeOut});
				});
				jQuery('body').on('click','#rev_addon_gal_settings_slideout .rs-sbs-close', function() {
					var a = jQuery('#rev_addon_gal_settings_slideout');				
					punchgs.TweenLite.to(a,0.4,{xPercent:"+100%", autoAlpha:0, display:"none",overwrite:"auto",ease:punchgs.Power3.easeInOut});
				});

				//enable Scrollbars
				jQuery('#rev_addon_gal_settings_slideout .rs-sbs-slideout-inner').css("max-height",$( window ).height()-300);
					setTimeout(function() {
						jQuery('#rev_addon_gal_settings_slideout .rs-sbs-slideout-inner').perfectScrollbar("update");
					},400);
				$(window).resize(function(){
					jQuery('#rev_addon_gal_settings_slideout .rs-sbs-slideout-inner').css("max-height",$( window ).height()-300);
					jQuery('#rev_addon_gal_settings_slideout .rs-sbs-slideout-inner').perfectScrollbar("update");
				});

				//call scrollbars
				jQuery('#rev_addon_gal_settings_slideout .rs-sbs-slideout-inner').perfectScrollbar({wheelPropagation:true, suppressScrollX:true});



				}); //end document ready

			/*! Settings Save Function */
			// Setup a click handler to initiate the Ajax request and handle the response
			$('#rs-addon-gal-save').live("click",function(evt) {
				showWaitAMinute({fadeIn:300,text:rev_slider_addon.please_wait_a_moment});
				$.ajax({
					url : rev_slider_addon_gal.ajax_url,
					type : 'post',
					data : {
						action : 'save_gal',
						nonce: $('#ajax_rev_slider_addon_gal_nonce').text(),// The security nonce
						default_gallery: $('#rs-addon-gal-slider').val()
					},
					success : function( response ) {
						switch(response){
							case "0":
									UniteAdminRev.showInfo({type: 'warning', hideon: '', event: '', content: 'Ajax Error', hidedelay: 3});
									break;
							case "1":
									UniteAdminRev.showInfo({type: 'success', hideon: '', event: '', content: rev_slider_addon.settings_saved, hidedelay: 3});
									break;
							case "-1":
									UniteAdminRev.showInfo({type: 'warning', hideon: '', event: '', content: 'Nonce missing', hidedelay: 3});
									break;
						}
						showWaitAMinute({fadeOut:300,text:rev_slider_addon.please_wait_a_moment});
					},
					error : function ( response ){
						UniteAdminRev.showInfo({type: 'warning', hideon: '', event: '', content: 'Ajax Error', hidedelay: 3});
					}
				}); // End Ajax
			}); // End Click

		});

})( jQuery );
