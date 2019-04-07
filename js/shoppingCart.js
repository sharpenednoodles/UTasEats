//Code is still very unfinished

//Update quantities
$("tr").change(function()
{
	var itemName = $(this).children("#itemName").text();
	console.log($(this).children("#price").text());
	console.log($(this).children("#itemQuantity").length);

	$("#itemCart").append($('<tr>').append($('<td>').append(itemName)));
});
