<?php
//Provided utilities related to cafe SQLI information

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
 ?>
