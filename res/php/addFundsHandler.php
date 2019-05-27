<?php
//Handler for adding funds to a given users account
session_start();
require("../db/dbConn.php");
require("../db/dbQueries.php");

if(isset($_POST["rechargeAmount"]))
{
	$increaseFunds = $conn->prepare("UPDATE users SET accountBalance = accountBalance + ? WHERE ID = ?");
	$increaseFunds->bind_param("ii", $_POST["rechargeAmount"], $_SESSION["userNum"]);
	$increaseFunds->execute();
	$increaseFunds->close();
}

header("location: ../../userpage.php");
 ?>

 <h1>Add funds handler</h1>
 <h5>Debug: Post Variable Contents</h5>
 <p><?php print_r($_POST); ?></p>
 <h5>Debug: Session Variable Contents</h5>
 <p><?php print_r($_SESSION); ?> </p>
