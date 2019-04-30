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

		<title>Trade Table Menu</title>
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
		<div class="jumbotron border text-light text-center splash" id="splashTradeTable" style="background-image">
			<h1 class="display-4">Trade Table Menu</h1>
			<p class="lead">Grab a coffee from the Trade Table. The best baristas on campus. Guaranteed.</p>
			<p>Opening Hours: TBA</p>
		</div>
		<div class="row">
		 <div class="col-sm-12 col-md-8">
			 <div class="card mb-4">
				 <div class="card-body">
					 <h5 class="card-title text-center">Trade Table Menu</h5>
					 <table class="table table-hover table-striped table-bordered masterMenu">
						 <thead class="thead-dark">
							 <tr>
								 <th scope="col">Item Name</th>
								 <th scope="col">Price</th>
								 <th scope="col">Type</th>
								 <?php
								 //Hide cart actions if we aren't logged in
								 if($_SESSION['loggedIn'] == true)
								 {
									 echo "<th scope=\"col\">In Cart</th>";
								 }
								 ?>
							 </tr>
						 </thead>
						 <tbody>

							 <?php
							 //Include table files and definitions
							 require("res/php/generateMasterTable.php");

							 //Array of master menu, will be read from SQL DB later
							 $masterMenu = array(
								 array("ItemName" => "Trade Table Sample Item 2", "Price" => "3.2", "Type" => ItemGroup::Food, "Restaurant" => array(Restaurant::Lazenbys)),
								 array("ItemName" => "Coffee", "Price" => "4", "Type" => ItemGroup::Drink, "Restaurant" => array(Restaurant::TradeTable, Restaurant::Lazenbys, Restaurant::SuzyLee)),
							 );

							 printMasterTable($masterMenu, false, $_SESSION['loggedIn']);
								?>

						 </tbody>
						 </table>
					 </div>
				 </div>
			 </div>
			 <?php
				if($_SESSION['loggedIn'] == true)
				{

					echo <<<CHECKOUT
					<div class="col-sm-12 col-md-4">
					 <div class="card mb-4">
						 <div class="card-body">
							 <h5 class="card-title text-center">Item Cart</h5>
								 <table class="table table-striped table-bordered masterMenu">
									<thead class="thead-dark">
										<tr>
											<th scope="col">Item Name</th>
											<th scope="col">Quantity</th>
										</tr>
									</thead>
									<tbody id="itemCart">
									</tbody>
								 </table>
								 <div class="form-group">
									<label for="NotesArea">Extra Notes</label>
									<textarea class="form-control" id="NotesArea" rows="3"></textarea>
								</div>
								<button type="submit" class="btn btn-dark"name="button">Check Out</button>
						 </div>
					 </div>
				 </div>
CHECKOUT;
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
	<script src="https://cdnjs.buttflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
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

	</body>
</html>
