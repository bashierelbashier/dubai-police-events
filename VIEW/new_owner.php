<?php

session_start();

if (!isset($_SESSION['USER_NO']))
{
    header("location:login.php");
}

if ($_SESSION['PRIVILEGE']!=1&&$_SESSION['PRIVILEGE']!=2)
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
    html,body
    {
        height: 100%;
    }
</style>
<body style="font-family: 'Droid Arabic Naskh', serif">
<div class="col-xs-2 navbar-fixed-top pull-right" style="background-color:black;min-height: 100%;">

    <ul style="margin-top: 55px;" class="nav nav-pills nav-stacked col-md-12">
        <?php include "navigation.php"?>
    </ul>

</div>


<div class="col-md-12 navbar-fixed-top" style="height:55px;padding-left:0px;background-color: #1b5e20;">

    <a style="cursor:pointer;" class="col-xs-9 pull-right"><p class="col-xs-12 pull-right" id="lands" style="margin-top:0.5%;color:white;font-size:x-large"><b> أصحاب الأراضي <i class="fa fa-arrow-left"></i> جديد </b></p></a>

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
    <a href="owners.php"><button style="margin-top: 20px;margin-right:5px;" class="btn btn-default col-xs-2 pull-right"><i class="fa fa-long-arrow-right"></i> رجوع </button></a>
    <button type="submit" form="owner_form" style="margin-top: 20px;margin-right:5px;" class="btn btn-success col-xs-2 pull-right"><i class="fa fa-save"></i> حفظ </button>
    <br/>
    <br/>

</div>

</div>

<div class="col-xs-10" style="min-height:81.5%;margin-top:125px;background-image: url('../ASSETS/form_sheetbg.png');">
    <br/>

    <div class="panel panel-default" style="border-radius: 0px;box-shadow: 1px 1px 1px 1px darkgrey;">
        <div class="panel-heading">
            <h1 class="panel-title" align="center"> بيانات مالك جديد </h1>
        </div>
        <div class="panel-body">
            <form id="owner_form" name="owner_form">
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
        <div class="panel-footer">
        </div>
    </div>

</div>


</body>
</html>
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
                        swal({
                            title : "تم !",
                            text : "تم حفظ البيانات بنجاح",
                            type : "success",
                            confirmButtonColor : "skyblue",
                            confirmButtonText : "حسنا"
                        }).then(function(){
                            window.location="owners.php";
                        });

                    }else
                    {
                        swal("لم يتم حفظ البيانات ! الرجاء التحقق من صحتها");
                    }
                }
            });
        });



    });
</script>
