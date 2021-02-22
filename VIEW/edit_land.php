<?php

session_start();

$land_file_exist = TRUE;

if (!isset($_SESSION['USER_NO'])) {
    header("location:login.php");
}

if ($_SESSION['PRIVILEGE'] == 4)
    header("location:access_denied.php");


include "../MODEL/connect.php";

$sql = "SELECT *,T_LANDS.CREATOR_ID AS CREATED_BY,T_LANDS.MODIFIER_ID AS MODIFIED_BY,
T_LANDS.DATE_CREATED AS CREATION_DATE, T_LANDS.DATE_MODIFIED AS MOD_DATE
 FROM T_LANDS JOIN T_LOCALES USING (LOCALE_NO) 
  JOIN T_DISTRICTS USING (DISTRICT_NO) WHERE LAND_NO='" . $_GET['LAND_NO'] . "' AND DISTRICT_NO = " . $_GET['DISTRICT_NO'];
$res = mysqli_query($connect, $sql);
$row = mysqli_fetch_array($res);

$q = "SELECT * FROM T_LANDS JOIN T_BORROW_LAND_FILE
 USING (LAND_NO,DISTRICT_NO) 
 WHERE LAND_NO='" . $_GET['LAND_NO'] . "' AND DISTRICT_NO = " . $_GET['DISTRICT_NO'] . " AND RETURNED = FALSE";

$r = mysqli_query($connect, $q);

if (mysqli_num_rows($r) > 0) {
    $land_file_exist = FALSE;
}


?>

<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>


    <meta charset="utf-8" />
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <title style="font-family: 'Droid Arabic Naskh', serif">System</title>
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
    <link rel="stylesheet" href="../ASSETS/CSS/alertifyjs/css/alertify.rtl.min.css" /> <!-- optional -->
    <link rel="stylesheet" href="../ASSETS/CSS/alertifyjs/css/themes/default.rtl.min.css" /> <!-- optional -->
    <link rel="stylesheet" href="../ASSETS/CSS/mystyle.css">
    <link rel="stylesheet" href="../ASSETS/CSS/cairo/style.css" type="text/css" media="all" />

</head>

<style>
    .owner-row:hover {
        background-color: #b8daff;
    }

    .form-control {
        border-radius: 0px;
    }

    html,
    body {
        height: 100%;
        font-size: large;
    }
</style>

<body style="font-family: 'Droid Arabic Naskh', serif">
    <input type="text" hidden id="status" value="<?php echo $row['STATUS']; ?>" />
    <div class="col-xs-2 navbar-fixed-top pull-right" style="background-color:black;min-height: 100%;">
        <ul style="margin-top: 55px;" class="nav nav-pills nav-stacked col-md-12">

            <?php include "navigation.php" ?>

        </ul>
    </div>



    <div class="col-md-12 navbar-fixed-top" style="height:55px;background-color: #1b5e20 ;padding-left: 0px;">
        <a style="cursor:pointer;" class="col-xs-9 pull-right">
            <p class="col-xs-12 pull-right" id="lands" style="margin-top:0.5%;color:white;font-size:x-large"><b> الأراضي <i class="fa fa-arrow-left"></i> قطعة أرض <i class="fa fa-arrow-left"></i> <?php echo $row['DISTRICT_NAME'] . " - قطعة رقم : " . $row['LAND_NO'];  ?> </b></p>
        </a>

        <div style="position:relative;z-index: 999;">
            <button id="user_button" style="border-width:0px;height:55px;background-color: #1b5e20;" class="btn col-xs-3 btn-success pull-left dropdown-toggle" data-toggle="dropdown">

                <div>
                    <i style="margin: 5px;" class="fa fa-user-circle fa-lg"></i>
                    <?php echo "  " . $_SESSION['FULL_NAME'] . "  "; ?>
                </div>

            </button>

            <ul class="col-xs-3 dropdown-menu dropdown" style="margin:0px;border-radius:0px;">
                <li style="margin-top: 3px;"><a href="../MODEL/logout.php">
                        <p style="color:#6a6a6a;font-family: 'Droid Arabic Naskh', serif;font-size: medium;color:#1b5e20;" align="center"> <i class="fa fa-lock"></i> تسجيل الخروج </p>
                    </a></li>
            </ul>
        </div>

    </div>


    <div id="buttons_div" class="col-xs-10 navbar-fixed-top pull-right" style="margin-right: 16.7%;height:70px;border-bottom-style: outset;border-bottom-width: 1px;border-bottom-color: lightgray;  background-color: #ffffff;margin-top:55px; ">
        <a href="lands.php" style="margin-top: 20px;margin-right:5px;" class="btn btn-default col-xs-2 pull-right"><i class="fa fa-long-arrow-right"></i> رجوع </a>
        <button type="submit" form="lands_form" style="margin-top: 20px;margin-right:5px;" class="btn btn-success col-xs-2 pull-right"><i class="fa fa-pencil-square-o"></i> حفظ التعديلات </button>
        <button id="delete_record" style="margin-top: 20px;margin-right:5px;" class="btn btn-danger col-xs-2 pull-right"><i class="fa fa-trash-o"></i> حذف </button>
        <a href="add_files.php?land_no=<?php echo $row['LAND_NO'] . '&district_no=' . $row['DISTRICT_NO']; ?>"><button id="add_docs" style="margin-top: 20px;margin-right:5px;" class="btn btn-info col-xs-3 pull-right"><i class="fa fa-plus"></i> إضافة مستندات لقطعة الأرض </button> </a>
        <a href="new_transaction.php?land_no=<?php echo $row['LAND_NO'] . '&district_no=' . $row['DISTRICT_NO']; ?>"><button id="add_trans" style="margin-top: 20px;margin-right:5px;" class="btn btn-warning col-xs-2 pull-right"> <i class="fa fa-plus"></i> إضافة معاملة </button> </a>
        <br />
        <br />
    </div>

    <input type="text" hidden id="privilege" value="<?php echo $_SESSION['PRIVILEGE']; ?>" />


    <div class="col-xs-10" id="data_div" style="min-height:81.5%;margin-top:125px;background-image: url('../ASSETS/form_sheetbg.png');">
        <br />
        <div class="panel panel-default" style="border-radius: 0px;box-shadow: 1px 1px 1px 1px darkgrey;">
            <div class="panel-heading">
                <h1 class="panel-title" align="center"> بيانات قطعة الأرض </h1>
            </div>
            <div class="panel-body">
                <form id="lands_form" name="lands_form">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h3 align="center" class="panel-title"> البيانات الأساسية لقطعة الأرض</h3>
                        </div>
                        <div class="panel-body">
                            <table class="table table-responsive">
                                <tr>
                                    <td class="col-xs-2">
                                        <label class="control-label">رقم القطعة</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input type="text" readonly class="form-control" value="<?php echo $row['LAND_NO']; ?>" name="land_no" id="land_no" placeholder="رقم القطعة" />
                                    </td>
                                    <td class="col-xs-2">
                                        <label class="control-label">المحلية</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input value="<?php echo $row['LOCALE_NO']; ?>" name="locale" id="locale" hidden />
                                        <input required class="form-control " readonly value="<?php echo $row['LOCALE_NAME']; ?>" />
                                    </td>
                                    <td class="col-xs-2">
                                        <label class="control-label">المربوع</label>
                                    </td>
                                    <td class="col-xs-2">

                                        <input value="<?php echo $row['DISTRICT_NO']; ?>" name="district" id="district" hidden />
                                        <input required class="form-control " readonly value="<?php echo $row['DISTRICT_NAME']; ?>" />
                                    </td>

                                </tr>
                                <tr>
                                    <td class="col-xs-2">
                                        <label class="control-label">قياس المساحة</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <select class="form-control" name="measure_unit" id="measure_unit">
                                            <option value="2">بالأفدنة</option>
                                        </select>
                                    </td>
                                    <td class="col-xs-2">
                                        <label class="control-label">المساحة</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input type="text" class="form-control" value="<?php echo $row['AREA']; ?>" name="area" placeholder="مثلاً 20 كيلومتر مربع" />
                                    </td>
                                    <td class="col-xs-2">
                                        <label>التصنيف</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <select class="form-control" id="classification" name="classification">
                                            <?php
                                            include "../MODEL/fetch_classifications.php";
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-xs-2">
                                        <label>نوع قطعة الأرض</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <select required class="form-control" id="land_type" name="land_type">
                                            <?php
                                            include "../MODEL/fetch_land_types.php";
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="panel panel-success">
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
                                        <input type="text" class="form-control" value="<?php echo $row['OFFICE_NO']; ?>" id="office_no" name="office_no" />
                                    </td>
                                    <td>
                                        <label> الدولاب </label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" value="<?php echo $row['CUPBOARD_NO']; ?>" id="cupboard_no" name="cupboard_no" />
                                    </td>
                                    <td>
                                        <label> الوحدة </label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" value="<?php echo $row['UNIT_NO']; ?>" id="unit_no" name="unit_no" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label> الرف </label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" value="<?php echo $row['SHELF_NO']; ?>" id="shelf_no" name="shelf_no" />
                                    </td>
                                    <td>
                                        <label> الصندوق </label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="box_no" value="<?php echo $row['BOX_NO']; ?>" name="box_no" />
                                    </td>
                                    <td>
                                        <label> المجلد </label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="folder_no" value="<?php echo $row['FOLDER_NO']; ?>" name="folder_no" />
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
                    </div>

                    <div class="panel panel-success">
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
                    </div>
                    <div class="col-md-12" style="margin-top:20px;margin-bottom:30px;">

                        <h2 class="col-md-6 pull-right" style="margin-top: 70px;color:brown;font-size:x-large">
                            إستعراض نسخة من ملف قطعة الأرض <i class="fa fa-hand-o-left"></i>
                        </h2>
                        <a>
                            <a href="../REPORTS/land_file.php?land_no=<?php echo $_GET['LAND_NO'] . '&district_no=' . $_GET['DISTRICT_NO']; ?>"><img height="150" src="../ASSETS/folder_icon.png" /></a>
                        </a>

                    </div>
                    <input type="text" hidden value="<?php echo $row['DISTRICT_NO']; ?>" id="district_no" name="district_no" />
                </form>
            </div>

            <div class="panel-footer">
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

            </div>
        </div>
    </div>


    <input type="text" hidden value="<?php echo $row['CLASS_NO']; ?>" id="class_no" />
    <input type="text" hidden value="<?php echo $row['LOCALE_NO']; ?>" id="locale_no" />
    <input type="text" hidden value="<?php echo $row['TYPE_NO']; ?>" id="type_no" />
    <input type="text" hidden value="<?php echo $row['AREA_UNIT']; ?>" id="measure_unit_no" />




    <!-- Modal -->
    <div class="modal fade" style="border-radius: 10px;" id="SelectOwnerModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
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
                                        <span class="input-group-addon" style="background-color:white;border-radius: 0px;border-width:0px;">
                                            <i class="fa fa-filter"></i>
                                        </span>
                                        <input type="search" id="owner_search_txt" class="form-control" placeholder="الإسم أو رقم إثبات الشخصية ..." />
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

                    <button data-dismiss="modal" class="btn btn-warning pull-left"> <i class="fa fa-window-close"></i> إغلاق </button>
                </div>
            </div>
        </div>
    </div>




    <!-- Modal -->
    <div class="modal fade" style="border-radius: 10px;" id="BorrowModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content" style="border-radius: 10px;">

                <div class="modal-header">
                    <h4 class="modal-title" align="center"> تسليف ملف قطعة الأرض </h4>
                </div>
                <div class="modal-body" dir="rtl">
                    <form id="BorrowForm">

                        <input hidden value="<?php echo $_GET['LAND_NO']; ?>" name="b_land_no" class="borrow-input" id="b_land_no" />

                        <input value="<?php echo $_GET['DISTRICT_NO']; ?>" name="b_district" class="borrow-input" id="b_district" hidden />

                        <table class="table table-responsive">

                            <tr>
                                <td>
                                    <label>إسم المستلف</label>
                                </td>
                                <td>
                                    <input required type="text" class="borrow-input form-control" id="borrower" name="borrower" />
                                </td>
                                <td>
                                    <label>إدارة المستلف</label>
                                </td>
                                <td>
                                    <input required type="text" class="borrow-input form-control" id="management" name="management" />
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <label>غرض الإستلاف</label>
                                </td>
                                <td>
                                    <input required type="text" class="borrow-input form-control" id="purpose" name="purpose" />
                                </td>
                                <td>
                                    <label>تاريخ الإستلاف</label>
                                </td>
                                <td>
                                    <input required type="text" class="borrow-input form-control" id="borrow_date" name="borrow_date" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>مُسِّلف الملف</label>
                                </td>
                                <td>
                                    <input required type="text" value="<?php echo $_SESSION['FULL_NAME']; ?>" class="borrow-input form-control" id="hander" name="hander" />
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn borrow-input btn-warning pull-left"> <i class="fa fa-window-close"></i> إغلاق </button>
                    <button type="submit" form="BorrowForm" class="btn borrow-input btn-primary pull-left"> <i class="fa fa-save"></i> حفظ </button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" style="border-radius: 10px;" id="NewOwnerModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
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
                                    <input class="col-xs-2 pull-right" checked type="radio" id="individual" value="1" name="owner_type">
                                    <label class="col-xs-2 pull-right">فرد</label>
                                    <input class="col-xs-2 pull-right" type="radio" id="org" value="2" name="owner_type">
                                    <label class="col-xs-2 pull-right">مؤسسة</label>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-xs-3">
                                    <label class="control-label">الإسم </label>
                                </td>
                                <td class="col-xs-3" colspan="4">
                                    <input autocomplete="off" required type="text" class="text-center form-control" name="owner_name" placeholder="إسم المالك ....." />
                                </td>
                            </tr>
                            <tr>
                                <td class="col-xs-3">
                                    <label class="control-label">رقم الهاتف 1</label>
                                </td>
                                <td class="col-xs-3">
                                    <input dir="ltr" type="tel" class="form-control text-center" placeholder="رقم الهاتف 1" id="phone1" name="phone1" />
                                </td>

                                <td class="col-xs-3">
                                    <label class="control-label">رقم الهاتف 2</label>
                                </td>
                                <td class="col-xs-3">
                                    <input dir="ltr" type="tel" class="form-control text-center" placeholder="رقم الهاتف 2" id="phone2" name="phone2" />
                                </td>
                            </tr>
                            <tr id="id_row">
                                <td class="col-xs-3">
                                    <label class="control-label">نوع إثبات الشخصية</label>
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
                                    <label class="control-label">رقم إثبات الشخصية</label>
                                </td>
                                <td class="col-xs-3">
                                    <input dir="ltr" type="text" class="form-control text-center" placeholder="رقم إثبات الشخصية" id="idno" name="idno" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>ملاحظات</label>
                                </td>
                                <td colspan="3">
                                    <textarea name="notes" style="resize: none" rows="4" class="form-control col-xs-12"></textarea>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-warning pull-left"> <i class="fa fa-window-close"></i> إغلاق </button>
                    <button type="submit" form="owner_form" class="btn btn-primary pull-left"> <i class="fa fa-save"></i> حفظ </button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<script>
    $(document).ready(function() {



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
            alertify.error("<h3> هذه القطعة قد تم نزعها لمصلحة حكومة جمهورية السودان ولا يمكن تعديل بياناتها </h3>");

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
                                    $("#scan_district_no").val($("#district").val());

                                    alertify.success("<h4>  <i class='fa fa-check'></i> تم حفظ التعديلات بنجاح </h4>");
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