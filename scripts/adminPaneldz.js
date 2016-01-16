
/*
Copyright (C) 2015 AHRealty Advisors
Designed by Kiyoto Kirkpatrick http://kiyoto.me
*/

$(document).ready(function(){
	Dropzone.autoDiscover = false;

	// Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
	var previewNode = document.querySelector("#template");
	previewNode.id = "";
	var previewTemplate = previewNode.parentNode.innerHTML;
	previewNode.parentNode.removeChild(previewNode); 


	var myDropzone = new Dropzone(document.querySelector("#my-awesome-dropzone"), { // Make the whole body a dropzone

		// The configuration we've talked about above
		// url does not has to be written if we have wrote action in the form tag but i have mentioned here just for convenience sake
		url                 : '/upload.processordz.php',
		thumbnailWidth		: 80,
		thumbnailHeight		: 80,
		parallelUploads     : 100,
		previewTemplate		: previewTemplate,
		autoProcessQueue    : false, // this is important as you dont want form to be submitted unless you have clicked the submit button
		paramName           : 'files', // this is optional Like this one will get accessed in php by writing $_FILE['pic'] // if you dont specify it then bydefault it taked 'file' as paramName eg: $_FILE['file']
		previewsContainer   : '#previews', // we specify on which div id we must show the files
		clickable			: ".fileinput-button", // Define the element that should be used as click trigger to select files.
		uploadMultiple      : true,
		maxFiles            : 100,
		acceptedFiles       : '.jpg,.jpeg,.pdf,.png,.bmp',
		dictInvalidFileType : 'This file type is not supported.',

		// The setting up of the dropzone
		init: function() {
			var myDropzone = this;

			// First change the button to actually tell Dropzone to process the queue.
			document.querySelector(".startUpload").addEventListener("click", function(e) {
				// Make sure that the form isn't actually being sent.
				e.preventDefault();
				e.stopPropagation();
				var form = document.getElementById('my-awesome-dropzone');
				var formInputs = document.getElementsByClassName('formInput');
                if (validate(formInputs) == true) {
					// Check if address field is empty
					var propertyAddress = document.getElementsByClassName('addressInput');
					if (propertyAddress[0].value != '') {
						if (myDropzone.getQueuedFiles().length > 0) {						
							myDropzone.processQueue();  
						} else {
							// Form is missing pictures/pdf send anyway?
							var confirmation = confirm("There are no images/pdf.\nSubmit Anyway?");
							if (confirmation) {
								form.submit(); //send empty 
							}
						}
					} else {
						alert("You must provide an address");
						propertyAddress[0].focus();
					}
				}
			});

			function validate(formInputs) {
				var elements = formInputs;
				for (var i=0; i < elements.length; i++) {
					if (elements[i].value == '' && elements[i].className != 'otherText formInput form-control') {
						if(confirm("There are empty fields.\nSubmit Anyway?")) {
							return true;
						} else {
							elements[i].focus();
							return false;
						}
					}
				}
				return true;
			}

			// Listen to the sendingmultiple event. In this case, it's the sendingmultiple event instead
			// of the sending event because uploadMultiple is set to true.
			this.on("sendingmultiple", function() {
				// Gets triggered when the form is actually being sent.
				// Hide the success button or the complete form.
			});
			this.on("successmultiple", function(files, response) {
				// Gets triggered when the files have successfully been sent.
				// Redirect user or notify of success.
				window.location.replace("adminPaneldz?listing=" + response);
			});
			this.on("errormultiple", function(files, response) {
				// Gets triggered when there was an error sending the files.
				// Maybe show form again, and notify user of error
				// alert(response);
			});
		}

	});
	
	// Update the total progress bar
	myDropzone.on("totaluploadprogress", function(progress) {
		document.querySelector("#total-progress .progress-bar").style.width = progress + "%";
	});
	
	myDropzone.on("sending", function(file) {
		// Show the total progress bar when upload starts
		document.querySelector("#total-progress").style.opacity = "1";
	});
	
	// Hide the total progress bar when nothing's uploading anymore
	myDropzone.on("queuecomplete", function(progress) {
		document.querySelector("#total-progress").style.opacity = "0";
	});
	
	document.querySelector("#actions .cancel").onclick = function() {
		myDropzone.removeAllFiles(true);
	}; 
});
