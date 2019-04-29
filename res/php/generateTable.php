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

function buildCafeMenu($tableHeaders, $sqli, $SQLQuery)
{
	buildHeaders($tableHeaders);
	buildSQLBody(array('item','price','type'), $sqli, $SQLQuery);
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
			echo("<tr>");
			foreach ($rowLabels as $rowLabel)
			{
				echo("<td>" .$row["$rowLabel"]."</td>");
			}
			echo("</tr>");
		}
	}
	echo "</tbody>";
}

//Special Case - Create body of master list from SQL connection and query - HELPER FUNCTION, ;['pDO NOT CALL DIRECTLY
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
					echo("<tr>");
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
