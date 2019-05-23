<!--KIT202 Assignment 2 - Bryce Andrews 204552-->
<?php
//Display DEBUG cards on page
$debug = false;

session_start();
//Get variables from POST
include("res/php/userAccessLevel.php");
include("res/db/dbConn.php");
include("res/db/dbQueries.php");
include("res/php/generateTable.php");
include("res/php/accountDetails.php");
require("res/php/cafeDetails.php");

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
	$welcomeWords = array("Welcome", "Salutations", "Bonjour", "Hello", "G'Day", "Guten Tag", "Buona Giornata", "Yoi Tsuitachi", "M'athcho maroon", "Hey", "Good to see you", "Hi", "Howdy","Sup", "Hiya");
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
			<!--
			<p class="lead">Page Under Construction</p>
			<p><?php //echo($welcomeMessage) ?></p>
		-->
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
			?>

			<div class="col-md-12">
				<div class="card mb-4">
					<div class="card-body">


					<div class="row">
					  <div class="col-lg-3 col-md-3 col-12-sm mb-4">
					    <div class="nav flex-column nav-pills" role="tablist">
					      <a class="nav-link active" data-toggle="pill" href="#home-pill" role="tab">Home</a>
								<a class="nav-link" data-toggle="pill" href="#profile-pill" role="tab">My Profile</a>
					      <a class="nav-link" data-toggle="pill" href="#order-pill" role="tab">My Orders</a>
								<a class="nav-link" data-toggle="pill" href="#funds-pill" role="tab">Add Funds</a>
								<?php
								switch((int)$_SESSION['accessLevel'])
								{
									case userAccessLevel::BoardDirector:
									case userAccessLevel::BoardMember:
									case userAccessLevel::CafeManager:
									echo "<a class='nav-link' data-toggle='pill' href='#manageOrder-pill' role='tab'>Manage Orders</a>";
									echo "<a class='nav-link' data-toggle='pill' href='#manageUsers-pill' role='tab'>Manage Accounts</a>";
									echo "<a class='nav-link' data-toggle='pill' href='#manageStaff-pill' role='tab'>Manage Staff</a>";
									echo "<a class='nav-link' data-toggle='pill' href='#manageShifts-pill' role='tab'>Manage Shifts</a>";
									echo "<a class='nav-link' data-toggle='pill' href='#manageCafes-pill' role='tab'>Manage Cafes</a>";
									case userAccessLevel::CafeStaff:
									echo "<a class='nav-link' href='masterList.php' role='tab'>Manage Menus</a>";
									echo "<a class='nav-link' data-toggle='pill' href='#viewShifts-pill' role='tab'>View Shifts</a>";
									break;
								}
								 ?>
					    </div>
					  </div>
					  <div class="col-lg-9 col-md-9 col-sm-12">
					    <div class="tab-content">
					      <div class="tab-pane fade show active" id="home-pill" role="tabpanel">
									<div class="row no-gutters">
								    <div class="col">
							        <h4><?php echo $_SESSION['firstName'] ." ".$_SESSION['lastName']; ?></h4>
											<p><small class="text-muted">
												<?php
												echo getUserRole($_SESSION['accessLevel']);
												//Display the resturant if person works as a manager, or cafe staff
												switch((int)$_SESSION['accessLevel'])
												{
													case UserAccessLevel::CafeManager:
													case UserAccessLevel::CafeStaff:
													echo " - ".$_SESSION["cafeEmployment"];
													break;
												}
												?>
											</small></p>
							        <p class="card-text"><?php echo($welcomeMessage) ?></p>
								    </div>
										<div class="col-md-3">
											<img src="<?php echo $_SESSION['profilePicture'];?>" class="card-img" alt="">
										</div>
								  </div>
								</div>
								<div class="tab-pane fade" id="profile-pill" role="tabpanel">
									<?php require("res/php/manageProfilePill.php") ?>
								</div>
					      <div class="tab-pane fade" id="order-pill" role="tabpanel">
									<?php require("res/php/myOrdersPill.php") ?>
								</div>
					      <div class="tab-pane fade" id="funds-pill" role="tabpanel">
									<?php require("res/php/manageFundsPill.php") ?>
								</div>
								<?php
								switch((int)$_SESSION['accessLevel'])
								{
									case userAccessLevel::BoardDirector:
									case userAccessLevel::BoardMember:
									case userAccessLevel::CafeManager:
									echo <<<FIRSTTAB
								<div class="tab-pane fade" id="manageOrder-pill" role="tabpanel">
FIRSTTAB;
									require("res/php/manageOrdersPill.php");
								echo <<<FIRSTTAB
								</div>
								<div class="tab-pane fade" id="manageUsers-pill" role="tabpanel">
FIRSTTAB;
									require("res/php/manageUsersPill.php");
									echo <<<FIRSTTAB
								</div>
								<div class="tab-pane fade" id="manageStaff-pill" role="tabpanel">
FIRSTTAB;
								require("res/php/manageStaffPill.php");
								echo <<<FIRSTTAB
								</div>
								<div class="tab-pane fade" id="manageShifts-pill" role="tabpanel">
									<h4>Manage Shifts</h4>
									<p>Functionality unimplemented</p>
								</div>
								<div class="tab-pane fade" id="manageCafes-pill" role="tabpanel">
									<h4>Manage Cafes</h4>
FIRSTTAB;
									echo "<p>Functionality unimplemented</p>";
									echo <<<FIRSTTAB
								</div>
FIRSTTAB;
								case UserAccessLevel::CafeStaff:
								echo <<<SECCONDTAB
								<div class="tab-pane fade" id="viewShifts-pill" role="tabpanel">
									<h4>View Shifts</h4>
									<p>You have no upcoming shifts.</p>
								</div>
SECCONDTAB;
							break;
						}
						?>
					    </div>
					  </div>
					</div>
					</div>
				</div>
			</div>
			<?php
			require("res/php/menuCards.php");
			 ?>
			</div>
			<?php
			if ($debug == true)
			{
				echo <<<DEBUG
				<div class="row">
				<div class="col-sm-12 col-md-4">
					<div class="card mb-4">
						<div class="card-body text-center">
							<h5 class=card-title>Debug: PHP Vars Info</h5>
							<p class="card-text">
DEBUG;
							echo("User name: ".$_SESSION['userID'] ."<br>");
							echo("First Name: ".$_SESSION['firstName'] ."<br>");
							echo("Last Name: ".$_SESSION['lastName'] ."<br>");
							echo("UserAccess level: ".$_SESSION['accessLevel']);
							echo <<<DEBUG
							</p>
						</div>
					</div>
				</div>
				<div class="col-sm-12 col-md-4">
					<div class="card mb-4">
						<div class="card-body text-center">
							<h5 class=card-title>Debug: Session Variable Contents</h5>
							<p class="card-text">
DEBUG;
							print_r($_SESSION);
							 echo <<<DEBUG
							</p>
						</div>
					</div>
				</div>
				<div class="col-sm-12 col-md-4">
					<div class="card mb-4">
						<div class="card-body text-center">
							<h5 class=card-title>Debug: Post Variable Contents</h5>
							<p class="card-text">
DEBUG;
							print_r($_POST);
							echo <<<DEBUG
							</p>
						</div>
					</div>
				</div>
			</div>
DEBUG;
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
	<script src="js/rechargeFunds.js"></script>
	<script src="js/editStaff.js"></script>
	<script src="js/editUsers.js"></script>
	<script src="js/manageOrder.js"></script>
	<script src="js/buildMenuDropDown.js"></script>
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
