<?php
session_start();
include "../MODEL/connect.php";

if (!isset($_SESSION['USER_NO']))
{
    header("location:login.php");
}

if ($_SESSION['PRIVILEGE']!=1 && $_SESSION['PRIVILEGE']!=2)
    header("location:access_denied.php");

$cq = "SELECT COUNT(*) AS COUN FROM T_OWNERS";
$cr = mysqli_query($connect,$cq);
$cw = mysqli_fetch_array($cr);
$pages = ceil($cw['COUN']/6);

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
    .pagination-link
    {
        font-size:medium;
        color: #1b5e20;
    }
    .form-control
    {
        border-radius: 0px;
    }
    html,body {
        height: 100%;
    }
</style>
<body style="font-family: 'Droid Arabic Naskh', serif;font-size: large">
<div class="col-xs-2 navbar-fixed-top pull-right" style="background-color:black;min-height: 100%;">

    <ul style="margin-top: 55px;" class="nav nav-pills nav-stacked col-md-12">

        <?php include "navigation.php"?>

    </ul>
</div>
<div class="col-md-12 navbar-fixed-top" style="height:55px;padding-left:0px;background-color: #1b5e20;">

    <a class="col-xs-9 pull-right" style="cursor:pointer;"><p class="col-xs-12 pull-right"  style="margin-top:0.5%;color:white;font-size:x-large"><b> <i class="fa fa-male"></i> أصحاب الأراضي  </b></p></a>

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
    <a href="new_owner.php"><button style="margin-top: 20px;" class="btn btn-default col-xs-4 pull-right"> تسجيل جديد <i class="fa fa-plus-square"></i></button></a>
    <div class="col-xs-5 pull-right">
        <nav aria-label="Navigation">
            <ul id="pages" class="pagination center-block">

            </ul>
        </nav>
    </div>
    <br/>
    <div class="input-group col-xs-3 pull-left">
        <span class="input-group-addon" style="background-color:white;border-radius: 0px;border-width:0px;">
            <i class="fa fa-filter"></i>
        </span>
        <input type="search" style="border-radius:0px;border-top-width: 0px;border-left-width: 0px;border-right-width: 0px" id="search_text" class="form-control" placeholder="الإسم ..."/>

    </div>
    <br/>
</div>

</div>

<div class="col-xs-10" id="owners_kanban" style="min-height:81.5%;margin-top:125px;background-color:whitesmoke;">

</div>

<input id="num_pages" value="<?php echo $pages;?>" hidden/>
</body>

</html>
<script>
    $(document).ready(function(){


        var pages = $("#num_pages").val();
        var start = 1;
        var end;

        fillPages(start);

        $(document).on('click','.pagination-link',function(e) {

            var link = $(this).attr('id');

            if (link == 'prev_set'){

                if (start!=1)
                    fillPages(start-5);

            }else if (link == 'next_set'){

                if (end!=pages)
                    fillPages(end+1);

            }else{

                var txt = $("#search_text").val();
                $.ajax({
                    url:"../MODEL/list_owners.php",
                    method : "POST",
                    data : {txt:txt,start:(link-1)*6,limit:6},
                    success : function(data)
                    {
                        $("#owners_kanban").html(data);
                    }
                });;
            }

        })


        function fillPages(astart)
        {
            start = astart;

            $("#pages").html('<li id="prev_set" class="pagination-link">' +
                '<a aria-label="السابق" href="#">' +
                '<span aria-hidden="true"> <i class="fa fa-long-arrow-left"></i>  </span>' +
                '</a></li>');

            for (var i=start;i<=pages;i++) {

                $("#pages").html($("#pages").html() + "<li class='pagination-link' id='"+i+"'><a href='#'>" + i + "</a></li>");
                end = i;
                if (i==(start+4))
                    break;

            }


            $("#pages").html($("#pages").html()+'<li id="next_set" class="pagination-link">'+
                '<a aria-label="التالي" href="#">'+
                '<span aria-hidden="true"><i class="fa fa-long-arrow-right"></i> </span>'+
                '</a></li>' );
        }

    });
</script>




<script>

    $(document).ready(function(){




        $.ajax({
            url:"../MODEL/list_owners.php",
            method:"POST",
            data:{start:0,limit:6},
            success: function(data)
            {
                $("#owners_kanban").html(data);
            }
        });

        $("#search_text").keyup(function(e){
            var txt = $(this).val();
            $.ajax({
                url:"../MODEL/list_owners.php",
                method : "POST",
                data : {txt:txt,start:0,limit:6},
                success : function(data)
                {
                    $("#owners_kanban").html(data);
                }
            });
        });


        $("#previous_page").click(function(){

        });

        $("#next_page").click(function(){

        });



    });

</script>