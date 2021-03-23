<?php
session_start();

include "connect.php";
header('Content-type: application/json; charset=utf-8');

$id = $_POST['id'];
$name = $_POST['hotel_name'];
$location = $_POST['hotel_location'];
$coordinates = $_POST['hotel_coordinates'];

$query = "UPDATE `T_EVENT_HOTELS` SET `HOTEL_NAME` = '". $name ."', `HOTEL_LOCATION` = '". $location ."', `HOTEL_COORDINATES` = '". $coordinates ."' WHERE `ID` = '". $id ."'";
if (mysqli_query($connect,$query)) {
    echo json_encode([
        'success' => "done"
    ]);
}
?>