<?php

session_start();
include "connect.php";
$land = $_POST['b_land_no'];
$district = $_POST['b_district'];
$borrower = $_POST['borrower'];
$management = $_POST['management'];
$purpose = $_POST['purpose'];
$borrow_date = $_POST['borrow_date'];
$hander = $_POST['hander'];


$query = "INSERT INTO T_BORROW_LAND_FILE VALUES ('".$land."',".$district.",
'".$borrower."','".$management."','".$purpose."'
,'".$borrow_date."','".$hander."',FALSE,NULL)";

echo $query;

if (mysqli_query($connect,$query))
{
    echo "done";
}

?>