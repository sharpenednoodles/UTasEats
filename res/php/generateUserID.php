<?php
//Generates a random userID for a new account given the accounts permission level
//Currently does not chack whether the generatedID is unique, be sure to check whether the ID exists when using this function

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
		break;
		case UserAccessLevel::CafeStaff:
		$accessCode = "CS";
		break;
		case UserAccessLevel::CafeManager:
		$accessCode = "CM";
		break;
		case UserAccessLevel::BoardMember:
		$accessCode = "BM";
		break;
		case UserAccessLevel::BoardDirector:
		$accessCode = "DB";
		break;
	}
		$userNumber = rand(1000, 9999);
		$generatedCode = $accessCode.$userNumber;
		return $generatedCode;
}
 ?>
