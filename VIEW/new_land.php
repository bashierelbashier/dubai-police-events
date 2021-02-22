<?php

session_start();
if (!isset($_SESSION['USER_NO']))
{
    header("location:login.php");
}

if ($_SESSION['PRIVILEGE']==4||$_SESSION['PRIVILEGE']==5)
    header("location:access_denied.php");

?>

<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>

    <meta charset="utf-8"/>
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
    <title style="font-family: 'Droid Arabic Naskh', serif">System</title>
    <script>

        var com_asprise_scan_app_license = "ENTwJt8xMa3wVWon6qFOS17y7OUgMEkJE0hGIz+W6my+wlWY8tHknOWGTPt6eKB8Roo8Y00/yFflhY4FLmzLzvZOLMDlPdPlHo1ekZP8d1ur+kPoYYxxtyzKJ8P1f7vSJnjl1GjhDTBkmSRa3W/Gf2Y4nrZ3V90DNJOxHd2wjzicZ3L5rcrIYcpbgRUw2yD+wdRWPpJl9eWfaKrN9zKXJvBli2GdRti5vwyi8lwKjjq5i1QSKBaLGOJgt9KGWpTJzRjY8kLD9BweJusluxGW0/8Z2sP6DLBlF0QE6APhLqSfxM=";

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
    <link rel="stylesheet" href="../ASSETS/CSS/alertifyjs/css/alertify.rtl.min.css"/> <!-- optional -->
    <link rel="stylesheet" href="../ASSETS/CSS/alertifyjs/css/themes/default.rtl.min.css"/> <!-- optional -->
    <link rel="stylesheet" href="../ASSETS/CSS/mystyle.css">
    <link rel="stylesheet" href="../ASSETS/CSS/btn.css">
    <link rel="stylesheet" href="../ASSETS/CSS/cairo/style.css" type="text/css" media="all" />
    <script src="../ASSETS/SCANNER/scanner.js" type="text/javascript"></script> <!-- required for scanning -->
    <script src="../ASSETS/SCANNER/zoomerang.js"></script>
    <link rel="stylesheet" type="text/css" href="../ASSETS/SCANNER/scanner.css">

</head>
<style>

    img:hover + .button, .button:hover
    {
        display: inline-block;
    }
    .owner-row:hover
    {
        background-color: #b8daff;
    }

    .form-control
    {
        border-radius: 0px;
    }

    html,body
    {
        height: 100%;
        font-size:large;
    }

</style>
<body style="font-family: 'Droid Arabic Naskh', serif">
<div class="col-xs-2 navbar-fixed-top pull-right" style="background-color:black;min-height: 100%;">

    <ul style="margin-top: 55px;" class="nav nav-pills nav-stacked col-md-12">

        <?php include "navigation.php"?>
    </ul>

</div>

<div class="col-md-12 navbar-fixed-top" style="height:55px;background-color: #1b5e20 ;padding-left: 0px;">
    <a style="cursor:pointer;" class="col-xs-9 pull-right"><p class="col-xs-12 pull-right" id="lands" style="margin-top:0.5%;color:white;font-size:x-large"><b> الأراضي <i class="fa fa-arrow-left"></i> قطعة أرض  <i class="fa fa-arrow-left"></i> جديدة </b></p></a>

    <div style="position:relative;z-index: 999;">
        <button style="border-width:0px;height:55px;background-color: #1b5e20;" class="btn col-xs-3 btn-success pull-left dropdown-toggle" data-toggle="dropdown">

            <div>
                <i style="margin: 5px;" class="fa fa-user-circle fa-lg"></i>
                <?php  echo "  ".$_SESSION['FULL_NAME']."  "; ?>
            </div>

        </button>

        <ul class="col-xs-3 dropdown-menu dropdown" style="margin:0px;border-radius:0px;">
            <li style="margin-top: 3px;"><a href="../MODEL/logout.php"><p style="color:#6a6a6a;font-family: 'Droid Arabic Naskh', serif;font-size: medium;color:#1b5e20;" align="center"> <i class="fa fa-lock"></i>  تسجيل الخروج  </p></a></li>
        </ul>
    </div>

</div>


<div class="col-xs-10 navbar-fixed-top pull-right" style="margin-right: 16.7%;height:70px;border-bottom-style: outset;border-bottom-width: 1px;border-bottom-color: lightgray;  background-color: #ffffff;margin-top:55px; ">
    <a href="lands.php"><button style="margin-top: 20px;margin-right:5px;" class="btn btn-default col-xs-2 pull-right"><i class="fa fa-long-arrow-right"></i> رجوع </button></a>
    <button id="lands_form_submit" type="submit" form="lands_form" style="margin-top: 20px;margin-right:5px;" class="btn btn-success col-xs-2 pull-right"><i class="fa fa-save"></i> حفظ </button>
    <button id="lands_form_submit_and_new" type="submit" form="lands_form" style="margin-top: 20px;margin-right:5px;" class="btn btn-primary col-xs-3 pull-right"><i class="fa fa-save"></i> حفظ و إضافة جديد </button>
    <br/>
    <br/>
</div>

</div>


<div class="col-xs-10" style="min-height:81.5%;margin-top:125px;background-image: url('../ASSETS/form_sheetbg.png');">
    <br/>

    <div class="panel panel-default" style="border-radius: 0px;box-shadow: 1px 1px 1px 1px darkgrey;">
        <div class="panel-heading">
            <h1 class="panel-title" align="center"> بيانات قطعة أرض </h1>
        </div>
        <div class="panel-body">

            <form id="lands_form" name="lands_form">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h5 align="center" class="panel-title">
                            البيانات الأساسية لقطعة الأرض
                        </h5>
                    </div>
                    <div class="panel-body">
                        <table class="table table-responsive">
                            <br/>
                            <tr>
                                <td class="col-xs-2">
                                    <label class="control-label">رقم القطعة</label>
                                </td>
                                <td class="col-xs-2">
                                    <input autocomplete="off" id="land_no" required type="text" class="form-control" name="land_no" placeholder="رقم القطعة"/>
                                </td>


                                <td class="col-xs-2">
                                    <label class="control-label">المحلية</label>
                                </td>
                                <td class="col-xs-2">
                                    <select required class="form-control" name="locale" id="locale">
                                        <?php
                                        include "../MODEL/fetch_locales.php";
                                        ?>
                                    </select>
                                </td>
                                <td class="col-xs-2">
                                    <label class="control-label">المربوع</label>
                                </td>
                                <td class="col-xs-2">
                                    <select required class="form-control" name="district" id="district">
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-xs-2">
                                    <label class="control-label">قياس المساحة</label>
                                </td>
                                <td class="col-xs-2">
                                    <select class="form-control" name="measure_unit">
                                        <option value="2" selected>بالأفدنة</option>
                                    </select>
                                </td>
                                <td class="col-xs-2">
                                    <label class="control-label">المساحة</label>
                                </td>
                                <td class="col-xs-2">
                                    <input autocomplete="off" required type="text" class="form-control" name="area"/>
                                </td>
                                <td class="col-xs-2">
                                    <label>التصنيف</label>
                                </td>
                                <td class="col-xs-2">
                                    <select required class="form-control" id="classification" name="classification">
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
                        <h3 align="center" class="panel-title">بيانات مالك قطعة الأرض</h3>
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
                            </table>
                        </div>

                        <button type="button" class="btn btn-primary pull-right" id="add_owner">
                            <i class="fa fa-user-plus"></i>       إختيار مالك
                        </button>

                        <button type="button" id="register_owner" class="btn btn-info pull-left">
                            <i class="fa fa-user-plus"> </i> تسجيل بيانات جديد
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
                                    <input type="text" class="form-control" id="office_no" name="office_no"/>
                                </td>
                                <td>
                                    <label> الدولاب </label>
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="cupboard_no" name="cupboard_no"/>
                                </td>
                                <td>
                                    <label> الوحدة </label>
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="unit_no" name="unit_no"/>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label> الرف </label>
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="shelf_no" name="shelf_no"/>
                                </td>
                                <td>
                                    <label> الصندوق </label>
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="box_no" name="box_no"/>
                                </td>

                                <td>
                                    <label> المجلد </label>
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="folder_no" name="folder_no"/>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

            </form>


            <div class="panel panel-success" style="margin: 20px 0px;">

                <div class="panel-heading">
                    <h2 align="center" class="title panel-title" >   إضافة مستندات لقطعة الأرض :    <i class="fa fa-plus-circle"></i>  <img src="../ASSETS/scan_icon.ico" height="20" width="20" style="margin-bottom:4px;"/> </h2>
                </div>

                <div class="panel-body">
                    <form id="form1" action="../MODEL/upload_files.php?action=dump" method="POST" enctype="multipart/form-data" target="_blank">

                        <input type="text" class="hidden" name="land_no" id="scan_land_no"/>
                        <input type="text" class="hidden" name="district_no" id="scan_district_no"/>
                        <div class="col-md-12">
                            <button type="button" id="scan_single" style="border-radius:0px;" class="btn btn-lg btn-primary pull-right" onclick="scanSimple();">  إضافة مستند جديد <i class="fa fa-plus-square-o"></i> </button>

                            <button type="button" class="hidden btn btn-lg btn-info pull-left" onclick="submitForm1();" style="float: right;border-radius:0px;font-size:large;margin-right:5px;">    حفظ المستندات     <i class="fa fa-upload"></i></button>
                        </div>
                        <div id="images" class="well-lg well col-md-12" style="border-radius:0px;display: block; background-color: #fff; height: 250px; overflow: scroll; margin-top: 20px;margin-bottom: 20px;padding: 5px;">

                        </div>
                        <label class="col-md-12" > <a href="javascript:clearScans();"><span class="pull-left btn btn-danger" style="font-weight: normal;color:white;font-family: 'Droid Arabic Naskh', serif">
                             حذف جميع المستندات <i class="fa fa-trash"></i></span></a></label>
                    </form>
                </div>

            </div>



            <div class="panel panel-success hidden" style="margin: 20px 0px;">

                <div class="panel-heading">
                    <h2 align="center" class="title panel-title" > معاملات قطعة الأرض </h2>
                </div>

                <div class="panel-body">

                    <div id="transactions_table">
                        <table class="table table-striped table-bordered">
                            <tr align="center">
                                <td>#</td>
                                <td>نوع المعاملة</td>
                                <td>تاريخ المعاملة</td>
                            </tr>
                        </table>
                    </div>

                    <button type="button" class="btn btn-primary btn-block" id="add_transaction">
                        <i class="fa fa-plus-square-o"></i> إضافة معاملة
                    </button>

                </div>

            </div>


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
                <br/>
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
                                    <input type="search" id="owner_search_txt" class="form-control" placeholder="الإسم أو رقم إثبات الشخصية ..."/>
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
<div class="modal fade" style="border-radius: 10px;" id="TransactionModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content" style="border-radius: 10px;">

            <div class="modal-header">
                <h6 class="modal-title" align="center"> إضافة معاملات قطعة الأرض </h6>
                <br/>
            </div>

            <div class="modal-body" dir="rtl">
                <form id="TransForm" role="form" class="form form-horizontal">
                    <table class="table table-responsive">

                        <tr>
                            <td width="25%">
                                <label>
                                    نوع المعاملة
                                </label>
                            </td>

                            <td width="25%">
                                <select class="form-control" id="trans_no" name="trans_no">
                                    <option value="1">تخصيص</option>
                                    <option value="2">تجديد</option>
                                    <option value="3">تنازل</option>
                                    <option value="4">رهن</option>
                                    <option value="5">فك رهن</option>
                                    <option value="6">فرز</option>
                                    <option value="8">تغيير غرض</option>
                                    <option value="9">إضافة</option>
                                    <option value="10">ضم</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                    <div id="transaction_data">

                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-warning pull-left"> <i class="fa fa-window-close"></i> إغلاق </button>
                <button type="button" form="TransForm" class="btn btn-success pull-left"> <i class="fa fa-save"> </i> حفظ البيانات </button>
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
                        <br/>
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
                                <input autocomplete="off" required type="text" class="text-center form-control" name="owner_name" placeholder="إسم المالك ....."/>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-xs-3">
                                <label class="control-label">رقم الهاتف 1</label>
                            </td>
                            <td class="col-xs-3">
                                <input dir="ltr" type="tel" class="form-control text-center" placeholder="رقم الهاتف 1" id="phone1" name="phone1"/>
                            </td>

                            <td class="col-xs-3">
                                <label class="control-label">رقم الهاتف 2</label>
                            </td>
                            <td class="col-xs-3">
                                <input dir="ltr" type="tel" class="form-control text-center" placeholder="رقم الهاتف 2" id="phone2" name="phone2"/>
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
                                <input dir="ltr" type="text" class="form-control text-center" placeholder="رقم إثبات الشخصية" id="idno" name="idno"/>
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
    alertify.defaults.glossary.title = 'تأكيد';
    alertify.defaults.glossary.ok = 'موافق';
    alertify.defaults.glossary.cancel = 'إلغاء';
    //alertify.alert('هل قمت بمراجعة البيانات والتأكد من صحتها؟');
</script>

<script>
    $(document).ready(function(){


        $("#individual").click(function(){
            $("#id_row").show();
        });

        $("#org").click(function(){
            $("#id_row").hide();
            $("#id_type").val(0);
            $("#idno").val('');
        });

        var noveou = 0;


        $("#transaction_data").load("TransactionsForms/1.php").hide().fadeIn();

        $("#trans_no").change(function(){

            var trans = $("#trans_no").val();
            $("#transaction_data").load("TransactionsForms/"+trans+".php").hide().fadeIn();

        });


        $.datepicker.setDefaults({
            changeYear : true,
            changeMonth :true,
            dateFormat: 'yy-mm-dd'
        });

        $(function(){
            $("#trans_date").datepicker();
        });


        var change_flag = false;


        $("#lands_form_submit_and_new").click(function(){
            noveou=1;
        });

        $("#add_transaction").click(function(){
            $("#TransactionModal").modal("show");
        });

        $("input").change(function(){
            change_flag=true;
        });

        $("select").change(function(){
            change_flag=true;
        });

        var owners = [];



        $("#owner_form").submit(function(e){
            e.preventDefault();

            $.ajax({
                url:'../MODEL/insert_owner.php',
                method:'POST',
                data:new FormData(this),
                processData:false,
                contentType:false,
                success:function(data)
                {

                    if (data)
                    {
                        owners.push(data);
                        $.ajax({
                            url:"../MODEL/fetch_new_land_owners.php",
                            method:"POST",
                            data:{owners:owners},
                            success:function(data)
                            {
                                $("#owners_table").html(data);
                                $("#SelectOwnerModal").modal("hide");
                            }
                        });

                        $("#NewOwnerModal").modal("hide");
                        $("#owner_form")[0].reset();
                        $.ajax({
                            url:"../MODEL/modal_fetch_owners.php",
                            method : "POST",
                            data : {},
                            success : function(data)
                            {
                                $("#modal-owners-data").html(data);
                            }
                        });
                        change_flag=true;

                    }
                    else
                    {
                        swal("لم يتم حفظ البيانات ! الرجاء التحقق من صحتها");
                    }

                }
            });
        });



        $("#register_owner").click(function(){
            $("#NewOwnerModal").modal("show");
            $("#SelectOwnerModal").modal("hide");
        });



        $.ajax({
            url:"../MODEL/modal_fetch_owners.php",
            method : "POST",
            data : {},
            success : function(data)
            {
                $("#modal-owners-data").html(data);
            }
        });

        $("#add_owner").click(function(){
            $("#SelectOwnerModal").modal("show");
        });

        $("#owner_search_txt").keyup(function(e){

            var txt = $("#owner_search_txt").val();

            $.ajax({
                url:"../MODEL/modal_fetch_owners.php",
                method : "POST",
                data : {txt:txt},
                success : function(data)
                {
                    $("#modal-owners-data").html(data);
                }
            });
        });





        $(document).on('click','.owner-remove',function(e) {

            var owner = $(this).attr("id");

            var removedIndex = owners.indexOf(owner);

            swal({
                title: "تأكيد",
                text: "هل تريد حذف هذا السجل",
                type: "question",

                confirmButtonColor: "red",
                showCancelButton:true,
                cancelButtonColor:"green",
                cancelButtonText:"لا أريد الحذف <i class='fa fa-thumbs-up'></i>",
                confirmButtonText: "نعم <i class='fa fa-trash'></i>"
            }).then(function (isConfirm) {
                if (isConfirm) {

                    if(removedIndex>-1)
                        owners.splice(removedIndex,1);

                    $.ajax({
                        url: "../MODEL/fetch_new_land_owners.php",
                        method: "POST",
                        data: {owners: owners},
                        success: function (data) {
                            $("#owners_table").html(data);
                            $("#SelectOwnerModal").modal("hide");
                            change_flag=true;
                        }
                    });
                }});

        });



        $(document).on('click','.owner-row',function(e){

            var owner =$(this).attr("id");
            var flag = false;
            for (var i=0;i<owners.length;i++)
                if (owners[i]==owner)
                    flag = true;

            if (flag==false)
            {
                owners.push(owner);
                $.ajax({
                    url:"../MODEL/fetch_new_land_owners.php",
                    method:"POST",
                    data:{owners:owners},
                    success:function(data)
                    {
                        $("#owners_table").html(data);
                        $("#SelectOwnerModal").modal("hide");
                        change_flag=true;
                    }
                });
            }
        });



        function fetchDistricts()
        {

            var locale_no = $("#locale").val();
            $.ajax({
                url: '../MODEL/fetch_districts.php',
                method:"POST",
                data:{locale_no:locale_no},
                success:function(data)
                {
                    $("#district").html(data);
                }

            });
        }



        $("#locale").change(function(){
            fetchDistricts();
        });












        $("#lands_form").submit(function(e){

            e.preventDefault();

            $.ajax({
                url:'../MODEL/insert_land.php',
                method:'POST',
                data:new FormData(this),
                processData:false,
                contentType:false,
                success:function(data)
                {
                    if (data)
                    {
                        var land = $("#land_no").val();
                        var district = $("#district").val();
                        $.ajax({
                            url:'../MODEL/insert_land_owners.php',
                            method:'POST',
                            data:{owners:owners,land:land,district:district},
                            success:function(data)
                            {
                                $("#scan_land_no").val($("#land_no").val());
                                $("#scan_district_no").val($("#district").val());

                                submitForm1();
                                change_flag=false;

                                swal({
                                    title : "تم !",
                                    text : "تم حفظ البيانات بنجاح",
                                    type : "success",
                                    confirmButtonColor : "skyblue",
                                    confirmButtonText : "حسنا"
                                }).then(function(){

                                    if (noveou==0)
                                        window.location = "edit_land.php?LAND_NO="+land+"&DISTRICT_NO="+district;
                                    else
                                        window.location = "new_land.php";

                                });
                            }
                        });

                    }else
                    {
                        swal("لم يتم حفظ البيانات ! الرجاء التحقق من صحتها");
                    }
                }
            });
        });








        $.ajax({
            url:"../MODEL/fetch_classifications.php",
            method:"POST",
            success:function(data){
                $("#classification").html(data);
            }
        });

        fetchDistricts();


    });
</script>





































<script>
    // -------------- Optional status display, depending on JQuery --------------
    function displayStatus(loading, mesg, clear) {

        if(loading) {
            $('#info').html((clear ? '' : $('#info').html()) + '<p>' + mesg + '</p>');
        } else {
            $('#info').html((clear ? '' : $('#info').html()) + mesg);
        }
    }

    // -------------- scanning related code: independent of any 3rd JavaScript library --------------
    function scanAsJpg() {
        displayStatus(true, 'Scanning', true);
        scanner.scan(handleImages,
            {  "output_settings" : [ {
                    "type" : "return-base64",
                    "format" : "jpg"
                } ], "i18n": { "lang": getLang() } }, true, false);
    }

    function scanSimple() {
        displayStatus(true, 'جاري المسح ...', true);
        scanner.scan(handleImages,
            {
                "prompt_scan_more": false,
                "detect_blank_pages": true,
                "output_settings" : [ {
                    "type" : "return-base64",
                    "format" : "jpg"
                } ], "i18n": { "lang": getLang() } }, false, false);
    }


    function scanMultiple() {
        displayStatus(true, 'جاري المسح ...', true);
        scanner.scan(handleImages,
            {
                "twain_cap_setting": {
                    "CAP_FEEDERENABLED":true,
                    "CAP_AUTOFEED":true,
                },
                "prompt_scan_more": false,
                "detect_blank_pages": true,
                "output_settings" : [ {
                    "type" : "return-base64",
                    "format" : "jpg"
                } ], "i18n": { "lang": getLang() } }, false, false);
    }

    function scanAsPdf() {
        displayStatus(true, 'جاري مسح الملفات', true);
        scanner.scan(handleImages,
            {  "output_settings" : [ {
                    "type" : "return-base64",
                    "format" : "pdf"
                } ], "i18n": { "lang": getLang() } }, true, false);
    }

    function scanThenUpload() {
        displayStatus(true, 'Scanning', true);
        scanner.scan(handleUploadResponse,
            {
                "output_settings" : [ {
                    "type" : "upload",
                    "format" : "pdf",
                    "pdf_force_black_white" : false,
                    "upload_target" : {
                        "url" : "https://asprise.com/scan/applet/upload.php?action=dump",
                        "cookies" : "name=value; poweredBy=Asprise"
                    }
                } ], "i18n": { "lang": getLang() }
            }
            , true, false);
    }

    /** Returns true if it is successfully or false if failed and reports error. */
    function checkIfSuccessfully(successful, mesg, response) {
        displayStatus(false, '', true);
        if(successful && mesg != null && mesg.toLowerCase().indexOf('user cancel') >= 0) { // User cancelled.
            displayStatus(false, '<pre>' + "تم الإيقاف بواسطة المستخدم" + '</pre>', true);
            return false;
        } else if(!successful) {
            displayStatus(false, '<pre>' + "Failed: " + mesg + "\n" + response + '</pre>', true);
            return false;
        }
        return true;
    }

    /** Callback function to retrieve scanned images. Returns number of images retrieved. */
    function handleImages(successful, mesg, response) {
        if(!checkIfSuccessfully(successful, mesg, response)) {
            return 0;
        }

        var scannedImages = scanner.getScannedImages(response, true, false);
        displayStatus(false, '<pre>' + "Scanned Successfully" + '</pre>', true);
        for(var i = 0; (scannedImages instanceof Array) && i < scannedImages.length; i++) {
            var img = scannedImages[i];
            displayStatus(false, "\n<pre>  " + img.toString() + "</pre>", false);
            appendImage(img, document.getElementById('images'));
        }
        return (scannedImages instanceof Array) ? scannedImages.length : 0;
    }

    /** Callback function to retrieve upload response */
    function handleUploadResponse(successful, mesg, response) {
        if(!checkIfSuccessfully(successful, mesg, response)) {
            return 0;
        }

        var uploadResponse = scanner.getUploadResponse(response);
        if(uploadResponse) {
            displayStatus(false, "<h2>Upload Response from the Server Side: </h2>" + uploadResponse, true);
        } else {
            displayStatus(false, '<pre>' + "Failed: " + mesg + "\n" + response + '</pre>', true);
        }
    }

    /** Displays general response to the page - for demo purpose only. */
    function universalHandlerForDemo(successful, mesg, response) {
        try {
            if (!checkIfSuccessfully(successful, mesg, response)) {
                return;
            }

            // Original images
            var imgCount = handleImages(successful, mesg, response);

            // Thumbnails
            var thumbs = scanner.getScannedImages(response, false, true);
            if (thumbs.length > 0) {
                displayStatus(false, '<pre>' + "Thumbnails acquired: " + thumbs.length + '</pre>', false);

                $("#info").append("<div id=\"thumbs\"></div>");

                for (var i = 0; i < thumbs.length; i++) {
                    var t = thumbs[i];
                    appendImage(t, document.getElementById('thumbs'), true);
                }
            }

            var saveResponse = scanner.getSaveResponse(response);
            if (saveResponse) {
                displayStatus(false, "<h2>File Save Result: </h2>" + saveResponse, false);
            }
            var uploadResponse = scanner.getUploadResponse(response);
            if (uploadResponse) {
                displayStatus(false, "<h2>Upload Response from the Server Side: </h2>" + uploadResponse, false);
            }
        } catch (e) {
            displayStatus(false, "<h2>Exception</h2><p>" +
                (e == null ? e : e.toString().replace(/[\x26\x0A\<>'"]/g,function(r){return"&#"+r.charCodeAt(0)+";"}) )
                + "</p>", false);
        }
    }

    /** To track all the images (thumbnails excluded) scanned so far. */
    /** @type ScannedImage[] */
    var imagesScanned = [];

    /**
     * Appends image to given dom node.
     * @param scannedImage ScannedImage
     * @param domParent
     */
    function appendImage(scannedImage, domParent, isThumbnail) {



        if(! scannedImage) {
            return;
        }
        //scanner.logToConsole("Appending scanned image: " + scannedImage.toString());
        if(!isThumbnail) {
            imagesScanned.push(scannedImage);
        }



        if(scannedImage.mimeType == scanner.MIME_TYPE_BMP || scannedImage.mimeType == scanner.MIME_TYPE_GIF || scannedImage.mimeType == scanner.MIME_TYPE_JPEG || scannedImage.mimeType == scanner.MIME_TYPE_PNG) {



            var elementImg = scanner.createDomElementFromModel(
                {
                    'name': 'img',
                    'attributes': {
                        'class': 'scanned zoom thumb thumb-img',
                        'src': scannedImage.src,
                        'height': '200',
                    }
                }
            );


            var elementcancel = scanner.createDomElementFromModel(
                {
                    'name': 'i',
                    'attributes': {
                        'class': 'fa fa-trash fa-lg',
                        'style': 'font-size:large;',
                    }
                }
            );


            var cancelbutton = scanner.createDomElementFromModel(
                {
                    'name': 'label',
                    'attributes': {
                        'type': 'button',
                        'id': scannedImage.src,
                        'class': 'btn col-xs-12 btn-block delete-doc',
                        'style': 'background-color:grey;color:white;',
                    }
                }
            );

            var sp = scanner.createDomElementFromModel(
                {
                    'name': 'span',
                    'attributes': {
                        'class': 'col-xs-6 pull-right',
                    }
                }
            );

            var document = scanner.createDomElementFromModel(
                {
                    'name': 'div',
                    'attributes': {
                        'id':'image_div',
                        'class': 'col-xs-2 pull-right img_wrapper',
                        'style': 'margin:3px;'
                    }
                }
            );

            var par = scanner.createDomElementFromModel(
                {
                    'name': 'div',
                    'attributes': {
                        'class': 'img_wrapper',
                    }
                }
            );



            cancelbutton.appendChild(elementcancel);
            sp.appendChild(cancelbutton);
            par.appendChild(elementImg);
            par.appendChild(sp);
            document.appendChild(par);
            domParent.appendChild(document);
            // optional UI effect that allows the user to click the image to zoom.
            enableZoom();



        } else if(scannedImage.mimeType == scanner.MIME_TYPE_PDF) {
            var elementA = scanner.createDomElementFromModel({
                'name': 'a',
                'attributes': {
                    'href': 'javascript:previewPdf(' + (imagesScanned.length - 1) + ');',
                    'class': 'thumb thumb-pdf'
                }
            });
            domParent.appendChild(elementA);
        }
    }

    function submitForm1() {
        displayStatus(true, "<pre>جاري تحميل المستندات، الرجاء الإنتظار ....</pre>", true);
        if(! scanner.submitFormWithImages('form1', imagesScanned, function(xhr) {
                if(xhr.readyState == 4) { // 4: request finished and response is ready
                    displayStatus(false, xhr.responseText, true);
                }
            })) {
            //swal("ليس هناك مستندات ليتم تحميلها، الرجاء إضافة مستند لتحميله");
        }
    }

    function clearScans() {
        if((imagesScanned instanceof Array) && imagesScanned.length > 0) {
            swal({
                title: "تحذير",
                text: "هل تريد حذف جميع المستندات التي تم مسحها؟",
                type: "warning",
                confirmButtonColor: "red",
                showCancelButton:true,
                cancelButtonColor:"green",
                cancelButtonText:"لا أريد الحذف",
                confirmButtonText: "<i class='fa fa-trash'></i> نعم"
            }).then(function (isConfirm) {
                if (isConfirm) {
                    imagesScanned = [];
                    document.getElementById('images').innerHTML = '';
                }
            });
        }
    }

    function getLang() {
        return $("#lang").val();
    }

    // Low level scanner access demos
    function selectASource() {
        displayStatus(true, 'Selecting a source ...', true);
        scanner.getSource(handleLowLevelApiResponse, "select", true, null, null, false, null, {
            "i18n": {
                "lang": getLang()
            }
        });
    }

    function listSources() {
        displayStatus(true, 'Lists all sources ...', true);
        scanner.listSources(handleLowLevelApiResponse, false, "all", false, false, null);
    }

    function getSourceCaps() {
        displayStatus(true, 'Gets source capabilities ...', true);
        scanner.getSource(handleLowLevelApiResponse, "select", false, "all", false, true, "CAP_FEEDERENABLED: false; ICAP_UNITS: TWUN_INCHES", {
            "i18n": {
                "lang": getLang()
            }
        });
    }

    function getSystemInfo() {
        displayStatus(true, 'Gets system info ...', true);
        scanner.callFunction(handleLowLevelApiResponse, "asprise_scan_system_info");
    }

    function handleLowLevelApiResponse(successful, mesg, result) {
        displayStatus(false, (successful ? "OK" : "ERROR") + '<pre>' + (mesg ? " - " + mesg : "") + "\n" + result + '</pre>', true);
    }

    $(function() {
        if(window.scanner.hasJava()) {
            displayStatus(false, "JRE: " + window.scanner.deployJava.getJREs(), false);
        } else {
            if(! window.scanner.isWindows()) {
                displayStatus(false, "<p class='warn'>Currently, only Windows is supported.</p>", false);
            }
        }
    });


    $(document).on('click','.delete-doc',function(){

        var src = $(this).attr("id");
        swal({
            title: "تأكيد",
            text: "هل تريد حقاً حذف هذا المستند؟",
            type: "warning",

            confirmButtonColor: "red",
            showCancelButton:true,
            cancelButtonColor:"green",
            cancelButtonText:"لا أريد الحذف",
            confirmButtonText: "<i class='fa fa-trash'></i> نعم"
        }).then(function (isConfirm) {
            if (isConfirm) {

                var temp = [];
                for (var i = 0; i < imagesScanned.length; i++) {

                    if (imagesScanned[i].src != src) {
                        temp.push(imagesScanned[i])
                    }
                }

                imagesScanned = temp;
                $("#images").html("");
                afterdelete();


            }
        });



    });





    /******************************************************************************************/
    function afterdelete()
    {

        for (var i=0;i<imagesScanned.length;i++)
        {

            var scannedImage = imagesScanned[i];

            var elementImg = scanner.createDomElementFromModel(
                {
                    'name': 'img',
                    'attributes': {
                        'class': 'scanned zoom thumb thumb-img',
                        'src': scannedImage.src,
                        'height': '200',
                    }
                }
            );


            var elementcancel = scanner.createDomElementFromModel(
                {
                    'name': 'i',
                    'attributes': {
                        'class': 'fa fa-trash fa-lg',
                        'style': 'font-size:large;',
                    }
                }
            );


            var cancelbutton = scanner.createDomElementFromModel(
                {
                    'name': 'label',
                    'attributes': {
                        'type': 'button',
                        'id': scannedImage.src,
                        'class': 'btn col-xs-12 btn-block delete-doc',
                        'style': 'background-color:grey;color:white;',
                    }
                }
            );

            var sp = scanner.createDomElementFromModel(
                {
                    'name': 'span',
                    'attributes': {
                        'class': 'col-xs-6 pull-right',
                    }
                }
            );

            var document_div = scanner.createDomElementFromModel(
                {
                    'name': 'div',
                    'attributes': {
                        'id':'image_div',
                        'class': 'col-xs-2 pull-right img_wrapper',
                    }
                }
            );

            var par = scanner.createDomElementFromModel(
                {
                    'name': 'div',
                    'attributes': {
                        'class': 'img_wrapper',
                    }
                }
            );



            cancelbutton.appendChild(elementcancel);
            sp.appendChild(cancelbutton);
            par.appendChild(elementImg);
            par.appendChild(sp);
            document_div.appendChild(par);
            document.getElementById('images').appendChild(document_div);

            // // optional UI effect that allows the user to click the image to zoom.
            enableZoom();

        }
    }

    function enableZoom() {
        Zoomerang.config({
            maxWidth: window.innerWidth, // 400,
            maxHeight: window.innerHeight, // 400,
            bgColor: '#000',
            bgOpacity: .80,
            onClose: function(target) {
                target.style.transform = ''; // fixing origin missing bug
            }
        }).listen('.zoom');
    }
</script>