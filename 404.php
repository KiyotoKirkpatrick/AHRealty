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
		<div class="navbar navbar-inverse navbar-fixed-top navbar-small" role="navigation">
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
			<div class="col-md-8">
				<h2 class='greenTitle centered bordered'><strong>Error 404</strong></h2>
				<p><h3 class='centered'><strong>The Requested Page Could Not Be Located</strong></h3></p>
			</div><!-- /.col-md-8 -->
			<div class="col-md-4 featuredProperties well well-sm">
				<h3 class='orangeTitle centered'>Featured Properties</h3>
				<div class='featuredListingsHolder'>
					<ul class='featuredListings'>
					</ul>
				</div>
			</div><!-- /.col-md-4 -->
		</div><!-- /.row -->


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
	<script src="scripts/featuredListings.js"></script>
	<script src="scripts/index.js"></script>
  </body>
</html>
