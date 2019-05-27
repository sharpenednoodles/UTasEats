<?php
//HTML snippet for a user card that gives the user the ID of their newly created profile
 ?>
<div class="col-sm-12 col-md-7">
	<div class="card mb-4">
		<div class="card-body text-center">
			<h5 class=card-title>New Account Created</h5>
			<p class="card-text">Your new userID is <?php echo($_SESSION['newID']);?></p>
		</div>
	</div>
</div>
