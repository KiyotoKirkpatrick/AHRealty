
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
		url				 : '/update.listing.php',
		thumbnailWidth		: 80,
		thumbnailHeight		: 80,
		parallelUploads	 : 100,
		previewTemplate		: previewTemplate,
		autoProcessQueue	: false, // this is important as you dont want form to be submitted unless you have clicked the submit button
		paramName		   : 'files', // this is optional Like this one will get accessed in php by writing $_FILE['pic'] // if you dont specify it then bydefault it taked 'file' as paramName eg: $_FILE['file']
		previewsContainer   : '#previews', // we specify on which div id we must show the files
		clickable			: ".fileinput-button", // Define the element that should be used as click trigger to select files.
		uploadMultiple	  : true,
		maxFiles			: 100,
		acceptedFiles	   : '.jpg,.jpeg,.pdf,.png,.bmp',
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
						if (confirmDeletion(form) == true) {
							if (myDropzone.getQueuedFiles().length > 0) {						
								myDropzone.processQueue();  
							} else {
								form.submit(); //send empty
							}
						} else {
							// Cancelled deletion. Reload the page.
							location.reload(true);
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

			function confirmDeletion(form) {
				//Check if files deleted and confirm else reload the page.
				if (form.contains(document.getElementById('deletedImages')) || form.contains(document.getElementById('deletedPdfs'))) {
					if(confirm("Are you sure you want to delete these files?\nCancelling will refresh the page.")) {
						return true;
					} else {
						return false;
					}
				} else {
					return true;
				}
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
				window.location.replace("listing?id=" + response);
			});
			this.on("errormultiple", function(files, response) {
				// Gets triggered when there was an error sending the files.
				// Maybe show form again, and notify user of error
				alert(response);
			});

			// Parse removing already uploaded files and send them to the upload
			// handler to delete them from the server.
			this.on("removedfile", function (file) {
				// Only files that have been programmatically added should
				// have a url property.
				if (file.url && file.url.trim().length > 0) {
					if (file.filetype == 'image') {
						$("<input type='hidden'>").attr({
							id: 'deletedImages',
							name: 'deletedImages[]'
						}).val(file.url).appendTo('#my-awesome-dropzone');
					} else if (file.filetype == 'pdf') {
						$("<input type='hidden'>").attr({
							id: 'deletedPdfs',
							name: 'deletedPdfs[]'
						}).val(file.url).appendTo('#my-awesome-dropzone');
					}
				}
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
	



	//Add existing images into dropzone
	var defaultImages = document.querySelector(".defaultImages").innerHTML;
	var imagesArray = defaultImages.split(',');
	var existingFiles = [];

	// Check if there are images. If not, don't process them.
	if (imagesArray[0] != 'noImages') {
		for (var i = 0; i < imagesArray.length; i++) {
			// Set up the thumbnail location
			var thumbnailNameArray = imagesArray[i].split('.');
			var thumbnailLocation = thumbnailNameArray[0] + "-thumbnail." + thumbnailNameArray[1];

			var tempArr = { 
					name: imagesArray[i].slice(11), 
					size: 42,
					status: Dropzone.ADDED, 
					url: imagesArray[i],
					thumbnail: thumbnailLocation,
					accepted: true,
					filetype: 'image'
				};
			existingFiles.push(tempArr);
		}

		for (var i = 0; i < existingFiles.length; i++) {
			var mockFile = existingFiles[i];
			myDropzone.emit("addedfile", mockFile);
			myDropzone.files.push(mockFile);
			myDropzone.emit("thumbnail", mockFile, "/uploaded_thumbnails/" + mockFile["thumbnail"]);
			myDropzone.emit("complete", mockFile);
		}
	}

	//Add existing pdfs into dropzone
	var defaultPdf = document.querySelector(".defaultPdf").innerHTML;
	var pdfArray = defaultPdf.split(',');
	var existingFiles = [];

	// Check if there are pdfs. If not, don't process them.
	if (pdfArray[0] != 'noPDF') {
		for (var i = 0; i < pdfArray.length; i++) {
			var tempArr = { 
					name: pdfArray[i].slice(11), 
					size: 42,
					status: Dropzone.ADDED, 
					url: pdfArray[i],
					accepted: true,
					filetype: 'pdf'
				};
			existingFiles.push(tempArr);
		}

		for (var i = 0; i < existingFiles.length; i++) {
			var mockFile = existingFiles[i];
			myDropzone.emit("addedfile", mockFile);
			myDropzone.files.push(mockFile);
			myDropzone.emit("thumbnail", mockFile, "/images/acrobat_icon.jpg");
			myDropzone.emit("complete", mockFile);
		}
	}

});
