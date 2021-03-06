<?php
session_start();

if (!isset($_SESSION['USER_NO'])) {
    header("location:VIEW/login.php");
}

if ($_SESSION['PRIVILEGE'] != 1) {
    header("location:VIEW/events.php");
}


?>
<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>

    <meta charset="utf-8" />
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <title style="font-family: 'Droid Arabic Kufi', serif">System</title>
    <script src="ASSETS/SCANNER/jquery-1.js"></script> <!-- optional -->
    <script src="ASSETS/SCANNER/jquery-migrate-1.js"></script>
    <link href="ASSETS/CSS/bootstrap.min.css" rel="stylesheet"> <!-- optional -->
    <link href="ASSETS/CSS/static/css/odoo.css" rel="stylesheet"> <!-- optional -->
    <link href="ASSETS/CSS/css/font-awesome.min.css" rel="stylesheet"> <!-- optional -->
    <link href="ASSETS/CSS/sweetalert2.min.css" rel="stylesheet"> <!-- optional -->
    <link href="ASSETS/CSS/jquery-ui.min.css" rel="stylesheet"> <!-- optional -->
    <script src="ASSETS/SCANNER/jquery-ui.min.js"></script> <!-- optional -->
    <script src="ASSETS/SCANNER/bootstrap.min.js"></script> <!-- optional -->
    <script src="ASSETS/SCANNER/sweetalert2.min.js"></script> <!-- optional -->
    <script src="ASSETS/CHARTS/Chart.min.js"></script>
    <link rel="stylesheet" hre="ASSETS/CHARTS/Chart.min.css" />
    <link rel="stylesheet" href="ASSETS/CSS/mystyle.css">

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

<body>

    <div class="col-xs-2 navbar-fixed-top pull-right" style="background-color:black;min-height: 100%;">

        <ul style="margin-top: 55px;" class="nav nav-pills nav-stacked col-md-12">

            <?php
            if ($_SESSION['PRIVILEGE'] == 1)
                echo '<li><a href="#"><i class="fa fa-dashboard"></i> لوحة المعلومات </a></li>
                <li><a href="VIEW/events.php"><i class="fa fa-list"></i> قائمة الفعاليات </a></li>
                <li><a href="VIEW/new_event.php"><i class="fa fa-plus"></i> إضافة فعاليه </a></li>
                <li><a href="VIEW/control_panel.php"><i class="fa fa-gears"></i> لوحة التحكم </a></li>';
            else if ($_SESSION['PRIVILEGE'] == 2)
                echo '<li><a href="#"><i class="fa fa-dashboard"></i> لوحة المعلومات </a></li>
                <li><a href="VIEW/events.php"><i class="fa fa-list"></i> قائمة الفعاليات </a></li>
                <li><a href="VIEW/new_event.php"><i class="fa fa-plus"></i> إضافة فعاليه </a></li>';
            ?>
        </ul>

    </div>

    <div class="col-md-12 navbar-fixed-top" style="height:55px;background-color: #1b5e20 ;padding-left: 0px;">
        <a class="col-xs-9 pull-right" style="cursor:pointer;">
            <p class="col-xs-12 pull-right" id="classes" style="margin-top:0.5%;color:white;font-size:x-large"><b>
                    <i class="fa fa-dashboard"></i> لوحة المعلومات </b></p>
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
                <li style="margin-top: 3px;">
                    <a href="MODEL/logout.php">
                        <p class="text-center" style="color:#6a6a6a;color:#1b5e20;"> <i class="fa fa-lock"></i> تسجيل
                            الخروج </p>
                    </a>
                </li>
            </ul>
        </div>

    </div>




    <div class="col-xs-10 navbar-fixed-top pull-right"
        style="padding-top:2px;margin-right: 16.7%;height:70px;border-bottom-style: outset;border-bottom-width: 1px;border-bottom-color: lightgray;  background-color: #ffffff;margin-top:55px; ">
        <img src="ASSETS/IMAGES/image.png" style="width: 100%;height:100%;" />
    </div>



    <div class="col-xs-10" id="home_view" style="padding:2px;min-height:81.5%;margin-top:125px;background-color:white;">

        <div style="margin-bottom: 20px; width: 50%;" class="col-md-6 pull-right"><canvas id="pie-chart-q1"></canvas></div>
        <div style="margin-bottom: 20px; width: 50%;" class="col-md-6 pull-right"><canvas id="pie-chart-q2"></canvas></div>
        <div style="width: 50%;" class="col-md-6 pull-right"><canvas id="pie-chart-q3"></canvas></div>
        <div style="width: 50%;" class="col-md-6 pull-right"><canvas id="pie-chart-q4"></canvas></div>

    </div>

</body>

</html>

<script>
$(document).ready(function() {
    $.ajax({
        url: 'MODEL/events_stats.php',
        method: 'POST',
        dataType: 'json',
        success: function (data) {
            let q1_data, q2_data, q3_data, q4_data = {};
            const legend = {
                rtl : true,
                borderWidth: 3,
                labels: {
                    fontSize: 13,
                    fontFamily: 'Droid Arabic Kufi'
                }
            };
            const title = {
                display: true,
                padding: 0,
                fontSize: 15,
                fontFamily: 'Droid Arabic Kufi'
            };

            if (data.q1_labels.length > 0 && data.q1_stats.length > 0) {
                q1_data = {
                    datasets: [{
                        backgroundColor: ["#3e95cd", "#8e5ea2", "#3cba9f", "#e8c3b9", "#c45850"],
                        data: data.q1_stats,
                    }],
                    labels: data.q1_labels
                };
            }
            else {
                q1_data = {
                    labels: ['لا توجد بيانات'],
                    datasets: [{
                        labels:'لا توجد بيانات',
                        backgroundColor: ['#D3D3D3'],
                        data: [100]
                    }]
                };
            }

            const q1_chart = new Chart(document.getElementById("pie-chart-q1"), {
                type: 'pie',
                data: q1_data,
                options: {
                    responsive: true,
                    legend: legend,
                    title: title,
                    tooltip: {
                        enabled: false
                    }
                }
            });

            q1_chart.options.title.text = 'إحصائية فعاليات الربع الأول';

            if (data.q2_labels.length > 0 && data.q2_stats.length > 0) {
                q2_data = {
                    datasets: [{
                        backgroundColor: ["#3e95cd", "#8e5ea2", "#3cba9f", "#e8c3b9", "#c45850"],
                        data: data.q2_stats
                    }],
                    labels: data.q2_labels
                };
            }
            else {
                q2_data = {
                    labels: ['لا توجد بيانات'],
                    datasets: [{
                        labels:'لا توجد بيانات',
                        backgroundColor: ['#D3D3D3'],
                        data: [100]
                    }]
                };
            }
            var q2_chart = new Chart(document.getElementById("pie-chart-q2"), {
                type: 'pie',
                data: q2_data,
                options: {
                    responsive: true,
                    legend: legend,
                    title: title
                }
            });

            q2_chart.options.title.text = 'إحصائية فعاليات الربع الثاني';
            
            if (data.q3_labels.length > 0 && data.q3_stats) {
                q3_data = {
                    datasets: [{
                        backgroundColor: ["#3e95cd", "#8e5ea2", "#3cba9f", "#e8c3b9", "#c45850"],
                        data: data.q3_stats
                    }],
                    labels: data.q3_labels
                };
            }
            else {
                q3_data = {
                    labels: ['لا توجد بيانات'],
                    datasets: [{
                        labels:'لا توجد بيانات',
                        backgroundColor: ['#D3D3D3'],
                        data: [100]
                    }]
                };
            }
            var q3_chart = new Chart(document.getElementById("pie-chart-q3"), {
                type: 'pie',
                data: q3_data,
                options: {
                    responsive: true,
                    legend: legend,
                    title: title
                }
            });

            q3_chart.options.title.text = 'إحصائية فعاليات الربع الثالث';

            if (data.q4_labels.length > 0 && data.q4_stats.length > 0) {
                q4_data = {
                    datasets: [{
                        backgroundColor: ["#3e95cd", "#8e5ea2", "#3cba9f", "#e8c3b9", "#c45850"],
                        data: data.q4_stats
                    }],
                    labels: data.q4_labels
                };
            }
            else {
                q4_data = {
                    labels: ['لا توجد بيانات'],
                    datasets: [{
                        labels:'لا توجد بيانات',
                        backgroundColor: ['#D3D3D3'],
                        data: [100]
                    }]
                };
            }
            var q4_chart = new Chart(document.getElementById("pie-chart-q4"), {
                type: 'pie',
                data: q4_data,
                options: {
                    responsive: true,
                    legend: legend,
                    title: title
                }
            });

            q4_chart.options.title.text = 'إحصائية فعاليات الربع الرابع';
        }
    });

});
</script>