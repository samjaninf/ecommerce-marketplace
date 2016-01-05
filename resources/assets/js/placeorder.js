(function($) {
	var time = jQuery('#time');
	var customTime = jQuery('#custom-time');
	var product;

	time.on('change', function() {
		$this = $(this);
		if ( $this.val() === 'custom' || $this.val() === customTime.val()) {
			$('#custom-time-value').val(customTime.val().replace(/\s/g, ''));
			customTime.show();
		} else {
			customTime.hide();
		}
	});
	customTime.on('change', function() {
		jQuery('#custom-time-value').val($(this).val());
	});

	jQuery('.filter-toggle').on('click', function() {
		jQuery('.dropdown-toggle').show();
	});
	jQuery('.dropdown-close').on('click', function() {
		jQuery('.dropdown-toggle').hide();
	});

	function priceToDecimal(price) {
		return (price / 100).toFixed(2);
	}

	function createProductSizes(productName, that) {
		if(window.products) {
			
			window.products.forEach( function (product) {
				//get the selected product name and create select option for sizes
				if ( product.name == productName.replace(/\s/g, '')) {
				
					//get create option for sizes for d.replace(/\s/g, ''
					if ( product.type === 'drink' ) {
						productSize = product.pivot;
						sizes = {'xs': 'xs_activated', 'sm': 'sm_activated', 'md': 'md_activated', 'lg': 'lg_activated'};

						if (that) {
							option = '<select name="productSizes[' + that.attr('name').replace(/\D/g, '') + ']" class="choose-product-select count-size">';
						} else {
							option = '<select name="productSizes[0]" class="choose-product-select count-size">';
						}

						//type
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
						} else {
							$('.sizes-select').html('');
							$('.sizes-select').append(option);
						}
						
					} else {
						if (that) {
							//food only uses the "sm" value, no sizes
							that.parent().siblings('.sizes-select').html('');
							that.parent().siblings('.sizes-select').append('£' + priceToDecimal(product.pivot.sm));
						} else {
							$('.sizes-select').html('');
							$('.sizes-select').append('£' + priceToDecimal(product.pivot.sm));
						}
					}
				}
			});
		}
	}

	$(document).ready(function() {

		Array.prototype.move = function (old_index, new_index) {
		    if (new_index >= this.length) {
		        var k = new_index - this.length;
		        while ((k--) + 1) {
		            this.push(undefined);
		        }
		    }
		    this.splice(new_index, 0, this.splice(old_index, 1)[0]);
		    return this; // for testing purposes
		};

		sorted = [];
		sorting = [];

		$('.choose-product-select option').each( function (i) {
			sorting.push($(this));
			sorted.push($(this).text().replace(/\s/g, '').toLowerCase());
		});
		sorted.sort();
		
		sorted.forEach(function (value, i) {
			console.log(value);
		});

		// $('.choose-product-select option').each( function (i) {
		// 	var cur = $(this).text().replace(/\s/g, '').toLowerCase();
		// 	sorted.push(cur);



		// 	sorted.slice(-1)[0] 

		// 	sorted.indexOf
		// });

		console.log(sorted.sort());
		$('.choose-product-select').attr('name', 'products[0]');

		var current = $('.choose-product-select option:selected').text().replace(/\s/g, '');
		createProductSizes(current);
		if ( $('.remove-product').length == 1 ) {
			$('.remove-product').hide();
		}
	});

	$(document).on('change', '.choose-product-select', function() {
		var current = $(this).find('option:selected').text().replace(/\s/g, '');
		createProductSizes(current, $(this));
	});

	$(document).on('click', '#add-product', function (e) {
		e.preventDefault();

		product = $('.products-copy').clone().removeClass('products-copy');
		product.find('.remove-product').show();
		product.find('.remove-product').css('display', 'block');
		product.find('.count-product').attr('name', 'products[' + $('.count-product').length + ']');
		var current = product.find('.count-product option:selected').text().replace(/\s/g, '');
		var that = product.find('.choose-product-select');
		createProductSizes(current, that);
		product.insertAfter('.products-copy');

	});

	$(document).on('click', '.remove-product', function(e) {
		e.preventDefault();

		$(this).parent().parent().remove();
	});
})(jQuery);