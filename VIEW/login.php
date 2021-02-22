<?php

session_start();

include "../MODEL/connect.php";

if (!mysqli_select_db($connect, "ARCHIVE")) {
    header("location:../MODEL/database.php");
}




if (isset($_SESSION['USER_NO'])) {
    header("location:../index.php");
}

?>
<!DOCTYPE html>
<html lang="ar">

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
    button,
    .btn {
        border-radius: 0px;
    }
</style>

<body dir="rtl" style="background-image: url('../ASSETS/IMAGES/dubai-police-bg.jpg');background-size: 100% 100%;">

    <br />
    <!-- <img src="../ASSETS/archive-icon-24.png" height="100" class="img center-block" />

    <h3 class="text-center"> نظام الأرشيف </h3> -->

    <br />
    <div class="col-lg-6"></div>
    <div class="container col-lg-4 align-items-center" align="center" dir="rtl">
        <h1 class="text-center"> إستمارة المعاينة 2021 </h1>
        <br />
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1 class="panel-title"><b> تسجيل الدخول <i class="fa fa-unlock-alt"></i> </b> </h1>
            </div>

            <div class="panel-body" dir="rtl">

                <form role="form" id="login-form" class="form-horizontal">
                    <div class="form-group has-success has-warning">
                        <label style="margin-bottom: 2rem;" class="control-label" for="username">الرقم العسكري</label>
                        <br />
                        <div class="col-xs-10 input-group">
                            <input autofocus type="text" id="username" class="form-control text-center" placeholder="الرقم العسكري" dir="ltr" style="border-radius: 0px" />
                            <span id="user_validation" style="border-radius:0px;" class="input-group-addon">

                            </span>
                        </div>
                    </div>
                    <div class="form-group has-success has-warning">
                        <label style="margin-bottom: 2rem;" class="control-label" for="password">كلمة المرور</label>
                        <br />
                        <div class="col-xs-10 input-group">

                            <input type="password" id="password" class="form-control text-center" placeholder="كلمة المرور" dir="ltr" style="border-radius: 0px" />
                            <span id="pass_validation" style="border-radius:0px;" class="input-group-addon">

                            </span>
                        </div>
                    </div>
                    <div class="col-xs-12 text-danger" id="invalid_cred">

                    </div>
                    <br />
                    <br />
                    <br />
                    <div class="form-group">
                        <div class="col-xs-1"></div>
                        <button type="submit" style="border-top-right-radius: 10px;border-bottom-left-radius: 10px;margin-right:5px;" id="sign-in" class="btn btn-success col-xs-10 btn-lg"> تسجيل الدخول <i class="fa fa-sign-in"></i> </button>
                        <div class="col-xs-1"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>


</body>

</html>

<script>
    $(document).ready(function() {

        $("#username").focus();
        $("#user_validation").hide();
        $("#pass_validation").hide();
        $("#login-form").submit(function(e) {
            e.preventDefault();
            var username = $("#username").val();
            var password = $("#password").val();

            if ($.trim(username).length > 0 && $.trim(password).length > 0) {

                $("#user_validation").hide();
                $("#pass_validation").hide();
                $.ajax({
                    url: "../MODEL/login_script.php",
                    method: "POST",
                    data: {
                        username: username,
                        password: password
                    },
                    beforeSend: function() {
                        $("#sign-in").html("جاري تسجيل الدخول .....");
                    },
                    success: function(data)

                    {

                        if (data == 'GRANTED') {

                            window.location = "../index.php";

                        } else if (data == 'INACTIVE') {

                            alertify.defaults.glossary.title = '<h6>  تنبيه ! </h6>';
                            alertify.defaults.glossary.ok = 'حسناً';
                            alertify.alert("<h4 style='color:red;font-size:large;'>  هذا الحساب غير نشط الرجاء مراجعة الآدمن  <i class='fa fa-info'></i> </h4>");

                            $("#invalid_cred").html("<h3> حساب غير نشط  <i class='fa fa-hand-stop-o'></i> </h3>");
                            $("#sign-in").html(' تسجيل الدخول <i class="fa fa-sign-in"></i> ');

                        } else {

                            $("#invalid_cred").html("<h3>  خطأ في إسم المستخدم أو كلمة المرور  <i class='fa fa-warning'></i></h3>");
                            $("#sign-in").html(' تسجيل الدخول <i class="fa fa-sign-in"></i> ');

                        }

                    }

                });
            } else {
                $("#user_validation").hide();
                if ($.trim(username).length == 0) {

                    $("#pass_validation").hide();
                    $("#user_validation").show();
                    $("#user_validation").html("<i class='fa fa-warning' style='font-size:large;color:red;'></i>");
                }

                if ($.trim(password).length == 0) {


                    $("#pass_validation").show();
                    $("#pass_validation").html("<i class='fa fa-warning' style='font-size:large;color:red;'></i>");
                }


            }

        });
    });
</script>