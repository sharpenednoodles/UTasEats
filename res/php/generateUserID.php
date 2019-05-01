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
