<?php
session_start();

if (!isset($_SESSION['USER_NO'])) {
    header("location:login.php");
}

if ($_SESSION['PRIVILEGE'] != 1) {
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

<body dir="rtl" style="font-family: 'Droid Arabic Naskh', serif">
    <div class="col-xs-2 navbar-fixed-top pull-right" style="background-color:black;min-height: 100%;">

        <ul style="margin-top: 55px;" class="nav nav-pills nav-stacked col-md-12">
            <?php include "navigation.php" ?>
        </ul>

    </div>



    <div class="col-md-12 navbar-fixed-top" style="height:55px;background-color: #1b5e20 ;padding-left: 0px;">
        <a class="col-xs-9 pull-right" style="cursor:pointer;">
            <p class="col-xs-12 pull-right" style="margin-top:0.5%;color:white;font-size:x-large"><b> <i class="fa fa-gears"></i> لوحة التحكم </b></p>
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
                    <p size="4" color="black"> <i class="fa fa-dashboard"></i> لوحة المعلومات </p>
                </a></li>
            <li><a href="#tab2" data-toggle="tab">
                    <p size="4" color="black"> <i class="fa fa-hdd-o"></i> النسخ والإسترجاع </p>
                </a></li>
            <li><a id="Users" href="#tab3" data-toggle="tab">
                    <p size="4" color="black"> <i class="fa fa-users"></i> المستخدمين والصلاحيات </p>
                </a></li>

        </ul>

    </div>



    <!-- Modal -->
    <div class="modal fade" style="border-radius: 0px;" id="UserModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content" style="border-radius: 0px;">

                <h4 class="modal-title" id="user_modal_title" align="center"></h4>

                <div class="modal-body" dir="rtl">
                    <br />
                    <br />
                    <form class="form-inline" id="users_form">
                        <table class="table table-responsive">
                            <tr>
                                <td>
                                    <label>الإسم</label>
                                </td>
                                <td>
                                    <input type="text" required class="form-control text-center" id="full_name" name="full_name" autocomplete="off" />
                                </td>
                                <td>
                                    <label>إسم المستخدم (للتعريف)</label>
                                </td>
                                <td>
                                    <input type="text" required class="form-control text-center" id="user_name" name="user_name" autocomplete="off" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>كلمة المرور</label>
                                </td>
                                <td>
                                    <input required type="text" required class="form-control text-center" id="password" name="password" autocomplete="off" />
                                </td>
                                <td>
                                    <label>درجة الصلاحية</label>
                                </td>
                                <td>

                                    <select id="privilege" name="privilege" class="form-control text-center">
                                        <option value="1"> كامل الصلاحيات (آدمن) </option>
                                        <option value="2"> مشرف أرشيف </option>
                                        <option value="3"> موظف أرشيف </option>
                                        <option value="4"> إستعلامات وتقارير </option>
                                        <option value="5"> أمين الأرشيف </option>
                                    </select>

                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>نشط ؟</label>
                                </td>
                                <td>
                                    <input checked type="radio" id="active" name="active" value="1">
                                    <label>نشط</label>
                                    <input type="radio" id="inactive" name="active" value="0">
                                    <label>غير نشط</label>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-warning pull-left" data-dismiss="modal">إغلاق</button>
                    <button type="submit" form="users_form" class="btn btn-primary pull-left" id="user_submit"><i class="fa fa-save"></i> حفظ </button>
                    <button type="button" form="users_form" class="btn btn-success pull-left" id="user_update"><i class="fa fa-edit"></i> حفظ التعديلات </button>

                </div>
            </div>

        </div>
    </div>

    <!-- End Of Modal -->


    <div class="col-xs-10" style="min-height:93%;margin-top:50px;background-color:whitesmoke;">

        <div id="my-tab-content" style="margin-top:80px;" class="tab-content">

            <div class="tab-pane active" id="tab1">

                <div style="cursor: pointer;margin:10px;box-shadow: 1px 1px 1px 1px lightgrey;background-color:white;" class="col-xs-3 pull-right">
                    <h1 align="center"><i class="fa fa-server"></i></h1>
                    <h6 align="center"> تفاصيل خادم الملفات </h6>
                    <hr>
                    <h6 align="center" style="color:darkgreen;">

                    </h6>
                </div>


                <div style="cursor: pointer;margin:10px;box-shadow: 1px 1px 1px 1px lightgrey;background-color:white;" class="col-xs-3 pull-right">
                    <h1 align="center"><i class="fa fa-users"></i></h1>
                    <h6 align="center"> عدد المستخدمين النشطين </h6>
                    <hr>
                    <h6 align="center" style="color:darkgreen;">
                        <?php
                        $query = "SELECT COUNT(*) AS USERS FROM T_USERS WHERE ACTIVE = TRUE";
                        $result = mysqli_query($connect, $query);
                        $row = mysqli_fetch_array($result);
                        echo $row['USERS'];
                        ?>
                        مستخدم.
                    </h6>
                    <br />
                    <hr>
                    <h6 align="center">
                        <a onclick="document.getElementById('Users').click();"> إدارة المستخدمين </a>
                    </h6>
                    <br />
                </div>


                <div style="cursor: pointer;margin:10px;box-shadow: 1px 1px 1px 1px lightgrey;background-color:white;" class="col-xs-3 pull-right">
                    <h1 align="center"><i class="fa fa-database"></i></h1>
                    <h6 align="center"> إجمالي حجم المستندات المخزنة </h6>
                    <hr>
                    <h6 align="center" style="color:darkgreen;">
                        <?php
                        function folderSize($dir)
                        {
                            $size = 0;
                            foreach (glob(rtrim($dir, '/') . '/*', GLOB_NOSORT) as $each) {
                                $size += is_file($each) ? filesize($each) : folderSize($each);
                            }
                            return $size;
                        }

                        echo round(folderSize("../IMAGES") / 1000 / 1000, 2);
                        ?>
                        ميقابايت.
                    </h6>
                    <br />
                </div>


                <div style="cursor: pointer;margin:10px;box-shadow: 1px 1px 1px 1px lightgrey;background-color:white;" class="col-xs-2 pull-right">
                    <h1 align="center"><i class="fa fa-globe"></i></h1>
                    <h6 align="center"> عدد الأراضي المسجلة </h6>
                    <hr>
                    <h6 align="center" style="color:darkgreen;">
                        <?php
                        $query = "SELECT COUNT(*) AS LANDS FROM T_LANDS";
                        $result = mysqli_query($connect, $query);
                        $row = mysqli_fetch_array($result);
                        echo $row['LANDS'];
                        ?>
                        قطعة
                    </h6>
                </div>

                <div style="cursor: pointer;margin:10px;box-shadow: 1px 1px 1px 1px lightgrey;background-color:white;" class="col-xs-3 pull-right">
                    <h1 align="center"><i class="fa fa-file"></i></h1>
                    <h6 align="center"> عدد المستندات المخزنة </h6>
                    <hr>
                    <h6 align="center" style="color:darkgreen;">
                        <?php
                        $query = "SELECT COUNT(*) AS DOCS FROM T_DOCS";
                        $result = mysqli_query($connect, $query);
                        $row = mysqli_fetch_array($result);
                        echo $row['DOCS'];
                        ?>
                        مستند.
                    </h6>
                </div>





            </div>


            <!--------------------------------------------------------------------------------->


            <div class="tab-pane" id="tab2">
                <div class="col-xs-12">
                    <a href="../MODEL/backup.php" type="button" class="btn btn-default col-xs-4 pull-right"><img class="img-responsive" src="../ASSETS/backup.png" /> نسخ مستندات وبيانات الأراضي </a>
                    <div class="col-xs-8">
                        <label> إسترجاع البيانات من ملف إحتياطي </label>
                        <input type="file" class="form-control" id="backup_file" name="backup_file" />
                        <br />
                        <button type="button" class="btn btn-primary btn-block" disabled id="restore"> بدء عملية الإسترجاع <i class="fa fa-play-circle-o fa-lg"></i></button>
                    </div>
                </div>
            </div>

            <!--------------------------------------------------------------------------------->

            <div class="tab-pane" id="tab3">
                <button style="margin-bottom:20px;left:20px;" id="add_user" class="btn btn-success pull-left"><i class="fa fa-plus"></i> إضافة مستخدم </button>
                <div class="col-xs-12 pull-right" style="height:460px;overflow:scroll;background-color:white;" id="users_table">

                </div>
            </div>


            <!--------------------------------------------------------------------------------->

        </div>
    </div>

</body>

</html>
<script>
    $(document).ready(function() {

        var user_no = '';
        $("#user_update").hide();

        $(document).on('click', '.user-row', function(e) {

            var id = $(this).attr("id");
            user_no = id;
            $.ajax({

                url: "../MODEL/fetch_user_data.php",
                method: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    $("#users_form").html(data);
                }

            });

            $("#user_modal_title").html(" بيانات مستخدم ");
            $("#user_submit").hide();
            $("#user_update").show();
            $("#UserModal").modal("show");

        });

        $(document).on('click', '#add_user', function(e) {

            var full_name = $("#full_name").val('');
            var user_name = $("#user_name").val('');
            var password = $("#password").val('');
            var privilege = $("#privilege").val(1);
            var active = $("#active").val();

            $("#user_modal_title").html(" إضافة مستخدم جديد ");
            $("#user_submit").show();
            $("#user_update").hide();
            $("#UserModal").modal("show");

        });


        $("#user_update").click(function() {

            var full_name = $("#full_name").val();
            var user_name = $("#user_name").val();
            var password = $("#password").val();
            var privilege = $("#privilege").val();
            var active = $("input[name=active]:checked").val();

            $.ajax({
                url: "../MODEL/update_user.php",
                method: "POST",
                data: {
                    full_name: full_name,
                    user_name: user_name,
                    user_no: user_no,
                    active: active,
                    privilege: privilege,
                    password: password
                },
                success: function(data) {
                    $.ajax({
                        url: "../MODEL/fetch_users.php",
                        method: "POST",
                        success: function(data) {

                            $("#users_table").html(data);
                            $("#UserModal").modal("hide");

                        }
                    });
                }
            });

        });

        $("#users_form").submit(function(e) {

            e.preventDefault();

            $.ajax({
                url: "../MODEL/insert_user.php",
                method: "POST",
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(data) {
                    $("#users_form")[0].reset();
                    $("#UserModal").modal("hide");

                    $.ajax({
                        url: "../MODEL/fetch_users.php",
                        method: "POST",
                        success: function(data) {

                            $("#users_table").html(data);

                        }
                    });
                }
            });

        });

        $.ajax({
            url: "../MODEL/fetch_users.php",
            method: "POST",
            success: function(data) {
                $("#users_table").html(data);
            }
        });

    });
</script>