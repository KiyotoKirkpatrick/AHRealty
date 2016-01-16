
/*
Copyright (C) 2015 AHRealty Advisors
Designed by Kiyoto Kirkpatrick http://kiyoto.me
*/


$(function (jQuery) {
	"use strict";	
	jQuery(document).ready(function(){

		$('.emailButton').click(function() {
			var $name = $(this).text();
			$( "input[name='mailTo']" ).val($name);
			$('#emailModal').modal('show');
		});

		$("input#emailSubmit").click(function(){
			// Clear the success text box in case the user has tried the message more than once.
			$('.emailSuccessText').text('');

			// Send the email form data to the email handler.
			$.ajax({
				type: "POST",
				url: "../includes/emailForm", //process to mail
				data: $('form.contact').serialize(),
				success: function(msg){
					$("#emailModal").modal('hide'); //hide popup
					$('.emailSuccessText').append(msg);
					$("#thanksModal").modal('show'); //hide button and show thank you
				},
				error: function(){
					alert("Error.\nAn unexpected error occurred.\nPlease try again.");
				}
			});
		});
	});
});