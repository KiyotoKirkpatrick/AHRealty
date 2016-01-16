
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

	$propertyType.on('change', function(){
		var $selectedValue = $propertyType.val();
		if ($selectedValue == 'Other') {
			// Display the specify div, and flash it to make sure
			// the user sees it.
			$otherDiv.css('display', 'inline-block');
			flash($otherDiv);

		} else {
			// Empty the input and hide it.
			$otherInput.val('');
			$otherDiv.css('display', 'none');
		}
	});

	function flash(element) {

		var $selectedValueFlash = $propertyType.val();
		var $specifyText = $('.specifyOtherText');
		if ($otherInput.val().length === 0 && $selectedValueFlash == 'Other') {
			element.css('background-color', '#FD6B07');
			$specifyText.css('color', '#fff').delay(10000);
			$specifyText.animate({color: '#FD6B07'}, 1500, 'linear');
			element.animate({
					backgroundColor: "#fff"
				}, 1500, 'linear', function(){ flash(element); });
		}

	}

	// Flash the Other Input text if it's shown and empty.
	$otherInput.on('keyup', function() {
		if ($otherInput.val().length === 0 && $propertyType.val() == 'Other') {
			flash($otherDiv);
		}
	});

	// Show modal if listing has been posted.
	if ($('#dom-target').text() == 'showModal') {
		$('#myModal').modal('show');
	}

});














