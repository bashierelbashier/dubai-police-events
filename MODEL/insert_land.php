<?php
session_start();
include "connect.php";
$land_no = $_POST['land_no'];
$district = $_POST['district'];
$locale = $_POST['locale'];
$classification = $_POST['classification'];
$area = $_POST['area'];
$office = $_POST['office_no'];
$cupboard = $_POST['cupboard_no'];
$unit = $_POST['unit_no'];
$shelf = $_POST['shelf_no'];
$box = $_POST['box_no'];
$folder = $_POST['folder_no'];
$land_type = $_POST['land_type'];
$measure_unit = $_POST['measure_unit'];
$creator = $_SESSION['USER_NO'];


$query = "INSERT INTO T_LANDS VALUES ('".$land_no."',".$measure_unit.",".$area.",".$land_type.",".$classification.",
".$district.",".$locale.",'".$office."','".$cupboard."','".$unit."','".$shelf."','".$box."','".$folder."',0,CURTIME(),".$creator.",NULL,NULL)";
if (mysqli_query($connect,$query))
{
    echo "done";
}



?>