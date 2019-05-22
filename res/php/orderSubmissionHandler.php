<?php
//Handle menu logic hebre

session_start();
require("../db/dbConn.php");
require("../db/dbQueries.php");

//If form data posix_set
//Todo: check whether account has enough money, else send them to a not enough momey page
if (isset($_POST['itemCount']))
{
	$accountBalance = (int)substr($_SESSION['accountBalance'], 1);
	if ($_POST['price'] <= $accountBalance)
	{
		$timeFormatted = date("H:i:s", strtotime($_POST['PickUpTime']));
		$insertOrder = $conn->prepare("INSERT INTO orderList (userID, price, cafeID, pickupTime, orderNotes, paid) VALUES (?,?,?,?,?,1)");
		$insertOrder->bind_param("idiss", $_SESSION['userNum'], $_POST['price'], $_POST['cafe'], $timeFormatted, $_POST['OrderNotes']);
		$insertOrder->execute();
		$orderID = $conn->insert_id;
		$insertOrder->close();

		//Insert order information into pivot table
		$insertItem = $conn->prepare("INSERT INTO item_to_order (orderID, itemID, quantity) VALUES (?,?,?)");
		for ($i = 0; $i < $_POST['itemCount']; $i++)
		{
			$insertItem->bind_param("iii", $orderID, $_POST['item'.$i]["id"], $_POST['item'.$i]["quantity"]);
			$insertItem->execute();
		}

		//Deduct the $accountBalance
		$newBalance = $accountBalance - $_POST['price'];
		$deductFunds = $conn->prepare("UPDATE users SET accountBalance = ? WHERE ID = ?");
		$deductFunds->bind_param("di", $newBalance, $_SESSION['userNum']);
		$deductFunds->execute();
		$deductFunds->close();
		$_SESSION['accountBalance'] = "$".$newBalance;
		$_SESSION['ORDER_number'] = $orderID;
		$_SESSION['ORDER_collectionTime'] = $_POST['PickUpTime'];
	}
	else
	{
		$_SESSION['ORDER_insuffFunds'] = true;
	}
	//Redirect to order page
	$_SESSION['ORDER_processed'] = true;
	$_SESSION['ORDER_cafe'] = $_POST['cafe'];
	header('location: ../../order.php');
}
else
{
	//No data worth adding to DB, redirect home
	header('location: ../../index.php');
}


 ?>
 <h1>Order handler</h1>
<h5>Debug: Post Variable Contents</h5>
<p><?php print_r($_POST); ?></p>
<h5>Debug: Session Variable Contents</h5>
<p><?php print_r($_SESSION); ?> </p>
<h5>Order Number:</h5>
<p><?php echo($orderID); ?> </p>
