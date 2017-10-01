<?php
require_once('pdf/tcpdf.php');
require_once('pdf/fpdi/fpdi.php'); // the addon

// FPDI extends the TCPDF class, so you keep all TCPDF functionality
$pdf = new FPDI();

$pdf->AddPage();
$pdf->setSourceFile(get_template_directory() . '/dial_base.pdf');
// FPDI's importPage returns an object that you can insert with TCPDF's useTemplate
$pdf->useTemplate($pdf->importPage(1)); 
$pdf->AddPage();
$pdf->useTemplate($pdf->importPage(2));
$pdf->AddPage();
$pdf->useTemplate($pdf->importPage(3));


$dial = get_query_var('dial');
$wheel = get_public_wheel_details($dial);
$answers = get_public_wheel_rest(array('id' => $dial));
$answers = $answers['answers'];
error_log($answers[0]->answer);

// create new PDF document
//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator('Trusted Data Dial by Parhelion');
$pdf->SetAuthor('parhelion.co.nz');
$pdf->SetTitle('Dial title');
$pdf->SetSubject('Trusted Data Dial');
$pdf->SetKeywords('Trusted Data, Data Dial');

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'Trusted data dial pdf test', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
$pdf->setFooterData(array(0,64,0), array(0,64,128));

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

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 7, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
//$pdf->AddPage();

// set text shadow effect
$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// Set some content to print
$answer0 = $answers[0]->answer;
$answer1 = $answers[1]->answer;
$answer2 = $answers[2]->answer;
$answer3 = $answers[3]->answer;
$answer4 = $answers[4]->answer;
$answer5 = $answers[5]->answer;
$answer6 = $answers[6]->answer;
$answer7 = $answers[7]->answer;
$html = <<<EOD
<!-- h1>$wheel->name</h1>
<img src="https://trusteddata.co.nz/media/dial.png" width="180px" height="180px" align="center" style="display:block;margin:auto"/>
<h1>Trusted data answers</h1 -->

<table border="0" height="210px"><tr height="210px"><td height="300px"></td></tr></table>

<table border="0" bordercolor="red" cellpadding="14">
    <tr height="125px">
        <td width="50px">&nbsp;</td>
        <td height="125px" width="260px">$answer0</td>
        <td width="40px">&nbsp;</td>
        <td height="125px" width="260px">$answer1</td>
    </tr>
    <tr height="20px">
        <td colspan="4" height="20px">&nbsp;</td>
    </tr>
    <tr heigh="150px">
         <td width="50px">&nbsp;</td>
        <td height="125px" width="260px">$answer2</td>
        <td width="40px">&nbsp;</td>
        <td height="125px" width="260px">$answer3</td>
    </tr>
    <tr height="20px">
        <td colspan="4" height="20px">&nbsp;</td>
    </tr>
    <tr heigh="150px">
         <td width="50px">&nbsp;</td>
        <td height="125px" width="260px">$answer4</td>
        <td width="40px">&nbsp;</td>
        <td height="125px" width="260px">$answer5</td>
    </tr>
    <tr height="20px">
        <td colspan="4" height="20px">&nbsp;</td>
    </tr>
    <tr heigh="150px">
         <td width="50px">&nbsp;</td>
        <td height="125px" width="260px">$answer6</td>
        <td width="40px">&nbsp;</td>
        <td height="125px" width="260px">$answer7</td>
    </tr>



</table>


EOD;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

$pdf->AddPage();
$pdf->useTemplate($pdf->importPage(4));
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('data_dial.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+