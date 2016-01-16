<?php
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';

sec_session_start();

if (login_check($mysqli) == true) {
	$logged = 'in';
} else {
	$logged = 'out';
}

// Get the id from the URL
$id = filter_input(INPUT_GET, 'id', $filter = FILTER_SANITIZE_STRING);

// Get all the info from the MySQL entry.
//$row = getListingArray($id, $mysqli);

// Check for MySQL errors (such as invalid listing id) and print error, then redirect to error page.

try {
	// Get all the info from the MySQL entry.
	$row = getListingArray($id, $mysqli);
	if ($row == 'Error') {
		throw new Exception("MySQL error " . $mysqli->error . " <br> Query:<br> " . $row, $mysqli->errno);
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
$address = isset_get($row, 'ADDRESS');
$plaza = isset_get($row, 'PLAZA');
$state = isset_get($row, 'STATE');
$classification = isset_get($row, 'CLASSIFICATION');
$propertyType = isset_get($row, 'PROPERTYTYPE');

// If price, size available, or total price are blank, display contact message.
$contactUs = 'Please contact us for more information.';

$price = isset_get($row, 'PRICE');
if ($price == '') {
	$price = $contactUs;
}

$sizeAvailable = isset_get($row, 'SIZEAVAILABLE');
if ($sizeAvailable == '') {
	$sizeAvailable = $contactUs;
}

$totalSize = isset_get($row, 'TOTALSIZE');
if ($totalSize == '') {
	$totalSize = $contactUs;
}

// Set up the rest of the variables.
$pricingType = isset_get($row, 'PRICINGTYPE');
$brokerTemp = isset_get($row, 'BROKER');
$broker = '';
$secondBrokerTemp = isset_get($row, 'SECONDBROKER');
$secondBroker = '';
$pdf = isset_get($row, 'PDF');
$images = isset_get($row, 'IMAGES');
$noImages = false;



// Start parsing the Google Maps URL, pricingType, broker, PDF, and Images.
$mapsURL = urlencode($address);

// Parse brokerTemp
switch ($brokerTemp) {
	case 'jorge':
		$broker = '<strong>Jorge Andrade</strong><br /><a class="emailButton greenTitle" href="javascript:;">jorge@ahrealtyadvisors.com</a><br /><br />';
		break;
	case 'christian':
		$broker = '<strong>Christian Andrade</strong><br />Office: 314-773-1700 x302<br />Cell: 314-775-4888<br /><a class="emailButton greenTitle" href="javascript:;">christian@ahrealtyadvisors.com</a><br /><br />';
		break;
	case 'rob':
		$broker = '<strong>Rob Berneking</strong><br />Office: 314-773-1700 x303<br />Cell: 618-581-5312<br /><a class="emailButton greenTitle" href="javascript:;">rob@ahrealtyadvisors.com</a><br /><br />';
		break;
	case 'lorenzo':
		$broker = '<strong>Lorenzo Andrade</strong><br />Office: 314-773-1700 x304<br />Cell: 314-922-4797<br /><a class="emailButton greenTitle" href="javascript:;">lorenzo@ahrealtyadvisors.com</a><br /><br />';
		break;
	case 'michael':
		$broker = '<strong>Michael Sintzel</strong><br />Office: 314-773-1700 x307<br />Cell: 618-567-9083<br /><a class="emailButton greenTitle" href="javascript:;">mike@ahrealtyadvisors.com</a><br /><br />';
		break;
	default:
		$broker = 'Error';
}
// Parse secondBrokerTemp
switch ($secondBrokerTemp) {
	case 'none':
		$secondBroker = '';
		break;
	case '':
		$secondBroker = '';
		break;
	case 'jorge':
		$secondBroker = '<strong>Jorge Andrade</strong><br /><a class="emailButton greenTitle" href="javascript:;">jorge@ahrealtyadvisors.com</a><br /><br />';
		break;
	case 'christian':
		$secondBroker = '<strong>Christian Andrade</strong><br />Office: 314-773-1700 x302<br />Cell: 314-775-4888<br /><a class="emailButton greenTitle" href="javascript:;">christian@ahrealtyadvisors.com</a><br /><br />';
		break;
	case 'rob':
		$secondBroker = '<strong>Rob Berneking</strong><br />Office: 314-773-1700 x303<br />Cell: 618-581-5312<br /><a class="emailButton greenTitle" href="javascript:;">rob@ahrealtyadvisors.com</a><br /><br />';
		break;
	case 'lorenzo':
		$secondBroker = '<strong>Lorenzo Andrade</strong><br />Office: 314-773-1700 x304<br />Cell: 314-922-4797<br /><a class="emailButton greenTitle" href="javascript:;">lorenzo@ahrealtyadvisors.com</a><br /><br />';
		break;
	case 'michael':
		$secondBroker = '<strong>Michael Sintzel</strong><br />Office: 314-773-1700 x307<br />Cell: 618-567-9083<br /><a class="emailButton greenTitle" href="javascript:;">mike@ahrealtyadvisors.com</a><br /><br />';
		break;
	default:
		$secondBroker = 'Error';
}



// ==================== Carousel Logic ======================

// Make an array out of the comma-delimited list of $images
$imagesArray = explode(',', $images);

// Only show the carousel if there is more than one image.
$carouselLength = count($imagesArray);
if ($carouselLength > 1) {
	$showCarousel = true;
} else {
	$showCarousel = false;
}

// If there are images, process them. Otherwise skip and load the no-image icon.
if ($images != "noImages") {

	// Create the carousel indicators and images
	$carouselIndicatorsTemp[0] = '<li data-target="#myCarousel" data-slide-to="0" class="active"></li>';
	$carouselImagesTemp[0] = '<div class="item active"><img data-src="holder.js/900x500/auto/#555:#5a5a5a/text:First slide" src="uploaded_images/' . stripslashes($imagesArray[0]) . '"  width="100%" height="auto"></img></div>';
	
	for ($i = 1; $i < $carouselLength; $i++) {
		$carouselIndicatorsTemp[$i] = '<li data-target="#myCarousel" data-slide-to="' . $i . '"></li>';
		$carouselImagesTemp[$i] = '<div class="item"><img data-src="holder.js/900x500/auto/#555:#5a5a5a/text:First slide" src="uploaded_images/' . stripslashes($imagesArray[$i]) . '"  width="100%" height="auto"></img></div>';
	}

	// Implode to convert array to string.
	$carouselIndicators = implode(' ', $carouselIndicatorsTemp);
	$carouselImages = implode(' ', $carouselImagesTemp);

} else {
	$noImages = true;
	$carouselImages = '<div class="item active"><a href="#"><img class="noImage" alt="No Image" data-src="holder.js/900x500/auto/#555:#5a5a5a/text:First slide" src="images/no-image.jpg" width="100%" height="auto"></img></a></div>';
}

// ==================== PDF Logic ======================
// Make an array out of the comma-delimited list of $pdf
$pdfArray = explode(',', $pdf);

// Only show the carousel if there is more than one image.
$pdfArrayLength = count($pdfArray);
// If there are pdf(s), create the links. Otherwise show the no-pdf image.
if ($pdf != "noPDF") {
	// Create the array to hold the pdf links
	// We know there will be at least 1 pdf if it got this far.
	$pdfLinkTemp[0] = '<a href="uploaded_pdfs/' . stripslashes($pdfArray[0]) . '" target="_blank"><img src="images/acrobat_icon.jpg" width="85" height="85" /></a>';
	
	// Loop over the pdf array and add those to the link array if there are more than 1
	for ($i = 1; $i < $pdfArrayLength; $i++) {
		// Create the pdf link
		$pdfLinkTemp[$i] = '<a href="uploaded_pdfs/' . stripslashes($pdfArray[$i]) . '" target="_blank"><img src="images/acrobat_icon.jpg" width="85" height="85" /></a>';
	}

	// Implode to convert array to string.
	$pdfLink = implode(' ', $pdfLinkTemp);
} else {
	$pdfLink = '<a href="#"><img class="noPDF" src="images/no-image.jpg" width="100" height="75" /></a>';
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

	<!-- Custom styles for this template -->
	<link href='css/default_carousel_page.css' rel='stylesheet'>
	<!-- styles needed by jScrollPane -->
	<link type="text/css" href="css/jquery.jscrollpane.css" rel="stylesheet" media="all" />

	<link href='css/index.css' rel='stylesheet'>

	<!-- Start Google ReCaptcha -->
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
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
				<li class="dropdown active">
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

	  <!-- Three columns of text below the carousel -->
	  <div class="row">
		<div class="col-md-12 mainInfo">
			<div class="row">
			  <div class="col-md-12 listingTitle centered bordered">
				<h2><strong><span class='greenTitle'><?php echo $address ?></span></strong></h2>
				<div class='plazaState'>
					<h3 class='plaza'><i><?php echo $plaza ?></i></h3>
					<span class='orangeState'><?php echo $state ?></span>
				</div>
			  </div>
			  <div class="col-md-7 col-sm-12 listingInfo">
				<div class="col-md-6 listing infoLeft">
					<h3><span class="orangeTitle">Classification:</span></h3>
					<h4><?php echo $classification ?></h4>
					<h3><span class="orangeTitle">Property Type:</span></h3>
					<h4><?php echo $propertyType ?></h4>
					<h3><span class="orangeTitle">Listed Price:</span></h3>
					<h4><strong><?php echo $price ?></strong></h4>
					<h3><span class="orangeTitle">Size Available:</span></h3>
					<h4><?php echo $sizeAvailable ?></h4>
					<h3><span class="orangeTitle">Total Size:</span></h3>
					<h4><?php echo $totalSize ?></h4>
				</div>
				<div class="col-md-6 listing infoRight">
					<h3><span class="orangeTitle">Pricing Type:</span></h3>
					<h4><?php echo $pricingType ?></h4>
					<h3><span class="orangeTitle">Contact:</span></h3>
					<h4><?php echo $broker ?></h4>
					<h4><?php echo $secondBroker ?></h4>
					<h3><span class="orangeTitle">Details:</span></h3>
					<?php echo $pdfLink ?>
				</div>
			  </div>
			  <div class='col-md-5 col-sm-12 listingImages'>
			  	<div class='well well-sm' id='myModalContent' data-carousel='<?php echo $showCarousel?>' data-noImages='<?php echo $noImages ?>'>

			  		<!-- Only show carousel if there is more than one image -->
					<?php if ($showCarousel) : ?>
						<!-- Carousel for thumbnail images ================================================== -->
						<div id="myCarousel" class="carousel slide listing" data-ride="carousel">
						  <!-- Indicators -->
						  <ol class="carousel-indicators">
							<?php echo $carouselIndicators ?>
						  </ol>
						  <div class="carousel-inner listing">
	
							<?php echo $carouselImages ?>
	
						  </div>
						  <a class="left carousel-control" href="#myCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
						  <a class="right carousel-control" href="#myCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
						</div><!-- /.carousel -->
	
					<?php else : ?>
			    	  <?php echo $carouselImages ?>
			    	<?php endif; ?>
			    </div>
			  </div>




			  <div class='col-md-12'>
			  	<!-- Google maps iframe -->
				<iframe class="border-rounded-5" style="border:1px solid #cccccc;padding:4px;margin-top:20px;" width="100%" height="500" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=<?php echo $mapsURL ?>&amp;ie=UTF8&amp;hq=&amp;hnear=<?php echo $mapsURL ?>&amp;output=embed"></iframe>
			  </div>
			</div>


		</div><!-- /.col-md-12 -->
	  </div><!-- /.row -->


	  <!-- MODAL FOR ENLARGED CAROUSEL IMAGES -->
	  <div class="modal fade modal-fullscreen force-fullscreen" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h3 class="modal-title greenTitle"><?php echo $address ?></h3>
		      </div>
		      <div class="modal-body">
		        <p>No Images Available</p>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
		      </div>
		    </div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		<!-- MODAL FOR SENDING EMAIL -->
      <div class="modal fade modal-fullscreen force-fullscreen" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="emailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3 class="modal-title"><strong>Information Request</strong></h3>
          </div>
          <div class="modal-body">
            <form class="contact" name="contact">
				<h3><label for="mailTo" class="orangeTitle">To:</label></h3>
				<h4><input type="text" id="mailTo" name="mailTo" class="form-control" value="" readonly="readonly"></h4>
				<h3><label for="mailSubject" class="orangeTitle">Concerning:</label></h3>
				<h4><input type="text" id="mailSubject" name="subject" class="form-control" value="<?php echo $address ?>" readonly="readonly"></h4>
				<h3><label for="mailName" class="orangeTitle">Your Name:</label></h3>
				<h4><input type="text" id="mailName" name="name" class="form-control"></h4>
				<h3><label for="mailEmail" class="orangeTitle">Your E-mail Address:</label></h3>
				<h4><input type="email" id="mailEmail" name="email" class="form-control"></h4>
				<h3><label for="mailMessage" class="orangeTitle">Enter a Message:</label></h3>
				<h4><textarea id="mailMessage" name="emailMessage" class="form-control" rows="3"></textarea></h4>
				<div class="g-recaptcha" data-sitekey="6LcPiQcTAAAAAIhpC38kOeQc1i8HQK2AyrMAee34"></div>
			</form>
          </div>
          <div class="modal-footer">
            <input class="btn btn-success" type="submit" value="Send" id="emailSubmit">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->

      <!-- Modal thanking user for sending email -->
      <div class="modal fade modal-fullscreen force-fullscreen" id="thanksModal" tabindex="-1" role="dialog" aria-labelledby="emailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
          <div class="modal-body">
            <span class="emailSuccessText"></span>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->


	  <br>
	  <br>

	  <!-- FOOTER -->
	  <footer>
		<p class="pull-right"><a href="privacy">Privacy</a></p>
		<p><h4><span class='greenTitle'>&copy; 2015 AH Realty Advisors, LLC.</span></p>
		<p><small>330 North Fourth Street, Suite 300, Saint Louis, MO  63102</small></p>
		<p><small>Hours:  Mon-Fri  8:30am - 5pm</small></h4></p>

		<!-- LOGIN LOGIC -->
		<?php if ($logged == "in") : ?>
			<div class="col-md-6 col-md-offset-3 loggedIn bordered">
			<p>Welcome <?php echo htmlentities($_SESSION['username']); ?>!</p>
			<p><a href="adminListing?id=<?php echo $id?>" class="loginButton">Edit This Listing</a></p>
			<p><a href="adminProperties.php" class="loginButton">Edit Listings Page</a></p>
			<p><a href="adminPanel.php" class="loginButton">Admin Panel</a></p>
			<p><a href="includes/logout" class="loginButton">Log Out</a></p>
			</div>
		<?php else : ?>
			<p><a href="login.php">Login</a></p>
		<?php endif; ?>
	  </footer>

	</div><!-- /.container -->


	<!-- Bootstrap core JavaScript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="scripts/jquery-1.11.2.min.js"></script>
	<script src="scripts/bootstrap.js"></script>
	<script src="scripts/bootstrap-modal-carousel.min.js"></script>
	<script src="scripts/jquery.animate-enhanced.js"></script>
	<script src="scripts/fuse.min.js"></script>
	<script src="scripts/listing.js"></script>
	<script src="scripts/search.js"></script>
	<!--<script src="scripts/tap.js"></script>-->

	<!-- the mousewheel plugin - optional to provide mousewheel support for jscrollpane -->
	<script type="text/javascript" src="scripts/jquery.mousewheel.js"></script>

	<!-- the jScrollPane script -->
	<script type="text/javascript" src="scripts/jquery.jscrollpane.min.js"></script>

	<script src="scripts/index.js"></script>
	<script src="scripts/email.js"></script>
  </body>
</html>
