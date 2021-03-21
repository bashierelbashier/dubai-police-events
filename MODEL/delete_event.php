<?php
include "connect.php";

$event_id = $_POST['event_id'];

$delete_info = "DELETE FROM T_EVENT_INFO WHERE EVENT_ID = ". $event_id;
echo $delete_info;
mysqli_query($connect, $delete_info);
$delete_participants = "DELETE FROM T_EVENT_PARTICIPANTS WHERE EVENT_ID = ". $event_id;
mysqli_query($connect, $delete_participants);
$delete_needs = "DELETE FROM T_EVENT_NEEDS WHERE EVENT_ID = ". $event_id;
mysqli_query($connect, $delete_needs);
$delete_transportation = "DELETE FROM T_EVENT_TRANSPORTATION WHERE EVENT_ID = ". $event_id;
mysqli_query($connect, $delete_transportation);
$delete_report = "DELETE FROM T_EVENT_REPORT WHERE EVENT_ID = ". $event_id;
mysqli_query($connect, $delete_report);
$delete_coordinators = "DELETE FROM T_COORDINATORS WHERE EVENT_ID = ". $event_id;
mysqli_query($connect, $delete_coordinators);
$delete_hotels = "DELETE FROM T_EVENT_HOTELS WHERE EVENT_ID = ". $event_id;
mysqli_query($connect, $delete_hotels);
$delete_event = "DELETE FROM T_EVENT WHERE ID = ". $event_id;

if (mysqli_query($connect, $delete_event))
{
    echo "done";
}
?>