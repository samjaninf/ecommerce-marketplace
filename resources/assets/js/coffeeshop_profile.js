(function ($) {
	//hide add images button if more than 4
	var images = $('.cf-images');
	if ( images.length >= 4) {
		$('.add-images').hide();
	}
})(jQuery);