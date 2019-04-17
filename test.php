<!--KIT202 Assignment 1 - Bryce Andrews 204552-->
<?php
	session_start();
	require("res/php/userAccessLevel.php");
	require("res/db/dbConn.php");
	require("res/db/dbQueries.php");
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<title>UTASEats Test Playground</title>
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
		<div class="jumbotron border">
			<h1 class="display-4">Testing page</h1>
			<p class="lead">Playground for testing various features in the page</p>
			<hr class="my-4">
			<p>Bro, how do you even Mysqli??</p>
		</div>
		<div class="row">
			<div class="col-sm-12 col-md-4">
				<div class="card mb-4">
					<div class="card-body text-center">
						<h5 class=card-title>MySQLi Connection Status</h5>
						<p>
							<?php
							//Display our connection status
							echo $credentialStatus;
							?>
						</p>
							<div class="text-left">
							<p>
							<?php
							echo "<p><b>Username:</b> $username</p>";
							echo "<p><b>Password:</b> $password</p>";
							echo "<p><b>Address:</b> $address</p>";
							echo "<p><b>Database:</b> $DB</p>";
							?>
							</div>
						</p>
					</div>
				</div>
			</div>

			<div class="col-sm-12 col-md-8">
				<div class="card mb-4">
					<div class="card-body text-center">
						<h5 class=card-title>Database Table Sample</h5>
							<?php
							//Display our connection status
							$queryString =  "SELECT masterfoodlist.name, price, description, foodType.name as type FROM masterfoodlist INNER JOIN foodType ON masterfoodlist.type=foodType.typeID";
							?>
							<div class="text-left">


							<table class="table table-hover table-striped table-bordered">
								<thead class="thead-dark">
									<tr>
										<th>Name</th>
										<th>Price</th>
										<th>Description</th>
										<th>Type</th>
									</tr>
								</thead>
								<tbody>
								<?php
								//Populate our mysql_list_tables
								$tableContent = $conn->query($queryString);
								if ($tableContent->num_rows > 0)
								{
									while($row = $tableContent->fetch_assoc())
									{
										echo("<tr>");
										echo("<td>" .$row["name"]."</td>");
										echo("<td>$" .$row["price"].".00</td>");
										echo("<td>" .$row["description"]."</td>");
										echo("<td>" .$row["type"]."</td>");
										echo("</tr>");
									}
								}
								 ?>
							</tbody>
						</table>
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
