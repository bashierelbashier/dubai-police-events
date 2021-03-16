<?php
include "../MODEL/connect.php";
session_start();
if (!isset($_SESSION['USER_NO'])) {
    header("location:login.php");
}

if ($_SESSION['PRIVILEGE'] == 4 || $_SESSION['PRIVILEGE'] == 5)
    header("location:access_denied.php");


$cq = "SELECT COUNT(*) AS COUN FROM T_EVENT";
$cr = mysqli_query($connect, $cq);
$cw = mysqli_fetch_array($cr);
$pages = ceil($cw['COUN'] / 20);

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
    <link rel="stylesheet" href="../ASSETS/CSS/alertifyjs/css/alertify.rtl.min.css" /> <!-- optional -->
    <link rel="stylesheet" href="../ASSETS/CSS/alertifyjs/css/themes/default.rtl.min.css" /> <!-- optional -->
    <link rel="stylesheet" href="../ASSETS/CSS/mystyle.css">
    <link rel="stylesheet" href="../ASSETS/CSS/cairo/style.css" type="text/css" media="all" />

</head>
<style>
.land-row:hover {
    background-color: #1b6d85;
    cursor: pointer;
}

html,
body {
    height: 100%;
}

.transaction-row:hover {
    background-color: dimgray;
    color: white;
}
</style>

<body>
    <div class="col-xs-2 navbar-fixed-top pull-right" style="background-color:black;min-height: 100%;">

        <ul style="margin-top: 55px;" class="nav nav-pills nav-stacked col-md-12">

            <?php include "navigation.php" ?>

        </ul>

    </div>


    <div class="col-md-12 navbar-fixed-top" style="height:55px;background-color: #1b5e20 ;padding-left: 0px;">
        <a style="cursor:pointer;" class="col-xs-9 pull-right">
            <p class="col-xs-12 pull-right" id="classes" style="margin-top:7px;color:white;font-size:x-large">
                <b> <i class="fa fa-list"></i> قائمة الفعاليات </b>
            </p>
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
        style="margin-right: 16.7%;height:95px;border-bottom-style: outset;border-bottom-width: 1px;padding-right:5px;padding-left:6px;border-bottom-color: lightgray;padding-top: 15px;  background-color: #ffffff;margin-top:55px; ">

        <!-- <div class="col-xs-2 pull-right dropdown"
            style="background-color:white;height:30px;color:black;border-width:0px;">
            <button class="btn btn-default btn-block dropdown-toggle" data-toggle="dropdown" style="border-radius:0px;">
                طباعة <i class="fa fa-caret-down"></i>
            </button>
            <ul style="margin-top:10px;" class="dropdown-menu col-xs-12">
                <li style="background-color: lightgrey;color:black;" class="col-xs-12 dropdown-header"><span
                        class="pull-right">قائمة الفعاليات</span></li>
                <li id="print_transactions_in_period"><a href="#print_report">
                        <p style="color:#6a6a6a;" align="right"> <i class="fa fa-file-pdf-o"></i> في فترة زمنية </p>
                    </a></li>
                <li id="print_transactions_for_land"><a href="#print_report">
                        <p style="color:#6a6a6a;" align="right"> <i class="fa fa-file-pdf-o"></i> لقطعة أرض معينة </p>
                    </a></li>
                <li style="background-color: lightgrey;color:black;" class="col-xs-12 dropdown-header"><span
                        class="pull-right">الأراضي</span></li>
                <li id="print_ended_rent_lands"><a href="../REPORTS/NotInvestedLands.php">
                        <p style="color:#6a6a6a;" align="right"> <i class="fa fa-file-pdf-o"></i> منتهية الإيجارة </p>
                    </a></li>
            </ul>
        </div> -->

        <div class="col-xs-4 pull-right">
            <nav aria-label="Navigation">
                <ul style="margin:0px;" id="pages" class="pagination">
                </ul>
            </nav>
        </div>


        <div class="input-group col-xs-2 pull-left">
            <span class="input-group-addon" style="background-color:white;border-radius: 0px;border-width:0px;">
                <i class="fa fa-filter"></i>
            </span>
            <input type="search"
                style="border-radius:0px;border-top-width: 0px;border-left-width: 0px;border-right-width: 0px"
                id="filter_to" class="form-control" placeholder="إلى تاريخ ..." />
        </div>

        <div class="input-group col-xs-2 pull-left">
            <span class="input-group-addon" style="background-color:white;border-radius: 0px;border-width:0px;">
                <i class="fa fa-filter"></i>
            </span>
            <input type="search"
                style="border-radius:0px;border-top-width: 0px;border-left-width: 0px;border-right-width: 0px"
                id="filter_from" class="form-control" placeholder="من تاريخ ..." />
        </div>

        <br />
        <br />
        <div class="col-xs-12" style="margin:0px;">
            <table id="events_table" class='table table-bordered' style="margin-bottom: 0px !important;">
                <thead>
                    <tr align='center' style='background-color: #0c5460;color:white'>
                        <td> متسلسل # </td>
                        <td> الفعالية </td>
                        <td> نوع الفعالية </td>
                        <td> تصنيف الفعالية </td>
                        <td> الجهة المنظمة </td>
                        <td> موقع الفعالية </td>
                        <td> عدد الحضور المتوقع </td>
                        <td> عدد أفراد الشرطة </td>
                        <td> التاريخ </td>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    </div>

<!-- <div class="col-xs-10 well" id="past_transactions_table" style="min-height:81.5%;margin-top:130px;background-color:white;"> </div> -->

    <input id="num_pages" value="<?php echo $pages; ?>" hidden />

    <!-- Modal -->
    <div class="modal fade" style="border-radius: 10%;" id="ReportModal" role="dialog">
        <div style="border-radius: 10%;" class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content" style="border-radius: 10px;">

                <div class="modal-header">
                    <h4 class="modal-title" align="center"> طباعة تقرير عن المعاملات في فترة زمنية </h4>
                </div>

                <div class="modal-body" dir="rtl">
                    <br />
                    <br />
                    <form class="form-inline" method="get" action="../REPORTS/TransInPeriod.php" id="report_form">
                        <table class="table table-striped">
                            <tr>
                                <td><label> من </label></td>
                                <td><input required type="text" class="form-control" id="from_date" name="from_date" />
                                </td>
                                <td><label> إلى </label></td>
                                <td><input required type="text" class="form-control" id="to_date" name="to_date" /></td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning pull-left" data-dismiss="modal"><i
                            class="fa fa-window-close"></i> إغلاق </button>
                    <button type="submit" form="report_form" class="btn btn-success pull-left"><i
                            class="fa fa-print"></i> طباعة </button>
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
                    <br />
                    <div class="input-group col-xs-12">
                        <span class="input-group-addon"
                            style="background-color:white;border-radius: 0px;border-width:0px;">
                            <i class="fa fa-filter"></i>
                        </span>
                        <input type="search" id="lands_search_txt" dir="ltr" class="text-center  form-control"
                            placeholder=" ... رقم القطعة  " />
                    </div>
                </div>

                <div class="modal-body" style="height:400px;overflow:scroll" dir="rtl">

                    <form class="form-inline" method="get" action="#" id="LandTransReportForm">
                        <div id="ModalLandsData">

                        </div>
                        <input required type="text" id="event_no" name="event_no" hidden />
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-warning pull-left" data-dismiss="modal"><i
                            class="fa fa-window-close"></i> إغلاق </button>
                    <button type="submit" form="LandTransReportForm" class="btn btn-success pull-left"><i
                            class="fa fa-print"></i> طباعة </button>
                </div>

            </div>

        </div>
    </div>

    <!-- End Of Modal -->

</body>

</html>

<script>
$(document).ready(function() {


    var pages = $("#num_pages").val();
    var start = 1;
    var end;

    fillPages(start);

    $(document).on('click', '.pagination-link', function(e) {
        var link = $(this).attr('id');
        if (link == 'prev_set') {
            if (start != 1) {
                fillPages(start - 5);
            }
        } else if (link == 'next_set') {
            if (end != pages) {
                fillPages(end + 1);
            }
        }
        else {
            var filter_from = $("#filter_from").val();
            var filter_to = $("#filter_to").val();
            $.ajax({
                url: "../MODEL/fetch_events.php",
                method: "POST",
                data: {
                    filter_from: filter_from,
                    filter_to: filter_to,
                    limit: 20,
                    start: (link - 1) * 20
                },
                success: function(data) {
                    $("#events_table tbody").html(data);
                }
            });
        }

    })


    function fillPages(astart) {
        start = astart;

        $("#pages").html('<li id="prev_set" class="pagination-link">' +
            '<a aria-label="السابق" href="#">' +
            '<span aria-hidden="true"> <i class="fa fa-long-arrow-left"></i>  </span>' +
            '</a></li>');

        for (var i = start; i <= pages; i++) {

            $("#pages").html($("#pages").html() + "<li class='pagination-link' id='" + i + "'><a href='#'>" +
                i + "</a></li>");
            end = i;
            if (i == (start + 4))
                break;

        }


        $("#pages").html($("#pages").html() + '<li id="next_set" class="pagination-link">' +
            '<a aria-label="التالي" href="#">' +
            '<span aria-hidden="true"><i class="fa fa-long-arrow-right"></i> </span>' +
            '</a></li>');
    }

});
</script>



<script>
$(document).ready(function() {
    $.datepicker.setDefaults({
        changeYear: true,
        changeMonth: true,
        dateFormat: 'yy-mm-dd'
    });

    $("#filter_from, #filter_to, #from_date, #to_date").datepicker();

    $.ajax({
        url: "../MODEL/fetch_events.php",
        method: "POST",
        data: {
            start: 0,
            limit: 20
        },
        success: function(data) {
            $("#events_table tbody").html(data);
        }
    });

    $(document).on('click', '.event-row', function(e) {
        window.location = "edit_event.php?ID=" + $(this).attr("id");
    });

    $(document).on('click', '.event-row', function(e) {
        $(".event-row").css("background-color", "white");
        $(".event-row:hover").css("background-color", "#1b6d85");
        $(".event-row:hover").css("color", "#ffffff");

        $("#event_no").val($(this).attr("id"));

        $(this).css("background-color", "#2a62bc");
    });

    $("#filter_from").change(function() {
        var filter_from = $("#filter_from").val();
        var filter_to = $("#filter_to").val();

        $.ajax({
            url: "../MODEL/fetch_events.php",
            method: "POST",
            data: {
                filter_from: filter_from,
                filter_to: filter_to,
                start: 0,
                limit: 20
            },
            success: function(data) {
                $("#events_table tbody").html(data);
            }
        });

    });

    $("#filter_to").change(function() {
        var filter_from = $("#filter_from").val();
        var filter_to = $("#filter_to").val();

        $.ajax({
            url: "../MODEL/fetch_events.php",
            method: "POST",
            data: {
                filter_from: filter_from,
                filter_to: filter_to,
                start: 0,
                limit: 20
            },
            success: function(data) {
                $("#events_table tbody").html(data);
            }
        });
    });

    $(document).on('click', '.generate-pdf', function () {
        window.location = "../REPORTS/event.php?id=" + $(this).attr('data-event-iid');
    });

    /*
    $.ajax({
        url: "../MODEL/modal_fetch_lands.php",
        method: "POST",
        success: function(data) {
            $("#ModalLandsData").html(data);
        }
    });

    $("#lands_search_txt").keyup(function(e) {
        var txt = $("#lands_search_txt").val();
        $.ajax({
            url: "../MODEL/modal_fetch_lands.php",
            method: "POST",
            data: {
                txt: txt
            },
            success: function(data) {
                $("#ModalLandsData").html(data);
            }
        });
    });
    
    $("#print_transactions_in_period").click(function() {
        $("#ReportModal").modal({
            backdrop: 'static',
            keyboard: false
        });
        $("#ReportModal").modal("show");
    });
    
    $("#print_transactions_for_land").click(function() {
        $("#LandTransReportModal").modal({
            backdrop: 'static',
            keyboard: false
        });
        $("#LandTransReportModal").modal("show");
    });
    
    $.ajax({
        url: "../MODEL/fetch_transactions.php",
        method: "POST",
        data: {
            start: 0,
            limit: 20
        },
        success: function(data) {
            $("#past_transactions_table").html(data);
        }
    });
    
    $("#LandTransReportForm").submit(function(e) {
        e.preventDefault();
        var params = $("#event_no").val();
        var url = "../REPORTS/TransForLand.php?" + params;
        window.location = url;
    });
    
    $("#transaction_no").change(function() {
 
        var filter_from = $("#filter_from").val();
        var filter_to = $("#filter_to").val();
        var trans_no = $("#transaction_no").val();
 
        $.ajax({
            url: "../MODEL/fetch_transactions.php",
            method: "POST",
            data: {
                filter_from: filter_from,
                filter_to: filter_to,
                start: 0,
                limit: 20,
                trans_no: trans_no
            },
            success: function(data) {
                $("#past_transactions_table").html(data);
            }
        });
    });
    */
    


});
</script>