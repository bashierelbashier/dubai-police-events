<?php

include "connect.php";
header('Content-type: application/json; charset=utf-8');

$current_year = date('Y');

$query = "SELECT * FROM T_EVENT";
$result= mysqli_query($connect, $query);

$q1_query = "SELECT COUNT(*) AS count_events, FULL_NAME FROM T_EVENT JOIN T_USERS ON T_EVENT.CREATOR_ID = T_USERS.USER_NO WHERE T_EVENT.DATE_CREATED BETWEEN '". $current_year ."-01-01 00:00:00' AND '". $current_year ."-03-31  00:00:00' GROUP BY CREATOR_ID;";
$q1_result = mysqli_query($connect, $q1_query);
$q1_labels = [];
$q1_stats = [];
if (mysqli_num_rows($q1_result) > 0) {
    while ($row = mysqli_fetch_array($q1_result)) {
        $q1_labels[] = $row['FULL_NAME'];
        $q1_stats[] = $row['count_events'];
    }
}


$q2_query = "SELECT COUNT(*) AS count_events, FULL_NAME FROM T_EVENT JOIN T_USERS ON T_EVENT.CREATOR_ID = T_USERS.USER_NO WHERE T_EVENT.DATE_CREATED BETWEEN '". $current_year ."-04-01 00:00:00' AND '". $current_year ."-06-30  00:00:00' GROUP BY CREATOR_ID;";
$q2_result = mysqli_query($connect, $q2_query);
$q2_labels = [];
$q2_stats = [];
if (mysqli_num_rows($q2_result) > 0) {
    while ($row = mysqli_fetch_array($q2_result)) {
        $q2_labels[] = $row['FULL_NAME'];
        $q2_stats[] = $row['count_events'];
    }
}

$q3_query = "SELECT COUNT(*) AS count_events, FULL_NAME FROM T_EVENT JOIN T_USERS ON T_EVENT.CREATOR_ID = T_USERS.USER_NO WHERE T_EVENT.DATE_CREATED BETWEEN '". $current_year ."-07-01 00:00:00' AND '". $current_year ."-09-30  00:00:00' GROUP BY CREATOR_ID;";
$q3_result = mysqli_query($connect, $q3_query);
$q3_labels = [];
$q3_stats = [];
if (mysqli_num_rows($q3_result) > 0) {
    while ($row = mysqli_fetch_array($q3_result)) {
        $q3_labels[] = $row['FULL_NAME'];
        $q3_stats[] = $row['count_events'];
    }
}

$q4_query = "SELECT COUNT(*) AS count_events, FULL_NAME FROM T_EVENT JOIN T_USERS ON T_EVENT.CREATOR_ID = T_USERS.USER_NO WHERE T_EVENT.DATE_CREATED BETWEEN '". $current_year ."-10-01 00:00:00' AND '". $current_year ."-12-31  00:00:00' GROUP BY CREATOR_ID;";
$q4_result = mysqli_query($connect, $q4_query);
$q4_labels = [];
$q4_stats = [];
if (mysqli_num_rows($q4_result) > 0) {
    while ($row = mysqli_fetch_array($q4_result)) {
        $q4_labels[] = $row['FULL_NAME'];
        $q4_stats[] = $row['count_events'];
    }
}

echo json_encode([
    'q1_labels' => $q1_labels,
    'q1_stats' => $q1_stats,
    'q2_labels' => $q2_labels,
    'q2_stats' => $q2_stats,
    'q3_labels' => $q3_labels,
    'q3_stats' => $q3_stats,
    'q4_labels' => $q4_labels,
    'q4_stats' => $q4_stats,
]);