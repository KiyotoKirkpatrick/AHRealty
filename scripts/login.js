
/*
Copyright (C) 2015 AHRealty Advisors
Designed by Kiyoto Kirkpatrick http://kiyoto.me
*/


$(function (jQuery) {
	"use strict";
	
	jQuery(document).ready(function(){

		$('#email').keyup(function(key) {
			// If Enter is pressed, simulate submit button click.
			if (key.which == 13) {
				$('#loginButton').click();
			}
		});
		$('#password').keyup(function(key) {
			// If Enter is pressed, simulate submit button click.
			if (key.which == 13) {
				$('#loginButton').click();
			}
		});



	});
});