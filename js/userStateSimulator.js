//include this file onto pages which include the user state simulator widgets
//DEPRECATED _ DO NOT USE
updateUserState();
//Listen to change of radio buttons
$("#UserStateRadio").change(function()
{
	console.log("Change "+UserState);
	readUserState();
});

//User name spoof button
$("#SpoofNameButton").click(function() {
	UserName = $("#pseudoUsername").val();
	Cookies.set("UserNameCookie", UserName);
	alert("Username changed to "+UserName);
	updateUsername();
});

//Update user state value from radio setting
//TODO fix this giant clusterf***

function readUserState()
{
	//Get value of radio button
	UserState = $("input[name=options]:checked").val();
	//console.log("Update "+UserState);
	updateUserState();
}

//// TODO: refresh button group to show the selected group rather than relying on a display
function updateUserState()
{
	//console.log("refresh "+UserState);
	Cookies.set("UserStateCookie", UserState);
	switch (parseInt(UserState))
	{
		case 1:
		$("#StateDummyDisplay").text("Not Logged In");
		break;
		case 2:
		$("#StateDummyDisplay").text("Logged In as User");
		break;
		case 3:
		$("#StateDummyDisplay").text("Logged In as Admin");
		break;
		default:
		var testString = typeof(UserState);
		alert("You should not see this. Debug type: " +testString);
	}
	navbarState();
}
