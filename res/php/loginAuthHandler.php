<?php
//Handle login authentication logic here
session_start();
include("../db/dbConn.php");
include("../db/dbQueries.php");
include("userAccessLevel.php");

//Attempt to authenticate the user if userID field was set
if (isset($_POST['userID']))
{

	//Get password and sanitise string
	$password = $_POST['password'];
	$password = stripslashes($password);
	$password = mysqli_real_escape_string($conn, $password);

	$queryUsers = $conn->prepare("SELECT * FROM users WHERE username = ?");
	$queryUsers->bind_param("s", $_POST['userID']);
	$queryUsers->execute();
	$result = $queryUsers->get_result();

	//Get password hash from SQL result
	if ($result->num_rows > 0)
	{
		while($row = $result->fetch_assoc())
		{
			$hash = $row['password'];
			$activeAccount = $row['activeAccount'];
		}
	}

	$rows = mysqli_num_rows($result);

//Check to see whether the USERID exists, the password matches, and the account is currently marked as active, before authenticating
	if ($rows == 1 && password_verify($password, $hash) && $activeAccount == true)
	{
		//Correct password, login
		$_SESSION['userID'] = $_POST['userID'];
		$_SESSION['loggedIn'] = true;
		//Get access level from the DB
		$accessString = substr($_SESSION['userID'], 0, 2);
		$accessLevel = getAccessLevel($accessString);
		$_SESSION['accessLevel'] = $accessLevel;

		//Redirect to userpage
		header('location: ../../userpage.php');
	}
	else
	{
		//Unable to authenticate, or user account is disabled
		//redirect to error page
		header('location: ../../error.php');
	}
}
else
{
	//Blank string, redirect to the homepage
	header('location: ../../index.php');
}
 ?>
