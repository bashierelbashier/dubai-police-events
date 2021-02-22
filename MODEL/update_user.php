<?php
session_start();
include "connect.php";

$userno = $_POST['user_no'];
$username = $_POST['user_name'];
$fullname = $_POST['full_name'];
$password = $_POST['password'];
$active = $_POST['active'];
$privilege = $_POST['privilege'];

if ($password == '')
{
    $query="UPDATE T_USERS SET USER_NAME = '".$username."' ,
    ACTIVE =  ".$active.",
    FULL_NAME = '".$fullname."', PRIVILEGE_NO = ".$privilege."
    WHERE USER_NO = ".$userno;

}else{

    $query="UPDATE T_USERS SET USER_NAME = '".$username."' ,
    PASSWORD = '".md5($password)."', ACTIVE =  ".$active.",
    FULL_NAME = '".$fullname."', PRIVILEGE_NO = ".$privilege."
    WHERE USER_NO = ".$userno;

}


if (mysqli_query($connect,$query))
{
    "done";
}



?>