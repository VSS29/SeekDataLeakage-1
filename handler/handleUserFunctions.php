<?php
function getFirstTime($email){
	$connect=connectDB_toCreateDash();
	$ver = $connect->find();
	foreach ($ver as $doc) {
		if($doc['email'] == $email){
			$_SESSION['Plataform'] = $doc['Plataform'];
			$_SESSION['Term'] = $doc['Term'];
			$_SESSION['NomeRegra'] = $doc['NomeRegra'];
			$_SESSION['Ano'] = $doc['Ano'];
			$_SESSION['Mes'] = $doc['Mes'];
		}

	}
}

function newUser($username, $password, $email){
	connectDB_Users()->insert(array('login' => $username, 'password' => hash('sha256', $password) , 'email' => $email, 'hash' => md5(rand(0,1000)), 'confirm' => 0 ,'isAdmin'=>0));
	return true;
}

function getDB($login)
{

	$cursor = connectDB_Users()->find();

	$temp = array();

	foreach ($cursor as $doc) {
		if($doc['login'] != $login):
		$temp[]=$doc['login'];
		endif;
	}

	return $temp;
}

function showDB(){
	$cursor = connectDB_Users()->find();

	foreach ($cursor as $doc){
		print_r($doc);
	}
}

function getUsernameFromEmail($email)
{

	$cursor = connectDB_Users()->find();


	foreach ($cursor as $doc) {
		if(($doc['email'] == $email)):
		return $doc['login'];
		endif;
	}
}

function getEmailFromUserName($Username)
{

	$cursor = connectDB_Users()->find();
	foreach ($cursor as $doc) {
		if(($doc['login'] == $Username)):
		return $doc['email'];
		endif;
	}
}

function gethashFromEmail($email)
{
	$cursor = connectDB_Users()->find();

	foreach ($cursor as $doc) {
		if(($doc['email'] == $email)){
			return $doc['hash'];
		}
	}
}


function setNewHashToEmail($email)
{
	$cursor = connectDB_Users()->findOne(array('email' => $email));
	if ($cursor == true){
		connectDB_Users()->update(array('email'=>$email),array('$set'=>array('hash'=>md5(rand(0,1000)))));
	
	}

}



function isAdmin($email)
{
	$cursor = connectDB_Users()->find();

	foreach ($cursor as $doc) {
		if(($doc['email'] == $email)){
			if ($doc['isAdmin'] === 1){
				return true;
			}
		}
	}
	return false;
}


function  insertAdmin(){
	connectDB_Users()->insert(array('login' => 'admin', 'password' => hash('sha256', 'lol12') , 'email'=> 'root@localhost.com','hash'=>md5(rand(0,1000)), 'confirm'=>true ,'isAdmin'=>1));
}


function getConfirmFromEmail($email)
{
	$cursor = connectDB_Users()->find();

	foreach ($cursor as $doc) {
		if(($doc['email'] == $email)):
		return $doc['confirm'];
		endif;
	}
}


function checkEmailExists($email)
{
	
		return connectDB_Users()->findOne(array('email' => $email));
		
}


function setConfirm($email){
	$cursor = connectDB_Users()->find();

	$cursor = connectDB_Users()->findOne(array('email' => $email));
	if ($cursor == true){
		connectDB_Users()->update(array('email'=>$email),array('$set'=>array('confirm'=>true)));

	}

}


function setNewPassword($email,$newpass){

	$cursor = connectDB_Users()->findOne(array('email' => $email));
	if ($cursor == true){
		connectDB_Users()->update(array('email'=>$email),array('$set'=>array('password'=>hash('sha256',$newpass))));
	}

}


function setAdmin($email){
	$cursor = connectDB_Users()->findOne(array('email' => $email));
	if ($cursor == true){
		connectDB_Users()->update(array('email'=>$email),array('$set'=>array('isAdmin'=>1)));
		return true;
	}
	return false;

}

function checkPass($email, $password)
{
	if(!is_array($password) && !is_array($email)){
	$res = connectDB_Users()->findOne(array('email' => $email, 'password' => hash('sha256', $password)));
	if($res):
	return true;
	endif;
	}
}


function deleteid($idd){
	$res = connectDB_Users()->remove(array('login' => $idd));
	if ($res['n'] == 1){
		return true;
	}
	return false;
}

function deleteUser($email, $passwordDel)
{

	if(checkPass($email, $passwordDel)){
		connectDB_Users()->remove(array('email' => $email));
		return true;
	}

	return false;

}


function deleteDB(){

	$response = connectDB_Users()->drop();

	print_r($response);
}


function cleanMemberSession($login, $password, $email)
{
	$_SESSION["Pesquisa"] = array();
	$_SESSION["email"] = $email;
	$_SESSION["login"]=$login;
	$_SESSION["password"]=$password;
	$_SESSION["loggedIn"]=true;
	$_SESSION["isAdmin"]=isAdmin($email);
	$_SESSION["token"]="";
	getFirstTime($_SESSION["email"]);
}

function generateToken(){
	return ($_SESSION["token"]=md5(uniqid()));
}

function exists(){
	return (isset($_SESSION["token"])) ? true : false;
}


function checkToken($token){	
	if(exists() && $token === $_SESSION["token"]){
		unset($_SESSION["token"]);
		return true;
	}else{
		return false;
	}
	
}


function flushMemberSession()
{
	
	unset($_SESSION["Pesquisa"]);
	unset($_SESSION["email"]);
	unset($_SESSION["login"]);
	unset($_SESSION["password"]);
	unset($_SESSION["loggedIn"]);
	unset($_SESSION["isAdmin"]);
	unset($_SESSION['Plataform']);
	unset($_SESSION['Term']);
	unset($_SESSION['Mes']);
	unset($_SESSION['verifyTermSession']);
	unset($_SESSION);
	session_destroy();

}

function loggedIn()
{
	if($_SESSION['loggedIn']):
	return true;
	else:
	return false;
	endif;
}

?>