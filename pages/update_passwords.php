<?php
   require_once ('../helpers/functions.php');

   $email = $_POST['email'];
   $magicNumber = $_POST['magic'];
   $database = dbConnect();
   $user_data;
   $arr_length = count($_POST['id']);
   for($i=0;$i<$arr_length;$i++)
   {
       $user_data[$i]['id'] = $_POST['id'][$i];
       $user_data[$i]['website'] = $_POST['website'][$i];
       $user_data[$i]['username'] = $_POST['username'][$i];
       $user_data[$i]['password'] = $_POST['password'][$i];
   }

    foreach($user_data as $data){
        $status = addUserData($email, $magicNumber, $data, $database);
    }
    $ajaxdata['status'] = "transactions_completed";
    $ajaxdata['message'] = "Database Updated.";
    $ajaxdata['html'] = displayUserPasswords($email, $magicNumber, $database);
    echo json_encode($ajaxdata);
?>
