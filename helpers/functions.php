<?php
function dbConnect() {
   $config = include('db.config.php');
   $db = $config->name;
   $host = $config->host;
   $user = $config->user;
   $password = $config->password;
   $conn = mysqli_connect($host, $user, $password, $db, 3306);
   return $conn;
}

function checkUser($email, $database) {
    $query = "SELECT * FROM user WHERE email = '$email'";
    if(!$result = $database->query($query)){
        die('There was an error running the query [' . $database->error . ']');
    }
    return $result->num_rows;
}

function createUser($email, $magicNumber, $database) {
  $query = "INSERT INTO user (email, password) VALUES ('$email','$magicNumber')";
  if(!$result = $database->query($query)){
      die('There was an error running the query [' . $database->error . ']');
  }
}

function verifyUser($email, $magicNumber, $database) {
   $query = "SELECT * FROM user WHERE email = '$email'";
   if(!$result = $database->query($query)){
       die('There was an error running the query [' . $database->error . ']');
   }
   $row = $result->fetch_assoc();
   return ($row['password'] == $magicNumber);
}



function getQuestions($email, $magicNumber, $database) {
   $query = "SELECT q1, q2, q3 FROM user WHERE email = '$email'";
   if(!$result = $database->query($query)){
       die('There was an error running the query [' . $database->error . ']');
   }
   $row = $result->fetch_assoc();
   return $row;
}     /* needs to delete the user from the users table  */

function removeUser($email) {
  echo "removeUser Stub";
}

function displayQuestions($questions = false, $answers = false) {
  $disable_answers = "";
  $disable_questions = "";
  $disable = "disabled='disabled'";
  if ($answers == true) {
    $disable_answers = $disable;
  }
  if ($questions == true) {
    $disable_questions  = $disable;
  }
  $response = "";
  $response .= " <div class='col-sm-12' id='questions'>";
  $response .= "     <div class='form-group'>";
  $response .= "        <input type='text' class='form-control' $disable_questions placeholder='Enter your first question' id='qf1'/>";
  $response .= "     </div>";
  $response .= "     <div class='form-group'>";
  $response .= "         <input type='text' class='form-control' $disable_answers placeholder='Answer 1' id='q1'/>";
  $response .= "     </div>";
  $response .= "     <div class='form-group'>";
  $response .= "         <input type='text' class='form-control' $disable_questions placeholder='Enter your second question' id='qf2'/>";
  $response .= "     </div>";
  $response .= "     <div class='form-group'>";
  $response .= "         <input type='text' class='form-control' $disable_answers placeholder='Answer 2' id='q2'/>";
  $response .= "     </div>";
  $response .= "     <div class='form-group'>";
  $response .= "         <input type='text' class='form-control' $disable_questions placeholder='Enter your third question' id='qf3'/>";
  $response .= "     </div>";
  $response .= "     <div class='form-group'>";
  $response .= "         <input type='text' class='form-control' $disable_answers placeholder='Answer 3' id='q3'/>";
  $response .= "     </div>";
  $response .= "</div>";
  return $response;
}


function displayLogin($user_dob = false, $buttonID = "button", $button_display = "Access", $display_questions = "") {
  $disable_user_dob = "";
  $disable = "disabled='disabled'";
  if ($user_dob == true) {
    $disable_user_dob = $disable;
  }
  $response = "";
  $response .= "<form method='post' action='helpers/login.php'>";
  $response .= "    <div class='row'>";
  $response .= "        <div id='login'>";
  $response .= "           <label for='usr'>Enter your email address and date of birth to continue:</label>";
  $response .= "               <div class='col-sm-6'>";
  $response .= "                   <div class='form-group'>";
  $response .= "                       <input type='text' class='form-control' $disable_user_dob placeholder='Email address' id='email'>";
  $response .= "                   </div>";
  $response .= "               </div>";
  $response .= "               <div class='col-sm-6'>";
  $response .= "                   <div class='form-group'>";
  $response .= "                   <div class='input-group date' id='dateOfBirth'>";
  $response .= "                       <input type='text' placeholder='Date of Birth' $disable_user_dob class='form-control' id='dateOfBirth2' />";
  $response .= "                       <span class='input-group-addon'>";
  $response .= "                          <span class='glyphicon glyphicon-calendar'></span>";
  $response .= "                       </span>";
  $response .= "                  </div>";
  $response .= "              </div>";
  $response .= "         </div>";
  $response .= "     </div> ";
  $response .= "$display_questions";
  $response .= "<div class='row'>";
  $response .= "    <div class='col-md-12' id='create_questions'><p><button class='btn btn-lg btn-success' role='button' id='$buttonID' >$button_display</button></p></div>";
  $response .= "</div>";
  $response .= "<div id='informationArea'></div>";
  return $response;
}

function addUserQuestions($email, $magicNumber, $questions, $database) {
      $query = "UPDATE user ";
      $query = $query."SET q1 =  '";
      $query = $query.$questions['q1']."', ";
      $query = $query."q2 =  '";
      $query = $query.$questions['q2']."', ";
      $query = $query."q3 =  '";
      $query = $query.$questions['q3']."' ";
      $query = $query." WHERE email = '$email'";

      if(!$result = $database->query($query)){
          die('There was an error running the query [' . $database->error . ']');
      }
      return $query;
}

function addUserPassphrase($email, $magicNumber, $password, $database) {
      $query = "UPDATE user SET passphrase = '$password' WHERE email = '$email'";
      if(!$result = $database->query($query)){
          die('There was an error running the query [' . $database->error . ']');
      }
      return $query;
}

?>
