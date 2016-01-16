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

	<!-- Start Google ReCaptcha -->
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
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
				<li class="active"><a href="team">Team</a></li>
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
			<h2 class='greenTitle centered bordered'><strong>The AH Realty Advisors Team</strong></h2>
			<div class='content'>
				<p><h3 class='orangeTitle'><i>Jorge Andrade <small>| Principal</small></i></h3></p>
				<h5><p><a class='emailButton greenTitle' href="javascript:;">jorge@ahrealtyadvisors.com</a></p>
				<p>Jorge Andrade has been active in real estate since 2001. Prior to his involvement in real estate, Jorge was the chief operating officer of a manufacturing company in Central Illinois. Jorge is active in the analysis and acquisition of investment opportunities as well as the strategic management of the company. He holds both a Bachelors and Masters in Business Administration from Missouri State University.</p></h5>
		
				<p><h3 class='orangeTitle'><i>Christian Andrade <small>| Managing Broker & Principal</small></i></h3></p>
				<h5><p><i>314-773-1700 x302</i><a class="pull-right" href="http://www.linkedin.com/pub/christian-andrade/38/964/87b" target="_blank" ><img border="0" src="images/linkedin-logo.jpg" width="70" height="24" alt="Follow Christian Andrade on LinkedIn" title="Follow Christian Andrade on LinkedIn" /></a>
				<br><a class='emailButton greenTitle' href="javascript:;">christian@ahrealtyadvisors.com</a></p>
				<p>Christian Andrade is the managing broker and principal of AH Realty Advisors and handles the day-to-day management of the company. Christian has been active in real estate since 2002. Initially, he worked as a commercial real estate lender for Colonial Bank (now BB&T) in Birmingham, Alabama. At the bank, he focused on construction and mini-permanent financing of multifamily, retail and office properties. Later he formed AH Realty Advisors, LLC and Andrade Holdings, LLC with Jorge Andrade in order to pursue real estate brokerage, property management, and investments. He holds a real estate license in Missouri and Illinois.  He is also a  member of the REALTORS Association of Southwestern Illinois.  Christian graduated magna cum laude from Vanderbilt University with majors in Economics and Philosophy. He is also a member of honor society Phi Beta Kappa.</p></h5>
		
				<p><h3 class='orangeTitle'><i>Rob Berneking <small>| Principal</small></i></h3></p>
				<h5><p><i>314-773-1700 x303</i><a class="pull-right" href="http://www.linkedin.com/pub/rob-berneking/9/114/245" target="_blank" ><img border="0" src="images/linkedin-logo.jpg" width="70" height="24" alt="Follow Rob Berneking on LinkedIn" title="Follow Rob Berneking on LinkedIn" /></a>
				<br><a class='emailButton greenTitle' href="javascript:;">rob@ahrealtyadvisors.com</a></p>
				<p>Rob Berneking is a Principal of AH Realty Advisors, LLC.  He is a licensed broker in both Illinois and Missouri and has been working in real estate since 2003. He handles much of the brokerage business for the company and is also extensively involved in management, development, and construction operations. Prior to the formation AHRA, Rob was a broker with the Kenneth Johnson Agency (now Johnson Properties) in Swansea, IL and previously the manager of Strano Commercial Group, a company which he co-founded in 2004. Rob has completed hundreds of lease and sale transactions covering the entire St. Louis Metropolitan Area. His transactions range from retail and office leases to the sale of large multi-family and industrial properties. Rob also assists in the management of nearly 120,000 sq. ft. of retail space. He has received several awards for his work over the years including the Largest Commercial Sale Award for 2005 from the Realtors Association of Southwestern Illinois and was named a "Rising Star" in 2006 by the Illinois Business Journal. Rob earned a Bachelors of Business Administration with a concentration in Finance from the John Cook School of Business at Saint Louis University.</p></h5>
		
				<p><h3 class='orangeTitle'><i>Lorenzo Andrade <small>| Advisor</small></i></h3></p>
				<h5><p><i>314-773-1700 x304</i><a class="pull-right" href="http://www.linkedin.com/pub/lorenzo-andrade/3/591/a51/" target="_blank" ><img border="0" src="images/linkedin-logo.jpg" width="70" height="24" alt="Follow Lorenzo Andrade on LinkedIn" title="Follow Lorenzo Andrade on LinkedIn" /></a>
				<br><a class='emailButton greenTitle' href="javascript:;">lorenzo@ahrealtyadvisors.com</a></p>
				<p>Lorenzo Andrade is an Advisor with AH Realty Advisors, LLC specializing in retail, office, and investment real estate along with the sales of exclusive residential properties.  Prior to joining AH Realty Advisors, LLC, Lorenzo owned and operated two retail businesses.  Before he began his work as an entrepreneur, Lorenzo worked in the film industry first in film development and later as an international film sales executive.  In 2005 he graduated with honors from The University of Chicago with a Bachelor of Arts in Psychology.</p></h5>
		
				<p><h3 class='orangeTitle'><i>Michael Sintzel <small>| Advisor</small></i></h3></p>
				<h5><p><i>314-773-1700 x307</i>
				<br><a class='emailButton greenTitle' href="javascript:;">mike@ahrealtyadvisors.com</a></p>
				<p>Michael Sintzel has been a licensed real estate salesperson for several years. He is licensed in both Illinois and Missouri. He has participated in numerous investment transactions. Michael specializes in residential buyer and seller representation as well as representation wihin the commerical and investment  real estate industry. Prior to joining AH Realty Advisors, he worked in the purchase, sale, and rehabilitation of residential and multi-family properties in both Missouri and Illinois. Michael is still active in real estate investment.  Michael has a BA in Business Administration with a concentration in Finance from Fontbonne University.  Michael is a member of the National Association of REALTORS, the Illinois Association of REALTORS, and the REALTOR Association or Southwestern Illinois.</p></h5>
		
				<p><h3 class='orangeTitle'><i>Misti Andrade <small>| Marketing</small></i></h3></p>
				<h5><p><a class='emailButton greenTitle' href="javascript:;">misti@ahrealtyadvisors.com</a></p>
				<p>Misti Andrade provides all of the marketing materials and property advertising at AHRA. Prior to joining AHRA, she held graphic artist positions at Auburn University at Montgomery, Alabama National Guard and Enterprise Rent-A-Car. Misti graduated from Auburn University in 2004 where she majored in graphic design. She is also active in Junior Service in Belleville, Illinois.</p></h5>
			</div>
		</div><!-- /.col-md-8 -->
		<div class="col-md-4 featuredProperties well well-sm">
		  <h3 class='orangeTitle centered'>Featured Properties</h3>
		  <div class='featuredListingsHolder'>
			<ul class='featuredListings'>
			</ul>
		  </div>
		</div><!-- /.col-md-4 -->
	  </div><!-- /.row -->

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
				<h4><input type="text" id="mailSubject" name="subject" class="form-control" value=""></h4>
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
  <script src="scripts/email.js"></script>
  </body>
</html>
