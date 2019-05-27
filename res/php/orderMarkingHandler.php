<?php
//Handler for changing the status of an order card via POST submission
session_start();
require("../db/dbConn.php");
require("../db/dbQueries.php");

if(isset($_POST['markPaid']))
{
	$editOrder = $conn->prepare("UPDATE orderList set paid = true WHERE ID = ?");
	$editOrder->bind_param("i", $_POST['markPaid']);
	$editOrder->execute();
	$editOrder->close();
}
if(isset($_POST['markMade']))
{
	$editOrder = $conn->prepare("UPDATE orderList set orderCompleted = true WHERE ID = ?");
	$editOrder->bind_param("i", $_POST['markMade']);
	$editOrder->execute();
	$editOrder->close();
}
if(isset($_POST['markCollected']))
{
	$editOrder = $conn->prepare("UPDATE orderList set orderPickedUp = true WHERE ID = ?");
	$editOrder->bind_param("i", $_POST['markCollected']);
	$editOrder->execute();
	$editOrder->close();
}

if(isset($_POST['markCompleted']))
{
	$editOrder = $conn->prepare("DELETE from orderList WHERE ID = ?");
	$editOrder->bind_param("i", $_POST['markCompleted']);
	$editOrder->execute();
	$editOrder->close();
	header('location: ../../userpage.php');
}

header('location: ../../orderList.php');
 ?>
 <h1>Order Marking handler</h1>
<h5>Debug: Post Variable Contents</h5>
<p><?php print_r($_POST); ?></p>
<h5>Debug: Session Variable Contents</h5>
<p><?php print_r($_SESSION); ?> </p>
