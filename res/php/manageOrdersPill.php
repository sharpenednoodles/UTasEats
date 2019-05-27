<?php
//HTML snippet for the Manage orders pill found wihtin the user page
//Displays different orders depnding on the users access level and employment details
 ?>
<h4>Manage Orders</h4>
<?php
switch((int)$_SESSION['accessLevel'])
{
	case userAccessLevel::BoardDirector:
	case userAccessLevel::BoardMember:
	case userAccessLevel::CafeManager:
		//Build the order cards for all cafes
		buildOrderCards($conn, $queryMasterOrders, true);
	break;
	case userAccessLevel::CafeStaff:
	//Build the order cards for just the specific cafe
	if ($_SESSION['cafeEmployment'] == 'Lazenbys')
	{
		buildOrderCards($conn, $queryLazenbysOrders, true);
	}
	elseif ($_SESSION['cafeEmployment'] == 'Suzy Lee')
	{
		buildOrderCards($conn, $querySuzyLeeOrders, true);
	}
	elseif ($_SESSION['cafeEmployment'] == 'Trade Table')
	{
		buildOrderCards($conn, $queryTradeTableOrders, true);
	}
	break;
}
 ?>
<form action="res/php/orderMarkingHandler.php" method="post" id="manageOrderForm"></form>
