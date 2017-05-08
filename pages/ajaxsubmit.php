

<?php
 /* -Post will send the following 3 values:
 - email
 - password
 - action
 verifyUser($email, $dob)
 - if user is verified then create a session called 'login' and store their email address as the session value. $_SESSION['login'] = $email
 - if user does not exist then create another session with a diff name and pass email as the value again.
 - regardless of whether the verification is true or false redirect to index.php?page=questions.html. this page will act depending on if the previous mentioned sessions are set.
 createUser($email, $dob)
 - insert a new user into the database. the password field in the database will just be the hash (however you did it with JS and the DOB etc?)
 removeUser($email)
 - needs to delete the user from the users table --> */

    require_once('../helpers/functions.php');
    //require_once('../resources/php/defuse-crypto.phar');
    $email = $_POST['email'];
    $magicNumber = $_POST['magic'];
    $ajaxdata;
     /* Connect to SQL Database */
     $database = dbConnect();
     /* Construct Hash... */
     // echo("Constructing Hash...<br>");
     if (checkUser($email, $database) == 1){
         if (verifyUser($email, $magicNumber, $database) == 1){
             $_SESSION["login"] = $email;
             $ajaxdata['status'] = "login";
             $ajaxdata['questions'] = getQuestions($email, $magicNumber, $database);
             $ajaxdata['message'] = "Authentication sucessful.";
             $ajaxdata['html'] = displayQuestions(true, true, false, "response_button", "Enter your answers");

         }
         else {
             $_SESSION["failed"] = $email;
             $ajaxdata['status'] = "failed";
             $ajaxdata['message'] = "User verification failed.";
         }
     }
     else {
       // echo("Creating User... <br>");
       createUser($email, $magicNumber, $database);
       $_SESSION["new"] = $email;
       $ajaxdata['status'] = "new";
       $ajaxdata['message'] = "New user created";
       $ajaxdata['html'] = displayQuestions(true, false, true, "question_button", "Create Your Questions!");
     }
     echo json_encode($ajaxdata);


     /* if user is verified then create a session called 'login' and store
     their email address as the session value. $_SESSION['login'] = $email
     if user does not exist then create another session with a diff name
     and pass email as the value again regardless of whether the verification
     is true or false redirect to index.php?page=questions.html.
     This page will act depending on if the previous mentioned sessions are set.
      */


?>
