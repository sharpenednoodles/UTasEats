<?php
//TODO check existing IDs in DB

function generateUserID($userType)
{
	$accessCode = "error";
	switch((int)$userType)
	{
		case UserAccessLevel::UserStaff:
		$accessCode = "UE";
		break;
		case UserAccessLevel::UserStudent:
		$accessCode = "US";
	}
		$userNumber = rand(1000, 9999);
		$generatedCode = $accessCode.$userNumber;
		return $generatedCode;
}
 ?>
