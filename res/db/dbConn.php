<?php
//Taken from tutorial code
//My SQL variables
//CHANGE WHEN TRANFERRING TO ALACRITAS
$address = "localhost";
$username = "sharpenednoodles";
$password = "password";
$DB = "UTasEats";

$conn = new mysqli($address, $username, $password, $DB);

if (mysqli_connect_errno()) {
			$err = mysqli_connect_error();
	    $credentialStatus = "Connect failed: ".$err;
	    //exit();
	}
	else
	{
			$credentialStatus = "Credentials Authenticated";
	}
?>
