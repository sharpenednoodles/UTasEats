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
 ?>
