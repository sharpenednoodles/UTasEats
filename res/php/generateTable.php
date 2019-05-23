<?php
//Generate html tables from SQL data for the menu contents

//TODO, reference the SQL strings directly so they do not need to be passed to function
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

//Same as above, but we can specify a custom class for javascript interactivity, and an optional id from the table to classify with
function buildCustomGenericList($tableHeaders, $sqlHeaders, $sqli, $SQLQuery, $customClass, $customID)
{
	buildHeaders($tableHeaders);
	buildSQLBodyCustom($sqlHeaders, $sqli, $SQLQuery, $customClass, $customID);
	finishTable();
}

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
			if ($includeExpiry == true || ((($row['endDate'] >= $currentDate) || $row['endDate'] == "N/A") && (($row['startDate'] <= $currentDate) || $row['startDate'] == "N/A")))
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
//Close table tag
function finishTable()
{
	echo "</table>";
	echo "</div>";
}

 ?>
