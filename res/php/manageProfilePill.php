<h4>Manage Profile</h4>
<form class="" action="res/php/profileImageUploadHandler.php" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<img src="<?php echo $_SESSION['profilePicture'];?>" width="100">
		<label>Change Profile Picture</label>
		<input type="file" class="form-control-file" name="profileImage">
		<input type="submit" value="Upload">
	</div>
</form>
<form class="" action="res/php/profileEdit.php" method="post">
	<label>Change Email</label>
	<div class="form-row">
	<div class="input-group col-md-6 col-sm-12 mb-4">
		<div class="input-group-prepend">
			<span class="input-group-text" id="inputGroupPrepend">@</span>
		</div>
		<input class="form-control" type="email" name="emailAddress" placeholder="Enter Email Address" id="emailInput">
		<div class="invalid-feedback" id="invalidEmail">Please enter a valid email address</div>
		</div>
	</div>
	<label>Change Password</label>
	<div class="form-row">
	<div class="form-group col-md-6 col-sm-12">
		<input class="form-control" type="password" name="password" maxlength="70" placeholder="Password" id="userPasswordInput">
		<div class="invalid-feedback" id="invalidPassword"></div>
	</div>
</div>
<div class="form-row mb-3">
	<div class="form-group col-md-6 col-sm-12">
		<input class="form-control" type="password" name="passwordConfirm" maxlength="70" placeholder="Confirm Password" id="userPasswordInputConfirm">
		<div class="invalid-feedback" id="invalidConfirmPassword">Passwords do not match</div>
	</div>
</div>
<button type="submit" class="btn btn-primary"name="button" id="passwordSubmitButton">Save Changes</button>
</form>
