<h4>Manage Cafe Staff</h4>
<div class="table-responsive">
	<?php
	//Get cafe list from the DB and store in array
	$getCafeQuery = ("SELECT cafeID, name FROM cafe");
	$getCafes = $conn->query($getCafeQuery);
	if ($getCafes->num_rows > 0)
	{
		while ($row = $getCafes->fetch_assoc())
		{
			$cafeNames[$row['cafeID']] = $row["name"];
		}
	}

	$staffQuery = "SELECT *, users.ID as userID from users inner join cafe on users.cafeEmployment = cafe.cafeID inner join accountType on users.accountTypeKey = accountType.ID where accountType.accessCode = 'CM' or accountType.accessCode = 'CS'";
	buildCustomGenericList(array("Surname", "First Name", "Cafe"), array("lastName", "firstName", "name"), $conn, $staffQuery, "StaffSelect", "userID");
	 ?>
</div>
<modal>
	<div class="modal fade" id="cafeStaffModal" tabindex="-1" role="dialog">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="cafeStaffModalTitle">Edit Cafe Position for </h5>
	        <button type="button" id ="cafeStaffCrossButton" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div id="cafeStaffBody"class="modal-body">
					<form action="res/php/cafeStaffHandler.php" method="post" id="cafeStaffForm">
						<div class="form-group">
							 <label>Cafe Position</label>
							 <select class="form-control" name="cafeChange" id="cafeSelector">
									 <?php
										 foreach ($cafeNames as $cafeID => $cafeName)
										 {
											 echo "<option cafeID='$cafeID'>$cafeName</option>";
										 }
										?>
							 </select>
						</div>
						<div id="hiddenInputs"></div>
					</form>
				</div>
	      <div class="modal-footer">
	        <button id="cafeStaffCancelButton" type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
	        <button id="cafeStaffConfirmButton" type="submit" class="btn btn-primary">Confirm</button>
	      </div>
	    </div>
	  </div>
	</div>
</modal>
