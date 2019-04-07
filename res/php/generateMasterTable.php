<?php

//datatypes/definitions
abstract class ItemGroup
{
		const Food = 1;
		const Drink = 2;
}

abstract class Restaurant
{
	const Lazenbys = 1;
	const SuzyLee = 2;
	const TradeTable = 3;
}


//Print master list data from array
function printMasterTable($masterTableArr, $isMaster, $loggedIn)
{
	foreach ($masterTableArr as $itemArr)
	{
		echo "<tr class=\"clickable\" >";
		echo "<td id=\"itemName\">";
		echo $itemArr["ItemName"];
		echo"</td>";
		echo "<td id=\"price\">";
		//Currency formatting
		echo '$';
		echo number_format($itemArr["Price"],2);
		echo"</td>";
		echo "<td id=\"itemType\">";
		getItemType($itemArr["Type"]);
		echo"</td>";

		if ($isMaster)
		{
			echo "<td id=\"itemResturants\">";
			printRestaurants($itemArr["Restaurant"]);
			echo"</td>";
		}

		if($loggedIn == true && $isMaster == false)
		{
			//print elements to add items to cart.
			echo <<<AMT
			<td>
			<div class="input-group">
				<input type="number" value="0" min="0" step="1" class="form-control" id="itemQuantity"/>
			</div>
			</td>
AMT;
		}
		echo "</tr>";
	}
}

//helper functions
function getItemType($itemID)
{
	switch ((int)$itemID)
	{
		case ItemGroup::Food:
		echo("Food");
		break;
		case ItemGroup::Drink:
		echo("Drink");
		break;
		default:
		echo("Unknown");
	}
}

function printRestaurants($resturantArray)
{
	foreach ($resturantArray as $resturant)
	{
		switch ((int)$resturant)
		{
			case Restaurant::Lazenbys:
			echo("Lazenbys");
			break;
			case Restaurant::SuzyLee:
			echo("Suzy Lee");
			break;
			case Restaurant::TradeTable:
			echo("Trade Table");
			break;
			default:
			echo("Unknown");
		}
		echo ", ";
	}
}

 ?>
