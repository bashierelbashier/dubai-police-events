<?php
session_start();

include "connect.php";
header('Content-type: application/json; charset=utf-8');

$id = $_POST['id'];
$name = $_POST['name'];
$reference = $_POST['reference'];
$position = $_POST['position'];

$query = "UPDATE `T_COORDINATORS` SET `NAME` = '". $name ."', `REFERENCE` = '". $reference ."', `POSITION` = '". $position ."' WHERE `ID` = '". $id ."'";
if (mysqli_query($connect,$query)) {
    echo json_encode([
        'success' => "done"
    ]);
}
?>