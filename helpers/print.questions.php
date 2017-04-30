<?php
   include_once 'db.php';
   session_start();
   $num_questions = 3;
   if(isset($_SESSION['login'])) {
      $user = $_SESSION['login'];
      $query = "SELECT q1,q2,q3 FROM user WHERE email = '$user'";
      //$result = mysqli_function
      for($i = 1; $i < $num_questions; $i++) {
         echo '
            <div class="form-group">
               <input type="text" class="form-control" id="qf'.$i.'" name="qf'.$i.'"/ disabled value="'.$question[$i].'">
            </div>
            <div class="form-group">
               <input type="text" class="form-control" placeholder="Answer '.$i.'" id="q'.$i.'" name="q'.$i.'"/>
            </div>
         ';
      }
   }
   else {
      if(isset($_SESSION['new'])) {
         echo '<p>A new account will be created for user '.$_SESSION['new'];
      }
      for($i = 1; $i < $num_questions; $i++) {
         echo '
            <div class="form-group">
               <input type="text" class="form-control" placeholder="Enter your question" id="qf'.$i.'" name="qf'.$i.'"/>
            </div>
            <div class="form-group">
               <input type="text" class="form-control" placeholder="Answer '.$i.'" id="q'.$i.'" name="q'.$i.'"/>
            </div>
         ';
      }
   }
?>
