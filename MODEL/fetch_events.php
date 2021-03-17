<?php

session_start();
include "connect.php";

$limit = $_POST['limit'];
$start = $_POST['start'];


if (isset($_POST['filter_from']) && $_POST['filter_from'] != '' && isset($_POST['filter_to']) && $_POST['filter_to'] != '') {
    $query = "SELECT * FROM T_EVENT WHERE EVENT_DATE >= '".$_POST['filter_from']."' AND EVENT_DATE <= '".$_POST['filter_to']."'";
}
else if (isset($_POST['filter_from']) && $_POST['filter_from'] != '') {
    $query = "SELECT * FROM T_EVENT WHERE EVENT_DATE >= '".$_POST['filter_from']."'";
}
else if (isset($_POST['filter_to']) && $_POST['filter_to'] != '') {
    $query = "SELECT * FROM T_EVENT WHERE EVENT_DATE <= '".$_POST['filter_to']."'";
}
else {
    $query = "SELECT * FROM T_EVENT";
}

if ($_SESSION['PRIVILEGE'] == 2) {
    $query .= " WHERE CREATOR_ID = " . $_SESSION['USER_NO'];
}

$query .= " ORDER BY EVENT_DATE LIMIT ".$start.",".$limit;

$result= mysqli_query($connect,$query);

$output = "";

$count = $start + 1;

if (mysqli_num_rows($result)>0)
{
    while ($row=mysqli_fetch_array($result))
    {
        $event_id = $row['ID'];
        include "process_event_type.php";

        $output .= "<tr id= '".$event_id."' class= 'event-row' style= 'cursor:pointer;' align= 'center'>
            <td>".$count."</td>
            <td>".$row['EVENT_NAME']."</td>
            <td>".$row['EVENT_TYPE']."</td>
            <td>".$row['CLASSIFICATION']."</td>
            <td>".$row['ORGANIZER']."</td>
            <td>".$row['EVENT_LOCATION']."</td>
            <td>".$row['EXPECTED_AUDIENCE']."</td>
            <td>".$row['POLICE_COUNT']."</td>
            <td>".date('Y-m-d', strtotime($row['EVENT_DATE']))."</td>
        </tr>";

        $count++;
    }
}
else {
    $output .= '<tr align="center"><td colspan="10"> لاتوجد بيانات </td></tr>';
}

echo $output;

?>