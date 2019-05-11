<!--KIT202 Assignment 2 - Bryce Andrews 204552-->
<?php
session_start();
require("res/php/userAccessLevel.php");
require("res/db/dbConn.php");
require("res/db/dbQueries.php");
require("res/php/generateTable.php");
require("res/php/cafeDetails.php");

$restaurant = "Trade Table";
$openTime = getOpenTime($conn, $restaurant);
$openTime = date("g:ia", strtotime($openTime));
$closeTime = getCloseTime($conn, $restaurant);
$closeTime = date("g:ia", strtotime($closeTime));
$description = getDescription($conn, $restaurant);
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<title><?php echo $restaurant;?> Menu</title>
		<!--Include Bootstrap CDN-->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="css/override.css">
		<?php readfile("metaIncludes.html"); ?>
	</head>
	<body class="page-body">
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
		<div class="jumbotron border text-light text-center splash" id="splashTradeTable" style="background-image">
			<h1 class="display-4"><?php echo $restaurant;?> Menu</h1>
			<p class="lead"><?php echo "$description"; ?></p>
			<p>Opening Hours: <?php echo "$openTime - $closeTime"; ?></p>
		</div>

		<div class="row">
		 <div class="col-sm-12 col-md-8">
			 <div class="card mb-4">
				 <div class="card-body">
					 <h5 class="card-title text-center"><?php echo $restaurant;?> Menu</h5>
					 <?php
					 if ($_SESSION["loggedIn"] == true)
					 {
						 	buildCafeMenu(array('Item', 'Price', 'Type', 'In Cart'), $conn, $queryTradeTableList, $_SESSION["loggedIn"], true);
					 }
					 else
					 {
						 buildCafeMenu(array('Item', 'Price', 'Type'), $conn, $queryTradeTableList, $_SESSION["loggedIn"], true);
					 }
					 ?>
				 </div>
			 </div>
		 </div>
			 <?php
			  if($_SESSION['loggedIn'] == true)
				{
					require("res/php/itemCartCard.php");
				}
			  ?>
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

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

	<script type="text/javascript" src="js/shoppingCart.js">

	</script>
	</body>
</html>
