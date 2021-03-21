<?php
session_start();
include "connect.php";

$username = $_POST['user_name'];
$fullname = $_POST['full_name'];
$password = $_POST['password'];
$active = $_POST['active'];
$privilege = $_POST['privilege'];
$RANKING = $_POST['RANKING'];

if (file_exists($_FILES['signature']['tmp_name'])) {
    $fileExt = explode('.', $_FILES['signature']['name']);
    $fileActualExt = strtolower(end($fileExt));
    $img_signature = uniqid('', true) .".". $fileActualExt;
    move_uploaded_file($_FILES['signature']['tmp_name'], '../IMAGES/' . $img_signature);
}
else {
    $img_signature = '';
}

$q = "SELECT MAX(USER_NO) AS MAX FROM T_USERS";
$r = mysqli_query($connect, $q);
$w = mysqli_fetch_array($r);
$max = $w['MAX'] + 1;


$query = "INSERT INTO T_USERS VALUES (" . $max . ",'" . $username . "','" . md5($password) . "'," . $active . ",'" . $fullname . "'," . $privilege . ",CURTIME(), '". $img_signature ."', '". $RANKING ."')";



if (mysqli_query($connect, $query)) {
    "done";
}