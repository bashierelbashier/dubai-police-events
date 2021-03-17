<?php

session_start();
if (!isset($_SESSION['USER_NO'])) {
    header("location:login.php");
}

if ($_SESSION['PRIVILEGE'] == 4 || $_SESSION['PRIVILEGE'] == 5)
    header("location:access_denied.php");

?>

<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>

    <meta charset="utf-8" />
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <title>System</title>
    <script src="../ASSETS/SCANNER/jquery-1.js"></script> <!-- optional -->
    <script src="../ASSETS/SCANNER/jquery-migrate-1.js"></script>
    <link href="../ASSETS/CSS/bootstrap.min.css" rel="stylesheet"> <!-- optional -->
    <link href="../ASSETS/CSS/bootstrap-select.min.css" rel="stylesheet"> <!-- optional -->
    <link href="../ASSETS/CSS/static/css/odoo.css" rel="stylesheet"> <!-- optional -->
    <link href="../ASSETS/CSS/css/font-awesome.min.css" rel="stylesheet"> <!-- optional -->
    <link href="../ASSETS/CSS/sweetalert2.min.css" rel="stylesheet"> <!-- optional -->
    <link href="../ASSETS/CSS/jquery-ui.min.css" rel="stylesheet"> <!-- optional -->
    <script src="../ASSETS/SCANNER/jquery-ui.min.js"></script> <!-- optional -->
    <script src="../ASSETS/SCANNER/jquery-chosen.min.js"></script> <!-- optional -->
    <script src="../ASSETS/SCANNER/bootstrap.min.js"></script> <!-- optional -->
    <script src="../ASSETS/SCANNER/bootstrap-select.min.js"></script> <!-- optional -->
    <script src="../ASSETS/SCANNER/popper.min.js"></script> <!-- optional -->
    <script src="../ASSETS/SCANNER/sweetalert2.min.js"></script> <!-- optional -->
    <script src="../ASSETS/CSS/alertifyjs/alertify.js"></script> <!-- optional -->
    <script src="../ASSETS/SCANNER/moment.min.js"></script> <!-- optional -->
    <link rel="stylesheet" href="../ASSETS/CSS/alertifyjs/css/alertify.rtl.min.css" /> <!-- optional -->
    <link rel="stylesheet" href="../ASSETS/CSS/alertifyjs/css/themes/default.rtl.min.css" /> <!-- optional -->
    <link rel="stylesheet" href="../ASSETS/CSS/mystyle.css">
    <link rel="stylesheet" href="../ASSETS/CSS/btn.css">
    <link rel="stylesheet" href="../ASSETS/CSS/cairo/style.css" type="text/css" media="all" />
    <script src="../ASSETS/SCANNER/scanner.js" type="text/javascript"></script> <!-- required for scanning -->
    <script src="../ASSETS/SCANNER/zoomerang.js"></script>
    <link rel="stylesheet" type="text/css" href="../ASSETS/SCANNER/scanner.css">

</head>

<body>
    <div class="col-xs-2 navbar-fixed-top pull-right" style="background-color:black;min-height: 100%;">

        <ul style="margin-top: 55px;" class="nav nav-pills nav-stacked col-md-12">

            <?php include "navigation.php" ?>
        </ul>

    </div>

    <div class="col-md-12 navbar-fixed-top" style="height:55px;background-color: #1b5e20 ;padding-left: 0px;">
        <a style="cursor:pointer;" class="col-xs-9 pull-right">
            <p class="col-xs-12 pull-right" id="events" style="margin-top:0.5%;color:white;font-size:x-large"><b>
                    الفعاليات
                    <i class="fa fa-arrow-left"></i> فعالية <i class="fa fa-arrow-left"></i> جديدة </b></p>
        </a>

        <div style="position:relative;z-index: 999;">
            <button style="border-width:0px;height:55px;background-color: #1b5e20;"
                class="btn col-xs-3 btn-success dropdown-toggle" data-toggle="dropdown">

                <div>
                    <i style="margin: 5px;" class="fa fa-user-circle fa-lg"></i>
                    <?php echo "  " . $_SESSION['FULL_NAME'] . "  "; ?>
                </div>

            </button>

            <ul class="col-xs-3 dropdown-menu dropdown" style="margin:0px;border-radius:0px;">
                <li style="margin-top: 3px;"><a href="../MODEL/logout.php">
                        <p style="color:#6a6a6a;font-family: 'Droid Arabic Naskh', serif;font-size: medium;color:#1b5e20;"
                            align="center"> <i class="fa fa-lock"></i> تسجيل الخروج </p>
                    </a></li>
            </ul>
        </div>

    </div>


    <div class="col-xs-10 navbar-fixed-top pull-right"
        style="margin-right: 16.7%;height:70px;border-bottom-style: outset;border-bottom-width: 1px;border-bottom-color: lightgray;  background-color: #ffffff;margin-top:55px; ">
        <button id="events_form_submit" type="submit" form="events_form" style="margin-top: 20px;margin-right:5px;"
            class="btn btn-success col-xs-2 pull-right"><i class="fa fa-save"></i> حفظ </button>
        <button id="events_form_submit_and_new" type="submit" form="events_form"
            style="margin-top: 20px;margin-right:5px;" class="btn btn-primary col-xs-3 pull-left"><i
                class="fa fa-save"></i> حفظ و إضافة جديد </button>
        <br />
        <br />
    </div>

    </div>


    <div class="col-xs-10"
        style="min-height:81.5%;margin-top:125px;background-image: url('../ASSETS/form_sheetbg.png');">
        <br />

        <div class="panel panel-default" style="border-radius: 0px;box-shadow: 1px 1px 1px 1px darkgrey;">
            <div class="panel-heading">
                <h1 class="panel-title" align="center"> تفاصيل الفعالية </h1>
            </div>
            <div class="panel-body">

                <form id="events_form" name="events_form" method="POST">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h5 align="center" class="panel-title">
                                بيانات الفعالية الأساسية
                            </h5>
                        </div>
                        <div class="panel-body">
                            <table class="table table-responsive">
                                <br/>
                                <tr>
                                    <td class="col-xs-2 text-center">
                                        <label class="control-label">إسم الفعالية</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input  type="text" name="event_name" id="event_name" class="form-control" placeholder="إسم الفعالية" autocomplete="off" required/>
                                    </td>

                                    <td class="col-xs-2 text-center">
                                        <label class="control-label">نوع الفعالية</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <select required class="form-control" id="event_type" name="event_type">
                                            <option value="" disabled selected>نوع الفعالية</option>
                                            <option value="1">بطولة رياضية </option>
                                            <option value="2">مباراة</option>
                                            <option value="3">سباق</option>
                                            <option value="4">أخرى</option>
                                        </select>
                                    </td>

                                    <td class="col-xs-2 text-center">
                                        <label class="control-label">تصنيف الفعالية</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <select required class="form-control" id="event_classification" name="event_classification">
                                            <option value="" disabled selected>تصنيف الفعالية</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                        </select>
                                    </td>

                                </tr>
                                <tr>
                                    <td class="col-xs-2 text-center">
                                        <label class="control-label">الجهة المنظمة</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input autocomplete="off" id="event_organizer" required type="text" class="form-control" name="event_organizer" placeholder="الجهة المنظمة" />
                                    </td>

                                    <td class="col-xs-2 text-center">
                                        <label class="control-label">موقع الفعالية</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input autocomplete="off" id="event_location" required type="text" class="form-control"
                                            name="event_location" placeholder="موقع الفعالية" />
                                    </td>

                                    <td class="col-xs-2 text-center">
                                        <label class="control-label">تاريخ الفعالية</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input autocomplete="off" required type="text" class="form-control"
                                            name="event_date"  id="event_date"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-xs-2 text-center">
                                        <label>يوم الفعالية</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input type="text" readonly class="form-control"
                                            name="event_day" id="event_day" placeholder="يوم الفعالية"/>
                                    </td>
                                    <td class="col-xs-2 text-center">
                                        <label class="control-label">عدد الحضور المتوقع</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input autocomplete="off" required type="number" class="form-control"
                                            name="expected_audience" id="expected_audience"/>
                                    </td>

                                    <td class="col-xs-2 text-center">
                                        <label class="control-label">عدد الافراد الشرطة</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input autocomplete="off" required type="number" class="form-control"
                                            name="police_count" id="police_count"/>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="panel panel-success">

                        <div class="panel-heading">
                            <h3 align="center" class="panel-title">حضور التنسيق والمعاينة</h3>
                        </div>

                        <div class="panel-body">
                            <button type="button" id="add_coordinator" class="btn btn-info pull-left" style="margin-bottom: 5px;">
                                <i class="fa fa-user-plus"> </i>
                                <span>إضافة</span>
                            </button>
                            <table align="center" id="coordinators_table" class="table table-bordered">
                                <thead>
                                    <tr style="background-color: #0c5460;color:white">
                                        <td></td>
                                        <th class="text-center"> الإسم </th>
                                        <th class="text-center"> الجهة </th>
                                        <th class="text-center"> المنصب </th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h5 align="center" class="panel-title">
                                بيانات أخرى عن الفعالية
                            </h5>
                        </div>
                        <div class="panel-body">
                            <table class="table table-responsive">
                                <tr>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="vips_exist" id="vips_exist" value="1">
                                        <label class="form-check-label" for="vips_exist">شخصيات هامة</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="other_event" id="other_event" value="1">
                                        <label class="form-check-label" for="other_event">فعالية مصاحبة</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="hotels" id="hotels" value="1">
                                        <label class="form-check-label" for="hotels">فنادق إقامة</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="operation_room" id="operation_room" value="1">
                                        <label class="form-check-label" for="operation_room">غرفة عمليات</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="police_office" id="police_office" value="1">
                                        <label class="form-check-label" for="police_office">مكتب للشرطة</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="heliports" id="heliports" value="1">
                                        <label class="form-check-label" for="heliports">مهبط طائرة</label>
                                    </td>
                                    <td class="col-xs-2" colspan="2">
                                        <input class="form-check-input" type="checkbox" name="media" id="media" value="1">
                                        <label class="form-check-label" for="media">جهات إعلامية</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-xs-2 text-center">
                                        <label class="control-label">موقع غرفة العمليات</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input autocomplete="off" id="operation_room_location" type="text" class="form-control" name="operation_room_location" placeholder="موقع غرفة العمليات" />
                                    </td>
                                    <td class="col-xs-2 text-center">
                                        <label class="control-label">هل غرفة العمليات تغطي الحدث:</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="operation_room_covering" id="operation_room_covering_yes" value="1">
                                        <label class="form-check-label" for="operation_room_covering_yes">نعم</label>
                                        <input class="form-check-input" type="checkbox" name="operation_room_covering" id="operation_room_covering_no" value="0">
                                        <label class="form-check-label" for="operation_room_covering_no">لا</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-xs-2 text-center">
                                        <label class="control-label">عدد الكاميرات </label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input autocomplete="off" type="number" class="form-control"
                                            name="cameras_number" id="cameras_number" value="0" min="0"/>
                                    </td>
                                    <td class="col-xs-2 text-center">
                                        <label class="control-label">هل الكاميرات تقوم بعملية التسجيل :</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="camaeras_recording" id="camaeras_recording_yes" value="1">
                                        <label class="form-check-label" for="camaeras_recording_yes">نعم</label>
                                        <input class="form-check-input" type="checkbox" name="camaeras_recording" id="camaeras_recording_no" value="0">
                                        <label class="form-check-label" for="camaeras_recording_no">لا</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-xs-2 text-center">
                                        <label class="control-label">عدد المداخل الفرعية </label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input autocomplete="off" type="number" class="form-control"
                                            name="sub_entries" id="sub_entries" value="0" min="0"/>
                                    </td>
                                    <td class="col-xs-2 text-center">
                                        <label class="control-label">عدد المداخل الرئيسية</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input autocomplete="off" type="number" class="form-control"
                                            name="main_entries" id="main_entries" value="0" min="0"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-xs-2 text-center">
                                        <label class="control-label">أخرى</label>
                                    </td>
                                    <td class="col-xs-2" colspan="3" style="max-width: 520px;">
                                        <textarea name="other_exist" id="other_exist" class="form-control" placeholder="أخرى...." autocomplete="off" style="max-width: 760px; min-width: 243px; max-height: 150px; min-height: 50px;"></textarea>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h5 align="center" class="panel-title">
                                الفنادق المخصصة للمشاركين في الفعالية
                            </h5>
                        </div>
                        <div class="panel-body">
                            <button type="button" id="add_hotel" class="btn btn-info pull-left" style="margin-bottom: 5px;">
                                <i class="fa fa-user-plus"> </i>
                                <span>إضافة</span>
                            </button>
                            <table align="center" id="hotels_table" class="table table-bordered">
                                <thead>
                                    <tr style="background-color: #0c5460;color:white">
                                        <td></td>
                                        <th class="text-center"> إسم الفندق </th>
                                        <th class="text-center"> الموقع </th>
                                        <th class="text-center"> إحداثيات المكان </th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h5 align="center" class="panel-title">
                                المتطوعين
                            </h5>
                        </div>
                        <div class="panel-body">
                            <table class="table table-responsive">
                                <tr>
                                    <td class="col-xs-2 text-center">
                                        <label class="control-label">هل يوجد متطوعين:</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="volunteers" id="volunteers_yes" value="1">
                                        <label class="form-check-label" for="volunteers_yes">نعم</label>
                                        <input class="form-check-input" type="checkbox" name="volunteers" id="volunteers_no" value="0">
                                        <label class="form-check-label" for="volunteers_no">لا</label>
                                    </td>
                                    <td></td>
                                    <td class="col-xs-2 text-center">
                                        <label class="control-label">عدد المتطوعين</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input  type="number" name="volunteers_number" id="volunteers_number" class="form-control" placeholder="عدد المتطوعين" autocomplete="off" value="0" min="0" disabled/>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h5 align="center" class="panel-title">
                                الجهات المشاركة في الفعالية 
                            </h5>
                        </div>
                        <div class="panel-body">
                            <table class="table table-responsive">
                                <tr>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="security_service" id="security_service" value="1">
                                        <label class="form-check-label" for="security_service">جهاز أمن الدولة </label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="traffic" id="traffic" value="1">
                                        <label class="form-check-label" for="traffic">الإدارة العامة للمرور</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="civil_defence" id="civil_defence" value="1">
                                        <label class="form-check-label" for="civil_defence">الإدارة العامة الدفاع المدني</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="criminal_investigations" id="criminal_investigations" value="1">
                                        <label class="form-check-label" for="criminal_investigations">التحريات والمباحث الجنائية</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="private_security" id="private_security" value="1">
                                        <label class="form-check-label" for="private_security">شركات الأمن الخاص</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="operations" id="operations" value="1">
                                        <label class="form-check-label" for="operations">الإدارة العامة للعمليات</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="forensic_criminology" id="forensic_criminology" value="1">
                                        <label class="form-check-label" for="forensic_criminology">الأدلة الجنائية وعلم الجريمة</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="competent_center" id="competent_center" value="1">
                                        <label class="form-check-label" for="competent_center">المركز المختص</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="explosives_security" id="explosives_security" value="1">
                                        <label class="form-check-label" for="explosives_security">إدارة أمن المتفجرات</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="personal_security" id="personal_security" value="1">
                                        <label class="form-check-label" for="personal_security">إدارة امن وحماية الشخصيات</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="transportation" id="transportation" value="1">
                                        <label class="form-check-label" for="transportation">هيئة الطرق والمواصلات</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="transport_rescue" id="transport_rescue" value="1">
                                        <label class="form-check-label" for="transport_rescue">الإدارة العامة للنقل والإنقاذ</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="security_inspection" id="security_inspection" value="1">
                                        <label class="form-check-label" for="security_inspection">إدارة التفتيش الأمني </label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="explosives" id="explosives" value="1">
                                        <label class="form-check-label" for="explosives">إدارة المتفجرات</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="airports_security" id="airports_security" value="1">
                                        <label class="form-check-label" for="airports_security">الإدارة العامة لأمن المطارات</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="ambulance" id="ambulance" value="1">
                                        <label class="form-check-label" for="ambulance">الإسعاف الموحد</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-xs-2 text-center">
                                        <label class="control-label">أخرى</label>
                                    </td>
                                    <td class="col-xs-2" colspan="3" style="max-width: 520px;">
                                        <textarea name="other_participants" id="other_participants" class="form-control" placeholder="أخرى...." autocomplete="off" style="max-width: 760px; min-width: 243px; max-height: 150px; min-height: 50px;"></textarea>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h5 align="center" class="panel-title">
                                احتياجات عملية التأمين
                            </h5>
                        </div>
                        <div class="panel-body">
                            <table class="table table-responsive">
                                <tr>
                                    <td class="col-xs-2 text-center">
                                        <label class="control-label">عدد الافراد</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input autocomplete="off" type="number" class="form-control"
                                            name="individuals" id="individuals" value="0" min="0"/>
                                    </td>
                                    <td class="col-xs-2 text-center">
                                        <label class="control-label">عدد الدوريات الامنية</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input autocomplete="off" type="number" class="form-control"
                                            name="patrols" id="patrols" value="0" min="0"/>
                                    </td>
                                    <td class="col-xs-2 text-center">
                                        <label class="control-label">عدد الاجهزة</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input autocomplete="off" type="number" class="form-control"
                                            name="devices" id="devices" value="0" min="0"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-xs-2 text-center">
                                        <label class="control-label">عدد الباصات</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input autocomplete="off" type="number" class="form-control"
                                            name="buses" id="buses" value="0" min="0"/>
                                    </td>
                                    <td class="col-xs-2 text-center">
                                        <label class="control-label">عدد عناصر الشرطة النسائية</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input autocomplete="off" type="number" class="form-control"
                                            name="female_officers" id="female_officers" value="0" min="0"/>
                                    </td>
                                    <td class="col-xs-2 text-center">
                                        <label class="control-label">عدد الحواجز الأمنية</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input autocomplete="off" type="number" class="form-control"
                                            name="security_blocks" id="security_blocks" value="0" min="0"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-xs-2 text-center">
                                        <label class="control-label">عدد الدراجات الهوائية والنارية</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input autocomplete="off" type="number" class="form-control"
                                            name="bikes_motobikes" id="bikes_motobikes" value="0" min="0"/>
                                    </td>
                                    <td class="col-xs-2 text-center">
                                        <label class="control-label">أخرى</label>
                                    </td>
                                    <td class="col-xs-2" colspan="3" style="max-width: 515px;">
                                        <textarea name="other_needs" id="other_needs" class="form-control" placeholder="أخرى" autocomplete="off" style="max-width: 499px; min-width: 156px; max-height: 150px; min-height: 50px;"></textarea>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h5 align="center" class="panel-title">
                                نوع المواصلات 
                            </h5>
                        </div>
                        <div class="panel-body">
                            <table class="table table-responsive">
                                <tr>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="transportation_bus" id="transportation_bus" value="1">
                                        <label class="form-check-label" for="transportation_bus">باص</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="transportation_car" id="transportation_car" value="1">
                                        <label class="form-check-label" for="transportation_car">سيارة</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="transportation_taxi" id="transportation_taxi" value="1">
                                        <label class="form-check-label" for="transportation_taxi">سيارة اجرة</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="transportation_metro" id="transportation_metro" value="1">
                                        <label class="form-check-label" for="transportation_metro">مترو</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="transportation_other" id="transportation_other" value="1">
                                        <label class="form-check-label" for="transportation_other">أخرى</label>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h5 align="center" class="panel-title">
                                المرفقات المطلوبة في التقرير النهائي 
                            </h5>
                        </div>
                        <div class="panel-body">
                            <table class="table table-responsive">
                                <tr>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="emergency_plan" id="emergency_plan" value="1">
                                        <label class="form-check-label" for="emergency_plan">خطة الطوارئ والاخلاء</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="vip_list" id="vip_list" value="1">
                                        <label class="form-check-label" for="vip_list">أسماء الشخصيات الهامة</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="id_cards" id="id_cards" value="1">
                                        <label class="form-check-label" for="id_cards">البطاقات التعريفية</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="correspondence" id="correspondence" value="1" checked disabled>
                                        <label class="form-check-label" for="correspondence">المراسلات والمخاطبات</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="individuals_list" id="individuals_list" value="1" checked disabled>
                                        <label class="form-check-label" for="individuals_list">كشف الافراد</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="invitation_card" id="invitation_card" value="1">
                                        <label class="form-check-label" for="invitation_card">بطاقة الدعوة</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="volunteers_list" id="volunteers_list" value="1">
                                        <label class="form-check-label" for="volunteers_list">كشف المتطوعين</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="orginzers_list" id="orginzers_list" value="1">
                                        <label class="form-check-label" for="orginzers_list">كشف افراد الجهات المنظمة</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="security_list" id="security_list" value="1">
                                        <label class="form-check-label" for="security_list">كشف عناصر الشركات الامنية</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="participants_plans" id="participants_plans" value="1" checked disabled>
                                        <label class="form-check-label" for="participants_plans">خطط الجهات المشاركة</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="operation_cost" id="operation_cost" value="1" checked disabled>
                                        <label class="form-check-label" for="operation_cost">تكلفة العملية</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="classification_form" id="classification_form" value="1" checked disabled>
                                        <label class="form-check-label" for="classification_form">استمارة تصنيف العملية</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="success_form" id="success_form" value="1" checked disabled>
                                        <label class="form-check-label" for="success_form">استمارة نجاح الفعالية</label>
                                    </td>
                                    <td class="col-xs-2 text-center">
                                        <label class="control-label">أخرى</label>
                                    </td>
                                    <td class="col-xs-2" colspan="3" style="max-width: 309px;">
                                        <textarea name="report_others" id="report_others" class="form-control" placeholder="أخرى" autocomplete="off" style="max-width: 499px; min-width: 160px; max-height: 150px; min-height: 50px;"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-xs-2 text-center">
                                        <label class="control-label">ملاحظات</label>
                                    </td>
                                    <td class="col-xs-2" colspan="3" style="max-width: 520px;">
                                        <textarea  type="text" name="report_notes" id="report_notes" class="form-control" placeholder="ملاحظات" autocomplete="off" style="max-width: 758px; min-width: 243px; max-height: 150px; min-height: 50px;"></textarea>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h5 align="center" class="panel-title">
                                القائم بالتنسيق والمعاينة
                            </h5>
                        </div>
                        <div class="panel-body">
                            <table class="table table-responsive">
                                <tr>
                                    <td class="col-xs-2 text-center">
                                        <label class="control-label">الرتبة</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input  type="text" name="coordination_rank" id="coordination_rank" value="<?php echo $_SESSION['RANK'] ;?>" class="form-control" placeholder="الرتبة" autocomplete="off" readonly/>
                                    </td>
                                    <td class="col-xs-2 text-center">
                                        <label class="control-label">الإسم</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input  type="text" name="coordination_name" id="coordination_name" value="<?php echo $_SESSION['FULL_NAME'] ;?>" class="form-control" placeholder="الإسم" autocomplete="off" readonly/>
                                    </td>
                                    <td class="col-xs-2 text-center">
                                        <label class="control-label">التوقيع</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <a href="../IMAGES/<?php echo $_SESSION['IMG_SIGNATURE']; ?>" class="btn btn-toolbar" style="padding: 0;" target="_blank">عرض</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" style="border-radius: 10px;" id="CoordinationModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 10px;">

                <div class="modal-header">
                    <h4 class="modal-title" align="center"> إضافة أسماء حضور التنسيق والمعاينة </h4>
                </div>
                <div class="modal-body" dir="rtl">
                    <form id="coordinator_form" class="oe_formview">
                        <table class="table table-responsive">
                            <br />
                            <tr>
                                <td class="col-xs-1 text-center">
                                    <label class="control-label">الإسم </label>
                                </td>
                                <td class="col-xs-3" colspan="4">
                                    <input autocomplete="off" required type="text" class="text-center form-control"
                                        name="name" id="coordinator_name" placeholder="الإسم ....." />
                                </td>
                            </tr>
                            <tr>
                                <td class="col-xs-1 text-center">
                                    <label class="control-label">الجهة </label>
                                </td>
                                <td class="col-xs-3" colspan="4">
                                    <input autocomplete="off" required type="text" class="text-center form-control"
                                        name="reference" id="coordinator_reference" placeholder="الجهة ....." />
                                </td>
                            </tr>
                            <tr>
                                <td class="col-xs-1 text-center">
                                    <label class="control-label">المنصب </label>
                                </td>
                                <td class="col-xs-3" colspan="4">
                                    <input autocomplete="off" required type="text" class="text-center form-control"
                                        name="position" id="coordinator_position" placeholder="المنصب ....." />
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-warning pull-left">
                        <i class="fa fa-window-close"></i>
                        <span>إغلاق</span>
                    </button>
                    <button type="submit" form="coordinator_form" class="btn btn-primary pull-left">
                        <i class="fa fa-save"></i>
                        <span>حفظ</span>    
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" style="border-radius: 10px;" id="HotelModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 10px;">

                <div class="modal-header">
                    <h4 class="modal-title" align="center"> إضافة فندق مخصص للمشاركين في الفعالية</h4>
                </div>
                <div class="modal-body" dir="rtl">
                    <form id="hotel_form" class="oe_formview">
                        <table class="table table-responsive">
                            <br />
                            <tr>
                                <td class="col-xs-1 text-center">
                                    <label class="control-label">إسم الفندق </label>
                                </td>
                                <td class="col-xs-3" colspan="4">
                                    <input autocomplete="off" required type="text" class="text-center form-control"
                                        name="hotel_name" id="hotel_name" placeholder="إسم الفندق ....." />
                                </td>
                            </tr>
                            <tr>
                                <td class="col-xs-1 text-center">
                                    <label class="control-label">الموقع </label>
                                </td>
                                <td class="col-xs-3" colspan="4">
                                    <input autocomplete="off" required type="text" class="text-center form-control"
                                        name="hotel_location" id="hotel_location" placeholder="الموقع ....." />
                                </td>
                            </tr>
                            <tr>
                                <td class="col-xs-1 text-center">
                                    <label class="control-label">إحداثيات المكان </label>
                                </td>
                                <td class="col-xs-3" colspan="4">
                                    <input autocomplete="off" required type="text" class="text-center form-control"
                                        name="hotel_coordinates" id="hotel_coordinates" placeholder="إحداثيات المكان ....." />
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-warning pull-left">
                        <i class="fa fa-window-close"></i>
                        <span>إغلاق</span>
                    </button>
                    <button type="submit" form="hotel_form" class="btn btn-primary pull-left">
                        <i class="fa fa-save"></i>
                        <span>حفظ</span>    
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            
            $.datepicker.setDefaults({
                changeYear: true,
                changeMonth: true,
                dateFormat: 'yy-mm-dd'
            });

            var noveou = 0;

            $("#events_form_submit_and_new").click(function() {
                noveou = 1;
            });

            $('#event_date').datepicker();

            $('#event_date').change(function () {
                let day = moment($(this).val()).format('dddd');
                if (day == 'Friday') {
                    $('#event_day').val('الجمعة');
                }
                
                if (day == 'Saturday') {
                    $('#event_day').val('السبت');
                }
                
                if (day == 'Sunday') {
                    $('#event_day').val('الأحد');
                }
                
                if (day == 'Monday') {
                    $('#event_day').val('الأثنين');
                }
                
                if (day == 'Tuesday') {
                    $('#event_day').val('الثلاثاء');
                }
                
                if (day == 'Wednesday') {
                    $('#event_day').val('الأربعاء');
                }
                
                if (day == 'Thursday') {
                    $('#event_day').val('الخميس');
                }
            });

            $("#add_coordinator").click(function() {
                $("#CoordinationModal").modal("show");
            });

            $("#CoordinationModal").on('show.bs.modal', function (e) {
                $('#coordinator_form')[0].reset();
            });

            $('#coordinator_form').submit(function (e) {
                event.preventDefault();
                let html = '<tr>'
                    + '<td class="text-center" style="width: 1%;"><button type="button" class="btn btn-danger remove-coordinator"><i class="fa fa-times"></i></button></td>'
                    + '<td class="col-xs-2"><input type="text" class="form-control" name="coordinator_name[]" value="'+ $('#coordinator_name').val() +'"/></td>'
                    + '<td class="col-xs-2"><input type="text" class="form-control" name="coordinator_reference[]" value="'+ $('#coordinator_reference').val() +'"/></td>'
                    + '<td class="col-xs-2"><input type="text" class="form-control" name="coordinator_position[]" value="'+ $('#coordinator_position').val() +'"/></td>'
                    +'</tr>';
                $('#coordinators_table tbody').append(html);
                $('#coordinator_form')[0].reset();
            });

            $(document).on('click', '.remove-coordinator', function () {
                $(this).parent().parent().remove();
            });

            $("#add_hotel").click(function() {
                $("#HotelModal").modal("show");
            });

            $("#HotelModal").on('show.bs.modal', function (e) {
                $('#hotel_form')[0].reset();
            });

            $('#hotel_form').submit(function (e) {
                event.preventDefault();
                let html = '<tr>'
                    + '<td class="text-center" style="width: 1%;"><button type="button" class="btn btn-danger remove-hotel"><i class="fa fa-times"></i></button></td>'
                    + '<td class="col-xs-2"><input type="text" class="form-control" name="hotel_name[]" value="'+ $('#hotel_name').val() +'"/></td>'
                    + '<td class="col-xs-2"><input type="text" class="form-control" name="hotel_location[]" value="'+ $('#hotel_location').val() +'"/></td>'
                    + '<td class="col-xs-2"><input type="text" class="form-control" name="hotel_coordinates[]" value="'+ $('#hotel_coordinates').val() +'"/></td>'
                    +'</tr>';
                $('#hotels_table tbody').append(html);
                $('#hotel_form')[0].reset();
            });

            $(document).on('click', '.remove-hotel', function () {
                $(this).parent().parent().remove();
            });

            $('#operation_room_covering_yes').change(function () {
                if ($(this).attr('checked') == 'checked') {
                    $('#operation_room_covering_no').attr('checked', false);   
                }
                else {
                    $('#operation_room_covering_no').attr('checked', true);
                }
            });

            $('#operation_room_covering_no').change(function () {
                if ($(this).attr('checked') == 'checked') {
                    $('#operation_room_covering_yes').attr('checked', false);
                }
                else {
                    $('#operation_room_covering_yes').attr('checked', true);
                }
            });

            $('#camaeras_recording_yes').change(function () {
                if ($(this).attr('checked') == 'checked') {
                    $('#camaeras_recording_no').attr('checked', false);   
                }
                else {
                    $('#camaeras_recording_no').attr('checked', true); 
                }
            });

            $('#camaeras_recording_no').change(function () {
                if ($(this).attr('checked') == 'checked') {
                    $('#camaeras_recording_yes').attr('checked', false);
                }
                else {
                    $('#camaeras_recording_yes').attr('checked', true);
                }
            });

            $('#volunteers_yes').change(function () {
                if ($(this).attr('checked') == 'checked') {
                    $('#volunteers_no').attr('checked', false);   
                    $('#volunteers_number').attr('disabled', false);
                }
                else {
                    $('#volunteers_no').attr('checked', true);
                    $('#volunteers_number').attr('disabled', true);
                }
            });

            $('#volunteers_no').change(function () {
                if ($(this).attr('checked') == 'checked') {
                    $('#volunteers_yes').attr('checked', false);
                    $('#volunteers_number').attr('disabled', true);
                }
                else {
                    $('#volunteers_yes').attr('checked', true);
                    $('#volunteers_number').attr('disabled', false);
                }
            });

            $("#events_form").submit(function(e) {
                e.preventDefault();

                $.ajax({
                    url: '../MODEL/insert_event.php',
                    method: 'POST',
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        if (data.success) {
                            swal({
                                title: "تم !",
                                text: "تم حفظ البيانات بنجاح",
                                type: "success",
                                confirmButtonColor: "skyblue",
                                confirmButtonText: "حسنا"
                            }).then(function() {
                                if (noveou == 1) {
                                    $("#events_form")[0].reset();
                                    $('#coordinators_table tbody').html('');
                                    $('#hotels_table tbody').html('');
                                    $('#event_name').focus();
                                }
                                else {
                                    window.location = 'edit_event.php?ID=' + data.event_id;
                                }
                            });

                        }
                        else {
                            swal("لم يتم حفظ البيانات ! الرجاء التحقق من صحتها");
                        }
                    }
                });
            });
            

            /* 
            var change_flag = false;

            $("select").change(function() {
                change_flag = true;
            });

            $("input").change(function() {
                change_flag = true;
            });

            $("#individual").click(function() {
                $("#id_row").show();
            });

            $("#org").click(function() {
                $("#id_row").hide();
                $("#id_type").val(0);
                $("#idno").val('');
            });

            var owners = [];

            $("#owner_form").submit(function(e) {
                e.preventDefault();

                $.ajax({
                    url: '../MODEL/insert_owner.php',
                    method: 'POST',
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function(data) {

                        if (data) {
                            owners.push(data);
                            $.ajax({
                                url: "../MODEL/fetch_new_land_owners.php",
                                method: "POST",
                                data: {
                                    owners: owners
                                },
                                success: function(data) {
                                    $("#owners_table").html(data);
                                    $("#SelectOwnerModal").modal("hide");
                                }
                            });

                            $("#NewOwnerModal").modal("hide");
                            $("#owner_form")[0].reset();
                            $.ajax({
                                url: "../MODEL/modal_fetch_owners.php",
                                method: "POST",
                                data: {},
                                success: function(data) {
                                    $("#modal-owners-data").html(data);
                                }
                            });
                            change_flag = true;

                        } else {
                            swal("لم يتم حفظ البيانات ! الرجاء التحقق من صحتها");
                        }

                    }
                });
            });
            
            $(function() {
                $("#trans_date").datepicker();
            });
            
            $("#register_owner").click(function() {
                $("#NewOwnerModal").modal("show");
                $("#SelectOwnerModal").modal("hide");
            });
        
            $.ajax({
                url: "../MODEL/modal_fetch_owners.php",
                method: "POST",
                data: {},
                success: function(data) {
                    $("#modal-owners-data").html(data);
                }
            });
            
            $("#add_owner").click(function() {
                $("#SelectOwnerModal").modal("show");
            });
        
            $("#owner_search_txt").keyup(function(e) {
        
                var txt = $("#owner_search_txt").val();
        
                $.ajax({
                    url: "../MODEL/modal_fetch_owners.php",
                    method: "POST",
                    data: {
                        txt: txt
                    },
                    success: function(data) {
                        $("#modal-owners-data").html(data);
                    }
                });
            });
            
            $(document).on('click', '.owner-remove', function(e) {
        
                var owner = $(this).attr("id");
        
                var removedIndex = owners.indexOf(owner);
        
                swal({
                    title: "تأكيد",
                    text: "هل تريد حذف هذا السجل",
                    type: "question",
        
                    confirmButtonColor: "red",
                    showCancelButton: true,
                    cancelButtonColor: "green",
                    cancelButtonText: "لا أريد الحذف <i class='fa fa-thumbs-up'></i>",
                    confirmButtonText: "نعم <i class='fa fa-trash'></i>"
                }).then(function(isConfirm) {
                    if (isConfirm) {
        
                        if (removedIndex > -1)
                            owners.splice(removedIndex, 1);
        
                        $.ajax({
                            url: "../MODEL/fetch_new_land_owners.php",
                            method: "POST",
                            data: {
                                owners: owners
                            },
                            success: function(data) {
                                $("#owners_table").html(data);
                                $("#SelectOwnerModal").modal("hide");
                                change_flag = true;
                            }
                        });
                    }
                });
        
            });
        
            $(document).on('click', '.owner-row', function(e) {
        
                var owner = $(this).attr("id");
                var flag = false;
                for (var i = 0; i < owners.length; i++)
                    if (owners[i] == owner)
                        flag = true;
        
                if (flag == false) {
                    owners.push(owner);
                    $.ajax({
                        url: "../MODEL/fetch_new_land_owners.php",
                        method: "POST",
                        data: {
                            owners: owners
                        },
                        success: function(data) {
                            $("#owners_table").html(data);
                            $("#SelectOwnerModal").modal("hide");
                            change_flag = true;
                        }
                    });
                }
            });
        
            function fetchDistricts() {
        
                var locale_no = $("#locale").val();
                $.ajax({
                    url: '../MODEL/fetch_districts.php',
                    method: "POST",
                    data: {
                        locale_no: locale_no
                    },
                    success: function(data) {
                        $("#district").html(data);
                    }
        
                });
            }
        
            $("#locale").change(function() {
                fetchDistricts();
            });
        
            $.ajax({
                url: "../MODEL/fetch_classifications.php",
                method: "POST",
                success: function(data) {
                    $("#classification").html(data);
                }
            });
        
            fetchDistricts();
            */



        });

        alertify.defaults.glossary.title = 'تأكيد';
        alertify.defaults.glossary.ok = 'موافق';
        alertify.defaults.glossary.cancel = 'إلغاء';
        //alertify.alert('هل قمت بمراجعة البيانات والتأكد من صحتها؟');
    </script>
</body>
</html>