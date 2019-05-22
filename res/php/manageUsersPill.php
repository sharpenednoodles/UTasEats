<h4>Manage Accounts</h4>
<div class="table-responsive">
	<?php
	$queryUsers = "SELECT userName, firstName, lastName, accountType from users inner join accountType on accountTypeKey = accountType.ID";
	buildGenericList(array("User ID", "First Name", "Last Name", "Access Level"), array("userName", "firstName", "lastName", "accountType"), $conn, $queryUsers);
	 ?>
</div>
