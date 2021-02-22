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
        // Set font

        $this->SetFont('aealarabiya', 'BU', 13);
        $da = date("Y/m/d");
        $this->Cell('', 5,' الأراضي منتهية الإيجارة في تاريخ  : '.$da, 0, true, 'C', 0, '', 0, true, 'M', 'M');
        $this->ln();
        $this->ln();
        $this->ln();
        $this->SetFont('aealarabiya', 'B', 13);

        $this->Cell(180, 5,'   #             المحلية                       المربوع                         رقم القطعة                  تاريخ إنتهاء الإيجارة      ', 0, true, 'L', 0, '', 0, true, 'M', 'M');
        // Title
        $this->SetLineStyle(array('width' => 0.90 / $this->k, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0));
        $this->SetY((5 / $this->k) + max(5, $this->y));
        if ($this->rtl) {
            $this->SetX($this->original_rMargin);
        } else {
            $this->SetX($this->original_lMargin);
        }
        $this->Cell(($this->w - $this->original_lMargin - $this->original_rMargin), 1, '', 'T', 1, 'C');
        $this->endTemplate();


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
		$this->Cell(0, 4, 'وزارة الزراعة والثروة الحيوانية والري       -      نظام الأرشيف', 0, false, 'L', 0, '', 0, false, 'T', 'L');
	}
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('SudanMinistry');
$pdf->SetTitle('SudanMinistry');
$pdf->SetSubject('Transactions In Period');


// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
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

// set font
$pdf->SetFont('amiri', '', 11);


include "../MODEL/connect.php";

$da = date("Y/m/d");
$output = "";

$dislandsquery = "SELECT * FROM T_TRANSACTION WHERE TRANSACTION_NO = 6";
$dislandsres = mysqli_query($connect,$dislandsquery);
$count = 1;
while ($dislandsrow=mysqli_fetch_array($dislandsres))
{

    $query = "SELECT MAX(TRANS_DATE) AS LAST_DATE,LAND_NO,DISTRICT_NAME,LOCALE_NAME,DISTRICT_NO FROM 
 T_LOCALES JOIN T_DISTRICTS USING (LOCALE_NO) JOIN T_LANDS USING (DISTRICT_NO)
 JOIN T_TRANSACTION USING (LAND_NO,DISTRICT_NO)
 WHERE (TRANSACTION_NO = 1 OR TRANSACTION_NO =2) AND STATUS = 0
 AND DISTRICT_NO = ".$dislandsrow['DISTRICT_NO']." AND
 LAND_NO = '".$dislandsrow['SEC_LAND_NO']."'
 GROUP BY LAND_NO,DISTRICT_NAME,LOCALE_NAME,DISTRICT_NO";

    $res = mysqli_query($connect,$query);


    if (mysqli_num_rows($res)>0)
    {
        $row = mysqli_fetch_array($res);
        $q = "SELECT PERIOD FROM T_TRANSACTION WHERE 
    (TRANSACTION_NO = 1 OR TRANSACTION_NO = 2)
    AND TRANS_DATE ='".$row['LAST_DATE']."' AND
    LAND_NO = '".$row['LAND_NO']."' AND DISTRICT_NO = ".$row['DISTRICT_NO'];

        $r = mysqli_query($connect,$q);
        $w = mysqli_fetch_array($r);

        $date = new DateTime("".$row['LAST_DATE']."");
        $date->add(new DateInterval('P'.$w['PERIOD'].'Y'));
        $top_date = $date->format('Y-m-d');


        if ($top_date<$da)
        {
            $output .='
        <tr align="center">
        <td width="25%">'.$top_date.'</td>
        <td width="25%">'.$row['LAND_NO'].'</td>
        <td width="25%">'.$row['DISTRICT_NAME'].'</td>
        <td width="20%">'.$row['LOCALE_NAME'].'</td>
        <td width="5%">'.$count++.'</td>
        </tr>';
        }
    }
    else
    {
        $query = "SELECT MAX(TRANS_DATE) AS LAST_DATE,LAND_NO,DISTRICT_NAME,LOCALE_NAME,DISTRICT_NO FROM 
        T_LOCALES JOIN T_DISTRICTS USING (LOCALE_NO) JOIN T_LANDS USING (DISTRICT_NO)
        JOIN T_TRANSACTION USING (LAND_NO,DISTRICT_NO)
        WHERE (TRANSACTION_NO = 1 OR TRANSACTION_NO =2) AND STATUS = 0
        AND DISTRICT_NO = ".$dislandsrow['DISTRICT_NO']." AND
        LAND_NO = '".$dislandsrow['LAND_NO']."'
        GROUP BY LAND_NO,DISTRICT_NAME,LOCALE_NAME,DISTRICT_NO";

        $res = mysqli_query($connect,$query);
        $row = mysqli_fetch_array($res);
        $q = "SELECT PERIOD FROM T_TRANSACTION WHERE 
    (TRANSACTION_NO = 1 OR TRANSACTION_NO = 2)
    AND TRANS_DATE ='".$row['LAST_DATE']."' AND
    LAND_NO = '".$row['LAND_NO']."' AND DISTRICT_NO = ".$row['DISTRICT_NO'];

        $r = mysqli_query($connect,$q);
        $w = mysqli_fetch_array($r);

        $date = new DateTime("".$row['LAST_DATE']."");
        $date->add(new DateInterval('P'.$w['PERIOD'].'Y'));
        $top_date = $date->format('Y-m-d');


        if ($top_date<$da)
        {
            $output .='
        <tr align="center">
        <td width="25%">'.$top_date.'</td>
        <td width="25%">'.$dislandsrow['SEC_LAND_NO'].'</td>
        <td width="25%">'.$row['DISTRICT_NAME'].'</td>
        <td width="20%">'.$row['LOCALE_NAME'].'</td>
        <td width="5%">'.$count++.'</td>
        </tr>';
        }
    }

}

$query = "SELECT MAX(TRANS_DATE) AS LAST_DATE,LAND_NO,DISTRICT_NAME,LOCALE_NAME,DISTRICT_NO FROM 
 T_LOCALES JOIN T_DISTRICTS USING (LOCALE_NO) JOIN T_LANDS USING (DISTRICT_NO)
 JOIN T_TRANSACTION USING (LAND_NO,DISTRICT_NO)
 WHERE (TRANSACTION_NO = 1 OR TRANSACTION_NO =2) AND STATUS = 0 
 GROUP BY LAND_NO,DISTRICT_NAME,LOCALE_NAME,DISTRICT_NO";

$res = mysqli_query($connect,$query);

$count = 1;
while ($row=mysqli_fetch_array($res))
{
    $q = "SELECT PERIOD FROM T_TRANSACTION WHERE 
    (TRANSACTION_NO = 1 OR TRANSACTION_NO = 2)
    AND TRANS_DATE ='".$row['LAST_DATE']."' AND
    LAND_NO = '".$row['LAND_NO']."' AND DISTRICT_NO = ".$row['DISTRICT_NO'];

    $r = mysqli_query($connect,$q);
    $w = mysqli_fetch_array($r);

    $date = new DateTime("".$row['LAST_DATE']."");
    $date->add(new DateInterval('P'.$w['PERIOD'].'Y'));
    $top_date = $date->format('Y-m-d');


    if ($top_date<$da)
    {
        $output .='
        <tr align="center">
        <td width="25%">'.$top_date.'</td>
        <td width="25%">'.$row['LAND_NO'].'</td>
        <td width="25%">'.$row['DISTRICT_NAME'].'</td>
        <td width="20%">'.$row['LOCALE_NAME'].'</td>
        <td width="5%">'.$count++.'</td>
        </tr>';
    }

}


if ($output=='')
    $output .= '<tr align="center"><td>لاتوجد بيانات</td></tr>';

$html = <<<EOD

<table width="100%" cellpadding="3">
$output
</table>

EOD;


// print a block of text using Write()

$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);


//Close and output PDF document

$pdf->Output('OutRentedLands.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

?>
