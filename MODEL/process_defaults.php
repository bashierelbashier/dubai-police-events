<?php

if (isset($_POST['vips_exist'])) {
    $vips_exist = 1;
}
else {
    $vips_exist = 0;
}

if (isset($_POST['other_event'])) {
    $other_event = 1;
}
else {
    $other_event = 0;
}

if (isset($_POST['hotels'])) {
    $hotels = 1;
}
else {
    $hotels = 0;
}

if (isset($_POST['operation_room'])) {
    $operation_room = 1;
}
else {
    $operation_room = 0;
}

if (isset($_POST['police_office'])) {
    $police_office = 1;
}
else {
    $police_office = 0;
}

if (isset($_POST['heliports'])) {
    $heliports = 1;
}
else {
    $heliports = 0;
}

if (isset($_POST['media'])) {
    $media = 1;
}
else {
    $media = 0;
}

if (isset($_POST['operation_room_covering'])) {
    $operation_room_covering = $_POST['operation_room_covering'];
}
else {
    $operation_room_covering = 0;
}

if (isset($_POST['camaeras_recording'])) {
    $camaeras_recording = $_POST['camaeras_recording'];
}
else {
    $camaeras_recording = 0;
}

if (isset($_POST['volunteers'])) {
    $volunteers = $_POST['volunteers'];
}
else {
    $volunteers = 0;
}

if (isset($_POST['volunteers_number'])) {
    $volunteers_number = $_POST['volunteers_number'];
}
else {
    $volunteers_number = 0;
}

if (isset($_POST['security_service'])) {
    $security_service = 1;
}
else {
    $security_service = 0;
}

if (isset($_POST['traffic'])) {
    $traffic = 1;
}
else {
    $traffic = 0;
}

if (isset($_POST['civil_defence'])) {
    $civil_defence = 1;
}
else {
    $civil_defence = 0;
}

if (isset($_POST['criminal_investigations'])) {
    $criminal_investigations = 1;
}
else {
    $criminal_investigations = 0;
}

if (isset($_POST['private_security'])) {
    $private_security = 1;
}
else {
    $private_security = 0;
}

if (isset($_POST['operations'])) {
    $operations = 1;
}
else {
    $operations = 0;
}

if (isset($_POST['forensic_criminology'])) {
    $forensic_criminology = 1;
}
else {
    $forensic_criminology = 0;
}

if (isset($_POST['competent_center'])) {
    $competent_center = 1;
}
else {
    $competent_center = 0;
}

if (isset($_POST['explosives_security'])) {
    $explosives_security = 1;
}
else {
    $explosives_security = 0;
}

if (isset($_POST['personal_security'])) {
    $personal_security = 1;
}
else {
    $personal_security = 0;
}

if (isset($_POST['transportation'])) {
    $transportation = 1;
}
else {
    $transportation = 0;
}

if (isset($_POST['transport_rescue'])) {
    $transport_rescue = 1;
}
else {
    $transport_rescue = 0;
}

if (isset($_POST['security_inspection'])) {
    $security_inspection = 1;
}
else {
    $security_inspection = 0;
}

if (isset($_POST['explosives'])) {
    $explosives = 1;
}
else {
    $explosives = 0;
}

if (isset($_POST['airports_security'])) {
    $airports_security = 1;
}
else {
    $airports_security = 0;
}

if (isset($_POST['ambulance'])) {
    $ambulance = 1;
}
else {
    $ambulance = 0;
}

if (isset($_POST['transportation_bus'])) {
    $transportation_bus = 1;
}
else {
    $transportation_bus = 0;
}

if (isset($_POST['transportation_car'])) {
    $transportation_car = 1;
}
else {
    $transportation_car = 0;
}

if (isset($_POST['transportation_taxi'])) {
    $transportation_taxi = 1;
}
else {
    $transportation_taxi = 0;
}

if (isset($_POST['transportation_metro'])) {
    $transportation_metro = 1;
}
else {
    $transportation_metro = 0;
}

if (isset($_POST['transportation_other'])) {
    $transportation_other = 1;
}
else {
    $transportation_other = 0;
}

if (isset($_POST['emergency_plan'])) {
    $emergency_plan = 1;
}
else {
    $emergency_plan = 0;
}

if (isset($_POST['vip_list'])) {
    $vip_list = 1;
}
else {
    $vip_list = 0;
}

if (isset($_POST['id_cards'])) {
    $id_cards = 1;
}
else {
    $id_cards = 0;
}

if (isset($_POST['invitation_card'])) {
    $invitation_card = 1;
}
else {
    $invitation_card = 0;
}

if (isset($_POST['volunteers_list'])) {
    $volunteers_list = 1;
}
else {
    $volunteers_list = 0;
}

if (isset($_POST['orginzers_list'])) {
    $orginzers_list = 1;
}
else {
    $orginzers_list = 0;
}

if (isset($_POST['security_list'])) {
    $security_list = 1;
}
else {
    $security_list = 0;
}

$correspondence = 1;
$individuals_list = 1;
$participants_plans = 1;
$operation_cost = 1;
$classification_form = 1;
$success_form = 1;