<?php
include 'handler/handleRules.php';
include 'handler/handleProxy.php';

function emailSended($id){

	$cursor = connectDB_Rules()->find();
	foreach ($cursor as $doc) {
		if(($doc['_id'] == $id)){
			if($doc['emailed']==0){
				return false;
			}else{
				return true;
			}
		}
	}
	return true;
}

function setEmailSendedTrue($id){
	$cursor = connectDB_Rules()->findOne(array('_id' =>  new MongoId($id)));
	if ($cursor == true){
		$val=connectDB_Rules()->update(array('_id'=>new MongoId($id)),array('$set'=>array('emailed'=>1)));
	}
}

function setEmailSendedFalse($id){
	$cursor = connectDB_Rules()->findOne(array('_id' =>  new MongoId($id)));
	if ($cursor == true){
		$val=connectDB_Rules()->update(array('_id'=>new MongoId($id)),array('$set'=>array('emailed'=>0)));
	}
}


function getNumOfDash($term,$URL){

	$cursor =  connectDB_Dash()->find();
	foreach ($cursor as $doc) {
		if(($doc['Termo'] == $term && $doc['URL'] == $URL )){
			return $doc['Quantidade'];
		}
	}
}

function getDayOfDash($term,$URL){

	$cursor =  connectDB_Dash()->find();
	foreach ($cursor as $doc) {
		if(($doc['Termo'] == $term && $doc['URL'] == $URL )){
			return $doc['Data'];
		}
	}
}

function existsDash($term,$URL,$data){
	$cursor =  connectDB_Dash()->find();
	foreach ($cursor as $doc) {
		if(($doc['Termo'] == $term && $doc['URL'] == $URL && $doc['Data'] == $data )){
			return true;
		}
	}
	return false;
}





function updateDateDLFound($term,$URL,$email,$date){
	$coll = connectDB_DLFound();

	$cursor = $coll->findOne(array('Termo' => $term,'URL'=>$URL , 'email'=>$email));
	if ($cursor == true){
		$coll->update(array('Termo'=>$term, 'URL'=>$URL, 'email'=>$email),array('$set'=>array('DataFound'=>$date,'viewed'=>0)));
	}
	
}

function updateDateDLFoundDados($term,$dados,$email,$date){
	$coll = connectDB_DLFound();

	$cursor = $coll->findOne(array('Termo' => $term,'Dados'=>$dados , 'email'=>$email));
	print_r($cursor);
	if ($cursor == true){
		$coll->update(array('Termo'=>$term, 'Dados'=>$dados, 'email'=>$email),array('$set'=>array('DataFound'=>$date,'viewed'=>0)));
	}
}

function getNumOfDLFound($term,$URL,$email){

	$cursor = connectDB_DLFound()->find();
	foreach ($cursor as $doc) {
		if(($doc['Termo'] == $term && $doc['URL'] == $URL && $doc['email'] ==$email )){
			return $doc['Num'];
		}
	}
}

function existsDLFound($term,$URL,$email){
	$cursor = connectDB_DLFound()->find();
	foreach ($cursor as $doc) {
		if(($doc['Termo'] == $term && $doc['URL'] == $URL && $doc['email'] == $email)){
			return true;
		}
	}
	return false;
}

function existsDLFoundDados($term,$dados,$email){
	$cursor = connectDB_DLFound()->find();
	foreach ($cursor as $doc) {
		if(($doc['Termo'] == $term && $doc['Dados'] === $dados && $doc['email'] == $email)){
			return true;
		}
	}
	return false;
}


function getRuleByID($id){

	$cursor = connectDB_Rules()->find();
	foreach ($cursor as $doc) {
		if(($doc['_id'] == $id)){
			return $doc;
		}
	}
}

function getUrlsArquives(){
	
	
	
	$getList = connectDB_engine()->find();
	$getURLS = array();
	$newList = array();


			$get = connectDB_proxy()->find();
			$proxy_list=array();
			foreach ($get as $doc) {
				if($doc['verified'] === 1)
				$proxy_list[]=$doc['Proxy'];
			}
		
			if (isset($proxy_list) && !empty($proxy_list)) {  
				$proxy = $proxy_list[array_rand($proxy_list)];    
			}
		
			if(!empty($proxy_list)){

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_PROXY, $proxy);
			curl_setopt($ch, CURLOPT_URL, 'http://pastebin.com/archive');
			curl_setopt($ch, CURLOPT_HEADER, TRUE);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, TRUE );
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, FALSE);
			$page = curl_exec($ch);			
			curl_close($ch);
			}else{
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, 'http://pastebin.com/archive');
				curl_setopt($ch, CURLOPT_HEADER, TRUE);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, TRUE );
				curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, FALSE);
				$page = curl_exec($ch);
				curl_close($ch);
				
			}

		
	if($getList->count() == '0'){
		$pastPageXPath = returnXPathObject($page);
		$queryXML = $pastPageXPath->query('//tr/td/a/@href');
		for($i = 0; $i < $queryXML->length ; $i++){
			if($queryXML->length > 0){
					$getURLS[]='http://pastebin.com/raw'.$queryXML->item($i)->nodeValue;
			}
		}
		
		$print =array_unique($getURLS);
		foreach($print as $url){
			connectDB_engine()->insert(array('URL'=>$url));
		}
		
	}else{
		foreach ($getList as $list) {
			$newList[] = $list['URL'];
		}
		
	$pastPageXPath = returnXPathObject($page);	
		$queryXML = $pastPageXPath->query('//tr/td/a/@href');
		for($i = 0; $i < $queryXML->length ; $i++){
	
			if($queryXML->length > 0){
	
				if(!in_array('http://pastebin.com/raw'.$queryXML->item($i)->nodeValue, $newList)){
					$getURLS[]='http://pastebin.com/raw'.$queryXML->item($i)->nodeValue;
				}
	
			}
		}
	
	
		$print =array_unique(umerge($getURLS, $newList));
	
		foreach($print as $url){
			connectDB_engine()->insert(array('URL'=>$url));
		}
		
	}
	

}

function getRawArquive(){

	set_time_limit(0);

	
	
	$url 			= 'http://pastebin.com/api_scraping.php?limit=250';
	$ch 			= curl_init($url);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_VERBOSE, 1);
	curl_setopt($ch, CURLOPT_NOBODY, 0);
	$page  		= curl_exec($ch);
	$hits = json_decode($page , true);
	
	$api_dev_key 		= 'dev_key'; //api_dev_key 
	$api_user_key 		= 'user_key'; //api_user_key
	
	$database=connectDB_engine();
	
	$existentes=$database->find();
	$listaurls=array();
	
	
	
	
	foreach ($existentes as $urls) {
		$listaurls[]=$urls['URL'];
	}
	
	if(empty($listaurls)){
		foreach ($hits as $value){
	
			$ch = curl_init($value['scrape_url']);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, 'api_option=show_paste&api_user_key='.$api_user_key.'&api_dev_key='.$api_dev_key.'');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_VERBOSE, 1);
			curl_setopt($ch, CURLOPT_NOBODY, 0);
			$page1  	= curl_exec($ch);
	
	
			$database->insert(array('URL'=>$value['scrape_url'],'content'=>html_entity_decode($page1)));
	
		}
	}else{
	
		foreach ($hits as $value){
			if(!in_array($value['scrape_url'],$listaurls)){
				echo 'tenho um novo! '.$value['scrape_url'] .'<br>';
				$ch = curl_init($value['scrape_url']);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, 'api_option=show_paste&api_user_key='.$api_user_key.'&api_dev_key='.$api_dev_key.'');
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_VERBOSE, 1);
				curl_setopt($ch, CURLOPT_NOBODY, 0);
					
				$page1  	= curl_exec($ch);
				$database->insert(array('URL'=>$value['scrape_url'],'content'=>html_entity_decode($page1)));
					
			}
		}
	
	}
}


/**
 * @param id_rule
 * @param email
 * @param termos
 * @param relevo
 * @param URLS
 * @param i
 */

function setOnDB($id_rule, $email, $termos, $relevo, $URLS, $i, $TextFromURL, $rule_name) {

	if(sizeof($termos)>1){
		if($relevo=="Alto"){

			if(emailSended($id_rule)==false){
				setEmailSendedTrue($id_rule);
				sendEmailto($email,$URLS[$i]);
			}


			if(!existsDLFound($termos[$j],$URLS[$i],$email)){
				connectDB_Dash()->insert(array( 'email' => $email,'Data'=>date_format(new DateTime(), 'd/m/Y'),'NomeRegra'=>$rule_name ,'Plataforma'=>"Pastebin",'URL'=>$URLS [$i],'Termo'=>$termos[$j], 'Quantidade'=>1));
				connectDB_DLFound()->insert(array( 'email' => $email,'DataFound'=>date_format(new DateTime(), 'Y-m-d H:i:s'), 'Plataforma'=>"Pastebin",'URL'=>$URLS [$i],'TextoEncontrado'=>$TextFromURL,'Termo'=>$termos[$j],'NomeRegra'=>$rule_name, 'Num'=>1,'viewed'=>0,'falsePositiv'=>2));
			}else{
				updateDateDLFound($termos[$j],$URLS[$i],$email, date_format(new DateTime(), 'Y-m-d H:i:s'));
			}

		}

		if($relevo=="Baixo"){

			if(!existsDLFound($termos[$j],$URLS[$i],$email)){
				connectDB_Dash()->insert(array( 'email' => $email,'Data'=>date_format(new DateTime(), 'd/m/Y'),'NomeRegra'=>$rule_name , 'Plataforma'=>"Pastebin",'URL'=>$URLS [$i],'Termo'=>$termos[$j], 'Quantidade'=>1));
				connectDB_DLFound()->insert(array( 'email' => $email,'DataFound'=>date_format(new DateTime(), 'Y-m-d H:i:s'), 'Plataforma'=>"Pastebin",'URL'=>$URLS [$i],'TextoEncontrado'=>$TextFromURL,'Termo'=>$termos[$j], 'NomeRegra'=>$rule_name,'Num'=>1,'viewed'=>0,'falsePositiv'=>2));
			}else{
				updateDateDLFound($termos[$j],$URLS[$i],$email, date_format(new DateTime(), 'Y-m-d H:i:s'));

			}

		}

		if($relevo=="Medio"){
			if(!existsDLFound($termos[$j],$URLS[$i],$email)){
				echo "rule_name:".$rule_name.'<br>';
				echo "texto found:".$TextFromURL.'<br>';
				connectDB_Dash()->insert(array( 'email' => $email,'Data'=>date_format(new DateTime(), 'd/m/Y'), 'NomeRegra'=>$rule_name ,'Plataforma'=>"Pastebin",'URL'=>$URLS [$i],'Termo'=>$termos[$j], 'Quantidade'=>1));
				connectDB_DLFound()->insert(array( 'email' => $email,'DataFound'=>date_format(new DateTime(), 'Y-m-d H:i:s'), 'Plataforma'=>"Pastebin",'URL'=>$URLS [$i],'TextoEncontrado'=>$TextFromURL,'Termo'=>$termos[$j], 'NomeRegra'=>$rule_name,'Num'=>1,'viewed'=>0,'falsePositiv'=>2));
			}else{
				updateDateDLFound($termos[$j],$URLS[$i],$email, date_format(new DateTime(), 'Y-m-d H:i:s'));

			}


		}
	}else{

		if($relevo=="Alto"){
			if(emailSended($id_rule)==false){

				setEmailSendedTrue($id_rule);
					
				sendEmailto($email,$URLS[$i]);
			}


			if(!existsDLFound($termos[0],$URLS[$i],$email)){
				connectDB_Dash()->insert(array( 'email' => $email,'Data'=>date_format(new DateTime(), 'd/m/Y'),'NomeRegra'=>$rule_name , 'Plataforma'=>"Pastebin",'URL'=>$URLS [$i],'Termo'=>$termos[0], 'Quantidade'=>1));
				connectDB_DLFound()->insert(array( 'email' => $email,'DataFound'=>date_format(new DateTime(), 'Y-m-d H:i:s'), 'Plataforma'=>"Pastebin",'URL'=>$URLS [$i],'TextoEncontrado'=>$TextFromURL,'Termo'=>$termos[0], 'NomeRegra'=>$rule_name,'Num'=>1,'viewed'=>0,'falsePositiv'=>2));
			}else{
				updateDateDLFound($termos[0],$URLS[$i],$email, date_format(new DateTime(), 'Y-m-d H:i:s'));

			}
		}

		if($relevo=="Baixo"){


			if(!existsDLFound($termos[0],$URLS [$i],$email)){
				connectDB_Dash()->insert(array( 'email' => $email,'Data'=>date_format(new DateTime(), 'd/m/Y'),'NomeRegra'=>$rule_name , 'Plataforma'=>"Pastebin",'URL'=>$URLS [$i],'Termo'=>$termos[0], 'Quantidade'=>1));
				connectDB_DLFound()->insert(array( 'email' => $email,'DataFound'=>date_format(new DateTime(), 'Y-m-d H:i:s'), 'Plataforma'=>"Pastebin",'URL'=>$URLS [$i],'TextoEncontrado'=>$TextFromURL,'Termo'=>$termos[0],'NomeRegra'=>$rule_name, 'Num'=>1,'viewed'=>0,'falsePositiv'=>2));
			}else{
				updateDateDLFound($termos[0],$URLS [$i],$email, date_format(new DateTime(), 'Y-m-d H:i:s'));
			}

		}

		if($relevo=="Medio"){
			if(!existsDLFound($termos[0],$URLS [$i],$email)){
				echo "rule_name:".$rule_name.'<br>';
				echo "texto found:".$TextFromURL.'<br>';
				
				
				connectDB_Dash()->insert(array( 'email' => $email,'Data'=>date_format(new DateTime(), 'd/m/Y'),'NomeRegra'=>$rule_name , 'Plataforma'=>"Pastebin",'URL'=>$URLS [$i],'Termo'=>$termos[0], 'Quantidade'=>1));
				connectDB_DLFound()->insert(array( 'email' => $email,'DataFound'=>date_format(new DateTime(), 'Y-m-d H:i:s'), 'Plataforma'=>"Pastebin",'URL'=>$URLS [$i],'TextoEncontrado'=>$TextFromURL,'Termo'=>$termos[0], 'NomeRegra'=>$rule_name,'Num'=>1,'viewed'=>0,'falsePositiv'=>2));
			}else{
				echo "rule_name:".$rule_name.'<br>';
				echo "texto found:".$TextFromURL.'<br>';
				updateDateDLFound($termos[0],$URLS [$i],$email, date_format(new DateTime(), 'Y-m-d H:i:s'));
			}
		}
	}
}


/**
 *
 */

function getURLS() {
	$URLS=array();

	$getList = connectDB_engine()->find();
	foreach ($getList as $value){
		$URLS[]=$value['URL'];
	}
	return $URLS;
}




function sendEmailto($emailSend, $URL, $plataform,$termos){
	require 'C:\xampp\htdocs\SDLPlatform\PHPMailer\PHPMailerAutoload.php';

	
	$mail = new PHPMailer(); // create a new object
	$mail->IsSMTP(); // enable SMTP
	$mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
	$mail->SMTPAuth = true; // authentication enabled
	$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
	$mail->Host = "smtp.gmail.com";
	$mail->Port = 465; // or 587
	$mail->IsHTML(true);
	$mail->Username = "email"; //Email to send emails from
	$mail->Password = "password"; //Password from that email
	$mail->SetFrom("SDL Platform");
	$mail->Subject = "Fuga de informação detectada!";
	if($plataform == 'PasteBin'){
		$mail->Body = "Foi detectada uma fuga de informação às ".date('H:i:s')." sobre o termo ".$termos.".<br>
				Pode verificar a fuga no seguinte endereço <a href='".str_replace('api_scrape_item.php?i=','',$URL)."'>".str_replace('api_scrape_item.php?i=','',$URL)."</a>.<br>
								
				<br>
			<br> <small><i>Copyright © 2015-2016 SDLP, Todos os direitos reservados.
			<br>Em caso de contacto faça-o para:
			<br>seekdataleakplataform.info@gmail.com
			<br>Mais info em:  https://seekdataleakage.ddns.net/SDLPlatform/index.php</i></small>";
	}

	if($plataform=='Shodan'){
		$mail->Body = "Atenção, foi encontrado no Shodan informação relevante, por favor verifique na plataforma

				<br>
			<br> <small><i>Copyright © 2015-2016 SDLP, Todos os direitos reservados.
<br>Em caso de contacto faça-o para:
<br>seekdataleakplataform.info@gmail.com
<br>Mais info em: http://seekdataleakage.no-ip.org/SDLPlatform/index.php</i></small>";
	}

	$mail->AddAddress($emailSend);
	$mail->Send();
}



?>