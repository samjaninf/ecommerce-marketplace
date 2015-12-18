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

	function priceToDecimal(price) {
		price = price / 100;
		return price;
	}

	function getProductSizes(productName, that) {


		window.products.forEach( function (product) {
			if ( product.name == productName) {

				productSize = product.pivot;
				sizes = {'xs': 'xs_activated', 'sm': 'sm_activated', 'md': 'md_activated', 'lg': 'lg_activated'};

				if (that) {
					console.log(that.attr('name').replace(/\D/g, ''));
					//myString = myString.replace(/\D/g,'');
					option = '<select name="productSizes[' + that.attr('name').replace(/\D/g, '') + ']" class="choose-product-select count-size">';
				} else {
					option = '<select name="productSizes[0]" class="choose-product-select count-size">';
				}


				for ( var key in sizes) {
					
				if ( productSize[sizes[key]] == 1 ) {
						if ( key == 'xs' ) {
							price = 'X-small';
						} else if ( key == 'sm' ) {
							price = 'Small';
						} else if ( key == 'md' ) {
							price = 'Medium';
						} else if ( key == 'lg' ) {
							price = 'Large';
						}

						option += '<option value="' + key + '">' + price + ' @ £' + priceToDecimal(productSize[key]) + '</option>';
					}
				}
				
				option += '</select>';
				if (that) {
					that.parent().siblings('.sizes-select').html('');
					that.parent().siblings('.sizes-select').append(option);
					console.log(option);
				} else {
					$('.sizes-select').html('');
					$('.sizes-select').append(option);
				}
				// sizes.forEach( function (size) {
				// 	console.log(productSize[size]);
				// });
				// if ( size.xs_activated == 1) {
				// 	//create option
				// 	xs = '<option value="' + size.xs + ">X-Small @ " + priceToDecimal(size.xs) + "</option>";

				// }

			}
		});
	}

	function getProductCount() {
		return $('.count-product').length - 1;
	}
	$(document).ready(function() {
		//get count and append attr
		$('.choose-product-select').attr('name', 'products[' + getProductCount() + ']');

		var current = $('.choose-product-select option:selected').text().replace(/\s/g, '');
		getProductSizes(current);
	});

	$(document).on('change', '.choose-product-select', function() {
		var current = $(this).find('option:selected').text().replace(/\s/g, '');
		getProductSizes(current, $(this));
	});

	var product;
	$(document).on('click', '#add-product', function (e) {
		e.preventDefault();

		product = $('.products-copy').clone().removeClass('products-copy');
		product.find('.count-product').attr('name', 'products[' + $('.count-product').length + ']');
		var current = product.find('.count-product option:selected').text().replace(/\s/g, '');
		var that = product.find('.choose-product-select');
		getProductSizes(current, that);
		product.insertAfter('.products-copy');
	});

	$(document).on('click', '.remove-product', function(e) {
		e.preventDefault();

		$(this).parent().parent().remove();
	});
})(jQuery);