<?php
session_start();

include "connect.php";
header('Content-type: application/json; charset=utf-8');

$name = $_POST['name'];
$reference = $_POST['reference'];
$position = $_POST['position'];
$event_id = $_POST['event_id'];

$query = "INSERT INTO `T_COORDINATORS`(`EVENT_ID`, `NAME`, `REFERENCE`, `POSITION`) VALUES (". $event_id .", '". $name ."', '". $reference ."', '". $position ."')";
if (mysqli_query($connect,$query)) {
    echo json_encode([
        'success' => "done"
    ]);
}
?>