<?php
//A series of helper functions to generate various types of HTML tables, given various parameters
//All tables pull data directly from the Database
//Some functions are internal helper functions, and SHOULD NOT be called directly

//See each function for details of it's functionality


//Build the master list from an array of headers, the DB connection and the SQL query
function buildMasterList($tableHeaders, $sqli, $SQLQuery)
{
	buildHeaders($tableHeaders);
	buildMasterBody($sqli, $SQLQuery);
	finishTable();
}

//Builds a generic HTML table based upon 2 arrays, tableHeaders specify the names, sqlHeaders specify the names of the data in the DB
function buildGenericList($tableHeaders, $sqlHeaders, $sqli, $SQLQuery)
{
	buildHeaders($tableHeaders);
	buildSQLBody($sqlHeaders, $sqli, $SQLQuery);
	finishTable();
}

//Same as above, but we can specify a custom class for javascript interactivity, and an optional id from the table to classify row data with
function buildCustomGenericList($tableHeaders, $sqlHeaders, $sqli, $SQLQuery, $customClass, $customID)
{
	buildHeaders($tableHeaders);
	buildSQLBodyCustom($sqlHeaders, $sqli, $SQLQuery, $customClass, $customID);
	finishTable();
}

//Build the cafe menu for the user facing side, providing the table header labels,
function buildCafeMenu($tableHeaders, $sqli, $SQLQuery, $isCart, $includeExpiry)
{
	buildHeaders($tableHeaders);
	buildCafeBody(array('item','price','type'), $sqli, $SQLQuery, $isCart, $includeExpiry);
	finishTable();
}

//Create table headers from array - HELPER FUNCTION. DO NOT CALL DIRECTLY
function buildHeaders($tableHeaders)
{
	echo "<div class=\"text-left\">";
	echo "<table class=\"table table-hover table-striped table-bordered\">";
	echo "<thead class=\"thead-dark\">";
	echo "<tr>";
	foreach ($tableHeaders as $header)
	{
		echo "<th>";
		echo $header;
		echo "</th>";
	}
	echo "</tr>";
	echo "</thead>";
}

//Create body of table from array of SQL lables, SQL connection and query - HELPER FUNCTION, DO NOT CALL DIRECTLY
function buildSQLBody($rowLabels, $sqli, $SQLQuery)
{
	echo "<tbody>";
	$tableContent = $sqli->query($SQLQuery);

	if ($tableContent->num_rows > 0)
	{
		while($row = $tableContent->fetch_assoc())
		{
			echo("<tr id =".$row["itemID"].">");
			foreach ($rowLabels as $rowLabel)
			{
				echo("<td>" .$row["$rowLabel"]."</td>");
			}
			echo("</tr>");
		}
	}
	echo "</tbody>";
}

//Create body of table from array of SQL lables, SQL connection, query and adds a custom class to the rows - HELPER FUNCTION, DO NOT CALL DIRECTLY
function buildSQLBodyCustom($rowLabels, $sqli, $SQLQuery, $customClass, $customID)
{
	echo "<tbody>";
	$tableContent = $sqli->query($SQLQuery);

	if ($tableContent->num_rows > 0)
	{
		while($row = $tableContent->fetch_assoc())
		{
			echo("<tr id =".$row[$customID]." class='$customClass'>");
			foreach ($rowLabels as $rowLabel)
			{
				echo("<td>" .$row["$rowLabel"]."</td>");
			}
			echo("</tr>");
		}
	}
	echo "</tbody>";
}

//Special case - Create body of cafe menu - can specify whether to include items if they no longer are valid - HELPER FUNCTION, DO NOT CALL DIRECTLY
function buildCafeBody($rowLabels, $sqli, $SQLQuery, $isCart, $includeExpiry)
{
	echo "<tbody>";
	$tableContent = $sqli->query($SQLQuery);
	$currentDate = date('Y-m-d');
	if ($tableContent->num_rows > 0)
	{
		while($row = $tableContent->fetch_assoc())
		{
			//If includeExpiry is true we print regardelss, otherwise we check the current date against the expiry and start times - which we will set to true if the values are N/A
			if ($includeExpiry == true || ((($row['endDate'] >= $currentDate) || ($row['endDate'] == "N/A") || $row['endDate'] == "0000-00-00") && (($row['startDate'] <= $currentDate) || ($row['startDate'] == "N/A" || $row['startRow'] == "0000-00-00"))))
			{
				//TODO check if item is in valid range before echoing table
				echo("<tr id =".$row["itemID"].">");
				foreach ($rowLabels as $rowLabel)
				{
					echo("<td>" .$row["$rowLabel"]."</td>");
				}
				//Add item for ordering quantity
				if ($isCart)
				{
					echo "<td style=\"width: 150px\"><div class=\"input-group\">";
						echo "<input type=\"number\" value=\"0\" min=\"0\" max=\"99\" step=\"1\" class=\"form-control\" id=\"itemQuantity\">";
					echo "</div></td>";
				}
				echo("</tr>");
			}
		}
	}
	echo "</tbody>";
}

//Special Case - Create body of master list from SQL connection and query - HELPER FUNCTION, DO NOT CALL DIRECTLY
function buildMasterBody($sqli, $SQLQuery)
{
	echo "<tbody>";
	$tableContent = $sqli->query($SQLQuery);

	if ($tableContent->num_rows > 0)
	{
		while($row = $tableContent->fetch_assoc())
		{
			if ($row["itemID"] != $lastItemID)
				{
					echo("<tr class=\"clickable\" id=".$row["itemID"]." startDate=".$row["startDate"]." endDate=".$row["endDate"].">");
					echo("<td>" .$row["item"]."</td>");
					echo("<td>" .$row["price"]."</td>");
					echo("<td>" .$row["description"]."</td>");
					echo("<td>" .$row["type"]."</td>");
					echo("<td>" .$row["cafe"]);
					//Use browser tags to auto close tags
				}
				else
				{
					echo(", ".$row["cafe"]);
				}
			$lastItemID = $row["itemID"];
		}
	}

	echo "</tbody>";
}

//Close table tag - HELPER FUNCTION - DO NOT CALL DIRECTLY
function finishTable()
{
	echo "</table>";
	echo "</div>";
}

//Function to build order cards, if completed false, then we won't display completed orders
function buildOrderCards($sqli, $SQLQuery, $completed)
{
	echo "<div class='row'>";
	$cardContent = $sqli->query($SQLQuery);
	if ($cardContent->num_rows > 0)
	{
		while($row = $cardContent->fetch_assoc())
		{
			$status = calculateOrderStatus($row['paid'], $row['orderCompleted'], $row['orderPickedUp']);
			if(($completed == false && $status !='Completed') || $completed == true)
			{
				$colour = getCardColour($status);
				echo "<div class='col-sm-12 col-md-4'>";
				echo "<div class='card mb-4 text-center bg-$colour text-white'>";
				echo "<div class='card-header'>Order #".$row['ID']." - ".$row['cafe']."</div>";
				echo "<div class ='card-body bg-dark'>";
				echo "<div class ='card-text'>".$row['quantity']." x ".$row['name']."</div>";
				echo "</div>";
				echo"<ul class='list-group list-group-flush'>";
					echo "<li class='list-group-item bg-$colour'>".$row['firstName']." ".$row['lastName']."</li>";
				  echo "<li class='list-group-item bg-$colour'>Pickup Time: ".$row['pickupTime']."</li>";
					echo "<li class='list-group-item bg-$colour'>Total Paid: ".$row['price']."</li>";
					echo "<li class='list-group-item bg-dark'>Order Notes: ".$row['orderNotes']."</li>";
			  echo "</ul>";
				if ($status == "Unpaid")
				{
					echo "<button class='btn btn-$colour btn-lg text-white orderPaidButton' orderID='".$row['ID']."'>Order Paid</button>";
				}
				if ($status == "Needs Making")
				{
					echo "<button class='btn btn-$colour btn-lg text-white orderMadeButton' orderID='".$row['ID']."'>Order Made</button>";
				}
				if ($status == "Awaiting Pickup")
				{
					echo "<button class='btn btn-$colour btn-lg text-white orderCollectedButton' orderID='".$row['ID']."'>Order Collected</button>";
				}
				if ($status == "Completed")
				{
					echo "<button class='btn btn-$colour btn-lg text-white orderCompletedButton' orderID='".$row['ID']."'>Delete Order</button>";
				}
				echo "<div class='card-footer'><b>".$status."</b></div>";
				echo "</div>";
				echo "</div>";
			}
		}
	}
	echo "</div>";
}

//Function to calcuate the status of a users order, given certain parameters
function calculateOrderStatus($paid, $orderCompleted, $orderPickedUp)
{
	if ($paid == false)
	{
		return "Unpaid";
	}

	if ($orderCompleted == false)
	{
		return "Needs Making";
	}
	if ($orderPickedUp == false)
	{
		return "Awaiting Pickup";
	}
	return "Completed";
}

//Define the bootstrap specific card colours for order cards
function getCardColour($status)
{
	if ($status =="Unpaid")
	{
		return "danger";
	}
	if ($status == "Needs Making")
	{
		return "info";
	}
	if ($status == "Awaiting Pickup")
	{
		return "success";
	}
	return "secondary";
}
 ?>
