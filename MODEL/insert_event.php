<?php
session_start();

include "connect.php";
header('Content-type: application/json; charset=utf-8');

$type = $_POST['event_type'];
$classification = $_POST['event_classification'];
$name = mysqli_real_escape_string($connect, $_POST['event_name']);
$organizer = mysqli_real_escape_string($connect, $_POST['event_organizer']);
$location = mysqli_real_escape_string($connect, $_POST['event_location']);
$expected_audience = $_POST['expected_audience'];
$police_count = $_POST['police_count'];
$event_date = $_POST['event_date'];
$day = $_POST['event_day'];
$creator_id = $_SESSION['USER_NO'];

$max_query = "SELECT MAX(ID) AS MAX FROM T_EVENT";
$max_result = mysqli_query($connect, $max_query);
$max_fetch = mysqli_fetch_array($max_result);

if ($max_fetch['MAX'] == 1) {
    $event_id = $max_fetch['MAX'];
}
else {
    $event_id = $max_fetch['MAX'] + 1;
}

$event_query = "INSERT INTO `T_EVENT`( `ID`, `EVENT_TYPE`, `CLASSIFICATION`, `EVENT_NAME`, `ORGANIZER`, `EVENT_LOCATION`, `EXPECTED_AUDIENCE`, `POLICE_COUNT`, `EVENT_DAY`, `DATE_CREATED`, `CREATOR_ID`)
    VALUES (". $event_id .", '". $type. "', '". $classification ."', '". $name ."', '". $organizer ."', '". $location ."', ". $expected_audience .", ". $police_count .", '". $day ."', CURTIME(), ". $creator_id .")";


$event_check = mysqli_query($connect, $event_query);
mysqli_query($connect, "UPDATE `T_EVENT` SET `EVENT_DATE` = '". $event_date ."' WHERE ID = " . $event_id);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
include 'process_defaults.php';

$hotel_name = mysqli_real_escape_string($connect, $_POST['hotel_name']);
$hotel_location = mysqli_real_escape_string($connect, $_POST['hotel_location']);
$hotel_coordinates = mysqli_real_escape_string($connect, $_POST['hotel_coordinates']);
$coordination_rank = mysqli_real_escape_string($connect, $_POST['coordination_rank']);
$coordination_name = mysqli_real_escape_string($connect, $_POST['coordination_name']);
$other_exist = mysqli_real_escape_string($connect, $_POST['other_exist']);

$info_query = "INSERT INTO `T_EVENT_INFO`(`EVENT_ID`, `VIPS_EXIST`, `OTHER_EVENT`, `HOTELS`, `OPERATION_ROOM`, `POLICE_OFFICE`, `HELIPORTS`, `MEDIA`, `OPERATION_ROOM_LOCATION`, `OPERATION_ROOM_COVERING`, `CAMERAS_NUMBER`, `CAMERAS_RECORDING`, `SUB_ENTRIES`, `MAIN_ENTRIES`, `HOTEL_NAME`, `HOTEL_LOCATION`, `HOTEL_COORDINATES`, `VOLUNTEERS`, `VOLUNTEERS_NUMBER`, `COORDINATOR_RANK`, `COORDINATOR_NAME`, `OTHER_INFO`)
    VALUES (". $event_id .", ". $vips_exist .", ". $other_event .", ". $hotels .", ". $operation_room .", ". $police_office .", ". $heliports .", ". $media .", '". $_POST['operation_room_location'] ."', ". $operation_room_covering .", ". $_POST['cameras_number'] .", ". $camaeras_recording .", ". $_POST['sub_entries'] .", ". $_POST['main_entries'] .", '". $hotel_name ."', '". $hotel_location ."', '". $hotel_coordinates ."', ". $volunteers .", ". $volunteers_number .", '". $coordination_rank ."', '". $coordination_name ."', '". $other_exist ."')";

$info_check = mysqli_query($connect, $info_query);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$other_participant11 = mysqli_real_escape_string($connect, $_POST['other_participant11']);
$other_participant12 = mysqli_real_escape_string($connect, $_POST['other_participant12']);
$other_participant13 = mysqli_real_escape_string($connect, $_POST['other_participant13']);
$other_participant14 = mysqli_real_escape_string($connect, $_POST['other_participant14']);

$participants_query = "INSERT INTO `T_EVENT_PARTICIPANTS`(`EVENT_ID`, `SECURITY_SERVICE`, `TRAFFIC`, `CIVIL_DEFENCE`, `CRIMINAL_INVESTIGATIONS`, `PRIVATE_SECURITY`, `OPERATIONS`, `FORENSIC_CRIMINOLOGY`, `COMPETENT_CENTER`, `EXPLOSIVES_SECURITY`, `PERSONAL_SECURITY`, `TRANSPORTATION`, `TRANSPORT_RESCUE`, `SECURITY_INSPECTION`, `EXPLOSIVES`, `AIRPORTS_SECURITY`, `AMBULANCE`, `OTHER_PARTICIPANT1`, `OTHER_PARTICIPANT2`, `OTHER_PARTICIPANT3`, `OTHER_PARTICIPANT4`)
    VALUES (". $event_id .", ". $security_service .", ". $traffic .", ". $civil_defence .", ". $criminal_investigations .", ". $private_security .", ". $operations .", ". $forensic_criminology .", ". $competent_center .", ". $explosives_security .", ". $personal_security .", ". $transportation .", ". $transport_rescue .", ". $security_inspection .", ". $explosives .", ". $airports_security .", ". $ambulance .", '". $other_participant11 ."', '". $other_participant12 ."', '". $other_participant13 ."', '". $other_participant14 ."')";

$participants_check = mysqli_query($connect, $participants_query);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$other_needs1 = mysqli_real_escape_string($connect, $_POST['other_needs1']);
$other_needs2 = mysqli_real_escape_string($connect, $_POST['other_needs2']);

$needs_query = "INSERT INTO `T_EVENT_NEEDS`(`EVENT_ID`, `INDIVIDUALS`, `PATROLS`, `DEVICES`, `BUSES`, `FEMALE_OFFICERS`, `SECURITY_BLOCKS`, `BIKES_MOTOBIKES`, `OTHER_NEEDS1`, `OTHER_NEEDS2`)
    VALUES (". $event_id .", ". $_POST['individuals'] .", ". $_POST['patrols'] .", ". $_POST['devices'] .", ". $_POST['buses'] .", ". $_POST['female_officers'] .", ". $_POST['security_blocks'] .", ". $_POST['bikes_motobikes'] .", '". $other_needs1 ."','". $other_needs2 ."')";

$needs_check = mysqli_query($connect, $needs_query);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$transportation_query = "INSERT INTO `T_EVENT_TRANSPORTATION`(`EVENT_ID`, `BUS`, `CAR`, `TAXI`, `METRO`, `OTHER`)
    VALUES (". $event_id .",". $transportation_bus .",". $transportation_car .",". $transportation_taxi .",". $transportation_metro .",". $transportation_other .")";

$transportation_check = mysqli_query($connect, $transportation_query);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$report_other1 = mysqli_real_escape_string($connect, $_POST['report_other1']);
$report_other2 = mysqli_real_escape_string($connect, $_POST['report_other2']);
$report_other3 = mysqli_real_escape_string($connect, $_POST['report_other3']);
$report_notes = mysqli_real_escape_string($connect, $_POST['report_notes']);

$report_query = "INSERT INTO `T_EVENT_REPORT`(`EVENT_ID`, `EMERGENCY_PLAN`, `VIP_LIST`, `ID_CARDS`, `CORRESPONDENCE`, `INDIVIDUALS_LIST`, `INVITATION_CARD`, `VOLUNTEERS_LIST`, `ORGINZERS_LIST`, `SECURITY_LIST`, `PARTICIPANTS_PLANS`, `OPERATION_COST`, `CLASSIFICATION_FORM`, `SUCCESS_FORM`, `REPORT_OTHER1`, `REPORT_OTHER2`, `REPORT_OTHER3`, `NOTES`)
    VALUES (". $event_id .", ". $emergency_plan .", ". $vip_list .", ". $id_cards .", ". $correspondence .", ". $individuals_list .", ". $invitation_card .", ". $volunteers_list .", ". $orginzers_list .", ". $security_list .", ". $participants_plans .", ". $operation_cost .", ". $classification_form .", ". $success_form .", '". $report_other1 ."', '". $report_other2 ."', '". $report_other3 ."', '". $report_notes ."')";

$report_check = mysqli_query($connect, $report_query);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if (isset($_POST['coordinator_name']) && isset($_POST['coordinator_reference']) && isset($_POST['coordinator_position'])) {
    $coordinator_name = $_POST['coordinator_name'];
    $coordinator_reference = $_POST['coordinator_reference'];
    $coordinator_position = $_POST['coordinator_position'];
    
    foreach ($coordinator_name as $key => $coordinator) {
        $coordinators_query = "INSERT INTO `T_COORDINATORS`(`EVENT_ID`, `NAME`, `REFERENCE`, `POSITION`) VALUES (". $event_id .", '". $coordinator_name[$key] ."', '". $coordinator_reference[$key] ."', '". $coordinator_position[$key] ."');";
        $coordinators_check = mysqli_query($connect, $coordinators_query);
    }
}
else {
    $coordinators_check = true;
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if ($event_check && $info_check && $participants_check && $needs_check && $transportation_check && $report_check && $coordinators_check) {
    echo json_encode([
        'success'  => 'done',
        'event_id' => $event_id
    ]);
}
?>