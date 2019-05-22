<?php
//Provided utilities related to cafe SQLI information

//Get restaurant descriptions from the DB
$LazenbysDescription = getDescription($conn, "Lazenbys");
$SuzyLeeDescription = getDescription($conn, "Suzy Lee");
$TradeTableDescription = getDescription($conn, "Trade Table");

function getOpenTime($sqli, $cafeName)
{
	$result = $sqli->query("SELECT openTime FROM cafe where cafe.name= '$cafeName'");
	while($row = $result->fetch_assoc())
	{
		$value = $row["openTime"];
	}
	return $value;
}

function getCloseTime($sqli, $cafeName)
{
	$result = $sqli->query("SELECT closeTime FROM cafe where cafe.name= '$cafeName'");
	while($row = $result->fetch_assoc())
	{
		$value = $row["closeTime"];
	}
	return $value;
}

function getDescription($sqli, $cafeName)
{
	$result = $sqli->query("SELECT description FROM cafe where cafe.name= '$cafeName'");
	while($row = $result->fetch_assoc())
	{
		$value = $row["description"];
	}
	return strval($value);
}

function getID($sqli, $cafeName)
{
	$result = $sqli->query("SELECT cafeID FROM cafe where cafe.name= '$cafeName'");
	while($row = $result->fetch_assoc())
	{
		$value = $row["cafeID"];
	}
	return strval($value);
}

function getCafeName($sqli, $cafeID)
{
	$result = $sqli->query("SELECT cafe.name FROM cafe where cafe.cafeID= '$cafeID'");
	while($row = $result->fetch_assoc())
	{
		$value = $row["name"];
	}

	return strval($value);
}

function roundToQuarterHour($timestring)
{
	//15 minutes = 60 seconds * 15
	$round = 15*60;
	$rounded = ceil($timestring / $round) * $round;
	return $rounded;
}

 ?>
