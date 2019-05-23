<?php
//Add funds via a POST form capture
session_start();
require("../db/dbConn.php");
require("../db/dbQueries.php");
require("userAccessLevel.php");


//Get access levels from DB and store in array
$getUserLevelsQuery = ("SELECT ID, accountType FROM accountType");
$getUserLevels = $conn->query($getUserLevelsQuery);
if ($getUserLevels->num_rows > 0)
{
	while ($row = $getUserLevels->fetch_assoc())
	{
		$permissionLevelNames[$row['ID']] = $row["accountType"];
	}
}


if(isset($_POST["permissionChange"]))
{
	$newAccessLevel = array_search($_POST['permissionChange'], $permissionLevelNames);
	$changeAccessLevel = $conn->prepare("UPDATE users SET accountTypeKey = ? WHERE ID = ?");
	$changeAccessLevel->bind_param("ii", $newAccessLevel, $_POST["userID"]);
	$changeAccessLevel->execute();
	$changeAccessLevel->close();


	$oldUserString = substr(getSQLValue($conn, 'users', 'username', 'ID', $_POST["userID"]),2);
	$newPrefix = getAccessCode($newAccessLevel);
	$newUserName = $newPrefix.$oldUserString;
	$changeUsername = $conn->prepare("UPDATE users SET username = ? WHERE ID = ?");
	$changeUsername->bind_param("si", $newUserName, $_POST["userID"]);
	$changeUsername->execute();
	$changeUsername->close();

	if ($_SESSION['userNum'] == $_POST["userID"])
	{
		//Log out of the account since we just changed our permissions
		header("location: logout.php");
	}
	else
	{
		//Redirect back to daskboard
		header("location: ../../userpage.php");
	}
}
else
{
	//redirect to home, no variables set
	header("location: ../../index.php");
}


 ?>

 <h1>User permission handler</h1>
 <h5>Debug: Post Variable Contents</h5>
 <p><?php print_r($_POST); ?></p>
 <h5>Debug: Session Variable Contents</h5>
 <p><?php print_r($_SESSION); ?> </p>
 <h5>Debug: Old username</h5>
 <p><?php echo($oldUserString); ?> </p>
 <h5>Debug: New Prefix</h5>
 <p><?php echo($newPrefix); ?> </p>
 <h5>Debug: New username</h5>
 <p><?php echo($newUserName); ?> </p>
