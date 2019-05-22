<!--KIT202 Assignment 2 - Bryce Andrews 204552-->
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

		<title>UTASEats Authentication</title>
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
	<div class="container">

	<div class="jumbotron border">
		<h1>Sign In</h1>
		<p class=lead>Sign into your Y.E.O.M./UTasEats Account below.<p/>
		<p>If you do not have an account you may register one <a href="registration.php">here</a></p>
	</div>

<div class="row justify-content-md-center">

	<?php
	if($_SESSION['newAccount'] == true)
	{
		require("res/php/newUserCard.php");
	}
	if($_SESSION['loggedIn'] == false)
	{
		require("res/php/loginCard.php");
	}
	else
	{
		//The user is already logged in - display a card to handle this
		echo <<<ERROR
		<div class="col-sm-12 col-md-4">
			<div class="card mb-4">
				<div class="card-body text-center">
					<h5 class=card-title>You are already logged in!</h5>
					<p class="card-text">Please log out before trying to log back in again.</p>
					<form class="" action="res/php/logout.php" method="post">
						<button class="btn btn-dark" type="submit" name="button">Log Out</button>
					</form>
				</div>
			</div>
		</div>
ERROR;
	}
	 ?>
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

	<!--
	<script type="text/javascript" src="js/navbar.js"></script>
-->
	<script>
	//
		$(function() {
			if (!document.location.host) {
				//Load our dependencies via Javascript if no PHP is available
  			$("#navAJAX").load("navbar.html");
				$("#footerAJAX").load("footer.html");
				}
			});

	</script>
	<script type="text/javascript" src="js/loginVerification.js"></script>


	</body>
</html>
