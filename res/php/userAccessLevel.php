<?php
//Enum to represent user access levels
abstract class UserAccessLevel
{
    const BoardDirector = 1;
    const BoardMember = 2;
    const CafeManager = 3;
		const CafeStaff = 4;
		const UserStaff = 5;
		const UserStudent = 6;
}

//Set user access level from string
function getAccessLevel($AC)
{
	if ($AC == "DB")
	{
		return UserAccessLevel::BoardDirector;
	}
	if ($AC == "BM")
	{
		return UserAccessLevel::BoardMember;
	}
	if ($AC == "CM")
	{
		return UserAccessLevel::CafeManager;
	}
	if ($AC == "CS")
	{
		return UserAccessLevel::CafeStaff;
	}
	if ($AC == "UE")
	{
		return UserAccessLevel::UserStaff;
	}
	if ($AC == "US")
	{
		return UserAccessLevel::UserStudent;
	}
	return error;
}

//Set a welcome string depending on access level
function welcomeMessage($accessLevel)
{
	switch($accessLevel)
	{
		case UserAccessLevel::BoardDirector:
			$welcomeString = "Hello Board Director. Are you ready to waste all our money? You can manage user permissions below.";
			break;
		case UserAccessLevel::BoardMember:
			$welcomeString = "Wassup board member? The master list can be manaaged below.";
			break;
		case UserAccessLevel::CafeManager:
			$welcomeString = "Welcome Manager. Hope you are ready to work for that extra 50 cents an hour! You can manage your restuarants menu below.";
			break;
		case UserAccessLevel::CafeStaff:
			$welcomeString = "Hello comrade. Get ready for strenuous working time. Your shifts can be seen below.";
			break;
		case UserAccessLevel::UserStaff:
			$welcomeString = "Welcome to UTAS Eats. Staff discounts coming soon. Watch this space. See our available menus below.";
			break;
		case UserAccessLevel::UserStudent:
			$welcomeString = "Welcome to UTAS Eats. We hope the service will make getting food between your classes a breeze! See our available menus below.";
			break;
		default:
			$welcomeString = "You are not logged in. You should not be able to see this page";
	}
	return $welcomeString;
}

 ?>
