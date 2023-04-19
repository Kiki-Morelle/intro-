<?php
$con =  new mysqli("localhost", "root","", "new");
if(!$con){
	echo"connection fail";
}
else{
	echo "connection success";
}
