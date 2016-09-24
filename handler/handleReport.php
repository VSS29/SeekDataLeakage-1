<?php

function getDashOnDB($email,$termo,$mes){

	$coll = connectDB_Dash();

	$cursor = $coll->find(array('email' => $email , 'Termo' => $termo));
	$all = array();
	foreach ($cursor as $doc) {
		$m = date_parse_from_format("d/m/y", $doc['Data']);
		if($m["month"] == $mes){
			$all[]= $doc;
		}
	}

	return $all;

}


function getDLFoundByTerm($email,$nomeregra,$termo,$plataform,$mes,$ano,$status){
	$stats=$status;
	if($stats=="positiv"){
		$get = connectDB_DLFound()->find(array('email' => $email , 'Termo' => $termo, 'Plataforma' => $plataform, 'NomeRegra' => $nomeregra, 'falsePositiv' => 0));
		$all = array();
		foreach ($get as $doc) {
			$m = date_parse_from_format("Y-m-d", $doc['DataFound']);
			if($m["month"] == $mes && $m["year"] == $ano){
				$all[]= $doc;
			}
		}

		return $all;
	}

	if($stats=="negativ"){
		$get = connectDB_DLFound()->find(array('email' => $email , 'Termo' => $termo, 'Plataforma' => $plataform, 'NomeRegra' => $nomeregra, 'falsePositiv' => 1));
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


function getNameOfRule($month,$year){
	
	$get = connectDB_DLFound()->find(array('email' => $_SESSION['email']));
	$all = array();
		foreach ($get as $doc) {
			$m = date_parse_from_format("Y-m-d H:i:s", $doc['DataFound']);
			if($month == $m["month"] && $year== $m["year"] ){
				$all[]=$doc;
			}
	}
	return $all;
}


function getDLFound($month){
	$get = connectDB_Dash()->find(array('email' => $_SESSION['email']));
	$all = array();
	foreach ($get as $doc) {
			$m = date_parse_from_format("d/m/y", $doc['Data']);
			if($month == $m['month']){
				$all[]=$doc;
			}
	}
	return $all;
}

function getRulesByName($rulename){
	$get = connectDB_Rules()->find(array('email' => $_SESSION['email'], 'Rule_name' => $rulename));
	$all = array();
	foreach ($get as $doc) {
			$all=$doc['Termos_Regra'];
	}
	return $all;

}

function getPlataformByName($rulename){
	$get = connectDB_Rules()->find(array('email' => $_SESSION['email'], 'Rule_name' => $rulename));
	$all = array();
	foreach ($get as $doc) {
			return $doc['Plataforma'];
	}

}

function getDLFoundByName($name){
	$get = connectDB_DLFound()->find(array('email' => $_SESSION['email'], 'NomeRegra' => $name));
	$arrayAux=array();
	foreach ($get as $doc) {
			$arrayAux[]=$doc;
	}
	return $arrayAux;
}



function getURLfromRuleName($rulename,$plat){
	$get = connectDB_DLFound()->find(array('email' => $_SESSION['email'], 'NomeRegra' => $name , 'Plataforma' => $plat, 'falsePositiv' => 0));
	$all = array();
	foreach ($get as $doc) {
			$all[]=$doc['URL'].': <br>'.$doc['TextoEncontrado'].'<hr></hr>'; //--
	}
	return $all;
}


function checkUniqueRuleName($RuleName){
	$collectio = connectDB_Rules();
	$cursor = $collectio->findOne(array('email' => $_SESSION["email"], 'Rule_name'=>$RuleName));
	return $cursor;
}
?>