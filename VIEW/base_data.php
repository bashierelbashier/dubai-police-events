<?php
session_start();

if (!isset($_SESSION['USER_NO'])) {
    header("location:login.php");
}

if ($_SESSION['PRIVILEGE'] != 1 && $_SESSION['PRIVILEGE'] != 2) {
    header("location:access_denied.php");
}


include "../MODEL/connect.php";
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
    .form-control {
        border-radius: 0px;
    }

    html,
    body {
        height: 100%;
    }
</style>

<body style="font-family: 'Droid Arabic Naskh', serif">
    <div class="col-xs-2 navbar-fixed-top pull-right" style="background-color:black;min-height: 100%;">

        <ul style="margin-top: 55px;" class="nav nav-pills nav-stacked col-md-12">
            <?php include "navigation.php"; ?>
        </ul>

    </div>


    <div class="col-md-12 navbar-fixed-top" style="height:55px;background-color: #1b5e20 ;padding-left: 0px;">
        <a class="col-xs-9 pull-right" style="cursor:pointer;">
            <p class="col-xs-12 pull-right" id="lands" style="margin-top:0.5%;color:white;font-size:x-large"><b> <i class="fa fa-database"></i> البيانات المرجعية </b></p>
        </a>

        <div style="position:relative;z-index: 999;">
            <button style="border-width:0px;height:55px;background-color: #1b5e20;" class="btn col-xs-3 btn-success pull-left dropdown-toggle" data-toggle="dropdown">

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


    <div class="col-xs-10 navbar-fixed-top pull-right" style="margin-right: 16.7%;height:70px;border-bottom-style: outset;border-bottom-width: 1px;border-bottom-color: lightgray;  background-color: #ffffff;margin-top:55px; ">

        <ul style="margin-top:3px; background-color: #ffffff; border-radius:0px;border-bottom-width: 1px;border-bottom-color: cornflowerblue" id="tabs" class="nav nav-tabs col-xs-12 pull-right" data-tabs="tabs" dir="rtl">

            <li class="active"><a href="#tab1" data-toggle="tab">
                    <p size="4" color="black">المحليات</p>
                </a></li>
            <li><a href="#tab2" data-toggle="tab">
                    <p size="4" color="black">المربوعات</p>
                </a></li>
            <li><a href="#tab3" data-toggle="tab">
                    <p size="4" color="black">تصنيفات الأراضي</p>
                </a></li>
            <li><a href="#tab4" data-toggle="tab">
                    <p size="4" color="black">أنواع الأراضي</p>
                </a></li>
            <li class="hidden"><a href="#tab5" data-toggle="tab">
                    <p size="4" color="black">صناديق الأرشفة</p>
                </a></li>

        </ul>




        <div id="my-tab-content" style="margin-top:100px;" class="tab-content">
            <div class="tab-pane active" id="tab1">
                <button class="btn btn-info col-xs-4 pull-right modal-open" id="add_locale"><i class="fa fa-plus-circle"></i> إضافة محلية جديدة </button>
                <br />
                <br />

                <?php
                $sql = "SELECT * FROM T_LOCALES";
                $res = mysqli_query($connect, $sql);
                $count = 1;
                ?>

                <div class="panel panel-success" style="height:400px; overflow-y: scroll;">
                    <div class="panel-heading">
                        <h2 align="center" style="font-size: large" class="panel-title">أسماء المحليات</h2>
                    </div>
                    <div class="panel-body" id="locales_table">
                        <table class="table table-bordered" style="font-size:large;">
                            <tr align="center" style="background-color:#e8e8e8">
                                <td><b># متسلسل</b></td>
                                <td width="70%" colspan="2"><b>إسم المحلية</b></td>
                            </tr>
                            <?php while ($row = mysqli_fetch_array($res)) { ?>
                                <input hidden type="text" value="<?php echo $row['LOCALE_NAME']; ?>" id="l<?php echo $row['LOCALE_NO']; ?>" />
                                <tr align="center">
                                    <td><?php echo $count; ?></td>
                                    <td width="70%"><?php echo $row['LOCALE_NAME']; ?></td>
                                    <td>
                                        <button class="btn btn-primary locale-update" id="<?php echo $row['LOCALE_NO']; ?>"> <i class="fa fa-edit"></i> تعديل الإسم </button>
                                        <button class="btn btn-danger locale-delete" id="<?php echo $row['LOCALE_NO']; ?>"> <i class="fa fa-remove"></i> حذف </button>
                                    </td>
                                </tr>
                            <?php $count = $count + 1;
                            } ?>
                        </table>
                    </div>
                </div>
            </div>

            <div class="tab-pane" id="tab5">
                <button class="btn btn-info col-xs-4 pull-right" id="add_box"><i class="fa fa-plus-circle"></i> إضافة صندوق </button>
                <br />
                <br />

                <?php
                $sql = "SELECT * FROM T_BOXES";
                $res = mysqli_query($connect, $sql);
                $count = 1;
                ?>

                <div class="panel panel-success" style="height:400px; overflow-y: scroll;">
                    <div class="panel-heading">
                        <h2 align="center" style="font-size: large" class="panel-title">صناديق الأرشفة</h2>
                    </div>
                    <div class="panel-body" id="boxes_table">
                        <table class="table table-bordered" style="font-size:large;">

                            <tr align="center" style="background-color:#e8e8e8">
                                <td width="10%"><b># متسلسل</b></td>
                                <td width="12%"><b>رقم المكتب</b></td>
                                <td width="12%"><b>رقم الدولاب</b></td>
                                <td width="12%"><b>رقم الوحدة</b></td>
                                <td width="12%"><b>رقم الرف</b></td>
                                <td width="12%"><b>رقم الصندوق</b></td>
                                <td width="30%"><b>*****</b></td>
                            </tr>

                            <?php while ($row = mysqli_fetch_array($res)) { ?>
                                <tr align="center">
                                    <td><?php echo $count; ?></td>
                                    <td width="12%"><?php echo $row['OFFICE_NO']; ?></td>
                                    <td width="12%"><?php echo $row['CUPBOARD_NO']; ?></td>
                                    <td width="12%"><?php echo $row['UNIT_NO']; ?></td>
                                    <td width="12%"><?php echo $row['SHELF_NO']; ?></td>
                                    <td width="12%"><?php echo $row['BOX_NO']; ?></td>
                                    <td width="30%">
                                        <button class="btn hidden btn-primary box-update" id="<?php echo $row['BOX_ID']; ?>"> <i class="fa fa-edit"></i> تعديل </button>
                                        <button class="btn btn-danger box-delete" id="<?php echo $row['BOX_ID']; ?>"> <i class="fa fa-remove"></i> حذف </button>
                                    </td>
                                </tr>
                            <?php $count = $count + 1;
                            } ?>
                        </table>
                    </div>
                </div>
            </div>

            <div class="tab-pane" id="tab2">
                <button class="btn btn-info col-xs-4 pull-right modal-open" id="add_district"><i class="fa fa-plus-circle"></i> إضافة مربوع جديد </button>
                <br />
                <br />
                <?php
                $sql = "SELECT * FROM T_DISTRICTS JOIN T_LOCALES USING (LOCALE_NO)";
                $res = mysqli_query($connect, $sql);
                $count = 1;
                ?>
                <div class="panel panel-success" style="height:400px; overflow-y: scroll;">
                    <div class="panel-heading">
                        <h2 align="center" style="font-size: large" class="panel-title">أسماء المربوعات</h2>
                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered" id="districts_table" style="font-size:large">
                            <tr align="center" style="background-color:#e8e8e8">
                                <td><b># متسلسل</b></td>
                                <td width="35%"><b>المحلية</b></td>
                                <td width="35%" colspan="2"><b>إسم المربوع</b></td>
                            </tr>
                            <?php while ($row = mysqli_fetch_array($res)) { ?>
                                <input hidden type="text" value="<?php echo $row['LOCALE_NO']; ?>" id="dl<?php echo $row['DISTRICT_NO']; ?>" />
                                <input hidden type="text" value="<?php echo $row['DISTRICT_NAME']; ?>" id="d<?php echo $row['DISTRICT_NO']; ?>" />
                                <tr align="center">
                                    <td><?php echo $count; ?></td>
                                    <td width="35%"><?php echo $row['LOCALE_NAME']; ?></td>
                                    <td width="35%"><?php echo $row['DISTRICT_NAME']; ?></td>
                                    <td>
                                        <button class="btn btn-primary district-update" id="<?php echo $row['DISTRICT_NO']; ?>"> <i class="fa fa-edit"></i> تعديل الإسم </button>
                                        <button class="btn btn-danger district-delete" id="<?php echo $row['DISTRICT_NO']; ?>"> <i class="fa fa-remove"></i> حذف </button>
                                    </td>
                                </tr>
                            <?php $count = $count + 1;
                            } ?>
                        </table>
                    </div>
                </div>
            </div>

            <div class="tab-pane" id="tab3">
                <button class="btn btn-info col-xs-4 pull-right modal-open" id="add_classification"><i class="fa fa-plus-circle"></i> إضافة تصنيف جديد </button>
                <br />
                <br />
                <?php
                $sql = "SELECT * FROM T_CLASSIFICATIONS";
                $res = mysqli_query($connect, $sql);
                $count = 1;
                ?>
                <div class="panel panel-success" style="height:400px; overflow-y: scroll;">
                    <div class="panel-heading">
                        <h2 align="center" style="font-size: large" class="panel-title">تصنيفات الأراضي</h2>
                    </div>
                    <div class="panel-body" id="classifications_table">
                        <table class="table table-bordered" style="font-size:large">
                            <tr align="center" style="background-color:#e8e8e8">
                                <td><b># متسلسل</b></td>
                                <td width="70%" colspan="2"><b>التصنيف</b></td>

                            </tr>
                            <?php while ($row = mysqli_fetch_array($res)) { ?>
                                <input hidden type="text" value="<?php echo $row['CLASS_NAME']; ?>" id="c<?php echo $row['CLASS_NO']; ?>" />
                                <tr align="center">
                                    <td><?php echo $count; ?></td>
                                    <td width="70%"><?php echo $row['CLASS_NAME']; ?></td>
                                    <td>
                                        <button class="btn btn-primary class-update" id="<?php echo $row['CLASS_NO']; ?>"> <i class="fa fa-edit"></i> تعديل الإسم </button>
                                        <button class="btn btn-danger class-delete" id="<?php echo $row['CLASS_NO']; ?>"> <i class="fa fa-remove"></i> حذف </button>
                                    </td>
                                </tr><?php $count = $count + 1;
                                    } ?>
                        </table>
                    </div>
                </div>
            </div>

            <div class="tab-pane" id="tab4">
                <button class="btn btn-info col-xs-4 pull-right modal-open" id="add_type"><i class="fa fa-plus-circle"></i> إضافة نوع قطعة أرض جديد </button>
                <br />
                <br />
                <?php
                $sql = "SELECT * FROM T_LAND_TYPES";
                $res = mysqli_query($connect, $sql);
                $count = 1;
                ?>
                <div class="panel panel-success" style="height:400px; overflow-y: scroll;">
                    <div class="panel-heading">
                        <h2 align="center" style="font-size: large" class="panel-title">أسماء أنواع قطع الأراضي</h2>
                    </div>
                    <div class="panel-body" id="types_table">
                        <table class="table table-bordered" style="font-size:large">
                            <tr align="center" style="background-color:#e8e8e8">
                                <td><b># متسلسل</b></td>
                                <td width="70%" colspan="2"><b>إسم نوع قطعة الأرض</b></td>
                            </tr>
                            <?php while ($row = mysqli_fetch_array($res)) { ?>
                                <input hidden type="text" value="<?php echo $row['TYPE_NAME']; ?>" id="t<?php echo $row['TYPE_NO']; ?>" />
                                <tr align="center">
                                    <td><?php echo $count; ?></td>
                                    <td width="70%"><?php echo $row['TYPE_NAME']; ?></td>
                                    <td>
                                        <button class="btn btn-primary type-update" id="<?php echo $row['TYPE_NO']; ?>"> <i class="fa fa-edit"></i> تعديل الإسم </button>
                                        <button class="btn btn-danger type-delete" id="<?php echo $row['TYPE_NO']; ?>"> <i class="fa fa-remove"></i> حذف </button>
                                    </td>
                                </tr><?php $count = $count + 1;
                                    } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </div>


    <!-- Modal -->
    <div class="modal fade" style="border-radius: 0px;" id="BaseModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content" style="border-radius: 0px;">


                <h4 class="modal-title" id="base_data_modal_title" align="center"></h4>

                <div class="modal-body" dir="rtl">
                    <br />
                    <br />
                    <form class="form-inline" id="insert_count_form">
                        <table class="table table-striped">
                            <tr id="locale_row" class="hidden">
                                <td>
                                    <label>
                                        المحلية
                                    </label>
                                </td>
                                <td>
                                    <input id="district_locale_nom" hidden />
                                    <select class="form-control" id="district_locale_no">

                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label align="right" id="base_data_text_label"></label>
                                </td>
                                <td width="80%">
                                    <input autofocus style="width:400px;" type="text" id="base_data_text_input" name="" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <br />
                                    <br />
                                    <br />
                                    <br />
                                    <button align="center" type="button" id="base_data_modal_submit" class="btn btn-primary btn-block"><i class="fa fa-save"></i> حفظ البيانات </button>
                                    <button type="button" class="hidden btn btn-success btn-block" id="base_data_modal_update"><i class="fa fa-edit"></i> حفظ التعديلات </button>
                                </td>
                            </tr>
                        </table>
                    </form>


                    <button type="button" class="btn btn-warning" data-dismiss="modal">إغلاق</button>
                </div>
            </div>

        </div>
    </div>

    <!-- End Of Modal -->



    <!-- Modal -->
    <div class="modal fade" style="border-radius: 0px;" id="BoxModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content" style="border-radius: 0px;">


                <h4 class="modal-title" align="center"> إنشاء صندوق أرشفة جديد </h4>

                <div class="modal-body" dir="rtl">
                    <br />
                    <br />
                    <form class="form-inline" id="boxes_form">
                        <table class="table table-responsive">
                            <tr>
                                <td>
                                    <label>رقم المكتب</label>
                                </td>
                                <td>
                                    <input type="text" required class="form-control" id="office_no" name="office_no" autocomplete="off" />
                                </td>
                                <td>
                                    <label>رقم الدولاب</label>
                                </td>
                                <td>
                                    <input type="text" required class="form-control" id="cupborad_no" name="cupboard_no" autocomplete="off" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>رقم الوحدة</label>
                                </td>
                                <td>
                                    <input type="text" required class="form-control" id="unit_no" name="unit_no" autocomplete="off" />
                                </td>
                                <td>
                                    <label>رقم الرف</label>
                                </td>
                                <td>
                                    <input type="text" required class="form-control" id="shelf_no" name="shelf_no" autocomplete="off" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>رقم الصندوق</label>
                                </td>
                                <td>
                                    <input type="text" required class="form-control" id="box_no" name="box_no" autocomplete="off" />
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning pull-left" data-dismiss="modal">إغلاق</button>
                    <button type="submit" form="boxes_form" class="btn btn-primary pull-left" id="boxes_submit"><i class="fa fa-save"></i> حفظ </button>
                    <button type="submit" form="boxes_form" class="btn hidden btn-success pull-left" id="boxes_update"><i class="fa fa-edit"></i> حفظ التعديلات </button>

                </div>
            </div>

        </div>
    </div>

    <!-- End Of Modal -->



    <div class="col-xs-10" style="min-height:81.5%;margin-top:125px;background-image: url('../ASSETS/form_sheetbg.png');">
        <br />

    </div>

</body>

</html>
<script>
    $(document).ready(function() {
        var uid = '';
        var type = '';



        function fetchLocales() {
            $.ajax({
                url: "../MODEL/fetch_locales.php",
                method: "GET",
                data: {},
                success: function(data) {
                    document.getElementById("district_locale_no").innerHTML = data;
                }
            });
        }

        $("#add_box").click(function() {
            $("#BoxModal").modal("show");
        });



        $(".modal-open").click(function(e) {

            $("#base_data_text_input").val('');

            document.getElementById("base_data_modal_submit").classList.remove('hidden');
            document.getElementById("base_data_modal_update").classList.add('hidden');
            var id = this.getAttribute('id');
            if (id == 'add_locale') {
                $("#base_data_modal_title").html("إضافة محلية جديدة");
                $("#base_data_text_label").html("إسم المحلية");
                document.getElementById("locale_row").classList.add('hidden');


                type = 'l';

            } else if (id == 'add_type') {
                $("#base_data_modal_title").html("إضافة نوع قطعة أرض جديد");
                $("#base_data_text_label").html("إسم نوع قطعة الأرض");
                document.getElementById("locale_row").classList.add('hidden');


                type = 't';

            } else if (id == 'add_classification') {
                $("#base_data_modal_title").html("إضافة تصنيف جديد");
                $("#base_data_text_label").html("إسم التصنيف");
                document.getElementById("locale_row").classList.add('hidden');


                type = 'c';

            } else {
                $("#base_data_modal_title").html("إضافة مربوع جديد");
                $("#base_data_text_label").html("إسم المربوع");
                fetchLocales();
                document.getElementById("locale_row").classList.remove('hidden');


                type = 'd';
            }
            $("#base_data_text_input").focus();
            $("#BaseModal").modal("show");

        });


        $("#boxes_form").submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: "../MODEL/insert_box.php",
                method: "POST",
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data) {
                        $("#boxes_table").html(data);
                        $("#BoxModal").modal("hide");
                        $("#boxes_form")[0].reset();
                    } else {
                        swal("لم يتم إدخال البيانات الرجاء التحقق من صحتها");
                    }
                }
            });
        });


        $(document).on('click', '.locale-update', function(e) {

            var id = $(this).attr("id");
            uid = id;
            $("#base_data_modal_title").html("تعديل إسم المحلية");
            $("#base_data_text_label").html("إسم المحلية");

            id = 'l' + id;
            var vale = $("#" + id).val();

            $("#base_data_text_input").val(vale);
            $("#base_data_text_input").focus();

            document.getElementById("base_data_modal_submit").classList.add('hidden');
            document.getElementById("base_data_modal_update").classList.remove('hidden');
            document.getElementById("locale_row").classList.add('hidden');

            $("#BaseModal").modal("show");
            type = 'l';

        });

        $(document).on('click', '.district-update', function(e) {

            var id = $(this).attr("id");
            uid = id;
            var lid = id;
            $("#base_data_modal_title").html("تعديل المربوع");
            $("#base_data_text_label").html("إسم المربوع");

            id = 'd' + id;
            var vale = $("#" + id).val();
            $("#base_data_text_input").val(vale);
            $("#base_data_text_input").focus();

            lid = 'dl' + lid;
            vale = $("#" + lid).val();

            document.getElementById("base_data_modal_submit").classList.add('hidden');
            document.getElementById("base_data_modal_update").classList.remove('hidden');
            document.getElementById("locale_row").classList.add('hidden');


            $("#district_locale_nom").val(vale);




            $("#BaseModal").modal("show");
            type = 'd';

        });

        $(document).on('click', '.class-update', function(e) {

            var id = $(this).attr("id");
            uid = id;
            $("#base_data_modal_title").html("تعديل التصنيف");
            $("#base_data_text_label").html("التصنيف");

            id = 'c' + id;
            var vale = $("#" + id).val();
            $("#base_data_text_input").val(vale);
            $("#base_data_text_input").focus();

            document.getElementById("base_data_modal_submit").classList.add('hidden');
            document.getElementById("base_data_modal_update").classList.remove('hidden');
            document.getElementById("locale_row").classList.add('hidden');


            $("#BaseModal").modal("show");
            type = 'c';

        });


        $(document).on('click', '.type-update', function(e) {

            var id = $(this).attr("id");
            uid = id;
            $("#base_data_modal_title").html("تعديل إسم نوع قطعة الأرض");
            $("#base_data_text_label").html("إسم نوع قطعة الأرض");

            id = 't' + id;
            var vale = $("#" + id).val();
            $("#base_data_text_input").val(vale);
            $("#base_data_text_input").focus();

            document.getElementById("base_data_modal_submit").classList.add('hidden');
            document.getElementById("base_data_modal_update").classList.remove('hidden');
            document.getElementById("locale_row").classList.add('hidden');


            $("#BaseModal").modal("show");
            type = 't';

        });




        $("#base_data_modal_update").click(function() {
            var text = $("#base_data_text_input").val();
            if (text != '' && text != ' ') {
                if (type == 'l') {
                    $.ajax({
                        url: "../MODEL/update_locale.php",
                        method: "POST",
                        data: {
                            text: text,
                            id: uid
                        },
                        success: function(data) {
                            $("#locales_table").html(data);
                        }

                    });
                } else if (type == 'd') {
                    var locale = $("#district_locale_nom").val();
                    $.ajax({
                        url: "../MODEL/update_district.php",
                        method: "POST",
                        data: {
                            text: text,
                            id: uid,
                            locale: locale
                        },
                        success: function(data) {
                            if (data) {
                                $("#districts_table").html(data);
                            } else {
                                swal("لايمكن تعديل السجل لإرتباطه بسجلات أخرى (قطع الأراضي)");
                            }

                        }

                    });
                } else if (type == 'c') {

                    $.ajax({
                        url: "../MODEL/update_classification.php",
                        method: "POST",
                        data: {
                            text: text,
                            id: uid
                        },
                        success: function(data) {
                            $("#classifications_table").html(data);
                        }

                    });
                } else if (type == 't') {
                    $.ajax({
                        url: "../MODEL/update_type.php",
                        method: "POST",
                        data: {
                            text: text,
                            id: uid
                        },
                        success: function(data) {
                            $("#types_table").html(data);
                        }

                    });
                }
                $("#base_data_text_input").val("");
                $("#BaseModal").modal("hide");
            } else {
                swal("الرجاء كتابة الإسم أولا ثم الحفظ");
            }
        });

        $("#base_data_modal_submit").click(function() {
            var text = $("#base_data_text_input").val();
            if (text != '' && text != ' ') {
                if (type == 'l') {


                    $.ajax({
                        url: "../MODEL/insert_locale.php",
                        method: "POST",
                        data: {
                            text: text
                        },
                        success: function(data) {
                            $("#locales_table").html(data);
                        }
                    });

                } else if (type == 't') {
                    var fees_type = $("input[name=fees_type]:checked").val();

                    $.ajax({
                        url: "../MODEL/insert_type.php",
                        method: "POST",
                        data: {
                            text: text,
                            fees_type: fees_type
                        },
                        success: function(data) {
                            $("#types_table").html(data);
                        }
                    });
                } else if (type == 'd') {
                    var locale = $("#district_locale_no").val();
                    $.ajax({
                        url: "../MODEL/insert_district.php",
                        method: "POST",
                        data: {
                            text: text,
                            locale: locale
                        },
                        success: function(data) {
                            $("#districts_table").html(data);
                        }
                    });
                } else if (type == 'c') {
                    $.ajax({
                        url: "../MODEL/insert_classification.php",
                        method: "POST",
                        data: {
                            text: text
                        },
                        success: function(data) {
                            $("#classifications_table").html(data);
                        }
                    });
                }
                $("#base_data_text_input").val("");
                $("#BaseModal").modal("hide");
            } else {
                swal("الرجاء كتابة الإسم أولا ثم الحفظ");
            }

        });







        $(document).on('click', '.type-delete', function(e) {
            var id = $(this).attr("id");
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
                        url: "../MODEL/delete_type.php",
                        method: "POST",
                        data: {
                            id: id
                        },
                        success: function(data) {
                            if (data) {
                                $("#types_table").html(data);
                            } else {
                                swal("لم يتم حذف السجل لإرتباطه بسجلات أخرى");
                            }

                        }
                    });

                } else {

                }
            });
        });

        /////////////////////////////////////////////////////////


        $(document).on('click', '.box-delete', function(e) {
            var id = $(this).attr("id");
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
                        url: "../MODEL/delete_box.php",
                        method: "POST",
                        data: {
                            id: id
                        },
                        success: function(data) {
                            if (data) {
                                $("#boxes_table").html(data);
                            } else {
                                swal("لم يتم حذف السجل لإرتباطه بسجلات أخرى");
                            }

                        }
                    });

                } else {

                }
            });
        });

        ///////////////////////////////////////////////////////////

        $(document).on('click', '.district-delete', function(e) {
            var id = $(this).attr("id");
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
                        url: "../MODEL/delete_district.php",
                        method: "POST",
                        data: {
                            id: id
                        },
                        success: function(data) {
                            if (data) {
                                $("#districts_table").html(data);
                            } else {
                                swal("لم يتم حذف السجل لإرتباطه بسجلات أخرى");
                            }

                        }
                    });

                } else {

                }
            });
        });



        //////////////////////////////////////

        $(document).on('click', '.locale-delete', function(e) {
            var id = $(this).attr("id");
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
                        url: "../MODEL/delete_locale.php",
                        method: "POST",
                        data: {
                            id: id
                        },
                        success: function(data) {
                            if (data) {
                                $("#locales_table").html(data);
                            } else {
                                swal("لم يتم حذف السجل لإرتباطه بسجلات أخرى");
                            }

                        }
                    });

                } else {

                }
            });
        });




        //////////////////////////////////////

        $(document).on('click', '.classification-delete', function(e) {
            var id = $(this).attr("id");
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
                        url: "../MODEL/delete_classification.php",
                        method: "POST",
                        data: {
                            id: id
                        },
                        success: function(data) {
                            if (data) {
                                $("#classifications_table").html(data);
                            } else {
                                swal("لم يتم حذف السجل لإرتباطه بسجلات أخرى");
                            }

                        }
                    });

                } else {

                }
            });
        });

    });
</script>