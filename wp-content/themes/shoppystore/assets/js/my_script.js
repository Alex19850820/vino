$(document).ready(function() {
	// jQuery('.item-masonry').hover(
	// 	function(){
	// 		$(this).find(".cover-item-gallery").fadeIn();
	// 	},
	// 	function(){
	// 		$(this).find(".cover-item-gallery").fadeOut();
	// 	}
	// );
	// jQuery('.item-masonry').hover(
	// 	function(){
	// 		$(this).find(".grid-item").fadeIn();
	// 	},
	// 	function(){
	// 		$(this).find(".grid-item").fadeOut();
	// 	}
	// );
	//
	// var sizer = '.sizer4';
	//
	// var container = jQuery('#gallery, .slick-current');
	//
	// container.imagesLoaded(function(){
	// 	container.masonry({
	// 		itemSelector: '.item-masonry',
	// 		columnWidth: sizer,
	// 		percentPosition: true
	// 	});
	// });

	jQuery('.grid').imagesLoaded( function() {
		jQuery('.grid-preloader').css('display', 'none');
		jQuery('.grid, .more_btn').css('display', 'block');
		jQuery('.grid').masonry({
			itemSelector: '.grid-item',
			percentPosition: true
		});
	});

	/*sliders*/
	// $(".vertical-center-4").slick({
	// 	dots: true,
	// 	vertical: true,
	// 	centerMode: true,
	// 	slidesToShow: 4,
	// 	slidesToScroll: 2
	// });
	// $(".vertical-center-3").slick({
	// 	dots: true,
	// 	vertical: true,
	// 	centerMode: true,
	// 	slidesToShow: 3,
	// 	slidesToScroll: 3
	// });
	// $(".vertical-center-2").slick({
	// 	dots: true,
	// 	vertical: true,
	// 	centerMode: true,
	// 	slidesToShow: 2,
	// 	slidesToScroll: 2
	// });
	// $(".vertical-center").slick({
	// 	dots: true,
	// 	vertical: true,
	// 	centerMode: true,
	// });
	// $(".vertical").slick({
	// 	dots: true,
	// 	vertical: true,
	// 	slidesToShow: 3,
	// 	slidesToScroll: 3
	// });
	// $(".regular").slick({
	// 	dots: true,
	// 	infinite: true,
	// 	// centerMode: true,
	// 	slidesToShow: 4,
	// 	slidesToScroll: 4
	// });
	// $(".center").slick({
	// 	dots: true,
	// 	infinite: true,
	// 	centerMode: true,
	// 	slidesToShow: 3,
	// 	slidesToScroll: 3
	// });
	// $(".variable").slick({
	// 	dots: true,
	// 	infinite: true,
	// 	variableWidth: true
	// });
	// $(".lazy").slick({
	// 	lazyLoad: 'ondemand', // ondemand progressive anticipated
	// 	infinite: true
	// });
	// $('.autoplay').slick({
	// 	slidesToShow: 4,
	// 	slidesToScroll: 4,
	// 	autoplay: true,
	// 	autoplaySpeed: 7000,
	// 	adaptiveHeight: true,
	// 	variableWidth: true,
	// 	centerMode: true
	// });
	// $('.filtering').slick({
	// 	slidesToShow: 4,
	// 	slidesToScroll: 1,
	// 	autoplay: true,
	// 	autoplaySpeed: 7000,
	// 	adaptiveHeight: true,
	// 	variableWidth: true,
	// 	centerMode: true
	// });

	jQuery('.responsive').slick({
		dots: true,
		infinite: true,
		speed: 300,
		autoplay: true,
		autoplaySpeed: 7000,
		slidesToShow: 1,
		slidesToScroll: 1,
		adaptiveHeight: true,
		responsive: [
			{
				breakpoint: 1024,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
					infinite: true,
					dots: true
				}
			},
			{
				breakpoint: 600,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				}
			},
			{
				breakpoint: 480,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				}
			}
			// You can unslick at a given breakpoint now by adding:
			// settings: "unslick"
			// instead of a settings object
		]
	});
	// $('.slider-for').slick({
	// 	slidesToShow: 1,
	// 	slidesToScroll: 1,
	// 	arrows: false,
	// 	fade: true,
	// 	asNavFor: '.slider-nav'
	// });
	// $('.slider-nav').slick({
	// 	slidesToShow: 3,
	// 	slidesToScroll: 1,
	// 	asNavFor: '.slider-for',
	// 	dots: true,
	// 	centerMode: true,
	// 	focusOnSelect: true
	// });
	jQuery('.aws-search-form').submit('click', function () {
		// alert('sdfsdf'); return false;
		var string = jQuery('.aws-search-field').val();
		window.location.replace("https://" + document.domain + "/category/?swoof=1&woof_text=" + string);
		return false;
	} )
	// category/?swoof=1&woof_text=виски
});