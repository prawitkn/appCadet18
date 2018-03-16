<?php
ini_set('memory_limit', '1024M');
include('session.php');
//include('prints_function.php');
//include('inc_helper.php');

// Include the main TCPDF library (search for installation path).
require_once('tcpdf/tcpdf.php');

function to_thai_short_date($eng_date){
	if(strlen($eng_date) != 10){
		return null;
	}else{
		$new_date = explode('-', $eng_date);

		$new_y = (int) $new_date[0] + 543;
		$new_m = $new_date[1];
		$new_d = $new_date[2];

		//$new_d = to_thai_number((int)$new_d); // 01 -> ๑
	
		$thai_date = $new_d . '/' . $new_m . '/' . substr($new_y, 2, 2);
		//replace thai month
		$thai_short_date = '';
		switch($new_m){
			case '01' : $thai_short_date = str_replace("/01/"," ม.ค.",$thai_date); break;
			case '02' : $thai_short_date = str_replace("/02/"," ก.พ.",$thai_date); break;
			case '03' : $thai_short_date = str_replace("/03/"," มี.ค.",$thai_date); break;
			case '04' : $thai_short_date = str_replace("/04/"," เม.ย.",$thai_date); break;
			case '05' : $thai_short_date = str_replace("/05/"," พ.ค.",$thai_date); break;
			case '06' : $thai_short_date = str_replace("/06/"," มิ.ย.",$thai_date); break;
			case '07' : $thai_short_date = str_replace("/07/"," ก.ค.",$thai_date); break;
			case '08' : $thai_short_date = str_replace("/08/"," ส.ค.",$thai_date); break;
			case '09' : $thai_short_date = str_replace("/09/"," ก.ย.",$thai_date); break;
			case '10' : $thai_short_date = str_replace("/10/"," ต.ค.",$thai_date); break;
			case '11' : $thai_short_date = str_replace("/11/"," พ.ย.",$thai_date); break;
			case '12' : $thai_short_date = str_replace("/12/"," ธ.ค.",$thai_date); break;
		}
		
		//$thai_short_date = to_thai_number($thai_short_date);
		
		return $thai_short_date;
	}
}


// Extend the TCPDF class to create custom Header and Footer

class MYPDF extends TCPDF {
	//Page header
    public function Header() {
		// Set font
		$this->SetFont('THSarabun', '', 16, '', true);
		// Title
        
		//$this->SetY(11);			
		//if($this->page != 1){
			//Page No. top right n/N
			//$this->Cell(0, 5, $this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
			
			//$this->Cell(0, 5, '- '.$this->getAliasNumPage().' -', 0, false, 'C', 0, '', 0, false, 'T', 'M');
		//}
		 // Logo
        //$image_file = '../asset/img/logo-asia-kangnam.jpg';
        //$this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		//$this->SetY(5);	
		//$this->Cell(0, 5, 'ตท. 18', 0, false, 'C', 0, '', 0, false, 'M', 'M');
		//$html='<h3 style="text-align: center;">ตท.18</h3>';
		//$this->writeHTML($html, true, false, true, false, '');
			  
		//$this->Ln(5);
        //$this->Cell(0, 5, 'xxx', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }
    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        ///$this->SetY(-15);
        // Set font
        //$this->SetFont('THSarabun', '', 14, '', true);
        // Page number
		//$tmp = date('Y-m-d H:i:s');
		//$tmp = to_thai_short_date_fdt($tmp);
		//$this->Cell(0, 10,'Print : '. $tmp, 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }
}



// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$title="Cadet18";
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Prawit Khamnet');
$pdf->SetTitle($title);
$pdf->SetSubject($title);
$pdf->SetKeywords($title);



// set default header data

$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);



// set header and footer fonts

$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));



// remove default header/footer

$pdf->setPrintHeader();

$pdf->setPrintFooter(false);



// set default monospaced font

$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);



//set margins

//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetMargins(20, 15, 10);
$pdf->setCellHeightRatio(1);
$pdf->SetFont('THSarabun', '', 14);

//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);

//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);



//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);



//set some language-dependent strings

//$pdf->setLanguageArray($l);



// ---------------------------------------------------------



$sql = "SELECT  `id`, `mid`, `fullname`, `photo`, `nickname`, `origin`, `genNo`, `subService`,`position`, `workPlace`, `workPlace2`
, `dateOfBirth`, `mobileNo`, `tel`, `email`, `address`,`address2`,`groupCode`, `groupName`, `group2code`, `group2Name`, `statusCode`, `retireYear` 
, IF(left(name,1) IN ('เ','แ','ไ','ใ','โ'),right(name,CHAR_LENGTH(name)-1),name) as nameForOrder 
FROM cadet18_person a
WHERE 1 ";
if(isset($_GET['groupCode'])){
	$sql.="and a.groupCode = :groupCode ";
}
if(isset($_GET['search_word']) and isset($_GET['search_word'])){
	$sql.="and (a.id = :search_word OR a.fullname like :search_word2) ";
}
if(isset($_GET['groupCode'])){
	switch($_GET['groupCode']){
		case 2 : 
			$sql .="ORDER BY CAST(a.groupCode AS UNSIGNED), CAST(a.group2Code AS DECIMAL(10,2)), nameForOrder "; 
			break;
		default : 
			$sql .="ORDER BY CAST(a.groupCode AS UNSIGNED), CAST(a.group2Code AS DECIMAL(10,2)), a.id "; 		
	}
}


		
/*if(isset($_GET['groupCode']) AND $_GET['groupCode']<>""){
	if($_GET['groupCode']==3){
		$sql .="				
		ORDER BY CAST(a.groupCode AS UNSIGNED), CAST(a.group2Code AS DECIMAL(10,2)), a.id 
		"; 
	}else{
		$sql .="				
		ORDER BY CAST(a.groupCode AS UNSIGNED), CAST(a.group2Code AS DECIMAL(10,2)), a.name 
		"; 
	}
}*/

$stmt = $pdo->prepare($sql);
if(isset($_GET['groupCode']) AND $_GET['groupCode']<>""){
	$stmt->bindParam(':groupCode', $_GET['groupCode']);
}
if(isset($_GET['search_word']) and isset($_GET['search_word'])){
	$search_word='%'.$_GET['search_word'].'%';
	$stmt->bindParam(':search_word', $search_word);
	$stmt->bindParam(':search_word2', $search_word);
}
$stmt->execute();				



//$dbquery = mysql_query($sql);

//$pdf->AddPage();	

$i = 1;
$iperpage = 0;
$ititle = "";
$ititle2 = "";
$html="";
//$html="<table border=\"1\">";

//$pdf->AddPage('P','A4');
while ($result = $stmt->fetch()) {
	if($i==0){
		$iperpage = 0;	
		$ititle = $result['groupName'];		
		$ititle2 =  $result['group2Name'];
		$html.='<h3 style="text-align: center;">ทำเนียบ ตท. 18 ('.$ititle.')</h3>
		<h4 style="text-decoration: underline;">'.$ititle2.'</h4>
		<table>
		';
	}else{
		if(trim($ititle2) != trim($result['group2Name'])){ 
			// output the HTML content
			$html .= '</table>';
			$pdf->writeHTML($html, true, false, true, false, '');
									
			$pdf->AddPage('P','A4');
			$iperpage = 0;	
			$ititle = $result['groupName'];		
			$ititle2 =  $result['group2Name'];
			$html='<h3 style="text-align: center;">ทำเนียบ ตท. 18 ('.$ititle.')</h3>
			<h4 style="text-decoration: underline;">'.$ititle2.'</h4>
			<table>
			';
		}else{
			if($iperpage==4){
				// output the HTML content
				$html .= '</table>';
				$pdf->writeHTML($html, true, false, true, false, '');
				
				$pdf->AddPage('P','A4');
				$iperpage = 0;	
				$ititle = $result['groupName'];		
				$ititle2 =  $result['group2Name'];
				$html='<h3 style="text-align: center;">ทำเนียบ ตท. 18 ('.$ititle.')</h3>
				<h4 style="text-decoration: underline;">'.$ititle2.'</h4>
				<table>
				';
			} //end if iperpage=4
		}//end if title2
	}//end if html=""	
	
	//$html .= '<tr>';
	$img='images/no_pic.jpg';
	if (file_exists('images/person/'.$result['photo'])) {
		if(trim($result['photo'])<>""){
			//$html .= '<td width="25%" style="border-bottom: 1px solid black;"><div align="center"><img src="images/'.$result['photo'].'" height="160"></div></td>';
			$img='images/person/'.$result['photo'];			
		}
		//$html .= '<td width="25%" style="border-bottom: 1px solid black;"><div align="center"><img src="images/no_pic.jpg" height="160"></div></td>';
	}else{
		//$html .= '<td width="25%" style="border-bottom: 1px solid black;"><div align="center"><img src="images/no_pic.jpg" height="160"></div></td>';
		
	}
	$html.="<tr style=\"font-weight: bold;\">";
	$html.='<td rowspan="7"><img src="'.$img.'" width="122" /></td>';
	$html.="<td>ยศ ชื่อ นามสกุล : </td>";
	$html.="<td colspan=\"2\">".$result['fullname']."</td>";
	$html.="<td>: ".trim($result['nickname'])."</td>";
	$html.="</tr>";
	
	$html.="<tr>";
	$html.="<td><b>ตำแหน่ง : </b></td>";
	$html.="<td colspan=\"3\">".$result['position']."</td>";
	$html.="</tr>";
	
	$html.="<tr>";
	$html.="<td><b>สถานที่ทำงาน : </b></td>";
	$html.="<td colspan=\"3\">".($result['workPlace']<>""?$result['workPlace']:"-")."</td>";
	$html.="</tr>";
	
	$html.="<tr>";
	$html.="<td><b></b></td>";
	$html.="<td colspan=\"3\">".($result['workPlace2']<>""?$result['workPlace2']:"-")."</td>";
	$html.="</tr>";
	
	$html.="<tr>";
	$html.="<td><b>ที่อยู่ : </b></td>";
	$html.="<td colspan=\"3\">".($result['address']<>""?$result['address']:"-")."</td>";
	$html.="</tr>";
	
	$html.="<tr>";
	$html.="<td><b></b></td>";
	$html.="<td colspan=\"3\">".($result['address2']<>""?$result['address2']:"-")."</td>";
	$html.="</tr>";
	
	$html.="<tr>";
	$html.="<td><b>โทร : </b></td>";
	$html.="<td colspan=\"3\">".$result['mobileNo'].' '.($result['tel']<>""?', '.$result['tel']:'')."</td>";
	$html.="</tr>";
	
	$html.="<tr>";
	$html.="<td></td>";
	$html.="<td colspan=\"3\"></td>";
	$html.="</tr>";
	
	
	$i++;
	$iperpage = $iperpage+1;
	
}



// output the HTML content
$html .= '</table>';
$html.="<h6 style=\"text-align: center;\">".($i-1)." นาย</h6>";
$pdf->writeHTML($html, true, false, true, false, '');



// reset pointer to the last page

$pdf->lastPage();



// ---------------------------------------------------------



//Change To Avoid the PDF Error 

ob_end_clean();

  

//Close and output PDF document

$pdf->Output($title.'.pdf', 'I');



//============================================================+

// END OF FILE                                                

//============================================================+