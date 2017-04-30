
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
    require_once('../resources/php/defuse-crypto.phar');
    $user = "root";
    $password = "Zeppelin01";
    $database = "easypass";
    $email = $_POST["email"];
    $dob = $_POST["dateOfBirth"];

    /* Connect to SQL Database */
    $database = mysqli_connect('localhost',$user,$password, $database)
      or die( "Unable to select database");

    /* Construct Hash... */
    echo("Constructing Hash...<br>");
    $magicNumber = hash("sha256", $email.$dob);

    /* Check if email exists */
    echo("Checking User...");
    if (checkUser($email, $database) == 1){
        echo " ...existing user found!<br>";
        echo("Checking If DOB matches...");
        if (verifyUser($email, $magicNumber, $database) == 1){
            echo("...user successfully verified!<br>");
        }
        else {
            echo("...user verification failed!<br>");
            /* do something here */
        }
    }
    else {
      echo("Creating User... <br>");
      createUser($email, $magicNumber, $database);
    }

    /* if user is verified then create a session called 'login' and store
    their email address as the session value. $_SESSION['login'] = $email
    if user does not exist then create another session with a diff name
    and pass email as the value again regardless of whether the verification
    is true or false redirect to index.php?page=questions.html.
    This page will act depending on if the previous mentioned sessions are set.
     */

    function checkUser($email, $database) {
        $query = "SELECT * FROM main WHERE email = '".$email."'";

        if(!$result = $database->query($query)){
            die('There was an error running the query [' . $database->error . ']');
        }
        return $result->num_rows;
    }

    function createUser($email, $magicNumber, $database) {
      $query = "INSERT INTO main (email, stored_magic) VALUES ('".$email."','".$magicNumber."')";
      if(!$result = $database->query($query)){
          die('There was an error running the query [' . $database->error . ']');
      }
    }
    
    function verifyUser($email, $magicNumber, $database) {
       $query = "SELECT * FROM main WHERE email = '".$email."'";
       if(!$result = $database->query($query)){
           die('There was an error running the query [' . $database->error . ']');
       }
       $row = $result->fetch_assoc();
       return ($row['stored_magic'] == $magicNumber);
    }

    /* needs to delete the user from the users table  */
    function removeUser($email) {
      echo "removeUser Stub";
    }
?>
</table>
