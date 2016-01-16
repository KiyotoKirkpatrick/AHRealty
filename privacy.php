<?php
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';

sec_session_start();

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

	<!-- Custom styles for this template -->
	<link href='css/default_carousel_page.css' rel='stylesheet'>
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
					<li><a href="properties?sort=commercial">Commercial</a></li>
					<li><a href="properties?sort=residential">Residential</a></li>
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
		<div class="row mainInfo">
		<div class="col-md-12">
			<div class="row">
				<div class='col-md-12'>
					<h2 class='greenTitle centered bordered'><strong>Privacy Policy</strong></h2>
				</div><!-- /.col-md-8 -->
				<div class="col-md-8 col-md-offset-2">
					<div class='content'>
							<h2>This privacy policy discloses the privacy practices for AH Realty Advisors.</h2>
							<br><h4>This privacy policy applies solely to information collected by this web site.
							<br>It will notify you of the following:</h4>
							<br>
						<h4>1. What personally identifiable information is collected from you through the web site, how it is used and with whom it may be shared.
						<br>2. What choices are available to you regarding the use of your data.
						<br>3. The security procedures in place to protect the misuse of your information.
						<br>4. How you can correct any inaccuracies in the information.</h4>
						<br>
						<h3><br>Information Collection, Use, and Sharing</h3>
						We are the sole owners of the information collected on this site. We only have access to/collect information that you voluntarily give us via email or other direct contact from you. We will not sell or rent this information to anyone.
						<br>
						<br>We will use your information to respond to you, regarding the reason you contacted us. We will not share your information with any third party outside of our organization, other than as necessary to fulfill your request, e.g. to ship an order.
						<br>
						<br>Unless you ask us not to, we may contact you via email in the future to tell you about specials, new products or services, or changes to this privacy policy.
						<br>
						<h3><br>Your Access to and Control Over Information</h3>
						You may opt out of any future contacts from us at any time.
						<br>You can do the following at any time by contacting us via the email address or phone number given on our website:
						<br>
						<br>   • See what data we have about you, if any.
						<br>
						<br>   • Change/correct any data we have about you.
						<br>
						<br>   • Have us delete any data we have about you.
						<br>
						<br>   • Express any concern you have about our use of your data.
						<br>
						<br>
						<h3>Cookies</h3>
						We use "cookies" on this site. A cookie is a piece of data stored on a site visitor's hard drive to help us improve your access to our site and identify repeat visitors to our site.<br>Cookies can enable us to track and target the interests of our users to enhance the experience on our site.<br>Usage of a cookie is in no way linked to any personally identifiable information on our site. 
						<br>
						<h3><br>Security</h3>
						We take precautions to protect your information. When you submit sensitive information via the website, your information is protected both online and offline.
						<br>
						<br>Wherever we collect sensitive information, that information is encrypted and transmitted to us in a secure way. You can verify this by looking for a closed lock icon at the bottom of your web browser, or looking for "https" at the beginning of the address of the web page.
						<br>
						<br>While we use encryption to protect sensitive information transmitted online, we also protect your information offline. Only employees who need the information to perform a specific job (for example, customer service) are granted access to personally identifiable information. The computers/servers in which we store personally identifiable information are kept in a secure environment.
						<br>
						<h3><br>Updates</h3>
						<br>Our Privacy Policy may change from time to time and all updates will be posted on this page.
						<br>
						<br>If you feel that we are not abiding by this privacy policy, you should contact us immediately.
						<br>
					</div>
				</div><!-- /.col-md-8 -->
			</div><!-- /.row -->
		</div><!-- /.col-md-12 -->
		</div><!-- /.row -->


		<br>
		<br>

		<!-- FOOTER -->
		<footer>
			<p class="pull-right"><a href="privacy">Privacy</a></p>
			<p><h4><span class='greenTitle'>&copy; 2015 AH Realty Advisors, LLC.</span></p>
			<p><small>330 North Fourth Street, Suite 300, Saint Louis, MO   63102</small></p>
		<p><small>Hours:  Mon-Fri  8:30am - 5pm</small></h4></p>
		<!-- LOGIN LOGIC -->
		<?php if ($logged == "in") : ?>
			<div class="col-md-6 col-md-offset-3 loggedIn bordered">
			<p>Welcome <?php echo htmlentities($_SESSION['username']); ?>!</p>
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
		<script src="scripts/jquery.animate-enhanced.js"></script>
		<script src="scripts/fuse.min.js"></script>
		<script src="scripts/search.js"></script>
		<!--<script src="scripts/tap.js"></script>-->

		<!-- the mousewheel plugin - optional to provide mousewheel support for jscrollpane -->
		<script type="text/javascript" src="scripts/jquery.mousewheel.js"></script>

		<!-- the jScrollPane script -->
		<script type="text/javascript" src="scripts/jquery.jscrollpane.min.js"></script>

		<!-- Load the featured listings. -->
		<script src="scripts/index.js"></script>
	</body>
</html>
