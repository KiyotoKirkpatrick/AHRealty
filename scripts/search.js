
/*
Copyright (C) 2015 AHRealty Advisors
Designed by Kiyoto Kirkpatrick http://kiyoto.me
*/

$(function(jQuery) {
	function start(properties) {
		var $inputSearch = $('#inputSearch'),
			$result = $('.results'),

			button_exists = false,

			searchAddress = true,
			searchSize = true,
			searchPrice = true,

			fuse;

		function search() {
			var r = fuse.search($inputSearch.val());
			$result.empty();
			// Only show results if search box isn't empty.
			if ($inputSearch.val() != ''){
				$.each(r, function() {
					if (this.DISPLAY == 1) {
						$previewImage = this.IMAGES.split(',');
						$carouselLength = $previewImage.length;
						$carouselImages = '';
						$carouselImagesTemp = [];
						$carouselIndicators = '';
						$carouselIndicatorsTemp = [];
						this.carousel = '';

						// Check for images and construct them and the indicators for the carousel
						if ($previewImage != "noImages") {

							// Set up the thumbnail redirection
							for (i = 0; i < $carouselLength; i++) {
								$thumbnailNameArray = $previewImage[i].split('.');
								$previewImage[i] = $thumbnailNameArray[0] + "-thumbnail." + $thumbnailNameArray[1];
								$previewImage[i] = $previewImage[i].replace(/"/g, "&quot;").replace(/'/g, "&apos;");
							}

							$carouselImagesTemp[0] = "<div class='item active'><img alt='No Image' data-src='holder.js/900x500/auto/#555:#5a5a5a/text:First slide' src='uploaded_thumbnails/" + $previewImage[0] + "'  width='100%' height='auto'></img></div>";
							$carouselIndicatorsTemp[0] = "<li data-target='#myCarousel' data-slide-to='0' class='active'></li>";

							for (i = 1; i < $carouselLength; i++) {
								$carouselImagesTemp[i] = "<div class='item'><img alt='Slide # " + i + "' data-src='holder.js/900x500/auto/#555:#5a5a5a/text:First slide' src='uploaded_thumbnails/" + $previewImage[i] + "'  width='100%' height='auto'></img></div>";
								$carouselIndicatorsTemp[i] = "<li data-target='#myCarousel' data-slide-to='" + i + "'></li>";
							}
						
							// Implode to convert array to string.
							$carouselImages = $carouselImagesTemp.join('');
							$carouselIndicators = "<ol class='carousel-indicators'>" + $carouselIndicatorsTemp.join('') + "</ol>";
						
						} else {
							$carouselImages = "<div class='item active'><a href='#'><img class='noImage' alt='No Image' data-src='holder.js/900x500/auto/#555:#5a5a5a/text:First slide' src='images/no-image.jpg' width='100%' height='auto'></img></div>";
						}

						// Construct the carousel
						$carousel = "<div id='searchCarousel' class='carousel slide listing searchCarousel'>" + $carouselIndicators + "<div class='carousel-inner listing featured'>" + $carouselImages + "</div></div>";

						// Set the featured listing html
						if ($previewImage != "noImages") {
							if ($carouselLength > 1) {
								scrollableAreaAPI.getContentPane().append(
									$result.append('<div class="resultDivProperties"><a href="listing?id=' + this.ID + '" class="resultLink searchCarouselLink" rel="popover" data-content="' + $carousel + '" data-placement="left" data-container="body" data-original-title="' + this.ADDRESS + '" data-trigger="hover focus"><h3>' + this.ADDRESS + '</h3><div class="resultDiv1"><img src="uploaded_thumbnails/' + $previewImage[0] + '" alt="" height="auto" width="75"></div><div class="resultDiv2"><div class="resultDiv2-1">' + this.PRICINGTYPE + '</div><div class="resultDiv2-2">' + this.PRICE + '</div><div class="resultDiv2-3">' + this.SIZEAVAILABLE + '</div><div class="resultDiv2-4">' + this.STATE + '</div></div></a></div>')
								);
							} else {
								scrollableAreaAPI.getContentPane().append(
									$result.append('<div class="resultDivProperties"><a href="listing?id=' + this.ID + '" class="resultLink searchCarouselLink" rel="popover" data-content="' + $carouselImages + '" data-placement="left" data-container="body" data-original-title="' + this.ADDRESS + '" data-trigger="hover focus"><h3>' + this.ADDRESS + '</h3><div class="resultDiv1"><img src="uploaded_thumbnails/' + $previewImage[0] + '" alt="" height="auto" width="75"></div><div class="resultDiv2"><div class="resultDiv2-1">' + this.PRICINGTYPE + '</div><div class="resultDiv2-2">' + this.PRICE + '</div><div class="resultDiv2-3">' + this.SIZEAVAILABLE + '</div><div class="resultDiv2-4">' + this.STATE + '</div></div></a></div>')
								);
							}
						} else {
							scrollableAreaAPI.getContentPane().append(
								$result.append('<div class="resultDivProperties"><a href="listing?id=' + this.ID + '" class="resultLink searchCarouselLink" rel="popover" data-content="' + $carousel + '" data-placement="left" data-container="body" data-original-title="' + this.ADDRESS + '" data-trigger="hover focus"><h3>' + this.ADDRESS + '</h3><div class="resultDiv1"><img src="images/no-image.jpg" alt="" height="auto" width="75"></div><div class="resultDiv2"><div class="resultDiv2-1">' + this.PRICINGTYPE + '</div><div class="resultDiv2-2">' + this.PRICE + '</div><div class="resultDiv2-3">' + this.SIZEAVAILABLE + '</div><div class="resultDiv2-4">' + this.STATE + '</div></div></a></div>')
							);
						}
					};
				});
			};

			var resultsChildrenLength = $('.results').children().length;

			if (resultsChildrenLength == 0) {
				$('.scrollable-area').css({'display': 'none'});

			} else if (resultsChildrenLength == 1 && $(window).width() >= 992) {
				$('.scrollable-area').css({'height': '165px', 'display': 'inline-block'})

			} else if (resultsChildrenLength == 2 && $(window).width() >= 992) {
				$('.scrollable-area').css({'height': '330px', 'display': 'inline-block'})

			} else if (resultsChildrenLength >= 3 && $(window).width() >= 992) {
				$('.scrollable-area').css({'height': '500px', 'display': 'inline-block'})

			} else {
				$('.scrollable-area').css({'height': '180px', 'display': 'inline-block'})
			}
			scrollableAreaAPI.reinitialise();
		}

		function createFuse() {
			var keys = [];
			if (searchAddress) {
				keys.push('ADDRESS');
			}
			if (searchSize) {
				keys.push('SIZEAVAILABLE');
			}
			if (searchPrice) {
				keys.push('PRICE');
			}
			fuse = new Fuse(properties, {
				keys: keys,
				threshold: '0.5'
			});
		}


		$inputSearch.keyup(function(key) {
			// If Enter is pressed, go to properties page and search that value.
			if (key.which == 13) {
				var searchVal = $inputSearch.val();
				window.location.replace("http://ahrealtyadvisors.com/properties?search=" + searchVal);
			} else {
				search()
				var t = $(this);
				t.next('span').toggle(Boolean(t.val()));
			}
		});

		$(".clearer").hide($(this).prev('input').val());
		$(".clearer").click(function () {
			$(this).prev('input').val('').focus();
			$(this).hide();
			$result.empty();

			// Reset the scrollable area
			$('.scrollable-area').css({'display': 'none'});
			scrollableAreaAPI.reinitialise();
		});

		createFuse();

		// Popover logic
		$('.searchCarouselLink').popover({
		  html: true,
		  trigger: 'manual',
		  animation: false,
		  container: 'body'
		}).on("mouseenter", function () {
			var _this = this;
			$(this).popover("show");
			$(this).siblings(".popover").on("mouseleave", function () {
				$(_this).popover('hide');
			});
		}).on("mouseleave", function () {
			var _this = this;
			setTimeout(function () {
				$(_this).popover("hide")
			}, 100);
		});

		// Set up the popovers
		$('body').popover({
		  html: true,
		  trigger: 'hover',
		  selector: 'a[rel=popover]'
		});
	
		// Start the carousel when the popover is shown.
		$('body').on('shown.bs.popover', function () {
			$('.searchCarousel').carousel({
				interval: 1250
			});
		});

		// Close popovers on body click
		$('body').on('click', function (e) {
			$('.popover').each(function () {
				$(this).remove();
			});
		});
	}

	// Initialise the scrollpanes
	$('.scrollable-area').css({'display': 'none'});
	$('.scrollable-area').jScrollPane({
		showArrows: false,
		contentWidth: 300
	});

	var scrollableAreaAPI = $('.scrollable-area').data('jsp');

	// Watch for JScrollPane events
	$('.jspDrag').hide();
	$('.jspScrollable').mouseenter(function(){
		$(this).find('.jspDrag').stop(true, true).fadeIn();
	});
	$('.jspScrollable').mouseleave(function(){
		$(this).find('.jspDrag').stop(true, true).fadeOut();
	});

	// Get JSON containing listings and set cache to false to see updated files.
	$.ajaxSetup({ cache: false });
	$.getJSON('../data/properties.json', function(data) {
		 start(data);
	});

});
