<?php
include "conn.php";
if(isset($_POST['email'])){
    $email = $_POST['email'];

    $sql= "INSERT INTO user(email) VALUES(?)";
    $stmt = $con->prepare($sql);
    $stmt->execute([$email]);
}