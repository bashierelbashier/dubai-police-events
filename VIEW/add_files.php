<?php

session_start();

$land_file_exist = TRUE;

if (!isset($_SESSION['USER_NO']))
{
    header("location:login.php");
}

if ($_SESSION['PRIVILEGE']==4||$_SESSION['PRIVILEGE']==5)
    header("location:access_denied.php");

?>

<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>

    <title> system </title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script>

        var com_asprise_scan_app_license = "ENTwJt8xMa3wVWon6qFOS17y7OUgMEkJE0hGIz+W6my+wlWY8tHknOWGTPt6eKB8Roo8Y00/yFflhY4FLmzLzvZOLMDlPdPlHo1ekZP8d1ur+kPoYYxxtyzKJ8P1f7vSJnjl1GjhDTBkmSRa3W/Gf2Y4nrZ3V90DNJOxHd2wjzicZ3L5rcrIYcpbgRUw2yD+wdRWPpJl9eWfaKrN9zKXJvBli2GdRti5vwyi8lwKjjq5i1QSKBaLGOJgt9KGWpTJzRjY8kLD9BweJusluxGW0/8Z2sP6DLBlF0QE6APhLqSfxM=";

    </script>
    <script src="../ASSETS/SCANNER/scanner.js" type="text/javascript"></script> <!-- required for scanning -->
    <script src="../ASSETS/SCANNER/jquery-1.js"></script> <!-- optional -->
    <script src="../ASSETS/SCANNER/jquery-migrate-1.js"></script>
    <link href="../ASSETS/CSS/bootstrap.min.css" rel="stylesheet"> <!-- optional -->
    <link href="../ASSETS/CSS/static/css/odoo.css" rel="stylesheet"> <!-- optional -->
    <link href="../ASSETS/CSS/mystyle.css" rel="stylesheet"> <!-- optional -->
    <link href="../ASSETS/CSS/btn.css" rel="stylesheet"> <!-- optional -->
    <link href="../ASSETS/CSS/css/font-awesome.min.css" rel="stylesheet"> <!-- optional -->
    <link href="../ASSETS/CSS/sweetalert2.min.css" rel="stylesheet"> <!-- optional -->
    <link href="../ASSETS/CSS/jquery-ui.min.css" rel="stylesheet"> <!-- optional -->
    <script src="../ASSETS/SCANNER/jquery-ui.min.js"></script> <!-- optional -->
    <script src="../ASSETS/SCANNER/bootstrap.min.js"></script> <!-- optional -->
    <script src="../ASSETS/SCANNER/sweetalert2.min.js"></script> <!-- optional -->
    <link rel="resource" type="application/l10n" href="../ASSETS/SCANNER/locale.properties">`
    <link rel="resource" type="application/l10n" href="../ASSETS/SCANNER/viewer.properties">

    <style>

        img:hover + .button, .button:hover
        {
            display: inline-block;
        }

    </style>
    <!--link href="../ASSETS/SCANNER/demo.css" rel="stylesheet"--> <!-- optional -->
    <script>
        // -------------- Optional status display, depending on JQuery --------------
        function displayStatus(loading, mesg, clear) {

            if(loading) {
                $('#info').html((clear ? '' : $('#info').html()) + '<p>' + mesg + '</p>');
            } else {
                $('#info').html((clear ? '' : $('#info').html()) + mesg);
            }
        }

        // -------------- scanning related code: independent of any 3rd JavaScript library --------------
        function scanAsJpg() {
            displayStatus(true, 'Scanning', true);
            scanner.scan(handleImages,
                {  "output_settings" : [ {
                        "type" : "return-base64",
                        "format" : "jpg"
                    } ], "i18n": { "lang": getLang() } }, true, false);
        }

        function scanSimple() {
            displayStatus(true, 'جاري المسح ...', true);
            scanner.scan(handleImages,
                {
                    "prompt_scan_more": false,
                    "detect_blank_pages": true,
                    "output_settings" : [ {
                        "type" : "return-base64",
                        "format" : "jpg"
                    } ], "i18n": { "lang": getLang() } }, false, false);
        }


        function scanMultiple() {
            displayStatus(true, 'جاري المسح ...', true);
            scanner.scan(handleImages,
                {
                    "twain_cap_setting": {
                        "CAP_FEEDERENABLED":true,
                        "CAP_AUTOFEED":true,
                    },
                    "prompt_scan_more": false,
                    "detect_blank_pages": true,
                    "output_settings" : [ {
                        "type" : "return-base64",
                        "format" : "jpg"
                    } ], "i18n": { "lang": getLang() } }, false, false);
        }

        function scanAsPdf() {
            displayStatus(true, 'جاري مسح الملفات', true);
            scanner.scan(handleImages,
                {  "output_settings" : [ {
                        "type" : "return-base64",
                        "format" : "pdf"
                    } ], "i18n": { "lang": getLang() } }, true, false);
        }

        function scanThenUpload() {
            displayStatus(true, 'Scanning', true);
            scanner.scan(handleUploadResponse,
                {
                    "output_settings" : [ {
                        "type" : "upload",
                        "format" : "pdf",
                        "pdf_force_black_white" : false,
                        "upload_target" : {
                            "url" : "https://asprise.com/scan/applet/upload.php?action=dump",
                            "cookies" : "name=value; poweredBy=Asprise"
                        }
                    } ], "i18n": { "lang": getLang() }
                }
                , true, false);
        }

        /** Returns true if it is successfully or false if failed and reports error. */
        function checkIfSuccessfully(successful, mesg, response) {
            displayStatus(false, '', true);
            if(successful && mesg != null && mesg.toLowerCase().indexOf('user cancel') >= 0) { // User cancelled.
                displayStatus(false, '<pre>' + "تم الإيقاف بواسطة المستخدم" + '</pre>', true);
                return false;
            } else if(!successful) {
                displayStatus(false, '<pre>' + "Failed: " + mesg + "\n" + response + '</pre>', true);
                return false;
            }
            return true;
        }

        /** Callback function to retrieve scanned images. Returns number of images retrieved. */
        function handleImages(successful, mesg, response) {
            if(!checkIfSuccessfully(successful, mesg, response)) {
                return 0;
            }

            var scannedImages = scanner.getScannedImages(response, true, false);
            displayStatus(false, '<pre>' + "Scanned Successfully" + '</pre>', true);
            for(var i = 0; (scannedImages instanceof Array) && i < scannedImages.length; i++) {
                var img = scannedImages[i];
                displayStatus(false, "\n<pre>  " + img.toString() + "</pre>", false);
                appendImage(img, document.getElementById('images'));
            }
            return (scannedImages instanceof Array) ? scannedImages.length : 0;
        }

        /** Callback function to retrieve upload response */
        function handleUploadResponse(successful, mesg, response) {
            if(!checkIfSuccessfully(successful, mesg, response)) {
                return 0;
            }

            var uploadResponse = scanner.getUploadResponse(response);
            if(uploadResponse) {
                displayStatus(false, "<h2>Upload Response from the Server Side: </h2>" + uploadResponse, true);
            } else {
                displayStatus(false, '<pre>' + "Failed: " + mesg + "\n" + response + '</pre>', true);
            }
        }

        /** Displays general response to the page - for demo purpose only. */
        function universalHandlerForDemo(successful, mesg, response) {
            try {
                if (!checkIfSuccessfully(successful, mesg, response)) {
                    return;
                }

                // Original images
                var imgCount = handleImages(successful, mesg, response);

                // Thumbnails
                var thumbs = scanner.getScannedImages(response, false, true);
                if (thumbs.length > 0) {
                    displayStatus(false, '<pre>' + "Thumbnails acquired: " + thumbs.length + '</pre>', false);

                    $("#info").append("<div id=\"thumbs\"></div>");

                    for (var i = 0; i < thumbs.length; i++) {
                        var t = thumbs[i];
                        appendImage(t, document.getElementById('thumbs'), true);
                    }
                }

                var saveResponse = scanner.getSaveResponse(response);
                if (saveResponse) {
                    displayStatus(false, "<h2>File Save Result: </h2>" + saveResponse, false);
                }
                var uploadResponse = scanner.getUploadResponse(response);
                if (uploadResponse) {
                    displayStatus(false, "<h2>Upload Response from the Server Side: </h2>" + uploadResponse, false);
                }
            } catch (e) {
                displayStatus(false, "<h2>Exception</h2><p>" +
                    (e == null ? e : e.toString().replace(/[\x26\x0A\<>'"]/g,function(r){return"&#"+r.charCodeAt(0)+";"}) )
                    + "</p>", false);
            }
        }

        /** To track all the images (thumbnails excluded) scanned so far. */
        /** @type ScannedImage[] */
        var imagesScanned = [];

        /**
         * Appends image to given dom node.
         * @param scannedImage ScannedImage
         * @param domParent
         */
        function appendImage(scannedImage, domParent, isThumbnail) {



            if(! scannedImage) {
                return;
            }
            //scanner.logToConsole("Appending scanned image: " + scannedImage.toString());
            if(!isThumbnail) {
                imagesScanned.push(scannedImage);
            }



            if(scannedImage.mimeType == scanner.MIME_TYPE_BMP || scannedImage.mimeType == scanner.MIME_TYPE_GIF || scannedImage.mimeType == scanner.MIME_TYPE_JPEG || scannedImage.mimeType == scanner.MIME_TYPE_PNG) {



                var elementImg = scanner.createDomElementFromModel(
                    {
                        'name': 'img',
                        'attributes': {
                            'class': 'scanned zoom thumb thumb-img',
                            'src': scannedImage.src,
                            'height': '200',
                        }
                    }
                );


                var elementcancel = scanner.createDomElementFromModel(
                    {
                        'name': 'i',
                        'attributes': {
                            'class': 'fa fa-trash fa-lg',
                            'style': 'font-size:large;',
                        }
                    }
                );


                var cancelbutton = scanner.createDomElementFromModel(
                    {
                        'name': 'label',
                        'attributes': {
                            'type': 'button',
                            'id': scannedImage.src,
                            'class': 'btn col-xs-12 btn-block delete-doc',
                            'style': 'background-color:grey;color:white;',
                        }
                    }
                );

                var sp = scanner.createDomElementFromModel(
                    {
                        'name': 'span',
                        'attributes': {
                            'class': 'col-xs-6 pull-right',
                        }
                    }
                );

                var document = scanner.createDomElementFromModel(
                    {
                        'name': 'div',
                        'attributes': {
                            'id':'image_div',
                            'class': 'col-xs-2 pull-right img_wrapper',
                            'style': 'margin:3px;'
                        }
                    }
                );

                var par = scanner.createDomElementFromModel(
                    {
                        'name': 'div',
                        'attributes': {
                            'class': 'img_wrapper',
                        }
                    }
                );



                cancelbutton.appendChild(elementcancel);
                sp.appendChild(cancelbutton);
                par.appendChild(elementImg);
                par.appendChild(sp);
                document.appendChild(par);
                domParent.appendChild(document);
                // optional UI effect that allows the user to click the image to zoom.
                enableZoom();



            } else if(scannedImage.mimeType == scanner.MIME_TYPE_PDF) {
                var elementA = scanner.createDomElementFromModel({
                    'name': 'a',
                    'attributes': {
                        'href': 'javascript:previewPdf(' + (imagesScanned.length - 1) + ');',
                        'class': 'thumb thumb-pdf'
                    }
                });
                domParent.appendChild(elementA);
            }
        }

        function submitForm1() {
            displayStatus(true, "<pre>جاري تحميل المستندات، الرجاء الإنتظار ....</pre>", true);
            if(! scanner.submitFormWithImages('form1', imagesScanned, function(xhr) {
                    if(xhr.readyState == 4) { // 4: request finished and response is ready
                        displayStatus(false, xhr.responseText, true);

                        swal("تم تحميل المستندات بنجاح");
                        imagesScanned = [];
                        document.getElementById('images').innerHTML = '';
                        fetch_docs();
                    }
                })) {
                swal("ليس هناك مستندات ليتم تحميلها، الرجاء إضافة مستند لتحميله");
            }
        }

        function clearScans() {
            if((imagesScanned instanceof Array) && imagesScanned.length > 0) {
                swal({
                    title: "تحذير",
                    text: "هل تريد حذف جميع المستندات التي تم مسحها؟",
                    type: "warning",
                    confirmButtonColor: "red",
                    showCancelButton:true,
                    cancelButtonColor:"green",
                    cancelButtonText:"لا أريد الحذف",
                    confirmButtonText: "<i class='fa fa-trash'></i> نعم"
                }).then(function (isConfirm) {
                    if (isConfirm) {
                        imagesScanned = [];
                        document.getElementById('images').innerHTML = '';
                    }
                });
            }
        }

        function getLang() {
            return $("#lang").val();
        }

        // Low level scanner access demos
        function selectASource() {
            displayStatus(true, 'Selecting a source ...', true);
            scanner.getSource(handleLowLevelApiResponse, "select", true, null, null, false, null, {
                "i18n": {
                    "lang": getLang()
                }
            });
        }

        function listSources() {
            displayStatus(true, 'Lists all sources ...', true);
            scanner.listSources(handleLowLevelApiResponse, false, "all", false, false, null);
        }

        function getSourceCaps() {
            displayStatus(true, 'Gets source capabilities ...', true);
            scanner.getSource(handleLowLevelApiResponse, "select", false, "all", false, true, "CAP_FEEDERENABLED: false; ICAP_UNITS: TWUN_INCHES", {
                "i18n": {
                    "lang": getLang()
                }
            });
        }

        function getSystemInfo() {
            displayStatus(true, 'Gets system info ...', true);
            scanner.callFunction(handleLowLevelApiResponse, "asprise_scan_system_info");
        }

        function handleLowLevelApiResponse(successful, mesg, result) {
            displayStatus(false, (successful ? "OK" : "ERROR") + '<pre>' + (mesg ? " - " + mesg : "") + "\n" + result + '</pre>', true);
        }

        $(function() {
            if(window.scanner.hasJava()) {
                displayStatus(false, "JRE: " + window.scanner.deployJava.getJREs(), false);
            } else {
                if(! window.scanner.isWindows()) {
                    displayStatus(false, "<p class='warn'>Currently, only Windows is supported.</p>", false);
                }
            }
        });


        $(document).on('click','.delete-doc',function(){

            var src = $(this).attr("id");
            swal({
                title: "تأكيد",
                text: "هل تريد حقاً حذف هذا المستند؟",
                type: "warning",

                confirmButtonColor: "red",
                showCancelButton:true,
                cancelButtonColor:"green",
                cancelButtonText:"لا أريد الحذف",
                confirmButtonText: "<i class='fa fa-trash'></i> نعم"
            }).then(function (isConfirm) {
                if (isConfirm) {

                    var temp = [];
                    for (var i = 0; i < imagesScanned.length; i++) {

                        if (imagesScanned[i].src != src) {
                            temp.push(imagesScanned[i])
                        }
                    }

                    imagesScanned = temp;
                    $("#images").html("");
                    afterdelete();


                }
            });



        });





        /******************************************************************************************/
        function afterdelete()
        {

            for (var i=0;i<imagesScanned.length;i++)
            {

                var scannedImage = imagesScanned[i];

                var elementImg = scanner.createDomElementFromModel(
                    {
                        'name': 'img',
                        'attributes': {
                            'class': 'scanned zoom thumb thumb-img',
                            'src': scannedImage.src,
                            'height': '200',
                        }
                    }
                );


                var elementcancel = scanner.createDomElementFromModel(
                    {
                        'name': 'i',
                        'attributes': {
                            'class': 'fa fa-trash fa-lg',
                            'style': 'font-size:large;',
                        }
                    }
                );


                var cancelbutton = scanner.createDomElementFromModel(
                    {
                        'name': 'label',
                        'attributes': {
                            'type': 'button',
                            'id': scannedImage.src,
                            'class': 'btn col-xs-12 btn-block delete-doc',
                            'style': 'background-color:grey;color:white;',
                        }
                    }
                );

                var sp = scanner.createDomElementFromModel(
                    {
                        'name': 'span',
                        'attributes': {
                            'class': 'col-xs-6 pull-right',
                        }
                    }
                );

                var document_div = scanner.createDomElementFromModel(
                    {
                        'name': 'div',
                        'attributes': {
                            'id':'image_div',
                            'class': 'col-xs-2 pull-right img_wrapper',
                        }
                    }
                );

                var par = scanner.createDomElementFromModel(
                    {
                        'name': 'div',
                        'attributes': {
                            'class': 'img_wrapper',
                        }
                    }
                );



                cancelbutton.appendChild(elementcancel);
                sp.appendChild(cancelbutton);
                par.appendChild(elementImg);
                par.appendChild(sp);
                document_div.appendChild(par);
                document.getElementById('images').appendChild(document_div);

                // // optional UI effect that allows the user to click the image to zoom.
                enableZoom();
            }
        }


    </script>

    <link rel="stylesheet" type="text/css" href="../ASSETS/SCANNER/scanner.css">
</head>
<style>
    .form-control
    {
        font-family: 'Droid Arabic Naskh', serif;
    }
</style>
<body class="scannerjs loadingInProgress" tabindex="1" style="background-image:url('../ASSETS/form_sheetbg.png');font-family: 'Droid Arabic Naskh', serif">
<div id="main" style="z-index: 999999;">



    <div>

        <div class="col-md-12">
            <a href="edit_land.php?LAND_NO=<?php echo $_GET['land_no'].'&DISTRICT_NO='.$_GET['district_no']; ?>"">
            <button style="margin:20px;border-radius: 10%;" class="btn navbar-fixed-top btn-warning col-md-2 pull-right">
                <i class="fa fa-arrow-right"></i> رجوع
            </button>
            </a>
        </div>

        <?php
        include "../MODEL/connect.php";
        $sql = "SELECT * FROM T_LANDS JOIN T_DISTRICTS USING (DISTRICT_NO,LOCALE_NO) JOIN T_LOCALES USING (LOCALE_NO)
        JOIN T_CLASSIFICATIONS USING (CLASS_NO) JOIN T_LAND_TYPES USING (TYPE_NO)
        WHERE LAND_NO='".$_GET['land_no']."' AND DISTRICT_NO =".$_GET['district_no'];

        $res = mysqli_query($connect,$sql);
        $row = mysqli_fetch_array($res);
        ?>
        <div class="col-md-12">
            <div class="panel panel-success" style="margin: 20px 0px;">
                <div class="panel-heading">
                    <h2 class="title panel-title" align="center">  تفاصيل قطعة الأرض  </h2>
                </div>
                <div class="panel-body">
                    <table class="table table-responsive">
                        <tr>
                            <td class="col-xs-2">
                                <label class="control-label">رقم القطعة</label>
                            </td>
                            <td class="col-xs-2">
                                <input type="text" readonly class="form-control" value="<?php echo $row['LAND_NO'];?>" name="land_no" id="land_no" placeholder="رقم القطعة"/>
                            </td>
                            <td class="col-xs-2">
                                <label class="control-label">المساحة</label>
                            </td>
                            <td class="col-xs-2">
                                <input type="text" readonly class="form-control" value="<?php echo $row['AREA'];?>" name="area" placeholder="مثلاً 20 كيلومتر مربع"/>
                            </td>
                            <td class="col-xs-2">
                                <label class="control-label">قياس المساحة</label>
                            </td>
                            <?php
                            $unit = "أمتار";
                            if ($row['AREA_UNIT']==2)
                                $unit = " أفدنة ";
                            ?>
                            <td class="col-xs-2">
                                <input type="text" class="form-control" value="<?php echo $unit; ?>" readonly/>
                            </td>
                        </tr>
                        <tr>

                            <td class="col-xs-2">
                                <label class="control-label">المربوع</label>
                            </td>
                            <td class="col-xs-2">
                                <input readonly type="text" class="form-control" value="<?php echo $row['DISTRICT_NAME'];?>" />
                                <input hidden type="text" class="form-control" value="<?php echo $row['DISTRICT_NO'];?>" id="district_no" />
                            </td>
                            <td class="col-xs-2">
                                <label class="control-label">المحلية</label>
                            </td>
                            <td class="col-xs-2">
                                <input type="text" class="form-control" readonly value="<?php echo $row['LOCALE_NAME'] ?>"/>
                            </td>
                            <td class="col-xs-2">
                                <label>التصنيف</label>
                            </td>
                            <td class="col-xs-2">
                                <input type="text" class="form-control" readonly value="<?php echo $row['CLASS_NAME'] ?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-xs-2">
                                <label>نوع قطعة الأرض</label>
                            </td>
                            <td class="col-xs-2">
                                <input type="text" class="form-control" readonly value="<?php echo $row['TYPE_NAME'] ?>"/>
                            </td>
                        </tr>
                    </table>


                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h5 align="center" class="panel-title">
                                بيانات مكان الإحتفاظ بملف قطعة الأرض
                            </h5>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped">
                                <tr>
                                    <td>
                                        <label> المكتب </label>
                                    </td>
                                    <td>
                                        <input type="text" readonly class="form-control" value="<?php echo $row['OFFICE_NO'];?>" id="office_no" name="office_no"/>
                                    </td>
                                    <td>
                                        <label> الدولاب </label>
                                    </td>
                                    <td>
                                        <input type="text" readonly class="form-control" value="<?php echo $row['CUPBOARD_NO'];?>" id="cupboard_no" name="cupboard_no"/>
                                    </td>
                                    <td>
                                        <label> الوحدة </label>
                                    </td>
                                    <td>
                                        <input type="text" readonly class="form-control" value="<?php echo $row['UNIT_NO'];?>" id="unit_no" name="unit_no"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label> الرف </label>
                                    </td>
                                    <td>
                                        <input type="text" readonly class="form-control" value="<?php echo $row['SHELF_NO'];?>" id="shelf_no" name="shelf_no"/>
                                    </td>

                                    <td>
                                        <label> الصندوق </label>
                                    </td>
                                    <td>
                                        <input type="text" readonly class="form-control" id="box_no" value="<?php echo $row['BOX_NO'];?>" name="box_no"/>
                                    </td>

                                    <td>
                                        <label> المجلد </label>
                                    </td>
                                    <td>
                                        <input type="text" readonly class="form-control" id="folder_no" value="<?php echo $row['FOLDER_NO'];?>" name="folder_no"/>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end cell -->

        <div class="col-md-12">
            <div class="panel panel-info" style="margin: 20px 0px;">
                <div class="panel-heading">
                    <h2 align="center" class="title panel-title" >   إضافة مستندات جديدة لقطعة الأرض :    <i class="fa fa-plus-circle"></i>  <img src="../ASSETS/scan_icon.ico" height="20" width="20" style="margin-bottom:4px;"/> </h2>
                </div>
                <div class="panel-body">
                    <form id="form1" action="../MODEL/upload_files.php?action=dump" method="POST" enctype="multipart/form-data" target="_blank">

                        <input type="text" class="hidden" value="<?php echo $_GET['land_no'] ?>" name="land_no" id="land_no"/>
                        <input type="text" class="hidden" value="<?php echo $_GET['district_no'] ?>" name="district_no" id="district_no"/>
                        <div class="col-md-12">
                            <button type="button" id="scan_single" style="border-radius:0px;" class="btn btn-lg btn-default pull-right" onclick="scanSimple();">  إضافة مستند جديد <i class="fa fa-plus"></i> </button>
                            <button type="button" id="scan_mutiple" style="border-radius:0px;margin-right:3px;" class="btn btn-lg btn-primary hidden pull-right" onclick="scanMultiple();"> إضافة عدة مستندات <i class="fa fa-clone"></i></button>

                            <button type="button" class="btn btn-lg btn-success pull-left" onclick="submitForm1();" style="float: right;border-radius:0px;font-size:large;margin-right:5px;">  حفظ المستندات <i class="fa fa-upload"></i></button>
                        </div>
                        <div id="images" class="col-md-12" style="margin-left: 0px;border-color:lightgray;border-width: 3px;border-style: solid; margin-top: 20px;margin-bottom: 20px;padding: 5px;"></div>
                        <label class="col-md-12" > <a href="javascript:clearScans();"><span class="pull-left btn btn-danger" style="font-weight: normal;color:white;font-family: 'Droid Arabic Naskh', serif">
                             حذف جميع المستندات <i class="fa fa-trash"></i></span></a></label>
                    </form>
                </div>


            </div>

            <div class="panel panel-warning hidden" style="margin: 20px 0px;">
                <div class="panel-heading">
                    <h2 align="center" class="title panel-title" > سجل الأنشطة <i class="fa fa-archive"></i></h2>
                </div>
                <div class="panel-body">

                    <div id="info" class="well col-md-12" style="display: block; background-color: #fff; height:60px; margin-top: 12px; padding: 12px;">

                    </div>
                </div>
            </div>
            <div class="panel panel-warning" style="margin: 20px 0px;">
                <div class="panel-heading">
                    <h2 align="center" class="title panel-title" > المستندات المحفوظة لقطعة الأرض <i class="fa fa-archive"></i></h2>
                </div>
                <div class="panel-body">
                    <div id="docs" class="well col-md-12" style="display: block; background-color: #fff; height: 500px; margin-top: 12px; padding: 12px; overflow: scroll;"></div>
                </div>
            </div>
        </div>
        <!-- end cell -->
    </div>
    <!-- end 'row' -->



    <!---------------------------------------------------------------------------------------------------------------->
    <!-- Below JavaScript functions and HTML elements enhance the demo experience, but not required for scanner.js. -->
    <!---------------------------------------------------------------------------------------------------------------->

    <!-- For picture zoom in/out -->
    <script src="../ASSETS/SCANNER/zoomerang.js"></script>
    <script>


        function enableZoom() {
            Zoomerang.config({
                maxWidth: window.innerWidth, // 400,
                maxHeight: window.innerHeight, // 400,
                bgColor: '#000',
                bgOpacity: .80,
                onClose: function(target) {
                    target.style.transform = ''; // fixing origin missing bug
                }
            }).listen('.zoom');
        }

        function fetch_docs() {
            var land = $("#land_no").val();
            var district = $("#district_no").val();
            $.ajax({
                url: "../MODEL/fetch_docs.php",
                method: "POST",
                data: {land: land,district:district},
                success: function (data) {
                    $("#docs").html(data);
                }
            });
        }


        $(document).ready(function(){

            fetch_docs();



        });

    </script>


    <!-- For code editor support -->
    <script src="../ASSETS/SCANNER/ace.js" type="text/javascript" charset="utf-8"></script>

    <!-- For PDF preview -->
    <link rel="stylesheet" href="../ASSETS/SCANNER/magnific-popup.css" type="text/css" media="screen">
    <script type="text/javascript" src="../ASSETS/SCANNER/jquery.js"></script>



    <link rel="stylesheet" href="../ASSETS/SCANNER/viewer.css">



</div><input id="fileInput" class="fileInput" type="file"></body></html>