<?php
//Define our main SQL queries here
//Since these qurieis and functions are heavily used, we will keep them here for easy access

//Base variable for qurying the master list. DO NOT MAKE AN SQL QUERY FROM THIS VAR DIRECTLY. Use $queryMasterList instead
$queryMasterBase =  "SELECT item_to_cafe.itemID, masterFoodList.name as item, IFNULL(startDate, 'N/A') as startDate, IFNULL(endDate, 'N/A') as endDate,
CONCAT('$', masterFoodList.price) as price, masterFoodList.description, cafe.name as cafe, foodType.name as type from item_to_cafe
inner join cafe on cafe.cafeID = item_to_cafe.cafeID
inner join masterFoodList on masterFoodList.itemID = item_to_cafe.itemID
inner join foodType on masterFoodList.type = foodType.typeID";

//Query the cafe menu per cafe filter
$queryLazenbysList = $queryMasterBase." WHERE cafe.name = \"Lazenbys\" order by item";
$querySuzyLeeList = $queryMasterBase." WHERE cafe.name = \"Suzy Lee\" order by item";
$queryTradeTableList = $queryMasterBase." WHERE cafe.name = \"Trade Table\" order by item";
$queryMasterList = $queryMasterBase." order by itemID";

//Base variable for querying the current orders in the system. DO NOT MAKE AN SQL QUERY FROM THIS VAR DIRECTLY. Use $queryMasterOrders instead
$queryMasterOrdersBase = "SELECT orderList.ID, users.username as user, firstName, lastName, CONCAT('$', orderList.price) as price, orderList.creationTimeStamp, cafe.name as cafe, TRIM(LEADING '0' FROM TIME_FORMAT(pickupTime, \"%h:%i%p\")) as pickupTime,
orderNotes, masterFoodList.name, quantity, paid, orderCompleted, orderPickedUp from orderList inner join cafe on cafe.cafeID = orderList.cafeID
inner join users on userID = users.ID inner join item_to_order on orderList.ID = item_to_order.orderID
inner join masterFoodList on item_to_order.itemID = masterFoodList.itemID";

//Query the order list on a per cafe filter
$queryLazenbysOrders = $queryMasterOrdersBase. " WHERE cafe.name ='Lazenbys' order by orderList.ID";
$querySuzyLeeOrders = $queryMasterOrdersBase. " WHERE cafe.name ='Suzy Lee' order by orderList.ID";
$queryTradeTableOrders = $queryMasterOrdersBase. " WHERE cafe.name ='Trade Table' order by orderList.ID";
$queryMasterOrders = $queryMasterOrdersBase." order by orderList.ID";


//Basic function to get a value from any given table, row label, given a named ID
function getSQLValue($sqli, $table, $rowLabel, $IDLabel, $IDValue)
{
	$result = $sqli->query("SELECT $rowLabel FROM $table where $IDLabel = '$IDValue'");
	while($row = $result->fetch_assoc())
	{
		$value = $row[$rowLabel];
	}
	return strval($value);
}

//Basic function to determine whether a value like the one given exists from any given table, row label, given a named ID
function getSQLLikeValue($sqli, $table, $rowLabel, $IDLabel, $IDValue)
{
	$result = $sqli->query("SELECT $rowLabel FROM $table where $IDLabel like '%$IDValue'");
	while($row = $result->fetch_assoc())
	{
		$value = $row[$rowLabel];
	}
	return strval($value);
}
 ?>
