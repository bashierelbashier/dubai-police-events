<?php

session_start();

if (!isset($_SESSION['USER_NO']))
{
    header("location:login.php");
}

if ($_SESSION['PRIVILEGE']==4||$_SESSION['PRIVILEGE']==5)
    header("location:access_denied.php");




include "../MODEL/connect.php";

$id = $_GET["TRANS_ID"];

$sql = "SELECT *,T_TRANSACTION.AREA AS T_AREA FROM T_TRANSACTION JOIN T_LANDS USING (LAND_NO,DISTRICT_NO) JOIN T_DISTRICTS USING (LOCALE_NO,DISTRICT_NO) 
JOIN T_LOCALES USING (LOCALE_NO) JOIN T_CLASSIFICATIONS USING (CLASS_NO) JOIN T_LAND_TYPES USING (TYPE_NO) WHERE ID= ".$id;

$res = mysqli_query($connect,$sql);
$row = mysqli_fetch_array($res);
$trans_page = $row['TRANSACTION_NO'];

if ($row['FIRST_PARTY']!='')
{
    $fpsql = "SELECT OWNER_NAME FROM T_OWNERS WHERE OWNER_NO = ".$row['FIRST_PARTY'];
    $fpres = mysqli_query($connect,$fpsql);
    $fprow = mysqli_fetch_array($fpres);
}


if ($row['SEC_PARTY']!='')
{
    $spsql = "SELECT OWNER_NAME FROM T_OWNERS WHERE OWNER_NO = ".$row['SEC_PARTY'];
    $spres = mysqli_query($connect,$spsql);
    $sprow = mysqli_fetch_array($spres);
}

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
    <script src="../ASSETS/SCANNER/jquery-ui.min.js"></script> <!-- optional -->
    <link rel="stylesheet" href="../ASSETS/SCANNER/jquery-ui.min.css"/> <!-- optional -->
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
    .owner-row:hover
    {
        background-color: #1e7e34;
    }
</style>
<body style="font-family: 'Droid Arabic Naskh', serif;font-size: large">


<div class="col-xs-2 navbar-fixed-top pull-right" style="background-color:black;min-height: 100%;">

    <ul style="margin-top: 55px;" class="nav nav-pills nav-stacked col-md-12">

        <?php include "navigation.php"?>

    </ul>

</div>
<?php
include "../MODEL/process_transactions.php";
?>


<input type="text" hidden value="<?php echo $_SESSION['PRIVILEGE']; ?>" id="privilege"/>
<input type="text" hidden value="<?php echo $row['ID']; ?>" id="trans_id"/>

<div class="col-md-12 navbar-fixed-top" style="height:55px;background-color: #1b5e20 ;padding-left: 0px;">
    <a style="cursor:pointer;" class="col-xs-9 pull-right">
        <p class="col-xs-12 pull-right" id="classes" style="margin-top:7px;color:white;font-size:x-large">
            <b> <i class="fa fa-exchange"></i> معاملة <?php echo $row['TRANSACTION_NO']; ?>  <i class="fa fa-arrow-left"></i> قطعة أرض رقم : <?php echo $row['LAND_NO'];?> - <?php echo $row['DISTRICT_NAME']; ?> </b>
        </p>
    </a>
    <div style="position:relative;z-index: 999;">
        <button id="user_button" style="border-width:0px;height:55px;background-color: #1b5e20;" class="btn col-xs-3 btn-success pull-left dropdown-toggle" data-toggle="dropdown">

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




<div class="col-xs-10 navbar-fixed-top pull-right" align="right" style="margin-right: 16.7%;height:70px;border-bottom-style: outset;border-bottom-width: 1px;border-bottom-color: lightgray;padding-top: 15px;  background-color: #ffffff;margin-top:55px; ">
    <a class="btn btn-default col-md-2 pull-right" href="transactions.php">

        <i class="fa fa-long-arrow-right"></i> رجوع

    </a>
    <button style="margin-right:5px;" class="btn btn-success hidden col-md-2 pull-right" form="transaction_form" type="submit">
        <i class="fa fa-save"></i> حفظ
    </button>
    <button id="delete-transaction" style="margin-right:5px;" class="btn btn-danger col-md-2 pull-right" type="button">
        <i class="fa fa-trash-o"></i> حذف
    </button>
    <div class="col-xs-3 pull-right" >

    </div>
</div>



<div class="col-xs-10" id="transaction_form_area" style="min-height:81.5%;margin-top:125px;background-color:whitesmoke;">
<?php
if ($trans_page==1)
    include "editTransactions/assign.php";
else if ($trans_page==2)
    include "editTransactions/renewal.php";
else if ($trans_page==3)
    include "editTransactions/give.php";
else if ($trans_page==4)
    include "editTransactions/mort.php";
else if ($trans_page==5)
    include "editTransactions/dismort.php";
else if ($trans_page==6)
    include "editTransactions/distin.php";
else if ($trans_page==8)
    include "editTransactions/change.php";
else if ($trans_page==9)
    include "editTransactions/add.php";
else if ($trans_page==10)
    include "editTransactions/join.php";
else if ($trans_page==11)
    include "editTransactions/return.php";
else if ($trans_page==12)
    include "editTransactions/rip.php";

?>
</div>



<!-- Modal -->
<div class="modal fade" style="border-radius: 10px;" id="SelectOwnerModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content" style="border-radius: 10px;">

            <div class="modal-header">
                <h6 class="modal-title" align="center">  </h6>
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
    $(document).ready(function(){


        if ($("#privilege").val()!=1&&$("#privilege").val()!=2)
        {
            $("input").prop('disabled',true);
            $("select").prop('disabled',true);
            $("button").prop('disabled',true);
            $("#user_button").prop('disabled',false);
        }

        var party = '';

        var form_view = '';

        var change = false;

        $("input").change(function(){
            change = true;
        });

        $("select").change(function(){
            change = true;
        });

        $(document).on('submit','#transaction_form',function(e) {

            e.preventDefault();

            if (change==true)
            {

                var formData = new FormData(this);
                var trans_id = $("#trans_id").val();
                formData.append("trans_id",trans_id);


                $.ajax({
                    url: "../MODEL/delete_transaction.php",
                    method: "POST",
                    data: {trans_id:trans_id},
                    success: function (data) {
                        if (data) {
                            $.ajax({
                                url : "../MODEL/insert_transaction.php",
                                method : "POST",
                                data : formData,
                                processData:false,
                                contentType:false,
                                success : function (data){
                                    if(data){
                                        alertify.success("<h4><i class='fa fa-check'></i> تم حفظ التعديلات بنجاح </h4>");
                                    }
                                }
                            });
                        }
                    }
                });
            }else
            {
                alertify.message("<h4><i class='fa fa-info'></i> ليست هناك تعديلات لحفظها </h4>");
            }


        });


        $("#delete-transaction").click(function(){

            swal({
                title: "تأكيد",
                text: "هل تريد حذف هذه المعاملة وكل الآثار التي ترتبت عنها؟",
                type: "question",
                confirmButtonColor: "red",
                showCancelButton:true,
                cancelButtonColor:"green",
                cancelButtonText:"لا أريد الحذف <i class='fa fa-thumbs-up'></i>",
                confirmButtonText: "نعم <i class='fa fa-trash'></i>"
            }).then(function (isConfirm) {
                if (isConfirm) {

                    var trans_id = $("#trans_id").val();

                    $.ajax({
                        url: "../MODEL/delete_transaction.php",
                        method: "POST",
                        data: {trans_id:trans_id},
                        success: function (data) {
                            if (data) {

                                swal({
                                    title: "تم !",
                                    text: "تم الحذف بنجاح",
                                    type: "success",
                                    confirmButtonColor: "skyblue",
                                    confirmButtonText: "حسنا"
                                }).then(function () {
                                    window.location = "transactions.php";
                                });
                            }
                        }
                    });
                } else {

                }
            });
        });


        $(document).on('click','#register_owner',function(e) {
            form_view=        '  <div class="modal-dialog">\n' +
                '        <!-- Modal content-->\n' +
                '        <div class="modal-content" style="border-radius: 10px;">\n' +
                '\n' +
                '            <div class="modal-header">\n' +
                '                <h4 class="modal-title" align="center"> إضافة بيانات مالك جديد </h4>\n' +
                '            </div>\n' +
                '            <div class="modal-body" dir="rtl">\n' +
                '                <form id="owner_form" class="oe_formview">\n' +
                '                    <table class="table table-responsive">\n' +
                '                        <br/>\n' +
                '                        <tr>\n' +
                '                            <td class="col-xs-3">\n' +
                '                                <label class="control-label">الإسم </label>\n' +
                '                            </td>\n' +
                '                            <td class="col-xs-3" colspan="4">\n' +
                '                                <input autocomplete="off" required type="text" class="text-center form-control" name="owner_name" placeholder="إسم المالك ..."/>\n' +
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
                '                        <tr>\n' +
                '                            <td class="col-xs-3">\n' +
                '                                <label class="control-label">نوع إثبات الشخصية</label>\n' +
                '                            </td>\n' +
                '                            <td class="col-xs-3">\n' +
                '                                <select required class="form-control" name="idtype" id="idtype">\n' +
                '                                    <option value="1"> رقم الوطني </option>\n' +
                '                                    <option value="2"> بطاقة قومية </option>\n' +
                '                                    <option value="3"> جواز سفر </option>\n' +
                '                                </select>\n' +
                '                            </td>\n' +
                '                            <td class="col-xs-3">\n' +
                '                                <label class="control-label">رقم إثبات الشخصية</label>\n' +
                '                            </td>\n' +
                '                            <td class="col-xs-3">\n' +
                '                                <input dir="ltr" required type="text" class="form-control text-center" placeholder="رقم إثبات الشخصية" id="idno" name="idno"/>\n' +
                '                            </td>\n' +
                '\n' +
                '\n' +
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


        $(document).on('click','#selectOwner',function(e) {

            form_view='<div class="modal-dialog">\n' +
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
                url:"../MODEL/modal_fetch_owners.php",
                method : "POST",
                data : {},
                success : function(data)
                {
                    $("#modal-owners-data").html(data);
                }

            });

        });

        $(document).on('click','.owner-row',function(e) {
            var owner_no = $(this).attr("id");
            var owner_name = $(this).attr("content");

            if (party == 1) {
                $("#first_party").val(owner_no);
                $("#fp").val(owner_name);
            }
            else if (party == 2)
            {
                $("#sec_party").val(owner_no);
                $("#sp").val(owner_name);
            }
            change = true;
            $("#SelectOwnerModal").modal("hide");

        });


        $("#fp").click(function(){

            $("#SelectOwnerModal").modal("show");
            party = 1;

        });

        $("#sp").click(function(){

            $("#SelectOwnerModal").modal("show");
            party = 2;

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


        $(document).on('submit','#owner_form',function(e){
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url:'../MODEL/insert_owner.php',
                method:'POST',
                data:formData,
                processData:false,
                contentType:false,
                success:function(data)
                {

                    if (data)
                    {
                        if (party==1)
                        {
                            $("#first_party").val(data);
                            $("#fp").val(formData.get("owner_name"));
                        }else if (party==2)
                        {
                            $("#sec_party").val(data);
                            $("#sp").val(formData.get("owner_name"));
                        }

                        $("#SelectOwnerModal").modal("hide");

                        $("#owner_form")[0].reset();
                        change = true;
                        $.ajax({
                            url:"../MODEL/modal_fetch_owners.php",
                            method : "POST",
                            data : {},
                            success : function(data)
                            {
                                $("#modal-owners-data").html(data);
                            }

                        });
                    }
                    else
                    {
                        swal("لم يتم حفظ البيانات ! الرجاء التحقق من صحتها");
                    }

                }
            });
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


    });

</script>