
/*
Copyright (C) 2015 AHRealty Advisors
Designed by Kiyoto Kirkpatrick http://kiyoto.me
*/

$(function(jQuery) {
	function startParsing(properties) {
		var $featuredListings = $('.featuredListings');

		var r = properties;
		// Grab the number of listings in the database,
		// and the number of listings we've found that are able to be displayed
		var numFound = 0,
			propertiesLength = properties.length,
			previouslyUsed = -1;

		// We must get the max value from the id number of the last entry, as
		// deleting entries in the database does not give an accurate last
		// number entry from counting total entries.
		var lastEntryId = r[properties.length - 1].ID;

		$featuredListings.empty();


		// Only grab listings if we've found less than 2.
		while (numFound < 2) {
			checkListing();
		}

		function checkListing(){
			// Get a random number to check against the ID, but start at 1 because
			// array starts at 0, but ID increment starts at 1, and array length
			// doesn't account for 0.
			var randomNum = getRandomInt(1, lastEntryId, previouslyUsed);

			// Set up a variable to break the each loop if we need to.
			var breakEach = false;

			$.each(r, function() {
				if (this.ID == randomNum) {
					if (this.DISPLAY == 1 && this.FEATURED == 1) {
						previouslyUsed = this.ID;

						// Add 1 to numFound to know we found a matching listing
						numFound++;

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
						$carousel = "<div id='featuredCarousel' class='carousel slide listing featuredCarousel'>" + $carouselIndicators + "<div class='carousel-inner listing featured'>" + $carouselImages + "</div></div>";

						// Set the featured listing html
						if ($previewImage != "noImages") {
							if ($carouselLength > 1) {
								$featuredListings.append('<div class="resultDivProperties"><a href="listing?id=' + this.ID + '" class="resultLink" rel="popover" data-content="' + $carousel + '" data-placement="left" data-original-title="' + this.ADDRESS + '" data-trigger="hover focus"><h3>' + this.ADDRESS + '</h3><div class="resultDiv1"><img src="uploaded_thumbnails/' + $previewImage[0] + '" alt="" height="auto" width="75"></div><div class="resultDiv2"><div class="resultDiv2-1">' + this.PRICINGTYPE + '</div><div class="resultDiv2-2">' + this.PRICE + '</div><div class="resultDiv2-3">' + this.SIZEAVAILABLE + '</div><div class="resultDiv2-4">' + this.STATE + '</div></div></a></div>');
							} else {
								$featuredListings.append('<div class="resultDivProperties"><a href="listing?id=' + this.ID + '" class="resultLink" rel="popover" data-content="' + $carouselImages + '" data-placement="left" data-original-title="' + this.ADDRESS + '" data-trigger="hover focus"><h3>' + this.ADDRESS + '</h3><div class="resultDiv1"><img src="uploaded_thumbnails/' + $previewImage[0] + '" alt="" height="auto" width="75"></div><div class="resultDiv2"><div class="resultDiv2-1">' + this.PRICINGTYPE + '</div><div class="resultDiv2-2">' + this.PRICE + '</div><div class="resultDiv2-3">' + this.SIZEAVAILABLE + '</div><div class="resultDiv2-4">' + this.STATE + '</div></div></a></div>');
							}
						} else {
							$featuredListings.append('<div class="resultDivProperties"><a href="listing?id=' + this.ID + '" class="resultLink" rel="popover" data-content="' + $carousel + '" data-placement="left" data-original-title="' + this.ADDRESS + '" data-trigger="hover focus"><h3>' + this.ADDRESS + '</h3><div class="resultDiv1"><img src="images/no-image.jpg" alt="" height="auto" width="75"></div><div class="resultDiv2"><div class="resultDiv2-1">' + this.PRICINGTYPE + '</div><div class="resultDiv2-2">' + this.PRICE + '</div><div class="resultDiv2-3">' + this.SIZEAVAILABLE + '</div><div class="resultDiv2-4">' + this.STATE + '</div></div></a></div>');
						}

						// Break out of the .each loop
						breakEach = true;
					} else {
						checkListing();
					}
				}
				if (breakEach == true) {
					return false;
				}
			});
		}

		function getRandomInt(min, max, previous) {
			// We don't want to return the same number twice
			tempNum = previous;
			while (tempNum == previous) {
				tempNum = Math.floor(Math.random() * (max - min + 1)) + min;
			}
			return tempNum;
		}
	}

		

	// Get JSON containing listings and set cache to false to see updated files.
	$.ajaxSetup({ cache: false });
	$.getJSON('../data/properties.json', function(data) {
		 startParsing(data);
	});

	// Set up the popovers and carousels
	$('body').popover({
	  html: true,
	  trigger: 'hover',
	  selector: 'a[rel=popover]'
	});

	// Start the carousel when the popover is shown.
	$('body').on('shown.bs.popover', function () {
		$('.featuredCarousel').carousel({
    	    interval: 1250
    	});
	});

});
