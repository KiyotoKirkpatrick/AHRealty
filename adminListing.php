<?php
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';

sec_session_start();


// Get the id from the URL
$id = filter_input(INPUT_GET, 'id', $filter = FILTER_SANITIZE_STRING);

// Get all the info from the MySQL entry.
$row = getListingArray($id, $mysqli);

// Check for MySQL errors (such as invalid listing id) and print error, then redirect to error page.

try {
	// Get all the info from the MySQL entry.
	$row = getListingArray($id, $mysqli);
	if ($row == 'Error') {
		throw new Exception("MySQL error " . $mysqli->error . " <br> Query:<br> " . $query, $mysqli->errno);
	};
} catch(Exception $e ) {
	echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
	echo nl2br($e->getTraceAsString());
	header("Location: /error.php?err=Unknown Listing ID# $id");
}

// Set up function to test if the array is valid.
function isset_get($array, $key, $default = '') {
    return isset($array[$key]) ? $array[$key] : $default;
}



// Set all the variables.
$display = isset_get($row, 'DISPLAY');
$address = isset_get($row, 'ADDRESS');
$plaza = isset_get($row, 'PLAZA');
$state = isset_get($row, 'STATE');
$featured = isset_get($row, 'FEATURED');
$classification = isset_get($row, 'CLASSIFICATION');
$propertyType = isset_get($row, 'PROPERTYTYPE');
$propertyTypeOther = ''; // Set up an empty other field in case we need it.

$price = isset_get($row, 'PRICE');
$sizeAvailable = isset_get($row, 'SIZEAVAILABLE');
$totalSize = isset_get($row, 'TOTALSIZE');
$pricingType = isset_get($row, 'PRICINGTYPE');
$broker = isset_get($row, 'BROKER');
$secondBroker = isset_get($row, 'SECONDBROKER');
$pdf = isset_get($row, 'PDF');
$images = isset_get($row, 'IMAGES');



// ==================== Property Type Logic ======================
switch ($propertyType) {
    case "Office":
    case "Retail":
    case "Single-Family":
    case "Multi-Family":
    case "Industrial":
    case "Land":
        break;
    default:
       $propertyTypeOther = $propertyType;
       $propertyType = "Other";
}


// make a note of the current working directory relative to root.
$directory_self = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']);

// make a note of the location of the upload handler script
$uploadHandler = 'http://' . $_SERVER['HTTP_HOST'] . $directory_self . 'update.listing.php';




// ============ Login Check ============
if (login_check($mysqli) == true) {
	$logged = 'in';
} else {
	$logged = 'out';
}
?>

<!DOCTYPE html>
<!--
Copyright (C) 2015 AHRealty Advisors
Designed by Kiyoto Kirkpatrick http://kiyoto.me
-->
<html lang="en">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="shortcut icon" href="assets/ico/favicon.ico">

	<title>AH Realty Advisors | Commercial and Residential Management and Brokerage</title>

	<!-- Bootstrap core CSS -->
	<link href="css/bootstrap.css" rel="stylesheet">

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->

	<!-- styles needed by jScrollPane -->
	<link type="text/css" href="css/jquery.jscrollpane.css" rel="stylesheet" media="all" />

	<link href='css/index.css' rel='stylesheet'>
  </head>
<!-- NAVBAR
================================================== -->
  <body>
	<div class="navbar-wrapper">
	  <div class="container">
		<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		  <div class="container">
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			  <a class='navbar-brand' title="Commercial and Residential Management and Brokerage | AH Realty Advisors" target="_self" href="http://www.ahrealtyadvisors.com">
				<img id="logoLink" border="0" alt="AH Realty Advisors" title="" src="images/LogoCombined.png"></img>
			  </a>
			</div>
			<div class="navbar-collapse collapse">
			  <ul class="nav navbar-nav navbar-right">
				<li><a href="http://www.ahrealtyadvisors.com">Home</a></li>
				<li class="dropdown">
				  <a href="#services" class="dropdown-toggle" data-toggle="dropdown">Services <b class="caret"></b></a>
				  <ul class="dropdown-menu">
					<li><a href="brokerage">Brokerage</a></li>
					<li><a href="management">Management</a></li>
					<li><a href="development">Development</a></li>
					<li><a href="consulting">Consulting</a></li>
				  </ul>
				</li>
				<li class="dropdown">
				  <a href="#properties" class="dropdown-toggle" data-toggle="dropdown">Properties <b class="caret"></b></a>
				  <ul class="dropdown-menu">
					<li id='commercialPage'><a href="properties?sort=commercial">Commercial</a></li>
					<li id='residentialPage'><a href="properties?sort=residential">Residential</a></li>
				  </ul>
				</li>
				<li><a href="team">Team</a></li>
				<li><a href="contact">Contact</a></li>
				<form class="form-inline" role="form">
						<div class="form-group has-feedback">
							<input id="inputSearch" type="text" class="form-control hasclear" placeholder="Search..." />
							<span class="clearer glyphicon glyphicon-remove-circle form-control-feedback"></span>
						
						</div>
					</form>
					<div class='scrollable-area'>
						<ul class="results"></ul>
					</div>
			  </ul>
			</div>
		  </div>
		</div>
	  </div>
	</div>






	<!-- Marketing messaging and featurettes
	================================================== -->
	<!-- Wrap the rest of the page in another container to center all the content. -->

	<div class="container marketing">
	<div id="dom-target" style="display: none;"><?php
			echo "<span class='defaultDisplay'>" . $display . "</span>";
			echo "<span class='defaultState'>" . $state . "</span>";
			echo "<span class='defaultFeatured'>" . $featured . "</span>";
			echo "<span class='defaultClassification'>" . $classification . "</span>";
			echo "<span class='defaultPropertyType'>" . $propertyType . "</span>";
			echo "<span class='defaultPropertyTypeOther'>" . $propertyTypeOther . "</span>";
			echo "<span class='defaultPricingType'>" . $pricingType . "</span>";
			echo "<span class='defaultBroker'>" . $broker . "</span>";
			echo "<span class='defaultSecondBroker'>" . $secondBroker . "</span>";
			echo "<span class='defaultImages'>" . $images . "</span>";
			echo "<span class='defaultPdf'>" . $pdf . "</span>";
			?></div>

	  <!-- Three columns of text below the carousel -->
	  <div class="row">
		<div class="col-md-12 mainInfo">
		<?php if ($logged == "in") : ?>
			<div class="row">
				<form action="<?php echo $uploadHandler ?>" method="POST" enctype="multipart/form-data" id="my-awesome-dropzone">
					<div class="col-md-12 listingTitle centered">
						<h1><strong><span class='greenTitle'>Edit a Property Listing</span></strong></h1>
						<h2><strong><span class='greenTitle'>Address: <input type="text" name="address" class="formInput addressInput form-control" value="<?php echo $address ?>"/></span></strong></h2>
						<div class='plazaState'>
							<h3 class='plaza'><i>Plaza/Sub-Location: <input type="text" name="plaza" class="formInput form-control" value="<?php echo $plaza ?>"/></i></h3>
							<span class='orangeStateSelect'>Current State: 
								<select name="state" class="orangeStateSelectText form-control">
									<option value="Active">Active</option>
									<option value="Inactive">Inactive</option>
									<option value="Leased">Leased</option>
									<option value="Sold">Sold</option>
							</select></span>
							<span class='featuredSelect'>Featured Property?: 
								<select name="featured" class="featuredSelectText form-control">
									<option value="featuredNo">No</option>
									<option value="featuredYes">Yes</option>
							</select></span>
						</div>
					</div>
					<div class="col-md-6 col-sm-12 listingInfo">
						<div class="col-md-6 listing infoLeft">
							<h3><span class="orangeTitle">Classification:</span></h3>
							<h4><strong><select name="classification" class="form-control">
									<option value="Commercial">Commercial</option>
									<option value="Residential">Residential</option>
								</select></strong></h4>
							<h3><span class="orangeTitle">Property Type:</span></h3>
							<h4><strong><select class="propertyType form-control" name="propertyType">
									<option value="Office">Office</option>
									<option value="Retail">Retail</option>
									<option value="Single-Family">Single-Family</option>
									<option value="Multi-Family">Multi-Family</option>
									<option value="Industrial">Industrial</option>
									<option value="Land">Undeveloped Land</option>
									<option value="Other">Other</option>
								</select></strong></h4>
							<div class='other' style='display:none'>
								<h3><span class="orangeTitle specifyOtherText">Specify Other:</span></h3>
								<h4><strong><input class='otherText form-control' type="text" name="propertyTypeOther" /></strong></h4>
							</div>
							<h3><span class="orangeTitle">Listed Price:</span></h3>
							<h4><strong><input type="text" name="price" class="formInput form-control" value="<?php echo $price ?>"/></strong></h4>
							<h3><span class="orangeTitle">Size Available:</span></h3>
							<h4><strong><input type="text" name="sizeAvailable" class="formInput form-control" value="<?php echo $sizeAvailable ?>"/></strong></h4>
							<h3><span class="orangeTitle">Total Size:</span></h3>
							<h4><strong><input type="text" name="totalSize" class="formInput form-control" value="<?php echo $totalSize ?>"/></strong></h4>
						</div>

						<div class="col-md-6 listing infoRight">
							<h3><span class="orangeTitle">Pricing Type:</span></h3>
							<h4><strong><select name="pricingType" class="form-control">
								<option value="forSale">For Sale</option>
								<option value="forLease">For Lease</option>
								<option value="forSaleOrForLease">For Sale or For Lease</option>
							</select></strong></h4>
							<h3><span class="orangeTitle">Broker:</span></h3>
							<h4><strong><select name="broker" class="form-control">
								<option value="jorge">Jorge Andrade</option>
								<option value="christian">Christian Andrade</option>
								<option value="rob">Rob Berneking</option>
								<option value="lorenzo">Lorenzo Andrade</option>
								<option value="michael">Michael Sintzel</option>
							</select></strong></h4>
							<h3><span class="orangeTitle">Secondary Broker:</span></h3>
							<h4><strong><select name="secondBroker" class="form-control">
								<option value="none">None</option>
								<option value="jorge">Jorge Andrade</option>
								<option value="christian">Christian Andrade</option>
								<option value="rob">Rob Berneking</option>
								<option value="lorenzo">Lorenzo Andrade</option>
								<option value="michael">Michael Sintzel</option>
							</select></strong></h4>
							<br><h4>This option determines whether this listing is internal or public:</h4>
							<h3><span class="orangeTitle">Display to public:</span></h3>
							<h4><strong><select name="display" class="form-control">
								<option value="1">Yes</option>
								<option value="0">No</option>
							</select></strong></h4>

							<!-- Hidden inputs to hold info for upload form -->
							<input type="hidden" name="listingId" style="display: none;" value="<?php echo $id ?>"/>
							<input type="hidden" name="currentImages" style="display: none;" value="<?php echo $images ?>"/>
							<input type="hidden" name="currentPdfs" style="display: none;" value="<?php echo $pdf ?>"/>

						</div>
					</div>
					<div class='col-md-6 col-sm-12 darkGray'>
						<div id="actions" class="row">
							<!-- The fileinput-button span is used to style the file input field as button -->
							<span class="btn btn-success fileinput-button dropzoneButton">
								<i class="glyphicon glyphicon-plus"></i>
								<span>Add files...</span>
							</span>

							<!-- The global file processing state -->
							<span class="fileupload-process">
							  <div id="total-progress" class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
								<div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
							  </div>
							</span>
						</div><!-- /id="actions" -->

						<!-- Table that holds the previews -->
						<div class="table table-striped" class="files" id="previews">
							<div id="template" class="file-row">
								<!-- This is used as the file preview template -->
								<div>
									<span class="preview"><img data-dz-thumbnail class="previewThumbnail"/></span>
								</div>
								<div>
									<p class="name" data-dz-name></p>
									<strong class="error text-danger" data-dz-errormessage></strong>
								</div>
								<div>
									<p class="size" data-dz-size></p>
									<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
										<div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
										</div>
								</div>
								<div>
									<button data-dz-remove class="btn btn-warning cancel dropzoneButton">
										<i class="glyphicon glyphicon-ban-circle"></i>
										<span>Remove</span>
									</button>
									<button data-dz-remove class="btn btn-danger delete dropzoneButton">
										<i class="glyphicon glyphicon-trash"></i>
										<span>Delete</span>
									</button>
								</div>
							</div>
						</div> 
					</div><!-- /.col-md-4 /.col-sm-12 -->
					<div class='col-md-12 submitButton'>
						<button type="submit" class="btn btn-primary startUpload">
							<i class="glyphicon glyphicon-upload"></i>
							<span>Update Listing</span>
						</input>
					</div>
				</form>
			</div><!-- /.row -->
		</div><!-- /.col-md-12 -->
		</div><!-- /.row -->


	  <br>
	  <br>

	  <!-- FOOTER -->
	  <footer>
		<p class="pull-right"><a href="privacy">Privacy</a></p>
		<p><h4><span class='greenTitle'>&copy; 2015 AH Realty Advisors, LLC.</span></p>
		<p><small>330 North Fourth Street, Suite 300, Saint Louis, MO  63102</small></p>
		<p><small>Hours:  Mon-Fri  8:30am - 5pm</small></h4></p>

		<div class="col-md-6 col-md-offset-3 loggedIn bordered">
		    <p>Welcome <?php echo htmlentities($_SESSION['username']); ?>!</p>
		    <p><a href="listing?id=<?php echo $id ?>" class="loginButton">View This Listing</a></p>
		    <p><a href="adminProperties.php" class="loginButton">Back to Edit Listings</a></p>
		    <p><a href="adminPanel.php" class="loginButton">Admin Panel</a></p>
		    <p><a href="includes/logout" class="loginButton">Log Out</a></p>
		    <?php else : ?>
		    	<div class="col-md-6 col-md-offset-3 loggedIn bordered">
					<p>
						<span class="error">You are not authorized to access this page.</span> Please <a href="login.php">login</a>.
					</p>
				</div>
			<?php endif; ?>
	    </div>
	  </footer>

	</div><!-- /.container -->


	<!-- Bootstrap core JavaScript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="scripts/jquery-1.11.2.min.js"></script>
	<script src="scripts/jquery-ui-1.11.2.min.js"></script>
	<script src="scripts/bootstrap.js"></script>
	<script src="scripts/jquery.animate-enhanced.js"></script>
	<script src="scripts/fuse.js"></script>
	<script src="scripts/search.js"></script>
	<!--<script src="scripts/tap.js"></script>-->

	<!-- the mousewheel plugin - optional to provide mousewheel support for jscrollpane -->
	<script type="text/javascript" src="scripts/jquery.mousewheel.js"></script>

	<!-- the jScrollPane script -->
	<script type="text/javascript" src="scripts/jquery.jscrollpane.min.js"></script>

	<script src="scripts/index.js"></script>
	<script src="scripts/dropzone.js"></script>
	<script src="scripts/adminListing.js"></script>
	<script src="scripts/adminListingdz.js"></script>
  </body>
</html>
