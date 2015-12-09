(function($) {
	var time = jQuery('#time');
	var customTime = jQuery('#custom-time');

	time.on('change', function() {
		$this = $(this);
		console.log($this.val());
		console.log($this.html());
		if ( $this.val() === 'custom' || $this.val() === customTime.val()) {
			customTime.show();
		} else {
			customTime.hide();
		}
	});
	customTime.on('change', function() {
		jQuery('#custom-time-value').val($(this).val());
	});
})(jQuery);