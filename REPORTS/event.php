<?php
//============================================================+
// File name   : example_003.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 003 for TCPDF class
//               Custom Header and Footer
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Custom Header and Footer
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).
require_once('../ASSETS/PHP/TCPDF/tcpdf.php');

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {


	//Page header
	public function Header() {
        $this->Image('../ASSETS/IMAGES/image.png', 20, 5, 176, '', 'PNG', '', 'C', false, 300, '', false, false, 0, false, false, false);
        
        $this->SetY(28);

        $this->SetFont('amiri', '', 14);
        $title = 'الفعاليات - بيانات الفعالية';
        $this->Cell(0, 5, $title, 0, true, 'R', 0, '', 0, true, 'M', 'M');
        
        $this->SetY(28);
        
        $date = 'التاريخ: ' . date('Y/m/d');
        $this->Cell(0, 5, $date, 0, true, 'L', 0, '', 0, true, 'M', 'M');
        
        $this->SetY(32);
        
        $this->Cell(($this->w - $this->original_lMargin - $this->original_rMargin), 0, '', 'T', 0, 'C');
    }

	// Page footer
	public function Footer() {
        $this->SetLineStyle(array('width' => 0.90 / $this->k, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0));
        $this->SetY((-5 / $this->k) + max(-5, $this->y));
        if ($this->rtl) {
            $this->SetX($this->original_rMargin);
        } else {
            $this->SetX($this->original_lMargin);
        }
        $this->Cell(($this->w - $this->original_lMargin - $this->original_rMargin), 1, '', 'T', 1, 'C');
        $this->endTemplate();
		// Position at 15 mm from bottom
        $this->SetY(-9);
		// Set font
		$this->SetFont('aealarabiya', 'BI', 12);
		// Page number
		$this->Cell(0, 4, 'شرطة دبي - الإدارة العامة لأمن الهيئات والمنشآت والطؤارئ', 0, false, 'L', 0, '', 0, false, 'T', 'L');
	}
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('General Department of Protective Security & Emergency');
$pdf->SetTitle('Event Information');
$pdf->SetSubject('Transactions In Period');


// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 40, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------
// add a page
$pdf->AddPage('P', 'A4');
$pdf->setRTL(true);
$pdf->SetFont('amiri', '', 12);

include "../MODEL/connect.php";

$query = "SELECT * FROM T_EVENT WHERE ID = " . $_GET['id'];
$result = mysqli_query($connect,$query);
$row = mysqli_fetch_array($result);

$coordinator_query = "SELECT * FROM T_USERS WHERE USER_NO = " . $row['CREATOR_ID'];
$coordinator_result = mysqli_query($connect, $coordinator_query);
$coordinator_row = mysqli_fetch_array($coordinator_result);

include "../MODEL/process_event_type.php";

$output = '<h3>بيانات الفعالية الأساسية:</h3>
<table cellpadding="6" border="1">
    <tr style="background-color: #01915c; color: white; text-align: center; font-size: 17px; font-weight: bold;">
        <td width="30%">الفعالية</td>
        <td width="70%">'.$row['EVENT_NAME'].'</td>
    </tr>
    <tr style="text-align: center; font-size: 17px; font-weight: bold;">
        <td width="30%">نوع الفعالية</td>
        <td width="70%">'.$row['EVENT_TYPE'].'</td>
    </tr>
    <tr style="background-color: #01915c; color: white; text-align: center; font-size: 17px; font-weight: bold;">
        <td width="30%">تصنيف الفعالية</td>
        <td width="70%">'.$row['CLASSIFICATION'].'</td>
    </tr>
    <tr style="text-align: center; font-size: 17px; font-weight: bold;">
        <td width="30%">الجهة المنظمة</td>
        <td width="70%">'.$row['ORGANIZER'].'</td>
    </tr>
    <tr style="background-color: #01915c; color: white; text-align: center; font-size: 17px; font-weight: bold;">
        <td width="30%">موقع الفعالية</td>
        <td width="70%">'.$row['EVENT_LOCATION'].'</td>
    </tr>
    <tr style="text-align: center; font-size: 17px; font-weight: bold;">
        <td width="30%">الحضور المتوقع</td>
        <td width="70%">'.$row['EXPECTED_AUDIENCE'].'</td>
    </tr>
    <tr style="background-color: #01915c; color: white; text-align: center; font-size: 17px; font-weight: bold;">
        <td width="30%">عدد أفراد الشرطة</td>
        <td width="70%">'.$row['POLICE_COUNT'].'</td>
    </tr>
    <tr style="text-align: center; font-size: 17px; font-weight: bold;">
        <td style="width: 30%;">التاريخ</td>
        <td>'.date('Y/m/d', strtotime($row['EVENT_DATE'])).'</td>
    </tr>
    <tr style="background-color: #01915c; color: white; text-align: center; font-size: 17px; font-weight: bold;">
        <td width="30%">يوم الفعالية</td>
        <td width="70%">'.$row['EVENT_DAY'].'</td>
    </tr>
</table>';

$query = "SELECT * FROM T_COORDINATORS WHERE EVENT_ID = " . $_GET['id'];
$result = mysqli_query($connect,$query);
$output .= '<h3>حضور التنسيق والمعاينة:</h3>
<table cellpadding="4" border="1">
<thead>
    <tr style="background-color: #01915c; color: white; text-align: center; font-size: 17px; font-weight: bold;">
        <th>الإسم</th>
        <th>الجهة</th>
        <th>المنصب</th>
    </tr>
</thead>';

while ($row = mysqli_fetch_array($result)) {
    $output .= '<tr align="center">
        <td>'.$row['NAME'].'</td>
        <td>'.$row['REFERENCE'].'</td>
        <td>'.$row['POSITION'].'</td>
	</tr>';
}

$output .= '</table>';

$query = "SELECT * FROM T_EVENT_INFO WHERE EVENT_ID = " . $_GET['id'];
$result = mysqli_query($connect,$query);
$row = mysqli_fetch_array($result);
$output .= '<h3>بيانات أخرى عن الفعالية:</h3>
<table cellpadding="4" border="1">
    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">شخصيات هامة</td>
        <td>';
        if ($row['VIPS_EXIST']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">فعالية مصاحبة</td>
        <td>';
        if ($row['OTHER_EVENT']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">فنادق إقامة</td>
        <td>';
        if ($row['HOTELS']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">غرفة عمليات</td>
        <td>';
        if ($row['OPERATION_ROOM']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">مكتب للشرطة</td>
        <td>';
        if ($row['POLICE_OFFICE']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">مهبط طائرة</td>
        <td>';
        if ($row['HELIPORTS']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">جهات إعلامية</td>
        <td>';
        if ($row['MEDIA']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">موقع غرفة العمليات</td>
        <td>'. $row['OPERATION_ROOM_LOCATION'] .'</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">هل غرفة العمليات تغطي الحدث</td>
        <td>';
        if ($row['OPERATION_ROOM_COVERING']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">عدد الكاميرات</td>
        <td>'. $row['CAMERAS_NUMBER'] .'</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">هل الكاميرات تقوم بعملية التسجيل</td>
        <td>';
        if ($row['CAMERAS_RECORDING']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">عدد المداخل الفرعية</td>
        <td>'. $row['SUB_ENTRIES'] .'</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">عدد المداخل الرئيسية</td>
        <td>'. $row['MAIN_ENTRIES'] .'</td>
    </tr>

    <tr style="text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">هل يوجد متطوعين</td>
        <td>';
        if ($row['VOLUNTEERS']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">عدد المتطوعين</td>
        <td>'. $row['VOLUNTEERS_NUMBER'] .'</td>
    </tr>

    <tr style="text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">أخرى</td>
        <td>'. $row['OTHER_INFO'] .'</td>
    </tr>
</table>';

$query = "SELECT * FROM T_EVENT_HOTELS WHERE EVENT_ID = " . $_GET['id'];
$result = mysqli_query($connect,$query);
$output .= '<h3>الفنادق المخصصة للمشاركين في الفعالية:</h3>
<table cellpadding="4" border="1></i>">
<thead>
    <tr style="background-color: #01915c; color: white; text-align: center; font-size: 17px; font-weight: bold;">
        <th>إسم الفندق</th>
        <th>الم  قع</th>
        <th>إحداثيات المكان</th>
    </tr>
</thead>';

while ($row = mysqli_fetch_array($result)) {
    $output .= '<tr align="center">
        <td>'.$row['HOTEL_NAME'].'</td>
        <td>'.$row['HOTEL_LOCATION'].'</td>
        <td>'.$row['HOTEL_COORDINATES'].'</td>
	</tr>';
}

$output .= '</table>';

$query = "SELECT * FROM T_EVENT_PARTICIPANTS WHERE EVENT_ID = " . $_GET['id'];
$result = mysqli_query($connect,$query);
$row = mysqli_fetch_array($result);
$output .= '<h3>الجهات المشاركة في الفعالية:</h3>
<table cellpadding="4" border="1">
    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">جهاز أمن الدولة</td>
        <td>';
        if ($row['SECURITY_SERVICE']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">الإدارة العامة للمرور</td>
        <td>';
        if ($row['TRAFFIC']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">الإدارة العامة الدفاع المدني</td>
        <td>';
        if ($row['CIVIL_DEFENCE']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">التحريات والمباحث الجنائية</td>
        <td>';
        if ($row['CRIMINAL_INVESTIGATIONS']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">شركات الأمن الخاص</td>
        <td>';
        if ($row['PRIVATE_SECURITY']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">الإدارة العامة للعمليات</td>
        <td>';
        if ($row['OPERATIONS']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">الأدلة الجنائية وعلم الجريمة</td>
        <td>';
        if ($row['FORENSIC_CRIMINOLOGY']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">المركز المختص</td>
        <td>';
        if ($row['COMPETENT_CENTER']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">إدارة أمن المتفجرات</td>
        <td>';
        if ($row['EXPLOSIVES_SECURITY']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">إدارة امن وحماية الشخصيات</td>
        <td>';
        if ($row['PERSONAL_SECURITY']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">هيئة الطرق والمواصلات</td>
        <td>';
        if ($row['TRANSPORTATION']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">الإدارة العامة للنقل والإنقاذ</td>
        <td>';
        if ($row['TRANSPORT_RESCUE']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">إدارة التفتيش الأمني</td>
        <td>';
        if ($row['SECURITY_INSPECTION']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">إدارة المتفجرات</td>
        <td>';
        if ($row['EXPLOSIVES']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">الإدارة العامة لأمن المطارات</td>
        <td>';
        if ($row['AIRPORTS_SECURITY']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">الإسعاف الموحد</td>
        <td>';
        if ($row['AMBULANCE']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">أخرى</td>
        <td>'. $row['OTHER_PARTICIPANTS'] .'</td>
    </tr>
</table>';

$query = "SELECT * FROM T_EVENT_NEEDS WHERE EVENT_ID = " . $_GET['id'];
$result = mysqli_query($connect,$query);
$row = mysqli_fetch_array($result);
$output .= '<br><h3>احتياجات عملية التأمين:</h3>
<table cellpadding="4" border="1">
    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">عدد الافراد</td>
        <td>'. $row['INDIVIDUALS'] .'</td>
    </tr>

    <tr style="text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">عدد الدوريات الامنية</td>
        <td>'. $row['PATROLS'] .'</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">عدد الاجهزة</td>
        <td>'. $row['DEVICES'] .'</td>
    </tr>

    <tr style="text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">عدد الباصات</td>
        <td>'. $row['BUSES'] .'</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">عدد عناصر الشرطة النسائية</td>
        <td>'. $row['FEMALE_OFFICERS'] .'</td>
    </tr>

    <tr style="text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">عدد الحواجز الأمنية</td>
        <td>'. $row['SECURITY_BLOCKS'] .'</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">عدد الدراجات الهوائية والنارية</td>
        <td>'. $row['BIKES_MOTOBIKES'] .'</td>
    </tr>

    <tr style="text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">أخرى</td>
        <td>'. $row['OTHER_NEEDS'] .'</td>
    </tr>
</table>';

$query = "SELECT * FROM T_EVENT_TRANSPORTATION WHERE EVENT_ID = " . $_GET['id'];
$result = mysqli_query($connect,$query);
$row = mysqli_fetch_array($result);
$output .= '<h3>نوع المواصلات:</h3>
<table cellpadding="4" border="1">
    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">باص</td>
        <td>';
        if ($row['BUS']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">سيارة</td>
        <td>';
        if ($row['CAR']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">سيارة اجرة</td>
        <td>';
        if ($row['TAXI']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">مترو</td>
        <td>';
        if ($row['METRO']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">أخرى</td>
        <td>';
        if ($row['OTHER']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>
</table>';

$query = "SELECT * FROM T_EVENT_REPORT WHERE EVENT_ID = " . $_GET['id'];
$result = mysqli_query($connect,$query);
$row = mysqli_fetch_array($result);
$output .= '<br><h3>المرفقات المطلوبة في التقرير النهائي:</h3>
<table cellpadding="4" border="1">
    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">خطة الطوارئ والاخلاء</td>
        <td>';
        if ($row['EMERGENCY_PLAN']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">أسماء الشخصيات الهامة</td>
        <td>';
        if ($row['VIP_LIST']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">البطاقات التعريفية</td>
        <td>';
        if ($row['ID_CARDS']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">المراسلات والمخاطبات</td>
        <td>';
        if ($row['CORRESPONDENCE']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">كشف الافراد</td>
        <td>';
        if ($row['INDIVIDUALS_LIST']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">بطاقة الدعوة</td>
        <td>';
        if ($row['INVITATION_CARD']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">كشف المتطوعين</td>
        <td>';
        if ($row['VOLUNTEERS_LIST']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">كشف افراد الجهات المنظمة</td>
        <td>';
        if ($row['ORGINZERS_LIST']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">كشف عناصر الشركات الامنية</td>
        <td>';
        if ($row['SECURITY_LIST']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">خطط الجهات المشاركة</td>
        <td>';
        if ($row['PARTICIPANTS_PLANS']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">تكلفة العملية</td>
        <td>';
        if ($row['OPERATION_COST']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">استمارة تصنيف العملية</td>
        <td>';
        if ($row['CLASSIFICATION_FORM']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">استمارة نجاح الفعالية</td>
        <td>';
        if ($row['SUCCESS_FORM']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">أخرى</td>
        <td>'. $row['REPORT_OTHERS'] .'</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td style="font-size: 17px; font-weight: bold;">ملاحظات</td>
        <td>'. $row['NOTES'] .'</td>
    </tr>
</table>';


$output .= '<h3>القائم بالتنسيق والمعاينة:</h3><table width="100%">
<tr>
    <td width="40px">الرتبة:</td>
    <td>'. $coordinator_row['RANKING'] .'</td>
    <td width="40px">الإسم:</td>
    <td>'. $coordinator_row['FULL_NAME'] .'</td>
</tr>
<tr><td></td><td></td><td></td><td></td></tr>';
if ($coordinator_row['IMG_SIGNATURE']) {
    $output .='<tr>
        <td colspan="2">التوقيع:</td>
        
        <td colspan="2"><img src="../IMAGES/'. $coordinator_row['IMG_SIGNATURE'] .'" style="width: 100px; height: 100px;"></td>
    </tr>';
}
$output .= '</table>';

if ($output == '') {
    $output .= '<p style="text-align: center;">لاتوجد بيانات</p>';
}

$html = <<<EOD
$output
EOD;

// print a block of text using Write()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

//Close and output PDF document
$pdf->Output('ُEvent Information.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>
