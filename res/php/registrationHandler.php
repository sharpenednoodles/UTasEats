<?php
//Handle registration DB entry here from POST
session_start();
include("../db/dbConn.php");
include("../db/dbQueries.php");
include("userAccessLevel.php");
include("generateUserID.php");



 ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
 	<head>
 		<meta charset="utf-8">
 		<title></title>
 	</head>
 	<body>
		<h1>Debug page</h1>
 		<?php
		echo "_SESSION" .print_r($_SESSION) ."<br>";
		echo "_POST" .print_r($_POST);
		 ?>
 	</body>
 </html>
