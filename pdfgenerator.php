<?php
include_once("functions/functions.php");


if(isset($_POST["gerarPDF"])){
	
	set_time_limit(120);
	ignore_user_abort(true);

// Include the main TCPDF library (search for installation path).
require_once('/tcpdf/tcpdf.php');
$mes=getMonthByNumber($_SESSION['MesReport']);
$html="";

class PDFGENERATOR extends TCPDF {

	public function Header() {
		if (count($this->pages) === 1) {
			$mes=getMonthByNumber($_SESSION['MesReport']);
			$hed ="";
			$this->SetXY(100, 100);
			$imgsrc="";
			$files = glob('UserScripts/'.$_SESSION["email"].'/reportImage/*'); // get all file names
			foreach($files as $file){ // iterate files
				if(is_file($file)){
					$imgsrc=$file;
				}
			}
			$hed .='<img src="/SDLPlatform/'.$imgsrc.'" width="150px" height="28px" align="center"></img><hr>
					<h1>Relat&oacute;rio de '.$mes.'<small> @ Seek Data Leakage Plataform</small></h1><br>';
			$this->writeHTML($hed, true, false, false, false, '');
			$this->startPageGroup();
			$this->AddPage();
	
			
		}else{
			$imgsrc="";
			$files = glob('UserScripts/'.$_SESSION["email"].'/reportImage/*'); // get all file names
			foreach($files as $file){ // iterate files
				if(is_file($file)){
					$imgsrc=$file;
				}
			}
			$image_file = '/SDLPlatform/'.$imgsrc;
			$this->Image($image_file, 15, 10, 20, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
			// Set font
			$this->SetFont('Times', 'B', 10);

		$headerData = $this->getHeaderData();
		
		$this->writeHTML($headerData['string']);
		}
	
	}

	// Page footer
	public function Footer() {
		if (count($this->pages)>1) {
		// Position at 15 mm from bottom
		$this->SetY(-15);
		// Set font
		$this->SetFont('Times', 'I', 8);
		// Page number
		$numpage=0;
		if($this->getAliasNumPage()==2){
			$numpage=1;
		}else{
			$numpage=$this->getAliasNumPage();
		}
		
		$this->Cell(0, 0, $this->writeHTML('<hr>').'Pagina '.$numpage.'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
		}
	}
	
	
}

// create new PDF document
$pdf = new PDFGENERATOR(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->setHeaderData($ln='', $lw=0, $ht='', $hs=''
		. '<br><hr>', $tc=array(0,0,0), $lc=array(0,0,0));

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('SDL Platform');
$pdf->SetTitle('Relatório SDLP');
$pdf->SetSubject('');
// $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
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
$pdf->SetFont('Times', '', 10, '', true);	

// $lol=TCPDF_FONTS::addTTFfont('/SDLPlatform/font-awesome/fonts/fontawesome-webfont.ttf', 'TrueTypeUnicode', '', 32);
// $pdf->SetFont($lol, '', 14, '', false);
// Add a page
// This method has several options, check the source code documentation for more information.

// set text shadow effect
// $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// Set some content to print
function getDLFoundByName($name){
	$get = connectDB_DLFound()->find(array('email' => $_SESSION["email"] , 'NomeRegra' => $name));
	$arrayAux=array();
	foreach ($get as $doc) {
			$arrayAux[]=$doc;
		}
	return $arrayAux;
}

$html=$html.'
   <style type="text/css">
   
.fa-globe:before {
    content: "\f0ac"
}
		
.fa-lock:before {
    content: "\f023"
}

.fa-th-large:before {
    content: "\f009"
}

		
.fa-th-list:before {
    content: "\f00b"
}
		
.fa-share:before {
    content: "\f064"
}	

.alignleft {
	float: left;
}
.alignright {
	float: right;
}
		
.tg  {border-collapse:collapse;border-spacing:0;border:none;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;}
.tg .tg-tarb{font-size:small;vertical-align:top}
		
		 </style>';

$id=0;
$collum = connectDB_DLFound();
$cursor = $collum->find(array('email' => $_SESSION["email"] , 'Termo' => $_SESSION['NomesRegrasParaReport'][$id]['Termo'] ,'NomeRegra' => $_SESSION['NomesRegrasParaReport'][$id]["NomeRegra"], 'falsePositiv' => 0));
$url="";
$shodan=array();
$shodanValue="";
$mes=$_SESSION['MesReport'];
$ano=$_SESSION['AnoReport'];
$m="";

foreach ($_POST["imagem"] as $val){
	foreach ($cursor as $nomeregra){
		$m = date_parse_from_format("Y-m-d", $nomeregra['DataFound']);
		if($_SESSION['NomesRegrasParaReport'][$id]['Plataform']=='PasteBin' && $m["month"] == $mes && $m["year"] == $ano){	
			

			$wu=$_SESSION['NomesRegrasParaReport'][$id]['Termo'];
			$pattern = preg_quote($wu, '/');
			$pattern = "/^.*$wu.*\$/m";
			$conteudo_encontrado="";
			
			preg_match_all($pattern, $nomeregra['TextoEncontrado'], $matches);
			
			foreach ($matches[0] as $value){
				$conteudo_encontrado=$conteudo_encontrado.$value.'';
			}
			
			$conteudo_encontrado=$conteudo_encontrado.'<br>';
			
			$url=$url.str_replace('api_scrape_item.php?i=','',$nomeregra['URL']).':<br>'.$conteudo_encontrado.'<br>';
			
			//$url=$url.str_replace('api_scrape_item.php?i=','',$nomeregra['URL']).'<br>'; //$nomeregra['TextoEncontrado'].'<hr></hr>';
			
		}
		
		if( $_SESSION['NomesRegrasParaReport'][$id]['Plataform']=='Shodan' && $m["month"] == $mes && $m["year"] == $ano
		){
			$shodan=$nomeregra['Dados'];
			
		}
	}
	
	$nome='Nome Regra: '.$_SESSION['NomesRegrasParaReport'][$id]["NomeRegra"];
	$termos='Termo: '.$_SESSION['NomesRegrasParaReport'][$id]['Termo'];
	$plataforma='Plataforma: '.$_SESSION['NomesRegrasParaReport'][$id]['Plataform'];
	
	
	if($_SESSION['NomesRegrasParaReport'][$id]['Plataform']=='PasteBin'){
	$html = $html.'
	<div style="text-align:center"><img src="/SDLPlatform/icons/pastebin.png" height="50" width="75"></img></div>
	
	'.$nome.'<br>
	'.$termos.'<br>
	Grafico Evolutivo: <br>
	<div style="text-align:center">
	<img src="'.$val.'" ></img>
	</div>
	<pre>Link de cada termo encontrado:<br><small>'.$url.'</small></pre><br>
	
	';
	$pdf->AddPage();
	$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
	$html = "";
	}

	
	if($_SESSION['NomesRegrasParaReport'][$id]['Plataform']=='Shodan'){
	$html = $html.'
			<div style="text-align:center"><img src="/SDLPlatform/icons/shodan.png" height="25" width="75">
			</div>
	'.$nome.'<br>
	'.$termos.'<br>
	Grafico Evolutivo: <br>
	<div style="text-align:center">
	<img src="'.$val.'" ></img>
	</div>
	Conteudo Encontrado:<br>
	';
	$term = array();
	$term=getDLFoundByName($_SESSION['NomesRegrasParaReport'][$id]["NomeRegra"]);
	foreach ($term as $valueterm){
		
	 	$html = $html.'	
	 			
	 
	 			
	 			
				<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;border:none;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;}
.tg .tg-tarb{font-size:small;vertical-align:top}


	 			
</style>
<table class="tg" style="undefined;table-layout: fixed; width: 100%">
<colgroup>
<col style="width: 50%">
<col style="width: 50%">
</colgroup>
  <tr>
    <th class="tg-tarb">'.$pdf->SetFont('fontawesome').'
	                    	<h3><span style="font-family:FontAwesome;font-size: 2em;">&#xf0ac;</span> '.$pdf->SetFont('Times', '', 10, '', true).$valueterm['Dados']['IP'].'  <small>'.$valueterm['Dados']['Hostname'].'</small></h3>
	                    	<hr>
		                            <table>
		                                <tbody>
		                                    <tr>
		                                        <td >Pais</td>
		                                        <td >'.$valueterm['Dados']['Pais'].'</td> 
		                                    </tr>
		                                     <tr>
		                                        <td >Organiza&ccedil;&atilde;o</td>
		                                        <td >'.$valueterm['Dados']['Organization'].'</td> 
		                                    </tr>
		                                     <tr>
		                                        <td >Hostname</td>
		                                        <td >'.$valueterm['Dados']['Hostname'].'</td> 
		                                    </tr>
		                                     <tr>
		                                        <td>ASN</td>
		                                        <td>'.$valueterm['Dados']['ASN'].'</td> 
		                                    </tr>
		                     			 </tbody>
		                            </table>

	';
	 	if(!empty($valueterm['Dados']['Certificado'])){
	 		setlocale(LC_ALL, 'pt_PT', 'pt_PT.utf-8', 'pt_PT.utf-8', 'portuguese');
	 		date_default_timezone_set('Europe/Lisbon');
	 	
	 		?>
	 								<?php 								
	 								$html.='
	 								<h3>'.$pdf->SetFont('fontawesome').'
	 		                    	<span style="font-family:FontAwesome;font-size: 2em;">&#xf023;</span>'.$pdf->SetFont('Times', '', 10, '', true).' Certificado SSL:</h3>
	 									<hr>
	 								
	 				                            <table>
	 				                                <tbody>
	 				                                    <tr>
	 				                                        <td>Emissor</td>
	 				                                        <td>'.$valueterm['Dados']['Certificado']['Emissor'].' ('.$valueterm['Dados']['Certificado']['EmissorCN'].')</td>
	 				
	 				                                    </tr>
	 				                                    <tr>
	 				                                        <td>Receptor</td>
	 				                                        <td>'.$valueterm['Dados']['Certificado']['Receptor'].' ('.$valueterm['Dados']['Certificado']['ReceptorCN'].')</td>
	 				           
	 				                                    </tr>
	 				                                    <tr>
	 				                                        <td>Emitido</td>
	 				                                        <td>'.$emitido=date("d/M/Y - H:i:s", strtotime($valueterm['Dados']['Certificado']['EmitidoEm'])).'</td>           
	 				                                    </tr>
	 				                                    <tr>
	 				                                        <td>Caduca</td>
	 				                                        <td>'.$expira=date("d/M/Y - H:i:s", strtotime($valueterm['Dados']['Certificado']['ExpiraEm'])).'</td>           
	 				                                    </tr>  
	 				                                </tbody>
	 				                            </table>
									<br>
	 				                        SSL:
									<br>
	 				                            <table>
	 				                                <tbody>
	 				                                    <tr>
	 				                                   		<td>Nome Cifra</td>
	 				                                        <td>'.$valueterm['Dados']['Certificado']['NomeCifra'].'</td>
	 				                                    </tr>
	 				                                    <tr>
	 				                                         <td>Vers&otilde;es SSL</td>
	 				                                        <td>'; foreach ($valueterm['Dados']['Certificado']['versoesSSL'] as $SSL){ $html.=$SSL.' ';}?> <?php $html.='</td>
	 				           
	 				                                    </tr>
	 				                                    <tr>
	 				                                        <td>Bits da Cifra:</td>
	 				                                        <td>'.$valueterm['Dados']['Certificado']['bitsCifra'].'</td>           
	 				                                    </tr>
	 		
	 				                                </tbody>
	 				                            </table>
	 									';
	 					
	 									 if(!empty($valueterm['Dados']['Certificado']['ChavePublica'])){?><?php  $html.='
	 									Chave Publica:<pre>'.$valueterm['Dados']['Certificado']['ChavePublica'].'</pre><br>';
	 									 }
	 									if(!empty($valueterm['Dados']['Certificado']['ParametrosDiffie-Hellman'])){
	 									?>
	 									<?php  $html.='Par&acirc;metros Diffie-Hellman: '.$valueterm['Dados']['Certificado']['ParametrosDiffie-Hellman'].'<br>
	 									'; }?>
	 									<?php  $html.='
	 									Chain:<br><pre>';foreach ($valueterm['Dados']['Certificado']['certificate'] as $SSL){ $html.=$SSL.'<br>';}?>;<?php  $html.='</pre>
	 									';
	 		           }?>
		                                        		
		                                        		
		                                        		
	 <?php  $html.='  	
                                     		
	</th>                                  		
    <th class="tg-tarb"> 
		                     <h3>'.$pdf->SetFont('fontawesome').'
	                    	<span style="font-family:FontAwesome;font-size: 2em;">&#xf009;</span> '.$pdf->SetFont('Times', '', 10, '', true).'Porta:</h3>
	                        <hr>
							<br><br>
							<br><br>
							<br><br>
							<br><br>
							&nbsp;
							<style type="text/css">
.ta  {border-collapse:collapse;border-spacing:0;border-color:transparent}
.ta td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:transparent;color:#1ca8dd;background-color:#1ca8dd;}
.ta th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:transparent;color:#fff;background-color:#1ca8dd;}
							</style>
							<table class="ta" style="undefined;table-layout: fixed; width: 30px;height:30px">
							  <tr style="text-align:center;">
								<th style="font-size:small;background-color:#1ca8dd;color:#ffffff;text-align:center;border-color:#1ca8dd;"></th>
							  </tr>
							<tr style="text-align:center;">
							    <td style="font-size:small;background-color:#1ca8dd;color:#ffffff;text-align:center;border-color:#1ca8dd;">'.$valueterm['Dados']['Porta'].'</td>
							  </tr>
							  <tr>
							    <td style="font-size:small;background-color:#1ca8dd;color:#ffffff;text-align:center;border-color:#1ca8dd;"></td>
						  </tr>
							</table>
	                  		<br><br>
	                      
							 <h3>'.$pdf->SetFont('fontawesome').'
	                    	<span style="font-family:FontAwesome;font-size: 2em;">&#xf00b;</span> '.$pdf->SetFont('Times', '', 10, '', true).'Servi&ccedil;os:</h3>
							<hr>

							<style type="text/css">
							.tg .tg-fame{font-size:small;background-color:#ffffff;color:#000000;text-align:center;vertical-align:center}
							.tg .tg-porta{font-size:small;background-color:#1ca8dd;color:#ffffff;text-align:center}
							.tg .tg-protocolo{font-size:small;background-color:#FF915F;color:#ffffff;text-align:center}
							.tg .tg-link{font-size:small;background-color:#7DBB4D;color:#ffffff;text-align:center;vertical-align:center}
							</style>
							<table class="tg" style="undefined;table-layout: fixed; width: 300px">
							<colgroup>
							<col style="width: 100px">
							<col style="width: 200px">
							</colgroup>
							  <tr>
							    <th class="tg-porta" style="width: 70px;height:10px"><br>'.$valueterm['Dados']['Porta'].'</th>
							    <th class="tg-fame" rowspan="4" style="width: 200px">'.$valueterm['Dados']['Data'].'</th>
							  </tr>
							  <tr>
							    <td class="tg-protocolo" style="width: 70px;height:10px">'. $valueterm['Dados']['Transport'].'</td>
							  </tr>
							  <tr>
							    <td class="tg-link" style="width: 70px;height:10px"><a href="http://'.$valueterm['Dados']['IP'].':'.$valueterm['Dados']['Porta'].'" style="text-decoration: none;color:#fff" target="_blank" class="link">'.$pdf->SetFont('fontawesome').'
	                    	<span style="font-family:FontAwesome;font-size: 1em;">&#xf064;</span> '.$pdf->SetFont('Times', '', 10, '', true).'&nbsp;
	                                    </a></td>
							
							  </tr>
							<tr>
							    <td class="tg-fame"></td>
							  </tr>
								</table>
						</th>
					  </tr>
					</table>
	 	<br>
		<br>		    ';
	 	
					
		                    
		                      				
	 				 }
	 				 
	 				 
	 				 $pdf->AddPage();
	 				 $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
	 				 $html="";
	}
	
	

	$id++;
	$url="";
	$conteudo_encontrado="";
	$wu="";
	}
			

// 	$pdf->Write(0, $html, '', 0, 'L', true, 0, false, false, 0);
// $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
ob_end_clean();
$pdf->Output(date("F j, Y, g:i a").'.pdf', 'D'); //I

//============================================================+
// END OF FILE
//============================================================+

}else{
	header("Location: /SDLPlatform/login.php");
}
?>

