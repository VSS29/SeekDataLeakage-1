<?php

//**************************
function connectDB_toCreateDash() {
	ob_start();
	error_reporting(0);
	try
	{
		$m    = new MongoClient("mongodb://localhost:27017/Dashboards"); //Connect to your mongoDB instance. If you want security please add a username for each collections, for instance username:password@localhost.
		$db   = $m->Dashboards;
		$coll = $db->FirstEntry;

	}
	catch (MongoConnectionException $e)
	{
		die('<i class="fa fa-chain-broken" aria-hidden="true"></i> Error connecting to the server !');
	}
	catch (MongoException $e) {
		die('Error 109 ');
	}
	return $coll;
}
//**************************

//**************************
function connectDB_Top(){
	ob_start();
	error_reporting(0);
	try
	{
		$m    = new MongoClient("mongodb://localhost:27017/Top");  //Connect to your mongoDB instance. If you want security please add a username for each collections, for instance username:password@localhost. 
		$db   = $m->Top;
		$collection = $db->All;

	}
	catch (MongoConnectionException $e)
	{
		die('<i class="fa fa-chain-broken" aria-hidden="true"></i> Error connecting to the server !');
	}
	catch (MongoException $e) {
		die('Error 100 ');
	}
	return $collection;
}
//**************************

//**************************
function connectDB_Users(){
	ob_start();
	error_reporting(0);
	try
	{
		$m    = new MongoClient("mongodb://localhost:27017/Users"); //Connect to your mongoDB instance. If you want security please add a username for each collections, for instance username:password@localhost.
		$db   = $m->Users;
		$coll = $db->users;
	}
	catch (MongoConnectionException $e)
	{
		die('<i class="fa fa-chain-broken" aria-hidden="true"></i> Error connecting to the server !');
	}
	catch (MongoException $e) {
		die('Error 101 ');
	}
	return $coll;
}

//**************************

function connectDB_Rules(){
	ob_start();
	error_reporting(0);
	try
	{
		$m    = new MongoClient("mongodb://localhost:27017/Rules"); //Connect to your mongoDB instance. If you want security please add a username for each collections, for instance username:password@localhost.
		$db   = $m->Rules;
		$collection = $db->Table;

	}
	catch (MongoConnectionException $e)
	{
		die('<i class="fa fa-chain-broken" aria-hidden="true"></i> Error connecting to the server !');
	}
	catch (MongoException $e) {
		die('Error 102 ');
	}
	return $collection;
}

//**************************

//**************************

function connectDB_engine() {
	ob_start();
	error_reporting(0);
	try
	{
		$m    = new MongoClient("mongodb://localhost:27017/PasteBin"); //Connect to your mongoDB instance. If you want security please add a username for each collections, for instance username:password@localhost.
		$db   = $m->PasteBin;
		$collection = $db->Arquive;
	}
	catch (MongoConnectionException $e)
	{
		die('<i class="fa fa-chain-broken" aria-hidden="true"></i> Error connecting to the server !');
	}
	catch (MongoException $e) {
		die('Error 103 ');
	}
	return $collection;
}

function closeDB_engine() {
	ob_start();
	error_reporting(0);
	try
	{
		$m    = new MongoClient("mongodb://localhost:27017/PasteBin"); //Connect to your mongoDB instance. If you want security please add a username for each collections, for instance username:password@localhost.
		$err=$m->close();	}
	catch (MongoConnectionException $e)
	{
		die('<i class="fa fa-chain-broken" aria-hidden="true"></i> Error connecting to the server !');
	}
	catch (MongoException $e) {
		die('Error 104 ');
	}
	return $err;
}
//**************************

//**************************

function connectDB_proxy() {
	ob_start();
	error_reporting(E_ALL);
	try
	{
		$m    = new MongoClient("mongodb://localhost:27017/Proxy"); //Connect to your mongoDB instance. If you want security please add a username for each collections, for instance username:password@localhost.
		$db   = $m->Proxy;
		$collection = $db->Arquive;
	}
	catch (MongoConnectionException $e)
	{
		die('<i class="fa fa-chain-broken" aria-hidden="true"></i> Error connecting to the server !');
	}
	catch (MongoException $e) {
		die('Error 105 '.$e->Message());
	}
	return $collection;
}
//**************************

//**************************

function connectDB_Dash() {
	ob_start();
	error_reporting(0);
	try
	{
		$m    = new MongoClient("mongodb://localhost:27017/Dashboards"); //Connect to your mongoDB instance. If you want security please add a username for each collections, for instance username:password@localhost.
		$db   = $m->Dashboards;
		$coll = $db->All;

	}
	catch (MongoConnectionException $e)
	{
		die('<i class="fa fa-chain-broken" aria-hidden="true"></i> Error connecting to the server !');
	}
	catch (MongoException $e) {
		die('Error 106 ');
	}
	return $coll;
}
//**************************
//**************************
function connectDB_DLFound() {
	ob_start();
	error_reporting(0);
	try
	{
		$m    = new MongoClient("mongodb://localhost:27017/DataLeakage"); //Connect to your mongoDB instance. If you want security please add a username for each collections, for instance username:password@localhost.
		$db   = $m->DataLeakage;
		$collection = $db->Found;
	}
	catch (MongoConnectionException $e)
	{
		die('<i class="fa fa-chain-broken" aria-hidden="true"></i> Error connecting to the server !');
	}
	catch (MongoException $e) {
		die('Error 107 ');
	}
	return $collection;
}


//**************************

function curlGet($url) {
	$ch = curl_init ();
	curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, TRUE );
	curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, TRUE );
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt ( $ch, CURLOPT_URL, $url );
	$results = curl_exec ( $ch );
	curl_close ( $ch );
	return $results;
}



function returnXPathObject($item) {
	$xmlPageDom = new DOMDocument ();
	@$xmlPageDom->loadHTML ( $item ); //load the HTML from the page
	$xmlPageXPath = new DOMXPath($xmlPageDom);
	return $xmlPageXPath;
}

function umerge($arrays) {
	$result = array ();
	foreach ( $arrays as $array ) {
		$array = ( array ) $array;
		foreach ( $array as $value ) {
			if (array_search ( $value, $result ) === false)
				$result [] = $value;
		}
	}
	return $result;
}


function mb_stripos_all($haystack, $needle){
	$s=0;
	$i=0;

	while(is_integer($i)){
		$i= mb_stripos($haystack, $needle, $s);
			
		if(is_integer($i)) {
			$aStrPos[] = $i;
			$s = $i + mb_strlen($needle);
		}
	}

	if (isset($aStrPos)){
		return $aStrPos;
	
	}else{
		return false;
	}
}

function isPresent($haystack , $needle){
	if (strpos($haystack, $needle) !== false) {
		return true;
	}else{
		return false;
	}
}

?>
