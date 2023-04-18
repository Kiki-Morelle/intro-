<?php
$con = @mysqli_connect("localhost", "root", "", "basic");
if(!$con){
  echo "Connection failed!".@mysqli_error($con);
}