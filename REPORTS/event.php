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
        $this->Image('../ASSETS/IMAGES/image.png', 60, 5, 176, '', 'PNG', '', 'C', false, 300, '', false, false, 0, false, false, false);
        
        $this->SetY(20);

        $this->SetFont('amiri', '', 14);
        $title = 'الفعاليات - بيانات الفعالية';
        $this->Cell(0, 5, $title, 0, true, 'R', 0, '', 0, true, 'M', 'M');
        
        $this->SetY(20);
        
        $date = 'التاريخ: ' . date('Y/m/d');
        $this->Cell(0, 5, $date, 0, true, 'L', 0, '', 0, true, 'M', 'M');
        
        $this->SetY(25);
        
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
$pdf->SetMargins(PDF_MARGIN_LEFT, 30, PDF_MARGIN_RIGHT);
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
$pdf->AddPage('L', 'A4');
$pdf->setRTL(true);
$pdf->Ln(3);
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
<table cellpadding="4" border="1">
    <thead>
        <tr style="background-color: #01915c; color: white; text-align: center; font-size: 17px; font-weight: bold;">
            <th>الفعالية</th>
            <th>نوع الفعالية</th>
            <th>تصنيف الفعالية</th>
            <th>الجهة المنظمة</th>
            <th>موقع الفعالية</th>
            <th>الحضور المتوقع</th>
            <th>عدد أفراد الشرطة</th>
            <th>يوم الفعالية</th>
            <th>التاريخ</th>
        </tr>
    </thead>
    <tbody>
    <tr align="center">
            <td>'.$row['EVENT_NAME'].'</td>
            <td>'.$row['EVENT_TYPE'].'</td>
            <td>'.$row['CLASSIFICATION'].'</td>
            <td>'.$row['ORGANIZER'].'</td>
            <td>'.$row['EVENT_LOCATION'].'</td>
            <td>'.$row['EXPECTED_AUDIENCE'].'</td>
            <td>'.$row['POLICE_COUNT'].'</td>
            <td>'.$row['EVENT_DAY'].'</td>
            <td>'.date('Y/m/d', strtotime($row['EVENT_DATE'])).'</td>
        </tr>
    </tbody>
</table>';

$query = "SELECT * FROM T_COORDINATORS WHERE EVENT_ID = " . $_GET['id'];
$result = mysqli_query($connect,$query);
$output .= '<h3>حضور التنسيق والمعاينة:</h3>
<table width="95%" cellpadding="4" border="0">
<thead>
    <tr style="background-color: #01915c; color: white; text-align: center; font-size: 17px; font-weight: bold;">
        <th width="15%" style="background-color: #fff;"></th>
        <th border="1">الإسم</th>
        <th border="1">الجهة</th>
        <th border="1">المنصب</th>
    </tr>
</thead>';

while ($row = mysqli_fetch_array($result)) {
    $output .= '<tr align="center">
        <td width="15%" style="background-color: #fff;"></td>
        <td border="1">'.$row['NAME'].'</td>
        <td border="1">'.$row['REFERENCE'].'</td>
        <td border="1">'.$row['POSITION'].'</td>
	</tr>';
}

$output .= '</table>';

$query = "SELECT * FROM T_EVENT_INFO WHERE EVENT_ID = " . $_GET['id'];
$result = mysqli_query($connect,$query);
$row = mysqli_fetch_array($result);
$output .= '<h3>بيانات أخرى عن الفعالية:</h3>
<table width="95%" cellpadding="4" border="0">
    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td style="font-size: 17px; font-weight: bold;" border="1">شخصيات هامة</td>
        <td border="1">';
        if ($row['VIPS_EXIST']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td style="font-size: 17px; font-weight: bold;" border="1">فعالية مصاحبة</td>
        <td border="1">';
        if ($row['OTHER_EVENT']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td style="font-size: 17px; font-weight: bold;" border="1">فنادق إقامة</td>
        <td border="1">';
        if ($row['HOTELS']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td style="font-size: 17px; font-weight: bold;" border="1">غرفة عمليات</td>
        <td border="1">';
        if ($row['OPERATION_ROOM']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td style="font-size: 17px; font-weight: bold;" border="1">مكتب للشرطة</td>
        <td border="1">';
        if ($row['POLICE_OFFICE']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td style="font-size: 17px; font-weight: bold;" border="1">مهبط طائرة</td>
        <td border="1">';
        if ($row['HELIPORTS']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td style="font-size: 17px; font-weight: bold;" border="1">جهات إعلامية</td>
        <td border="1">';
        if ($row['MEDIA']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td style="font-size: 17px; font-weight: bold;" border="1">موقع غرفة العمليات</td>
        <td border="1">'. $row['OPERATION_ROOM_LOCATION'] .'</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td style="font-size: 17px; font-weight: bold;" border="1">هل غرفة العمليات تغطي الحدث</td>
        <td border="1">';
        if ($row['OPERATION_ROOM_COVERING']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td style="font-size: 17px; font-weight: bold;" border="1">عدد الكاميرات</td>
        <td border="1">'. $row['CAMERAS_NUMBER'] .'</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td style="font-size: 17px; font-weight: bold;" border="1">هل الكاميرات تقوم بعملية التسجيل</td>
        <td border="1">';
        if ($row['CAMERAS_RECORDING']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td style="font-size: 17px; font-weight: bold;" border="1">عدد المداخل الفرعية</td>
        <td border="1">'. $row['SUB_ENTRIES'] .'</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td style="font-size: 17px; font-weight: bold;" border="1">عدد المداخل الرئيسية</td>
        <td border="1">'. $row['MAIN_ENTRIES'] .'</td>
    </tr>

    <tr style="text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td style="font-size: 17px; font-weight: bold;" border="1">هل يوجد متطوعين</td>
        <td border="1">';
        if ($row['VOLUNTEERS']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td style="font-size: 17px; font-weight: bold;" border="1">عدد المتطوعين</td>
        <td border="1">'. $row['VOLUNTEERS_NUMBER'] .'</td>
    </tr>

    <tr style="text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td style="font-size: 17px; font-weight: bold;" border="1">أخرى</td>
        <td border="1">'. $row['OTHER_INFO'] .'</td>
    </tr>
</table>';

$query = "SELECT * FROM T_EVENT_HOTELS WHERE EVENT_ID = " . $_GET['id'];
$result = mysqli_query($connect,$query);
$output .= '<h3>الفنادق المخصصة للمشاركين في الفعالية:</h3>
<table width="95%" cellpadding="4" border="0">
<thead>
    <tr style="background-color: #01915c; color: white; text-align: center; font-size: 17px; font-weight: bold;">
        <th width="15%" style="background-color: #fff;"></th>
        <th border="1">إسم الفندق</th>
        <th border="1">الموقع</th>
        <th border="1">إحداثيات المكان</th>
    </tr>
</thead>';

while ($row = mysqli_fetch_array($result)) {
    $output .= '<tr align="center">
        <td width="15%" style="background-color: #fff;"></td>
        <td border="1">'.$row['HOTEL_NAME'].'</td>
        <td border="1">'.$row['HOTEL_LOCATION'].'</td>
        <td border="1">'.$row['HOTEL_COORDINATES'].'</td>
	</tr>';
}

$output .= '</table>';

$query = "SELECT * FROM T_EVENT_PARTICIPANTS WHERE EVENT_ID = " . $_GET['id'];
$result = mysqli_query($connect,$query);
$row = mysqli_fetch_array($result);
$output .= '<h3>الجهات المشاركة في الفعالية:</h3>
<table width="95%" cellpadding="4" border="0">
    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td style="font-size: 17px; font-weight: bold;" border="1">جهاز أمن الدولة</td>
        <td border="1">';
        if ($row['SECURITY_SERVICE']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td style="font-size: 17px; font-weight: bold;" border="1">الإدارة العامة للمرور</td>
        <td border="1">';
        if ($row['TRAFFIC']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td style="font-size: 17px; font-weight: bold;" border="1">الإدارة العامة الدفاع المدني</td>
        <td border="1">';
        if ($row['CIVIL_DEFENCE']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td style="font-size: 17px; font-weight: bold;" border="1">التحريات والمباحث الجنائية</td>
        <td border="1">';
        if ($row['CRIMINAL_INVESTIGATIONS']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td style="font-size: 17px; font-weight: bold;" border="1">شركات الأمن الخاص</td>
        <td border="1">';
        if ($row['PRIVATE_SECURITY']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td style="font-size: 17px; font-weight: bold;" border="1">الإدارة العامة للعمليات</td>
        <td border="1">';
        if ($row['OPERATIONS']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td style="font-size: 17px; font-weight: bold;" border="1">الأدلة الجنائية وعلم الجريمة</td>
        <td border="1">';
        if ($row['FORENSIC_CRIMINOLOGY']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td style="font-size: 17px; font-weight: bold;" border="1">المركز المختص</td>
        <td border="1">';
        if ($row['COMPETENT_CENTER']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td style="font-size: 17px; font-weight: bold;" border="1">إدارة أمن المتفجرات</td>
        <td border="1">';
        if ($row['EXPLOSIVES_SECURITY']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td style="font-size: 17px; font-weight: bold;" border="1">إدارة امن وحماية الشخصيات</td>
        <td border="1">';
        if ($row['PERSONAL_SECURITY']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td style="font-size: 17px; font-weight: bold;" border="1">هيئة الطرق والمواصلات</td>
        <td border="1">';
        if ($row['TRANSPORTATION']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td style="font-size: 17px; font-weight: bold;" border="1">الإدارة العامة للنقل والإنقاذ</td>
        <td border="1">';
        if ($row['TRANSPORT_RESCUE']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td style="font-size: 17px; font-weight: bold;" border="1">إدارة التفتيش الأمني</td>
        <td border="1">';
        if ($row['SECURITY_INSPECTION']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td style="font-size: 17px; font-weight: bold;" border="1">إدارة المتفجرات</td>
        <td border="1">';
        if ($row['EXPLOSIVES']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td style="font-size: 17px; font-weight: bold;" border="1">الإدارة العامة لأمن المطارات</td>
        <td border="1">';
        if ($row['AIRPORTS_SECURITY']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td style="font-size: 17px; font-weight: bold;" border="1">الإسعاف الموحد</td>
        <td border="1">';
        if ($row['AMBULANCE']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td style="font-size: 17px; font-weight: bold;" border="1">أخرى</td>
        <td border="1">'. $row['OTHER_PARTICIPANTS'] .'</td>
    </tr>
</table>';

$query = "SELECT * FROM T_EVENT_NEEDS WHERE EVENT_ID = " . $_GET['id'];
$result = mysqli_query($connect,$query);
$row = mysqli_fetch_array($result);
$output .= '<br><h3>احتياجات عملية التأمين:</h3>
<table width="95%" cellpadding="4" border="0">
    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td border="1" style="font-size: 17px; font-weight: bold;">عدد الافراد</td>
        <td border="1">'. $row['INDIVIDUALS'] .'</td>
    </tr>

    <tr style="text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td border="1" style="font-size: 17px; font-weight: bold;">عدد الدوريات الامنية</td>
        <td border="1">'. $row['PATROLS'] .'</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td border="1" style="font-size: 17px; font-weight: bold;">عدد الاجهزة</td>
        <td border="1">'. $row['DEVICES'] .'</td>
    </tr>

    <tr style="text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td border="1" style="font-size: 17px; font-weight: bold;">عدد الباصات</td>
        <td border="1">'. $row['BUSES'] .'</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td border="1" style="font-size: 17px; font-weight: bold;">عدد عناصر الشرطة النسائية</td>
        <td border="1">'. $row['FEMALE_OFFICERS'] .'</td>
    </tr>

    <tr style="text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td border="1" style="font-size: 17px; font-weight: bold;">عدد الحواجز الأمنية</td>
        <td border="1">'. $row['SECURITY_BLOCKS'] .'</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td border="1" style="font-size: 17px; font-weight: bold;">عدد الدراجات الهوائية والنارية</td>
        <td border="1">'. $row['BIKES_MOTOBIKES'] .'</td>
    </tr>

    <tr style="text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td border="1" style="font-size: 17px; font-weight: bold;">أخرى</td>
        <td border="1">'. $row['OTHER_NEEDS'] .'</td>
    </tr>
</table>';

$query = "SELECT * FROM T_EVENT_TRANSPORTATION WHERE EVENT_ID = " . $_GET['id'];
$result = mysqli_query($connect,$query);
$row = mysqli_fetch_array($result);
$output .= '<h3>نوع المواصلات:</h3>
<table width="95%" cellpadding="4" border="0">
    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td border="1" style="font-size: 17px; font-weight: bold;">باص</td>
        <td border="1">';
        if ($row['BUS']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td border="1" style="font-size: 17px; font-weight: bold;">سيارة</td>
        <td border="1">';
        if ($row['CAR']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td border="1" style="font-size: 17px; font-weight: bold;">سيارة اجرة</td>
        <td border="1">';
        if ($row['TAXI']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td border="1" style="font-size: 17px; font-weight: bold;">مترو</td>
        <td border="1">';
        if ($row['METRO']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td border="1" style="font-size: 17px; font-weight: bold;">أخرى</td>
        <td border="1">';
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
<table width="95%" cellpadding="4" border="0">
    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td border="1" style="font-size: 17px; font-weight: bold;">خطة الطوارئ والاخلاء</td>
        <td border="1">';
        if ($row['EMERGENCY_PLAN']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td border="1" style="font-size: 17px; font-weight: bold;">أسماء الشخصيات الهامة</td>
        <td border="1">';
        if ($row['VIP_LIST']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td border="1" style="font-size: 17px; font-weight: bold;">البطاقات التعريفية</td>
        <td border="1">';
        if ($row['ID_CARDS']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td border="1" style="font-size: 17px; font-weight: bold;">المراسلات والمخاطبات</td>
        <td border="1">';
        if ($row['CORRESPONDENCE']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td border="1" style="font-size: 17px; font-weight: bold;">كشف الافراد</td>
        <td border="1">';
        if ($row['INDIVIDUALS_LIST']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td border="1" style="font-size: 17px; font-weight: bold;">بطاقة الدعوة</td>
        <td border="1">';
        if ($row['INVITATION_CARD']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td border="1" style="font-size: 17px; font-weight: bold;">كشف المتطوعين</td>
        <td border="1">';
        if ($row['VOLUNTEERS_LIST']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td border="1" style="font-size: 17px; font-weight: bold;">كشف افراد الجهات المنظمة</td>
        <td border="1">';
        if ($row['ORGINZERS_LIST']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td border="1" style="font-size: 17px; font-weight: bold;">كشف عناصر الشركات الامنية</td>
        <td border="1">';
        if ($row['SECURITY_LIST']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td border="1" style="font-size: 17px; font-weight: bold;">خطط الجهات المشاركة</td>
        <td border="1">';
        if ($row['PARTICIPANTS_PLANS']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td border="1" style="font-size: 17px; font-weight: bold;">تكلفة العملية</td>
        <td border="1">';
        if ($row['OPERATION_COST']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td border="1" style="font-size: 17px; font-weight: bold;">استمارة تصنيف العملية</td>
        <td border="1">';
        if ($row['CLASSIFICATION_FORM']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td border="1" style="font-size: 17px; font-weight: bold;">استمارة نجاح الفعالية</td>
        <td border="1">';
        if ($row['SUCCESS_FORM']) {
            $output .= 'نعم';    
        }
        else {
            $output .= 'لا';    
        }
        $output .= '</td>
    </tr>

    <tr style="text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td border="1" style="font-size: 17px; font-weight: bold;">أخرى</td>
        <td border="1">'. $row['REPORT_OTHERS'] .'</td>
    </tr>

    <tr style="background-color: #01915c; color: white; text-align: center;">
        <td width="19%" style="background-color: #fff;"></td>
        <td border="1" style="font-size: 17px; font-weight: bold;">ملاحظات</td>
        <td>'. $row['NOTES'] .'</td>
    </tr>
</table>';


$output .= '<h3>القائم بالتنسيق والمعاينة:</h3><table width="100%">
<tr>
    <td width="40px">الرتبة:</td>
    <td>'. $coordinator_row['RANK'] .'</td>
    <td width="40px">الإسم:</td>
    <td>'. $coordinator_row['FULL_NAME'] .'</td>
</tr>
<tr><td></td><td></td></tr>';
if ($coordinator_row['IMG_SIGNATURE']) {
    $output .='<tr>
        <td width="16%">التوقيع:</td>
        <td><img src="../IMAGES/'. $coordinator_row['IMG_SIGNATURE'] .'" style="width: 100px; height: 100px;"></td>
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
