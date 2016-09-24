<?PHP

session_start();

if (empty($_SESSION['loggedIn'])){
	$_SESSION['loggedIn'] = false;
}

set_include_path('../SDLPlatform/');


 include 'handler/handleDB.php';
 include 'handler/handleUserFunctions.php';


 function getMonthByNumber($id){
 
 	if($id == "01"){
 		return "Janeiro";
 	}
 	if($id == "02"){
 		return "Fevereiro";
 	}
 
 	if($id == "03"){
 		return "Mar&ccedil;o";
 	}
 	if($id == "04"){
 		return "Abril";
 	}
 	if($id == "05"){
 		return "Maio";
 	}
 	if($id == "06"){
 		return "Junho";
 	}
 	if($id == "07"){
 		return "Julho";
 	}
 	if($id == "08"){
 		return "Agosto";
 	}
 	if($id == "09"){
 		return "Setembro";
 	}
 	if($id == "10"){
 		return "Outubro";
 	}
 	if($id == "11"){
 		return "Novembro";
 	}
 	if($id == "12"){
 		return "Dezembro";
 	}
 
 }
 
 
 function getRealUserIp(){
 	switch(true){
 		case (!empty($_SERVER['HTTP_X_REAL_IP'])) : return $_SERVER['HTTP_X_REAL_IP'];
 		case (!empty($_SERVER['HTTP_CLIENT_IP'])) : return $_SERVER['HTTP_CLIENT_IP'];
 		case (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) : return $_SERVER['HTTP_X_FORWARDED_FOR'];
 		default : return $_SERVER['REMOTE_ADDR'];
 	}
 }
 
?>
