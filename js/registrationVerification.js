//Include this is a seprate JS file
//Provide client side input validation
$("#registrationSubmitButton").click(function() {
	var password = $("#userPasswordInput").val();
	var passwordMatch =$("#userPasswordInputConfirm").val();
	//TODO replace with function bools, no extra vars
	var validPass = validatePassword(password);
	var validPassConfirm = validatePasswordMatch(password, passwordMatch);

	if (validPass == false || validPassConfirm == false)
	{
		event.preventDefault();
	}
});

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

function validatePasswordMatch(password, passwordConfirm)
{
	if (password != passwordConfirm)
	{
		invalidPasswordMatch("Passwords do not match");
		return false;
	}
	else
	{
		return true;
	}
}

//Provide feedback from string input
function invalidPasswordMatch(errorString)
{
	$("#userPasswordInputConfirm").addClass("is-invalid");
	$("#invalidConfirmPassword").text(errorString);
}
