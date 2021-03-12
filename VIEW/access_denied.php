<?php
session_start();

if (!isset($_SESSION['USER_NO'])) {
    header("location:login.php");
}

?>

<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <title>System</title>

    <link href="../ASSETS/CSS/bootstrap.min.css" rel="stylesheet"> <!-- optional -->
    <link href="../ASSETS/CSS/css/font-awesome.min.css" rel="stylesheet"> <!-- optional -->
    <link rel="stylesheet" href="../ASSETS/CSS/mystyle.css">

</head>

<body>
    <br />
    <br />
    <br />
    <br />
    <button class="btn btn-default center-block" style="font-size:large;color:red;" onclick="history.back()"><i
            class="fa fa-hand-o-right"></i> عودة </button>
    <br />
    <br />
    <br />
    <br />
    <br />
    <div class="container col-lg-12" align="center" style="background-color: ghostwhite;
border-color: red;border-width:3px;border-radius: 0px;border-style: outset;">
        <span class="text-danger">
            <h1><i class="fa fa-lock"></i> <i class="fa fa-user-times"></i></h1>
        </span>
        <span class="text-danger">
            <h3> You Don't Have Permission To Reach Requested Destination. </h3>
        </span>
        <span class="text-danger">
            <h3> ليست لديك الصلاحية للوصول إلى الوجهة المطلوبة. </h3>
        </span>
        <br />
    </div>
</body>

</html>