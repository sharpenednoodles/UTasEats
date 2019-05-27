<!--KIT202 Assignment 2 - Bryce Andrews 204552-->
<?php
//Handle item logic before loading page
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
	case userAccessLevel::CafeStaff:
	//do nothing
	break;
	case userAccessLevel::UserStaff:
	case userAccessLevel::UserStudent:
	default:
	header('location: index.php');
	break;
}

$debug = true;

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Populate item types and available cafes from DB
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Get cafe list for UI from the DB and store in array
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

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Form Submission Logic handling
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//New item submission
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

	//Find ID value for the selected food type from DB to insert
	$foodType = array_search($_POST['itemType'], $foodTypes);
	$insertItem = $conn->prepare("INSERT INTO masterFoodList (name, price, description, type) VALUES (?,?,?,?)");
	$insertItem->bind_param("sdsi", $_POST['itemName'], $_POST['itemPrice'], $_POST['itemDescription'], $foodType);
	$insertItem->execute();
	$itemID = $conn->insert_id;
	$insertItem->close();

	//Loop over all cafes selected with appropriate cafeIDs and add them to the item_to_cafe pivot table if they were selected
	$insertCafe = $conn->prepare("INSERT INTO item_to_cafe (itemID, cafeID) VALUES (?, ?)");
	foreach ($cafeToAdd as $cafeID)
	{
		$insertCafe->bind_param("ii", $itemID, $cafeID);
		$insertCafe->execute();
	}
	$insertCafe->close();
}

//Editing item submission
if (isset($_POST['itemNameEdit']))
{
	//Browse the array of cafe names, and populate array from POST variables named by the cafe name keys
	foreach ($cafeNames as $cafeID => $cafeName)
	{
		if($_POST[$cafeID] == true)
		{
			$cafeToAdd[] = $cafeID;
		}
	}

	$itemID = $_POST['editID'];
	$foodType = array_search($_POST['itemTypeEdit'], $foodTypes);
	$editStatement = $conn->prepare("UPDATE masterFoodList SET name = ?, price = ?, description = ?, type = ? WHERE itemID = ?");
	$editStatement->bind_param("sdsii", $_POST['itemNameEdit'], $_POST['itemPriceEdit'], $_POST['itemDescriptionEdit'], $foodType, $itemID);
	$editStatement->execute();
	$editStatement->close();


	//Check whether we are editing masterlist, or just a single cafe, then add/delete from the item_to_cafe pivot table as necessary
	if(isset($_POST['singleCafeID']) == false)
	{
		//We are running the master list, delete all exisitng entries, and create a new item_to_cafe entries for the selected cafes
		$deleteCafe = $conn->prepare("DELETE from item_to_cafe WHERE itemID = ?");
		$deleteCafe->bind_param("i", $itemID);
		$deleteCafe->execute();
		$deleteCafe->close();
		//Loop over all cafes selected with appropriate cafeIDs
		$insertCafe = $conn->prepare("INSERT INTO item_to_cafe (itemID, cafeID) VALUES (?, ?)");
		foreach ($cafeToAdd as $cafeID)
		{
			$insertCafe->bind_param("ii", $itemID, $cafeID);
			$insertCafe->execute();
		}
		$insertCafe->close();

	}
	else
	{
		//Only delete from single cafe, as cafe manager only has access to one cafe
		$deleteCafe = $conn->prepare("DELETE from item_to_cafe WHERE itemID = ? AND cafeID = ?");
		$deleteCafe->bind_param("ii", $itemID, $_POST['singleCafeID']);
		$deleteCafe->execute();
		$deleteCafe->close();

		//Add the new cafe entries to the pivot table if we are adding to the cafe selection (as opposed of only removing)
		if($_POST['itemActive'] == 'true')
		{
			$insertCafe = $conn->prepare("INSERT INTO item_to_cafe (itemID, cafeID) VALUES (?, ?)");
			$insertCafe->bind_param("ii", $itemID, $_POST['singleCafeID']);
			$insertCafe->execute();
			$insertCafe->close();
		}
	}
}

//Add expiration dates to the DB if set
//TODO handle removal of expiry dates to items
if(isset($_POST['startDate']) && isset($itemID))
{
	//update statement to add time
	//Convert the submitted time stamp to the DB format
	$SQLDate = date_format(date_create_from_format('d/m/Y', $_POST['startDate']), 'Y-m-d');
	$updateStartDate = $conn->prepare("UPDATE masterFoodList SET startDate = ? WHERE itemID = ?");
	$updateStartDate->bind_param("si", $SQLDate, $itemID);
	$updateStartDate->execute();
	$updateStartDate->close();
}
if(isset($_POST['endDate']) && isset($itemID))
{
	//update statment to add time
	//Convert the submitted time stamp to the DB format
	$SQLDate = date_format(date_create_from_format('d/m/Y', $_POST['endDate']), 'Y-m-d');
	$updateEndDate = $conn->prepare("UPDATE masterFoodList SET endDate = ? WHERE itemID = ?");
	$updateEndDate->bind_param("si", $SQLDate, $itemID);
	$updateEndDate->execute();
	$updateEndDate->close();
}

//Handle Item deletion
if(isset($_POST['delete']))
{
	$deleteStatement = $conn->prepare("DELETE from masterFoodList WHERE itemID = ?");
	//Iterate over the array for all items to be deleted
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
	//Change content based upon who is logged in
	switch((int)$_SESSION['accessLevel'])
	{
		case userAccessLevel::BoardDirector:
		case userAccessLevel::BoardMember:
		echo <<<HEAD
		<div class="container">
			<div class="jumbotron border">
				<h1 class="display-4">Master List</h1>
				<p class="lead">Manage available menu items below.</p>
			</div>
		</div>
HEAD;
		break;
		case userAccessLevel::CafeManager:
		echo "<div class=\"container\">";
			echo "<div class=\"jumbotron border\">";
				echo "<h1 class=\"display-4\">".$_SESSION['cafeEmployment']." List</h1>";
				echo "<p class=\"lead\">Manage available menu items in your cafe below.</p>";
			echo "</div>";
		echo "</div>";
		break;
		case userAccessLevel::CafeStaff:
		echo "<div class=\"container\">";
			echo "<div class=\"jumbotron border\">";
				echo "<h1 class=\"display-4\">".$_SESSION['cafeEmployment']." List</h1>";
				echo "<p class=\"lead\">View available menu items in your cafe below.</p>";
			echo "</div>";
		echo "</div>";
		break;
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
	 ?>
	 <div class="container">
		 <div class="row">
			<div class="col-sm-12 col-md-9 col-xl-10">
	 			<div class="card mb-4">
	 				<div class="card-body">
						<?php
						switch((int)$_SESSION['accessLevel'])
						{
							case userAccessLevel::BoardDirector:
							case userAccessLevel::BoardMember:
							echo "<h5 class='card-title text-center' id='tableType' tableType='master'>Master List Management</h5>";
							break;
							case userAccessLevel::CafeManager:
							case userAccessLevel::CafeStaff:
							echo "<h5 class='card-title text-center' id='tableType' tableType='".$_SESSION['cafeEmpID']."'>".$_SESSION['cafeEmployment']." List Management</h5>";
							break;
						}
						 ?>
						<div class="table-responsive-sm">
							<?php
								//Switch so that managers can only view a single restaurant
								//TODO - make this work with generics
								switch((int)$_SESSION['accessLevel'])
								{
									case userAccessLevel::BoardDirector:
									case userAccessLevel::BoardMember:
									case userAccessLevel::CafeManager:
									buildMasterList(array('Item', 'Price', 'Description', 'Type', 'Cafes'), $conn, $queryMasterList);
									break;
									case userAccessLevel::CafeStaff:
									if ($_SESSION['cafeEmployment'] == 'Lazenbys')
									{
										buildMasterList(array('Item', 'Price', 'Description', 'Type', 'Cafes'), $conn, $queryLazenbysList);
									}
									elseif ($_SESSION['cafeEmployment'] == 'Suzy Lee')
									{
										buildMasterList(array('Item', 'Price', 'Description', 'Type', 'Cafes'), $conn, $querySuzyLeeList);
									}
									elseif ($_SESSION['cafeEmployment'] == 'Trade Table')
									{
										buildMasterList(array('Item', 'Price', 'Description', 'Type', 'Cafes'), $conn, $queryTradeTableList);
									}
									break;
								}
							?>
						</div>
	 					</div>
	 				</div>
	 			</div>
				<?php
				//Only display menu controls to some users, and hide only certain buttons from others
				switch((int)$_SESSION['accessLevel'])
				{
					case userAccessLevel::BoardDirector:
					case userAccessLevel::BoardMember:
					case userAccessLevel::CafeManager:
					echo <<<CONTROLS
					<div class="col-sm-12 col-md-3 col-xl-2 float-right">
						<div class="card mb-4">
							<div class="card-body">
								<h5 class="card-title text-center">Item Controls</h5>
								<div class="list-group">
CONTROLS;
					}
					switch((int)$_SESSION['accessLevel'])
					{
						case userAccessLevel::BoardDirector:
						case userAccessLevel::BoardMember:
						echo <<<CONTROLS
									<button id="newButton" type="button" data-toggle="modal" data-target="#newItemModal" class="list-group-item list-group-item-success list-group-item-action">New Item</button>
									<button id="deleteButton" type="button" class="list-group-item list-group-item-danger list-group-item-action">Delete</button>
									<button id="multiDeleteButton" type="button" class="list-group-item list-group-item-warning list-group-item-action">Multi Delete</button>
CONTROLS;
						case userAccessLevel::CafeManager:
						echo <<<CONTROLS
									<button id="editButton" type="button" data-toggle="modal" data-target="#editItemModal" class="list-group-item list-group-item-info list-group-item-action">Edit Item</button>
								</div>
							</div>
						</div>
					</div>
CONTROLS;
					break;
				}
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
			<div class="row">
				<div class="col-sm-12 col-md-10">
					<div class="card mb-4">
						<div class="card-body text-center">
							<h5 class="card-title">Timed Items</h5>
							<?php
							//SQL query to display items with set expiry dates
							$fetchItemDates = "SELECT masterFoodList.name as name, foodType.name as type, IFNULL(DATE_FORMAT(startDate, \"%W, %D %M, %Y\"), 'N/A')
							as startDate, IFNULL(DATE_FORMAT(endDate, \"%W, %D %M, %Y\"),'N/A') as endDate
							FROM masterFoodList inner join foodType on masterFoodList.type = foodType.typeID where not startDate = \"N/A\" or not endDate = \"N/A\"";
							//Build the table, see generateTable.php for details
							buildGenericList(array('Item', 'Type', 'Start Date', 'End Date'), array('name', 'type', 'startDate', 'endDate'), $conn, $fetchItemDates);
							?>
						</div>
					</div>
				</div>
			</div>
	</div>
</main>
<?php
//Modal defintions (The pop up windows)
 ?>
<modalNew>
	<div class="modal fade" id="newItemModal" tabindex="-1" role="dialog" aria-labelledby="New Item" aria-hidden="true">
	   <div class="modal-dialog" role="document">
	      <div class="modal-content">
	         <div class="modal-header">
	            <h5 class="modal-title" id="newItemModalTitle">New Item</h5>
	            <button type="button" id="crossNewButton" class="close" data-dismiss="modal" aria-label="Close">
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
												//Populate availble food types
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
										switch((int)$_SESSION['accessLevel'])
										{
											//Populate availble restuarant selectors
											case userAccessLevel::BoardDirector:
											case userAccessLevel::BoardMember:
											foreach ($cafeNames as $cafeID => $cafeName)
											{
												echo "<div class=\"form-check form-check-inline\">";
												echo "<input class=\"form-check-input newRestaurantSelector\" name=\"$cafeID\" type=\"checkbox\" value=\"true\">";
												echo "<label class=\"form-check-label\"  for=\"$cafeID\">$cafeName</label>";
												echo "</div>";
											}
											break;
											case userAccessLevel::CafeStaff:
											case userAccessLevel::CafeManager:
											echo "<div class=\"form-check form-check-inline\">";
											echo "<input class=\"form-check-input newRestaurantSelector\" name=\"".$_SESSION['cafeEmpID']."\" type=\"checkbox\" value=\"true\"checked>";
											echo "<label class=\"form-check-label\"  for=\"".$_SESSION['cafeEmpID']."\">".$_SESSION['cafeEmployment']."</label>";
											echo "</div>";
											break;
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
	            <button type="button" id="crossEditButton" class="close" data-dismiss="modal" aria-label="Close">
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
												//Populate available food types
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
										switch((int)$_SESSION['accessLevel'])
										{
											//Populate avaialble resturant selectors
											case userAccessLevel::BoardDirector:
											case userAccessLevel::BoardMember:
											foreach ($cafeNames as $cafeID => $cafeName)
											{
												echo "<div class=\"form-check form-check-inline\">";
												echo "<input class=\"form-check-input editRestaurantSelector\" parseName=\"$cafeName\" name=\"$cafeID\" type=\"checkbox\" value=\"true\">";
												echo "<label class=\"form-check-label\"  for=\"$cafeID\">$cafeName</label>";
												echo "</div>";
											}
											break;
											case userAccessLevel::CafeStaff:
											case userAccessLevel::CafeManager:
											echo "<div class=\"form-check form-check-inline\">";
											echo "<input class=\"form-check-input editRestaurantSelector\" parseName=\"".$_SESSION['cafeEmployment']."\" name=\"".$_SESSION['cafeEmpID']."\" type=\"checkbox\" value=\"true\">";
											echo "<label class=\"form-check-label\"  for=\"".$_SESSION['cafeEmpID']."\">".$_SESSION['cafeEmployment']."</label>";
											echo "</div>";
											break;
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
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

		var minDateForm = $("#newItemStart").val();
		console.log(minDateForm);
		$('#newItemEnd').datepicker({
           uiLibrary: 'bootstrap4',
					 format: 'dd/mm/yyyy',
					 modal: true,
					 header: true,
					 footer: true,
					 minDate: minDateForm
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

		//Clear modal data on close
		$("#closeNewButton").click(function() {
			$("#newItemForm").trigger("reset");
		});
		$("#crossNewButton").click(function() {
			$("#newItemForm").trigger("reset");
		});
		$("#closeEditButton").click(function() {
			//Delete hidden field with edit ID
			$("#tempEditField").remove();
			$("#editItemForm").trigger("reset");
		});
		$("#crossEditButton").click(function() {
			//Delete hidden field with edit ID
			$("#tempEditField").remove();
			$("#editItemForm").trigger("reset");
		});

		//Override bootstrap new item form submission
    $("#saveNewButton").click(function()
		{
			//If data is valid, submit form
			if (validateNewItem() == true)
			{
				$("#newItemForm").submit();
			}
    });

		//Override bootstrap edit item form submission, and add additional data for Cafe Manager edit access if applicable
    $("#saveEditButton").click(function()
		{
			//If data is valid submit form
			if (validateEditItem() == true)
			{
				if ($("#tableType").attr("tabletype") != "master")
				{
					var cafeID = $("#tableType").attr("tabletype");
					$("#editItemForm").append("<input type='hidden' name='singleCafeID' value='"+cafeID+"'>");

					//Determine the state of the resturant switch, only if we are a cafe manager with access to a single menu
					if ($(".editRestaurantSelector").prop('checked') == true)
					{
						$("#editItemForm").append("<input type='hidden' name='itemActive' value='true'>");
					}
					else
					{
						//Check if the item is only available at one resturant, if so, deactivate it with an expiry rather than a deactivate flag
						if (restaurantArray.length > 1)
						{
							$("#editItemForm").append("<input type='hidden' name='itemActive' value='false'>");
						}
						else
						{
							$("#editItemForm").append("<input type='hidden' name='itemActive' value='true'>");
							//Setting the items expiry to a day before the current date, as items with no cafes registered in the pivot table will disappear entirely from the site UI
							yesterday = new Date();
							var yyyy = yesterday.getFullYear();
							//Jan is 0, need to fix
							var mm = yesterday.getMonth() + 1;
							//Want yesterdays day
							var dd = yesterday.getDate() - 1;

							//Add leading zeroes if needed
							if (dd < 10)
							{
								dd = '0'+dd;
							}
							if (mm < 10)
							{
								mm = '0'+mm;
							}
							$("#editItemForm").append("<input type='hidden' name='endDate' value='"+dd+"/"+mm+"/"+yyyy+"'>");
						}
					}
				}
				$("#editItemForm").submit();
			}
    });

	</script>

	<script src="js/masterlist.js"></script>
	<script src="js/buildMenuDropDown.js"></script>
	</body>
</html>
