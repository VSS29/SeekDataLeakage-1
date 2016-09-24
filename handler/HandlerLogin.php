<?php

function login($email,$password){
if(checkPass($email, $password) && getConfirmFromEmail($email)==true){
	cleanMemberSession(getUsernameFromEmail($email), $password,$email);
	header("Location: /SDLPlatform/index.php");

}else{
	if(!checkPass($email,$password)){
		return 'checkpass';
	}else{
		if(getConfirmFromEmail($email)!=true){
			return 'confirmemail';
		}
	}
}
}

?>