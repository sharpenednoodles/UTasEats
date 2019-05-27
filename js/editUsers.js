//Basic JS to handle user permission levels in the Manage Users Pill
$(".UserAccountSelect").click(function(){
	var ID = $(this).attr("id");
	var firstName = $(this).find("td:nth-child(2)").text();
	var lastName = $(this).find("td:nth-child(3)").text();
	var oldPermissions = $(this).find("td:nth-child(4)").text();

	$("#userAccountModalTitle").text("Edit Permissions for "+firstName+" "+lastName);
	$("#hiddenUserInputs").append("<input type='hidden' name='userID' value='"+ID+"'>");
	$("#permissionSelector").val(oldPermissions);
	$('#userAccountModal').modal('show');
});

$("#userAccountCancelButton").click(function() {
	$("#hiddenUserInputs").empty();
	$("#cafeStaffModalTitle").empty();
});

$("#userAccountCrossButton").click(function() {
	$("#hiddenUserInputs").empty();
	$("#cafeStaffModalTitle").empty();
});

$("#userAccountConfirmButton").click(function() {
	$("#userAccountForm").submit();
});
