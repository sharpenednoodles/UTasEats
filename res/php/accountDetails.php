<?php
//Get account details from SQL DB and make them available to the page

	$query = $conn->prepare("SELECT * from users WHERE username = ?");
	$query->bind_param("s", $_SESSION['userID']);
	$query->execute();
	$accountDetails = $query->get_result();

	while($row = $accountDetails->fetch_assoc())
	{
		$_SESSION['firstName'] = $row['firstName'];
		$_SESSION['lastName'] = $row['lastName'];
		$_SESSION['email'] = $row['email'];
		$_SESSION['accountBalance'] = "$".$row['accountBalance'];
		$_SESSION['CCNumber'] = $row['CCnumber'];
		$_SESSION['userNum'] = $row['ID'];
		$_SESSION['profilePicture'] = $row['imagePath'];
	}

	$query->close();
 ?>
