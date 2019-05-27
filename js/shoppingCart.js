//Handles the shopping cart interactivity on the client side
//Used on all cafe pages
//TODO: add cookies to store cafe cart items
var items = [];
var total = 0;
var cafe;

//Update quantities when the user adds items to the cart
$("tr").change(function()
{
	var itemID = $(this).attr("id");
	var itemName = $(this).find("td:nth-child(1)").text();
	var price = parseFloat($(this).find("td:nth-child(2)").text().substring(1));
	var quantity = parseFloat($(this).find("td:nth-child(4) input").val());
	cafe = $("#orderForm").attr("cafe");

	items[itemID] = [itemName, quantity, price];
	buildCafeCart();
});

//Builds the cafe cart object so the user can see the items in the cart
function buildCafeCart()
{
	//console.log(items);
	$("#itemCart").empty();
	$("#cartTotal").empty();
	total = 0;
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
	//Cookies.set("ItemCart", JSON.stringify(items));
}

//BootStrap Spinner override for cart functionality
$("input[type='number']").inputSpinner();

//Send the item ID, and the quantity for the order to be processed by php POST form submission
function buildPostSubmission()
{
	var j = 0;
	for (i=0; i < items.length; i++)
	{
		if (items[i] != null && items[i][1] > 0)
		{
			$("#orderForm").append("<input type='hidden' name='item"+j+"[id]' value="+i+">");
			$("#orderForm").append("<input type='hidden' name='item"+j+"[quantity]' value="+items[i][1]+">");
			j++;
		}
	}
	$("#orderForm").append("<input type = 'hidden' name='itemCount' value="+j+">");
	$("#orderForm").append("<input type = 'hidden' name='price' value="+total+">");
	$("#orderForm").append("<input type = 'hidden' name='cafe' value="+$("#orderForm").attr("cafe")+">");
}

//Handle form submission
//TODO Need to check whether the user can afford to pay for the items client side too
$("#checkOutButton").click(function()
{
	buildPostSubmission();
	$("#orderForm").submit();
});

//Read from cookie
$(document).ready(function(){
	//items = JSON.parse(Cookies.get("Item Cart"));
	//buildCafeCart();
	buildCafeCart();
});
