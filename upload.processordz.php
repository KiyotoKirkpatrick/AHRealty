<?php

// Start a secure session to upload info to mySQLI database
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';
sec_session_start();


// Check for MySQLI errors
if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
}

// Check to make sure user is logged in and has permission
// if so, process upload. Else, error.
if (login_check($mysqli) == true) {
	// filename: upload.processordz.php

	// --------------------------------Global Vars ------------------------------------------------

	// make a note of the current working directory, relative to root.
	$directory_self = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']);

	// make a note of the directory that will receive the uploaded images
	$uploadsDirectory = $_SERVER['DOCUMENT_ROOT'] . $directory_self . 'uploaded_images/';

	// make a note of the directory that will receive the uploaded image thumbnails
	$uploadsDirectoryThumbnail = $_SERVER['DOCUMENT_ROOT'] . $directory_self . 'uploaded_thumbnails/';

	// make a note of the directory that will receive the uploaded PDF
	$uploadsDirectoryPDF = $_SERVER['DOCUMENT_ROOT'] . $directory_self . 'uploaded_pdfs/';

	// make a note of the directory that will receive the updated properties.json
	$jsonDirectory = $_SERVER['DOCUMENT_ROOT'] . $directory_self . 'data/';

	// make a note of the location of the upload form in case we need it
	$uploadForm = 'http://' . $_SERVER['HTTP_HOST'] . $directory_self . 'adminPaneldz.php';

	// fieldname used within the file <input> of the HTML form
	$fieldname = 'files';




	// -------------------------------Image Upload Handling-------------------------------

	// Set up variable to make accessing files easier.
	$IMG = isset($_FILES['files']) ? $_FILES['files'] : array();
	$values_insert = [];
	$values_insertPDF = [];

	// Perform upload only if there's actually something uploaded.
	if (!empty($IMG)) {
		foreach ($IMG["error"] as $key => $error) {

			$filename = $IMG['name'][$key];
			$ext = pathinfo($filename, PATHINFO_EXTENSION);

			if ($error == 0 && $ext != '') {

				// check that the file we are working on really was the subject of an HTTP upload
				@is_uploaded_file($_FILES[$fieldname]['tmp_name'][$key])
					or error('not an HTTP upload', $uploadForm);

				// Set up name generation
				$tmp_name = $IMG["tmp_name"][$key];
				$name = $IMG["name"][$key];
				$now = time();
				while(file_exists($uploadFilename = $now.'-'.$name))
				{
					$now++;
				};
				
				// Remove anything which isn't a word, whitespace, number
				// or any of the following caracters -_.
				$uploadFilename = preg_replace("([^\w\s\d\-_.])", '', $uploadFilename);
				// Remove any runs of periods
				$uploadFilename = preg_replace("([\.]{2,})", '', $uploadFilename);

				// Check if the file is a PDF or image and upload to correct directory.
				if ($ext != 'pdf') {
					if (move_uploaded_file($tmp_name, "$uploadsDirectory/$uploadFilename")) {
						$name_array = $uploadFilename;
						$values_insert[] = $name_array;
					} else {
						echo 'Image Failed!';
					};

					// ------ Create a thumbnail from the newly saved image -------
					
					// Set up thumbnail name by adding "-thumbnail" before extension
					$filenameArray = explode(".", $uploadFilename);
					$thumbnailName = $filenameArray[0] . "-thumbnail." . $filenameArray[1];

					// Grab the saved image and scale it down
					$im = new Imagick("$uploadsDirectory/$uploadFilename");
					if ($im->scaleImage(400, 0)) {
						$im->writeImage("$uploadsDirectoryThumbnail/$thumbnailName");
						$im->destroy();
					} else {
						echo 'Thumbnail Scaling Failed!';
					}

				} else {
					if (move_uploaded_file($tmp_name, "$uploadsDirectoryPDF/$uploadFilename")) {
						$name_arrayPDF = $uploadFilename;
						$values_insertPDF[] = $name_arrayPDF;
					} else {
						echo 'PDF Failed!';
					};
				};

			} else {
			// possible PHP upload errors
			$errors = array(0 => 'Empty Array',
					1 => 'php.ini max file size exceeded',
					2 => 'HTML form max file size exceeded',
					3 => 'File upload was only partial',
					4 => 'No file was attached');

			error($errors[$_FILES[$fieldname]['error'][$key]], $uploadForm);
			};
		};
	}
	
	$values_insert = implode(',', $values_insert);
	$values_insertPDF = implode(',', $values_insertPDF);



	// ----------------------------- Upload to MySQL ----------------------------

	// Get all the info and store in variables to insert into the MySQL table.
	$tempDisplay = $_POST['display'];
	$display = (int) $tempDisplay;
	
	// Check if property is featured, post bool (0 or 1)
	$featuredInput = $_POST['featured'];
	if ( $featuredInput == 'featuredYes') {
		$featured = 1;
	} else {
		$featured = 0;
	}
	$address = $_POST['address'];
	$plaza = $_POST['plaza'];
	$state = $_POST['state'];
	$classification = $_POST['classification'];
	$propertyType = $_POST['propertyType'];
	// Check for 'other' property type & get text input
	if ( $propertyType == 'Other') {
		$propertyType = $_POST['propertyTypeOther'];
	}
	$price = $_POST['price'];
	$sizeAvailable = $_POST['sizeAvailable'];
	$totalSize = $_POST['totalSize'];

	// Get the correct pricing type
	$pricingTypeTemp = $_POST['pricingType'];
	$pricingType = '';

	// Parse pricingTypeTemp
	switch ($pricingTypeTemp) {
	case 'forSale':
		$pricingType = 'For Sale';
		break;
	case 'forLease':
		$pricingType = 'For Lease';
		break;
	case 'forSaleOrForLease':
		$pricingType = 'For Sale or For Lease';
		break;
	default:
		$pricingType = 'Error';
	};

	$broker = $_POST['broker'];
	$secondBroker = $_POST['secondBroker'];

	// Set PDF and images variables. if they're empty, set them that way.
	if ($values_insertPDF != '') {
		$pdfVar = $values_insertPDF;
	} else {
		$pdfVar = 'noPDF';
	};
	if ($values_insert != '') {
		$images = $values_insert;
	} else {
		$images = 'noImages';
	};


	// Insert the new listing into the database
	if ($insert_stmt = $mysqli->prepare("INSERT INTO listings (DISPLAY, FEATURED, ADDRESS, PLAZA, STATE, CLASSIFICATION, PROPERTYTYPE, PRICE, SIZEAVAILABLE, TOTALSIZE, PRICINGTYPE, BROKER, SECONDBROKER, PDF, IMAGES) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")) {
		$insert_stmt->bind_param('iisssssssssssss', $display, $featured, $address, $plaza, $state, $classification, $propertyType, $price, $sizeAvailable, $totalSize, $pricingType, $broker, $secondBroker, $pdfVar, $images);
		// Execute the prepared query.
		if (! $insert_stmt->execute()) {
			header('Location: /error.php?err=Listing Creation Failure ');
			exit();
		} else {
			// Make a variable that holds the dynamic link to the listing just inserted.
			$createdListing = $mysqli->insert_id;


			// Now we need to update the properties.json file to include the new listing.
			// We'll just query the MySQL database and write all rows to the file.
			$result = $mysqli->query('SELECT * FROM listings');
			$json = array();
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				$json[] = $row;
			}


			// Check if the json holding the listings exists, if not, create it.
			$myFile = $jsonDirectory . 'properties.json';
			// $method = (file_exists($myFile)) ? 'a' : 'w';

			// Open the listings json and write to it.
			$fp = fopen($myFile, 'w');
			fwrite($fp, json_encode($json));
			fclose($fp);

			// Free the memory from the MySQL query
			$result->free();

			// If you got this far, everything has worked and the files have been successfully saved.
			// We are now going to respond with the created listing url, to
			// give the user the option to navigate to the listing they just created.
			
			// Echo the listing number if there were files uploaded, otherwise dropzone
			// won't process it and we'll have to redirect from here.
			if (empty($IMG)) {
				header("Location: /adminPaneldz?listing=" . urlencode($createdListing));
			} else {
				echo $createdListing;
			}
			exit();
		}
	}
} else {
	// If the user isn't logged in, they get this error message.
	echo '<span class="error">You are not authorized to access this page.</span> Please <a href="login.php">login</a>.';
} // End login check.

// The following function is an error handler which is used
// to output an HTML error page if the file upload fails
function error($error, $location, $seconds = 5)
{
	header("Refresh: $seconds; URL= $location");
	echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"'.
	'"http://www.w3.org/TR/html4/strict.dtd">'.
	'<html lang="en">'.
	'		<head>'.
	'				<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">'.
	'				<link rel="stylesheet" type="text/css" href="stylesheet.css">'.
	'		<title>Upload error</title>'.
	'		</head>'.
	'		<body>'.
	'		<div id="Upload">'.
	'				<h1>Upload failure</h1>'.
	'				<p>An error has occurred: '.
	'				<br><br><span style="color: red;">' . $error . '</span><br><br>'.
	'				 The upload form is reloading</p>'.
	'		 </div>'.
	'</html>';
	exit;
} // end error handler
?>
