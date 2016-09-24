<?php

function getProxys(){
	$get = connectDB_proxy()->find();
	foreach ($get as $doc) {
			return $doc;
	}
}

function getVerifiedProxys(){
	$get = connectDB_proxy()->find();
	$verified_proxies=array();
	foreach ($get as $doc) {
		if($doc['verified'] === 1)
		$verified_proxies[]=$doc['Proxy'];
	}
	return $verified_proxies;
}

function curlGetWithProxy($url) {
	set_time_limit(90);
	$get = connectDB_proxy()->find();
	$proxy_list=array();
	foreach ($get as $doc) {
		if($doc['verified'] === 1)
		$proxy_list[]=$doc['Proxy'];
	}

	if (isset($proxy_list)) {  
		$proxy = $proxy_list[array_rand($proxy_list)];    
	}

	
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_PROXY, $proxy);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, TRUE);
	curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, TRUE );
	curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, TRUE );
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, FALSE);
	$results = curl_exec($ch);
	curl_close($ch);
	return $results;
}

function setProxy($ip){
	$coll = connectDB_proxy();
	$cursor = connectDB_proxy()->findOne(array('Proxy' =>  $ip));
	if($cursor == false){		
	$coll->insert(array( 'email' => $_SESSION['email'],'Proxy'=>$ip, 'verified' => 0,'time' => 0));
	return "sucesso";
	}else{
		return "fail";
	}
}

function setDefaultProxy(){
	$coll = connectDB_proxy();
	$coll->insert(array( 'email' => $_SESSION['email'],'Proxy'=>"104.236.227.136:9450", 'verified' => 0,'time' => 0));
	$coll->insert(array( 'email' => $_SESSION['email'],'Proxy'=>"173.55.177.158:17337", 'verified' => 0,'time' => 0));
	$coll->insert(array( 'email' => $_SESSION['email'],'Proxy'=>"136.0.16.217:8089", 'verified' => 0,'time' => 0));
	$coll->insert(array( 'email' => $_SESSION['email'],'Proxy'=>"199.168.148.146:10059", 'verified' => 0,'time' => 0));
	$coll->insert(array( 'email' => $_SESSION['email'],'Proxy'=>"164.58.68.181:3128", 'verified' => 0,'time' => 0));
	$coll->insert(array( 'email' => $_SESSION['email'],'Proxy'=>"24.196.69.180:1080", 'verified' => 0,'time' => 0));
	$coll->insert(array( 'email' => $_SESSION['email'],'Proxy'=>"199.168.148.150:10059", 'verified' => 0,'time' => 0));
	$coll->insert(array( 'email' => $_SESSION['email'],'Proxy'=>"209.124.132.3:1080", 'verified' => 0,'time' => 0));
	$coll->insert(array( 'email' => $_SESSION['email'],'Proxy'=>"107.170.244.166:8118", 'verified' => 0,'time' => 0));
	$coll->insert(array( 'email' => $_SESSION['email'],'Proxy'=>"54.255.211.131:8118", 'verified' => 0,'time' => 0));
	$coll->insert(array( 'email' => $_SESSION['email'],'Proxy'=>"69.36.65.214:1080", 'verified' => 0,'time' => 0));
	$coll->insert(array( 'email' => $_SESSION['email'],'Proxy'=>"24.246.127.180:8080", 'verified' => 0,'time' => 0));
	$coll->insert(array( 'email' => $_SESSION['email'],'Proxy'=>"66.249.131.115:8020", 'verified' => 0,'time' => 0));
	$coll->insert(array( 'email' => $_SESSION['email'],'Proxy'=>"162.208.49.45:3127", 'verified' => 0,'time' => 0));
	$coll->insert(array( 'email' => $_SESSION['email'],'Proxy'=>"67.202.112.137:8020", 'verified' => 0,'time' => 0));
	$coll->insert(array( 'email' => $_SESSION['email'],'Proxy'=>"52.27.57.60:8080", 'verified' => 0,'time' => 0));
	$coll->insert(array( 'email' => $_SESSION['email'],'Proxy'=>"137.116.91.0:3128", 'verified' => 0,'time' => 0));
	$coll->insert(array( 'email' => $_SESSION['email'],'Proxy'=>"198.11.172.90:3128", 'verified' => 0,'time' => 0));
	$coll->insert(array( 'email' => $_SESSION['email'],'Proxy'=>"47.88.15.202:3128", 'verified' => 0,'time' => 0));
	$coll->insert(array( 'email' => $_SESSION['email'],'Proxy'=>"52.88.81.13:3128", 'verified' => 0,'time' => 0));
	$coll->insert(array( 'email' => $_SESSION['email'],'Proxy'=>"199.189.80.13:8080", 'verified' => 0,'time' => 0));
	$coll->insert(array( 'email' => $_SESSION['email'],'Proxy'=>"47.88.16.166:3128", 'verified' => 0,'time' => 0));
	$coll->insert(array( 'email' => $_SESSION['email'],'Proxy'=>"159.203.1.226:8080", 'verified' => 0,'time' => 0));
	$coll->insert(array( 'email' => $_SESSION['email'],'Proxy'=>"98.101.157.150:8020", 'verified' => 0,'time' => 0));
	$coll->insert(array( 'email' => $_SESSION['email'],'Proxy'=>"207.254.170.172:8080", 'verified' => 0,'time' => 0));
	$coll->insert(array( 'email' => $_SESSION['email'],'Proxy'=>"165.138.126.16:8080", 'verified' => 0,'time' => 0));
	$coll->insert(array( 'email' => $_SESSION['email'],'Proxy'=>"54.169.218.234:1080", 'verified' => 0,'time' => 0));
	$coll->insert(array( 'email' => $_SESSION['email'],'Proxy'=>"137.135.166.225:8128", 'verified' => 0,'time' => 0));
	$coll->insert(array( 'email' => $_SESSION['email'],'Proxy'=>"47.88.25.150:3128", 'verified' => 0,'time' => 0));
	$coll->insert(array( 'email' => $_SESSION['email'],'Proxy'=>"104.238.83.28:443", 'verified' => 0,'time' => 0));
	$coll->insert(array( 'email' => $_SESSION['email'],'Proxy'=>"76.12.101.212:3128", 'verified' => 0,'time' => 0));
	$coll->insert(array( 'email' => $_SESSION['email'],'Proxy'=>"104.42.106.203:8080", 'verified' => 0,'time' => 0));
	
	
}


function deleteProxy($name){
	$coll = connectDB_proxy();
	$coll->remove(array('Proxy' => $name));
}

function checkProxy($ip){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'http://www.pastebin.com/archive');
	 curl_setopt($ch, CURLOPT_PROXY, $ip);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, 1);
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
	$curl_scraped_page = curl_exec($ch);
	
	if($curl_scraped_page!=null){
		$info = curl_getinfo($ch);	
		setProxyGood($ip,$info['total_time']);
	}else{
		deleteProxy($ip);
	}
	curl_close($ch);
}




function setProxyGood($ip,$time){
	$cursor = connectDB_proxy()->findOne(array('Proxy' =>  $ip));
	if ($cursor == true){
		$val=connectDB_proxy()->update(array('Proxy'=>$ip),array('$set'=>array('verified'=>1,'time'=>$time)));
	}
}




?>