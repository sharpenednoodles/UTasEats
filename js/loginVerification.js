//Include this is a seprate JS file
//Provide client side input validation for login page(s)
$("#loginSubmitButton").click(function() {
	var userID = $("#userIDinput").val();
	var password = $("#userPasswordInput").val();

	//TODO replace with function bools, no extra vars
	var validUser = validateUserID(userID);
	var validPass = validatePassword(password);

	if (validUser == false || validPass == false)
	{
		event.preventDefault();
	}
});

function validateUserID(userID)
{
	//If blank
	if (userID == "")
	{
		invalidUserID("User ID cannot be blank!");
		return false;
	}
	//Check if userID contains the correct prefix
	//Protect backend from buffer overflows (need to check length during backend implementation too)
	var userPrefix = userID.substring(0,2);
	if (!(userPrefix.match(/DB|BM|CM|CS|US|UE/g))||(userID.length > 15))
	{
		invalidUserID("Please Enter a Valid User ID. User IDs are case sensitive.");
		return false;
	}
	//Valid userID
	$("#userIDinput").removeClass("is-invalid").addClass("is-valid");
	$("#invalidUserID").text("");
	return true;
}

//Provide feedback from string input
function invalidUserID(errorString)
{
	$("#userIDinput").addClass("is-invalid");
	$("#invalidUserID").text(errorString);
}

//Make sure password meets arbitrary assignment specification
function validatePassword(password)
{
	if (password =="")
	{
		invalidPassword("Please Enter a password!");
		return false;
	}
	//Check string length
	if (password.length < 6 || password.length > 12)
		{
			//A 12 character password limit is just dumb. Like this unit.
			invalidPassword("Passwords must be between 6 - 12 characters.");
			return false;
		}
		//Passwords must contain 1 cap and 1 lower min
		if (!(password.match(/[a-z]/g) && password.match(/[A-Z]/g)))
		{
			invalidPassword("Passwords must contain at least one upper and one lower case letter.");
			return false;
		}
		//Must contain a number
		if(!(password.match(/[0-9]/g)))
		{
			invalidPassword("Passwords must contain at least one number.");
			return false;
		}
		//Must contain special characters
		if(!(password.match(/~|!|#|\$/g)))
		{
			invalidPassword("Passwords must contain one of the following characters ~ ! # $");
			return false;
		}

		//Valid password
		$("#userPasswordInput").removeClass("is-invalid").addClass("is-valid");
		$("#invalidPassword").text("");
		return true;
}

//Provide feedback from string input
function invalidPassword(errorString)
{
	$("#userPasswordInput").addClass("is-invalid");
	$("#invalidPassword").text(errorString);
}
