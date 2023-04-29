<?php 
session_start();
include "conn.php";
function check($data){
  $data= trim($data); //trim spaces on data
  $data= htmlspecialchars($data); //converts special characters into HTML entities
  $data= stripslashes($data); //used to clean up data retrieved from a database or from an HTML form
  $data = mysqli_real_escape_string($con, $data); // escape special characters in string
  return $data;
}


if(isset($_POST["login"])){
  $uname = $_POST['username'];
  $pword = md5($_POST['password']);
  //$rem = $_COOKIE['rememberme'];
  $sql = "SELECT * FROM tenant WHERE user_name = '$uname' AND password = '$pword'";
  $sql1 = "SELECT * FROM user WHERE user_name = '$uname' AND password = '$pword'";
  $query = mysqli_query($con, $sql);
  $query1 = mysqli_query($con, $sql1);
  $row = mysqli_fetch_assoc($query);
  $row1 = mysqli_fetch_assoc($query1);

  do {
    $role = $row1['role'];
    $row1 = mysqli_fetch_assoc($query1);
  } while ($row1);

  do{
    $fname = $row['first_Name'];

    $lname = $row['last_Name'];

    $tenant_status = $row['tenant_status'];

    $tenant_id = $row['tenant_id'];
    $sql2 = "SELECT * FROM contract WHERE tenant_id = '$tenant_id'";
    $query2 = mysqli_query($con, $sql2);
    $row1 = mysqli_fetch_assoc($query2);

    do{
      $end_date = $row1['end_day'];
      $house_id = $row1['house_id'];
      $row1 = mysqli_fetch_assoc($query2);
    }while ($row1);
    $row = mysqli_fetch_assoc($query);

  }while ($row);

  if ((mysqli_num_rows($query) == 1) || (mysqli_num_rows($query1) == 1)) {
    if($role == "Administrator"){
      $_SESSION['user_name'] = $uname;
      echo "<script type='text/javascript'>alert('Welcome $uname!');</script>";
      echo '<style>body{display:none;}</style>';
      echo '<script>window.location.href = "admin_home.php";</script>';

    }
    elseif ($role == "Manager") {
      $_SESSION['user_name'] = $uname;
      echo "<script type='text/javascript'>alert('Welcome $uname!');</script>";
      echo '<style>body{display:none;}</style>';
      echo '<script>window.location.href = "manager_home.php";</script>';
    }
    else {

      if ($tenant_status == 0) {
        $_SESSION['user_name'] = $uname;
        echo "<script type='text/javascript'>alert('Welcome $fname $lname!');</script>";
        echo '<style>body{display:none;}</style>';
        echo '<script>window.location.href = "initial_payment.php";</script>';
      }elseif ($tenant_status == 1) {
        $_SESSION['user_name'] = $uname;
        echo "<script type='text/javascript'>alert('Welcome $fname $lname!');</script>";
        echo '<style>body{display:none;}</style>';
        echo '<script>window.location.href = "home.php";</script>';
      }elseif ($tenant_status == 2) {
        $_SESSION['user_name'] = $uname;
        echo "<script type='text/javascript'>alert('Welcome $fname $lname!');</script>";
        echo '<style>body{display:none;}</style>';
        echo '<script>window.location.href = "waiting.php";</script>';
      }elseif((date('Y-m-d') > $end_date) && $tenant_status == 1){
        $sql3 = "UPDATE tenant SET tenant_status = '3' WHERE tenant_id = '$tenant_id'";
        mysqli_query($con, $sql3);
        $sql5 = "UPDATE contract SET status ='Inactive' WHERE status = 'Active' AND tenant_id = '$tenant_id'";
        mysqli_query($con, $sql5);
        $sql5 = "UPDATE house SET status ='Empty' WHERE house_id = '$house_id'";
        mysqli_query($con, $sql5);
        $_SESSION['user_name'] = $uname;
        echo "<script type='text/javascript'>alert('Welcome $fname $lname! Your contract has expired. To access the system please renew the contract.');</script>";
        echo '<style>body{display:none; color:red;}</style>';
        echo '<script>window.location.href = "renew_contract.php";</script>';

      }elseif ($tenant_status == 3) {
        $_SESSION['user_name'] = $uname;
        echo "<script type='text/javascript'>alert('Welcome $fname $lname! Your contract has expired. To access the system please renew the contract.');</script>";
        echo '<style>body{display:none;}</style>';
        echo '<script>window.location.href = "renew_contract.php";</script>';
      }
    }
    mysqli_close($con);
    $uname = "";


  }else {
    echo "<script style = 'color:red;'> alert('Incorrect Username or Password!!!')</script>";
  }

} 

?>
