//Recharge functionality
$(".recharge").click(function() {
	var amount = $(this).attr("amount");
	var ccNum = $("#addFundsForm").attr("lastNum");
	$("#addFundsForm").append("<input type='hidden' name='rechargeAmount' value='"+amount+"'>");
	$("#rechargeBody").append("<p>Your Credit Card with last 4 digits "+ccNum+" will be charged $"+amount+".00</p><p>Do you wish to continue?</p>");
	$('#rechargeModal').modal('show');
});

$("#rechargeCancelButton").click(function() {
	$("#addFundsForm").empty();
	$("#rechargeBody").empty();
});

$("#rechargeCrossButton").click(function() {
	$("#addFundsForm").empty();
	$("#rechargeBody").empty();
});

$("#rechargeConfirmButton").click(function() {
	$("#addFundsForm").submit();
});
