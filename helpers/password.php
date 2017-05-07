<!--
First we need a page that displays the users passwords and
privately stored data in some way.
It also needs to let users add a new password to be stored.
This should be stored in the '/pages' folder.
If you look at the structure of the 'rebuild' branch,
this is just a page that gets included in the index page.

Second we need a new helper in '/helpers'.
This helper needs to receive input (new password/data)
from the user and store it.

We can either store this in the database or create each user their own
file and continue to append data to it. I do believe we are hashing this
though like we did with html local storage??
The helper also needs to be able to remove specific passwords.

Thirdly we need another helper that generates the password data to be
displayed on the first page.
So I guess this will need to fetch the hashed data,
decrypt it and format it in a readable format.

My advice would be to put each piece of data (site:password) into an array.

Both helpers need to bounce back to index if $_SESSION['login'] is not set.
-->

<?php
print_r($_REQUEST['website']);
print_r($_REQUEST['username']);
print_r($_REQUEST['password']);
exit;
?>


<!--?php
   include_once 'db.php';
   session_start();
   $num_questions = 3;
   if(isset($_SESSION['login'])) {
      $user = $_SESSION['login'];
      $conn = dbConnect();
      $query = "SELECT q1,q2,q3 FROM user WHERE email = '$user'";
      $result = mysqli_query($conn, $query);
      $question = mysqli_fetch_array($result);
      for($i = 0; $i < $num_questions; $i++) {
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
   else if(isset($_SESSION['new'])) {
      echo '<p>A new account will be created for user '.$_SESSION['new'];
      for($i = 1; $i <= $num_questions; $i++) {
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
? -->
