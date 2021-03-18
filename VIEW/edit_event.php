<?php

session_start();

if (!isset($_SESSION['USER_NO'])) {
    header("location:login.php");
}


include "../MODEL/connect.php";

$sql = "SELECT * FROM T_EVENT JOIN T_EVENT_INFO ON T_EVENT.ID = T_EVENT_INFO.EVENT_ID JOIN T_EVENT_PARTICIPANTS ON T_EVENT.ID = T_EVENT_PARTICIPANTS.EVENT_ID JOIN T_EVENT_NEEDS ON T_EVENT.ID = T_EVENT_NEEDS.EVENT_ID JOIN T_EVENT_TRANSPORTATION ON T_EVENT.ID = T_EVENT_TRANSPORTATION.EVENT_ID JOIN T_EVENT_REPORT ON T_EVENT.ID = T_EVENT_REPORT.EVENT_ID WHERE T_EVENT.ID = " . $_GET['ID'];
$res = mysqli_query($connect, $sql);
$row = mysqli_fetch_array($res);

if ($row['CREATOR_ID'] != $_SESSION['USER_NO']) {
    header("location:access_denied.php");
}

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
    <link rel="stylesheet" href="../ASSETS/CSS/cairo/style.css" type="text/css" media="all" />

</head>

<style>
.owner-row:hover {
    background-color: #b8daff;
}
</style>

<body>
    <input type="text" hidden id="status" value="<?php echo $row['STATUS']; ?>" />
    <div class="col-xs-2 navbar-fixed-top pull-right" style="background-color:black;min-height: 100%;">
        <ul style="margin-top: 55px;" class="nav nav-pills nav-stacked col-md-12">

            <?php include "navigation.php" ?>

        </ul>
    </div>



    <div class="col-md-12 navbar-fixed-top" style="height:55px;background-color: #1b5e20 ;padding-left: 0px;">
    <a style="cursor:pointer;" class="col-xs-9 pull-right">
            <p class="col-xs-12 pull-right" id="lands" style="margin-top:0.5%;color:white;font-size:x-large"><b> الفعاليات
                    <i class="fa fa-arrow-left"></i> الفعالية <i class="fa fa-arrow-left"></i>
                    <?php echo $row['EVENT_NAME'];  ?> </b></p>
        </a>

        <div style="position:relative;z-index: 999;">
            <button id="user_button" style="border-width:0px;height:55px;background-color: #1b5e20;"
                class="btn col-xs-3 btn-success pull-left dropdown-toggle" data-toggle="dropdown">

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


    <div id="buttons_div" class="col-xs-10 navbar-fixed-top"
        style="margin-right: 16.7%;height:70px;border-bottom-style: outset;border-bottom-width: 1px;border-bottom-color: lightgray;  background-color: #ffffff;margin-top:55px; ">
        <div class="col-xs-2 pull-right"></div>
        <a href="events.php" style="margin-top: 20px;margin-right:5px;" class="btn btn-default col-xs-2 pull-right"><i
                class="fa fa-long-arrow-right"></i> رجوع </a>
        <button type="submit" form="event_form" style="margin-top: 20px;margin-right:5px;"
            class="btn btn-success col-xs-2 pull-right"><i class="fa fa-pencil-square-o"></i> حفظ التعديلات </button>
        <button id="delete_event" style="margin-top: 20px;margin-right:5px;"
            class="btn btn-danger col-xs-2 pull-right"><i class="fa fa-trash-o"></i> حذف </button>
        <a href="../REPORTS/event.php?id=<?php echo $_GET['ID']; ?>" style="margin-top: 20px;margin-right:5px;" class="btn btn-info col-xs-2 pull-right">
            <i class="fa fa-print"></i>
            <span>إستخراج</span>
        </a>
        <!--  <a href="new_transaction.php?land_no=<?php echo $row['LAND_NO'] . '&district_no=' . $row['DISTRICT_NO']; ?>"><button
                id="add_trans" style="margin-top: 20px;margin-right:5px;" class="btn btn-warning col-xs-2 pull-right">
                <i class="fa fa-plus"></i> إضافة معاملة </button> </a> -->
        <br />
        <br />
    </div>

    <input type="text" hidden id="privilege" value="<?php echo $_SESSION['PRIVILEGE']; ?>" />

    <div class="col-xs-10" id="data_div"
        style="min-height:81.5%;margin-top:125px;background-image: url('../ASSETS/form_sheetbg.png');">
        <br />
        <div class="panel panel-default" style="border-radius: 0px;box-shadow: 1px 1px 1px 1px darkgrey;">
            <div class="panel-heading">
                <h1 class="panel-title" align="center"> بيانات الفعالية</h1>
            </div>
            <div class="panel-body">
                <form id="event_form" name="event_form">
                    <input type="hidden" name="event_id" value="<?php echo $_GET['ID']; ?>">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h3 align="center" class="panel-title"> البيانات الأساسية للفعالية</h3>
                        </div>
                        <div class="panel-body">
                            <table class="table table-responsive">
                                <tr>
                                    <td class="col-xs-2 text-center">
                                        <label class="control-label">إسم الفعالية</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input type="text" class="form-control"
                                            value="<?php echo $row['EVENT_NAME']; ?>" name="event_name" id="event_name"
                                            placeholder="إسم الفعالية" />
                                    </td>
                                    <td class="col-xs-2 text-center">
                                        <label class="control-label text-center">نوع الفعالية</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <select required class="form-control" id="event_type" name="event_type">
                                            <option value="0" disabled>نوع الفعالية</option>
                                            <option value="1" <?php echo $row['EVENT_TYPE'] == 1 ? 'selected' : ''; ?>>بطولة رياضية </option>
                                            <option value="2" <?php echo $row['EVENT_TYPE'] == 2 ? 'selected' : ''; ?>>مباراة</option>
                                            <option value="3" <?php echo $row['EVENT_TYPE'] == 3 ? 'selected' : ''; ?>>سباق</option>
                                            <option value="4" <?php echo $row['EVENT_TYPE'] == 4 ? 'selected' : ''; ?>>أخرى</option>
                                        </select>
                                    </td>
                                    <td class="col-xs-2 text-center">
                                        <label class="control-label text-center">تصنيف الفعالية</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <select required class="form-control" id="event_classification" name="event_classification">
                                            <option value="0" disabled>تصنيف الفعالية</option>
                                            <option value="A" <?php echo $row['CLASSIFICATION'] == 'A' ? 'selected' : ''; ?>>A</option>
                                            <option value="B" <?php echo $row['CLASSIFICATION'] == 'B' ? 'selected' : ''; ?>>B</option>
                                            <option value="C" <?php echo $row['CLASSIFICATION'] == 'C' ? 'selected' : ''; ?>>C</option>
                                        </select>
                                    </td>

                                </tr>
                                <tr>
                                    <td class="col-xs-2 text-center">
                                        <label class="control-label text-center">الجهة المنظمة</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input type="text" class="form-control"
                                            value="<?php echo $row['ORGANIZER']; ?>" name="event_organizer" id="event_organizer"
                                            placeholder="الجهة المنظمة" />
                                    </td>
                                    <td class="col-xs-2 text-center">
                                        <label class="control-label text-center">موقع الفعالية</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input type="text" class="form-control" value="<?php echo $row['EVENT_LOCATION']; ?>"
                                            name="event_location" id="event_location" placeholder="موقع الفعالية" />
                                    </td>
                                    <td class="col-xs-2 text-center">
                                        <label>تاريخ الفعالية</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input type="text" class="form-control" value="<?php echo date('Y-m-d', strtotime($row['EVENT_DATE'])); ?>"
                                            name="event_date" id="event_date" placeholder="تاريخ الفعالية" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-xs-2 text-center">
                                        <label>يوم الفعالية</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input type="text" readonly class="form-control" value="<?php echo $row['EVENT_DAY']; ?>"
                                            name="event_day" id="event_day" placeholder="يوم الفعالية"/>
                                    </td>
                                    <td class="col-xs-2 text-center">
                                        <label>عدد الحضور المتوقع</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input type="number" class="form-control" value="<?php echo $row['EXPECTED_AUDIENCE']; ?>"
                                            name="expected_audience" id="expected_audience" placeholder="عدد الحضور المتوقع" />
                                    </td>
                                    <td class="col-xs-2 text-center">
                                        <label>عدد أفراد الشرطة</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input type="number" class="form-control" value="<?php echo $row['POLICE_COUNT']; ?>"
                                            name="police_count" id="police_count" placeholder="عدد أفراد الشرطة" />
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
                            <!-- <div id="owners_table"> -->
                            <button type="button" id="add_coordinator" class="btn btn-info pull-left" style="margin-bottom: 5px;">
                                <i class="fa fa-user-plus"> </i>
                                <span>إضافة</span>
                            </button>
                            <div id="coordinators_table">
                                <table align="center" class="table table-bordered">
                                    <thead>
                                        <tr align="center" style="background-color: #0c5460;color:white">
                                            <td> متسلسل # </td>
                                            <td> الإسم </td>
                                            <td> الجهة </td>
                                            <td> المنصب </td>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
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
                                        <input class="form-check-input" type="checkbox" name="vips_exist" id="vips_exist" <?php echo $row['VIPS_EXIST'] == 1 ? 'checked' : ''; ?> value="1">
                                        <label class="form-check-label" for="vips_exist">شخصيات هامة</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="other_event" id="other_event" <?php echo $row['OTHER_EVENT'] == 1 ? 'checked' : ''; ?> value="1">
                                        <label class="form-check-label" for="other_event">فعالية مصاحبة</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="hotels" id="hotels" <?php echo $row['HOTELS'] == 1 ? 'checked' : ''; ?> value="1">
                                        <label class="form-check-label" for="hotels">فنادق إقامة</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="operation_room" id="operation_room" <?php echo $row['OPERATION_ROOM'] == 1 ? 'checked' : ''; ?> value="1">
                                        <label class="form-check-label" for="operation_room">غرفة عمليات</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="police_office" id="police_office" <?php echo $row['POLICE_OFFICE'] == 1 ? 'checked' : ''; ?> value="1">
                                        <label class="form-check-label" for="police_office">مكتب للشرطة</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="heliports" id="heliports" <?php echo $row['HELIPORTS'] == 1 ? 'checked' : ''; ?> value="1">
                                        <label class="form-check-label" for="heliports">مهبط طائرة</label>
                                    </td>
                                    <td class="col-xs-2" colspan="2">
                                        <input class="form-check-input" type="checkbox" name="media" id="media" <?php echo $row['MEDIA'] == 1 ? 'checked' : ''; ?> value="1">
                                        <label class="form-check-label" for="media">جهات إعلامية</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-xs-2 text-center">
                                        <label class="control-label">موقع غرفة العمليات</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input autocomplete="off" id="operation_room_location" type="text" class="form-control" name="operation_room_location" placeholder="موقع غرفة العمليات" value="<?php echo $row['OPERATION_ROOM_LOCATION'] ?>"/>
                                    </td>
                                    <td class="col-xs-2 text-center">
                                        <label class="control-label">هل غرفة العمليات تغطي الحدث:</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="operation_room_covering" id="operation_room_covering_yes" <?php echo $row['OPERATION_ROOM_COVERING'] == 1 ? 'checked' : ''; ?> value="1">
                                        <label class="form-check-label" for="operation_room_covering_yes">نعم</label>
                                        <input class="form-check-input" type="checkbox" name="operation_room_covering" id="operation_room_covering_no" <?php echo $row['OPERATION_ROOM_COVERING'] == 0 ? 'checked' : ''; ?> value="0">
                                        <label class="form-check-label" for="operation_room_covering_no">لا</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-xs-2 text-center">
                                        <label class="control-label">عدد الكاميرات </label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input autocomplete="off" type="number" class="form-control"
                                            name="cameras_number" id="cameras_number" min="0" value="<?php echo $row['CAMERAS_NUMBER']; ?>"/>
                                    </td>
                                    <td class="col-xs-2 text-center">
                                        <label class="control-label">هل الكاميرات تقوم بعملية التسجيل :</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="camaeras_recording" id="camaeras_recording_yes" <?php echo $row['CAMERAS_RECORDING'] == 1 ? 'checked' : ''; ?> value="1">
                                        <label class="form-check-label" for="camaeras_recording_yes">نعم</label>
                                        <input class="form-check-input" type="checkbox" name="camaeras_recording" id="camaeras_recording_no" <?php echo $row['CAMERAS_RECORDING'] == 0 ? 'checked' : ''; ?> value="0">
                                        <label class="form-check-label" for="camaeras_recording_no">لا</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-xs-2 text-center">
                                        <label class="control-label">عدد المداخل الفرعية </label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input autocomplete="off" type="number" class="form-control"
                                            name="sub_entries" id="sub_entries" min="0" value="<?php echo $row['SUB_ENTRIES'] ?>"/>
                                    </td>
                                    <td class="col-xs-2 text-center">
                                        <label class="control-label">عدد المداخل الرئيسية</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input autocomplete="off" type="number" class="form-control"
                                            name="main_entries" id="main_entries" min="0" value="<?php echo $row['MAIN_ENTRIES'] ?>"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-xs-2 text-center">
                                        <label class="control-label">أخرى</label>
                                    </td>
                                    <td class="col-xs-2" colspan="3" style="max-width: 520px;">
                                        <textarea name="other_exist" id="other_exist" class="form-control" placeholder="أخرى...." autocomplete="off" style="max-width: 760px; min-width: 243px; max-height: 150px; min-height: 50px;"><?php echo $row['OTHER_INFO'] ?></textarea>
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
                                        <input class="form-check-input" type="checkbox" name="volunteers" id="volunteers_yes" <?php echo $row['VOLUNTEERS'] == 1 ? 'checked' : ''; ?> value="1">
                                        <label class="form-check-label" for="volunteers_yes">نعم</label>
                                        <input class="form-check-input" type="checkbox" name="volunteers" id="volunteers_no" <?php echo $row['VOLUNTEERS'] == 0 ? 'checked' : ''; ?> value="0">
                                        <label class="form-check-label" for="volunteers_no">لا</label>
                                    </td>
                                    <td></td>
                                    <td class="col-xs-2 text-center">
                                        <label class="control-label">عدد المتطوعين</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input  type="number" name="volunteers_number" id="volunteers_number" class="form-control" placeholder="عدد المتطوعين" disabled autocomplete="off" min="0" value="<?php echo $row['VOLUNTEERS_NUMBER']; ?>"/>
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
                                        <input class="form-check-input" type="checkbox" name="security_service" id="security_service" <?php echo $row['SECURITY_SERVICE'] == 1 ? 'checked' : ''; ?> value="1">
                                        <label class="form-check-label" for="security_service">جهاز أمن الدولة </label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="traffic" id="traffic" <?php echo $row['TRAFFIC'] == 1 ? 'checked' : ''; ?> value="1">
                                        <label class="form-check-label" for="traffic">الإدارة العامة للمرور</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="civil_defence" id="civil_defence" <?php echo $row['CIVIL_DEFENCE'] == 1 ? 'checked' : ''; ?> value="1">
                                        <label class="form-check-label" for="civil_defence">الإدارة العامة الدفاع المدني</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="criminal_investigations" id="criminal_investigations" <?php echo $row['CRIMINAL_INVESTIGATIONS'] == 1 ? 'checked' : ''; ?> value="1">
                                        <label class="form-check-label" for="criminal_investigations">التحريات والمباحث الجنائية</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="private_security" id="private_security" <?php echo $row['PRIVATE_SECURITY'] == 1 ? 'checked' : ''; ?> value="1">
                                        <label class="form-check-label" for="private_security">شركات الأمن الخاص</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="operations" id="operations" <?php echo $row['OPERATIONS'] == 1 ? 'checked' : ''; ?> value="1">
                                        <label class="form-check-label" for="operations">الإدارة العامة للعمليات</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="forensic_criminology" id="forensic_criminology" <?php echo $row['FORENSIC_CRIMINOLOGY'] == 1 ? 'checked' : ''; ?> value="1">
                                        <label class="form-check-label" for="forensic_criminology">الأدلة الجنائية وعلم الجريمة</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="competent_center" id="competent_center" <?php echo $row['COMPETENT_CENTER'] == 1 ? 'checked' : ''; ?> value="1">
                                        <label class="form-check-label" for="competent_center">المركز المختص</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="explosives_security" id="explosives_security" <?php echo $row['EXPLOSIVES_SECURITY'] == 1 ? 'checked' : ''; ?> value="1">
                                        <label class="form-check-label" for="explosives_security">إدارة أمن المتفجرات</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="personal_security" id="personal_security" <?php echo $row['PERSONAL_SECURITY'] == 1 ? 'checked' : ''; ?> value="1">
                                        <label class="form-check-label" for="personal_security">إدارة امن وحماية الشخصيات</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="transportation" id="transportation" <?php echo $row['TRANSPORTATION'] == 1 ? 'checked' : ''; ?> value="1">
                                        <label class="form-check-label" for="transportation">هيئة الطرق والمواصلات</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="transport_rescue" id="transport_rescue" <?php echo $row['TRANSPORT_RESCUE'] == 1 ? 'checked' : ''; ?>   value="1">
                                        <label class="form-check-label" for="transport_rescue">الإدارة العامة للنقل والإنقاذ</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="security_inspection" id="security_inspection" <?php echo $row['SECURITY_INSPECTION'] == 1 ? 'checked' : ''; ?> value="1">
                                        <label class="form-check-label" for="security_inspection">إدارة التفتيش الأمني </label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="explosives" id="explosives" <?php echo $row['EXPLOSIVES'] == 1 ? 'checked' : ''; ?> value="1">
                                        <label class="form-check-label" for="explosives">إدارة المتفجرات</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="airports_security" id="airports_security" <?php echo $row['AIRPORTS_SECURITY'] == 1 ? 'checked' : ''; ?> value="1">
                                        <label class="form-check-label" for="airports_security">الإدارة العامة لأمن المطارات</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="ambulance" id="ambulance" <?php echo $row['AMBULANCE'] == 1 ? 'checked' : ''; ?> value="1">
                                        <label class="form-check-label" for="ambulance">الإسعاف الموحد</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-xs-2 text-center">
                                        <label class="control-label">أخرى</label>
                                    </td>
                                    <td class="col-xs-2" colspan="3" style="max-width: 520px;">
                                        <textarea name="other_participants" id="other_participants" class="form-control" placeholder="أخرى...." autocomplete="off" style="max-width: 760px; min-width: 243px; max-height: 150px; min-height: 50px;"><?php echo $row['OTHER_PARTICIPANTS'] ?></textarea>
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
                                            name="individuals" id="individuals" min="0" value="<?php echo $row['INDIVIDUALS']; ?>"/>
                                    </td>
                                    <td class="col-xs-2 text-center">
                                        <label class="control-label">عدد الدوريات الامنية</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input autocomplete="off" type="number" class="form-control"
                                            name="patrols" id="patrols" min="0" value="<?php echo $row['PATROLS']; ?>"/>
                                    </td>
                                    <td class="col-xs-2 text-center">
                                        <label class="control-label">عدد الاجهزة</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input autocomplete="off" type="number" class="form-control"
                                            name="devices" id="devices" min="0" value="<?php echo $row['DEVICES']; ?>"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-xs-2 text-center">
                                        <label class="control-label">عدد الباصات</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input autocomplete="off" type="number" class="form-control"
                                            name="buses" id="buses" min="0" value="<?php echo $row['BUSES']; ?>"/>
                                    </td>
                                    <td class="col-xs-2 text-center">
                                        <label class="control-label">عدد عناصر الشرطة النسائية</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input autocomplete="off" type="number" class="form-control"
                                            name="female_officers" id="female_officers" min="0" value="<?php echo $row['FEMALE_OFFICERS']; ?>"/>
                                    </td>
                                    <td class="col-xs-2 text-center">
                                        <label class="control-label">عدد الحواجز الأمنية</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input autocomplete="off" type="number" class="form-control"
                                            name="security_blocks" id="security_blocks" min="0" value="<?php echo $row['SECURITY_BLOCKS']; ?>"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-xs-2 text-center">
                                        <label class="control-label">عدد الدراجات الهوائية والنارية</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input autocomplete="off" type="number" class="form-control"
                                            name="bikes_motobikes" id="bikes_motobikes" min="0" value="<?php echo $row['BIKES_MOTOBIKES']; ?>"/>
                                    </td>
                                    <td class="col-xs-2 text-center">
                                        <label class="control-label">أخرى</label>
                                    </td>
                                    <td class="col-xs-2" colspan="3" style="max-width: 515px;">
                                        <textarea name="other_needs" id="other_needs" class="form-control" placeholder="أخرى" autocomplete="off" style="max-width: 499px; min-width: 156px; max-height: 150px; min-height: 50px;"><?php echo $row['OTHER_NEEDS'] ?></textarea>
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
                                        <input class="form-check-input" type="checkbox" name="transportation_bus" id="transportation_bus" <?php echo $row['BUS'] == 1 ? 'checked' : ''; ?> value="1">
                                        <label class="form-check-label" for="transportation_bus">باص</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="transportation_car" id="transportation_car" <?php echo $row['CAR'] == 1 ? 'checked' : ''; ?> value="1">
                                        <label class="form-check-label" for="transportation_car">سيارة</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="transportation_taxi" id="transportation_taxi" <?php echo $row['TAXI'] == 1 ? 'checked' : ''; ?> value="1">
                                        <label class="form-check-label" for="transportation_taxi">سيارة اجرة</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="transportation_metro" id="transportation_metro" <?php echo $row['METRO'] == 1 ? 'checked' : ''; ?> value="1">
                                        <label class="form-check-label" for="transportation_metro">مترو</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="transportation_other" id="transportation_other" <?php echo $row['OTHER'] == 1 ? 'checked' : ''; ?> value="1">
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
                                        <input class="form-check-input" type="checkbox" name="emergency_plan" id="emergency_plan" <?php echo $row['EMERGENCY_PLAN'] == 1 ? 'checked' : ''; ?> value="1">
                                        <label class="form-check-label" for="emergency_plan">خطة الطوارئ والاخلاء</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="vip_list" id="vip_list" <?php echo $row['VIP_LIST'] == 1 ? 'checked' : ''; ?> value="1">
                                        <label class="form-check-label" for="vip_list">أسماء الشخصيات الهامة</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="id_cards" id="id_cards" <?php echo $row['ID_CARDS'] == 1 ? 'checked' : ''; ?> value="1">
                                        <label class="form-check-label" for="id_cards">البطاقات التعريفية</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="correspondence" id="correspondence" <?php echo $row['CORRESPONDENCE'] == 1 ? 'checked' : ''; ?> value="1" checked disabled>
                                        <label class="form-check-label" for="correspondence">المراسلات والمخاطبات</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="individuals_list" id="individuals_list" <?php echo $row['INDIVIDUALS_LIST'] == 1 ? 'checked' : ''; ?> value="1" checked disabled>
                                        <label class="form-check-label" for="individuals_list">كشف الافراد</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="invitation_card" id="invitation_card" <?php echo $row['INVITATION_CARD'] == 1 ? 'checked' : ''; ?> value="1">
                                        <label class="form-check-label" for="invitation_card">بطاقة الدعوة</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="volunteers_list" id="volunteers_list" <?php echo $row['VOLUNTEERS_LIST'] == 1 ? 'checked' : ''; ?> value="1">
                                        <label class="form-check-label" for="volunteers_list">كشف المتطوعين</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="orginzers_list" id="orginzers_list" <?php echo $row['ORGINZERS_LIST'] == 1 ? 'checked' : ''; ?> value="1">
                                        <label class="form-check-label" for="orginzers_list">كشف افراد الجهات المنظمة</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="security_list" id="security_list" <?php echo $row['SECURITY_LIST'] == 1 ? 'checked' : ''; ?> value="1">
                                        <label class="form-check-label" for="security_list">كشف عناصر الشركات الامنية</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="participants_plans" id="participants_plans" <?php echo $row['PARTICIPANTS_PLANS'] == 1 ? 'checked' : ''; ?> value="1" checked disabled>
                                        <label class="form-check-label" for="participants_plans">خطط الجهات المشاركة</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="operation_cost" id="operation_cost" <?php echo $row['OPERATION_COST'] == 1 ? 'checked' : ''; ?> value="1" checked disabled>
                                        <label class="form-check-label" for="operation_cost">تكلفة العملية</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="classification_form" id="classification_form" <?php echo $row['CLASSIFICATION_FORM'] == 1 ? 'checked' : ''; ?> value="1" checked disabled>
                                        <label class="form-check-label" for="classification_form">استمارة تصنيف العملية</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-xs-2">
                                        <input class="form-check-input" type="checkbox" name="success_form" id="success_form" <?php echo $row['SUCCESS_FORM'] == 1 ? 'checked' : ''; ?> value="1" checked disabled>
                                        <label class="form-check-label" for="success_form">استمارة نجاح الفعالية</label>
                                    </td>
                                    <td class="col-xs-2 text-center">
                                        <label class="control-label">أخرى</label>
                                    </td>
                                    <td class="col-xs-2" colspan="3" style="max-width: 309px;">
                                        <textarea name="report_others" id="report_others" class="form-control" placeholder="أخرى" autocomplete="off" style="max-width: 499px; min-width: 160px; max-height: 150px; min-height: 50px;"><?php echo $row['REPORT_OTHERS'] ?></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-xs-2 text-center">
                                        <label class="control-label">ملاحظات</label>
                                    </td>
                                    <td class="col-xs-2" colspan="3" style="max-width: 520px;">
                                        <textarea  type="text" name="report_notes" id="report_notes" class="form-control" placeholder="ملاحظات" autocomplete="off" style="max-width: 758px; min-width: 243px; max-height: 150px; min-height: 50px;"><?php echo $row['NOTES'] ?></textarea>
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
                    <!-- <div class="panel panel-success">
                        <div class="panel-heading">
                            <h5 align="center" class="panel-title">
                                بيانات مكان الإحتفاظ بملف قطعة الأرض
                            </h5>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped">
                                <tr>
                                    <td>
                                        <label> المكتب </label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" value="<?php echo $row['OFFICE_NO']; ?>"
                                            id="office_no" name="office_no" />
                                    </td>
                                    <td>
                                        <label> الدولاب </label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control"
                                            value="<?php echo $row['CUPBOARD_NO']; ?>" id="cupboard_no"
                                            name="cupboard_no" />
                                    </td>
                                    <td>
                                        <label> الوحدة </label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" value="<?php echo $row['UNIT_NO']; ?>"
                                            id="unit_no" name="unit_no" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label> الرف </label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" value="<?php echo $row['SHELF_NO']; ?>"
                                            id="shelf_no" name="shelf_no" />
                                    </td>
                                    <td>
                                        <label> الصندوق </label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="box_no"
                                            value="<?php echo $row['BOX_NO']; ?>" name="box_no" />
                                    </td>
                                    <td>
                                        <label> المجلد </label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="folder_no"
                                            value="<?php echo $row['FOLDER_NO']; ?>" name="folder_no" />
                                    </td>
                                </tr>
                                <div class="FileStatusDiv">
                                    <?php
                                    echo '<tr>
                                <td colspan="3">
                                    <label style="font-size:x-large;color: #0d47a1"> هل الملف موجود في مكانه المخصص له ؟ </label>
                                </td>
                                <td>';
                                    if ($land_file_exist == TRUE)
                                        echo '<label style="font-size:x-large;color:green" id="FileExsists"><i class="fa fa-check"></i> موجود </label>';
                                    else if ($land_file_exist == FALSE)
                                        echo '<label style="font-size:x-large;color:red" id="FileMissing"><i class="fa fa-close"></i> غير موجود </label>';

                                    echo '</td>
                                <td colspan="2">';
                                    if ($_SESSION['PRIVILEGE'] == 1 || $_SESSION['PRIVILEGE'] == 5)
                                        if ($land_file_exist == TRUE)
                                            echo '<button type="button" class="btn btn-default" id="borrow" > <i class="fa fa-share-square"></i> تسليف الملف </button>';
                                        else if ($land_file_exist == FALSE)
                                            echo '<button type="button" class="btn btn-primary" id="receive" > <i class="fa fa-hand-grab-o"></i> إسترجاع الملف </button>';

                                    echo '</td>
                                </tr>';

                                    if ($land_file_exist == FALSE) {
                                        $h = mysqli_fetch_array($r);
                                        echo '<tr>
                                    <td><label>مستلف الملف</label></td><td>' . $h['BORROWER'] . '</td>
                                    <td><label>الإدارة</label></td><td>' . $h['MANAGEMENT'] . '</td>
                                    <td><label>غرض الإستلاف</label></td><td>' . $h['PURPOSE'] . '</td>
                                    </tr><tr>
                                    <td><label>تاريخ الإستلاف</label></td><td>' . $h['BORROW_DATE'] . '</td>
                                    <td><label>المسلف</label></td><td>' . $h['HANDER'] . '</td>
                                    </tr>';
                                    }

                                    ?>
                                </div>
                            </table>
                        </div>
                    </div> -->

                    <!-- <div class="panel panel-success">
                        <div class="panel-heading">
                            <h3 align="center" class="panel-title">بيانات مالكي قطعة الأرض</h3>
                        </div>
                        <div class="panel-body">
                            <div id="owners_table">
                                <table align="center" class="table table-bordered">
                                    <tr align="center" style="background-color: #0c5460;color:white">
                                        <td> متسلسل # </td>
                                        <td> إسم المالك </td>
                                        <td> نوع المالك </td>
                                        <td> رقم الهاتف 1 </td>
                                        <td> رقم الهاتف 2 </td>
                                        <td></td>
                                    </tr>

                                    <?php

                                    $oquery = "SELECT * FROM T_LAND_OWNERS JOIN
                                T_OWNERS USING (OWNER_NO) WHERE LAND_NO='" . $_GET['LAND_NO'] . "' AND DISTRICT_NO = " . $_GET['DISTRICT_NO'];
                                    $ores = mysqli_query($connect, $oquery);
                                    $count = 1;
                                    $output = '';
                                    $select = '';


                                    while ($orow = mysqli_fetch_array($ores)) {

                                        if ($orow['OWNER_TYPE'] == 1)
                                            $orow['OWNER_TYPE'] = ' فرد ';
                                        else if ($orow['OWNER_TYPE'] == 2)
                                            $orow['OWNER_TYPE'] = ' مؤسسة ';


                                        $output .= '<tr align="center"><td>' . $count++ . '</td><td>' . $orow['OWNER_NAME'] . '</td>
                                    <td> ' . $orow['OWNER_TYPE'] . '</td>
                                    <td>' . $orow['PHONE_NO1'] . '</td><td>' . $orow['PHONE_NO2'] . '</td>
                                    <td><button id="' . $orow['OWNER_NO'] . '" type="button" class="btn owner-remove btn-danger"> <i class="fa fa-remove"></i> حذف </button></td></tr>';


                                        $select .= "<option value='" . $orow['OWNER_NO'] . "'>" . $orow['OWNER_NO'] . "</option>";
                                    }

                                    echo $output;

                                    ?>
                                </table>

                                <select id="land_owners_list" class="hidden">
                                    <?php
                                    echo $select;
                                    ?>
                                </select>
                            </div>

                            <button type="button" class="btn btn-primary" id="add_owner">
                                <i class="fa fa-user-plus"></i> إختيار مالك
                            </button>

                            <button type="button" id="register_owner" class="btn btn-info pull-left">
                                <i class="fa fa-user-plus"> </i> تسجيل بيانات جديد
                            </button>
                        </div>
                    </div> -->
                    
                    <!-- <div class="col-md-12" style="margin-top:20px;margin-bottom:30px;">

                        <h2 class="col-md-6 pull-right" style="margin-top: 70px;color:brown;font-size:x-large">
                            إستعراض نسخة من ملف قطعة الأرض <i class="fa fa-hand-o-left"></i>
                        </h2>
                        <a>
                            <a
                                href="../REPORTS/land_file.php?land_no=<?php echo $_GET['LAND_NO'] . '&district_no=' . $_GET['DISTRICT_NO']; ?>"><img
                                    height="150" src="../ASSETS/folder_icon.png" /></a>
                        </a>

                    </div> -->
                    <input type="text" hidden value="<?php echo $row['DISTRICT_NO']; ?>" id="district_no"
                        name="district_no" />
                </form>
            </div>

            <!-- <div class="panel-footer">
                <div class="col-md-6 pull-right">

                    تم الإنشاء بواسطة :
                    <?php
                    $creator =  $row['CREATED_BY'];
                    $q = "SELECT FULL_NAME FROM T_USERS WHERE USER_NO=" . $creator;
                    $r = mysqli_query($connect, $q);
                    $w = mysqli_fetch_array($r);
                    echo $w['FULL_NAME'];
                    ?>
                    بتاريخ :
                    <?php echo $row['CREATION_DATE']; ?>
                </div>

                <div>

                    <?php

                    $modifier =  $row['MODIFIED_BY'];
                    if ($modifier) {
                        $q = "SELECT FULL_NAME FROM T_USERS WHERE USER_NO=" . $modifier;
                        $r = mysqli_query($connect, $q);
                        $w = mysqli_fetch_array($r);
                        if ($row['MOD_DATE'] != '') {
                            echo "آخر تعديل قام به : ";
                            echo $w['FULL_NAME'];
                            echo " بتاريخ : ";
                            echo $row['MOD_DATE'];
                        } else {
                            echo " لم يتم تعديل بيانات القطعة أعلاه من قبل ";
                        }
                    } else {
                        echo " لم يتم تعديل بيانات القطعة أعلاه من قبل ";
                    }

                    ?>

                </div>

            </div> -->
    <!-- <input type="text" hidden value="<?php echo $row['CLASS_NO']; ?>" id="class_no" />
    <input type="text" hidden value="<?php echo $row['LOCALE_NO']; ?>" id="locale_no" />
    <input type="text" hidden value="<?php echo $row['TYPE_NO']; ?>" id="type_no" />
    <input type="text" hidden value="<?php echo $row['AREA_UNIT']; ?>" id="measure_unit_no" /> -->




    <!-- <div class="modal fade" style="border-radius: 10px;" id="SelectOwnerModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 10px;">

                <div class="modal-header">
                    <h6 class="modal-title" align="center"> إضافة مالك لقطعة الأرض </h6>
                    <br />
                </div>

                <div class="modal-body" dir="rtl">
                    <div>
                        <table class="table table-bordered">
                            <tr>
                                <td colspan="3">
                                    <div class="input-group col-xs-12">
                                        <span class="input-group-addon"
                                            style="background-color:white;border-radius: 0px;border-width:0px;">
                                            <i class="fa fa-filter"></i>
                                        </span>
                                        <input type="search" id="owner_search_txt" class="form-control"
                                            placeholder="الإسم أو رقم إثبات الشخصية ..." />
                                    </div>
                                </td>
                            </tr>
                            <tr align="center" style="background-color: #0c5460;color:white">
                                <td width="15%"> متسلسل # </td>
                                <td width="45%"> إسم المالك </td>
                                <td width="40%"> نوع المالك </td>
                            </tr>
                        </table>
                    </div>
                    <div id="modal-owners-data" style="overflow-x:scroll;height:300px;">

                    </div>
                </div>

                <div class="modal-footer">

                    <button data-dismiss="modal" class="btn btn-warning pull-left"> <i class="fa fa-window-close"></i>
                        إغلاق </button>
                </div>
            </div>
        </div>
    </div> -->

    <!-- <div class="modal fade" style="border-radius: 10px;" id="BorrowModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 10px;">

                <div class="modal-header">
                    <h4 class="modal-title" align="center"> تسليف ملف قطعة الأرض </h4>
                </div>
                <div class="modal-body" dir="rtl">
                    <form id="BorrowForm">

                        <input hidden value="<?php echo $_GET['LAND_NO']; ?>" name="b_land_no" class="borrow-input"
                            id="b_land_no" />

                        <input value="<?php echo $_GET['DISTRICT_NO']; ?>" name="b_district" class="borrow-input"
                            id="b_district" hidden />

                        <table class="table table-responsive">

                            <tr>
                                <td>
                                    <label>إسم المستلف</label>
                                </td>
                                <td>
                                    <input required type="text" class="borrow-input form-control" id="borrower"
                                        name="borrower" />
                                </td>
                                <td>
                                    <label>إدارة المستلف</label>
                                </td>
                                <td>
                                    <input required type="text" class="borrow-input form-control" id="management"
                                        name="management" />
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <label>غرض الإستلاف</label>
                                </td>
                                <td>
                                    <input required type="text" class="borrow-input form-control" id="purpose"
                                        name="purpose" />
                                </td>
                                <td>
                                    <label>تاريخ الإستلاف</label>
                                </td>
                                <td>
                                    <input required type="text" class="borrow-input form-control" id="borrow_date"
                                        name="borrow_date" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>مُسِّلف الملف</label>
                                </td>
                                <td>
                                    <input required type="text" value="<?php echo $_SESSION['FULL_NAME']; ?>"
                                        class="borrow-input form-control" id="hander" name="hander" />
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn borrow-input btn-warning pull-left"> <i
                            class="fa fa-window-close"></i> إغلاق </button>
                    <button type="submit" form="BorrowForm" class="btn borrow-input btn-primary pull-left"> <i
                            class="fa fa-save"></i> حفظ </button>
                </div>
            </div>
        </div>
    </div> -->


    <!-- <div class="modal fade" style="border-radius: 10px;" id="NewOwnerModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 10px;">

                <div class="modal-header">
                    <h4 class="modal-title" align="center"> إضافة بيانات مالك جديد </h4>
                </div>
                <div class="modal-body" dir="rtl">
                    <form id="owner_form" class="oe_formview">
                        <table class="table table-responsive">
                            <br />
                            <tr>
                                <td>
                                    <label>
                                        نوع المالك
                                    </label>
                                </td>
                                <td colspan="3">
                                    <input class="col-xs-2 pull-right" checked type="radio" id="individual" value="1"
                                        name="owner_type">
                                    <label class="col-xs-2 pull-right">فرد</label>
                                    <input class="col-xs-2 pull-right" type="radio" id="org" value="2"
                                        name="owner_type">
                                    <label class="col-xs-2 pull-right">مؤسسة</label>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-xs-3">
                                    <label class="control-label text-center">الإسم </label>
                                </td>
                                <td class="col-xs-3" colspan="4">
                                    <input autocomplete="off" required type="text" class="text-center form-control"
                                        name="owner_name" placeholder="إسم المالك ....." />
                                </td>
                            </tr>
                            <tr>
                                <td class="col-xs-3">
                                    <label class="control-label text-center">رقم الهاتف 1</label>
                                </td>
                                <td class="col-xs-3">
                                    <input dir="ltr" type="tel" class="form-control text-center"
                                        placeholder="رقم الهاتف 1" id="phone1" name="phone1" />
                                </td>

                                <td class="col-xs-3">
                                    <label class="control-label text-center">رقم الهاتف 2</label>
                                </td>
                                <td class="col-xs-3">
                                    <input dir="ltr" type="tel" class="form-control text-center"
                                        placeholder="رقم الهاتف 2" id="phone2" name="phone2" />
                                </td>
                            </tr>
                            <tr id="id_row">
                                <td class="col-xs-3">
                                    <label class="control-label text-center">نوع إثبات الشخصية</label>
                                </td>
                                <td class="col-xs-3">
                                    <select required class="form-control text-center" name="idtype" id="idtype">
                                        <option value="0"> لايوجد </option>
                                        <option value="1"> رقم وطني </option>
                                        <option value="2"> بطاقة قومية </option>
                                        <option value="3"> جواز سفر </option>
                                        <option value="4"> رخصة قيادة </option>
                                    </select>
                                </td>
                                <td class="col-xs-3">
                                    <label class="control-label text-center">رقم إثبات الشخصية</label>
                                </td>
                                <td class="col-xs-3">
                                    <input dir="ltr" type="text" class="form-control text-center"
                                        placeholder="رقم إثبات الشخصية" id="idno" name="idno" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>ملاحظات</label>
                                </td>
                                <td colspan="3">
                                    <textarea name="notes" style="resize: none" rows="4"
                                        class="form-control col-xs-12"></textarea>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-warning pull-left"> <i class="fa fa-window-close"></i>
                        إغلاق </button>
                    <button type="submit" form="owner_form" class="btn btn-primary pull-left"> <i
                            class="fa fa-save"></i> حفظ </button>
                </div>
            </div>
        </div>
    </div> -->
    </div>

    <div class="modal fade" style="border-radius: 10px;" id="CoordinationModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 10px;">
                <div class="modal-header">
                    <h4 class="modal-title" align="center"> إضافة أسماء حضور التنسيق والمعاينة </h4>
                </div>
                <div class="modal-body" dir="rtl">
                    <form id="coordinator_form" class="oe_formview">
                        <input type="hidden" name="event_id" value="<?php echo $_GET['ID']; ?>">
                        <table class="table table-responsive">
                            <br />
                            <tr>
                                <td class="col-xs-1">
                                    <label class="control-label text-center">الإسم </label>
                                </td>
                                <td class="col-xs-3" colspan="4">
                                    <input autocomplete="off" required type="text" class="text-center form-control"
                                        name="name" placeholder="الإسم ....." />
                                </td>
                            </tr>
                            <tr>
                                <td class="col-xs-1">
                                    <label class="control-label text-center">الجهة </label>
                                </td>
                                <td class="col-xs-3" colspan="4">
                                    <input autocomplete="off" required type="text" class="text-center form-control"
                                        name="reference" placeholder="الجهة ....." />
                                </td>
                            </tr>
                            <tr>
                                <td class="col-xs-1">
                                    <label class="control-label text-center">المنصب </label>
                                </td>
                                <td class="col-xs-3" colspan="4">
                                    <input autocomplete="off" required type="text" class="text-center form-control"
                                        name="position" placeholder="المنصب ....." />
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-warning pull-left"> <i class="fa fa-window-close"></i>
                        إغلاق </button>
                    <button type="submit" form="coordinator_form" class="btn btn-primary pull-left"> <i
                            class="fa fa-save"></i> حفظ </button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<script>
$(document).ready(function() {
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
    
    fetchCoordinators();

    $("#add_coordinator").click(function() {
        $("#CoordinationModal").modal("show");
    });

    $('#coordinator_form').submit(function(e) {
        e.preventDefault();

        $.ajax({
            url: '../MODEL/insert_coordinator.php',
            method: 'POST',
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function(data) {
                if (data.success) {
                    $("#coordinator_form")[0].reset();
                    swal({
                        title: "تم !",
                        text: "تم حفظ البيانات بنجاح",
                        type: "success",
                        confirmButtonColor: "skyblue",
                        confirmButtonText: "حسنا"
                    });
                    fetchCoordinators();
                }
                else {
                    swal("لم يتم حفظ البيانات ! الرجاء التحقق من صحتها");
                }

            }
        });
    });

    function fetchCoordinators() {
        $.ajax({
            url: "../MODEL/fetch_coordinators.php",
            method: "POST",
            data: {
                event_id: "<?php echo $_GET['ID']; ?>"
            },
            success: function(data) {
                $("#coordinators_table tbody").html(data);
            }

        });
    }

    fetchHotels();

    $("#add_hotel").click(function() {
        $("#HotelModal").modal("show");
    });

    $("#HotelModal").on('show.bs.modal', function (e) {
        $('#hotel_form')[0].reset();
    });

    $('#hotel_form').submit(function(e) {
        e.preventDefault();

        $.ajax({
            url: '../MODEL/insert_hotel.php',
            method: 'POST',
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function(data) {
                if (data.success) {
                    $("#hotel_form")[0].reset();
                    swal({
                        title: "تم !",
                        text: "تم حفظ البيانات بنجاح",
                        type: "success",
                        confirmButtonColor: "skyblue",
                        confirmButtonText: "حسنا"
                    });
                    fetchHotels();
                }
                else {
                    swal("لم يتم حفظ البيانات ! الرجاء التحقق من صحتها");
                }

            }
        });
    });

    function fetchHotels() {
        $.ajax({
            url: "../MODEL/fetch_hotels.php",
            method: "POST",
            data: {
                event_id: "<?php echo $_GET['ID']; ?>"
            },
            success: function(data) {
                $("#hotels_table tbody").html(data);
            }

        });
    }

    $("#event_form").submit(function(e) {
        e.preventDefault();

        if (change_flag == true) {
            $.ajax({
                url: '../MODEL/update_event.php',
                method: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data) {
                        alertify.success(
                            "<h4>  <i class='fa fa-check'></i> تم حفظ التعديلات بنجاح </h4>"
                            );
                        change_flag = false;

                    } else {
                        swal("لم يتم حفظ البيانات ! الرجاء التحقق من صحتها");
                    }
                }
            });
        } else {
            alertify.message("<h4><i class='fa fa-info'></i> ليست هناك تعديلات لحفظها </h4>");
        }
    });

    $("#delete_event").click(function() {
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
                $.ajax({
                    url: "../MODEL/delete_event.php",
                    method: "POST",
                    data: {
                        event_id: '<?php echo $_GET['ID'] ?>'
                    },
                    success: function(data) {
                        if (data) {
                            swal({
                                title: "تم !",
                                text: "تم الحذف بنجاح",
                                type: "success",
                                confirmButtonColor: "skyblue",
                                confirmButtonText: "حسنا"
                            }).then(function() {
                                window.location = "events.php";
                            });
                        } else {
                            swal("لم يتم حذف السجل لإرتباطه بسجلات أخرى");
                        }

                    }
                });

            } else {

            }
        });
    });


    $("#individual").click(function() {
        $("#id_row").show();
    });

    $("#org").click(function() {
        $("#id_row").hide();
        $("#id_type").val(0);
        $("#idno").val('');
    });


    var status = $("#status").val();


    if ($("#privilege").val() != 1 && $("#privilege").val() != 2) {
        $("input").prop('disabled', true);
        $("select").prop('disabled', true);
        $("button").prop('disabled', true);

    }


    if ($("#privilege").val() == 5) {
        $(".borrow-input").prop('disabled', false);
        $("#borrow").prop('disabled', false);
        $("#receive").prop('disabled', false);
    }

    if ($("#privilege").val() == 3) {
        $("#add_trans").prop('disabled', false);
        $("#add_docs").prop('disabled', false);
    }

    if (status == 1) {
        $("input").prop('disabled', true);
        $("select").prop('disabled', true);
        $("button").prop('disabled', true);
        alertify.set('notifier', 'position', 'bottom-center');
        alertify.error("<h3> هذه القطعة قد تم تغيير غرضها من زراعي إلى سكني ولا يمكن تعديل بياناتها </h3>");
    } else if (status == 2) {
        $("input").prop('disabled', true);
        $("select").prop('disabled', true);
        $("button").prop('disabled', true);
        alertify.set('notifier', 'position', 'bottom-center');
        alertify.error("<h3> هذه القطعة قد تم ضمها إلى قطعة أخرى ولا يمكن تعديل بياناتها </h3>");

    } else if (status == 3) {
        $("input").prop('disabled', true);
        $("select").prop('disabled', true);
        $("button").prop('disabled', true);
        alertify.set('notifier', 'position', 'bottom-center');
        alertify.error(
        "<h3> هذه القطعة قد تم نزعها لمصلحة حكومة جمهورية السودان ولا يمكن تعديل بياناتها </h3>");

    }

    window.onbeforeunload = function() {
        window.confirm();
        if (change_flag == true)
            return "";
        else
            return;
    };

    $("#user_button").prop('disabled', false);

    $("#receive").click(function() {

        var land = $("#b_land_no").val();
        var district = $("#b_district").val();
        $.ajax({

            url: '../MODEL/return_land_file.php',
            method: 'POST',
            data: {
                land: land,
                district: district
            },
            success: function(data) {
                if (data)
                    window.location = window.location.href;
            }

        });

    });

    $.datepicker.setDefaults({
        changeYear: true,
        changeMonth: true,
        dateFormat: 'yy-mm-dd'
    });


    $("#borrow").click(function() {
        $("#BorrowModal").modal("show");
    });


    var change_flag = false;

    $("input").change(function() {
        change_flag = true;
    });

    $("select").change(function() {
        change_flag = true;
    });

    $("textarea").change(function() {
        change_flag = true;
    });

    var owners = [];

    $("#land_owners_list option").each(function() {
        owners.push($(this).val());
    });

    $("#register_owner").click(function() {
        $("#NewOwnerModal").modal("show");
    });


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

                    var land = $("#land_no").val();
                    var district = $("#district").val();
                    var owner = data;
                    owners.push(owner);

                    $.ajax({
                        url: "../MODEL/insert_land_owners.php",
                        method: "POST",
                        data: {
                            owner: owner,
                            land: land,
                            district: district
                        },
                        success: function(data) {
                            $("#owners_table").html(data);
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
        $("#borrow_date").datepicker();
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


    $("#BorrowForm").submit(function(e) {

        e.preventDefault();
        $.ajax({
            url: '../MODEL/insert_borrow.php',
            method: 'POST',
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function(data) {

                if (data) {
                    change_flag = false;
                    window.location = window.location.href;
                }
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



    $("#lands_form").submit(function(e) {
        e.preventDefault();

        if (change_flag == true) {
            $.ajax({
                url: '../MODEL/update_land.php',
                method: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data) {

                        var land = $("#land_no").val();
                        var district = $("#district").val();

                        $.ajax({
                            url: '../MODEL/insert_land_owners.php',
                            method: 'POST',
                            data: {
                                owners: owners,
                                land: land,
                                district: district
                            },

                            success: function(data) {
                                $("#scan_land_no").val($("#land_no").val());
                                $("#scan_district_no").val($("#district")
                            .val());

                                alertify.success(
                                    "<h4>  <i class='fa fa-check'></i> تم حفظ التعديلات بنجاح </h4>"
                                    );
                                change_flag = false;
                            }

                        });

                    } else {
                        swal("لم يتم حفظ البيانات ! الرجاء التحقق من صحتها");
                    }
                }
            });
        } else {

            alertify.message("<h4><i class='fa fa-info'></i> ليست هناك تعديلات لحفظها </h4>");

        }
    });




    var c = $("#class_no").val();
    $("#classification").val(c);
    var c = $("#owner_no").val();
    $("#owner").val(c);
    var c = $("#locale_no").val();
    $("#locale").val(c);
    var c = $("#measure_unit_no").val();
    $("#measure_unit").val(c);
    var c = $("#type_no").val();
    $("#land_type").val(c);





    $("#delete_record").click(function() {
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

                var land_no = $("#land_no").val();
                var district_no = $("#district").val();


                $.ajax({
                    url: "../MODEL/delete_land.php",
                    method: "POST",
                    data: {
                        land_no: land_no,
                        district_no: district_no
                    },
                    success: function(data) {

                        if (data) {

                            swal({
                                title: "تم !",
                                text: "تم الحذف بنجاح",
                                type: "success",
                                confirmButtonColor: "skyblue",
                                confirmButtonText: "حسنا"
                            }).then(function() {
                                window.location = "lands.php";
                            });
                        } else {
                            swal("لم يتم حذف السجل لإرتباطه بسجلات أخرى");
                        }

                    }
                });

            } else {

            }
        });
    });

    fetchDistricts();
    var c = $("#district_no").val();
    $("#district").val(c);
});
</script>