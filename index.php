<?php
  require_once './vendor/autoload.php';
  include_once './helpers/functions.php';
  session_start();
	if(isset($_GET['page'])) {
		$page = 'pages/'.$_GET['page'].'.php';
	}
	else {
		$page = 'pages/login.php';
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>

		<title>Welcome to EasyPass</title>

		<!-- Bootstrap core CSS -->
		<link href="resources/css/bootstrap.min.css" rel="stylesheet">

		<!-- Custom styles -->
		<link href="resources/css/style.css" rel="stylesheet">

		<!-- Custom styles for this template -->
		<link href="resources/css/datetime.min.css" rel="stylesheet">

		<!-- Jquery and Moment -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>


  	</head>

	<body>
  		<div class="container">
			<?php include 'layout/nav.html' ?>

	  	<div class="jumbotron">
			<?php include 'layout/jumbotron.html' ?>
			<div class="container" id="main_area">
				<?php include $page; ?>
			</div>
			<div id="error-message"></div>
		</div>
		<?php include 'layout/footer.html'; ?>
	</div>
	<script type="text/javascript">
		$(function () {
			$('#dateOfBirth').datetimepicker({
				format: 'DD/MM/YYYY'
			});
		});
	</script>

	<script type="text/javascript" src="resources/js/registration.js"></script>
	<script>
	var magicNumber = "";
	var dateOfBirth = "";
	var email = "";
	var question_1 = "";
	var question_2 = "";
	var question_3 = "";
	var jasperthecat = "";
$("#main_area").on("click", "#button", function(){
			  if (checkForm() == true){
					dateOfBirth = document.getElementById('dateOfBirth2').value;
					email = document.getElementById('email').value;
					magicNumber = CryptoJS.SHA512(email + dateOfBirth).toString();
					$.ajax({
						type: "POST",
						url: "pages/ajaxsubmit.php",
						data: {email: email, magic: magicNumber},
						cache: false,
						success: function(result){
							  // $("#informationArea").html(result);
							  var obj = jQuery.parseJSON(result);
								if (obj.html != null) {
								  $("#main_area").html(obj.html);
								}
								$("#informationArea").html(obj.message);
							  if (obj.questions != null && obj.status == "login") {
								  question_1 = obj.questions.q1;
								  question_2 = obj.questions.q2;
								  question_3 = obj.questions.q3;
								}
								document.getElementById('dateOfBirth2').value = dateOfBirth;
								document.getElementById('email').value = email;
								document.getElementById('qf1').value = CryptoJS.AES.decrypt(question_1, dateOfBirth).toString(CryptoJS.enc.Utf8);
								document.getElementById('qf2').value = CryptoJS.AES.decrypt(question_2, dateOfBirth).toString(CryptoJS.enc.Utf8);
								document.getElementById('qf3').value = CryptoJS.AES.decrypt(question_3, dateOfBirth).toString(CryptoJS.enc.Utf8);
						},
						error: function (xhr, ajaxOptions, thrownError) {
							 alert(xhr.status);
							 alert(thrownError);
						}
					});
				}
	    return false;
});

$("#main_area").on("click", "#question_button", function(){
			question_1 = CryptoJS.AES.encrypt(document.getElementById('qf1').value, dateOfBirth).toString()
			question_2 = CryptoJS.AES.encrypt(document.getElementById('qf2').value, dateOfBirth).toString()
			question_3 = CryptoJS.AES.encrypt(document.getElementById('qf3').value, dateOfBirth).toString()
			$.ajax({
				type: "POST",
				url: "pages/create_questions.php",
				data: {email: email, magic: magicNumber, q1: question_1, q2: question_2, q3: question_3},
				cache: false,
				success: function(result){
						var obj = jQuery.parseJSON(result);
						$("#main_area").html(obj.html);
						$("#informationArea").html(obj.message);
						// $("#informationArea").html(result);
						document.getElementById('dateOfBirth2').value = dateOfBirth;
						document.getElementById('email').value = email;
						document.getElementById('qf1').value = CryptoJS.AES.decrypt(question_1, dateOfBirth).toString(CryptoJS.enc.Utf8);
						document.getElementById('qf2').value = CryptoJS.AES.decrypt(question_2, dateOfBirth).toString(CryptoJS.enc.Utf8);
						document.getElementById('qf3').value = CryptoJS.AES.decrypt(question_3, dateOfBirth).toString(CryptoJS.enc.Utf8);
				},
				error: function (xhr, ajaxOptions, thrownError) {
					 alert(xhr.status);
					 alert(thrownError);
				}
			});
	return false;
});

$("#main_area").on("click", "#answer_button", function(){
			var answer_1 = document.getElementById('q1').value
			var answer_2 = document.getElementById('q2').value
			var answer_3 = document.getElementById('q3').value
      jasperthecat = (answer_1 + answer_2 + answer_3).toLowerCase().replace(/ /g,'');
      var percythedog = CryptoJS.SHA512(jasperthecat).toString();
			$.ajax({
				type: "POST",
				url: "pages/assign_password.php",
				data: {email: email, magic: magicNumber, hash: percythedog},
				cache: false,
				success: function(result){
						var obj = jQuery.parseJSON(result);
						$("#main_area").html(obj.html);
						$("#informationArea").html(obj.message);
						document.getElementById('qf1').value = CryptoJS.AES.decrypt(question_1, dateOfBirth).toString(CryptoJS.enc.Utf8);
						document.getElementById('qf2').value = CryptoJS.AES.decrypt(question_2, dateOfBirth).toString(CryptoJS.enc.Utf8);
						document.getElementById('qf3').value = CryptoJS.AES.decrypt(question_3, dateOfBirth).toString(CryptoJS.enc.Utf8);
				},
				error: function (xhr, ajaxOptions, thrownError) {
					 alert(xhr.status);
					 alert(thrownError);
				}
			});
	return false;
});

$("#main_area").on("click", "#response_button", function(){
			var answer_1 = document.getElementById('q1').value
			var answer_2 = document.getElementById('q2').value
			var answer_3 = document.getElementById('q3').value
      jasperthecat = (answer_1 + answer_2 + answer_3).toLowerCase().replace(/ /g,'');
      alert(jasperthecat);
      var percythedog = CryptoJS.SHA512(jasperthecat).toString();
      var elements;
      var processed_data;
      var output;
			$.ajax({
				type: "POST",
				url: "pages/check_password.php",
				//this could be a flaw here need to fix up the create passphrase backend to prevent an attacker changing the password...
				data: {email: email, magic: magicNumber, hash: percythedog},
				cache: false,
				success: function(result){
						var obj = jQuery.parseJSON(result);
						if (obj.html != null) {
							$("#main_area").html(obj.html);
              elements = document.getElementsByClassName('user_data');
              for(var i = 0; i < elements.length; i++) {
                if (elements.item(i).name != "id[]"){
                  elements.item(i).value = CryptoJS.AES.decrypt(elements.item(i).value, jasperthecat).toString(CryptoJS.enc.Utf8);
                }
              }
						}
						$("#informationArea").html(obj.message);
            // $("#informationArea").html(result);

				},
				error: function (xhr, ajaxOptions, thrownError) {
					 alert(xhr.status);
					 alert(thrownError);
				}
			});
	return false;
});

$("#main_area").on("click", "#save_passwords", function(){
      var elements;
      var num_tags = 0;
      elements = document.getElementsByClassName('user_data');
      for(var i = 0; i < elements.length; i++){
           if (elements.item(i).type != "hidden" && elements.item(i).value != ''){
             elements.item(i).value = CryptoJS.AES.encrypt(elements.item(i).value, jasperthecat).toString();
           }
      }
      elements = $('form').serialize();
      elements = elements + "&email=" + email;
      alert(elements);
			$.ajax({
				type: "POST",
				url: "pages/update_passwords.php",
				//this could be a flaw here need to fix up the create passphrase backend to prevent an attacker changing the password...
				data: elements,
				cache: false,
				success: function(result){
          var obj = jQuery.parseJSON(result);
           if (obj.html != null) {
            $("#main_area").html(obj.html);
            elements = document.getElementsByClassName('user_data');
            for(var i = 0; i < elements.length; i++) {
              if (elements.item(i).name != "id[]"){
                elements.item(i).value = CryptoJS.AES.decrypt(elements.item(i).value, jasperthecat).toString(CryptoJS.enc.Utf8);
              }
            }
          }
          $("#informationArea").html(obj.message);
          //  $("#informationArea").html(result);
            elements = document.getElementsByClassName('user_data');

				},
				error: function (xhr, ajaxOptions, thrownError) {
					 alert(xhr.status);
					 alert(thrownError);
				}
			});
	return false;
});




$("body").on("click",".add-more",function(){
		var html = $(".copy").html();
		$(".after-add-more").after(html);
});

$("body").on("click",".remove",function(){
		$(this).parents(".control-group").remove();
});



</script>
	<script src="resources/js/datetime.min.js"></script>
  <script src="resources/js/sha512.js"></script>
  <script src="resources/js/aes.js"></script>

  </body>
</html>
