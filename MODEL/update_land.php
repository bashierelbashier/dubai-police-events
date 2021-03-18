<?php

session_start();
include "connect.php";
$land_no = $_POST['land_no'];
$district = $_POST['district'];
$district_no = $_POST['district_no'];
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
$locale = $_POST['locale'];
$modifier_id = $_SESSION['USER_NO'];

$query = "UPDATE T_LANDS SET  CLASS_NO = ".$classification.",
AREA =".$area." , AREA_UNIT=".$measure_unit.",
OFFICE_NO ='".$office."' , CUPBOARD_NO='".$cupboard."',
UNIT_NO ='".$unit."' , SHELF_NO='".$shelf."',
BOX_NO ='".$box."' , TYPE_NO =".$land_type.",
FOLDER_NO = '".$folder."',
DISTRICT_NO = '".$district."',
LOCALE_NO=".$locale.", MODIFIER_ID=".$modifier_id.",DATE_MODIFIED=CURTIME()
WHERE LAND_NO = '".$land_no."' AND DISTRICT_NO = ".$district_no;


if (mysqli_query($connect,$query))
{
    echo "done";
}

?>