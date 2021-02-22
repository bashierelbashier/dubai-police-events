<?php
include "connect.php";
$land_no = $_POST['land_no'];
$district_no = $_POST['district_no'];

$query = "DELETE FROM T_LANDS WHERE LAND_NO='".$land_no."' AND DISTRICT_NO ='".$district_no."'";

if (mysqli_query($connect,$query))
{
    echo "done";
}
?>