<?php
session_start();

include "connect.php";
header('Content-type: application/json; charset=utf-8');

$event_id = $_POST['event_id'];
$type = $_POST['event_type'];
$classification = $_POST['event_classification'];
$name = mysqli_real_escape_string($connect, $_POST['event_name']);
$organizer = mysqli_real_escape_string($connect, $_POST['event_organizer']);
$location = mysqli_real_escape_string($connect, $_POST['event_location']);
$expected_audience = $_POST['expected_audience'];
$police_count = $_POST['police_count'];
$date = $_POST['event_date'];
$day = $_POST['event_day'];
$modifier_id = $_SESSION['USER_NO'];

$event_query = "UPDATE `T_EVENT` SET `EVENT_TYPE` = '". $type ."', `CLASSIFICATION` = '". $classification ."', `EVENT_NAME` = '". $name ."', `ORGANIZER` = '". $organizer ."', `EVENT_LOCATION`= '". $location ."', `EXPECTED_AUDIENCE` = '". $expected_audience ."', `POLICE_COUNT` = '". $police_count ."', `EVENT_DATE` = '". $date ."', `EVENT_DAY` = '". $day ."', `DATE_MODIFIED`= CURTIME(), `MODIFIER_ID` = '". $modifier_id ."' WHERE `ID` = " . $event_id;

$event_check = mysqli_query($connect, $event_query);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
include 'process_defaults.php';

$other_exist = mysqli_real_escape_string($connect, $_POST['other_exist']);

$info_query = "UPDATE `T_EVENT_INFO` SET `VIPS_EXIST` = '". $vips_exist ."', `OTHER_EVENT` = '". $other_event ."', `HOTELS` = '". $hotels ."', `OPERATION_ROOM` = '". $operation_room ."', `POLICE_OFFICE` = '". $police_office ."', `HELIPORTS` = '". $heliports ."', `MEDIA` = '". $media ."', `OPERATION_ROOM_LOCATION` = '". $_POST['operation_room_location'] ."', `OPERATION_ROOM_COVERING` = '". $operation_room_covering ."', `CAMERAS_NUMBER` = '". $_POST['cameras_number'] ."', `CAMERAS_RECORDING` = '". $camaeras_recording ."', `SUB_ENTRIES` = '". $_POST['sub_entries'] ."', `MAIN_ENTRIES` = '". $_POST['main_entries'] ."', `VOLUNTEERS` = '". $volunteers ."', `VOLUNTEERS_NUMBER` = '". $volunteers_number ."', `OTHER_INFO` = '". $other_exist ."' WHERE `EVENT_ID` = " . $event_id;

$info_check = mysqli_query($connect, $info_query);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$other_participants = mysqli_real_escape_string($connect, $_POST['other_participants']);

$participants_query = "UPDATE `T_EVENT_PARTICIPANTS` SET `SECURITY_SERVICE` = '". $security_service ."', `TRAFFIC` = '". $traffic ."', `CIVIL_DEFENCE` = '". $civil_defence ."', `CRIMINAL_INVESTIGATIONS` = '". $criminal_investigations ."', `PRIVATE_SECURITY` = '". $private_security ."', `OPERATIONS` = '". $operations ."', `FORENSIC_CRIMINOLOGY` = '". $forensic_criminology ."', `COMPETENT_CENTER` = '". $competent_center ."', `EXPLOSIVES_SECURITY` = '". $explosives_security ."', `PERSONAL_SECURITY` = '". $personal_security ."', `TRANSPORTATION` = '". $transportation ."', `TRANSPORT_RESCUE` = '". $transport_rescue ."', `SECURITY_INSPECTION` = '". $security_inspection ."', `EXPLOSIVES` = '". $explosives ."', `AIRPORTS_SECURITY` = '". $airports_security ."', `AMBULANCE` = '". $ambulance ."', `OTHER_PARTICIPANTS` = '". $other_participants ."' WHERE EVENT_ID = " . $event_id;

$participants_check = mysqli_query($connect, $participants_query);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$other_needs = mysqli_real_escape_string($connect, $_POST['other_needs']);

$needs_query = "UPDATE `T_EVENT_NEEDS` SET `INDIVIDUALS` = '". $_POST['individuals'] ."', `PATROLS` = '". $_POST['patrols'] ."', `DEVICES` = '". $_POST['devices'] ."', `BUSES` = '". $_POST['buses'] ."', `FEMALE_OFFICERS` = '". $_POST['female_officers'] ."', `SECURITY_BLOCKS` = '". $_POST['security_blocks'] ."', `BIKES_MOTOBIKES` = '". $_POST['bikes_motobikes'] ."', `OTHER_NEEDS` = '". $other_needs ."' WHERE EVENT_ID = " . $event_id;

$needs_check = mysqli_query($connect, $needs_query);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$transportation_others = mysqli_real_escape_string($connect, $_POST['transportation_others']);

$transportation_query = "UPDATE `T_EVENT_TRANSPORTATION` SET `BUS` = '". $transportation_bus ."', `CAR` = '". $transportation_car ."', `TAXI` = '". $transportation_taxi ."', `METRO` = '". $transportation_metro ."', `POLICE_CAR` = '". $transportation_police ."', `TRANSPORTATION_OTHERS` = '". $transportation_others ."' WHERE EVENT_ID = " . $event_id;

$transportation_check = mysqli_query($connect, $transportation_query);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$report_others = mysqli_real_escape_string($connect, $_POST['report_others']);
$report_notes = mysqli_real_escape_string($connect, $_POST['report_notes']);

$report_query = "UPDATE `T_EVENT_REPORT` SET `EMERGENCY_PLAN` = '". $emergency_plan ."', `VIP_LIST` = '". $vip_list ."', `ID_CARDS` = '". $id_cards ."', `CORRESPONDENCE` = '". $correspondence ."', `INDIVIDUALS_LIST` = '". $individuals_list ."', `INVITATION_CARD` = '". $invitation_card ."', `VOLUNTEERS_LIST` = '". $volunteers_list ."', `ORGINZERS_LIST` = '". $orginzers_list ."', `SECURITY_LIST` = '". $security_list ."', `PARTICIPANTS_PLANS` = '". $participants_plans ."', `OPERATION_COST` = '". $operation_cost ."', `CLASSIFICATION_FORM` = '". $classification_form ."', `SUCCESS_FORM` = '". $success_form ."', `REPORT_OTHERS` = '". $report_others ."', `NOTES` = '". $report_notes ."' WHERE EVENT_ID = " . $event_id;

$report_check = mysqli_query($connect, $report_query);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if ($event_check && $info_check && $participants_check && $needs_check && $transportation_check && $report_check) {
    echo json_encode([
        'success'  => 'done'
    ]);
}
?>