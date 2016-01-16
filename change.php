<?php
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';
include_once '../includes/change.inc.php';

// Our custom secure session creation.
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

	<script type="text/JavaScript" src="js/sha512.js"></script>
	<script type="text/JavaScript" src="js/forms.js"></script>
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
					<h2 class='greenTitle centered bordered'><strong>Password Change</strong></h2>
				</div><!-- /.col-md-8 -->
				<div class="col-md-6 col-md-offset-3">
					<div class='content'>

						<?php if ($logged == "in") : ?>

							<!-- Registration form to be output if the POST variables are not
							set or if the registration script caused an error. -->
							<h1><span class="orangeTitle">To Change your Password:</span></h1>
							<ul>
								<li>Passwords must be at least 6 characters long</li>
								<li>Passwords must contain
									<ul>
										<li>At least one upper case letter (A..Z)</li>
										<li>At least one lower case letter (a..z)</li>
										<li>At least one number (0..9)</li>
									</ul>
								</li>
								<li>Your password and confirmation must match exactly</li>
							</ul>
							<form method="post" name="change_form" action="">
								<!-- Pass the email to the form so we know whose password to change -->
								<input type='hidden' name='user_id' id='user_id' value="<?php echo htmlentities($_SESSION['user_id']); ?>"/>

								<h3><span class="orangeTitle">Current Password:</span></h3>
								<input type="password"
												 name="currentPassword"
												 id="currentPassword"/><br>
								<h3><span class="orangeTitle">New password:</span></h3>
								<input type="password"
												 name="password"
												 id="password"/><br>
								<h3><span class="orangeTitle">Confirm new password:</span></h3>
								<input type="password"
														 name="confirmpwd"
														 id="confirmpwd" /><br>
								<input type="button"
									   value="Change Password"
									   class="loginButton"
									   onclick="return changeformhash(this.form,
																	  this.form.currentPassword,
																	  this.form.password,
																	  this.form.confirmpwd);" />
							</form>
							<br>

							<div class="col-md-6 col-md-offset-3 loggedIn bordered">
							<p>Welcome <?php echo htmlentities($_SESSION['username']); ?>!</p>
							<p><a href="adminPanel.php" class="loginButton">Admin Panel</a></p>
							<p><a href="includes/logout" class="loginButton">Log Out</a></p>
							</div>

						<?php else : ?>
							<p>
								<span class="error">You are not authorized to access this page.</span> Please <a href="login.php">login</a>.
							</p>
						<?php endif; ?>
					</div>
				</div><!-- /.col-md-6 -->
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
