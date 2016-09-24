<?php


include 'handler/handleDB.php';
include 'shodan_api/src/shodan.php';
include 'handler/handleEngine.php';

session_start();

date_default_timezone_set('Europe/Lisbon');

$options = getopt('I:');
$id_rule =  $options['I'];
$rule = array();
$rule = getRuleByID($id_rule);
$email = $rule['email'];
$rule_name=$rule['Rule_name'];
$termos=$rule['Termos_Regra'];	
$plataform=$rule['Plataforma'];	
$relevo=$rule['Relevo'];
$group = $rule['Grupo'];


if($plataform=='PasteBin'){
	
	if($rule_name=='GetAllPBArchives'){
	
		getRawArquive();
	
		$termos="";
		$relevo="";
		exit;	
	}
	
	if($rule_name=='resetPBArchives'){	
		connectDB_engine()->drop();
		$termos="";
		$relevo="";
		exit;
	}
	
	

	
	//---------
	set_time_limit(130);
	

	$exp_regular='/[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]+[:][^~,]+$/';
	$split_content=array();
	$foundLeakage=false;
	
	$getContent = connectDB_engine()->find();

		foreach($getContent as $value){
			
	
					for($j = 0; $j < sizeof ($termos); $j++) {
						if(sizeof($termos)>1 ){
							
				
							if(isPresent($value['content'],$termos[$j]) == true){ 
									if($relevo=="Alto"){
											
								
							
							
										if(!existsDLFound($termos[$j],$value['URL'] ,$email)){
											
											if(emailSended($id_rule)==true){
												sendEmailto($email,$value['URL'] ,$plataform,$termos[$j]);
											}
											
											connectDB_Dash()->insert(array( 'email' => $email,'Data'=>date_format(new DateTime(), 'd/m/Y'),'NomeRegra'=>$rule_name ,'Plataforma'=>"Pastebin",'URL'=>$value['URL']  ,'Termo'=>$termos[$j], 'Quantidade'=>1));
											
											
												$split_content = explode("\n", $value['content']);
												
												foreach ($split_content as $content){
													if (preg_match($exp_regular,$content)) {
														$foundLeakage=true;
														break;
													
													}else{
														$foundLeakage=false;
												
													}
												}

												if ($foundLeakage==true) {
													connectDB_DLFound()->insert(array( 'email' => $email,'DataFound'=>date_format(new DateTime(), 'Y-m-d H:i:s'), 'Plataforma'=>"Pastebin",'URL'=>$value['URL']  ,'TextoEncontrado'=>$value['content'],'Termo'=>$termos[$j],'NomeRegra'=>$rule_name, 'Num'=>1,'viewed'=>0,'falsePositiv'=>0));		
													connectDB_DLFound()->close();
												}else{
													connectDB_DLFound()->insert(array( 'email' => $email,'DataFound'=>date_format(new DateTime(), 'Y-m-d H:i:s'), 'Plataforma'=>"Pastebin",'URL'=>$value['URL']  ,'TextoEncontrado'=>$value['content'],'Termo'=>$termos[$j],'NomeRegra'=>$rule_name, 'Num'=>1,'viewed'=>0,'falsePositiv'=>2));
													connectDB_DLFound()->close();
													}
											
													}else{
										
										}
							
									}
							
									if($relevo=="Baixo"){
							
										if(!existsDLFound($termos[$j],$value['URL'] ,$email)){
											
											if(emailSended($id_rule)==true){
												sendEmailto($email,$value['URL'] ,$plataform,$termos[$j]);
											}
											
											connectDB_Dash()->insert(array( 'email' => $email,'Data'=>date_format(new DateTime(), 'd/m/Y'),'NomeRegra'=>$rule_name , 'Plataforma'=>"Pastebin",'URL'=>$value['URL']  ,'Termo'=>$termos[$j], 'Quantidade'=>1));
											
											
											
											$split_content = explode("\n", $value['content']);
												
												foreach ($split_content as $content){
													if (preg_match($exp_regular,$content)) {
														$foundLeakage=true;
														break;
													
													}else{
														$foundLeakage=false;
													
													}
												}

												if ($foundLeakage==true) {
													connectDB_DLFound()->insert(array( 'email' => $email,'DataFound'=>date_format(new DateTime(), 'Y-m-d H:i:s'), 'Plataforma'=>"Pastebin",'URL'=>$value['URL']  ,'TextoEncontrado'=>$value['content'],'Termo'=>$termos[$j],'NomeRegra'=>$rule_name, 'Num'=>1,'viewed'=>0,'falsePositiv'=>0));		
													connectDB_DLFound()->close();
												}else{
													connectDB_DLFound()->insert(array( 'email' => $email,'DataFound'=>date_format(new DateTime(), 'Y-m-d H:i:s'), 'Plataforma'=>"Pastebin",'URL'=>$value['URL']  ,'TextoEncontrado'=>$value['content'],'Termo'=>$termos[$j],'NomeRegra'=>$rule_name, 'Num'=>1,'viewed'=>0,'falsePositiv'=>2));
													
												}
										
											
										
										}else{
											
							
										}
							
									}
							
									if($relevo=="Medio"){
										if(!existsDLFound($termos[$j],$value['URL'] ,$email)){
								
											if(emailSended($id_rule)==true){
												sendEmailto($email,$value['URL'] ,$plataform,$termos[$j]);
											}
											
											connectDB_Dash()->insert(array( 'email' => $email,'Data'=>date_format(new DateTime(), 'd/m/Y'), 'NomeRegra'=>$rule_name ,'Plataforma'=>"Pastebin",'URL'=>$value['URL']  ,'Termo'=>$termos[$j], 'Quantidade'=>1));
											
											
											$split_content = explode("\n", $value['content']);
												
												foreach ($split_content as $content){
													if (preg_match($exp_regular,$content)) {
														$foundLeakage=true;
														break;
														
													}else{
														$foundLeakage=false;
													
													}
												}

												if ($foundLeakage==true) {
													connectDB_DLFound()->insert(array( 'email' => $email,'DataFound'=>date_format(new DateTime(), 'Y-m-d H:i:s'), 'Plataforma'=>"Pastebin",'URL'=>$value['URL']  ,'TextoEncontrado'=>$value['content'],'Termo'=>$termos[$j],'NomeRegra'=>$rule_name, 'Num'=>1,'viewed'=>0,'falsePositiv'=>0));		
													connectDB_DLFound()->close();
												}else{
													connectDB_DLFound()->insert(array( 'email' => $email,'DataFound'=>date_format(new DateTime(), 'Y-m-d H:i:s'), 'Plataforma'=>"Pastebin",'URL'=>$value['URL']  ,'TextoEncontrado'=>$value['content'],'Termo'=>$termos[$j],'NomeRegra'=>$rule_name, 'Num'=>1,'viewed'=>0,'falsePositiv'=>2));
													connectDB_DLFound()->close();
												}
												
											
											
										}else{
					
											
							
										}
							
							
									}
							}
						}else{
						

							if(isPresent($value['content'],$termos[0]) == true){								
							if($relevo=="Alto"){
																
							
										if(!existsDLFound($termos[0],$value['URL'] ,$email)){
											
											if(emailSended($id_rule)==true){
											sendEmailto($email,$value['URL'] ,$plataform,$termos[0]);
											}
											
											connectDB_Dash()->insert(array( 'email' => $email,'Data'=>date_format(new DateTime(), 'd/m/Y'),'NomeRegra'=>$rule_name , 'Plataforma'=>"Pastebin",'URL'=>$value['URL']  ,'Termo'=>$termos[0], 'Quantidade'=>1));
											
											
											
											$split_content = explode("\n", $value['content']);
											
											foreach ($split_content as $content){
												if (preg_match($exp_regular,$content)) {
													$foundLeakage=true;
													break;
												
												}else{
													$foundLeakage=false;
												
												}
											}
											
											if ($foundLeakage==true) {
												connectDB_DLFound()->insert(array( 'email' => $email,'DataFound'=>date_format(new DateTime(), 'Y-m-d H:i:s'), 'Plataforma'=>"Pastebin",'URL'=>$value['URL']  ,'TextoEncontrado'=>$value['content'],'Termo'=>$termos[0], 'NomeRegra'=>$rule_name,'Num'=>1,'viewed'=>0,'falsePositiv'=>0));
												
											}else{
												connectDB_DLFound()->insert(array( 'email' => $email,'DataFound'=>date_format(new DateTime(), 'Y-m-d H:i:s'), 'Plataforma'=>"Pastebin",'URL'=>$value['URL']  ,'TextoEncontrado'=>$value['content'],'Termo'=>$termos[0],'NomeRegra'=>$rule_name, 'Num'=>1,'viewed'=>0,'falsePositiv'=>2));
												
											}
											
									
											
										}else{
											
							
										}
									}
							
									if($relevo=="Baixo"){
							
							
										if(!existsDLFound($termos[0],$value['URL']  ,$email)){
											
											if(emailSended($id_rule)==true){
												sendEmailto($email,$value['URL'] ,$plataform,$termos[0]);
											}
											
											connectDB_Dash()->insert(array( 'email' => $email,'Data'=>date_format(new DateTime(), 'd/m/Y'),'NomeRegra'=>$rule_name , 'Plataforma'=>"Pastebin",'URL'=>$value['URL']  ,'Termo'=>$termos[0], 'Quantidade'=>1));
											
											
											$split_content = explode("\n", $value['content']);
											
											foreach ($split_content as $content){
												if (preg_match($exp_regular,$content)) {
													$foundLeakage=true;
													break;
											
												}else{
													$foundLeakage=false;
													
												}
											}
											
											if ($foundLeakage==true) {
												connectDB_DLFound()->insert(array( 'email' => $email,'DataFound'=>date_format(new DateTime(), 'Y-m-d H:i:s'), 'Plataforma'=>"Pastebin",'URL'=>$value['URL']  ,'TextoEncontrado'=>$value['content'],'Termo'=>$termos[0], 'NomeRegra'=>$rule_name,'Num'=>1,'viewed'=>0,'falsePositiv'=>0));
												
											}else{
												connectDB_DLFound()->insert(array( 'email' => $email,'DataFound'=>date_format(new DateTime(), 'Y-m-d H:i:s'), 'Plataforma'=>"Pastebin",'URL'=>$value['URL']  ,'TextoEncontrado'=>$value['content'],'Termo'=>$termos[0],'NomeRegra'=>$rule_name, 'Num'=>1,'viewed'=>0,'falsePositiv'=>2));
												
											}
											
										}else{
											
										}
							
									}
							
									if($relevo=="Medio"){
										
										
										if(!existsDLFound($termos[0],$value['URL']  ,$email)){
							
											if(emailSended($id_rule)==true){
												sendEmailto($email,$value['URL'] ,$plataform,$termos[0]);
											}
											
											connectDB_Dash()->insert(array( 'email' => $email,'Data'=>date_format(new DateTime(), 'd/m/Y'),'NomeRegra'=>$rule_name , 'Plataforma'=>"Pastebin",'URL'=>$value['URL']  ,'Termo'=>$termos[0], 'Quantidade'=>1));
											
										
											$split_content = explode("\n", $value['content']);
											
											foreach ($split_content as $content){
												if (preg_match($exp_regular,$content)) {
													$foundLeakage=true;
													break;
													
												}else{
													$foundLeakage=false;
											
												}
											}
											
											if ($foundLeakage==true) {
												connectDB_DLFound()->insert(array( 'email' => $email,'DataFound'=>date_format(new DateTime(), 'Y-m-d H:i:s'), 'Plataforma'=>"Pastebin",'URL'=>$value['URL']  ,'TextoEncontrado'=>$value['content'],'Termo'=>$termos[0], 'NomeRegra'=>$rule_name,'Num'=>1,'viewed'=>0,'falsePositiv'=>0));
												
											}else{
												connectDB_DLFound()->insert(array( 'email' => $email,'DataFound'=>date_format(new DateTime(), 'Y-m-d H:i:s'), 'Plataforma'=>"Pastebin",'URL'=>$value['URL']  ,'TextoEncontrado'=>$value['content'],'Termo'=>$termos[0],'NomeRegra'=>$rule_name, 'Num'=>1,'viewed'=>0,'falsePositiv'=>2));
												
											}
											
											
										}else{
			
										
										}
									}
							}
						
						}	
					}		

		
				
			}
			
			connectDB_engine()->close();
			


		
		
		
}


if($plataform=='Shodan'){ 
	$api_key = 'SHODANKEY'; //insert were your shodan api key.
	$shodan2 = new Shodan($api_key);
		
	if($group=="Network"){
		if(sizeof($termos)>1){
			foreach($termos as $valueTermos){
			$ip = $shodan2->host_search("net:".$valueTermos."");
			$array = json_decode(json_encode($ip), true);
			$arrayBuilder=array();

			$data=array();
			if(sizeof($array['matches'])>=1){
			foreach ($array['matches'] as $val){
			
				
				if(!empty($val['ssl']) && sizeof($val['ssl'])>1){
				
					$data=["Organization"=>$val['org'],"Pais"=>$val['location']['country_name'],"Longitude"=>$val['location']['longitude'],"Latitude"=>$val['location']['latitude'],"IP"=>$val['ip_str'],"Porta"=>$val['port'],"Hostname"=>$val['hostnames'][0],"ASN"=>$val['asn'],"Transport"=>$val['transport'],"Data"=>$val['data'],"Certificado"=>["Emissor"=>$val['ssl']['cert']['issuer']['O'],"EmissorCN"=>$val['ssl']['cert']['issuer']['CN'],"Receptor"=>$val['ssl']['cert']['subject']['O'],"ReceptorCN"=>$val['ssl']['cert']['subject']['CN'],"EmitidoEm"=>$val['ssl']['cert']['issued'],
													"ExpiraEm"=>$val['ssl']['cert']['expires'],"versoesSSL"=>$val['ssl']['versions'],"NomeCifra"=>$val['ssl']['cipher']['name'],"VersaoCifra"=>$val['ssl']['cipher']['version'],"bitsCifra"=>$val['ssl']['cipher']['bits'],"ChavePublica"=>$val['ssl']['dhparams']['public_key'],"ParametrosDiffie-Hellman"=>$val['ssl']['dhparams']['fingerprint'],"certificate"=>$val['ssl']['chain']]];
					
					if($relevo=="Alto"){
							
						if(emailSended($id_rule)==false){
							setEmailSendedTrue($id_rule);
							sendEmailto($email,$data,$plataform);
						}
					}
					
					
					if(!existsDLFoundDados($valueTermos, $data, $email)){
					connectDB_Dash()->insert(array( 'email' => $email,'Data'=>date_format(new DateTime(), 'd/m/Y'),'NomeRegra'=>$rule_name ,'Plataforma'=>"Shodan",'Termo'=>$valueTermos, 'Quantidade'=>1));
					
					connectDB_DLFound()->insert(array( 'email' => $email,'DataFound'=>date_format(new DateTime(), 'Y-m-d H:i:s'), 'Plataforma'=>"Shodan",'Termo'=>$valueTermos,'Dados'=>$data, 'NomeRegra'=>$rule_name,'Num'=>1,'viewed'=>0,'falsePositiv'=>2));
					
					
					}


				}else{
					$data=["Organization"=>$val['org'],"Pais"=>$val['location']['country_name'],"Longitude"=>$val['location']['longitude'],"Latitude"=>$val['location']['latitude'],"IP"=>$val['ip_str'],"Porta"=>$val['port'],"Hostname"=>$val['hostnames'][0],"ASN"=>$val['asn'],"Transport"=>$val['transport'],"Data"=>$val['data']];
				
				
					if(!existsDLFoundDados($valueTermos, $data, $email)){
					connectDB_Dash()->insert(array( 'email' => $email,'Data'=>date_format(new DateTime(), 'd/m/Y'),'NomeRegra'=>$rule_name ,'Plataforma'=>"Shodan",'Termo'=>$valueTermos, 'Quantidade'=>1));
					
					connectDB_DLFound()->insert(array( 'email' => $email,'DataFound'=>date_format(new DateTime(), 'Y-m-d H:i:s'), 'Plataforma'=>"Shodan",'Termo'=>$valueTermos,'Dados'=>$data, 'NomeRegra'=>$rule_name,'Num'=>1,'viewed'=>0,'falsePositiv'=>2));
					
					}
				}
			}
			
			
			
		
			}
			
		
			}
		}else{
			$ip = $shodan2->host_search("net:".$termos[0]."");
			$array = json_decode(json_encode($ip), true);
			$arrayBuilder=array();
			$data=array();
			if(sizeof($array['matches'])>=1){
			foreach ($array['matches'] as $val){
			
				
				if(!empty($val['ssl']) && sizeof($val['ssl'])>1){
				
					$data=["Organization"=>$val['org'],"Pais"=>$val['location']['country_name'],"Longitude"=>$val['location']['longitude'],"Latitude"=>$val['location']['latitude'],"IP"=>$val['ip_str'],"Porta"=>$val['port'],"Hostname"=>$val['hostnames'][0],"ASN"=>$val['asn'],"Transport"=>$val['transport'],"Data"=>$val['data'],"Certificado"=>["Emissor"=>$val['ssl']['cert']['issuer']['O'],"EmissorCN"=>$val['ssl']['cert']['issuer']['CN'],"Receptor"=>$val['ssl']['cert']['subject']['O'],"ReceptorCN"=>$val['ssl']['cert']['subject']['CN'],"EmitidoEm"=>$val['ssl']['cert']['issued'],
													"ExpiraEm"=>$val['ssl']['cert']['expires'],"versoesSSL"=>$val['ssl']['versions'],"NomeCifra"=>$val['ssl']['cipher']['name'],"VersaoCifra"=>$val['ssl']['cipher']['version'],"bitsCifra"=>$val['ssl']['cipher']['bits'],"ChavePublica"=>$val['ssl']['dhparams']['public_key'],"ParametrosDiffie-Hellman"=>$val['ssl']['dhparams']['fingerprint'],"certificate"=>$val['ssl']['chain']]];
					
					if($relevo=="Alto"){
							
						if(emailSended($id_rule)==false){
							setEmailSendedTrue($id_rule);
							sendEmailto($email,$data,$plataform);
						}
					}
					
					
					if(!existsDLFoundDados($termos[0], $data, $email)){
					connectDB_Dash()->insert(array( 'email' => $email,'Data'=>date_format(new DateTime(), 'd/m/Y'),'NomeRegra'=>$rule_name ,'Plataforma'=>"Shodan",'Termo'=>$termos[0], 'Quantidade'=>1));
					
					connectDB_DLFound()->insert(array( 'email' => $email,'DataFound'=>date_format(new DateTime(), 'Y-m-d H:i:s'), 'Plataforma'=>"Shodan",'Termo'=>$termos[0],'Dados'=>$data, 'NomeRegra'=>$rule_name,'Num'=>1,'viewed'=>0,'falsePositiv'=>2));
					
					}


				}else{
					$data=["Organization"=>$val['org'],"Pais"=>$val['location']['country_name'],"Longitude"=>$val['location']['longitude'],"Latitude"=>$val['location']['latitude'],"IP"=>$val['ip_str'],"Porta"=>$val['port'],"Hostname"=>$val['hostnames'][0],"ASN"=>$val['asn'],"Transport"=>$val['transport'],"Data"=>$val['data']];
				
				
					if(!existsDLFoundDados($termos[0], $data, $email)){
					connectDB_Dash()->insert(array( 'email' => $email,'Data'=>date_format(new DateTime(), 'd/m/Y'),'NomeRegra'=>$rule_name ,'Plataforma'=>"Shodan",'Termo'=>$termos[0], 'Quantidade'=>1));
					
					connectDB_DLFound()->insert(array( 'email' => $email,'DataFound'=>date_format(new DateTime(), 'Y-m-d H:i:s'), 'Plataforma'=>"Shodan",'Termo'=>$termos[0],'Dados'=>$data, 'NomeRegra'=>$rule_name,'Num'=>1,'viewed'=>0,'falsePositiv'=>2));
					
					}
				}
			}
			
			
			
		
			}
		}
	}
	
	fwrite($fop, ' [+] ID:'.$id_rule.' | Nome: '.$rule_name.' | Termos: '. $termos[0].' | '.$plataform .' | group: '.$group .' | EMAIL: '.$email.''.PHP_EOL );
	fclose($fop);
	
	if($group=="Dominio"){
		if(sizeof($termos)>1){
			foreach($termos as $valueTermos){
				$ip = $shodan2->host_search("hostname:".$valueTermos."");
				$array = json_decode(json_encode($ip), true);
				$arrayBuilder=array();

				$data=array();
				if(sizeof($array['matches'])>=1){
					foreach ($array['matches'] as $val){
							
	
						if(!empty($val['ssl']) && sizeof($val['ssl'])>1){
	
							$data=["Organization"=>$val['org'],"Pais"=>$val['location']['country_name'],"Longitude"=>$val['location']['longitude'],"Latitude"=>$val['location']['latitude'],"IP"=>$val['ip_str'],"Porta"=>$val['port'],"Hostname"=>$val['hostnames'][0],"ASN"=>$val['asn'],"Transport"=>$val['transport'],"Data"=>$val['data'],"Certificado"=>["Emissor"=>$val['ssl']['cert']['issuer']['O'],"EmissorCN"=>$val['ssl']['cert']['issuer']['CN'],"Receptor"=>$val['ssl']['cert']['subject']['O'],"ReceptorCN"=>$val['ssl']['cert']['subject']['CN'],"EmitidoEm"=>$val['ssl']['cert']['issued'],
									"ExpiraEm"=>$val['ssl']['cert']['expires'],"versoesSSL"=>$val['ssl']['versions'],"NomeCifra"=>$val['ssl']['cipher']['name'],"VersaoCifra"=>$val['ssl']['cipher']['version'],"bitsCifra"=>$val['ssl']['cipher']['bits'],"ChavePublica"=>$val['ssl']['dhparams']['public_key'],"ParametrosDiffie-Hellman"=>$val['ssl']['dhparams']['fingerprint'],"certificate"=>$val['ssl']['chain']]];
								
							if($relevo=="Alto"){
									
								if(emailSended($id_rule)==false){
									setEmailSendedTrue($id_rule);
									sendEmailto($email,$data,$plataform);
								}
								
								
								
							}
								
								
							if(!existsDLFoundDados($valueTermos, $data, $email)){
								connectDB_Dash()->insert(array( 'email' => $email,'Data'=>date_format(new DateTime(), 'd/m/Y'),'NomeRegra'=>$rule_name ,'Plataforma'=>"Shodan",'Termo'=>$valueTermos, 'Quantidade'=>1));
								
								connectDB_DLFound()->insert(array( 'email' => $email,'DataFound'=>date_format(new DateTime(), 'Y-m-d H:i:s'), 'Plataforma'=>"Shodan",'Termo'=>$valueTermos,'Dados'=>$data, 'NomeRegra'=>$rule_name,'Num'=>1,'viewed'=>0,'falsePositiv'=>2));
								
							}
	
	
						}else{
							$data=["Organization"=>$val['org'],"Pais"=>$val['location']['country_name'],"Longitude"=>$val['location']['longitude'],"Latitude"=>$val['location']['latitude'],"IP"=>$val['ip_str'],"Porta"=>$val['port'],"Hostname"=>$val['hostnames'][0],"ASN"=>$val['asn'],"Transport"=>$val['transport'],"Data"=>$val['data']];
	
	
							if(!existsDLFoundDados($valueTermos, $data, $email)){
								connectDB_Dash()->insert(array( 'email' => $email,'Data'=>date_format(new DateTime(), 'd/m/Y'),'NomeRegra'=>$rule_name ,'Plataforma'=>"Shodan",'Termo'=>$valueTermos, 'Quantidade'=>1));
								
								connectDB_DLFound()->insert(array( 'email' => $email,'DataFound'=>date_format(new DateTime(), 'Y-m-d H:i:s'), 'Plataforma'=>"Shodan",'Termo'=>$valueTermos,'Dados'=>$data, 'NomeRegra'=>$rule_name,'Num'=>1,'viewed'=>0,'falsePositiv'=>2));
								
							}
						}
					}
						
						
						
	
				}
					
	
			}
		}else{
			$ip = $shodan2->host_search("hostname:".$termos[0]."");
			$array = json_decode(json_encode($ip), true);
			$arrayBuilder=array();
			$data=array();
			if(sizeof($array['matches'])>=1){
				foreach ($array['matches'] as $val){
						
	
					if(!empty($val['ssl']) && sizeof($val['ssl'])>1){
	
						$data=["Organization"=>$val['org'],"Pais"=>$val['location']['country_name'],"Longitude"=>$val['location']['longitude'],"Latitude"=>$val['location']['latitude'],"IP"=>$val['ip_str'],"Porta"=>$val['port'],"Hostname"=>$val['hostnames'][0],"ASN"=>$val['asn'],"Transport"=>$val['transport'],"Data"=>$val['data'],"Certificado"=>["Emissor"=>$val['ssl']['cert']['issuer']['O'],"EmissorCN"=>$val['ssl']['cert']['issuer']['CN'],"Receptor"=>$val['ssl']['cert']['subject']['O'],"ReceptorCN"=>$val['ssl']['cert']['subject']['CN'],"EmitidoEm"=>$val['ssl']['cert']['issued'],
								"ExpiraEm"=>$val['ssl']['cert']['expires'],"versoesSSL"=>$val['ssl']['versions'],"NomeCifra"=>$val['ssl']['cipher']['name'],"VersaoCifra"=>$val['ssl']['cipher']['version'],"bitsCifra"=>$val['ssl']['cipher']['bits'],"ChavePublica"=>$val['ssl']['dhparams']['public_key'],"ParametrosDiffie-Hellman"=>$val['ssl']['dhparams']['fingerprint'],"certificate"=>$val['ssl']['chain']]];
							
						if($relevo=="Alto"){
								
							if(emailSended($id_rule)==false){
								setEmailSendedTrue($id_rule);
								sendEmailto($email,$data,$plataform);
							}
						}
							
							
						if(!existsDLFoundDados($termos[0], $data, $email)){
							connectDB_Dash()->insert(array( 'email' => $email,'Data'=>date_format(new DateTime(), 'd/m/Y'),'NomeRegra'=>$rule_name ,'Plataforma'=>"Shodan",'Termo'=>$termos[0], 'Quantidade'=>1));
							
							connectDB_DLFound()->insert(array( 'email' => $email,'DataFound'=>date_format(new DateTime(), 'Y-m-d H:i:s'), 'Plataforma'=>"Shodan",'Termo'=>$termos[0],'Dados'=>$data, 'NomeRegra'=>$rule_name,'Num'=>1,'viewed'=>0,'falsePositiv'=>2));
							
						}
	
	
					}else{
						$data=["Organization"=>$val['org'],"Pais"=>$val['location']['country_name'],"Longitude"=>$val['location']['longitude'],"Latitude"=>$val['location']['latitude'],"IP"=>$val['ip_str'],"Porta"=>$val['port'],"Hostname"=>$val['hostnames'][0],"ASN"=>$val['asn'],"Transport"=>$val['transport'],"Data"=>$val['data']];
	
	
						if(!existsDLFoundDados($termos[0], $data, $email)){
							connectDB_Dash()->insert(array( 'email' => $email,'Data'=>date_format(new DateTime(), 'd/m/Y'),'NomeRegra'=>$rule_name ,'Plataforma'=>"Shodan",'Termo'=>$termos[0], 'Quantidade'=>1));
							
							connectDB_DLFound()->insert(array( 'email' => $email,'DataFound'=>date_format(new DateTime(), 'Y-m-d H:i:s'), 'Plataforma'=>"Shodan",'Termo'=>$termos[0],'Dados'=>$data, 'NomeRegra'=>$rule_name,'Num'=>1,'viewed'=>0,'falsePositiv'=>2));
							
						}
					}
				}
					
					
					
	
			}
		}
	}
	
	
}
	

?>