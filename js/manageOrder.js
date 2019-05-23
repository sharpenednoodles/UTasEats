
//Different button listeners
$(".orderPaidButton").click(function() {
 var ID = $(this).attr("orderID");
 $("#manageOrderForm").append("<input type='hidden' name='markPaid' value='"+ID+"'>");
 $("#manageOrderForm").submit();
});

$(".orderMadeButton").click(function() {
 var ID = $(this).attr("orderID");
 $("#manageOrderForm").append("<input type='hidden' name='markMade' value='"+ID+"'>");
 $("#manageOrderForm").submit();
});

$(".orderCollectedButton").click(function() {
 var ID = $(this).attr("orderID");
 $("#manageOrderForm").append("<input type='hidden' name='markCollected' value='"+ID+"'>");
 $("#manageOrderForm").submit();
});

$(".orderCompletedButton").click(function() {
 var ID = $(this).attr("orderID");
 $("#manageOrderForm").append("<input type='hidden' name='markCompleted' value='"+ID+"'>");
 $("#manageOrderForm").submit();
});
