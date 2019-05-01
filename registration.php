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
			<p>Register a new account below. This service is only available to current UTAS Staff and Students.</p>
		</div>

		<div class="row">
			<div class="col-sm-12 col-md-12">
				<div class="card mb-4">
				  <div class="card-body">
				    <h5 class="card-title text-center">Registration</h5>


							<form action="res/php/registrationHandler.php" method="post" novalidate>



								<label>Your Details</label>
								<div class="form-row">
									<div class="form-group col-sm-12 col-md-6">
										<input class="form-control" type="text" name="firstName" placeholder="First Name" id="firstNameInput">
										<div class="invalid-feedback" id="invalidFirstName"></div>
									</div>
									<div class="form-group col-sm-12 col-md-6">
										<input class="form-control" type="text" name="lastName" placeholder="Last Name" id="lastNameInput">
										<div class="invalid-feedback" id="invalidLastName"></div>
									</div>
								</div>
								<div class="form-row mb-3">
								<div class="form-group col-sm-12 col-md-12">
									<div class="custom-control custom-radio custom-control-inline">
										<input class="custom-control-input" type="radio" name="inlineRadioGender" id="maleRadio1" value="male">
										<label class="custom-control-label" for="maleRadio1">Male</label>
									</div>
									<div class="custom-control custom-radio custom-control-inline">
										<input class="custom-control-input" type="radio" name="inlineRadioGender" id="femaleRadio2" value="female">
										<label class="custom-control-label" for="femaleRadio2">Female</label>
									</div>
									<div class="custom-control custom-radio custom-control-inline">
										<input class="custom-control-input" type="radio" name="inlineRadioGender" id="otherRadio3" value="other">
										<label class="custom-control-label" for="otherRadio3">Unspecified</label>
									</div>
									</div>
								</div>



								<label>Account Information</label>
									<div class="form-row">
										<div class="form-group col-sm-12 col-md-6">
										<input class="form-control" type="text" name="IDNumber" placeholder="Student/Staff ID Number" id="IDNumberInput">
										<div class="invalid-feedback" id="invalidIDNumber"></div>
									</div>
								</div>
									<div class="form-row mb-3">
									<div class="form-group col-sm-12 col-md-12">
										<div class="custom-control custom-radio custom-control-inline">
										  <input class="custom-control-input" type="radio" name="inlineRadioAccountType" id="studentRadio1" value="student">
										  <label class="custom-control-label" for="studentRadio1">UTAS Student</label>
										</div>
										<div class="custom-control custom-radio custom-control-inline">
										  <input class="custom-control-input" type="radio" name="inlineRadioAccountType" id="staffRadio2" value="staff">
										  <label class="custom-control-label" for="staffRadio2">UTAS Staff</label>
										</div>
										</div>
									</div>

									<label>Email Address</label>
									<div class="form-row">


									<div class="input-group col-md-6 col-sm-12 mb-4">
										<div class="input-group-prepend">
						          <span class="input-group-text" id="inputGroupPrepend">@</span>
						        </div>
										<input class="form-control" type="email" name="emailAddress" placeholder="Enter Email Address" id="emailInput">
										<div class="invalid-feedback" id="invalidEmail"></div>
									</div>
									</div>

									<label>Password</label>
									<div class="form-row">


									<div class="form-group col-md-6 col-sm-12">
										<input class="form-control" type="password" name="password" placeholder="Password" id="userPasswordInput">
										<div class="invalid-feedback" id="invalidPassword"></div>
									</div>
								</div>
								<div class="form-row mb-3">
									<div class="form-group col-md-6 col-sm-12">
										<input class="form-control" type="password" name="passwordConfirm" placeholder="Confirm Password" id="userPasswordInputConfirm">
										<div class="invalid-feedback" id="invalidConfirmPassword"></div>
									</div>
									</div>

									<label>Payment Information</label>
									<div class="form-row mb-3">
									<div class="form-group col-md-6 col-sm-12">

										<input class="form-control" type="text" name="CCName" placeholder="Name on Credit Card" id="CCNameInput">
										<div class="invalid-feedback" id="invalidCCName"></div>
									</div>
									<div class="form-group col-md-3 col-sm12">
										<input class="form-control" type="text" name="CCNumber" placeholder="Credit Card Number" id="CCNumberInput">
										<div class="invalid-feedback" id="invalidCCNumber"></div>
									</div>
									<div class="form-group col">
										<input class="form-control" type="text" name="CVC" placeholder="CVC" id="CVCInput">
										<div class="invalid-feedback" id="invalidCVC"></div>
									</div>
									<div class="form-group col">
										<input class="form-control" type="text" name="CCExp" placeholder="CC Expiry" id="CCExpInput">
										<div class="invalid-feedback" id="invalidCCExp"></div>
									</div>
									</div>


									<!--TODO: Remember user details with cookies-->
									<div class="custom-control custom-checkbox mb-3">
										<input type="checkbox" id="rememberCheck" class="custom-control-input">
										<label for="rememberCheck" class="custom-control-label">I accept the <a href="#termsAndConditionsModal"
											data-target="#termsAndConditionsModal" data-toggle="modal">terms and conditions</a></label>
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


<modal>
<div class="modal fade" id="termsAndConditionsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="termsAndConditionsModalTitle">Terms and Conditions</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<?php
					readfile("res/html/eula.html");
				 ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
</modal>
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
	<script type="text/javascript" src="js/registrationVerification.jss">

	</script>

	</body>
</html>
