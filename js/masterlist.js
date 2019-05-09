//JS code for client side interactivity
var prevRow;
var multiDelete = false;

//Select multiple behaviour
$(".clickable").click(function()
{
	if (multiDelete == false)
		rowSelect($(this));
	else deleteSelect($(this));
});


//Highlight columns with primary colour highlighting class
function rowSelect(selectedRow)
{
	console.log(selectedRow);
	if (selectedRow.hasClass("table-primary"))
	{
		console.log("Removing Highlight");
		selectedRow.removeClass("table-primary");
	}
	else
	{
		console.log("Adding Highlight");
		selectedRow.addClass("table-primary");
	}

	if (prevRow != null && prevRow.hasClass("table-primary"))
	{
		console.log("Removing Highlight OLD");
		console.log(prevRow);
		prevRow.removeClass("table-primary");
	}

	prevRow = selectedRow;
}

//call this from clickable selector for multi item selection (then deleting)
function deleteSelect(selectedColumn)
{
	//Only add high
	if (selectedColumn.hasClass("table-danger deleteRow"))
	{
		selectedColumn.removeClass("table-danger deleteRow");
	}
	else
	{
		selectedColumn.addClass("table-danger deleteRow");
	}
}


	$("#deleteButton").click(function()
	{
		//Show delete prompt
		if (multiDelete == false)
		{
			var numIDs = $("table").find(".table-primary").length;
			var deleteID = $("table").find(".table-primary").attr('id');
			if (numIDs == 0)
			{
				alert("Please select an item first");
			}
			else
			{
				$('#deleteItemModal').modal('show');
				$("#deleteItemBody").append("<p>Delete " +numIDs+" item?</p>");
				$("#deleteForm").append("<input type=\"hidden\" name =\"delete[]\" value="+deleteID+">");
			}

		}
		else
		{
			var numIDs = $("table").find(".deleteRow").length;
			var deleteIDs = [];

			if (numIDs == 0)
			{
				alert("Please select an item first");
			}
			else
			{
				$('#deleteItemModal').modal('show');
				$("#deleteItemBody").append("<p>Delete " +numIDs+" items?</p>");
				$("table").find(".deleteRow").each(function(){ deleteIDs.push($(this).attr("id")); });

				//Iterate over the array of IDs to build delete array to submit via POST
				for (var i = 0, len = deleteIDs.length; i < len; i++)
				{
  				$("#deleteForm").append("<input type=\"hidden\" name =\"delete[]\" value="+deleteIDs[i]+">");
				}
				//console.log(deleteIDs);
			}
		}
	});

	//Clear delete modal
	$("#deleteCancelButton").click(function()
	{
		$("#deleteForm").empty();
		$("#deleteItemBody").empty();
	});
	//submit modal for deletion
	$("#deleteConfirmButton").click(function()
	{
		$("#deleteForm").submit();
	});

	//toggle multidelete
	$("#multiDeleteButton").click(function()
	{
		if (multiDelete == false)
		{
			$("table").find(".table-primary").removeClass("table-primary");
			multiDelete = true;
		}
		else
		{
			$("table").find(".table-danger").removeClass("table-danger deleteRow");
			multiDelete = false;
		}
	});


	//Still missing form processing and resturaunt detection
	$("#editButton").click(function(e)
	{
		var itemCount = $("table").find(".table-primary").length;
		var editID = $("table").find(".table-primary").attr('id');
		if (itemCount != 0)
		{
			//Code to populate edit modal
			var editItemName = $("table").find(".table-primary td:nth-child(1)").text();
			//Strip string of $, convert to float, add 2 decimal points
			var editItemPrice = parseFloat($("table").find(".table-primary td:nth-child(2)").text().substring(1)).toFixed(2);
			var editItemType = $("table").find(".table-primary td:nth-child(4)").text();
			var editItemDescription = $("table").find(".table-primary td:nth-child(3)").text();
			//Not sure how to parse this
			var editItemResturants  = $("table").find(".table-primary td:nth-child(5)").text();
			var restaurantArray = editItemResturants.split(", ");

			var startDate = $("table").find(".table-primary").attr('startDate');
			var endDate = $("table").find(".table-primary").attr('endDate');

			$("#editItemForm").append("<input type=\"hidden\" id=\"tempEditField\" name =\"editID\" value="+editID+">");

			//Set values in edit field
			$("#editItemName").val(editItemName);
			$("#editItemPrice").val(editItemPrice);
			$("#editItemDescription").val(editItemDescription);
			$("#editItemType").val(editItemType);

			//Parse and set date timers if they exist
			if(startDate != "N/A")
			{
				startDateFormat = startDate.split("-").reverse().join("/");
				$("#editItemStart").val(startDateFormat);
			}
			if(endDate != "N/A")
			{
				endDateFormat = endDate.split("-").reverse().join("/");
				$("#editItemEnd").val(endDateFormat);
			}

			//Check all items found in table element
			for (i = 0; i < restaurantArray.length; i++)
			{
				var element = restaurantArray[i];
				$("[parsename='"+element+"']").prop('checked', true);
			}


		}
		else
		{
			e.stopPropagation();
			alert("Please select an item to edit!");
		}

	});


	$("#saveEditButton").click(function()
	{

	});

//Format price to decimal, disabled because too slow to process
/*
$("#newItemPrice").change(function()
{
	 $("#newItemPrice").val(parseFloat($("#newItemPrice").val()).toFixed(2));
});
*/

	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// Data Validation
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function validateNewItem()
{
	if (validateItemName("#newItemName") == false || validateItemPrice("#newItemPrice") == false || validateItemType("#newItemType") == false || validateItemDescrip("#newItemDescription") == false || validateNewItemRestaurant() == false)
	{
		return false;
	}
	else
	{
		return true;
	}
}

function validateEditItem()
{
	if (validateItemName("#editItemName") == false || validateItemPrice("#editItemPrice") == false || validateItemType("#editItemType") == false || validateItemDescrip("#editItemDescription") == false || validateEditItemRestaurant() == false)
	{
		return false;
	}
	else
	{
		return true;
	}
}

function validateItemName(itemName)
{
	var itemNameVal = $(itemName).val();
	if (itemNameVal.length == 0)
	{
		$(itemName).addClass("is-invalid");
		return false;
	}
	else
	{
		$(itemName).removeClass("is-invalid").addClass("is-valid");
		return true;
	}
}

function validateItemPrice(itemPrice)
{
	var itemPriceVal = $(itemPrice).val();
	if (itemPriceVal.length == 0 || itemPriceVal == 0 || itemPriceVal > 99.99)
	{
		$(itemPrice).addClass("is-invalid");
		return false;
	}
	else
	{
		$(itemPrice).removeClass("is-invalid").addClass("is-valid");
		return true;
	}
}

function validateItemType(itemType)
{
	$(itemType).addClass("is-valid");
	return true;
}

function validateItemDescrip(itemDescrip)
{
	var itemDescripVal = $(itemDescrip).val();
	if (itemDescripVal.length == 0)
	{
		$(itemDescrip).addClass("is-invalid");
		return false;
	}
	else
	{
		$(itemDescrip).removeClass("is-invalid").addClass("is-valid");
		return true;
	}
}

function validateNewItemRestaurant()
{
	if ($('.newRestaurantSelector:checkbox:checked').length == 0)
	{
		$(".newRestaurantSelector").addClass("is-invalid");
		return false;
	}
	else
	{
		$(".newRestaurantSelector").removeClass("is-invalid").addClass("is-valid");
		return true;
	}
}

function validateEditItemRestaurant()
{
	if ($('.editRestaurantSelector:checkbox:checked').length == 0)
	{
		$(".editRestaurantSelector").addClass("is-invalid");
		return false;
	}
	else
	{
		$(".editRestaurantSelector").removeClass("is-invalid").addClass("is-valid");
		return true;
	}
}
