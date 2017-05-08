
	var error = document.getElementById('error-message');
	var questsions = document.getElementById('questions');
	var login = document.getElementById('login');
	var passwords = document.getElementById('password');
	var button = document.getElementById('button');

	function displayError(message, element) {
		error.innerHTML = message;
		error.style.display='inline';
		element.select();
		element.focus();
	}

	function autoFillQuestions(question, element) {
		element.setAttribute("readonly","True");
        element.removeAttribute("placeholder")
        element.value = question;
	}

	function checkEmail(inputvalue){
		var pattern=/^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
		var bool = pattern.test(inputvalue) ? true : false;
		return bool;
	}

	function checkDateOfBirth(inputvalue){
		var pattern=/^([0-9])+\/([0-9])+\/([0-9])+([0-9])+/;
		var bool = pattern.test(inputvalue) ? true : false;
		return bool;
	}

	function checkForm() {
		error.innerHTML = '';
		var email = document.getElementById('email');
		var dob = document.getElementById('dateOfBirth2');

		if (email.value == '' || checkEmail(email.value) == false){
			displayError("Required: Please enter a valid email address.", email);
			return false;
		}
		else if (dob.value == '' || checkDateOfBirth(dob.value) == false){
			displayError("Required: Please enter a valid Date of Birth.", dob);
			return false;
		}
    return true;
	}

	function checkQuestions(){
		error.innerHTML = '';
		var qf1 = document.getElementById('qf1');
        var qf2 = document.getElementById('qf2');
        var qf3 = document.getElementById('qf3');
        var q1 = document.getElementById('q1');
		var q2 = document.getElementById('q2');
		var q3 = document.getElementById('q3');
        var email = document.getElementById('email');
        var dob = document.getElementById('dateOfBirth2');
        var user = JSON.parse(localStorage.getItem(email.value));
        var initial_password_file = "Username : Password";

        if (qf1.value == ''){
			displayError("Required: Please enter a suitable question.", qf1);
			return false;
		}
		else if (qf2.value == ''){
			displayError("Required: Please enter a suitable question.", qf2);
			return false;
		}
		else if (qf3.value == ''){
			displayError("Required: Please enter a suitable question.", qf3);
			return false;
		}

		if (q1.value == ''){
			displayError("Required: Answer to question can not be blank.", q1);
			return false;
		}
		else if (q2.value == ''){
			displayError("Required: Answer to question can not be blank.", q2);
			return false;
		}
		else if (q3.value == ''){
			displayError("Required: Answer to question can not be blank.", q3);
			return false;
		}

		user.Question_1 = CryptoJS.AES.encrypt(qf1.value, dob.value).toString();
		user.Question_2 = CryptoJS.AES.encrypt(qf2.value, dob.value).toString();
		user.Question_3 = CryptoJS.AES.encrypt(qf3.value, dob.value).toString();


		var password = (q1.value + q2.value + q3.value).toLowerCase().replace(/ /g,'');
		user.Hashed_Password = CryptoJS.SHA512(password).toString();
		user.Password_file = CryptoJS.AES.encrypt(initial_password_file, password).toString();

		localStorage.setItem(email.value, JSON.stringify(user))
		alert('Your Password File has been created and encrypted. Dont forget the answers to your questions!');

		button.innerHTML = "Login";
		button.setAttribute("onclick","return checkForm();");

		login.removeAttribute("class","hidden");
        questions.setAttribute("class","hidden");
        return false;
	}

	function setLogin(){
	    error.innerHTML = '';
		var email = document.getElementById('email');
	    var user = JSON.parse(localStorage.getItem(email.value));
	    var form = document.getElementById('password_text');
	    var q1 = document.getElementById('q1');
		var q2 = document.getElementById('q2');
		var q3 = document.getElementById('q3');
		var password = (q1.value + q2.value + q3.value).toLowerCase().replace(/ /g,'');
		if (user.Hashed_Password != CryptoJS.SHA512(password).toString()) {
		   	error.innerHTML = 'Error: Incorrect answer/question combination.';
			error.style.display='inline';
			return false;
		}
		passwords.removeAttribute("class","hidden");
        questions.setAttribute("class","hidden");
        form.innerHTML = CryptoJS.AES.decrypt(user.Password_file, password).toString(CryptoJS.enc.Utf8);
        button.innerHTML = "Save";
		button.setAttribute("onclick","return saveFile();");
        return false;
	}




	function saveFile() {
    	error.innerHTML = '';
    	var email = document.getElementById('email');
       	var form = document.getElementById('password_text');
       	var q1 = document.getElementById('q1');
		var q2 = document.getElementById('q2');
		var q3 = document.getElementById('q3');
	   	var password = (q1.value + q2.value + q3.value).toLowerCase().replace(/ /g,'');
	   	var user = JSON.parse(localStorage.getItem(email.value));
	   	user.Password_file = CryptoJS.AES.encrypt(form.value, password).toString();
	   	localStorage.setItem(email.value, JSON.stringify(user));

       	alert("Your Form has been saved");
       	return false;
    }
