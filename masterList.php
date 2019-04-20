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

		<title>UTASEats Master Food List Admin Panel</title>
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
	<?php
	switch((int)$_SESSION['accessLevel'])
	{
		case userAccessLevel::BoardDirector:
		case userAccessLevel::BoardMember:
		case userAccessLevel::CafeManager:
		echo <<<HEAD
		<div class="container">
			<div class="jumbotron border">
				<h1 class="display-4">Master List</h1>
				<p class="lead">Manage available menu items below.</p>
				<p> Page Under Construction - Data Base not functional</p>
			</div>
		</div>
HEAD;
		break;
		case userAccessLevel::CafeStaff:
		case userAccessLevel::UserStaff:
		case userAccessLevel::UserStudent:
		echo <<<HEAD
		<div class="container">
			<div class="jumbotron border">
				<h1 class="display-4">Insufficient privileges</h1>
				<p class="lead">You do not have sufficent privileges to view this page. Please contact your administrator if you believe this is an error.</p>
				<hr class="my-4">
				<a href="index.php">
					<p class="btn btn-dark btn-lg" role="button">Home</p>
				</a>
			</div>
		</div>
HEAD;
		break;
		default:
		echo <<<HEAD
		<div class="container">
			<div class="jumbotron border">
				<h1 class="display-4">Insufficient privileges</h1>
				<p class="lead">You are not logged in. Please login to your UTasEats account and try again.</p>
				<hr class="my-4">
				<a href="index.php">
					<p class="btn btn-dark btn-lg" role="button">Home</p>
				</a>
			</div>
		</div>
HEAD;
	break;
	}

	//Furthur page elements
	switch((int)$_SESSION['accessLevel'])
	{

	}
	 ?>
	 <div class="container">
		 <div class="row">
			<div class="col-sm-12 col-md-9">
	 			<div class="card mb-4">
	 				<div class="card-body">
	 					<h5 class="card-title text-center">Master List Management</h5>
						<table class="table table-hover table-striped table-bordered masterMenu">
  						<thead class="thead-dark">
    						<tr>
      						<th scope="col">Item Name</th>
									<th scope="col">Price</th>
      						<th scope="col">Type</th>
      						<th scope="col">Restaurants</th>
    						</tr>
  						</thead>
  						<tbody>

								<?php
								//Include table files and definitions
								require("res/php/generateMasterTable.php");

								//Array of master menu, will be read from SQL DB later
								$masterMenu = array(
									array("ItemName" => "Lazenbys Sample Item 1", "Price" => "5", "Type" => ItemGroup::Food, "Restaurant" => array(Restaurant::Lazenbys)),
									array("ItemName" => "SuzyLee Sample Item 1", "Price" => "9.5", "Type" => ItemGroup::Food, "Restaurant" => array(Restaurant::SuzyLee)),
									array("ItemName" => "Trade Table Sample Item 2", "Price" => "3.2", "Type" => ItemGroup::Drink, "Restaurant" => array(Restaurant::TradeTable)),
									array("ItemName" => "Coffee", "Price" => "4", "Type" => ItemGroup::Drink, "Restaurant" => array(Restaurant::TradeTable, Restaurant::Lazenbys, Restaurant::SuzyLee)),
								);

								printMasterTable($masterMenu, true, $_SESSION['loggedIn']);
								 ?>

  						</tbody>
							</table>
	 					</div>
	 				</div>
	 			</div>
				<div class="col-sm-12 col-md-3 float-right">
					<div class="card mb-4">
						<div class="card-body">
							<h5 class="card-title text-center">Item Controls</h5>
							<div class="list-group">
  							<button id="newButton" type="button" data-toggle="modal" data-target="#newItemModal" class="list-group-item list-group-item-success list-group-item-action">New Item</button>
  							<button id="deleteButton" type="button" class="list-group-item list-group-item-danger list-group-item-action">Remove Selected Items</button>
  							<button id="editButton" type="button" data-toggle="modal" data-target="#editItemModal" class="list-group-item list-group-item-info list-group-item-action">Edit Item</button>
							</div>
					</div>
					</div>
				</div>
			</div>


<!--Edit Item Modal-->
<div class="modal fade" id="editItemModal" tabindex="-1" role="dialog" aria-labelledby="Edit Item" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editItemModal">Edit Item</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="editItemBody"class="modal-body">
				<p>Item editing is currently unimplemented</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button id="saveEditButton" type="submit" class="btn btn-primary" data-dismiss="modal">Save changes</button>
      </div>
    </div>
  </div>
</div>


<!--New Item Modal-->
<div class="modal fade" id="newItemModal" tabindex="-1" role="dialog" aria-labelledby="New Item" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newItemModal">New Item</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="newItemBody" class="modal-body">

				<form action="masterList.php" method="post">
  				<div class="form-group">
    			<label for="inputText" class="form-label">Item Name</label>
      			<input type="text" class="form-control" id="newItemName" placeholder="Item Name">
					</div>

					<div class="form-group">
					<label for="inputText" class="form-label">Price</label>
					<div class="input-group">
  					<div class="input-group-prepend">
    					<span class="input-group-text" id="price-addon">$</span>
  					</div>
  					<input type="number" value="1" min="0" step="1" class="form-control" id="newItemPrice"/>
					</div>
					</div>

					<div class="form-group">
    				<label for="newItemType">Item Type</label>
    					<select class="form-control" id="newItemType">
      					<option>Food</option>
      					<option>Drink</option>
    					</select>
  				</div>

					<div class="form-group">
						<div class="form-check form-check-inline" id="newItemResturant">
  						<input class="form-check-input" type="checkbox" id="newItemLazenbys" value="option1">
  						<label class="form-check-label" for="newItemLazenbys">Lazenbys</label>
						</div>
						<div class="form-check form-check-inline">
  						<input class="form-check-input" type="checkbox" id="newItemSuzyLee" value="option2">
  						<label class="form-check-label" for="newItemSuzyLee">Suzy Lee</label>
						</div>
						<div class="form-check form-check-inline">
  						<input class="form-check-input" type="checkbox" id="newItemTradeTable" value="option3">
  						<label class="form-check-label" for="newItemTradeTable">Trade Table</label>
						</div>
					</div>

				</form>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button id="saveNewButton" type="submit" class="btn btn-primary" data-dismiss="modal">Save changes</button>
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
	//Clean up JS into seprate files
		$(function() {
			if (!document.location.host) {
				//Load our dependencies via Javascript if no PHP is available
  			$("#navAJAX").load("navbar.html");
				$("#footerAJAX").load("footer.html");
				}
			});

			$(".clickable").click(function()
			{
				var selectedColumn = $(this);
				if (selectedColumn.hasClass("table-primary"))
				{
					selectedColumn.removeClass("table-primary");
				}
				else {
					{
						selectedColumn.addClass("table-primary");
					}
				}

				});

				//Non permenant delete
				$("#deleteButton").click(function()
				{
					$("table.masterMenu").find(".table-primary").remove();

				});

				//Non functional
				$("#editButton").click(function()
				{
					//Ignore
					var itemCount = $("table.masterMenu").find(".table-primary").length;
					//alert(itemCount);
					var siblingNum = $("table.masterMenu").find(".table-primary").index();
					//alert(siblingNum);

				});

				$("#saveEditButton").click(function()
				{

				});

				$("#saveNewButton").click(function()
				{

				});

	</script>

	</body>
</html>
