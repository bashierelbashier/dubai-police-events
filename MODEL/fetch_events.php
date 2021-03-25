<?php

session_start();
include "connect.php";

$limit = $_POST['limit'];
$start = $_POST['start'];


if (isset($_POST['filter_from']) && $_POST['filter_from'] != '' && isset($_POST['filter_to']) && $_POST['filter_to'] != '') {
    $query = "SELECT T_EVENT.*, CREATOR.FULL_NAME AS CREATOR_NAME, MODIFIER.FULL_NAME AS MODIFIER_NAME FROM T_EVENT JOIN T_USERS AS CREATOR ON T_EVENT.CREATOR_ID = CREATOR.USER_NO LEFT JOIN T_USERS AS MODIFIER ON T_EVENT.CREATOR_ID = MODIFIER.USER_NO WHERE EVENT_DATE >= '".$_POST['filter_from']."' AND EVENT_DATE <= '".$_POST['filter_to']."'";
}
else if (isset($_POST['filter_from']) && $_POST['filter_from'] != '') {
    $query = "SELECT T_EVENT.*, CREATOR.FULL_NAME AS CREATOR_NAME, MODIFIER.FULL_NAME AS MODIFIER_NAME FROM T_EVENT JOIN T_USERS AS CREATOR ON T_EVENT.CREATOR_ID = CREATOR.USER_NO LEFT JOIN T_USERS AS MODIFIER ON T_EVENT.CREATOR_ID = MODIFIER.USER_NO WHERE EVENT_DATE >= '".$_POST['filter_from']."'";
}
else if (isset($_POST['filter_to']) && $_POST['filter_to'] != '') {
    $query = "SELECT T_EVENT.*, CREATOR.FULL_NAME AS CREATOR_NAME, MODIFIER.FULL_NAME AS MODIFIER_NAME FROM T_EVENT JOIN T_USERS AS CREATOR ON T_EVENT.CREATOR_ID = CREATOR.USER_NO LEFT JOIN T_USERS AS MODIFIER ON T_EVENT.CREATOR_ID = MODIFIER.USER_NO WHERE EVENT_DATE <= '".$_POST['filter_to']."'";
}
else {
    $query = "SELECT T_EVENT.*, CREATOR.FULL_NAME AS CREATOR_NAME, MODIFIER.FULL_NAME AS MODIFIER_NAME FROM T_EVENT JOIN T_USERS AS CREATOR ON T_EVENT.CREATOR_ID = CREATOR.USER_NO LEFT JOIN T_USERS AS MODIFIER ON T_EVENT.CREATOR_ID = MODIFIER.USER_NO ";
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

        if (date('A', strtotime($row['DATE_CREATED'])) == 'AM') {
            $created_date_time = 'ص';
        }
        else {
            $created_date_time = 'م';
        }

        if (date('A', strtotime($row['DATE_MODIFIED'])) == 'AM') {
            $modified_date_time = 'ص';
        }
        else {
            $modified_date_time = 'م';
        }
        
        $output .= "<tr id= '".$event_id."' class= 'event-row' style= 'cursor:pointer;' align= 'center' aria-label='تم الإنشاء في ".$row['DATE_CREATED']."، تاريخ آخر تعديل ".$row['DATE_MODIFIED']."'>
            <td>".$count."</td>
            <td>".$row['EVENT_NAME']."</td>
            <td>".$row['EVENT_TYPE']."</td>
            <td>".$row['CLASSIFICATION']."</td>
            <td>".$row['ORGANIZER']."</td>
            <td>".$row['EVENT_LOCATION']."</td>
            <td>".$row['EXPECTED_AUDIENCE']."</td>
            <td>".$row['POLICE_COUNT']."</td>
            <td>".date('Y-m-d', strtotime($row['EVENT_DATE']))."</td>
            <td class='event-tooltip' colspan='8'>
                <span>تم الإنشاء بواسطة: <strong>".$row['CREATOR_NAME']."</strong> - يوم: <strong>".date('Y/m/d', strtotime($row['DATE_CREATED']))."</strong> الساعة: <strong>".date('h:i', strtotime($row['DATE_CREATED'])) ." ". $created_date_time ."</strong></span>";
            if ($row['MODIFIER_NAME'] && $row['DATE_MODIFIED']) {
                $output .= "<span>آخر تعديل بواسطة: <strong>".$row['MODIFIER_NAME']."</strong> - يوم: <strong>".date('Y/m/d', strtotime($row['DATE_MODIFIED']))."</strong> الساعة: <strong>".date('h:i', strtotime($row['DATE_MODIFIED'])) ." ". $modified_date_time ."</strong></span>";
            }
            else {
                $output .= "<span>لا يوجد تعديل</span>";
            }
            $output .="</td>
        </tr>";

        $count++;
    }
}
else {
    $output .= '<tr align="center"><td colspan="10"> لاتوجد بيانات </td></tr>';
}

echo $output;

?>