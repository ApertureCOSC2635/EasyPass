<?php
   require_once ('../helpers/functions.php');
   $email = $_POST['email'];
   $magicNumber = $_POST['magic'];
   $questions['q1'] = $_POST['q1'];
   $questions['q2'] = $_POST['q2'];
   $questions['q3'] = $_POST['q3'];

   $database = dbConnect();
   /* Update Database */
   $status = addUserQuestions($email, $magicNumber, $questions, $database);

   $ajaxdata['status'] = "create_answers";
   $ajaxdata['message'] = "User Questions created. $email";
   $ajaxdata['message'] =  $status;
$ajaxdata['html'] = displayQuestions(true, true, false, "answer_button", "Create Your Answers!");
echo json_encode($ajaxdata);

?>
