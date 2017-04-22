<?php
	

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
	 		<div class="header clearfix">
				<nav>
		  			<ul class="nav nav-pills pull-right">
						<li role="presentation" class="active"><a href="#">Home</a></li>
						<li role="presentation"><a href="#">About</a></li>
						<li role="presentation"><a href="#">Contact</a></li>
		  			</ul>
				</nav>
				<h3 class="text-muted">EasyPass&copy; </h3>
			</div>

	  	<div class="jumbotron">
			<h1>Welcome to EasyPass</h1>
			<p class="lead">EasyPass is a simple, beautiful password manager that does not use a password. 
			Instead, we secure your data with information that is easy for you to remember. You are in control. 
			All you have to do is set three easy questions, set your answers and you are ready. </p>
	
			<div class="container">
				<div class="row">
			   		<div id="login">
			   			<label for="usr">Enter your email address and date of birth to continue:</label>
				   		<div class='col-sm-6'>
					   		<div class="form-group">
						   		<input type="text" class="form-control" placeholder="Email address" id="email">
					   		</div>
				   		</div>
				   		<div class='col-sm-6'>
					   		<div class="form-group">
						   		<div class='input-group date' id='dateOfBirth'>
							   		<input type='text' placeholder="Date of Birth" class="form-control" id='dateOfBirth2' />
							   		<span class="input-group-addon">
								  		<span class="glyphicon glyphicon-calendar"></span>
							   		</span>
						   		</div>
					  		</div>
				   		</div>
					</div>
				   	<div class="hidden" id="questions">
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Enter your first question" id="qf1"/>
						</div>
					   	<div class="form-group">
							<input type="text" class="form-control" placeholder="Answer 1" id="q1"/>
						</div>
					   	<div class="form-group">
							<input type="text" class="form-control" placeholder="Enter your second question" id="qf2"/>
						</div>
					   	<div class="form-group">
							<input type="text" class="form-control" placeholder="Answer 2" id="q2"/>
						</div>
					   	<div class="form-group">
							<input type="text" class="form-control" placeholder="Enter your third question" id="qf3"/>
						</div>
					   	<div class="form-group">
							<input type="text" class="form-control" placeholder="Answer 3" id="q3"/>
						</div>
					</div>
				   	<div class="hidden" id='password'>
				   		<div class="form-group">
							<textarea class="form-control" rows="20" id="password_text"></textarea>
					   	</div>
				   	</div>
			   	</div>
			</div>
			<div class="row">
				<div class="col-md-12"><p><button class="btn btn-success" type="submit" role="button" id="button" onclick="return checkForm();">Login</button></p></div>
			</div>
			<div id="error-message"></div>
		</div>
	  	<footer class="footer">
			<p>&copy; 2017 Aperture Science Labs, Inc. Bootstrap CSS used under the terms of the MIT licence.</p>
	  	</footer>
	</div>
	<script type="text/javascript">
		$(function () {
			$('#dateOfBirth').datetimepicker({
				format: 'DD/MM/YYYY'
			});
		});
	</script>

	<script type="text/javascript" src="resources/js/registration.js"></script>
	
	<script src="resources/js/datetime.min.js"></script>
	
    <script src="resources/js/sha512.js"></script>
    <script src="resources/js/aes.js"></script>

  </body>
</html>


