<?php
session_start();
include "connect.php";

$owner_no = $_POST['owner_no'];
$owner_name = $_POST['owner_name'];
$owner_type = $_POST['owner_type'];
$phone1 = $_POST['phone1'];
$phone2 = $_POST['phone2'];
$idtype = $_POST['idtype'];
$idno = $_POST['idno'];
$notes = $_POST['notes'];

$modifier_id = $_SESSION['USER_NO'];







$query = "UPDATE T_OWNERS SET  OWNER_NAME = '".$owner_name."',OWNER_TYPE = ".$owner_type.",
PHONE_NO1 ='".$phone1."' , PHONE_NO2 = '".$phone2."',NOTES = '".$notes."',
IDENTITY_TYPE =".$idtype.", IDENTITY_NO='".$idno."', MODIFIER_ID=".$modifier_id.",DATE_MODIFIED=CURTIME()
WHERE OWNER_NO = ".$owner_no;

if (mysqli_query($connect,$query))
{
    echo "done";
}

?>