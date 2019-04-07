//move prototype navbar JS code to here
//DEPRECATED, navbar now handled via PHP server side

//Default setup
var UserState = 0;
//If cookie exists with name
if(Cookies.get("UserStateCookie") == undefined)
{
	alert("DEBUG: No  user state cookies stored!");
	Cookies.set("UserStateCookie", 1);
}
UserState = Cookies.get("UserStateCookie");

if(Cookies.get("UserNameCookie") == undefined)
{
	alert("DEBUG: No username cookies stored!");
	Cookies.set("UserNameCookie", "Bob Ross");
}
var UserName = Cookies.get("UserNameCookie");
navbarState();
updateUsername();

//// TODO: use a switch statement
// TODO: Define user state enums
function navbarState()
{
	console.log("navbarState()");
	console.log("User State = "+UserState)
	if (UserState == 1)
		{
			console.log("User is logged out");
			//User is logged out
			console.log("showing logged out items");
			$(".loggedOut").show();
			console.log("hiding logged in items")
			$(".loggedIn").hide();
			$(".LoggedInAdmin").hide();
		}
		if (UserState == 2)
		{
			console.log("User is logged in")
			//User is logged in
			console.log("Show logged in items");
			$(".loggedIn").show();
			console.log("Hide logged out items");
			$(".loggedOut").hide();
			$(".LoggedInAdmin").hide();
		}
		if (UserState ==3)
		{
			console.log("User is logged in")
			//User is logged in
			console.log("Show logged in items");
			$(".loggedIn").show();
			console.log("Hide logged out items");
			$(".loggedOut").hide();
			console.log("Open Seasame. Admin privledges enabled.")
			$(".LoggedInAdmin").show();
		}
}

function updateUsername()
{
	//$("#navUsernameDisplay").hide();
	$("#navUsernameDisplay").text(UserName);
}

//add a listener to the logout button
