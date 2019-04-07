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

		<title>UTASEats Registration</title>
		<!--Include Bootstrap CDN-->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
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
		<div class="jumbotron border" style="background-image">
			<h1 class="display-4">Registration</h1>
			<p class="lead">Page Under Construction</p>
		</div>

		<div class="row">
			<div class="col-sm-12 col-md-12">
				<div class="card mb-4">
				  <div class="card-body">
				    <h5 class="card-title text-center">Registration</h5>


							<form action="userpage.php" method="post">
								<div class="form-group">
									<label for="userIDinput">Email Address</label>
									<input class="form-control" type="email" name="emailAddress" placeholder="Enter Email Address" id="emailInput">
									<div class="invalid-feedback" id="invalidEmail"></div>
								</div>
								<div class="form-group">
									<label for="userPasswordInput">Password</label>
									<input class="form-control" type="password" name="password" placeholder="Password" id="userPasswordInput">
									<div class="invalid-feedback" id="invalidPassword"></div>
								</div>
								<div class="form-group">
									<label for="userPasswordInput">Password Confirmation</label>
									<input class="form-control" type="password" name="passwordConfirm" placeholder="Password" id="userPasswordInputConfirm">
									<div class="invalid-feedback" id="invalidConfirmPassword"></div>
								</div>
								<!--TODO: Remember user details with cookies-->
								<div class="form-group form-check">
									<input type="checkbox" id="rememberCheck" class="form-check-input">
									<label for="rememberCheck" class="form-check-label">I accept the terms and conditions</label>
								</div>
								<button type="submit" class="btn btn-dark"name="button" id="registrationSubmitButton">Register</button>
							</form>



					</div>
					</div>
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

	<script>
		$(function() {
			if (!document.location.host) {
				//Load our dependencies via Javascript if no PHP is available
  			$("#navAJAX").load("navbar.html");
				$("#footerAJAX").load("footer.html");
				}
			});
	</script>
	<script type="text/javascript" src="js/registrationVerification.js">

	</script>

	</body>
</html>
