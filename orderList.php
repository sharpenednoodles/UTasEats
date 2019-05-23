<!--KIT202 Assignment 2 - Bryce Andrews 204552-->
<?php
session_start();
require("res/php/userAccessLevel.php");
include("res/db/dbConn.php");
include("res/db/dbQueries.php");
include("res/php/generateTable.php");
require("res/php/cafeDetails.php");

//Redirect user if insufficent privledges
switch((int)$_SESSION['accessLevel'])
{
	case userAccessLevel::UserStaff:
	case userAccessLevel::UserStudent:
	header('location: index.php');
	break;
}

 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<title>Order System</title>
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
		<?php
		switch((int)$_SESSION['accessLevel'])
		{
			case userAccessLevel::BoardDirector:
			case userAccessLevel::BoardMember:
			case userAccessLevel::CafeManager:
			echo "<h1>Master Order List</h1>";
			break;
			case userAccessLevel::CafeStaff:
			echo "<h1>".$_SESSION['cafeEmployment']." Order List</h1>";
			break;
		}
		 ?>
		<p class="lead">View all pending orders below</p>
	</div>
	<?php
	switch((int)$_SESSION['accessLevel'])
	{
		case userAccessLevel::BoardDirector:
		case userAccessLevel::BoardMember:
		case userAccessLevel::CafeManager:
			buildOrderCards($conn, $queryMasterOrders, false);
		break;
		case userAccessLevel::CafeStaff:
		if ($_SESSION['cafeEmployment'] == 'Lazenbys')
		{
			buildOrderCards($conn, $queryLazenbysOrders, false);
		}
		elseif ($_SESSION['cafeEmployment'] == 'Suzy Lee')
		{
			buildOrderCards($conn, $querySuzyLeeOrders, false);
		}
		elseif ($_SESSION['cafeEmployment'] == 'Trade Table')
		{
			buildOrderCards($conn, $queryTradeTableOrders, false);
		}
		break;
	}
	 ?>
	<form action="res/php/orderMarkingHandler.php" method="post" id="manageOrderForm"></form>

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
	<script src="js/manageOrder.js"></script>
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
	<script src="js/buildMenuDropDown.js"></script>
	</body>
</html>
