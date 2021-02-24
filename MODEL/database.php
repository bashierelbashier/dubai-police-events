<?php

include "connect.php";

////////////////////////////////////////////////////////////////////////////////////////////////////////////

$query = "CREATE DATABASE ARCHIVE CHARACTER SET utf8 COLLATE utf8_general_ci";

mysqli_query($connect, $query) or die("");

mysqli_select_db($connect, "ARCHIVE") or die("");

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

$query = "CREATE TABLE T_TRANSACTION(
ID INT(20),
LAND_NO VARCHAR(40),
DISTRICT_NO INT(6),
SEC_LAND_NO VARCHAR(40),
TRANSACTION_NO INT(2),
TRANS_DATE DATE,
RENEWAL_TERM INT(1),
PERIOD DOUBLE,
MONTHS_OR_YEARS INT(1),
AREA DOUBLE,
FIRST_PARTY INT(9),
SEC_PARTY INT(9),
ON_BEHALF_NAME VARCHAR(50),
ON_BEHALF_ID_TYPE INT(1),
ON_BEHALF_ID VARCHAR(15),
ON_BEHALF_PHONE VARCHAR(15),
DATE_CREATED DATETIME,
CREATOR_ID INT(3),
DATE_MODIFIED DATETIME,
MODIFIER_ID INT(3),
FOREIGN KEY (CREATOR_ID) REFERENCES T_USERS(USER_NO),
FOREIGN KEY (MODIFIER_ID) REFERENCES T_USERS(USER_NO),
FOREIGN KEY (LAND_NO,DISTRICT_NO) REFERENCES T_LANDS(LAND_NO,DISTRICT_NO),
PRIMARY KEY (ID)) CHARACTER SET utf8 ENGINE=InnoDB COLLATE utf8_general_ci";
mysqli_query($connect, $query) or die("");

/////////////////////////////////////////////////////////////////////////////////////////////////////


header("location:../index.php");
