<?php
session_start();

if (!isset($_SESSION['USER_NO'])) {
    header("location:VIEW/login.php");
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
                echo '<li><a href="#"><i class="fa fa-home"></i> الرئيسية </a></li>
        <li><a href="VIEW/lands.php"><i class="fa fa-map"></i> الأراضي </a></li>
        <li><a href="VIEW/owners.php"><i class="fa fa-male"></i> أصحاب الأراضي  </a></li>
        <li><a href="VIEW/transactions.php"><i class="fa fa-exchange"></i> المعاملات </a></li>
        <li><a href="VIEW/reports.php"><i class="fa fa-file-pdf-o"></i> التقارير </a></li>
        <li><a href="VIEW/control_panel.php"><i class="fa fa-gears"></i> لوحة التحكم </a></li>
        <li><a href="VIEW/base_data.php"><i class="fa fa-database"></i> البيانات المرجعية </a></li>';
            else if ($_SESSION['PRIVILEGE'] == 2)
                echo '<li><a href="#"><i class="fa fa-home"></i> الرئيسية </a></li>
        <li><a href="VIEW/lands.php"><i class="fa fa-map"></i> الأراضي </a></li>
        <li><a href="VIEW/owners.php"><i class="fa fa-male"></i> أصحاب الأراضي  </a></li>
        <li><a href="VIEW/transactions.php"><i class="fa fa-exchange"></i> المعاملات </a></li>
        <li><a href="VIEW/reports.php"><i class="fa fa-file-pdf-o"></i> التقارير </a></li>
        <li><a href="VIEW/base_data.php"><i class="fa fa-database"></i> البيانات المرجعية </a></li>';
            else if ($_SESSION['PRIVILEGE'] == 3)
                echo '<li><a href="#"><i class="fa fa-home"></i> الرئيسية </a></li>
        <li><a href="VIEW/lands.php"><i class="fa fa-map"></i> الأراضي </a></li>
        <li><a href="VIEW/transactions.php"><i class="fa fa-exchange"></i> المعاملات </a></li>
        <li><a href="VIEW/reports.php"><i class="fa fa-file-pdf-o"></i> التقارير </a></li>';
            else if ($_SESSION['PRIVILEGE'] == 4)
                echo '<li><a href="#"><i class="fa fa-home"></i> الرئيسية </a></li>
        <li><a href="VIEW/reports.php"><i class="fa fa-file-pdf-o"></i> التقارير </a></li>';
            else if ($_SESSION['PRIVILEGE'] == 5)
                echo '<li><a href="#"><i class="fa fa-home"></i> الرئيسية </a></li>
        <li><a href="VIEW/lands.php"><i class="fa fa-map"></i> الأراضي </a></li>';
            ?>

        </ul>

    </div>

    <div class="col-md-12 navbar-fixed-top" style="height:55px;background-color: #1b5e20 ;padding-left: 0px;">
        <a class="col-xs-9 pull-right" style="cursor:pointer;">
            <p class="col-xs-12 pull-right" id="classes" style="margin-top:0.5%;color:white;font-size:x-large"><b> <i class="fa fa-home"></i> الرئيسية </b></p>
        </a>

        <div style="position:relative;z-index: 999;">
            <button style="border-width:0px;height:55px;background-color: #1b5e20;" class="btn col-xs-3 btn-success pull-left dropdown-toggle" data-toggle="dropdown">

                <div>
                    <i style="margin: 5px;" class="fa fa-user-circle fa-lg"></i>
                    <?php echo "  " . $_SESSION['FULL_NAME'] . "  "; ?>
                </div>

            </button>

            <ul class="col-xs-3 dropdown-menu dropdown" style="margin:0px;border-radius:0px;">
                <li style="margin-top: 3px;">
                    <a href="MODEL/logout.php">
                        <p class="text-center" style="color:#6a6a6a;font-family: 'Droid Arabic Kufi', serif;font-size: medium;color:#1b5e20;"> <i class="fa fa-lock"></i> تسجيل الخروج </p>
                    </a>
                </li>
            </ul>
        </div>

    </div>




    <div class="col-xs-10 navbar-fixed-top pull-right" style="padding-top:2px;margin-right: 16.7%;height:70px;border-bottom-style: outset;border-bottom-width: 1px;border-bottom-color: lightgray;  background-color: #ffffff;margin-top:55px; ">
        <img src="ASSETS/logo.jpg" class="img col-xs-1 pull-left" height="60" />
        <img src="ASSETS/khartoum.jpg" class="img col-xs-1  pull-left" height="60" />
        <img src="ASSETS/logo.jpg" class="img col-xs-1 pull-left" height="60" />
        <img src="ASSETS/khartoum.jpg" class="img col-xs-1  pull-left" height="60" />
        <img src="ASSETS/logo.jpg" class="img col-xs-1 pull-left" height="60" />
        <img src="ASSETS/khartoum.jpg" class="img col-xs-1  pull-left" height="60" />
        <img src="ASSETS/logo.jpg" class="img col-xs-1 pull-left" height="60" />
        <img src="ASSETS/khartoum.jpg" class="img col-xs-1  pull-left" height="60" />
        <img src="ASSETS/logo.jpg" class="img col-xs-1 pull-left" height="60" />
        <img src="ASSETS/khartoum.jpg" class="img col-xs-1  pull-left" height="60" />
        <img src="ASSETS/logo.jpg" class="img col-xs-1 pull-left" height="60" />
        <img src="ASSETS/khartoum.jpg" class="img col-xs-1  pull-left" height="60" />
    </div>

    </div>

    <div class="col-xs-10" id="home_view" style="padding:2px;min-height:81.5%;margin-top:125px;background-color:white;">

        <?php

        if ($_SESSION['PRIVILEGE'] == 1 || $_SESSION['PRIVILEGE'] == 2)
            echo '<a href="VIEW/base_data.php">
        <div style="cursor: pointer;margin-top:5px;box-shadow: 1px 1px 1px 1px lightgrey;background-color:white;" class="col-xs-4 pull-right">

            <h1 class="col-xs-2 pull-right" align="center"><i class="fa fa-database"></i></h1>
            <h1 class="col-xs-10 pull-left" align="center"> البيانات المرجعية </h1>
            <br/>
            <br/>
            <hr>
            <span> البيانات التي يتم إستخدامها لوصف الأراضي و مكانها الجغرافي مثل (المربوعات والولايات والتصنيفات). </span>
            <br/>
            <br/>
        </div>
    </a>';

        if ($_SESSION['PRIVILEGE'] != 4)
            echo '<a href="VIEW/lands.php">
        <div style="cursor: pointer;margin-top:5px;box-shadow: 1px 1px 1px 1px lightgrey;background-color:white;" class="col-xs-4 pull-right">

            <h1 class="col-xs-2 pull-right" align="center"><i class="fa fa-map"></i></h1>
            <h1 class="col-xs-10 pull-left" align="center"> الاراضي </h1>
            <br/>
            <br/>
            <hr>
            <span> تسجيل بيانات الأراضي وأصحاب الأراضي و تخزين مستندات للأراضي وإجراء المعاملات عليها. </span>
            <br/>
            <br/>
        </div>
    </a>';

        if ($_SESSION['PRIVILEGE'] == 1 || $_SESSION['PRIVILEGE'] == 2)
            echo '
    <a href="VIEW/owners.php">
        <div style="cursor: pointer;margin-top:5px;box-shadow: 1px 1px 1px 1px lightgrey;background-color:white;" class="col-xs-4 pull-right">

            <h1 class="col-xs-2 pull-right" align="center"><i class="fa fa-male"></i></h1>
            <h1 class="col-xs-10 pull-left" align="center"> أصحاب الأراضي </h1>
            <br/>
            <br/>
            <hr>
            <span> تسجيل بيانات أصحاب الأراضي الشخصية. <br/></span>
            <br/>
            <br/>
        </div>
    </a>';


        if ($_SESSION['PRIVILEGE'] != 5)
            echo '
    <a href="VIEW/reports.php">
        <div style="cursor: pointer;margin-top:5px;box-shadow: 1px 1px 1px 1px lightgrey;background-color:white;" class="col-xs-4 pull-right">

            <h1 class="col-xs-2 pull-right" align="center"><i class="fa fa-file-pdf-o"></i></h1>
            <h1 class="col-xs-10 pull-left" align="center"> التقارير </h1>
            <br/>
            <br/>
            <hr>
            <span> تقارير عن الأراضي والمعاملات والأرشيف وتقارير إحصائية تفصيلية وعامة. </span>
            <br/>
            <br/>
        </div>
    </a>';

        if ($_SESSION['PRIVILEGE'] == 1)
            echo '
    <a href="VIEW/control_panel.php">
        <div style="cursor: pointer;margin-top:5px;box-shadow: 1px 1px 1px 1px lightgrey;background-color:white;" class="col-xs-4 pull-right">

            <h1 class="col-xs-2 pull-right" align="center"><i class="fa fa-gears"></i></h1>
            <h1 class="col-xs-10 pull-left" align="center"> لوحة التحكم </h1>
            <br/>
            <br/>
            <hr>
            <span> البيانات العامة الخاصة بالأراضي والمستندات وإدارة المستخدمين والنسخ الإحتياطي للبيانات. </span>
            <br/>
            <br/>
        </div>
    </a>';

        if ($_SESSION['PRIVILEGE'] != 4 && $_SESSION['PRIVILEGE'] != 5)
            echo '
    <a href="VIEW/transactions.php">
        <div style="cursor: pointer;margin-top:5px;box-shadow: 1px 1px 1px 1px lightgrey;background-color:white;" class="col-xs-4 pull-right">

            <h1 class="col-xs-2 pull-right" align="center"><i class="fa fa-exchange"></i></h1>
            <h1 class="col-xs-10 pull-left" align="center"> المعاملات </h1>
            <br/>
            <br/>
            <hr>
            <span> المعاملات التي تمت على الأراضي والتقارير المتعلقة بها وتعديلها. </span>
            <br/>
            <br/>
        </div>
    </a>';

        ?>

    </div>

</body>

</html>

<script>
    $(document).ready(function() {

    });
</script>