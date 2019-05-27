<?php
//Handler for updating user account details
//TODO include more attributes for the user to be able to update
session_start();
require("../db/dbConn.php");
require("../db/dbQueries.php");

//Update email address
if(isset($_POST['emailAddress']))
{
	$updateEmail = $conn->prepare("UPDATE users set email = ? where ID = ?");
	$updateEmail->bind_param("si", $_POST['emailAddress'], $_SESSION['userNum']);
	$updateEmail->execute();
	$updateEmail->close();
}

//Update password
if(isset($_POST['password']))
{
	$password = $_POST['password'];
	$password = stripslashes($password);
	$password = mysqli_real_escape_string($conn, $password);
	//Hash password with default encryption, BCRYPT as of PHP 7
	$password = password_hash($password, PASSWORD_DEFAULT);
	$updatePassword = $conn->prepare("UPDATE users set password = ? where ID = ?");
	$updatePassword->bind_param("si", $password, $_SESSION['userNum']);
	$updatePassword->execute();
	$updatePassword->close();
}


header("location: ../../userpage.php");
 ?>

<h1>Profile Update handler</h1>
<h5>Debug: Post Variable Contents</h5>
<p><?php print_r($_POST); ?></p>
<h5>Debug: Session Variable Contents</h5>
<p><?php print_r($_SESSION); ?> </p>
