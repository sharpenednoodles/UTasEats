<h4>View My Orders</h4>
<div class="table-responsive">
	<?php
	$queryOrderByName = $queryMasterOrdersBase." WHERE users.username ='".$_SESSION['userID']."' order by orderList.ID";
	buildGenericList(array("Order Number", "Item", "Quantity", "Cafe", "Status", "Pick Up"), array("ID", "name","quantity", "cafe", "orderCompleted", "pickupTime"), $conn, $queryOrderByName);
	 ?>
</div>
