<?php
//Handle registration DB entry here from POST
session_start();
include("../db/dbConn.php");
include("../db/dbQueries.php");
include("userAccessLevel.php");
include("generateUserID.php");

//If there is data, add to DB as a new user
if (isset($_POST['password']))
{
	//Sanatise new password before hashing
	$password = $_POST['password'];
	$password = stripslashes($password);
	$password = mysqli_real_escape_string($conn, $password);
	//Hash password with default encryption, BCRYPT as of PHP 7
	$password = password_hash($password, PASSWORD_DEFAULT);

	//Get user access level from account type
	if($_POST['radioAccountType'] == 'student')
	{
		$accessLevel = UserAccessLevel::UserStudent;
	}
	if ($_POST['radioAccountType'] == 'staff')
	{
		$accessLevel = UserAccessLevel::UserStaff;
	}

	//Log creation time
	$creationTimeStamp = date("Y-m-d H:i:s");

	//Generate a new user ID string
	//TODO ensure user string does not already exist, else generate a new string
	$userID = generateUserID($accessLevel);

	$insertUser = $conn->prepare("INSERT INTO users (username, password, accountTypeKey, idNumber, firstName, lastName, gender, CCNumber, CCName, CCCVC, CCExpDate, accountBalance, creationTimeStamp, email) VALUES (?,?,?,?,?,?,?,?,?,?,?,5,?,?)");
	$insertUser->bind_param("ssissssssssss", $userID, $password, $accessLevel, $_POST["IDNumber"], $_POST["firstName"], $_POST["lastName"], $_POST["radioGender"], $_POST["CCNumber"], strtoupper($_POST["CCName"]), $_POST["CVC"], $_POST["CCExp"], $creationTimeStamp, $_POST["emailAddress"]);
	$insertUser->execute();
	$insertUser->close();

	//Provide newly created login information for user
	$_SESSION["newAccount"] = true;
	$_SESSION["newID"] = $userID;

	//Redirect to user account page
	header("location: ../../login.php");
}
else
{
	//No data worth adding to DB, redirect home
	header('location: ../../index.php');
}

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
		echo "_POST" .print_r($_POST). "<br>";
		echo "<h1> ROW COUNT: $aids</h1>";
		echo "<p>$count</p>";
		 ?>
 	</body>
 </html>
