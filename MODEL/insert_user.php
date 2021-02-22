<?php
session_start();
include "connect.php";

$username = $_POST['user_name'];
$fullname = $_POST['full_name'];
$password = $_POST['password'];
$active = $_POST['active'];
$privilege = $_POST['privilege'];


$q = "SELECT MAX(USER_NO) AS MAX FROM T_USERS";
$r = mysqli_query($connect,$q);
$w = mysqli_fetch_array($r);
$max = $w['MAX']+1;


$query="INSERT INTO T_USERS VALUES (".$max.",'".$username."','".md5($password)."',".$active.",'".$fullname."',".$privilege.",CURTIME())";



if (mysqli_query($connect,$query))
{
    "done";
}



?>