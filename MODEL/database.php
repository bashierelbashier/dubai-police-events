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
PRIMARY KEY (USER_NO)) CHARACTER SET utf8 ENGINE=InnoDB COLLATE utf8_general_ci";
mysqli_query($connect, $query) or die("");
$full_name = 'الآدمن';
$query = "INSERT INTO T_USERS VALUES (1,'admin','" . md5("admin") . "',True,'" . $full_name . "',1,CURTIME())";
mysqli_query($connect, $query) or die("");

////////////////////////////////////////////////////////////////////////////////////////////////////

$query = "CREATE TABLE T_LAND_TYPES (
TYPE_NO INT(3),
TYPE_NAME VARCHAR(40),
DATE_CREATED DATETIME,
CREATOR_ID INT(3),
DATE_MODIFIED DATETIME,
MODIFIER_ID INT(3),
FOREIGN KEY(CREATOR_ID) REFERENCES T_USERS(USER_NO),
FOREIGN KEY(MODIFIER_ID) REFERENCES T_USERS(USER_NO),
PRIMARY KEY (TYPE_NO)) CHARACTER SET utf8 COLLATE utf8_general_ci";
mysqli_query($connect, $query) or die("");
$query = "INSERT INTO T_LAND_TYPES VALUES (1,'إيجارة',NULL,NULL,NULL,NULL)";
mysqli_query($connect, $query) or die("");

//////////////////////////////////////////////////////////////////////////////////////////////////////

$query = "CREATE TABLE T_CLASSIFICATIONS (
CLASS_NO INT(3),
CLASS_NAME VARCHAR(40),
DATE_CREATED DATETIME,
CREATOR_ID INT(3),
DATE_MODIFIED DATETIME,
MODIFIER_ID INT(3),
FOREIGN KEY(CREATOR_ID) REFERENCES T_USERS(USER_NO),
FOREIGN KEY(MODIFIER_ID) REFERENCES T_USERS(USER_NO),
PRIMARY KEY (CLASS_NO)) CHARACTER SET utf8 ENGINE=InnoDB COLLATE utf8_general_ci";
mysqli_query($connect, $query) or die("");
$query = "INSERT INTO T_CLASSIFICATIONS VALUES (1,'بدون تصنيف',NULL,NULL,NULL,NULL)";
mysqli_query($connect, $query) or die("");
$query = "INSERT INTO T_CLASSIFICATIONS VALUES (2,'ممتاز',NULL,NULL,NULL,NULL)";
mysqli_query($connect, $query) or die("");
$query = "INSERT INTO T_CLASSIFICATIONS VALUES (3,'جيد جدا',NULL,NULL,NULL,NULL)";
mysqli_query($connect, $query) or die("");
$query = "INSERT INTO T_CLASSIFICATIONS VALUES (4,'جيد',NULL,NULL,NULL,NULL)";
mysqli_query($connect, $query) or die("");
$query = "INSERT INTO T_CLASSIFICATIONS VALUES (5,'وسط',NULL,NULL,NULL,NULL)";
mysqli_query($connect, $query) or die("");


///////////////////////////////////////////////////////////////////////////////////////////////////////


$query = "CREATE TABLE T_LOCALES (
LOCALE_NO INT(6),
LOCALE_NAME VARCHAR(40),
DATE_CREATED DATETIME,
CREATOR_ID INT(3),
DATE_MODIFIED DATETIME,
MODIFIER_ID INT(3),
FOREIGN KEY(CREATOR_ID) REFERENCES T_USERS(USER_NO),
FOREIGN KEY(MODIFIER_ID) REFERENCES T_USERS(USER_NO),
PRIMARY KEY (LOCALE_NO)) CHARACTER SET utf8 ENGINE=InnoDB COLLATE utf8_general_ci";
mysqli_query($connect, $query) or die("");
$query = "INSERT INTO T_LOCALES VALUES (1,'شرق النيل',NULL,NULL,NULL,NULL)";
mysqli_query($connect, $query) or die("");
$query = "INSERT INTO T_LOCALES VALUES (2,'بحري',NULL,NULL,NULL,NULL)";
mysqli_query($connect, $query) or die("");


////////////////////////////////////////////////////////////////////////////////////////////////////

$query = "CREATE TABLE T_DISTRICTS (
LOCALE_NO INT(6),
DISTRICT_NO INT(6),
DISTRICT_NAME VARCHAR(40),
DATE_CREATED DATETIME,
CREATOR_ID INT(3),
DATE_MODIFIED DATETIME,
MODIFIER_ID INT(3),
FOREIGN KEY(CREATOR_ID) REFERENCES T_USERS(USER_NO),
FOREIGN KEY(MODIFIER_ID) REFERENCES T_USERS(USER_NO),
FOREIGN KEY(LOCALE_NO) REFERENCES T_LOCALES(LOCALE_NO),
PRIMARY KEY (DISTRICT_NO,LOCALE_NO)) CHARACTER SET utf8 ENGINE=InnoDB COLLATE utf8_general_ci";
mysqli_query($connect, $query) or die("");

$query = "INSERT INTO T_DISTRICTS VALUES (1,1,'الحاج يوسف',NULL,NULL,NULL,NULL)";
mysqli_query($connect, $query) or die("");

//////////////////////////////////////////////////////////////////////////////////////////////////////

$query = "CREATE TABLE T_OWNERS (
OWNER_NO INT(9),
OWNER_NAME VARCHAR(40),
OWNER_TYPE INT(1),
PHONE_NO1 VARCHAR(20),
PHONE_NO2 VARCHAR(20),
IDENTITY_TYPE INT(1),
IDENTITY_NO VARCHAR(20),
NOTES VARCHAR(600),
DATE_CREATED DATETIME,
CREATOR_ID INT(3),
DATE_MODIFIED DATETIME,
MODIFIER_ID INT(3),
FOREIGN KEY(CREATOR_ID) REFERENCES T_USERS(USER_NO),
FOREIGN KEY(MODIFIER_ID) REFERENCES T_USERS(USER_NO),
PRIMARY KEY (OWNER_NO)) CHARACTER SET utf8 ENGINE=InnoDB COLLATE utf8_general_ci";
mysqli_query($connect, $query) or die("");

////////////////////////////////////////////////////////////////////////////////////////////////////

$query = "CREATE TABLE T_LANDS (
LAND_NO VARCHAR(40),
AREA_UNIT INT(2),
AREA DOUBLE,
TYPE_NO INT(3),
CLASS_NO INT(3),
DISTRICT_NO INT(6),
LOCALE_NO INT(6),
OFFICE_NO VARCHAR(20),
CUPBOARD_NO VARCHAR(20),
UNIT_NO VARCHAR(20),
SHELF_NO VARCHAR(20),
BOX_NO VARCHAR(20),
FOLDER_NO VARCHAR(20),
STATUS INT(1),
DATE_CREATED DATETIME,
CREATOR_ID INT(3),
DATE_MODIFIED DATETIME,
MODIFIER_ID INT(3),
FOREIGN KEY(CREATOR_ID) REFERENCES T_USERS(USER_NO),
FOREIGN KEY(TYPE_NO) REFERENCES T_LAND_TYPES(TYPE_NO),
FOREIGN KEY(MODIFIER_ID) REFERENCES T_USERS(USER_NO),
FOREIGN KEY (DISTRICT_NO,LOCALE_NO) REFERENCES T_DISTRICTS(DISTRICT_NO,LOCALE_NO),
FOREIGN KEY (CLASS_NO) REFERENCES T_CLASSIFICATIONS(CLASS_NO),
PRIMARY KEY (LAND_NO,DISTRICT_NO)) CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB";
mysqli_query($connect, $query) or die("");

/////////////////////////////////////////////////////////////////////////////////////////////////////

$query = "CREATE TABLE T_DOCS (
LAND_NO VARCHAR(40),
DISTRICT_NO INT(6),
DOC_FILE VARCHAR(100),
DATE_CREATED DATETIME,
CREATOR_ID INT(3),
FOREIGN KEY(CREATOR_ID) REFERENCES T_USERS(USER_NO),
FOREIGN KEY (LAND_NO,DISTRICT_NO) REFERENCES T_LANDS(LAND_NO,DISTRICT_NO),
PRIMARY KEY (LAND_NO,DISTRICT_NO,DOC_FILE)) CHARACTER SET utf8 ENGINE=InnoDB COLLATE utf8_general_ci";
mysqli_query($connect, $query) or die("");

/////////////////////////////////////////////////////////////////////////////////////////////////////

$query = "CREATE TABLE T_LAND_OWNERS (
LAND_NO VARCHAR(40),
DISTRICT_NO INT(6),
OWNER_NO INT(6),
DATE_CREATED DATETIME,
CREATOR_ID INT(3),
FOREIGN KEY (CREATOR_ID) REFERENCES T_USERS(USER_NO),
FOREIGN KEY (OWNER_NO) REFERENCES T_OWNERS(OWNER_NO),
FOREIGN KEY (LAND_NO,DISTRICT_NO) REFERENCES T_LANDS(LAND_NO,DISTRICT_NO),
PRIMARY KEY (LAND_NO,DISTRICT_NO,OWNER_NO)) CHARACTER SET utf8 ENGINE=InnoDB COLLATE utf8_general_ci";
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


$query = "CREATE TABLE T_BORROW_LAND_FILE (
LAND_NO VARCHAR(40),
DISTRICT_NO INT(6),
BORROWER VARCHAR(50),
MANAGEMENT VARCHAR(50),
PURPOSE VARCHAR(90),
BORROW_DATE DATE,
HANDER VARCHAR(50),
RETURNED BOOLEAN,
RETURN_DATE DATETIME,
FOREIGN KEY (LAND_NO,DISTRICT_NO) REFERENCES T_LANDS(LAND_NO,DISTRICT_NO),
PRIMARY KEY (LAND_NO,DISTRICT_NO,BORROW_DATE)) CHARACTER SET utf8 ENGINE=InnoDB COLLATE utf8_general_ci";
mysqli_query($connect, $query) or die("");

/////////////////////////////////////////////////////////////////////////////////////////////////////

header("location:../index.php");
