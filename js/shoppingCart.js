//Code is still very unfinished

var items = [];
//Update quantities
$("tr").change(function()
{
	var itemID = $(this).attr("id");
	var itemName = $(this).find("td:nth-child(1)").text();
	var price = parseFloat($(this).find("td:nth-child(2)").text().substring(1));
	var quantity = parseFloat($(this).find("td:nth-child(4) input").val());

	items[itemID] = [itemName, quantity, price];
	buildCafeCart();
});

function buildCafeCart()
{
	//console.log(items);
	$("#itemCart").empty();
	$("#cartTotal").empty();
	var total = 0;
	for (i = 0; i < items.length; i ++)
	{
		if (items[i] != null && items[i][1] > 0)
		{
			//console.log("Item "+i +": "+items[i]);
				total += (items[i][1] * items[i][2]);
			//console.log("Total value at: "+total +" with type: " +typeof(total));

			//Build table row from data
			$("#itemCart").append($('<tr><td>'+items[i][0]+'</td><td>'+items[i][1]+'</td><td>$'+(items[i][1]*items[i][2]).toFixed(2) +"</td></tr>"));
		}
	}
	//Print total value
	$("#cartTotal").append("$"+total.toFixed(2));
}
