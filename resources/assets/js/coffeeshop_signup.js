(function($) {
	$(document).on("keypress", ":input:not(textarea)", function(event) {
	    return event.keyCode != 13;
	});
})(jQuery);