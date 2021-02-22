<?php
session_start();
include "connect.php";
$owner_name = $_POST['owner_name'];
$owner_type = $_POST['owner_type'];
$phone1 = $_POST['phone1'];
$phone2 = $_POST['phone2'];
$idtype = $_POST['idtype'];
$idno = $_POST['idno'];
$notes = $_POST['notes'];

$creator = $_SESSION['USER_NO'];


$q = "SELECT MAX(OWNER_NO) AS MAX FROM T_OWNERS";
$r = mysqli_query($connect,$q);
$w = mysqli_fetch_array($r);
$owner_no = $w['MAX']+1;
$query = "INSERT INTO T_OWNERS VALUES (".$owner_no.",'".$owner_name."',".$owner_type.",'".$phone1."',
'".$phone2."',".$idtype.",'".$idno."','".$notes."',CURTIME(),".$creator.",NULL,NULL)";
if (mysqli_query($connect,$query))
{
    echo $owner_no;
}



?>