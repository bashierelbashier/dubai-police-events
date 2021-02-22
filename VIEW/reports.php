<?php

session_start();
if (!isset($_SESSION['USER_NO']))
{
    header("location:login.php");
}

if ($_SESSION['PRIVILEGE']==5)
    header("location:access_denied.php");

?>


<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>


    <meta charset="utf-8"/>
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
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
    <link rel="stylesheet" href="../ASSETS/CSS/alertifyjs/css/alertify.rtl.min.css"/> <!-- optional -->
    <link rel="stylesheet" href="../ASSETS/CSS/alertifyjs/css/themes/default.rtl.min.css"/> <!-- optional -->
    <link rel="stylesheet" href="../ASSETS/CSS/mystyle.css">
    <link rel="stylesheet" href="../ASSETS/CSS/cairo/style.css" type="text/css" media="all" />

</head>
<style>

    .form-control
    {
        border-radius: 0px;
    }
    .land-row:hover
    {
        background-color: #1b6d85;
        cursor: pointer;
    }
    html,body
    {
        height: 100%;
    }
    .transaction-row:hover
    {
        background-color: dimgray;
        color:white;
    }

</style>
<body style="font-family: 'Droid Arabic Naskh', serif;font-size: large">
<div class="col-xs-2 navbar-fixed-top pull-right" style="background-color:black;min-height: 100%;">

    <ul style="margin-top: 55px;" class="nav nav-pills nav-stacked col-md-12">

        <?php include "navigation.php"?>

    </ul>

</div>


<div class="col-md-12 navbar-fixed-top" style="height:55px;background-color: #1b5e20 ;padding-left: 0px;">
    <a style="cursor:pointer;" class="col-xs-9 pull-right">
        <p class="col-xs-12 pull-right" id="classes" style="margin-top:7px;color:white;font-size:x-large">
            <b> <i class="fa fa-file-pdf-o"></i> التقارير </b>
        </p>
    </a>
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

<div class="col-xs-10 navbar-fixed-top pull-right" style="margin-right: 16.7%;height:70px;border-bottom-style: outset;border-bottom-width: 1px;border-bottom-color: lightgray;padding-top: 15px;  background-color: #ffffff;margin-top:55px; ">
    <br/>
</div>


<div class="col-xs-10" style="min-height:81.5%;margin-top:125px;background-color:white;">

    <br/>


    <!-- *************************************************************************************** -->


    <div style="border-radius: 0px;" class="panel panel-warning">
        <div class="panel-heading">
            <h3 style="font-size:x-large;" align="center" class="panel-title"> تقارير المعاملات </h3>
        </div>
        <div class="panel-body">

            <div style="margin-right:20px;cursor: pointer;box-shadow: 1px 1px 1px 1px lightgrey;background-color:white;" class="col-xs-3 pull-right">
                <div class="col-md-12 pull-right" style="background-color: #0000FF;height:2px;"></div>
                <div class="col-md-12">
                    <h6 align="center">المعاملات في فترة زمنية</h6>
                    <hr>
                    <button id="print_transactions_in_period" type="button" class="btn btn-block center-block btn-default">طباعة <i class="fa fa-print"></i></button>
                    <br/>
                </div>
            </div>

            <div style="margin-right:20px;cursor: pointer;box-shadow: 1px 1px 1px 1px lightgrey;background-color:white;" class="col-xs-3 pull-right">
                <div class="col-md-12 pull-right" style="background-color: #FF0000;height:2px;"></div>
                <div class="col-md-12">
                    <h6 align="center">المعاملات لقطعة أرض معينة</h6>
                    <hr>
                    <button id="LandTransactions" type="button" class="choose-land btn btn-block center-block btn-default">طباعة <i class="fa fa-print"></i></button>
                    <br/>
                </div>
            </div>

            <div style="margin-right:20px;cursor: pointer;box-shadow: 1px 1px 1px 1px lightgrey;background-color:white;" class="col-xs-3 pull-right">
                <div class="col-md-12 pull-right" style="background-color: rebeccapurple;height:2px;"></div>
                <div class="col-md-12">
                    <h6 align="center">معاملة معينة في فترة معينة</h6>
                    <hr>
                    <button id="print_transaction_in_period" type="button" class="btn btn-block center-block btn-default">طباعة <i class="fa fa-print"></i></button>
                    <br/>
                </div>
            </div>


        </div>

    </div>




    <!-- *************************************************************************************** -->




    <div style="border-radius: 0px;" class="panel panel-info">
        <div class="panel-heading">
            <h3 style="font-size:x-large;" align="center" class="panel-title"> تقارير الأرشيف </h3>
        </div>
        <div class="panel-body">

            <div style="margin-right:20px;cursor: pointer;box-shadow: 1px 1px 1px 1px lightgrey;background-color:white;" class="col-xs-3 pull-right">
                <div class="col-md-12 pull-right" style="background-color: #007fff;height:2px;"></div>
                <div class="col-md-12">
                    <h6 align="center"> نسخة من مستندات قطعة أرض </h6>
                    <hr>
                    <button type="button" id="LandFile" class="choose-land btn btn-block center-block btn-default">طباعة <i class="fa fa-print"></i></button>
                    <br/>
                </div>
            </div>

            <div style="margin-right:20px;cursor: pointer;box-shadow: 1px 1px 1px 1px lightgrey;background-color:white;" class="col-xs-3 pull-right">
                <div class="col-md-12 pull-right" style="background-color: seagreen;height:2px;"></div>
                <div class="col-md-12">
                    <h6 align="center"> الملفات المُسْتَلَفَة (غير موجودة) </h6>
                    <hr>
                    <button type="button" onclick="window.location='../REPORTS/BorrowedFiles.php';" class="btn btn-block center-block btn-default">طباعة <i class="fa fa-print"></i></button>
                    <br/>
                </div>
            </div>

            <div style="margin-right:20px;cursor: pointer;box-shadow: 1px 1px 1px 1px lightgrey;background-color:white;" class="col-xs-3 pull-right">
                <div class="col-md-12 pull-right" style="background-color:yellow;height:2px;"></div>
                <div class="col-md-12">
                <h6 align="center"> إستلاف الملفات في فترة زمنية </h6>
                <hr>
                <button id="PrintBorrowInPeriod" type="button" class="btn btn-block center-block btn-default">طباعة <i class="fa fa-print"></i></button>
                <br/>
            </div>


        </div>

    </div>



    <!-- *************************************************************************************** -->



    <div style="border-radius: 0px;" class="panel panel-warning">
        <div class="panel-heading">
            <h3 style="font-size:x-large;" align="center" class="panel-title"> تقارير قطع الأراضي </h3>
        </div>
        <div class="panel-body">

            <div style="margin-right:20px;cursor: pointer;box-shadow: 1px 1px 1px 1px lightgrey;background-color:white;" class="col-xs-3 pull-right">
                <div class="col-md-12 pull-right" style="background-color: black;height:2px;"></div>
                <div class="col-md-12">
                    <h6 align="center"> الأراضي منتهية الإيجارة </h6>
                    <hr>
                    <button type="button" onclick="window.location='../REPORTS/NotInvestedLands.php';" class="btn btn-block center-block btn-default">طباعة <i class="fa fa-print"></i></button>
                    <br/>
                </div>
            </div>

            <div style="margin-right:20px;cursor: pointer;box-shadow: 1px 1px 1px 1px lightgrey;background-color:white;" class="col-xs-3 pull-right">
                <div class="col-md-12 pull-right" style="background-color: brown;height:2px;"></div>
                <div class="col-md-12">
                    <h6 align="center"> الأراضي التي تم إستردادها </h6>
                    <hr>
                    <button type="button" onclick="window.location='../REPORTS/ReturnedLands.php';" class="btn btn-block center-block btn-default">طباعة <i class="fa fa-print"></i></button>
                    <br/>
                </div>
            </div>

            <div style="margin-right:20px;cursor: pointer;box-shadow: 1px 1px 1px 1px lightgrey;background-color:white;" class="col-xs-3 hidden pull-right">
                <div class="col-md-12 pull-right" style="background-color: #9c27b0;height:2px;"></div>
                <div class="col-md-12">
                    <h6 align="center">إحصائية القطع المسجلة</h6>
                    <hr>
                    <button type="button" class="btn btn-block center-block btn-default">طباعة <i class="fa fa-print"></i></button>
                    <br/>
                </div>
            </div>

        </div>

    </div>



    <!-- *************************************************************************************** -->



    <div style="border-radius: 0px;" class="panel panel-info">
        <div class="panel-heading">
            <h3 style="font-size:x-large;" align="center" class="panel-title"> تقارير شاملة في صيغة csv (إكسل) </h3>
        </div>
        <div class="panel-body">

            <div style="margin-right:20px;cursor: pointer;box-shadow: 1px 1px 1px 1px lightgrey;background-color:white;" class="col-xs-3 pull-right">
                <div class="col-md-12 pull-right" style="background-color: violet;height:2px;"></div>
                <div class="col-md-12">
                    <h6 align="center"> جميع الأراضي المسجلة </h6>
                    <hr>
                    <button type="button" class="btn btn-block center-block btn-default"> إستخراج <i class="fa fa-file-excel-o"></i></button>
                    <br/>
                </div>
            </div>

            <div style="margin-right:20px;cursor: pointer;box-shadow: 1px 1px 1px 1px lightgrey;background-color:white;" class="col-xs-3 pull-right">
                <div class="col-md-12 pull-right" style="background-color: limegreen;height:2px;"></div>
                <div class="col-md-12">
                    <h6 align="center">إحصائية بالمحليات والمربوعات</h6>
                    <hr>
                    <button type="button" class="btn btn-block center-block btn-default"> إستخراج <i class="fa fa-file-excel-o"></i></button>
                    <br/>
                </div>
            </div>

            <div style="margin-right:20px;cursor: pointer;box-shadow: 1px 1px 1px 1px lightgrey;background-color:white;" class="col-xs-3 pull-right">
                <div class="col-md-12 pull-right" style="background-color: lightgrey;height:2px;"></div>
                <div class="col-md-12">
                    <h6 align="center">المعاملات وإحصائياتها</h6>
                    <hr>
                    <button type="button" class="btn btn-block center-block btn-default"> إستخراج <i class="fa fa-file-excel-o"></i></button>
                    <br/>
                </div>
            </div>
        </div>

    </div>


</div>



<!-- Modal -->
<div class="modal fade" style="border-radius: 10%;" id="ReportModal" role="dialog">
    <div style="border-radius: 10%;" class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content" style="border-radius: 10px;">

            <div class="modal-header">
                <h4 class="modal-title" align="center"> طباعة تقرير عن المعاملات في فترة زمنية </h4>
            </div>

            <div class="modal-body" dir="rtl">
                <br/>
                <br/>
                <form class="form-inline" method="get" action="../REPORTS/TransInPeriod.php" id="report_form">
                    <table class="table table-striped">
                        <tr>
                            <td><label> من </label></td>
                            <td><input required type="text" class="form-control" id="from_date" name="from_date"/></td>
                            <td><label> إلى </label></td>
                            <td><input required type="text" class="form-control" id="to_date" name="to_date"/></td>
                        </tr>
                    </table>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning pull-left" data-dismiss="modal"><i class="fa fa-window-close"></i> إغلاق </button>
                <button type="submit" form="report_form" class="btn btn-success pull-left"><i class="fa fa-print"></i> طباعة </button>
            </div>

        </div>

    </div>
</div>

<!-- End Of Modal -->




<!-- Modal -->
<div class="modal fade" style="border-radius: 10%;" id="BorrowInPeriodModal" role="dialog">
    <div style="border-radius: 10%;" class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content" style="border-radius: 10px;">

            <div class="modal-header">
                <h4 class="modal-title" align="center"> طباعة تقرير عن سجل إستلاف الملفات في فترة زمنية </h4>
            </div>

            <div class="modal-body" dir="rtl">
                <br/>
                <br/>
                <form class="form-inline" method="get" action="../REPORTS/BorrowedFilesInPeriod.php" id="borrowForm">
                    <table class="table table-striped">
                        <tr>
                            <td><label> من </label></td>
                            <td><input required type="text" class="form-control" id="b_from_date" name="from_date"/></td>
                            <td><label> إلى </label></td>
                            <td><input required type="text" class="form-control" id="b_to_date" name="to_date"/></td>
                        </tr>
                    </table>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning pull-left" data-dismiss="modal"><i class="fa fa-window-close"></i> إغلاق </button>
                <button type="submit" form="borrowForm" class="btn btn-success pull-left"><i class="fa fa-print"></i> طباعة </button>
            </div>

        </div>

    </div>
</div>

<!-- End Of Modal -->






<!-- Modal -->
<div class="modal fade" style="border-radius: 0px;" id="LandTransReportModal" role="dialog">
    <div style="border-radius: 10%;" class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content" style="border-radius: 0px;">

            <div class="modal-header">
                <h4 class="modal-title" align="center"> طباعة تقرير عن معاملات قطعة أرض معينة </h4>
                <br/>
                <div class="input-group col-xs-12">
                            <span class="input-group-addon" style="background-color:white;border-radius: 0px;border-width:0px;">
                                <i class="fa fa-filter"></i>
                            </span>
                    <input type="search" id="lands_search_txt" dir="ltr" class="text-center  form-control" placeholder=" ... رقم القطعة  "/>
                </div>
            </div>

            <div class="modal-body" style="height:400px;overflow:scroll" dir="rtl">

                <form class="form-inline" method="get" action="#" id="LandTransReportForm">
                    <div id="ModalLandsData">

                    </div>
                    <input required type="text" id="land_no" name="land_no" hidden />
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-warning pull-left" data-dismiss="modal"><i class="fa fa-window-close"></i> إغلاق </button>
                <button type="submit" form="LandTransReportForm" class="btn btn-success pull-left"><i class="fa fa-print"></i> طباعة </button>
            </div>

        </div>

    </div>
</div>

<!-- End Of Modal -->






<!-- Modal -->
<div class="modal fade" style="border-radius: 10%;" id="TransInPeriodModal" role="dialog">
    <div style="border-radius: 10%;" class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content" style="border-radius: 10px;">

            <div class="modal-header">
                <h4 class="modal-title" align="center"> طباعة تقرير عن نوع معاملة في فترة زمنية معينة </h4>
            </div>

            <div class="modal-body" dir="rtl">
                <br/>
                <br/>
                <form class="form-inline" method="get" action="../REPORTS/ParticularTransInPeriod.php" id="p_report_form">
                    <table class="table table-striped">
                        <tr>
                            <td>
                                <label> نوع المعاملة </label>
                            </td>
                            <td>
                                <select class="form-control text-center" name="TRANSACTION_NO" id="TRANSACTION_NO">
                                    <option value="1"> تخصيص </option>
                                    <option value="2"> تجديد </option>
                                    <option value="3"> تنازل </option>
                                    <option value="4"> رهن </option>
                                    <option value="5"> فك رهن </option>
                                    <option value="6"> فرز </option>
                                    <option value="8"> تغيير غرض </option>
                                    <option value="9"> إضافة </option>
                                    <option value="10"> ضم </option>
                                </select>
                            </td>
                            <td><label> من </label></td>
                            <td><input required type="text" class="form-control" id="p_from_date" name="from_date"/></td>
                            <td><label> إلى </label></td>
                            <td><input required type="text" class="form-control" id="p_to_date" name="to_date"/></td>
                        </tr>
                    </table>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning pull-left" data-dismiss="modal"><i class="fa fa-window-close"></i> إغلاق </button>
                <button type="submit" form="p_report_form" class="btn btn-success pull-left"><i class="fa fa-print"></i> طباعة </button>
            </div>

        </div>

    </div>
</div>

<!-- End Of Modal -->






</body>
</html>
<script>
    $(document).ready(function(){


        $(document).on('click','.transaction-row',function(e) {
            window.location=$(this).attr("id");
        });

            $(document).on('click','.land-row',function(e) {
            $(".land-row").css("background-color", "white");
            $(".land-row:hover").css("background-color", "#1b6d85");

            $("#land_no").val($(this).attr("id"));

            $(this).css("background-color", "#2a62bc");
        });

        $.ajax({
            url:"../MODEL/modal_fetch_lands.php",
            method:"POST",
            success:function(data){
                $("#ModalLandsData").html(data);
            }
        });



        $("#PrintBorrowInPeriod").click(function(){
            $("#BorrowInPeriodModal").modal({backdrop:'static',keyboard:false});
            $("#BorrowInPeriodModal").modal("show");
        });

        $("#print_transactions_in_period").click(function(){
            $("#ReportModal").modal({backdrop:'static',keyboard:false});
            $("#ReportModal").modal("show");
        });

        $("#print_transaction_in_period").click(function(){
            $("#TransInPeriodModal").modal({backdrop:'static',keyboard:false});
            $("#TransInPeriodModal").modal("show");
        });

        var report = 1;

        $(".choose-land").click(function(e){

            if ($(this).attr('id')=='LandTransactions')
                report = 1;
            else if ($(this).attr('id')=='LandFile')
                report = 2;

            $("#LandTransReportModal").modal({backdrop:'static',keyboard:false});
            $("#LandTransReportModal").modal("show");

        });

        $("#lands_search_txt").keyup(function(e){
            var txt=$("#lands_search_txt").val();
            $.ajax({
                url:"../MODEL/modal_fetch_lands.php",
                method:"POST",
                data:{txt:txt},
                success:function(data){
                    $("#ModalLandsData").html(data);
                }
            });
        });


        $.ajax({
            url:"../MODEL/fetch_transactions.php",
            method:"POST",
            success: function(data)
            {
                $("#past_transactions_table").html(data);
            }
        });



        $("#LandTransReportForm").submit(function(e){
            e.preventDefault();
            var params = $("#land_no").val();
            var url;

            if (report == 1)
                url = "../REPORTS/TransForLand.php?"+params;
            else if (report == 2)
                url = "../REPORTS/land_file.php?"+params;

            window.location = url;
        });



        $.datepicker.setDefaults({
            changeYear : true,
            changeMonth :true,
            dateFormat: 'yy-mm-dd'
        });

        $(function(){
            $("#filter_from").datepicker();
        });

        $(function(){
            $("#filter_to").datepicker();
        });

        $(function(){
            $("#from_date").datepicker();
        });

        $(function(){
            $("#to_date").datepicker();
        });

        $(function(){
            $("#p_from_date").datepicker();
        });

        $(function(){
            $("#p_to_date").datepicker();
        });


        $(function(){
            $("#b_from_date").datepicker();
        });

        $(function(){
            $("#b_to_date").datepicker();
        });

    });
</script>