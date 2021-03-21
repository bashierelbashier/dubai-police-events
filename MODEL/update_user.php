<?php
session_start();
include "connect.php";

$userno = $_POST['user_no'];
$username = $_POST['user_name'];
$fullname = $_POST['full_name'];
$password = $_POST['password'];
$active = $_POST['active'];
$privilege = $_POST['privilege'];
$RANKING = $_POST['RANKING'];

$query = "SELECT * FROM T_USERS WHERE USER_NO = " . $_POST['user_no'];
$result = mysqli_query($connect, $query);
$row = mysqli_fetch_array($result);
if (file_exists($_FILES['signature']['tmp_name'])) {

    if ($row['IMG_SIGNATURE']) {
        unlink('../IMAGES/' . $row['IMG_SIGNATURE']);
    }

    $fileExt = explode('.', $_FILES['signature']['name']);
    $fileActualExt = strtolower(end($fileExt));
    $img_signature = uniqid('', true) .".". $fileActualExt;
    move_uploaded_file($_FILES['signature']['tmp_name'], '../IMAGES/' . $img_signature);
}
else {
    $img_signature = $row['IMG_SIGNATURE'];
}

if ($password == '')
{
    $query="UPDATE T_USERS SET USER_NAME = '".$username."' ,
    ACTIVE =  ".$active.",
    FULL_NAME = '".$fullname."', PRIVILEGE_NO = ".$privilege.",
    IMG_SIGNATURE = '". $img_signature ."',
    RANKING = '". $RANKING ."'
    WHERE USER_NO = ".$userno;

}else{

    $query="UPDATE T_USERS SET USER_NAME = '".$username."' ,
    PASSWORD = '".md5($password)."', ACTIVE =  ".$active.",
    FULL_NAME = '".$fullname."', PRIVILEGE_NO = ".$privilege.",
    IMG_SIGNATURE = '". $img_signature ."',
    RANKING = '". $RANKING ."'
    WHERE USER_NO = ".$userno;

}


if (mysqli_query($connect,$query))
{
    "done";
}



?>