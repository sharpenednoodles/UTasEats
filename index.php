<!--KIT202 Assignment 1 - Bryce Andrews 204552-->
<?php
	session_start();
	require("res/php/userAccessLevel.php");
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<title>Y.E.O.M. Home - UTasEats</title>
		<!--Include Bootstrap CDN-->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="css/override.css">
		<?php readfile("metaIncludes.html"); ?>

	</head>
	<body Class="page-body">
	<header>
	<?php
		//Include our navbar html file
		//Use navAJAX div to load dependencies in non PHP environments
		require("navbar.php");
	?>
	<div class ="container-full" id="navAJAX"></div>
	</header>

	<main class="site-content">
		<?php  echo ( $msg ); ?>
	<div class="container">
		<div class="jumbotron border text-light text-center splash" id="splashHome">
			<h1 class="display-4">Y.E.O.M.</h1>
			<p class="lead">Your Excellent On-time meals. Now available at UTAS Sandy Bay Campus.</p>
			<hr class="my-4">
			<p>Website Under Construction.</p>
			<div class="text-center">
				<a href="registration.php">
					<p class="btn btn-outline-light btn-lg" role="button">Get Started</p>
				</a>
				<h1><i class="material-icons">keyboard_arrow_down</i></h1>
			</div>
		</div>
		<!--Fancy Cards. mb refers to Bootstraps margin system. Here it is marging bottom, with space 4-->
		<!--col-sm and col-md describe how much space in the grid an element should take up based on screen size
				The full span of a grid takes up 12 elements-->
		<div class="row">
			<div class="col-sm-12 col-md-4">
				<div class="card mb-4">
					<div class="card-body text-center">
						<h5 class=card-title>Select</h5>
						<p class="card-text">Choose food or drinks from any on campus cafe or restaurant.</p>
						<a class="card-link" href="menuList.php">See Menus</a>
					</div>
				</div>
			</div>
			<div class="col-sm-12 col-md-4">
				<div class="card mb-4">
					<div class="card-body text-center">
						<h5 class=card-title>Order</h5>
						<p class="card-text">Order and pay instantly from your Y.E.O.M. prepaid account.</p>
						<a class="card-link" href="registration.php">Create Account</a>
					</div>
				</div>
			</div>
			<div class="col-sm-12 col-md-4">
				<div class="card mb-4">
					<div class="card-body text-center">
						<h5 class=card-title>Pick-Up</h5>
						<p class="card-text">Pick up your order once it's ready. No waiting in lines.</p>
						<a class="card-link" href="#">View Locations</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
<footer>
	<?php
		//Include our navbar html file
		//Use navAJAX div to load dependencies in non PHP environments
		readfile("footer.html");
	?>
	<div class ="container-full" id="footerAJAX"></div>
</footer>

	<!--Include JQuery, popper and bootstrap-->
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
	<script src="https://cdnjs.buttflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<!--
	<script type="text/javascript" src="js/navbar.js"></script>
-->

	<script>
		$(function() {
			if (!document.location.host) {
				//Load our dependencies via Javascript if no PHP is available
  			$("#navAJAX").load("navbar.html");
				$("#footerAJAX").load("Footer.html");
				}
			});
	</script>

	</body>
</html>
