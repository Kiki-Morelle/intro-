<?php
include "conn.php";
if(isset($_POST['email'])){
    $email = $_POST['email'];

$sql = "INSERT INTO user(email) VALUES('$email')";
        // echo " '$email'";
    mysqli_query($con,$sql);
}
else{
    echo "value email has not been set";
}
