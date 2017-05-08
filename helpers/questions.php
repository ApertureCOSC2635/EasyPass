<?php
   session_start();
   require_once '../vendor/autoload.php';
   include_once 'db.php';
   /* Connect to SQL Database */
   $database = dbConnect();

   if(isset($_SESSION['new'])) {
      $user = $_SESSION['new'];
      $questions = array($_POST['qf1'], $_POST['qf2'], $_POST['qf3']);
      $answers = array(
         hash("sha256", $_POST['q1']),
         hash("sha256", $_POST['q1']),
         hash("sha256", $_POST['q1'])
      );
      $query = "UPDATE user SET q1 = '$questions[0]', q2 = '$questions[1]', q3 = '$questions[2]' WHERE email = '$user'";
      $result = $database->query($query);
      $query = "UPDATE user SET q1a = '$answers[0]', q2a = '$answers[1]', q3a = '$answers[2]' WHERE email = '$user'";
      $result = $database->query($query);
      unset($_SESSION['new']);
      $_SESSION['login'] = $user;
      header("Location: ../index.php");
   }
   else if(isset($_SESSION['login'])) {
      $answers = array($_POST['q1'],$_POST['q2'],$_POST['q3']);
      $user = $_SESSION['login'];
      $query = "SELECT q1a,q2a,q3a FROM user WHERE email = '$user'";
      $result = $database->query($query);
      $row = $result->fetch_assoc();
      if($row['q1a'] != $answers[0] && $row['q2a'] != $answers[1] && $row['q3a'] != $answers[2]) {
         header("Location: ../index.php?page=questions");
      }
      else {
         header("Location: ../index.php");
      }
   }



?>
