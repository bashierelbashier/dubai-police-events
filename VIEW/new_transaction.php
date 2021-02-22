<?php

session_start();
if (!isset($_SESSION['USER_NO'])) {
    header("location:login.php");
}


if ($_SESSION['PRIVILEGE'] == 4 || $_SESSION['PRIVILEGE'] == 5)
    header("location:access_denied.php");


include "../MODEL/connect.php";

$sql = "SELECT * FROM T_LANDS JOIN T_LOCALES USING (LOCALE_NO) 
  JOIN T_DISTRICTS USING (DISTRICT_NO) WHERE LAND_NO='" . $_GET['land_no'] . "' AND DISTRICT_NO = " . $_GET['district_no'];

$res = mysqli_query($connect, $sql);

$row = mysqli_fetch_array($res);

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

    .owner-row:hover {
        background-color: #1e7e34;
    }
</style>

<body style="font-family: 'Droid Arabic Naskh', serif;font-size: large">
    <div class="col-xs-2 navbar-fixed-top pull-right" style="background-color:black;min-height: 100%;">

        <ul style="margin-top: 55px;" class="nav nav-pills nav-stacked col-md-12">
            <?php include "navigation.php" ?>
        </ul>

    </div>

    <div class="col-md-12 navbar-fixed-top" style="height:55px;padding-left:0px;background-color: #1b5e20;">

        <a class="col-xs-9 pull-right" style="cursor:pointer;">
            <p class="col-xs-12 pull-right" id="classes" style="margin-top:7px;color:white;font-size:x-large">
                <b> <i class="fa fa-exchange"></i> معاملة <i class="fa fa-arrow-left"></i> قطعة أرض رقم : <?php echo $_GET['land_no']; ?> - <?php echo $row['DISTRICT_NAME']; ?> </b>
            </p>
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


    <div class="col-xs-10 navbar-fixed-top pull-right" align="right" style="margin-right: 16.7%;height:70px;border-bottom-style: outset;border-bottom-width: 1px;border-bottom-color: lightgray;padding-top: 15px;  background-color: #ffffff;margin-top:55px; ">
        <a href="edit_land.php?LAND_NO=<?php echo $_GET['land_no'] . '&DISTRICT_NO=' . $_GET['district_no']; ?>"">
    <button class=" btn btn-default col-md-2 pull-right">
            <i class="fa fa-long-arrow-right"></i> رجوع
            </button>
        </a>
        <div class="col-xs-3 pull-right dropdown" style="background-color:white;height:30px;color:black;border-width:0px;">
            <button class="btn btn-default btn-block dropdown-toggle" data-toggle="dropdown" style="border-radius:10px;">
                المعاملة <i class="fa fa-caret-down"></i>
            </button>
            <ul style="margin-top:10px;" class="dropdown-menu col-xs-12">
                <li class="col-xs-12 center-block" id="assign_link"><a href="#">
                        <p style="color:#6a6a6a;font-family: 'Droid Arabic Naskh', serif;" align="right"> <i id="assign" class="fa fa-check marker"></i> تخصيص </p>
                    </a></li>
                <li class="col-xs-12 center-block" id="renew_link"><a href="#">
                        <p style="color:#6a6a6a;font-family: 'Droid Arabic Naskh', serif;" align="right"> <i id="renew" class="fa fa-check marker"></i> تجديد </p>
                    </a></li>
                <li class="col-xs-12 center-block" id="give_link"><a href="#">
                        <p style="color:#6a6a6a;font-family: 'Droid Arabic Naskh', serif;" align="right"> <i id="give" class="fa fa-check marker"></i> تنازل </p>
                    </a></li>
                <li class="col-xs-12 center-block" id="mort_link"><a href="#">
                        <p style="color:#6a6a6a;font-family: 'Droid Arabic Naskh', serif;" align="right"> <i id="mort" class="fa fa-check marker"></i> رهن </p>
                    </a></li>
                <li class="col-xs-12 center-block" id="dismort_link"><a href="#">
                        <p style="color:#6a6a6a;font-family: 'Droid Arabic Naskh', serif;" align="right"> <i id="dismort" class="fa fa-check marker"></i> فك رهن </p>
                    </a></li>
                <li class="col-xs-12 center-block" id="distin_link"><a href="#">
                        <p style="color:#6a6a6a;font-family: 'Droid Arabic Naskh', serif;" align="right"> <i id="distin" class="fa fa-check marker"></i> فرز </p>
                    </a></li>
                <li class="hidden col-xs-12 center-block" id="tagneen_link"><a href="#">
                        <p style="color:#6a6a6a;font-family: 'Droid Arabic Naskh', serif;" align="right"> <i id="tagneen" class="fa fa-check marker"></i> تقنيين </p>
                    </a></li>
                <li class="col-xs-12 center-block" id="change_link"><a href="#">
                        <p style="color:#6a6a6a;font-family: 'Droid Arabic Naskh', serif;" align="right"> <i id="change" class="fa fa-check marker"></i> تغيير غرض </p>
                    </a></li>
                <li class="col-xs-12 center-block" id="add_link"><a href="#">
                        <p style="color:#6a6a6a;font-family: 'Droid Arabic Naskh', serif;" align="right"> <i id="add" class="fa fa-check marker"></i> إضافة </p>
                    </a></li>
                <li class="col-xs-12 center-block" id="join_link"><a href="#">
                        <p style="color:#6a6a6a;font-family: 'Droid Arabic Naskh', serif;" align="right"> <i id="join" class="fa fa-check marker"></i> ضم </p>
                    </a></li>
                <li class="col-xs-12 center-block" id="return_link"><a href="#">
                        <p style="color:#6a6a6a;font-family: 'Droid Arabic Naskh', serif;" align="right"> <i id="return" class="fa fa-check marker"></i> إسترداد </p>
                    </a></li>
                <li class="col-xs-12 center-block" id="rip_link"><a href="#">
                        <p style="color:#6a6a6a;font-family: 'Droid Arabic Naskh', serif;" align="right"> <i id="rip" class="fa fa-check marker"></i> نزع </p>
                    </a></li>
            </ul>
        </div>
    </div>



    <div class="col-xs-10" id="transaction_form_area" style="min-height:81.5%;margin-top:125px;background-color:whitesmoke;">

    </div>




    <input type="text" hidden value="<?php echo $_GET['land_no']; ?>" id="land_no" />
    <input type="text" hidden value="<?php echo $_GET['district_no']; ?>" id="district_no" />


    <!-- Modal -->
    <div class="modal fade" style="border-radius: 10px;" id="SelectOwnerModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content" style="border-radius: 10px;">

                <div class="modal-header">
                    <h6 class="modal-title" align="center"> </h6>
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
                                <td width="40%"> إثبات الشخصية </td>
                            </tr>
                        </table>
                    </div>
                    <div id="modal-owners-data" style="overflow-x:scroll;height:300px;">

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" id="register_owner" class="btn btn-info pull-right"><i class=" fa fa-plus"></i> تسجيل جديد </button>
                    <button data-dismiss="modal" class="btn btn-warning pull-left"> <i class="fa fa-window-close"></i> إغلاق </button>
                </div>
            </div>
        </div>
    </div>


</body>

</html>
<script>
    $(document).ready(function() {

        var trans_no = 1;
        $(".marker").hide();
        $("#assign").show();

        var land_no = $("#land_no").val();

        var district_no = $("#district_no").val();

        var url = "formsTransactions/assign.php?land_no=" + land_no + "&district_no=" + district_no + "&trans_no=" + trans_no;

        $("#transaction_form_area").load(url).hide().fadeIn(0);


        $("#assign_link").click(function() {

            trans_no = 1;
            url = "formsTransactions/assign.php?land_no=" + land_no + "&district_no=" + district_no + "&trans_no=" + trans_no;
            $("#transaction_form_area").load(url).hide().fadeIn(0);
            $(".marker").hide();
            $("#assign").show();

        });

        $("#renew_link").click(function() {
            trans_no = 2;
            url = "formsTransactions/renewal.php?land_no=" + land_no + "&district_no=" + district_no + "&trans_no=" + trans_no;
            $("#transaction_form_area").load(url).hide().fadeIn(0);
            $(".marker").hide();
            $("#renew").show();
        });

        $("#give_link").click(function() {
            trans_no = 3;
            url = "formsTransactions/give.php?land_no=" + land_no + "&district_no=" + district_no + "&trans_no=" + trans_no;
            $("#transaction_form_area").load(url).hide().fadeIn(0);
            $(".marker").hide();
            $("#give").show();
        });


        $("#mort_link").click(function() {
            trans_no = 4;
            url = "formsTransactions/mort.php?land_no=" + land_no + "&district_no=" + district_no + "&trans_no=" + trans_no;
            $("#transaction_form_area").load(url).hide().fadeIn(0);
            $(".marker").hide();
            $("#mort").show();
        });

        $("#dismort_link").click(function() {
            trans_no = 5;
            url = "formsTransactions/dismort.php?land_no=" + land_no + "&district_no=" + district_no + "&trans_no=" + trans_no;
            $("#transaction_form_area").load(url).hide().fadeIn(0);
            $(".marker").hide();
            $("#dismort").show();
        });

        $("#distin_link").click(function() {
            trans_no = 6;
            url = "formsTransactions/distin.php?land_no=" + land_no + "&district_no=" + district_no + "&trans_no=" + trans_no;
            $("#transaction_form_area").load(url).hide().fadeIn(0);
            $(".marker").hide();
            $("#distin").show();
        });

        $("#tagneen_link").click(function() {
            trans_no = 7;
            url = "formsTransactions/tagneen.php?land_no=" + land_no + "&district_no=" + district_no + "&trans_no=" + trans_no;
            $("#transaction_form_area").load(url).hide().fadeIn(0);
            $(".marker").hide();
            $("#tagneen").show();
        });

        $("#change_link").click(function() {
            trans_no = 8;
            url = "formsTransactions/change.php?land_no=" + land_no + "&district_no=" + district_no + "&trans_no=" + trans_no;
            $("#transaction_form_area").load(url).hide().fadeIn(0);
            $(".marker").hide();
            $("#change").show();
        });

        $("#add_link").click(function() {
            trans_no = 9;
            url = "formsTransactions/add.php?land_no=" + land_no + "&district_no=" + district_no + "&trans_no=" + trans_no;
            $("#transaction_form_area").load(url).hide().fadeIn(0);
            $(".marker").hide();
            $("#add").show();
        });

        $("#join_link").click(function() {
            trans_no = 10;
            url = "formsTransactions/join.php?land_no=" + land_no + "&district_no=" + district_no + "&trans_no=" + trans_no;
            $("#transaction_form_area").load(url).hide().fadeIn(0);
            $(".marker").hide();
            $("#join").show();
        });

        $("#return_link").click(function() {
            trans_no = 11;
            url = "formsTransactions/return.php?land_no=" + land_no + "&district_no=" + district_no + "&trans_no=" + trans_no;
            $("#transaction_form_area").load(url).hide().fadeIn(0);
            $(".marker").hide();
            $("#return").show();
        });

        $("#rip_link").click(function() {
            trans_no = 12;
            url = "formsTransactions/rip.php?land_no=" + land_no + "&district_no=" + district_no + "&trans_no=" + trans_no;
            $("#transaction_form_area").load(url).hide().fadeIn(0);
            $(".marker").hide();
            $("#rip").show();
        });




        $.datepicker.setDefaults({
            changeYear: true,
            changeMonth: true,
            dateFormat: 'yy-mm-dd'
        });


        var party = '';

        var form_view = '';


        $(document).on('click', '#register_owner', function(e) {
            form_view = '  <div class="modal-dialog">\n' +
                '        <!-- Modal content-->\n' +
                '        <div class="modal-content" style="border-radius: 10px;">\n' +
                '\n' +
                '            <div class="modal-header">\n' +
                '                <h4 class="modal-title" align="center"> إضافة بيانات مالك جديد </h4>\n' +
                '            </div>\n' +
                '            <div class="modal-body" dir="rtl">\n' +
                '<form id="owner_form" class="oe_formview">\n' +
                '                    <table class="table table-responsive">\n' +
                '                        <br/>\n' +
                '                        <tr>\n' +
                '                            <td>\n' +
                '                                <label>\n' +
                '                                    نوع المالك\n' +
                '                                </label>\n' +
                '                            </td>\n' +
                '                            <td colspan="3">\n' +
                '                                <input class="col-xs-2 pull-right" checked type="radio" id="individual" value="1" name="owner_type">\n' +
                '                                <label class="col-xs-2 pull-right">فرد</label>\n' +
                '                                <input class="col-xs-2 pull-right" type="radio" id="org" value="2" name="owner_type">\n' +
                '                                <label class="col-xs-2 pull-right">مؤسسة</label>\n' +
                '                            </td>\n' +
                '                        </tr>\n' +
                '                        <tr>\n' +
                '                            <td class="col-xs-3">\n' +
                '                                <label class="control-label">الإسم </label>\n' +
                '                            </td>\n' +
                '                            <td class="col-xs-3" colspan="4">\n' +
                '                                <input autocomplete="off" required type="text" class="text-center form-control" name="owner_name" placeholder="إسم المالك ....."/>\n' +
                '                            </td>\n' +
                '                        </tr>\n' +
                '                        <tr>\n' +
                '                            <td class="col-xs-3">\n' +
                '                                <label class="control-label">رقم الهاتف 1</label>\n' +
                '                            </td>\n' +
                '                            <td class="col-xs-3">\n' +
                '                                <input dir="ltr" type="tel" class="form-control text-center" placeholder="رقم الهاتف 1" id="phone1" name="phone1"/>\n' +
                '                            </td>\n' +
                '\n' +
                '                            <td class="col-xs-3">\n' +
                '                                <label class="control-label">رقم الهاتف 2</label>\n' +
                '                            </td>\n' +
                '                            <td class="col-xs-3">\n' +
                '                                <input dir="ltr" type="tel" class="form-control text-center" placeholder="رقم الهاتف 2" id="phone2" name="phone2"/>\n' +
                '                            </td>\n' +
                '                        </tr>\n' +
                '                        <tr id="id_row">\n' +
                '                            <td class="col-xs-3">\n' +
                '                                <label class="control-label">نوع إثبات الشخصية</label>\n' +
                '                            </td>\n' +
                '                            <td class="col-xs-3">\n' +
                '                                <select required class="form-control text-center" name="idtype" id="idtype">\n' +
                '                                    <option value="0"> لايوجد </option>\n' +
                '                                    <option value="1"> رقم وطني </option>\n' +
                '                                    <option value="2"> بطاقة قومية </option>\n' +
                '                                    <option value="3"> جواز سفر </option>\n' +
                '                                    <option value="4"> رخصة قيادة </option>\n' +
                '                                </select>\n' +
                '                            </td>\n' +
                '                            <td class="col-xs-3">\n' +
                '                                <label class="control-label">رقم إثبات الشخصية</label>\n' +
                '                            </td>\n' +
                '                            <td class="col-xs-3">\n' +
                '                                <input dir="ltr" type="text" class="form-control text-center" placeholder="رقم إثبات الشخصية" id="idno" name="idno"/>\n' +
                '                            </td>\n' +
                '                        </tr>\n' +
                '                        <tr>\n' +
                '                            <td>\n' +
                '                                <label>ملاحظات</label>\n' +
                '                            </td>\n' +
                '                            <td colspan="3">\n' +
                '                                <textarea name="notes" style="resize: none" rows="4" class="form-control col-xs-12"></textarea>\n' +
                '                            </td>\n' +
                '                        </tr>\n' +
                '                    </table>\n' +
                '                </form>\n' +
                '            </div>\n' +
                '            <div class="modal-footer">\n' +
                '                <button data-dismiss="modal" class="btn btn-warning pull-left"> <i class="fa fa-window-close"></i> إغلاق </button>\n' +
                '                <button type="submit" form="owner_form" class="btn btn-primary pull-left"> <i class="fa fa-save"></i> حفظ </button>\n' +
                '                <button type="button" class="btn btn-default" id="selectOwner"><i class="fa fa-hand-pointer-o"></i> إختيار موجود </button>\n' +
                '            ' +
                '</div>\n' +
                '        </div>\n' +
                '    </div>';

            $("#SelectOwnerModal").html(form_view);

        });



        $(document).on('click', '#selectOwner', function(e) {

            form_view = '<div class="modal-dialog">\n' +
                '        <!-- Modal content-->\n' +
                '        <div class="modal-content" style="border-radius: 10px;">\n' +
                '\n' +
                '            <div class="modal-header">\n' +
                '                <h6 class="modal-title" align="center">  </h6>\n' +
                '                <br/>\n' +
                '            </div>\n' +
                '\n' +
                '            <div class="modal-body" dir="rtl">\n' +
                '                <div>\n' +
                '                    <table class="table table-bordered">\n' +
                '                        <tr>\n' +
                '                            <td colspan="3">\n' +
                '                                <div class="input-group col-xs-12">\n' +
                '                            <span class="input-group-addon" style="background-color:white;border-radius: 0px;border-width:0px;">\n' +
                '                                <i class="fa fa-filter"></i>\n' +
                '                            </span>\n' +
                '                                    <input type="search" id="owner_search_txt" class="form-control" placeholder="الإسم أو رقم إثبات الشخصية ..."/>\n' +
                '                                </div>\n' +
                '                            </td>\n' +
                '                        </tr>\n' +
                '                        <tr align="center" style="background-color: #0c5460;color:white">\n' +
                '                            <td width="15%"> متسلسل # </td>\n' +
                '                            <td width="45%"> إسم المالك </td>\n' +
                '                            <td width="40%"> إثبات الشخصية </td>\n' +
                '                        </tr>\n' +
                '                    </table>\n' +
                '                </div>\n' +
                '                <div id="modal-owners-data" style="overflow-x:scroll;height:300px;">\n' +
                '\n' +
                '                </div>\n' +
                '            </div>\n' +
                '\n' +
                '            <div class="modal-footer">\n' +
                '                <button type="button" id="register_owner" class="btn btn-info pull-right"><i class=" fa fa-plus"></i> تسجيل جديد </button>\n' +
                '                <button data-dismiss="modal" class="btn btn-warning pull-left"> <i class="fa fa-window-close"></i> إغلاق </button>\n' +
                '            </div>\n' +
                '        </div>\n' +
                '    </div>';

            $("#SelectOwnerModal").html(form_view);

            $.ajax({
                url: "../MODEL/modal_fetch_owners.php",
                method: "POST",
                data: {},
                success: function(data) {
                    $("#modal-owners-data").html(data);
                }

            });

        });



        $(document).on('click', '.owner-row', function(e) {

            var owner_no = $(this).attr("id");
            var owner_name = $(this).attr("content");


            if (party == 1) {

                $("#first_party").val(owner_no);
                $("#fp").val(owner_name);


            } else if (party == 2) {

                $("#sec_party").val(owner_no);
                $("#sp").val(owner_name);


            }
            change = true;

            $("#SelectOwnerModal").modal("hide");

        });


        $(document).on('click', '#fp', function() {

            $("#SelectOwnerModal").modal("show");
            party = 1;

        });

        $(document).on('click', '#individual', function() {
            $("#id_row").show();
        });

        $(document).on('click', '#org', function() {
            $("#id_row").hide();
            $("#id_type").val(0);
            $("#idno").val('');
        });


        $(document).on('click', '#sp', function() {

            $("#SelectOwnerModal").modal("show");
            party = 2;

        });





        $.ajax({
            url: "../MODEL/modal_fetch_owners.php",
            method: "POST",
            data: {},
            success: function(data) {
                $("#modal-owners-data").html(data);
            }
        });




        $(document).on('submit', '#owner_form', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: '../MODEL/insert_owner.php',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {

                    if (data) {
                        if (party == 1) {
                            $("#first_party").val(data);
                            $("#fp").val(formData.get("owner_name"));
                        } else if (party == 2) {
                            $("#sec_party").val(data);
                            $("#sp").val(formData.get("owner_name"));
                        }


                        $("#SelectOwnerModal").modal("hide");

                        $("#owner_form")[0].reset();
                        change = true;
                        $.ajax({
                            url: "../MODEL/modal_fetch_owners.php",
                            method: "POST",
                            data: {},
                            success: function(data) {
                                $("#modal-owners-data").html(data);
                            }

                        });
                    } else {
                        swal("لم يتم حفظ البيانات ! الرجاء التحقق من صحتها");
                    }
                }
            });
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


    });
</script>