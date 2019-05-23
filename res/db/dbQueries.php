<?php
//Define out SQL queries here

$queryMasterBase =  "SELECT item_to_cafe.itemID, masterFoodList.name as item, IFNULL(startDate, 'N/A') as startDate, IFNULL(endDate, 'N/A') as endDate,
CONCAT('$', masterFoodList.price) as price, masterFoodList.description, cafe.name as cafe, foodType.name as type from item_to_cafe
inner join cafe on cafe.cafeID = item_to_cafe.cafeID
inner join masterFoodList on masterFoodList.itemID = item_to_cafe.itemID
inner join foodType on masterFoodList.type = foodType.typeID";

//Per cafe filters
$queryLazenbysList = $queryMasterBase." WHERE cafe.name = \"Lazenbys\" order by item";
$querySuzyLeeList = $queryMasterBase." WHERE cafe.name = \"Suzy Lee\" order by item";
$queryTradeTableList = $queryMasterBase." WHERE cafe.name = \"Trade Table\" order by item";
$queryMasterList = $queryMasterBase." order by itemID";


$queryMasterOrdersBase = "SELECT orderList.ID, users.username as user, CONCAT('$', orderList.price) as price, orderList.creationTimeStamp, cafe.name as cafe, TRIM(LEADING '0' FROM TIME_FORMAT(pickupTime, \"%h:%i%p\")) as pickupTime,
orderNotes, masterFoodList.name, quantity, paid, orderCompleted, orderPickedUp from orderList inner join cafe on cafe.cafeID = orderList.cafeID
inner join users on userID = users.ID inner join item_to_order on orderList.ID = item_to_order.orderID
inner join masterFoodList on item_to_order.itemID = masterFoodList.itemID";

$queryLazenbysOrders = $queryMasterOrdersBase. " WHERE cafe.name ='Lazenbys' order by orderList.ID";
$querySuzyLeeOrders = $queryMasterOrdersBase. " WHERE cafe.name ='Suzy Lee' order by orderList.ID";
$queryTradeTableOrders = $queryMasterOrdersBase. " WHERE cafe.name ='Trade Table' order by orderList.ID";
$queryMasterOrders = $queryMasterOrdersBase." order by orderList.ID";


//Basic function to get a value for less sepcific gets
function getSQLValue($sqli, $table, $rowLabel, $IDLabel, $IDValue)
{
	$result = $sqli->query("SELECT $rowLabel FROM $table where $IDLabel = '$IDValue'");
	while($row = $result->fetch_assoc())
	{
		$value = $row[$rowLabel];
	}
	return strval($value);
}

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
