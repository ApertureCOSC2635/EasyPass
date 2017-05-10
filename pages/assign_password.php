<?php
   require_once ('../helpers/functions.php');
   $email = $_POST['email'];
   $magicNumber = $_POST['magic'];
   $password  = $_POST['hash'];

   $database = dbConnect();
   /* Update Database */
   $status = addUserPassphrase($email, $magicNumber, $password, $database);

   $ajaxdata['status'] = "passphrase_created";
   $ajaxdata['message'] = "User Passphrase created.";
   $ajaxdata['html'] = displayLogin();
   echo json_encode($ajaxdata);

?>
