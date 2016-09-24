<?php


function getDLFound(){
	$get = connectDB_DLFound()->find();
	foreach ($get as $doc) {
		if($doc['email'] == $_SESSION['email']){
			return $doc;
		}
	}
}


function getDLFoundGlobal($email,$ano,$status){
	set_time_limit(60);
	$stats=$status;
	$Jan=0;
	$Fev=0;
	$Mar=0;
	$Abr=0;
	$Mai=0;
	$Jun=0;
	$Jul=0;
	$Ag=0;
	$Set=0;
	$Out=0;
	$Nov=0;
	$Dez=0;


	if($stats=="total"){
		$get = connectDB_DLFound()->find(array('email' => $email));
		foreach ($get as $doc) {
			$m = date_parse_from_format("Y-m-d", $doc['DataFound']);
			if($m["year"] == $ano && $m['month'] == 01){
				$Jan=$Jan+$doc['Num'];
			}
			if($m["year"] == $ano && $m['month'] == 02){
				$Fev=$Fev+$doc['Num'];
			}
			if($m["year"] == $ano && $m['month'] == 03){
				$Mar=$Mar+$doc['Num'];
			}
			if($m["year"] == $ano && $m['month'] == 04){
				$Abr=$Abr+$doc['Num'];
			}
			if($m["year"] == $ano && $m['month'] == 05){
				$Mai=$Mai+$doc['Num'];
			}
			if($m["year"] == $ano && $m['month'] == 06){
				$Jun=$Jun+$doc['Num'];
			}
			if($m["year"] == $ano && $m['month'] == 07){
				$Jul=$Jul+$doc['Num'];
			}
			if($m["year"] == $ano && $m['month'] == 08){
				$Ag=$Ag+$doc['Num'];
			}
			if($m["year"] == $ano && $m['month'] == 09){
				$Set=$Set+$doc['Num'];
			}
			if($m["year"] == $ano && $m['month'] == 10){
				$Out=$Out+$doc['Num'];
			}
			if($m["year"] == $ano && $m['month'] == 11){
				$Nov=$Nov+$doc['Num'];
			}
			if($m["year"] == $ano && $m['month'] == 12){
				$Dez=$Dez+$doc['Num'];
			}
		}
		return ''.$Jan.', '.$Fev.', '.$Mar.', '.$Abr.', '.$Mai.', '.$Jun.', '.$Jul.', '.$Ag.', '.$Set.', '.$Out.', '.$Nov.', '.$Dez.'';
	}



	if($stats=="positiv"){
		$get = connectDB_DLFound()->find(array('email' => $email ,'falsePositiv' => 0));
		foreach ($get as $doc) {
			$m = date_parse_from_format("Y-m-d", $doc['DataFound']);
			if($m["year"] == $ano && $m['month'] == 01){
				$Jan=$Jan+$doc['Num'];
			}
			if($m["year"] == $ano && $m['month'] == 02 ){
				$Fev=$Fev+$doc['Num'];
			}
			if($m["year"] == $ano && $m['month'] == 03 ){
				$Mar=$Mar+$doc['Num'];
			}
			if($m["year"] == $ano && $m['month'] == 04 ){
				$Abr=$Abr+$doc['Num'];
			}
			if($m["year"] == $ano && $m['month'] == 05 ){
				$Mai=$Mai+$doc['Num'];
			}
			if($m["year"] == $ano && $m['month'] == 06){
				$Jun=$Jun+$doc['Num'];
			}
			if($m["year"] == $ano && $m['month'] == 07){
				$Jul=$Jul+$doc['Num'];
			}
			if($m["year"] == $ano && $m['month'] == 08 ){
				$Ag=$Ag+$doc['Num'];
			}
			if($m["year"] == $ano && $m['month'] == 09 ){
				$Set=$Set+$doc['Num'];
			}
			if($m["year"] == $ano && $m['month'] == 10 ){
				$Out=$Out+$doc['Num'];
			}
			if($m["year"] == $ano && $m['month'] == 11){
				$Nov=$Nov+$doc['Num'];
			}
			if($m["year"] == $ano && $m['month'] == 12){
				$Dez=$Dez+$doc['Num'];
			}
		}
		return ''.$Jan.', '.$Fev.', '.$Mar.', '.$Abr.', '.$Mai.', '.$Jun.', '.$Jul.', '.$Ag.', '.$Set.', '.$Out.', '.$Nov.', '.$Dez.'';
	}


	if($stats=="negativ"){
		$get = connectDB_DLFound()->find(array('email' => $email , 'falsePositiv' => 1));
		foreach ($get as $doc) {
			$m = date_parse_from_format("Y-m-d", $doc['DataFound']);
		if($m["year"] == $ano && $m['month'] == 01){
				$Jan=$Jan+$doc['Num'];
			}
			if($m["year"] == $ano && $m['month'] == 02 ){
				$Fev=$Fev+$doc['Num'];
			}
			if($m["year"] == $ano && $m['month'] == 03 ){
				$Mar=$Mar+$doc['Num'];
			}
			if($m["year"] == $ano && $m['month'] == 04 ){
				$Abr=$Abr+$doc['Num'];
			}
			if($m["year"] == $ano && $m['month'] == 05 ){
				$Mai=$Mai+$doc['Num'];
			}
			if($m["year"] == $ano && $m['month'] == 06){
				$Jun=$Jun+$doc['Num'];
			}
			if($m["year"] == $ano && $m['month'] == 07){
				$Jul=$Jul+$doc['Num'];
			}
			if($m["year"] == $ano && $m['month'] == 08 ){
				$Ag=$Ag+$doc['Num'];
			}
			if($m["year"] == $ano && $m['month'] == 09 ){
				$Set=$Set+$doc['Num'];
			}
			if($m["year"] == $ano && $m['month'] == 10 ){
				$Out=$Out+$doc['Num'];
			}
			if($m["year"] == $ano && $m['month'] == 11){
				$Nov=$Nov+$doc['Num'];
			}
			if($m["year"] == $ano && $m['month'] == 12){
				$Dez=$Dez+$doc['Num'];
			}
		}
		return ''.$Jan.', '.$Fev.', '.$Mar.', '.$Abr.', '.$Mai.', '.$Jun.', '.$Jul.', '.$Ag.', '.$Set.', '.$Out.', '.$Nov.', '.$Dez.'';
	}


	// 	if($stats=="negativ"){
	// 		$get = connectDB_DLFound()->find();
	// 		$all = array();
	// 		foreach ($get as $doc) {
	// 			$m = date_parse_from_format("Y-m-d", $doc['DataFound']);
	// 			if($doc['email'] == $email && $doc['Termo'] == $termo && $doc['Plataforma'] == $plataform && $doc['NomeRegra'] == $nomeregra && $m["month"] == $mes && $m["year"] == $ano && $doc['falsePositiv']==1){
	// 				$all[]= $doc;
	// 			}
	// 		}

	// 		return $all;
	// 	}

}


function getDLFoundMontlyByTerm($email,$nomeregra,$termo,$plataform,$ano,$status){
	set_time_limit(60);
	$stats=$status;
	$Jan=0;
	$Fev=0;
	$Mar=0;
	$Abr=0;
	$Mai=0;
	$Jun=0;
	$Jul=0;
	$Ag=0;
	$Set=0;
	$Out=0;
	$Nov=0;
	$Dez=0;
	
	
	if($stats=="total"){
		$get = connectDB_DLFound()->find(array('email' => $email , 'Termo' => $termo , 'Plataforma' => $plataform,'NomeRegra' => $nomeregra));
		foreach ($get as $doc) {
			$m = date_parse_from_format("Y-m-d", $doc['DataFound']);
			if($m["year"] == $ano && $m['month'] == 01){
				$Jan=$Jan+$doc['Num'];
			}
			if($m["year"] == $ano && $m['month'] == 02){
				$Fev=$Fev+$doc['Num'];
			}
			if($m["year"] == $ano && $m['month'] == 03){
				$Mar=$Mar+$doc['Num'];
			}
			if($m["year"] == $ano && $m['month'] == 04){
				$Abr=$Abr+$doc['Num'];
			}
			if( $m["year"] == $ano && $m['month'] == 05){
				$Mai=$Mai+$doc['Num'];
			}
			if( $m["year"] == $ano && $m['month'] == 06){
				$Jun=$Jun+$doc['Num'];
			}
			if( $m["year"] == $ano && $m['month'] == 07){
				$Jul=$Jul+$doc['Num'];
			}
			if( $m["year"] == $ano && $m['month'] == 08){
				$Ag=$Ag+$doc['Num'];
			}
			if( $m["year"] == $ano && $m['month'] == 09){
				$Set=$Set+$doc['Num'];
			}
			if( $m["year"] == $ano && $m['month'] == 10){
				$Out=$Out+$doc['Num'];
			}
			if( $m["year"] == $ano && $m['month'] == 11){
				$Nov=$Nov+$doc['Num'];
			}
			if( $m["year"] == $ano && $m['month'] == 12){
				$Dez=$Dez+$doc['Num'];
			}
		}
	echo ''.$Jan.', '.$Fev.', '.$Mar.', '.$Abr.', '.$Mai.', '.$Jun.', '.$Jul.', '.$Ag.', '.$Set.', '.$Out.', '.$Nov.', '.$Dez.'';
	}
	
	
	
	if($stats=="positiv"){
		$get = connectDB_DLFound()->find(array('email' => $email , 'Termo' => $termo , 'Plataforma' => $plataform,'NomeRegra' => $nomeregra, 'falsePositiv' => 0));
		foreach ($get as $doc) {
			$m = date_parse_from_format("Y-m-d", $doc['DataFound']);
			if($m["year"] == $ano && $m['month'] == 01){
				$Jan=$Jan+$doc['Num'];
			}
			if($m["year"] == $ano && $m['month'] == 02){
				$Fev=$Fev+$doc['Num'];
			}
			if($m["year"] == $ano && $m['month'] == 03){
				$Mar=$Mar+$doc['Num'];
			}
			if($m["year"] == $ano && $m['month'] == 04){
				$Abr=$Abr+$doc['Num'];
			}
			if( $m["year"] == $ano && $m['month'] == 05){
				$Mai=$Mai+$doc['Num'];
			}
			if( $m["year"] == $ano && $m['month'] == 06){
				$Jun=$Jun+$doc['Num'];
			}
			if( $m["year"] == $ano && $m['month'] == 07){
				$Jul=$Jul+$doc['Num'];
			}
			if( $m["year"] == $ano && $m['month'] == 08){
				$Ag=$Ag+$doc['Num'];
			}
			if( $m["year"] == $ano && $m['month'] == 09){
				$Set=$Set+$doc['Num'];
			}
			if( $m["year"] == $ano && $m['month'] == 10){
				$Out=$Out+$doc['Num'];
			}
			if( $m["year"] == $ano && $m['month'] == 11){
				$Nov=$Nov+$doc['Num'];
			}
			if( $m["year"] == $ano && $m['month'] == 12){
				$Dez=$Dez+$doc['Num'];
			}
		}
		echo ''.$Jan.', '.$Fev.', '.$Mar.', '.$Abr.', '.$Mai.', '.$Jun.', '.$Jul.', '.$Ag.', '.$Set.', '.$Out.', '.$Nov.', '.$Dez.'';
	}
	

	if($stats=="negativ"){
		$get = connectDB_DLFound()->find(array('email' => $email , 'Termo' => $termo , 'Plataforma' => $plataform,'NomeRegra' => $nomeregra, 'falsePositiv' => 1));
		foreach ($get as $doc) {
			$m = date_parse_from_format("Y-m-d", $doc['DataFound']);
			if($m["year"] == $ano && $m['month'] == 01){
				$Jan=$Jan+$doc['Num'];
			}
			if($m["year"] == $ano && $m['month'] == 02){
				$Fev=$Fev+$doc['Num'];
			}
			if($m["year"] == $ano && $m['month'] == 03){
				$Mar=$Mar+$doc['Num'];
			}
			if($m["year"] == $ano && $m['month'] == 04){
				$Abr=$Abr+$doc['Num'];
			}
			if( $m["year"] == $ano && $m['month'] == 05){
				$Mai=$Mai+$doc['Num'];
			}
			if( $m["year"] == $ano && $m['month'] == 06){
				$Jun=$Jun+$doc['Num'];
			}
			if( $m["year"] == $ano && $m['month'] == 07){
				$Jul=$Jul+$doc['Num'];
			}
			if( $m["year"] == $ano && $m['month'] == 08){
				$Ag=$Ag+$doc['Num'];
			}
			if( $m["year"] == $ano && $m['month'] == 09){
				$Set=$Set+$doc['Num'];
			}
			if( $m["year"] == $ano && $m['month'] == 10){
				$Out=$Out+$doc['Num'];
			}
			if( $m["year"] == $ano && $m['month'] == 11){
				$Nov=$Nov+$doc['Num'];
			}
			if( $m["year"] == $ano && $m['month'] == 12){
				$Dez=$Dez+$doc['Num'];
			}
		}
		echo ''.$Jan.', '.$Fev.', '.$Mar.', '.$Abr.', '.$Mai.', '.$Jun.', '.$Jul.', '.$Ag.', '.$Set.', '.$Out.', '.$Nov.', '.$Dez.'';
	}
	

// 	if($stats=="negativ"){
// 		$get = connectDB_DLFound()->find();
// 		$all = array();
// 		foreach ($get as $doc) {
// 			$m = date_parse_from_format("Y-m-d", $doc['DataFound']);
// 			if($doc['email'] == $email && $doc['Termo'] == $termo && $doc['Plataforma'] == $plataform && $doc['NomeRegra'] == $nomeregra && $m["month"] == $mes && $m["year"] == $ano && $doc['falsePositiv']==1){
// 				$all[]= $doc;
// 			}
// 		}

// 		return $all;
// 	}

}

function getDLFoundByTerm($email,$nomeregra,$termo,$plataform,$mes,$ano,$status){
	set_time_limit(60);
	
	$stats=$status;
	if($stats=="positiv"){
	$get = connectDB_DLFound()->find(array('email' => $email , 'Termo' => $termo , 'Plataforma' => $plataform,'NomeRegra' => $nomeregra, 'falsePositiv' => 0));
	$all = array();
	foreach ($get as $doc) {
		$m = date_parse_from_format("Y-m-d", $doc['DataFound']);
		if($m["month"] == $mes && $m["year"] == $ano ){
			$all[]= $doc;
		}
	}
	return $all;
	}
	
	if($stats=="negativ"){
	$get = connectDB_DLFound()->find(array('email' => $email , 'Termo' => $termo , 'Plataforma' => $plataform,'NomeRegra' => $nomeregra, 'falsePositiv' => 1));
		$all = array();
		foreach ($get as $doc) {
			$m = date_parse_from_format("Y-m-d", $doc['DataFound']);
			if($m["month"] == $mes && $m["year"] == $ano){
				$all[]= $doc;
			}
		}
	
		return $all;
	}
	
}



function setDefaultDLFound(){
	$coll = connectDB_DLFound();
	$coll->	insert(array( 'email' => "root@localhost.com",'DataFound'=>"01/01/2015", 'Plataforma'=>"Pastebin",'URL'=>'teste','TextoEncontrado'=>"texto default php",'Termo'=>'PHP', 'NomeRegra'=>"Default",'Num'=>1,'viewed'=>0,'falsePositiv'=>2));
	$coll->	insert(array( 'email' => "root@localhost.com",'DataFound'=>"01/01/2015", 'Plataforma'=>"Pastebin",'URL'=>'teste','TextoEncontrado'=>"texto default php",'Termo'=>'PHP', 'NomeRegra'=>"Default",'Num'=>1,'viewed'=>0,'falsePositiv'=>2));
	//	insert(array( 'email' => "root@localhost.com",'DataFound'=>"01/01/2015", 'Plataforma'=>"Pastebin",'URL'=>'teste','TextoEncontrado'=>"texto default php",'Termo'=>'PHP', 'NomeRegra'=>"Default",'Num'=>1,'viewed'=>0,'falsePositiv'=>2));
}



function getDashOnDB($email,$nomeregra,$termo,$plataform,$mes,$ano){

	$coll = connectDB_Dash();
	$cursor = $coll->find(array('email' => $email , 'Termo' => $termo , 'Plataforma' => $plataform,'NomeRegra' => $nomeregra));
	$all = array();
	foreach ($cursor as $doc) {
		$m = date_parse_from_format("d/m/Y", $doc['Data']);
		if($m["month"] == $mes && $m["year"] == $ano){
			$all[]= $doc;
		}
	}

	return $all;

}

function CreateDash($email,$plataform,$ano,$mes,$nomeregra,$term) {
	if($nomeregra!=null && $term!=null){
	$connect=connectDB_toCreateDash();
	$ver = $connect->find();
	foreach ($ver as $doc) {
		if($doc['email'] == $email){
			$connect->update(array('email'=>$doc['email']),array('$set'=>array('Plataform'=>$plataform ,'Ano'=>$ano,'Mes'=>$mes,'NomeRegra'=>$nomeregra,'Term'=>$term )));
		}else{
			$connect->insert(array( 'email' => $email,'Plataform'=>$plataform, 'Ano'=>$ano,'Mes'=>$mes,'NomeRegra'=>$nomeregra,'Term'=>$term));
		}
	}
	}
}

function getCreateDash($email) {
		$connect=connectDB_toCreateDash();
		$ver = $connect->find(array('email' => $email));
		$temp;
		foreach ($ver as $doc) {
				$temp[]=$ver;
		}
		
		return $ver;
	
}



function setDefaultDash(){
	$coll = connectDB_Dash();
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin",'NomeRegra'=>"Default", 'URL'=>'teste', 'Data' => "01/01/2015", 'Termo'=>'PHP', 'Quantidade'=>1));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste', 'Data' => "01/01/2015", 'Termo'=>'PHP', 'Quantidade'=>1));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "03/01/2015", 'Termo'=>'PHP', 'Quantidade'=>1));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin",'NomeRegra'=>"Default", 'URL'=>'teste','Data' => "03/01/2015", 'Termo'=>'PHP', 'Quantidade'=>1));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin",'NomeRegra'=>"Default", 'URL'=>'teste','Data' => "03/01/2015", 'Termo'=>'PHP', 'Quantidade'=>1));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "03/01/2015", 'Termo'=>'PHP', 'Quantidade'=>1));


	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "06/01/2015", 'Termo'=>'PHP', 'Quantidade'=>8));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin",'NomeRegra'=>"Default", 'URL'=>'teste','Data' => "06/01/2015", 'Termo'=>'PHP', 'Quantidade'=>8));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "06/01/2015", 'Termo'=>'PHP', 'Quantidade'=>8));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "06/01/2015", 'Termo'=>'PHP', 'Quantidade'=>8));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "06/01/2015", 'Termo'=>'PHP', 'Quantidade'=>8));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "06/01/2015", 'Termo'=>'PHP', 'Quantidade'=>8));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "06/01/2015", 'Termo'=>'PHP', 'Quantidade'=>8));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "06/01/2015", 'Termo'=>'PHP', 'Quantidade'=>8));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "06/01/2015", 'Termo'=>'PHP', 'Quantidade'=>8));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "10/01/2015", 'Termo'=>'PHP', 'Quantidade'=>10));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "08/01/2015", 'Termo'=>'PHP', 'Quantidade'=>5));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "09/01/2015", 'Termo'=>'PHP', 'Quantidade'=>2));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "11/01/2015", 'Termo'=>'PHP', 'Quantidade'=>3));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "15/01/2015", 'Termo'=>'PHP', 'Quantidade'=>7));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "16/01/2015", 'Termo'=>'PHP', 'Quantidade'=>12));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "13/01/2015", 'Termo'=>'PHP', 'Quantidade'=>24));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "17/01/2015", 'Termo'=>'PHP', 'Quantidade'=>12));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "21/01/2015", 'Termo'=>'PHP', 'Quantidade'=>14));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "22/01/2015", 'Termo'=>'PHP', 'Quantidade'=>15));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "23/01/2015", 'Termo'=>'PHP', 'Quantidade'=>16));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "25/01/2015", 'Termo'=>'PHP', 'Quantidade'=>19));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "29/01/2015", 'Termo'=>'PHP', 'Quantidade'=>1));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "26/01/2015", 'Termo'=>'PHP', 'Quantidade'=>2));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "02/01/2015", 'Termo'=>'PHP', 'Quantidade'=>4));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "04/01/2015", 'Termo'=>'PHP', 'Quantidade'=>6));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "14/01/2015", 'Termo'=>'PHP', 'Quantidade'=>7));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "27/01/2015", 'Termo'=>'PHP', 'Quantidade'=>8));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "28/01/2015", 'Termo'=>'PHP', 'Quantidade'=>2));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "20/01/2015", 'Termo'=>'PHP', 'Quantidade'=>3));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "07/01/2015", 'Termo'=>'PHP', 'Quantidade'=>6));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "12/01/2015", 'Termo'=>'PHP', 'Quantidade'=>2));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "12/01/2015", 'Termo'=>'PHP', 'Quantidade'=>2));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "30/01/2015", 'Termo'=>'PHP', 'Quantidade'=>1));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "30/01/2015", 'Termo'=>'PHP', 'Quantidade'=>1));

	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "01/02/2015", 'Termo'=>'ASUS', 'Quantidade'=>1));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "03/02/2015", 'Termo'=>'ASUS', 'Quantidade'=>3));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "06/02/2015", 'Termo'=>'ASUS', 'Quantidade'=>4));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "10/02/2015", 'Termo'=>'ASUS', 'Quantidade'=>5));

	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "01/02/2015", 'Termo'=>'PHP', 'Quantidade'=>1));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "03/02/2015", 'Termo'=>'PHP', 'Quantidade'=>3));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "06/02/2015", 'Termo'=>'PHP', 'Quantidade'=>4));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "10/02/2015", 'Termo'=>'PHP', 'Quantidade'=>5));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "08/02/2015", 'Termo'=>'PHP', 'Quantidade'=>6));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "09/02/2015", 'Termo'=>'PHP', 'Quantidade'=>8));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "11/02/2015", 'Termo'=>'PHP', 'Quantidade'=>9));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "15/02/2015", 'Termo'=>'PHP', 'Quantidade'=>12));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "16/02/2015", 'Termo'=>'PHP', 'Quantidade'=>11));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "13/02/2015", 'Termo'=>'PHP', 'Quantidade'=>24));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "17/02/2015", 'Termo'=>'PHP', 'Quantidade'=>14));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "21/02/2015", 'Termo'=>'PHP', 'Quantidade'=>15));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "22/02/2015", 'Termo'=>'PHP', 'Quantidade'=>18));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "22/02/2015", 'Termo'=>'PHP', 'Quantidade'=>18));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "23/02/2015", 'Termo'=>'PHP', 'Quantidade'=>16));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "25/02/2015", 'Termo'=>'PHP', 'Quantidade'=>19));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "12/01/2015", 'Termo'=>'PHP', 'Quantidade'=>2));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "26/02/2015", 'Termo'=>'PHP', 'Quantidade'=>2));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "02/02/2015", 'Termo'=>'PHP', 'Quantidade'=>4));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "04/02/2015", 'Termo'=>'PHP', 'Quantidade'=>6));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "14/02/2015", 'Termo'=>'PHP', 'Quantidade'=>7));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "27/02/2015", 'Termo'=>'PHP', 'Quantidade'=>8));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "28/02/2015", 'Termo'=>'PHP', 'Quantidade'=>2));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "20/02/2015", 'Termo'=>'PHP', 'Quantidade'=>3));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "07/02/2015", 'Termo'=>'PHP', 'Quantidade'=>6));
	$coll->insert(array( 'email' => "root@localhost.com", 'Plataforma'=>"Pastebin", 'NomeRegra'=>"Default",'URL'=>'teste','Data' => "12/02/2015", 'Termo'=>'PHP', 'Quantidade'=>2));


}

function deleteDash(){
	$coll = connectDB_Dash();
	$result = $coll->drop();
	print_r($result);
}

?>