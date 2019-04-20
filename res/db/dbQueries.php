<?php
//Define out SQL queries here
$queryMasterList =  "SELECT item_to_cafe.itemID, masterFoodList.name as item,
masterFoodList.price, masterFoodList.description, cafe.name as cafe, foodType.name as type from item_to_cafe
inner join cafe on cafe.cafeID = item_to_cafe.cafeID
inner join masterFoodList on masterFoodList.itemID = item_to_cafe.itemID
inner join foodType on masterFoodList.type = foodType.typeID";

//Per cafe filters
$queryLazenbysList = $queryMasterList." WHERE cafe.name = \"Lazenbys\"";
$querySuzyLeeList = $queryMasterList." WHERE cafe.name = \"Suzy Lee\"";
$queryTradeTableList = $queryMasterList." WHERE cafe.name = \"Trade Table\"";

 ?>
