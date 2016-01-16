
/*
Copyright (C) 2015 AHRealty Advisors
Designed by Kiyoto Kirkpatrick http://kiyoto.me
*/

$(function(jQuery) {

	//Check if the "other" option is selected, and if so, show the
	//"other" text box to fill in
	var $propertyType = $(".propertyType");
	var $otherDiv = $(".other");
	var $otherInput = $('.otherText');

	// Set up the default dropdown selection box variables.
	var $defaultState = $('.defaultState').text(),
		$defaultFeatured = $('.defaultFeatured').text(),
		$defaultClassification = $('.defaultClassification').text(),
		$defaultPropertyType = $('.defaultPropertyType').text(),
		$defaultPropertyTypeOther = $('.defaultPropertyTypeOther').text(),
		$defaultPricingType = $('.defaultPricingType').text(),
		$defaultBroker = $('.defaultBroker').text();
		$defaultSecondBroker = $('.defaultSecondBroker').text();
		$defaultDisplay = $('.defaultDisplay').text();

		
		
	// Set up each of the default dropdowns using the provided values.
	switch($defaultState) {
		case "Active":
			$('select[name=state]').val("Active");
			break;
		case "Leased":
			$('select[name=state]').val("Leased");
			break;
		case "Sold":
			$('select[name=state]').val("Sold");
			break;
	}
	switch($defaultFeatured) {
		case "0":
			$('select[name=featured]').val("featuredNo");
			break;
		case "1":
			$('select[name=featured]').val("featuredYes");
			break;
	}
	switch($defaultClassification) {
		case "Commercial":
			$('select[name=classification]').val("Commercial");
			break;
		case "Residential":
			$('select[name=classification]').val("Residential");
			break;
	}
	switch($defaultPropertyType) {
		case "Office":
			$('select[name=propertyType]').val("Office");
			break;
		case "Retail":
			$('select[name=propertyType]').val("Retail");
			break;
		case "Single-Family":
			$('select[name=propertyType]').val("Single-Family");
			break;
		case "Multi-Family":
			$('select[name=propertyType]').val("Multi-Family");
			break;
		case "Industrial":
			$('select[name=propertyType]').val("Industrial");
			break;
		case "Land":
			$('select[name=propertyType]').val("Land");
			break;
		case "Other":
			$('select[name=propertyType]').val("Other");
			$('.otherText').val($defaultPropertyTypeOther);
			break;
	}
	switch($defaultPricingType) {
		case "For Sale":
			$('select[name=pricingType]').val("forSale");
			break;
		case "For Lease":
			$('select[name=pricingType]').val("forLease");
			break;
		case "For Sale or For Lease":
			$('select[name=pricingType]').val("forSaleOrForLease");
			break;
	}
	switch($defaultBroker) {
		case "jorge":
			$('select[name=broker]').val("jorge");
			break;
		case "christian":
			$('select[name=broker]').val("christian");
			break;
		case "rob":
			$('select[name=broker]').val("rob");
			break;
		case "lorenzo":
			$('select[name=broker]').val("lorenzo");
			break;
		case "michael":
			$('select[name=broker]').val("michael");
			break;
		case "marquita":
			$('select[name=broker]').val("marquita");
			break;
	}
	switch($defaultSecondBroker) {
		case "":
			$('select[name=secondBroker]').val("none");
			break;
		case "none":
			$('select[name=secondBroker]').val("none");
			break;
		case "christian":
			$('select[name=secondBroker]').val("christian");
			break;
		case "rob":
			$('select[name=secondBroker]').val("rob");
			break;
		case "lorenzo":
			$('select[name=secondBroker]').val("lorenzo");
			break;
		case "michael":
			$('select[name=secondBroker]').val("michael");
			break;
		case "marquita":
			$('select[name=secondBroker]').val("marquita");
			break;
	}
	switch($defaultDisplay) {
		case "1":
			$('select[name=display]').val("1");
			break;
		case "0":
			$('select[name=display]').val("0");
			break;
	}



	$propertyType.on('change', function() {
		otherFlashCheck();
	});

	// Check if 'other' is selected, and if so, display the 'specify other' div
	// and call the flash function to see if it is empty so we can flash it.
	function otherFlashCheck() {
		var $selectedValue = $propertyType.val();
		if ($selectedValue == 'Other') {
			// Display the specify div, and flash it to make sure
			// the user sees it.
			$otherDiv.css('display', 'inline-block');
			flash($otherDiv);

		} else {
			// Empty the input and hide it.
			$otherDiv.css('display', 'none');
		}
	}

	// Flash the 'specify other' div if there is no text to get the user's attention.
	function flash(element) {

		var $selectedValueFlash = $propertyType.val();
		var $specifyText = $('.specifyOtherText');
		if ($otherInput.val().length === 0 && $selectedValueFlash == 'Other') {
			element.css('background-color','#FD6B07');
			$specifyText.css('color','#fff').delay(10000);
			$specifyText.animate({color:'#FD6B07'}, 1500, 'linear');
			element.animate({backgroundColor:"#fff"}, 1500, 'linear', function(){ flash(element); });
		}

	}

	// Flash the Other Input text on keyup
	$otherInput.on('keyup', function() {
		flash($otherDiv);
	});

	// Call otherFlashCheck to see if 'other' is selected on page load.
	otherFlashCheck();

});














