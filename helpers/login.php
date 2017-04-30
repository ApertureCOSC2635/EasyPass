<table>
<!--Post will send the following 3 values:
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
- needs to delete the user from the users table -->
<?php
    $user="root";
    $password="Zeppelin01";
    $database="easypass";
    mysql_connect('localhost',$user,$password);
    @mysql_select_db($database) or die( "Unable to select database");
    echo "Does anything work?";
    foreach ($_POST as $key => $value) {
        echo "<tr>";
        echo "<td>";
        echo $key;
        echo "</td>";
        echo "<td>";
        echo $value;
        echo "</td>";
        echo "</tr>";
    }
    $query = sprintf("INSERT INTO main (email) VALUES (\"%s\")", $_POST["email"] );
    echo $query;
    mysql_query($query);

    /* if user is verified then create a session called 'login' and store
    their email address as the session value. $_SESSION['login'] = $email
    if user does not exist then create another session with a diff name
    and pass email as the value again regardless of whether the verification
    is true or false redirect to index.php?page=questions.html.
    This page will act depending on if the previous mentioned sessions are set.
     */

    function checkUser($email, $dob) {

    }
    function createUser($email, $dob) {
      echo "createUser Stub";
    }
    function verifyUser($email, $dob) {
       echo "verifyUser Stub";
    }

    /* needs to delete the user from the users table  */
    function removeUser($email) {
      echo "removeUser Stub";
    }


?>
</table>
