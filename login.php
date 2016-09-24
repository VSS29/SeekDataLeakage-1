<?PHP
include_once("functions/functions.php");
include_once("handler/HandlerLogin.php");
include_once("handler/handleUserFunctions.php");

if(loggedIn()){
	header('Location: /SDLPlatform/index.php');
}

if(isset($_POST["submitLogin"])){

	$err_user_pass ="";
	$err_user_email ="";




$erro = login($_POST["email"], $_POST["password"]);

if($erro = 'checkpass'){
	$err_user_pass = '<p style="text-align:center; font-size:13px; color:#d62e2e;"> <b>Erro:</b> Email ou Password Incorrectas!';
}else{
	if($erro = 'confirmemail'){
	$err_user_email = '<p style="text-align:center; font-size:13px; color:#d62e2e;"> <b>Erro:</b> Por favor, confirme o seu email!';
	}
}

			//   if(checkPass($_POST["email"], $_POST["password"]) && getConfirmFromEmail($_POST["email"])==true){
			//   	cleanMemberSession(getUsernameFromEmail($_POST["email"]), $_POST["password"],$_POST["email"]);
			//   	header("Location: /SDLPlatform/index.php");
			    
			// }else{
			// 	if(!checkPass($_POST["email"], $_POST["password"])){
			// 	$err_user_pass = '<p style="text-align:center; font-size:13px; color:#d62e2e;"> <b>Erro:</b> Email ou Password Incorrectas!';
			// 	}else{
			//     if(getConfirmFromEmail($_POST["email"])!=true){
			//     	$err_user_email = '<p style="text-align:center; font-size:13px; color:#d62e2e;"> <b>Erro:</b> Por favor, confirme o seu email!';		
			// 	}
			// 	}
			// }
	}


?>


<!DOCTYPE html>
<html lang="en-IN">
<head>
<meta charset="utf-8">
<title>Seek Data Leakage Platform</title>
<link rel="icon" type="image/ico" href="/SDLPlatform/icons/sdlflavicon.png">
<!-- <link href='http://fonts.googleapis.com/css?family=Ropa+Sans' rel='stylesheet'> -->
<link type="text/css" href="font-awesome/css/font-awesome.min.css" rel='stylesheet'>
<style type="text/css">
body{font-family: 'Ropa Sans', sans-serif; color:#666; font-size:14px; color:#333; background-color:#222;}
li,ul,body,input{margin:0; padding:0; list-style:none}
#login-form{width:350px; background:#FFF; margin:0 auto; margin-top:20px; background:#f8f8f8; overflow:hidden; border-radius:7px}
.form-header li{margin:0; line-height:60px; width:350px; text-align:center; background:#eee; font-size:18px; float:left; transition:all 600ms ease}

/*sectiop*/
.section-out{width:700px; float:left; transition:all 600ms ease}
.section-out:after{content:''; clear:both; display:table}
.section-out section{width:350px; float:left}

.login{padding:20px}
.ul-list{clear:both; display:table; width:100%}
.ul-list:after{content:''; clear:both; display:table}
.ul-list li{ margin:0 auto; margin-bottom:12px}
.input{background:#fff; transition:all 800ms; width:247px; border-radius:3px 0 0 3px; font-family: 'Ropa Sans', sans-serif; border:solid 1px #ccc; border-left:none;  outline:none; color:#999; height:40px; line-height:40px; display:inline-block; padding-left:10px; font-size:16px}
.input,.login span.icon{vertical-align:top}
.login span.icon{width:50px; transition:all 800ms; text-align:center; color:#999; height:40px; border-radius:3px 0 0 3px; background:#e8e8e8; height:40px; line-height:40px; display:inline-block; border:solid 1px #ccc; border-right:none; font-size:16px}
.input:focus:invalid{border-color:red}
.input:focus:invalid+.icon{border-color:red}
.input:focus:valid{border-color:green}
.input:focus:valid+.icon{border-color:green}
#check,#check1{top:1px; position:relative}
.btn{border:none; outline:none; background:#337ab7; font-family: 'Ropa Sans', sans-serif; margin:0 auto; display:block; height:40px; width:100%; padding:0 10px; border-radius:3px; font-size:16px; color:#FFF}

.social-login{padding:15px 20px; background:#f1f1f1; border-top:solid 2px #e8e8e8; text-align:center}
.form a i.fa{line-height:35px}
.remember{width:50%; display:inline-block; clear:both; font-size:14px}
.remember:nth-child(2){text-align:right}
.remember a{text-decoration:none; color:#666}

.hide{display:none}
a:link {
    color: #01A9DB;
}

a:visited {
    color: #01A9DB;
}

.strike {
    display: block;
    text-align: center;
    overflow: hidden;
    white-space: nowrap; 
}

.strike > span {
    position: relative;
    display: inline-block;
}

.strike > span:before,
.strike > span:after {
    content: "";
    position: absolute;
    top: 100%;
    height: 2px;
    background: #000000;
}

.strike > span:before {
    right: 100%;
    margin-right: 15px;
}

.strike > span:after {
    left: 100%;
    margin-left: 15px;
}



</style>

	
</head>
<body oncontextmenu="return false;">


<div align="center" style="margin-top:100px;">
&nbsp;<img src="/SDLPlatform/images/SDL_LOGO.png" width="400px" height="30px"></img>
</div>
<div id="login-form">


<div>
<ul class="form-header">
<li><label for="login"><i class="fa fa-lock"></i> Entrar<label for="login"></li>
</ul>
</div>

<div style="" class="section-out">
<section class="login-section">
<div class="login">
<?php if(!loggedIn()){?>
      
<form method="post" action="<?=$_SERVER["PHP_SELF"]; ?>" >
<ul class="ul-list">
<li><span class="icon"><i class="fa fa-envelope-o"></i></span><input type="Text" required class="input" id="email" type="email" name="email" placeholder="Email" value="<?= isset($_POST["email"]) ? htmlentities($_POST["email"]) : "" ; ?>" /></li>
<li><span class="icon"><i class="fa fa-lock"></i></span><input  class="input" type="password" id="inputPassword" class="form-control" name="password" placeholder="Password" required autocomplete="off"/></li>


<input type="hidden" name="token" value="<?php echo generateToken();?>">
<li><input name="submitLogin" type="submit" value="Entrar" class="btn"/></li>
 <?php if(isset($_POST["submitLogin"])){if($err_user_pass!=""){ echo $err_user_pass; }}?>
 <?php if(isset($_POST["submitLogin"])){if($err_user_email!=""){ echo $err_user_email; }}?>
</ul>
</form>
</div>

 <div align="center"> 
       <i class="fa fa-credit-card"></i>&nbsp;<a href="/SDLPlatform/Register/join.php">Registe-se aqui</a> Ou&nbsp;<a href="/SDLPlatform/Register/reset.php">Recupere a password</a>
		<br><br>
</div>
 
</section>

 	 <?php }else{
	header("Location:/SDLPlatform/index.php");
 	  }?>

</div>   
</body>

</html>