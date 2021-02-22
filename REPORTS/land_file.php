<?php



include "../ASSETS/PHP/TCPDF/tcpdf.php";
include "../MODEL/connect.php";

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator('Ministry');
$pdf->SetAuthor('Ministry');
$pdf->SetTitle('Report');
$pdf->SetSubject('Report');
$pdf->SetKeywords('TCPDF, PDF, Report');

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(0);

// remove default footer
$pdf->setPrintFooter(false);

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

// set font
$pdf->SetFont('amiri', '', 48);


// remove default header
$pdf->setPrintHeader(false);



$land = $_GET['land_no'];
$district = $_GET['district_no'];

$query = "SELECT * FROM T_DOCS WHERE LAND_NO='".$land."' AND DISTRICT_NO = ".$district;
$res = mysqli_query($connect,$query);

if (mysqli_num_rows($res)>0)
{

    while ($row=mysqli_fetch_array($res)) {
// add a page
        $pdf->AddPage();
// get the current page break margin
        $bMargin = $pdf->getBreakMargin();
// get current auto-page-break mode
        $auto_page_break = $pdf->getAutoPageBreak();
// disable auto-page-break
        $pdf->SetAutoPageBreak(false, 0);
// set bacground image
        $img_file = "../IMAGES/".$row['DOC_FILE'];
        $pdf->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
// restore auto-page-break status
        $pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// set the starting point for the page content
        $pdf->setPageMark();
    }

}else{
    $pdf->AddPage();

    $html = <<<EOD
    <br/>
    <br/>
    <br/>
    <br/>
    <table width="100%" cellpadding="3">
    <tr align="center"><td>لاتوجد مستندات لقطعة الأرض هذه.</td></tr>
    </table>
EOD;


// print a block of text using Write()

    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

}
// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('Land_file.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
