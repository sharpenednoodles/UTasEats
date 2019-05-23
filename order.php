<!--KIT202 Assignment 2 - Bryce Andrews 204552-->
<?php
session_start();
require("res/php/userAccessLevel.php");
require("res/db/dbConn.php");
require("res/db/dbQueries.php");
require("res/php/generateTable.php");
require("res/php/cafeDetails.php");

if ($_SESSION['ORDER_processed'] == false)
{
	//Redirect if not coming from completing an arder
	header('location: index.php');
}

//Change restaurant name here
$restaurant = getCafeName($conn, $_SESSION['ORDER_cafe']);
$restVar = str_replace(' ', '', $restaurant);
$openTime = getOpenTime($conn, $restaurant);
$openTime = date("g:ia", strtotime($openTime));
$closeTime = getCloseTime($conn, $restaurant);
$closeTime = date("g:ia", strtotime($closeTime));
$description = getDescription($conn, $restaurant);

$orderNumber = $_SESSION['ORDER_number'];
$insufficentFunds = $_SESSION['ORDER_insuffFunds'];
$pickupTime = $_SESSION['ORDER_collectionTime'];

//Flush temp session variable hack

$_SESSION['ORDER_cafe'] = null;
$_SESSION['ORDER_number'] = null;
$_SESSION['ORDER_processed'] = null;
$_SESSION['ORDER_insuffFunds'] = null;
$_SESSION['ORDER_collectionTime'] = null;


 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<title><?php echo $restaurant;?> Order Complete</title>
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
		<div class="jumbotron border text-light text-center splash" id="splash<?php echo $restVar; ?>" style="background-image">
			<h1 class="display-4">Your <?php echo $restaurant;?> Order</h1>
		</div>
		<div class="row justify-content-md-center">
		 <div class="col-sm-12 col-lg-6">
			 <div class="card mb-4">
				 <?php
				 if ($insufficentFunds == true)
				 {
					 echo "<div class='card-header text-center'>Insufficent funds</div>";
				 }
				 else
				 {
				 	echo "<div class='card-header card-title text-center'>Order #$orderNumber has been placed</div>";
				 }
				  ?>
				 <div class="card-body">
					 <?php
					 if ($insufficentFunds == true)
					 {
						 //Order not placed, not enough cash
						 echo "<p>There are not enough funds in your account to complete this purchase.</p>";
						 echo "<p>Please visit your account <a href='userpage.php'>here</a> to add additional funds, and try again.</p>";
					 }
					 else
					 {
					 	//Display order Information
						$queryOrderByNumber = $queryMasterOrdersBase. " WHERE orderList.ID ='".$orderNumber."' order by orderList.ID";
						buildGenericList(array("Item", "Quantity"), array("name","quantity"), $conn, $queryOrderByNumber);
						$orderNotes = getSQLValue($conn, 'orderList', 'orderNotes', 'ID', $orderNumber);
						$totalPaid = getSQLValue($conn, 'orderList', 'price', 'ID', $orderNumber);
						echo"<b>Order Notes:</b>";
						echo "<p>$orderNotes</p>";
						echo"<b>Total Paid: </b>";
						echo "<p>$totalPaid</p>";
					 }
					  ?>
				 </div>
				 <?php if ($sufficentFunds == false) { echo "<div class='card-footer text-muted text-center'>Please proceed to $restaurant to collect your order at $pickupTime</div>"; } ?>
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script src="js/thirdParty/bootstrap-input-spinner.js"></script>
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

	</body>
</html>
