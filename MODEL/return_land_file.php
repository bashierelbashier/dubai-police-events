<?php
session_start();
include "connect.php";
$land = $_POST['land'];
$district = $_POST['district'];

$q = "SELECT MAX(BORROW_DATE) AS MAX FROM T_BORROW_LAND_FILE WHERE
      LAND_NO = '".$land."' AND DISTRICT_NO = ".$district." AND RETURNED = FALSE ";

$r = mysqli_query($connect,$q);

$o = mysqli_fetch_array($r);


$query = "UPDATE T_BORROW_LAND_FILE SET RETURNED =TRUE , RETURN_DATE =CURDATE()
          WHERE LAND_NO = '".$land."' AND DISTRICT_NO = ".$district." AND BORROW_DATE  ='".$o['MAX']."'";


if (mysqli_query($connect,$query))
{
    echo "done";
}

?>