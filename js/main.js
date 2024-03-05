var Validator = {};

Validator.isValidName = function(name){
	//@name the name must not have digits and must not be empty
	if(name){
		var pattern = /^[a-zA-Z]+$/;
		if(pattern.test(name)){
			return true;
		}
	}
	return false;
}

Validator.isValidContact = function(contact){
	//@contact can be an email or a phone number
	var phoneNumber = /^\+?\d{9,13}$/;
	
	if(contact){
		if(contact.length>0){
			if(phoneNumber.test(contact)){
				return true;
			}
		}
	}
	return false;
}

Validator.isValidDescription = function(desc){
	var descPattern = /^\w+/;
	if(desc){
		if(descPattern.test(desc)&&desc.length<300){
			return true;
		}
	}
	return false;
}

Validator.isValidUrl = function(url){
	if(url){
		var url_small = url.toLowerCase(url);
		var urlPattern = /^[\a-z]+([\-]?[\a-z]+)$/;
		if(urlPattern.test(url_small)){
			return true;
		}
	}
	return false;
}

Validator.isValidStoreName = function(name){
	var pattern = /^\w+/;
	if(name){
		if(pattern.test(name)&&name.length<=30){
			return true;
		}
	}
	return false;
}

Validator.isValidPassword = function(password){
	var passwordPattern = /^\w{8,30}$/;
	if(password){
		if(passwordPattern.test(password)){
			return true;
		}
	}
	return false;
}

Validator.isValidConfirmCode = function(code){
	var codePattern =  /\d{6}$/;
	if(code){
		if(codePattern.test(code)){
			return true;
		}
	}
	return false;
}

Validator.isValidReview = function(review){
	var revPattern = /\w+/;
	if(review){
		if(revPattern.test(review)&&review.length<=150){
			return true;
		}
	}
	return false;
}
