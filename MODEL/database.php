<?php

include "connect.php";

////////////////////////////////////////////////////////////////////////////////////////////////////////////

$query = "CREATE DATABASE EVENTS CHARACTER SET utf8 COLLATE utf8_general_ci";

mysqli_query($connect, $query) or die("");

mysqli_select_db($connect, "EVENTS") or die("");

////////////////////////////////////////////////////////////////////////////////////////////////////

$query = "CREATE TABLE T_USERS (
USER_NO INT(3),
USER_NAME VARCHAR(40) UNIQUE,
PASSWORD VARCHAR(100),
ACTIVE BOOLEAN,
FULL_NAME VARCHAR(40),
PRIVILEGE_NO INT(1),
DATE_CREATED DATETIME,
IMG_SIGNATURE VARCHAR(100),
RANKING VARCHAR(100),
PRIMARY KEY (USER_NO)) CHARACTER SET utf8 ENGINE=InnoDB COLLATE utf8_general_ci";
mysqli_query($connect, $query) or die("");
$full_name = 'الآدمن';
$query = "INSERT INTO T_USERS VALUES (1,'admin','" . md5("admin") . "',True,'" . $full_name . "',1,CURTIME(),'', '')";
mysqli_query($connect, $query) or die("");

///////////////////////////////////////////////////////////////////////////////////////////////////

$query = "CREATE TABLE T_EVENT (
ID INT(20),
EVENT_TYPE VARCHAR(40),
CLASSIFICATION VARCHAR(1),
EVENT_NAME VARCHAR(60),
ORGANIZER VARCHAR(40),
EVENT_LOCATION VARCHAR(40),
EXPECTED_AUDIENCE INT(8),
POLICE_COUNT INT(8),
EVENT_DATE DATETIME,
EVENT_DAY VARCHAR(10),
DATE_CREATED DATETIME,
CREATOR_ID INT(3),
DATE_MODIFIED DATETIME,
MODIFIER_ID INT(3),
FOREIGN KEY (CREATOR_ID) REFERENCES T_USERS(USER_NO),
FOREIGN KEY (MODIFIER_ID) REFERENCES T_USERS(USER_NO),
PRIMARY KEY (ID)) CHARACTER SET utf8 ENGINE=InnoDB COLLATE utf8_general_ci";
mysqli_query($connect, $query) or die("");
    
/////////////////////////////////////////////////////////////////////////////////////////////////////

$query = "CREATE TABLE T_EVENT_INFO (
ID INT(20) AUTO_INCREMENT,
EVENT_ID INT(20),
VIPS_EXIST BOOLEAN,
OTHER_EVENT BOOLEAN,
HOTELS BOOLEAN,
OPERATION_ROOM BOOLEAN,
POLICE_OFFICE BOOLEAN,
HELIPORTS BOOLEAN,
MEDIA BOOLEAN,
OPERATION_ROOM_LOCATION VARCHAR(100),
OPERATION_ROOM_COVERING BOOLEAN,
CAMERAS_NUMBER INT(8),
CAMERAS_RECORDING BOOLEAN,
SUB_ENTRIES INT(8),
MAIN_ENTRIES INT(8),
VOLUNTEERS BOOLEAN,
VOLUNTEERS_NUMBER INT(8),
OTHER_INFO TEXT,
FOREIGN KEY (EVENT_ID) REFERENCES T_EVENT(ID),
PRIMARY KEY (ID))  CHARACTER SET utf8 ENGINE=InnoDB COLLATE utf8_general_ci";
mysqli_query($connect, $query) or die("");

/////////////////////////////////////////////////////////////////////////////////////////////////////

$query = "CREATE TABLE T_EVENT_HOTELS (
ID INT(20) AUTO_INCREMENT,
EVENT_ID INT(20),
HOTEL_NAME VARCHAR(100),
HOTEL_LOCATION VARCHAR(100),
HOTEL_COORDINATES VARCHAR(50),
FOREIGN KEY (EVENT_ID) REFERENCES T_EVENT(ID),
PRIMARY KEY (ID))  CHARACTER SET utf8 ENGINE=InnoDB COLLATE utf8_general_ci";
mysqli_query($connect, $query) or die("");

/////////////////////////////////////////////////////////////////////////////////////////////////////

$query = "CREATE TABLE T_COORDINATORS (
ID INT(20) AUTO_INCREMENT,
EVENT_ID INT(20),
NAME VARCHAR(100),
REFERENCE VARCHAR(100),
POSITION VARCHAR(100),
FOREIGN KEY (EVENT_ID) REFERENCES T_EVENT(ID),
PRIMARY KEY (ID))  CHARACTER SET utf8 ENGINE=InnoDB COLLATE utf8_general_ci";
mysqli_query($connect, $query) or die("");


/////////////////////////////////////////////////////////////////////////////////////////////////////

$query = "CREATE TABLE T_EVENT_PARTICIPANTS (
ID INT(20) AUTO_INCREMENT,
EVENT_ID INT(20),
SECURITY_SERVICE BOOLEAN,
TRAFFIC BOOLEAN,
CIVIL_DEFENCE BOOLEAN,
CRIMINAL_INVESTIGATIONS BOOLEAN,
PRIVATE_SECURITY BOOLEAN,
OPERATIONS BOOLEAN,
FORENSIC_CRIMINOLOGY BOOLEAN,
COMPETENT_CENTER BOOLEAN,
EXPLOSIVES_SECURITY BOOLEAN,
PERSONAL_SECURITY BOOLEAN,
TRANSPORTATION BOOLEAN,
TRANSPORT_RESCUE BOOLEAN,
SECURITY_INSPECTION BOOLEAN,
EXPLOSIVES BOOLEAN,
AIRPORTS_SECURITY BOOLEAN,
AMBULANCE BOOLEAN,
OTHER_PARTICIPANTS TEXT,
FOREIGN KEY (EVENT_ID) REFERENCES T_EVENT(ID),
PRIMARY KEY (ID))  CHARACTER SET utf8 ENGINE=InnoDB COLLATE utf8_general_ci";
mysqli_query($connect, $query) or die("");

/////////////////////////////////////////////////////////////////////////////////////////////////////

$query = "CREATE TABLE T_EVENT_NEEDS (
ID INT(20) AUTO_INCREMENT,
EVENT_ID INT(20),
INDIVIDUALS INT(8),
PATROLS INT(8),
DEVICES INT(8),
BUSES INT(8),
FEMALE_OFFICERS INT(8),
SECURITY_BLOCKS INT(8),
BIKES_MOTOBIKES INT(8),
OTHER_NEEDS TEXT,
FOREIGN KEY (EVENT_ID) REFERENCES T_EVENT(ID),
PRIMARY KEY (ID))  CHARACTER SET utf8 ENGINE=InnoDB COLLATE utf8_general_ci";
mysqli_query($connect, $query) or die("");

/////////////////////////////////////////////////////////////////////////////////////////////////////

$query = "CREATE TABLE T_EVENT_TRANSPORTATION (
ID INT(20) AUTO_INCREMENT,
EVENT_ID INT(20),
BUS BOOLEAN,
CAR BOOLEAN,
TAXI BOOLEAN,
METRO BOOLEAN,
OTHER BOOLEAN,
FOREIGN KEY (EVENT_ID) REFERENCES T_EVENT(ID),
PRIMARY KEY (ID))  CHARACTER SET utf8 ENGINE=InnoDB COLLATE utf8_general_ci";
mysqli_query($connect, $query) or die("");

/////////////////////////////////////////////////////////////////////////////////////////////////////

$query = "CREATE TABLE  T_EVENT_REPORT (
ID INT(20) AUTO_INCREMENT,
EVENT_ID INT(20),
EMERGENCY_PLAN BOOLEAN,
VIP_LIST BOOLEAN,
ID_CARDS BOOLEAN,
CORRESPONDENCE BOOLEAN,
INDIVIDUALS_LIST BOOLEAN,
INVITATION_CARD BOOLEAN,
VOLUNTEERS_LIST BOOLEAN,
ORGINZERS_LIST BOOLEAN,
SECURITY_LIST BOOLEAN,
PARTICIPANTS_PLANS BOOLEAN,
OPERATION_COST BOOLEAN,
CLASSIFICATION_FORM BOOLEAN,
SUCCESS_FORM BOOLEAN,
REPORT_OTHERS TEXT,
NOTES TEXT,
FOREIGN KEY (EVENT_ID) REFERENCES T_EVENT(ID),
PRIMARY KEY (ID))  CHARACTER SET utf8 ENGINE=InnoDB COLLATE utf8_general_ci";
mysqli_query($connect, $query) or die("");

/////////////////////////////////////////////////////////////////////////////////////////////////////

header("location:../index.php");
