<?php
session_start();

include "connect.php";
header('Content-type: application/json; charset=utf-8');

$name = $_POST['hotel_name'];
$location = $_POST['hotel_location'];
$coordinates = $_POST['hotel_coordinates'];
$event_id = $_POST['event_id'];

$query = "INSERT INTO `T_EVENT_HOTELS`(`EVENT_ID`, `HOTEL_NAME`, `HOTEL_LOCATION`, `HOTEL_COORDINATES`) VALUES (". $event_id .", '". $name ."', '". $location ."', '". $coordinates ."')";
if (mysqli_query($connect,$query)) {
    echo json_encode([
        'success' => "done"
    ]);
}
?>