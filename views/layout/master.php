<?php
   if(isset($_SESSION['page'])) {
      $content = $_SESSION['page'];
   }
   else {
      header('Location: /easypass');
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
      <?php
         require('nav.html');
         require($content);
         require('footer.html')
      ?>
      </div>
      <script type="text/javascript" src="resources/js/registration.js"></script>

   	<script src="resources/js/datetime.min.js"></script>

      <script src="resources/js/sha512.js"></script>
      <script src="resources/js/aes.js"></script>

      <script src="resources/js/jquery.mask.js"></script>
   </body>
</html>
