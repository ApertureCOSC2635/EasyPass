<table>
<?php
    $user="root";
    $password="Zeppelin01";
    $database="easypass";
    mysql_connect(localhost,$user,$password);
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
?>
</table>
