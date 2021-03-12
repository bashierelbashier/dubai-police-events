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
PRIMARY KEY (USER_NO)) CHARACTER SET utf8 ENGINE=InnoDB COLLATE utf8_general_ci";
mysqli_query($connect, $query) or die("");
$full_name = 'الآدمن';
$query = "INSERT INTO T_USERS VALUES (1,'admin','" . md5("admin") . "',True,'" . $full_name . "',1,CURTIME(),'')";
mysqli_query($connect, $query) or die("");



///////////////////////////////////////////////////////////////////////////////////////////////////

$query = "CREATE TABLE T_EVENT(
ID INT(20),
EVENT_TYPE VARCHAR(40),
CLASSIFICATION VARCHAR(1);
EVENT_NAME VARCHAR(60),
ORGANIZER VARCHAR(40),
EVENT_LOCATION VARCHAR(40),
EXPECTED_AUDIENCE INT(8),
POLICE_COUNT INT(8),
EVENT_DATE DATETIME,
EVENT_DAY VARCHAR(10),
VIPS_EXIST BOOLEAN,
DATE_CREATED DATETIME,
CREATOR_ID INT(3),
DATE_MODIFIED DATETIME,
MODIFIER_ID INT(3),
FOREIGN KEY (CREATOR_ID) REFERENCES T_USERS(USER_NO),
FOREIGN KEY (MODIFIER_ID) REFERENCES T_USERS(USER_NO),
PRIMARY KEY (ID)) CHARACTER SET utf8 ENGINE=InnoDB COLLATE utf8_general_ci";
mysqli_query($connect, $query) or die("");

/////////////////////////////////////////////////////////////////////////////////////////////////////


header("location:../index.php");