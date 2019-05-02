//Include this is a seprate JS file
//Provide client side input validation
$("#registrationSubmitButton").click(function() {

	//Get values from fields
	var firstName = $("#firstNameInput").val();
	var lastName = $("#lastNameInput").val();
	var gender = $("input[name='radioGender']").is(':checked');
	var idNumber = $("#IDNumberInput").val();
	var accountCheck = $("input[name='radioAccountType']").is(':checked');
	var email = $("#emailInput").val();
	var password = $("#userPasswordInput").val();
	var passwordMatch =$("#userPasswordInputConfirm").val();
	var ccName = $("#CCNameInput").val();
	var ccNumber = $("#CCNumberInput").val();
	var cvc = $("#CVCInput").val();
	var ccExp = $("#CCExpInput").val();
	//See if user has accepted eula
	var acceptTerms = $("#termsandCondsCheck").prop('checked');

	//TODO replace with function bools, no extra vars
	//Booleans
	var validFirstName = validateFirstName(firstName);
	var validLastName = validateLastName(lastName);
	var validIDNumber = validateIDNumber(idNumber);
	var validPass = validatePassword(password);
	var validPassConfirm = validatePasswordMatch(password, passwordMatch);
	var validGender = validateGender(gender);
	var validEmail = validateEmail(email);
	var validAccount = validateAccount(accountCheck);
	var validTerms = checkTerms(acceptTerms);
	var validCCNumber = validateCCNumber(ccNumber);
	var validCCName = validateCCName(ccName);
	var validCVC = validateCVC(cvc);
	var validCCEXP = validateCCEXP(ccExp);

	if (validFirstName == false || validLastName == false || validGender == false || validIDNumber == false || validAccount == false || validPass == false || validPassConfirm == false || validEmail == false || validCCNumber == false || validCCName == false || validCCEXP == false || validCVC == false || validTerms == false)
	{
		event.preventDefault();
	}
});

//Make sure password meets arbitrary assignment specification
function validatePassword(password)
{
	if (password =="")
	{
		invalidPassword("Please Enter a Password!");
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

//functions with a single invalidation message do not need a helper string method!
function validatePasswordMatch(password, passwordConfirm)
{
	if (password != passwordConfirm || passwordConfirm == "")
	{
		$("#userPasswordInputConfirm").addClass("is-invalid");
		return false;
	}
	else
	{
		$("#userPasswordInputConfirm").removeClass("is-invalid").addClass("is-valid");
		return true;
	}
}

function validateFirstName(firstName)
{
	if (firstName == "")
	{
		$("#firstNameInput").addClass("is-invalid");
		return false;
	}
	else
	{
		$("#firstNameInput").removeClass("is-invalid").addClass("is-valid");
		return true;
	}
}

function validateLastName(lastName)
{
	if (lastName == "")
	{
		$("#lastNameInput").addClass("is-invalid");
		return false;
	}
	else
	{
		$("#lastNameInput").removeClass("is-invalid").addClass("is-valid");
		return true;
	}
}

function validateIDNumber(idNumber)
{
	if (idNumber.length == 6 && idNumber.match(/^[0-9]+$/))
	{
		$("#IDNumberInput").removeClass("is-invalid").addClass("is-valid");
		return true;
	}
	else
	{
		$("#IDNumberInput").addClass("is-invalid");
		return false;
	}
}

function validateGender(gender)
{
	if (gender == false)
	{
		$("#maleRadio1, #femaleRadio2, #otherRadio3").addClass("is-invalid");
		return false;
	}
	else if (gender == true)
	{
		$("#maleRadio1, #femaleRadio2, #otherRadio3").removeClass("is-invalid").addClass("is-valid");
		return true;
	}
}

function validateAccount(accountCheck)
{
	if (accountCheck == false)
	{
		$("#studentRadio1, #staffRadio2").addClass("is-invalid");
		return false;
	}
	else if (accountCheck == true)
	{
		$("#studentRadio1, #staffRadio2").removeClass("is-invalid").addClass("is-valid");
		return true;
	}
}

//Regex from http://www.regexlib.com/REDetails.aspx?regexp_id=3013
function validateEmail(email)
{
	if (email.match(/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/))
	{
		$("#emailInput").removeClass("is-invalid").addClass("is-valid");
		return true;
	}
	else
	{
		$("#emailInput").addClass("is-invalid");
		return false;
	}
}

//Credit cards
function validateCCName(ccName)
{
	if (ccName.match(/^[A-z\.\'\-\ ]+$/))
	{
		$("#CCNameInput").removeClass("is-invalid").addClass("is-valid");
		return true;
	}
	else
	{
		$("#CCNameInput").addClass("is-invalid");
		return false;
	}
}

function validateCVC(CVC)
{
	if (CVC.length == 3 && CVC.match(/^[0-9]+$/))
	{
		$("#CVCInput").removeClass("is-invalid").addClass("is-valid");
		return true;
	}
	else
	{
		$("#CVCInput").addClass("is-invalid");
		return false;
	}
}

function validateCCEXP(ccEXP)
{
	if (ccEXP.match(/^(0[1-9]|1[0-2])\/?([0-9]{4}|[0-9]{2})$/))
	{
		$("#CCExpInput").removeClass("is-invalid").addClass("is-valid");
		return true;
	}
	else
	{
		$("#CCExpInput").addClass("is-invalid");
		return false;
	}
}

//REGEX patterns from https://www.w3resource.com/javascript/form/credit-card-validation.php
function validateCCNumber(ccNumber)
{
	//Match AMEX Card
	if (ccNumber.match(/^(?:3[47][0-9]{13})$/))
	{
		validCCFeedback("American Express");
		return true;
	}
	//Match Visa Card
	else if (ccNumber.match(/^(?:4[0-9]{12}(?:[0-9]{3})?)$/))
	{
		validCCFeedback("Visa");
		return true;
	}
	//Match MasterCard
	else if (ccNumber.match(/^(?:5[1-5][0-9]{14})$/))
	{
		validCCFeedback("MasterCard");
		return true;
	}
	else
	{
		$("#CCNumberInput").addClass("is-invalid").removeClass("is-valid");
		return false;
	}
}

//Provide feedback on matched card details
function validCCFeedback(feedback)
{
	$("#CCNumberInput").removeClass("is-invalid").addClass("is-valid");
	$("#validCCNumber").text(feedback);
}

function checkTerms(acceptTerms)
{
	if (acceptTerms == true)
	{
		$("#termsandCondsCheck").removeClass("is-invalid").addClass("is-valid");
		return true;
	}
	else if (acceptTerms == false)
	{
		$("#termsandCondsCheck").addClass("is-invalid");
		return false;
	}
}
