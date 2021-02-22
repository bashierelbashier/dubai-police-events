<?php

session_start();

if (!isset($_SESSION['USER_NO'])) {
    header("location:login.php");
}

if ($_SESSION['PRIVILEGE'] == 4 || $_SESSION['PRIVILEGE'] == 5)
    header("location:access_denied.php");

$prev = '#';
$next = '#';

include "../MODEL/connect.php";

$query = "SELECT * FROM T_DOCS WHERE LAND_NO = '" . $_GET['LAND_NO'] . "' AND DISTRICT_NO =" . $_GET['DISTRICT_NO'];
$res = mysqli_query($connect, $query);
$rows = [];

while ($row = mysqli_fetch_assoc($res)) {
    array_push($rows, $row);
}

for ($i = 0; $i < sizeof($rows); $i++) {

    if ($rows[0]['DOC_FILE'] != $_GET['DOC_SOURCE']) {
        if ($rows[$i]['DOC_FILE'] == $_GET['DOC_SOURCE']) {
            $prev = 'docs_gallery.php?LAND_NO=' . $_GET['LAND_NO'] . '&DISTRICT_NO=' . $_GET['DISTRICT_NO'] . '&DOC_SOURCE=' . $rows[$i - 1]['DOC_FILE'];
        }
    }

    if ($rows[$i] != end($rows)) {
        if ($rows[$i]['DOC_FILE'] == $_GET['DOC_SOURCE']) {
            $next = 'docs_gallery.php?LAND_NO=' . $_GET['LAND_NO'] . '&DISTRICT_NO=' . $_GET['DISTRICT_NO'] . '&DOC_SOURCE=' . $rows[$i + 1]['DOC_FILE'];
        }
    }
}

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

<body style="font-family: 'Droid Arabic Naskh', serif">





    <div style="background-color: darkslategrey;" class="col-xs-12">

        <input hidden type="text" id="doc_source" value="<?php echo $_GET['DOC_SOURCE']; ?>" />

        <div style="height: 55px;background-color: #a6e1ec;border-top-right-radius: 8px;border-top-left-radius: 8px;padding-top: 10px;" class="col-xs-8 center-block navbar-fixed-bottom">
            <div class="col-xs-4 pull-left">
                <a id="prev_doc" href="<?php echo $prev; ?>" style="border-radius:50%;" class="btn btn-info pull-right"> <i class="fa fa-chevron-left"></i></a>
            </div>
            <div class="col-xs-4 pull-left">
                <button id="delete-doc" style="border-radius:50%;" class="btn btn-danger center-block"> <i class="fa fa-trash-o"></i></button>
            </div>
            <div class="col-xs-4 pull-right">
                <a id="next_doc" href="<?php echo $next; ?>" style="border-radius:50%" class="btn btn-info pull-left"><i class="fa fa-chevron-right"></i> </a>
            </div>
        </div>

        <div class="col-xs-3"></div>

        <div class="col-xs-6">
            <img class="col-xs-12" src="../IMAGES/<?php echo $_GET['DOC_SOURCE']; ?>" />
        </div>

        <div class="col-xs-3"></div>

    </div>



</body>

</html>
<script>
    $(document).ready(function() {

        $("#delete-doc").click(function() {
            swal({
                title: "تأكيد",
                text: "تنبيه-لايمكن إسترجاع المستند بعد حذفه هل تريد تأكيد الحذف؟",
                type: "question",

                confirmButtonColor: "red",
                showCancelButton: true,
                cancelButtonColor: "green",
                cancelButtonText: "لا أريد الحذف <i class='fa fa-thumbs-up'></i>",
                confirmButtonText: "نعم <i class='fa fa-trash'></i>"
            }).then(function(isConfirm) {
                if (isConfirm) {

                    var doc_source = $("#doc_source").val();

                    $.ajax({
                        url: "../MODEL/delete_doc.php",
                        method: "POST",
                        data: {
                            doc_source: doc_source
                        },
                        success: function(data) {
                            alertify.success("تم الحذف بنجاح");
                        }
                    });

                }
            });

        });
    });
</script>