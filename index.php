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
						//$("#informationArea").html(result);
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

</script>
	<script src="resources/js/datetime.min.js"></script>
  <script src="resources/js/sha512.js"></script>
  <script src="resources/js/aes.js"></script>

  </body>
</html>
