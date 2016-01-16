
/*
Copyright (C) 2015 AHRealty Advisors
Designed by Kiyoto Kirkpatrick http://kiyoto.me
*/

$(function(jQuery) {
	function start(properties) {
		var $inputSearch = $('#inputSearchProperties'),
			$result = $('.resultsProperties'),

			currentSortVal = getUrlVars()['sort'],
			currentSearchVal = getUrlVars()['search'],

			currentSearchByVal = 'all',

			$commercialButton = $('.commercialButton'),
			$commercialOffice = $('.commercialOffice'),
			$commercialRetail = $('.commercialRetail'),
			$commercialIndustrial = $('.commercialIndustrial'),
			$commercialLand = $('.commercialLand'),
			$commercialMulti = $('.commercialMulti'),
			$commercialAll = $('.commercialAll'),

			$residentialButton = $('.residentialButton'),
			$bothButton = $('.bothButton'),

			$addressButton = $('.addressButton'),
			$sizeButton = $('.sizeButton'),
			$priceButton = $('.priceButton'),
			$allButton = $('.allButton'),

			$inputSearchProperties = $('#inputSearchProperties'),

			searchAddress = false,
			searchSize = false,
			searchPrice = false,
			searchAll = true,

			fuse;

			//Decode get variables if they exist.
			if (currentSortVal != undefined) {
				currentSortVal = decodeURI(currentSortVal);
			}
			if (currentSearchVal != undefined) {
				currentSearchVal = decodeURI(currentSearchVal);
			}

			// Set post variable to correct version
			if (currentSortVal == 'commercial' ) {currentSortVal = 'commercialAll';}

			// If search is set from navbar search, do search. otherwise hide the X clearer icon
			if (currentSearchVal) {
				$inputSearch.val(currentSearchVal);
			} else {
				$(".propertiesClearer").hide($(this).prev('input').val());
			}

		function getUrlVars()
		{
			var vars = [], hash;
			var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
			for(var i = 0; i < hashes.length; i++)
			{
				hash = hashes[i].split('=');
				vars.push(hash[0]);
				vars[hash[0]] = hash[1];
			}
			return vars;
		}

		function search(sortVal) {
			var r;
			// Show all items if search box is empty
			if ($inputSearch.val() === '') {
				r = properties;
			} else {
				r = fuse.search($inputSearch.val());
			}

			$result.empty();

			if (sortVal == 'commercialAll') {
				$.each(r, function() {
					if (this.DISPLAY == 1 && this.CLASSIFICATION == 'Commercial') {
						$constructedListing = constructListing(this);
					}
				});
			} else if (sortVal == 'commercialOffice') {
				$.each(r, function() {
					if (this.DISPLAY == 1 && this.CLASSIFICATION == 'Commercial' && this.PROPERTYTYPE == 'Office') {
						$constructedListing = constructListing(this);
					}
				});
			} else if (sortVal == 'commercialRetail') {
				$.each(r, function() {
					if (this.DISPLAY == 1 && this.CLASSIFICATION == 'Commercial' && this.PROPERTYTYPE == 'Retail') {
						$constructedListing = constructListing(this);
					}
				});
			} else if (sortVal == 'commercialMulti') {
				$.each(r, function() {
					if (this.DISPLAY == 1 && this.CLASSIFICATION == 'Commercial' && this.PROPERTYTYPE == 'Multi-Family') {
						$constructedListing = constructListing(this);
					}
				});
			} else if (sortVal == 'commercialIndustrial') {
				$.each(r, function() {
					if (this.DISPLAY == 1 && this.CLASSIFICATION == 'Commercial' && this.PROPERTYTYPE == 'Industrial') {
						$constructedListing = constructListing(this);
					}
				});
			} else if (sortVal == 'commercialLand') {
				$.each(r, function() {
					if (this.DISPLAY == 1 && this.CLASSIFICATION == 'Commercial' && this.PROPERTYTYPE == 'Land') {
						$constructedListing = constructListing(this);
					}
				});
			} else if(sortVal == 'residential') {
				$.each(r, function() {
					if (this.DISPLAY == 1 && this.CLASSIFICATION == 'Residential') {
						$constructedListing = constructListing(this);
					}
				});
			} else {
				$.each(r, function() {
					if (this.DISPLAY == 1) {
						$constructedListing = constructListing(this);
					}
				});
			}

			// Initialise the scrollpanes
			$('.propertiesScrollableArea').jScrollPane({
				showArrows: false,
				contentWidth: 205
			});

			var propertiesScrollableAreaAPI = $('.propertiesScrollableArea').data('jsp');

			// Watch for JScrollPane events
			$('.jspDrag').hide();
			$('.jspScrollable').mouseenter(function(){
				$(this).find('.jspDrag').stop(true, true).fadeIn();
			});
			$('.jspScrollable').mouseleave(function(){
				$(this).find('.jspDrag').stop(true, true).fadeOut();
			});

			



			function constructListing($tempListing) {
				$previewImage = $tempListing.IMAGES.split(',');
				$carouselLength = $previewImage.length;
				$carouselImages = '';
				$carouselImagesTemp = [];
				$carouselIndicators = '';
				$carouselIndicatorsTemp = [];
				$tempListing.carousel = '';
				$constructedListing = [];

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
						$result.append('<div class="resultDivProperties"><a href="listing?id=' + $tempListing.ID + '" class="resultLinkProperties searchPropertiesCarouselLink" rel="popover" data-content="' + $carousel + '" data-placement="left" data-container="body" data-original-title="' + $tempListing.ADDRESS + '" data-trigger="hover focus"><h3>' + $tempListing.ADDRESS + '</h3><div class="resultDiv1"><img src="uploaded_thumbnails/' + $previewImage[0] + '" alt="" height="auto" width="75"></div><div class="resultDiv2 propertiesScrollableArea"><div class="resultDiv2-1">' + $tempListing.PRICINGTYPE + '</div><div class="resultDiv2-2">' + $tempListing.PRICE + '</div><div class="resultDiv2-3">' + $tempListing.SIZEAVAILABLE + '</div></div><div class="resultDiv2-4">' + $tempListing.STATE + '</div></a></div>');
					} else {
						$result.append('<div class="resultDivProperties"><a href="listing?id=' + $tempListing.ID + '" class="resultLinkProperties searchPropertiesCarouselLink" rel="popover" data-content="' + $carouselImages + '" data-placement="left" data-container="body" data-original-title="' + $tempListing.ADDRESS + '" data-trigger="hover focus"><h3>' + $tempListing.ADDRESS + '</h3><div class="resultDiv1"><img src="uploaded_thumbnails/' + $previewImage[0] + '" alt="" height="auto" width="75"></div><div class="resultDiv2 propertiesScrollableArea"><div class="resultDiv2-1">' + $tempListing.PRICINGTYPE + '</div><div class="resultDiv2-2">' + $tempListing.PRICE + '</div><div class="resultDiv2-3">' + $tempListing.SIZEAVAILABLE + '</div></div><div class="resultDiv2-4">' + $tempListing.STATE + '</div></a></div>');
					}
				} else {
					$result.append('<div class="resultDivProperties"><a href="listing?id=' + $tempListing.ID + '" class="resultLinkProperties searchPropertiesCarouselLink" rel="popover" data-content="' + $carousel + '" data-placement="left" data-container="body" data-original-title="' + $tempListing.ADDRESS + '" data-trigger="hover focus"><h3>' + $tempListing.ADDRESS + '</h3><div class="resultDiv1"><img src="images/no-image.jpg" alt="" height="auto" width="75"></div><div class="resultDiv2 propertiesScrollableArea"><div class="resultDiv2-1">' + $tempListing.PRICINGTYPE + '</div><div class="resultDiv2-2">' + $tempListing.PRICE + '</div><div class="resultDiv2-3">' + $tempListing.SIZEAVAILABLE + '</div></div><div class="resultDiv2-4">' + $tempListing.STATE + '</div></a></div>');
				}
			


				// Popover Carousel Logic
				$('.searchPropertiesCarouselLink').popover({
				  html: true,
				  trigger: 'manual',
				  animation: true,
				  container: 'body',
				  placement: 'auto left'
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
		}

		function createFuse()
		{
			var keys = [];
			if (searchAddress) {
				keys.push('ADDRESS');
			}else if (searchSize) {
				keys.push('SIZEAVAILABLE');
			}else if (searchPrice) {
				keys.push('PRICE');
			} else if (searchAll) {
				keys.push('ADDRESS', 'SIZEAVAILABLE', 'PRICE');
			}
			fuse = new Fuse(properties, {
			keys: keys,
			threshold: '0.5'
			});
		}


		function onSortByChanged(value)
		{
			var addArray = [];

			//Set up id/class references
			var resPage = $('#residentialPage'),
				resButton = $residentialButton,
				comPage = $('#commercialPage'),
				comButton = $commercialButton;

			if (currentSortVal != value) {
				if (value != 'sort on load') {
					currentSortVal = value;
				}


				// ----------- Start button highlight logic
				
				// Start fresh with all buttons unhighlihted.
				allButtonsArray = [
									$bothButton,
									resPage,
									resButton,
									comPage,
									comButton,
									$commercialOffice,
									$commercialRetail,
									$commercialIndustrial,
									$commercialLand,
									$commercialMulti,
									$commercialAll
									];

				removeActive(allButtonsArray);


				// Set buttons to highlight based on selected sort
				switch (currentSortVal) {
					case 'residential':
						addArray.push(resPage, resButton);
						break;
					case 'commercialAll':
						addArray.push(comPage, comButton, $commercialAll);
						break;
					case 'commercialOffice':
						addArray.push(comPage, comButton, $commercialOffice);
						break;
					case 'commercialRetail':
						addArray.push(comPage, comButton, $commercialRetail);
						break;
					case 'commercialIndustrial':
						addArray.push(comPage, comButton, $commercialIndustrial);
						break;
					case 'commercialLand':
						addArray.push(comPage, comButton, $commercialLand);
						break;
					case 'commercialMulti':
						addArray.push(comPage, comButton, $commercialMulti);
						break;
					default:
						addArray.push($bothButton);
				} 
				
			}

			addActive(addArray);

			// Show the loading icon to give visual feedback to users.
			$('#myModal').modal('show');

			// Fade out the loading icon after results have loaded.
			// Add a "sleep" timer because results load too quick.
			setTimeout(function() {
				$('#myModal').modal('hide');
			}, (0.5 * 1000));
			
			createFuse();
			search(currentSortVal);
		}

		function removeActive(array) {
			// For each item in the array, remove the class 'active'
			var removeArray = array;
			var removeArrayLength = removeArray.length;
			for (i = 0; i < removeArrayLength; i++) {
				if ( removeArray[i].hasClass('active') ) {
					removeArray[i].removeClass('active');
				}
			}
		}

		function addActive(array) {
			// For each item in the array, add the class 'active'
			var addArray = array;
			var addArrayLength = addArray.length;
			for (i = 0; i < addArrayLength; i++) {
				if ( !addArray[i].hasClass('active') ) {
					addArray[i].addClass('active');
				}
			}
		}

		function onSearchByChanged(value)
		{
			var addArray = [];

			if (currentSearchByVal != value) {
				if (value != 'sort on load') {
					currentSearchByVal = value;
				}


				// Start fresh with all buttons unhighlihted.
				allSearchButtonsArray = [
									$addressButton,
									$sizeButton,
									$priceButton,
									$allButton
									];

				removeActive(allSearchButtonsArray);
				searchAddress =
				searchSize =
				searchPrice =
				searchAll = false;

				

				// Set buttons to highlight based on selected sort
				switch (currentSearchByVal) {
					case 'address':
						addArray.push($addressButton);
						searchAddress = true;
						break;
					case 'size':
						addArray.push($sizeButton);
						searchSize = true;
						break;
					case 'price':
						addArray.push($priceButton);
						searchPrice = true;
						break;
					case 'all':
						addArray.push($allButton);
						searchAll = true;
						break;
					default:
						alert('An error has occurred.');
				}

				addActive(addArray);
			}

			changeSearchText();
			createFuse();
			search(currentSortVal);
		}

		function changeSearchText()
		{
			switch(currentSearchByVal)
			{
				case 'address':
					$inputSearchProperties.attr('placeholder', 'Search by Address...');
					break;
				case 'size':
					$inputSearchProperties.attr('placeholder', 'Search by Size...');
					break;
				case 'price':
					$inputSearchProperties.attr('placeholder', 'Search by Price...');
					break;
				case 'all':
					$inputSearchProperties.attr('placeholder', 'Search All...');
					break;
				default:
					$inputSearchProperties.attr('placeholder', 'Search...');
					break;
			}
		}

		function dropdownChanged() {
			if (!$commercialButton.hasClass('open') || $commercialAll.hasClass('active') || $commercialOffice.hasClass('active') || $commercialRetail.hasClass('active') || $commercialIndustrial.hasClass('active') || $commercialLand.hasClass('active') || $commercialMulti.hasClass('active')) {
				if (!$commercialButton.hasClass('active')) {
					$commercialButton.addClass('active');
				}
			}
		}

		$commercialButton.on('click', function() {dropdownChanged();});
		$commercialOffice.on('click', function() {onSortByChanged('commercialOffice');});
		$commercialRetail.on('click', function() {onSortByChanged('commercialRetail');});
		$commercialIndustrial.on('click', function() {onSortByChanged('commercialIndustrial');});
		$commercialLand.on('click', function() {onSortByChanged('commercialLand');});
		$commercialMulti.on('click', function() {onSortByChanged('commercialMulti');});
		$commercialAll.on('click', function() {onSortByChanged('commercialAll');});

		$residentialButton.on('click', function() {onSortByChanged('residential');});
		$bothButton.on('click', function() {onSortByChanged('both');});

		$addressButton.on('click', function() {onSearchByChanged('address');});
		$sizeButton.on('click', function() {onSearchByChanged('size');});
		$priceButton.on('click', function() {onSearchByChanged('price');});
		$allButton.on('click', function() {onSearchByChanged('all');});

		$inputSearch.on('keyup', function() {
			search(currentSortVal);

			// Show the X clearing icon
			var t = $(this);
			t.next('span').toggle(Boolean(t.val()));
		});



		onSortByChanged('sort on load');
		changeSearchText();
		onSearchByChanged('sort on load');


		// Logic for clearing search bar on X pressed
		$(".propertiesClearer").click(function () {
			$(this).prev('input').val('').focus();
			$(this).hide();

			// Reset the search
			search(currentSortVal);
			
		});
	}


	// Get JSON containing listings and set cache to false to see updated files.
	$.ajaxSetup({ cache: false });
	$.getJSON('../data/properties.json', function(data) {
		start(data);
	});

});
