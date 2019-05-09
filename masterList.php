<!--KIT202 Assignment 2 - Bryce Andrews 204552-->
<?php
session_start();
require("res/php/userAccessLevel.php");
require("res/db/dbConn.php");
require("res/db/dbQueries.php");
require("res/php/generateTable.php");

//Redirect user if insufficent privledges
switch((int)$_SESSION['accessLevel'])
{
	case userAccessLevel::BoardDirector:
	case userAccessLevel::BoardMember:
	case userAccessLevel::CafeManager:
	//do nothing
	break;
	case userAccessLevel::CafeStaff:
	case userAccessLevel::UserStaff:
	case userAccessLevel::UserStudent:
	default:
	header('location: index.php');
	break;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Populate form from DB
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Get cafe list from the DB and store in array
$getCafeQuery = ("SELECT cafeID, name FROM cafe");
$getCafes = $conn->query($getCafeQuery);
if ($getCafes->num_rows > 0)
{
	while ($row = $getCafes->fetch_assoc())
	{
		$cafeNames[$row['cafeID']] = $row["name"];
	}
}

//Get food types from DB for UI and store in array
$getFoodTypeQuery = ("SELECT typeID, name FROM foodType");
$getFoodTypes = $conn->query($getFoodTypeQuery);
if ($getFoodTypes->num_rows > 0)
{
	while ($row = $getFoodTypes->fetch_assoc())
	{
		$foodTypes[$row["typeID"]] = $row["name"];
	}
}


//Form Submission Logic handler
if (isset($_POST['itemName']))
{
	//Get item cafe from input

	//Browse the array of cafe names, and populate array from POST variables named by the cafe name keys
	foreach ($cafeNames as $cafeID => $cafeName)
	{
		if($_POST[$cafeID] == true)
		{
			$cafeToAdd[] = $cafeID;
		}
	}

	//Add to DB
	$foodType = array_search($_POST['itemType'], $foodTypes);
	$insertItem = $conn->prepare("INSERT INTO masterFoodList (name, price, description, type) VALUES (?,?,?,?)");
	$insertItem->bind_param("sisi", $_POST['itemName'], $_POST['itemPrice'], $_POST['itemDescription'], $foodType);
	$insertItem->execute();
	$itemID = $conn->insert_id;
	$insertItem->close();

	//Loop over all cafes selected with appropriate cafeIDs
	$insertCafe = $conn->prepare("INSERT INTO item_to_cafe (itemID, cafeID) VALUES (?, ?)");
	foreach ($cafeToAdd as $cafeID)
	{
		$insertCafe->bind_param("ii", $itemID, $cafeID);
		$insertCafe->execute();
	}
	$insertCafe->close();
}


if (isset($_POST['itemNameEdit']))
{
	$itemID = $_POST['editID'];
	$foodType = array_search($_POST['itemTypeEdit'], $foodTypes);
	$editStatement = $conn->prepare("UPDATE masterFoodList SET name = ?, price = ?, description = ?, type = ? WHERE itemID = ?");
	$editStatement->bind_param("sisii", $_POST['itemNameEdit'], $_POST['itemPriceEdit'], $_POST['itemDescriptionEdit'], $foodType, $itemID);
	$editStatement->execute();
	$editStatement->close();
}

//Add date as an edit
if(isset($_POST['startDate']) && isset($itemID))
{
	//update statement to add time
	$SQLDate = date_format(date_create_from_format('d/m/Y', $_POST['startDate']), 'Y-m-d');
	$updateStartDate = $conn->prepare("UPDATE masterFoodList SET startDate = ? WHERE itemID = ?");
	$updateStartDate->bind_param("si", $SQLDate, $itemID);
	$updateStartDate->execute();
	$updateStartDate->close();
}
if(isset($_POST['endDate']) && isset($itemID))
{
	//update statment to add time
	$SQLDate = date_format(date_create_from_format('d/m/Y', $_POST['endDate']), 'Y-m-d');
	$updateEndDate = $conn->prepare("UPDATE masterFoodList SET endDate = ? WHERE itemID = ?");
	$updateEndDate->bind_param("si", $SQLDate, $itemID);
	$updateEndDate->execute();
	$updateEndDate->close();
}

//Iterate over deletion form data
if(isset($_POST['delete']))
{
	$deleteStatement = $conn->prepare("DELETE from masterFoodList WHERE itemID = ?");
	foreach ($_POST['delete'] as $delID)
	{
		$deleteStatement->bind_param("i", $delID);
		$deleteStatement->execute();
	}
	$deleteStatement->close();
}


//Clear POST variable after processing
//$_POST = array();
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
		<!-- Date picker extension CDN for bootstrap 4-->
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
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
	//TODO Edit these so board directors, and cafe managers get different notices
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
				<p> Page Under Construction - Database editing unimplemented</p>
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
	}

//TODO: move page code to an include require statement based upon user access level
	//Furthur page elements
	switch((int)$_SESSION['accessLevel'])
	{

	}
	 ?>
	 <div class="container">
		 <div class="row">
			<div class="col-sm-12 col-md-9 col-xl-10">
	 			<div class="card mb-4">
	 				<div class="card-body">
	 					<h5 class="card-title text-center">Master List Management</h5>
						<div class="table-responsive-sm">
							<?php
								buildMasterList(array('Item', 'Price', 'Description', 'Type', 'Cafes'), $conn, $queryMasterList);
							?>
						</div>
	 					</div>
	 				</div>
	 			</div>
				<div class="col-sm-12 col-md-3 col-xl-2 float-right">
					<div class="card mb-4">
						<div class="card-body">
							<h5 class="card-title text-center">Item Controls</h5>
							<div class="list-group">
  							<button id="newButton" type="button" data-toggle="modal" data-target="#newItemModal" class="list-group-item list-group-item-success list-group-item-action">New Item</button>
								<button id="deleteButton" type="button" class="list-group-item list-group-item-danger list-group-item-action">Delete</button>
								<button id="multiDeleteButton" type="button" class="list-group-item list-group-item-warning list-group-item-action">Multi Delete</button>
  							<button id="editButton" type="button" data-toggle="modal" data-target="#editItemModal" class="list-group-item list-group-item-info list-group-item-action">Edit Item</button>
							</div>
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

				<div class="col-sm-12 col-md-4">
					<div class="card mb-4">
						<div class="card-body text-center">
							<h5 class=card-title>Debug: Food Types</h5>
							<p class="card-text">
								<?php
								print_r($foodTypes);
								print_r($cafeToAdd);
								 ?>
							</p>
						</div>
					</div>
				</div>

				<div class="col-sm-12 col-md-4">
					<div class="card mb-4">
						<div class="card-body text-center">
							<h5 class=card-title>Debug: Cafe Names</h5>
							<p class="card-text">
								<?php
								print_r($cafeNames);
								 ?>
							</p>
						</div>
					</div>
				</div>

			</div>
			<div class="row">
				<div class="col-sm-12 col-md-10">
					<div class="card mb-4">
						<div class="card-body text-center">
							<h5 class="card-title">Timed Items</h5>
							<?php
							$fetchItemDates = "SELECT masterFoodList.name as name, foodType.name as type, IFNULL(DATE_FORMAT(startDate, \"%W, %D %M, %Y\"), 'N/A')
							as startDate, IFNULL(DATE_FORMAT(endDate, \"%W, %D %M, %Y\"),'N/A') as endDate
							FROM masterFoodList inner join foodType on masterFoodList.type = foodType.typeID where not isNULL(startDate) or not isNULL(endDate)";
							buildGenericList(array('Item', 'Type', 'Start Date', 'End Date'), array('name', 'type', 'startDate', 'endDate'), $conn, $fetchItemDates);
							?>
						</div>

					</div>

				</div>
			</div>
	</div>
</main>
<?php
//TODO: get categories and resturants from database
 ?>
<modalNew>
	<div class="modal fade" id="newItemModal" tabindex="-1" role="dialog" aria-labelledby="New Item" aria-hidden="true">
	   <div class="modal-dialog" role="document">
	      <div class="modal-content">
	         <div class="modal-header">
	            <h5 class="modal-title" id="newItemModalTitle">New Item</h5>
	            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	            <span aria-hidden="true">&times;</span>
	            </button>
	         </div>
	         <div id="newItemBody" class="modal-body">
	            <form action="masterList.php" method="post" id="newItemForm" autocomplete="off">
	               <div class="form-group">
	                  <label for="inputText" class="form-label">Item Name</label>
	                  <input type="text" class="form-control" name ="itemName" maxlength="32" id="newItemName" placeholder="Enter the items name">
										<div class="invalid-feedback">Please enter a name</div>
	               </div>
	               <div class="form-group">
	                  <label for="inputText" class="form-label">Price</label>
	                  <div class="input-group">
	                     <div class="input-group-prepend">
	                        <span class="input-group-text" id="price-addon">$</span>
	                     </div>
	                     <input type="number" name="itemPrice" value="1.00" min="0" max="99.9" step="0.50" class="form-control" id="newItemPrice"/>
											 <div class="invalid-feedback">Please enter a valid price</div>
	                  </div>
	               </div>
	               <div class="form-group">
	                  <label for="newItemType">Item Type</label>
	                  <select class="form-control" id="newItemType" name="itemType">
												<?php
													foreach ($foodTypes as $key => $foodName)
													{
														echo "<option>$foodName</option>";
													}
												 ?>
	                  </select>
	               </div>
								 <div class="form-group">
									 <label for="itemDescription" class="form-label">Item Description</label>
									 <textarea type="text" class="form-control" name="itemDescription" id="newItemDescription" placeholder="Enter a brief description of the item."></textarea>
									 <div class="invalid-feedback">Please enter a description of the item</div>
								 </div>
	               <div class="form-group">
										<?php
											foreach ($cafeNames as $cafeID => $cafeName)
											{
												echo "<div class=\"form-check form-check-inline\">";
												echo "<input class=\"form-check-input newRestaurantSelector\" name=\"$cafeID\" type=\"checkbox\" value=\"true\">";
												echo "<label class=\"form-check-label\"  for=\"$cafeID\">$cafeName</label>";
												echo "</div>";
											}
										 ?>
	               </div>
								 <div class="form-group">
	                  <label class="form-label">Start Date</label>
	                  <input type="text" class="form-control" name ="startDate" id="newItemStart" readonly="true" placeholder="(Optional) Enter a start date.">
	               </div>
								 <div class="form-group">
	                  <label class="form-label">End Date</label>
	                  <input type="text" class="form-control" name ="endDate" id="newItemEnd" readonly="true" placeholder="(Optional) Enter an end date.">
	               </div>
	            </form>
	            <div class="modal-footer">
	               <button type="button" id="closeNewButton"class="btn btn-secondary" data-dismiss="modal">Close</button>
	               <button class="btn btn-default btn-primary" id="saveNewButton" type="submit">Save changes</button>
	            </div>
	         </div>
	      </div>
	   </div>
	</div>
</modalNew>
<modalEdit>
	<div class="modal fade" id="editItemModal" tabindex="-1" role="dialog" aria-labelledby="Edit Item" aria-hidden="true">
	   <div class="modal-dialog" role="document">
	      <div class="modal-content">
	         <div class="modal-header">
	            <h5 class="modal-title" id="editItemModalTitle">Edit Item</h5>
	            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	            <span aria-hidden="true">&times;</span>
	            </button>
	         </div>
	         <div id="editItemBody" class="modal-body">
	            <form action="masterList.php" method="post" id="editItemForm" autocomplete="off">
	               <div class="form-group">
	                  <label for="inputText" class="form-label">Item Name</label>
	                  <input type="text" class="form-control" name ="itemNameEdit" maxlength="32" id="editItemName" placeholder="Enter the items name">
										<div class="invalid-feedback">Please enter a name</div>
	               </div>
	               <div class="form-group">
	                  <label for="inputText" class="form-label">Price</label>
	                  <div class="input-group">
	                     <div class="input-group-prepend">
	                        <span class="input-group-text" id="price-addon">$</span>
	                     </div>
	                     <input type="number" name="itemPriceEdit" value="1.00" min="0" max="99.9" step="0.50" class="form-control" id="editItemPrice"/>
											 <div class="invalid-feedback">Please enter a valid price</div>
	                  </div>
	               </div>
	               <div class="form-group">
	                  <label for="editItemType">Item Type</label>
	                  <select class="form-control" id="editItemType" name="itemTypeEdit">
												<?php
													foreach ($foodTypes as $key => $foodName)
													{
														echo "<option typeID=\"$key\">$foodName</option>";
													}
												 ?>
	                  </select>
	               </div>
								 <div class="form-group">
									 <label for="itemDescriptionEdit" class="form-label">Item Description</label>
									 <textarea type="text" class="form-control" name="itemDescriptionEdit" id="editItemDescription" placeholder="Enter a brief description of the item."></textarea>
									 <div class="invalid-feedback">Please enter a description of the item</div>
								 </div>
	               <div class="form-group">
										<?php
											foreach ($cafeNames as $cafeID => $cafeName)
											{
												echo "<div class=\"form-check form-check-inline\">";
												echo "<input class=\"form-check-input editRestaurantSelector\" name=\"$cafeID\" type=\"checkbox\" value=\"true\">";
												echo "<label class=\"form-check-label\"  for=\"$cafeID\">$cafeName</label>";
												echo "</div>";
											}
										 ?>
	               </div>
								 <div class="form-group">
	                  <label class="form-label">Start Date</label>
	                  <input type="text" class="form-control" name ="startDate" id="editItemStart" readonly="true" placeholder="(Optional) Enter a start date.">
	               </div>
								 <div class="form-group">
	                  <label class="form-label">End Date</label>
	                  <input type="text" class="form-control" name ="endDate" id="editItemEnd" readonly="true" placeholder="(Optional) Enter an end date.">
	               </div>
	            </form>
	            <div class="modal-footer">
	               <button type="button" id="closeEditButton"class="btn btn-secondary" data-dismiss="modal">Close</button>
	               <button class="btn btn-default btn-primary" id="saveEditButton" type="submit">Save changes</button>
	            </div>
	         </div>
	      </div>
	   </div>
	</div>
</modalEdit>
<modalDelete>
	<div class="modal fade" id="deleteItemModal" tabindex="-1" role="dialog" aria-labelledby="Edit Item" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="deleteItemModalTitle">Delete Item</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div id="deleteItemBody"class="modal-body"></div>
				<form id="deleteForm" action="masterList.php" method="post"></form>
	      <div class="modal-footer">
	        <button id="deleteCancelButton" type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
	        <button id="deleteConfirmButton" type="submit" class="btn btn-danger">Delete</button>
	      </div>
	    </div>
	  </div>
	</div>
</modalDelete>
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
	<!--Calendar Date Picker -->
	<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>


	<script>
	//Clean up JS into seprate files
		$(function() {
			if (!document.location.host) {
				//Load our dependencies via Javascript if no PHP is available
  			$("#navAJAX").load("navbar.html");
				$("#footerAJAX").load("footer.html");
				}
			});

			//Boot strap date picker override
		$('#newItemStart').datepicker({
          uiLibrary: 'bootstrap4',
					format: 'dd/mm/yyyy',
					modal: true,
					header: true,
					footer: true
      });
		$('#newItemEnd').datepicker({
           uiLibrary: 'bootstrap4',
					 format: 'dd/mm/yyyy',
					 modal: true,
					 header: true,
					 footer: true
       });
		 $('#editItemStart').datepicker({
						uiLibrary: 'bootstrap4',
					 format: 'dd/mm/yyyy',
					 modal: true,
					 header: true,
					 footer: true
				});
		 $('#editItemEnd').datepicker({
						 uiLibrary: 'bootstrap4',
						format: 'dd/mm/yyyy',
						modal: true,
						header: true,
						footer: true
				 });

		//TODO need to clear previous data valiadation
		$("#closeNewButton").click(function() {
			$("#newItemForm").trigger("reset");
		});
		$("#closeEditButton").click(function() {
			//Delete hidden field with edit ID
			$("#tempEditField").remove();
			$("#editItemForm").trigger("reset");
		});

		//Override bootstrap new item form submission
    $("#saveNewButton").click(function()
		{
			if (validateNewItem() == true)
			{
				$("#newItemForm").submit();
			}
    });

		//Override bootstrap new item form submission
    $("#saveEditButton").click(function()
		{

			if (validateEditItem() == true)
			{
				$("#editItemForm").submit();
			}
    });

	</script>

	<script src="js/masterlist.js"></script>
	</body>
</html>
