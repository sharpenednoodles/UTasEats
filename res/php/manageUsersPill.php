<?php
//HTML snippet for the Manage Users pill in the user account page.
 ?>
<h4>Manage User Accounts</h4>
<p>Change user account permissions by clicking on a user below.</p>
<div class="table-responsive">
	<?php
	//Get access levels from DB and store in array
	$getUserLevelsQuery = ("SELECT ID, accountType FROM accountType");
	$getUserLevels = $conn->query($getUserLevelsQuery);
	if ($getUserLevels->num_rows > 0)
	{
		while ($row = $getUserLevels->fetch_assoc())
		{
			$permissionLevelNames[$row['ID']] = $row["accountType"];
		}
	}

//Hide invalid permissions from user upgrade prompt
	switch((int)$_SESSION['accessLevel'])
	{
		case userAccessLevel::CafeManager:
		unset($permissionLevelNames[3]);
		case userAccessLevel::BoardMember:
		unset($permissionLevelNames[2]);
		unset($permissionLevelNames[1]);
		break;
	}

	$userQuery = "SELECT *, users.ID as userID, users.userName as userName from users inner join accountType on users.accountTypeKey = accountType.ID";
	buildCustomGenericList(array("User ID", "First Name", "Last Name", "Access Level"), array("userName", "firstName", "lastName", "accountType"), $conn, $userQuery, "UserAccountSelect", "userID");
	 ?>
</div>
<modal>
	<div class="modal fade" id="userAccountModal" tabindex="-1" role="dialog">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="userAccountModalTitle">Edit User Permission levels for </h5>
	        <button type="button" id ="userAccountCrossButton" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div id="userAccountBody"class="modal-body">
					<form action="res/php/userPermissionsHandler.php" method="post" id="userAccountForm">
						<div class="form-group">
							 <label>User Permission</label>
							 <select class="form-control" name="permissionChange" id="permissionSelector">
									 <?php
										 foreach ($permissionLevelNames as $permissionID => $permissionName)
										 {
											 echo "<option>$permissionName</option>";
										 }
										?>
							 </select>
						</div>
						<div id="hiddenUserInputs"></div>
					</form>
					<p>Please note that changing an accounts permissions will change the userID to a new group prefix</p>
				</div>
	      <div class="modal-footer">
	        <button id="userAccountCancelButton" type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
	        <button id="userAccountConfirmButton" type="submit" class="btn btn-primary">Confirm</button>
	      </div>
	    </div>
	  </div>
	</div>
</modal>
