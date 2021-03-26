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
        
        $output .= "<tr id= '".$event_id."' class= 'event-row' align= 'center'>
            <td>".$count."</td>
            <td>".date('Y/m/d', strtotime($row['EVENT_DATE']))."</td>
            <td>".$row['EVENT_NAME']."</td>
            <td>".$row['EVENT_LOCATION']."</td>
            <td>".$row['EXPECTED_AUDIENCE']."</td>
            <td>".$row['POLICE_COUNT']."</td>
            <td class='text-center' style='width: 14%;'>";

            if ($_SESSION['PRIVILEGE'] == 1 || $row['CREATOR_ID'] == $_SESSION['USER_NO']) {
                $output .= "<a href='../REPORTS/event.php?id=".$row['ID']."' class='btn btn-info' title='إستخراج' style='margin-left: 5px;'><i class='fa fa-print'></i></a>";
            }

            $output .= "<a href='edit_event.php?ID=".$row['ID']."' class='btn btn-primary' title='تعديل ' style='margin-left: 5px;'><i class='fa fa-edit'></i></a>";
            
            if ($_SESSION['PRIVILEGE'] == 1) {
                $output .= "<button type='button' class='btn btn-danger delete-event' data-id='".$row['ID']."' title='حذف'><i class='fa fa-times'></i></button>";
            }

            $output .= "</td>
            <td class='event-tooltip row'>
                <span class='col-xs-6 text-center'>تم الإنشاء بواسطة: <strong>".$row['CREATOR_NAME']."</strong> - يوم: <strong>".date('Y/m/d', strtotime($row['DATE_CREATED']))."</strong> الساعة: <strong>".date('h:i', strtotime($row['DATE_CREATED'])) ." ". $created_date_time ."</strong></span>";
            if ($row['MODIFIER_NAME'] && $row['DATE_MODIFIED']) {
                $output .= "<span class='col-xs-6 text-center'>آخر تعديل بواسطة: <strong>".$row['MODIFIER_NAME']."</strong> - يوم: <strong>".date('Y/m/d', strtotime($row['DATE_MODIFIED']))."</strong> الساعة: <strong>".date('h:i', strtotime($row['DATE_MODIFIED'])) ." ". $modified_date_time ."</strong></span>";
            }
            else {
                $output .= "<span class='col-xs-6 text-center'>لا يوجد تعديل</span>";
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