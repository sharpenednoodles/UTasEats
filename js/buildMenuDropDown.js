//Code responsible for building and populating the cafe cart in the navbar drop down menu
$("#cartDropdown").click(function() {
	//alert("Menu Clicked");

//Todo fetch cafe IDs from the Databse instead of hardcoding
	if (cafe == 1)
	{
		$("#lazenbysDropdownAnchor").empty();
		for (i = 0; i < items.length; i++)
		{
			if (items[i] != null && items[i][1] > 0)
			{
				$("#lazenbysDropdownAnchor").append("<div class='dropdown-item'>"+items[i][1]+" x "+items[i][0]+" - $"+items[i][2].toFixed(2)+"</div>");
			}
		}
		$("#lazenbysDropdownAnchor").append("<div class='dropdown-item'>Sub Total - $"+total.toFixed(2)+"</div>");
	}
	else if (cafe == 2)
	{
		$("#suzyleeDropdownAnchor").empty();
		for (i = 0; i < items.length; i++)
		{
			if (items[i] != null && items[i][1] > 0)
			{
				$("#suzyleeDropdownAnchor").append("<div class='dropdown-item'>"+items[i][1]+" x "+items[i][0]+" - $"+items[i][2].toFixed(2)+"</div>");
			}
		}
		$("#suzyleeDropdownAnchor").append("<div class='dropdown-item'>Sub Total - $"+total.toFixed(2)+"</div>");
	}
	else if (cafe ==3)
	{
		$("#tradetableDropdownAnchor").empty();
		for (i = 0; i < items.length; i++)
		{
			if (items[i] != null && items[i][1] > 0)
			{
				$("#tradetableDropdownAnchor").append("<div class='dropdown-item'>"+items[i][1]+" x "+items[i][0]+" - $"+items[i][2].toFixed(2)+"</div>");
			}
		}
		$("#tradetableDropdownAnchor").append("<div class='dropdown-item'>Sub Total - $"+total.toFixed(2)+"</div>");
	}

});
