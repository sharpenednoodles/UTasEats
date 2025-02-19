<?php
//Get frequently used account details from SQL DB and make them available globally to all pages on the site via SESSION variables
//Will update the session variables wherever this file is included

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
		$_SESSION['accessLevel'] = $row['accountTypeKey'];
		$_SESSION['cafeEmpID'] = $row['cafeEmployment'];
	}
	$query->close();

	//Get Cafe Employer name is applicable
	$query = $conn->prepare("SELECT * from users inner join cafe on cafeEmployment=cafeID WHERE username = ?");
	$query->bind_param("s", $_SESSION['userID']);
	$query->execute();
	$cafeEmployment = $query->get_result();


	while($row = $cafeEmployment->fetch_assoc())
	{
		$_SESSION['cafeEmployment'] = $row['name'];
	}
	$query->close();

 ?>
