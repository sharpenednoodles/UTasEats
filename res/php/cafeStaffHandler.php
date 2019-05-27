<?php
//Handler to modify cafe staffs current employer details
session_start();
require("../db/dbConn.php");
require("../db/dbQueries.php");

//Get cafe list from the DB and store in array
$getCafeQuery = ("SELECT cafeID, name FROM cafe");
$getCafes = $conn->query($getCafeQuery);
if ($getCafes->num_rows > 0)
{
	while ($row = $getCafes->fetch_assoc())
	{
		$cafeNames[$row['cafeID']] = $row["name"];
	}
}

if(isset($_POST["cafeChange"]))
{
	//Get the key (cafeID) from the cafe name
	$cafeID = array_search($_POST['cafeChange'], $cafeNames);
	$changeCafe = $conn->prepare("UPDATE users SET cafeEmployment = ? WHERE ID = ?");
	$changeCafe->bind_param("ii", $cafeID, $_POST["userID"]);
	$changeCafe->execute();
	$changeCafe->close();
}


header("location: ../../userpage.php");
 ?>

 <h1>Cafe staff handler</h1>
 <h5>Debug: Post Variable Contents</h5>
 <p><?php print_r($_POST); ?></p>
 <h5>Debug: Session Variable Contents</h5>
 <p><?php print_r($_SESSION); ?> </p>
