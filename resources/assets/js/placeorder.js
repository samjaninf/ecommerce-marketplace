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
	// products.forEach(function (product) {
	// 	console.log(product);


	// 	// product.name

	// 	// if product.pivot.xs_activated = 1
	// 	// if product.pivot.sm_activated = 1
	// 	// if product.pivot.md_activated = 1
	// 	// if product.pvitor.lg_activated = 1

	// });


	jQuery('.filter-toggle').on('click', function() {
		console.log('click');
		jQuery('.dropdown-toggle').show();
	});
	jQuery('.dropdown-close').on('click', function() {
		jQuery('.dropdown-toggle').hide();
	});
	function getProductSize(productName) {

		window.products.forEach( function (product) {
			if ( product.name == productName) {
				console.log(product.pivot);
			}
		});
		console.log(window.products);
	}
	$(document).ready(function() {
		var current = $('.choose-product-select option:selected').text().replace(/\s/g, '');
		getProductSize(current);
	});

	$('.choose-product-select').on('change', function() {
		var current = $(this).find('option:selected').text().toLowerCase().replace(/\s/g, '');
		console.log(current);
	});


})(jQuery);