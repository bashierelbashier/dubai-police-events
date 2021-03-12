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
    <script>
    </script>
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
            <p class="col-xs-12 pull-right" id="lands" style="margin-top:0.5%;color:white;font-size:x-large"><b>
                    الفعاليات
                    <i class="fa fa-arrow-left"></i> فعالية <i class="fa fa-arrow-left"></i> جديدة </b></p>
        </a>

        <div style="position:relative;z-index: 999;">
            <button style="border-width:0px;height:55px;background-color: #1b5e20;"
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


    <div class="col-xs-10 navbar-fixed-top pull-right"
        style="margin-right: 16.7%;height:70px;border-bottom-style: outset;border-bottom-width: 1px;border-bottom-color: lightgray;  background-color: #ffffff;margin-top:55px; ">
        <button id="lands_form_submit" type="submit" form="lands_form" style="margin-top: 20px;margin-right:5px;"
            class="btn btn-success col-xs-2 pull-right"><i class="fa fa-save"></i> حفظ </button>
        <button id="lands_form_submit_and_new" type="submit" form="lands_form"
            style="margin-top: 20px;margin-right:5px;" class="btn btn-primary col-xs-3 pull-right"><i
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

                <form id="lands_form" name="lands_form">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h5 align="center" class="panel-title">
                                بيانات الفعالية الأساسية
                            </h5>
                        </div>
                        <div class="panel-body">
                            <table class="table table-responsive">
                                <br />
                                <tr>
                                    <td class="col-xs-2">
                                        <label class="control-label">إسم الفعالية</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input autocomplete="off" id="land_no" required type="text" class="form-control"
                                            name="land_no" placeholder="إسم الفعالية" />
                                    </td>


                                    <td class="col-xs-2">
                                        <label class="control-label">الجهة المنظمة</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input autocomplete="off" id="land_no" required type="text" class="form-control"
                                            name="land_no" placeholder="الجهة المنظمة" />
                                    </td>
                                    <td class="col-xs-2">
                                        <label class="control-label">موقع الفعالية</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input autocomplete="off" id="land_no" required type="text" class="form-control"
                                            name="land_no" placeholder="موقع الفعالية" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-xs-2">
                                        <label class="control-label">تاريخ الفعالية</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input autocomplete="off" required type="text" class="form-control"
                                            name="area" />
                                    </td>
                                    <td class="col-xs-2">
                                        <label class="control-label">عدد الحضور المتوقع</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input autocomplete="off" required type="text" class="form-control"
                                            name="area" />
                                    </td>
                                    <td class="col-xs-2">
                                        <label>عدد الأفراد الشرطة</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <input autocomplete="off" required type="text" class="form-control"
                                            name="area" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-xs-2">
                                        <label>هل يوجد شخصيات هامة؟</label>
                                    </td>
                                    <td class="col-xs-2">
                                        <select required class="form-control" id="land_type" name="land_type">
                                            <option value="0">لا</option>
                                            <option value="1">نعم</option>
                                        </select>
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
                            <div id="owners_table">
                                <table align="center" class="table table-bordered">
                                    <tr align="center" style="background-color: #0c5460;color:white">
                                        <td> متسلسل # </td>
                                        <td> الإسم </td>
                                        <td> الجهة </td>
                                        <td> المنصب </td>
                                    </tr>
                                </table>
                            </div>

                            <!-- <button type="button" class="btn btn-primary pull-right" id="add_owner">
                                <i class="fa fa-user-plus"></i> إختيار مالك
                            </button> -->

                            <button type="button" id="register_owner" class="btn btn-info pull-left">
                                <i class="fa fa-user-plus"> </i> تسجيل جديد
                            </button>

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
                                        <input type="text" class="form-control" id="office_no" name="office_no" />
                                    </td>
                                    <td>
                                        <label> الدولاب </label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="cupboard_no" name="cupboard_no" />
                                    </td>
                                    <td>
                                        <label> الوحدة </label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="unit_no" name="unit_no" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label> الرف </label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="shelf_no" name="shelf_no" />
                                    </td>
                                    <td>
                                        <label> الصندوق </label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="box_no" name="box_no" />
                                    </td>

                                    <td>
                                        <label> المجلد </label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="folder_no" name="folder_no" />
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                </form>




            </div>

        </div>

    </div>



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
                                    <label class="control-label">الإسم </label>
                                </td>
                                <td class="col-xs-3" colspan="4">
                                    <input autocomplete="off" required type="text" class="text-center form-control"
                                        name="owner_name" placeholder="إسم المالك ....." />
                                </td>
                            </tr>
                            <tr>
                                <td class="col-xs-3">
                                    <label class="control-label">رقم الهاتف 1</label>
                                </td>
                                <td class="col-xs-3">
                                    <input dir="ltr" type="tel" class="form-control text-center"
                                        placeholder="رقم الهاتف 1" id="phone1" name="phone1" />
                                </td>

                                <td class="col-xs-3">
                                    <label class="control-label">رقم الهاتف 2</label>
                                </td>
                                <td class="col-xs-3">
                                    <input dir="ltr" type="tel" class="form-control text-center"
                                        placeholder="رقم الهاتف 2" id="phone2" name="phone2" />
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
    </div>
</body>

</html>

<script>
alertify.defaults.glossary.title = 'تأكيد';
alertify.defaults.glossary.ok = 'موافق';
alertify.defaults.glossary.cancel = 'إلغاء';
//alertify.alert('هل قمت بمراجعة البيانات والتأكد من صحتها؟');
</script>

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

    var noveou = 0;


    $.datepicker.setDefaults({
        changeYear: true,
        changeMonth: true,
        dateFormat: 'yy-mm-dd'
    });

    $(function() {
        $("#trans_date").datepicker();
    });


    var change_flag = false;


    $("#lands_form_submit_and_new").click(function() {
        noveou = 1;
    });

    $("input").change(function() {
        change_flag = true;
    });

    $("select").change(function() {
        change_flag = true;
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

    $("#lands_form").submit(function(e) {

        e.preventDefault();

        $.ajax({
            url: '../MODEL/insert_land.php',
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

                            submitForm1();
                            change_flag = false;

                            swal({
                                title: "تم !",
                                text: "تم حفظ البيانات بنجاح",
                                type: "success",
                                confirmButtonColor: "skyblue",
                                confirmButtonText: "حسنا"
                            }).then(function() {

                                if (noveou == 0)
                                    window.location =
                                    "edit_land.php?LAND_NO=" + land +
                                    "&DISTRICT_NO=" + district;
                                else
                                    window.location = "new_land.php";

                            });
                        }
                    });

                } else {
                    swal("لم يتم حفظ البيانات ! الرجاء التحقق من صحتها");
                }
            }
        });
    });

    $.ajax({
        url: "../MODEL/fetch_classifications.php",
        method: "POST",
        success: function(data) {
            $("#classification").html(data);
        }
    });

    fetchDistricts();


});
</script>