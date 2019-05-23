//Basic JS to handle staff change modal
$(".StaffSelect").click(function(){
	var ID = $(this).attr("id");
	var firstName = $(this).find("td:nth-child(2)").text();
	var lastName = $(this).find("td:nth-child(1)").text();
	var oldCafe = $(this).find("td:nth-child(3)").text();

	$("#cafeStaffModalTitle").text("Edit Position for "+firstName+" "+lastName);
	$("#hiddenInputs").append("<input type='hidden' name='userID' value='"+ID+"'>");
	$("#cafeSelector").val(oldCafe);
	$('#cafeStaffModal').modal('show');
});

$("#cafeStaffCancelButton").click(function() {
	$("#hiddenInputs").empty();
	$("#cafeStaffModalTitle").empty();
});

$("#cafeStaffCrossButton").click(function() {
	$("#hiddenInputs").empty();
	$("#cafeStaffModalTitle").empty();
});

$("#cafeStaffConfirmButton").click(function() {
	$("#cafeStaffForm").submit();
});
