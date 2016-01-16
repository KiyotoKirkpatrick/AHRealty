
/*
Copyright (C) 2015 AHRealty Advisors
Designed by Kiyoto Kirkpatrick http://kiyoto.me
*/


$(function (jQuery) {
	"use strict";
	
	jQuery(document).ready(function(){

		// Set up the carousel modal and listen for clicks
		/*$('#myModal').modal({local: '#myCarousel'});*/
		
		$('.carousel-inner').click(function() {
			$('#myModal').modal({local: '#myCarousel'});
		});


		// Show the image if it is clicked and there is no carousel.
		$('#myModalContent').click(function() {
			if ($('#myModalContent').attr('data-carousel') == false && $('#myModalContent').attr('data-noImages') != true) {
				$('#myModal').modal({local: '#myModalContent'});
			}
		});
		
		// Listen for clicks if there is no image or pdf.
		$('img.noImage').click(function() {
			alert( "No image of this property is available.\nPlease contact us for more information." );
		});

		$('img.noPDF').click(function() {
			alert( "No PDF for this property is available.\nPlease contact us for more information." );
		});


	});
});