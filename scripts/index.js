
/*
Copyright (C) 2015 AHRealty Advisors
Designed by Kiyoto Kirkpatrick http://kiyoto.me
*/


$(function (jQuery) {
	"use strict";
	
	jQuery(document).ready(function(){

		// Make the navbar static if on mobile. Otherwise it's fixed in place.
		if($(window).width() <= 768) {
			$('.navbar-fixed-top').removeClass('navbar-fixed-top').addClass('navbar-static-top');
		}


		// ---------- Watch for carousel changes and animate the info ----------
		
		// Pause the carousel for debug purposes
		/*$('#myCarousel').carousel({
            interval: false
        });*/

		$('#myCarousel').on('slid.bs.carousel', function () {
			// Check to see which slide is active
			$( 'div.item.active' ).children('.container').children('.carouselCaptionHeader').toggle('slide', {direction: 'left'}, 'slow');
			$( 'div.item.active' ).children('.container').children('.carouselCaptionContent').toggle('slide', {direction: 'right'}, 'slow');
			$( 'div.item.active' ).children('.container').children('.carouselCaptionButton').toggle('slide', {direction: 'right'}, 'slow');

		});

		// Reset the caption so it will slide
		$('#myCarousel').on('slide.bs.carousel', function () {
			// Check to see which slide is active
			$( 'div.item.active' ).children('.container').children('.carouselCaptionHeader').toggle('slide', {direction: 'left'}, 'slow');
			$( 'div.item.active' ).children('.container').children('.carouselCaptionContent').toggle('slide', {direction: 'right'}, 'slow');
			$( 'div.item.active' ).children('.container').children('.carouselCaptionButton').toggle('slide', {direction: 'right'}, 'slow');


		});
	});
});