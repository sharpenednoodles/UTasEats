<!--KIT202 Assignment 2 - Bryce Andrews 204552-->
<?php
session_start();
//Get variables from POST
include("res/php/userAccessLevel.php");
include("res/db/dbConn.php");
include("res/db/dbQueries.php");
include("res/php/accountDetails.php");



//If we are not logged in, redirect us to an error page
if ($_SESSION['loggedIn'] == false)
{
	header('location: index.php');
}

//TODO move this to dependacy file
//move welcome information to seperate page
$welcomeBanner = welcomeBanner();
$welcomeMessage = welcomeMessage($_SESSION['accessLevel']);

//Give the user a interesting welcome
function welcomeBanner()
{
	$welcomeWords = array("Welcome", "Salutations", "Bonjour", "Hello", "G'Day", "Guten Tag", "Buona Giornata", "Yoi Tsuitachi", "M'athchomaroon", "Hey", "Good to see you", "Hi", "Howdy","Sup", "Hiya");
	return $welcomeWords[rand(0,sizeof($welcomeWords)-1)];
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<title><?php echo($_SESSION["userID"]. "'s Account") ?></title>
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
			<h1 class="display-4"><?php echo("$welcomeBanner, " .$_SESSION['firstName']) ?>!</h1>
			<p class="lead">Page Under Construction</p>
			<p><?php echo($welcomeMessage) ?></p>
		</div>
		<div class="row">
			<?php

			//TODO fix this
			//Display new user card for newly generated users
			if($_SESSION['newAccount'] == true && ($_SESSION['newID'] == $_SESSION['userID']))
			{
				$_SESSION['newAccount'] = false;
				echo <<<NEWUSER
				<div class="col-sm-12 col-md-12">
					<div class="card mb-4">
						<div class="card-body text-center">
							<h5 class=card-title>New Account Created</h5>
							<p class="card-text">You will need your userID
NEWUSER;
				echo(" <b>".$_SESSION['newID']."</b> ");
				echo <<<NEWUSER
						to log in for future uses. </p>
						<p>$5 AUD credit has been added to your account as a thank you for registering!</p>
					</div>
				</div>
			</div>
NEWUSER;
			}
			switch((int)$_SESSION['accessLevel'])
			{
				case UserAccessLevel::BoardDirector:
				//specific includes just for board director
				require("res/php/boardMemberSecurityCard.php");
				case UserAccessLevel::BoardMember:
				//specific includes for board memebers
				require("res/php/cafeManagerSecurityCard.php");
				require("res/php/masterListCard.php");
				break;
				case UserAccessLevel::CafeManager:
				require("res/php/masterListCard.php");
				case UserAccessLevel::CafeStaff:
				require("res/php/rosterCard.php");
				break;
				case UserAccessLevel::UserStudent:
				case UserAccessLevel::UserStaff:
				require("res/php/menuCards.php");
				break;
			}
			 ?>
			</div>
			<div class="row">
			<div class="col-sm-12 col-md-4">
				<div class="card mb-4">
					<div class="card-body text-center">
						<h5 class=card-title>Debug: PHP Vars Info</h5>
						<p class="card-text">
						<?php
						echo("User name: ".$_SESSION['userID'] ."<br>");
						echo("First Name: ".$_SESSION['firstName'] ."<br>");
						echo("Last Name: ".$_SESSION['lastName'] ."<br>");
						echo("UserAccess level: ".$_SESSION['accessLevel']);
						 ?>
						</p>
					</div>
				</div>
			</div>
			<div class="col-sm-12 col-md-4">
				<div class="card mb-4">
					<div class="card-body text-center">
						<h5 class=card-title>Debug: Session Variable Contents</h5>
						<p class="card-text">
						<?php
						print_r($_SESSION);
						 ?>
						</p>
					</div>
				</div>
			</div>
			<div class="col-sm-12 col-md-4">
				<div class="card mb-4">
					<div class="card-body text-center">
						<h5 class=card-title>Debug: Post Variable Contents</h5>
						<p class="card-text">
						<?php
						print_r($_POST);
						 ?>
						</p>
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
	//For proper appearance where no php is available, ie my text editor
		$(function() {
			if (!document.location.host) {
				//Load our dependencies via Javascript if no PHP is available
  			$("#navAJAX").load("navbar.html");
				$("#footerAJAX").load("footer.html");
				}
			});


	</script>

	</body>
</html>
