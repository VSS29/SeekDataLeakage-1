<?php
include '../handler/handleDB.php';
include '../handler/handleUserFunctions.php';

$confirm=false;
$erroNoConfirm=false;
$sucessUpdate=false;
if(isset($_GET["email"]) && !empty($_GET["email"]) AND isset($_GET["hash"]) && !empty($_GET["hash"])){
	$email = $_GET["email"];
	$hash = $_GET["hash"];
	if(gethashFromEmail($email)==$hash){
		$confirm=true;
		
	}
	
}

function sendEmailNewPassword($emailSend){
	require 'C:\xampp\htdocs\SDLPlatform\PHPMailer\PHPMailerAutoload.php';

	$mail = new PHPMailer(); // create a new object
	$mail->IsSMTP(); // enable SMTP
	$mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
	$mail->SMTPAuth = true; // authentication enabled
	$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
	$mail->Host = "smtp.gmail.com";
	$mail->Port = 465; // or 587
	$mail->IsHTML(true);
	$mail->Username = "seekdataleakplataform.info@gmail.com";
	$mail->Password = "l8thesisISCTE2015";
	$mail->SetFrom("SDL Platform");
	$mail->Subject = "Alteração de Password!";
	$mail->Body = "A sua password foi alterada com sucesso ! Se não foi alterada pela entidade titular desta conta, entre em contacto conosco.

			<br>
			<br>
			<br> <small><i>Copyright © 2015-2016 SDLP, Todos os direitos reservados.
			<br>Em caso de contacto faça-o para:
			<br>seekdataleakplataform.info@gmail.com
			<br>Mais info em: https://seekdataleakage.ddns.net/SDLPlatform/index.php</i></small>";

	$mail->AddAddress($emailSend);
	
	$mail->Send();
	

}


if(isset($_POST["submitnewpass"])){

	if(gethashFromEmail($_POST["email"])==$_POST["hash"]){
		sendEmailNewPassword($_POST["email"]);
		
		setNewPassword($_POST["email"] , $_POST["password"]);
		setNewHashToEmail($_POST["email"]);
		
		$sucessUpdate=true;
	}
}

?>

<!DOCTYPE html>
<html lang="en-IN">
<head>
<meta charset="utf-8">
<link rel="icon" type="image/ico" href="/SDLPlatform/icons/sdlflavicon.png">
<title>Seek Data Leakage Platform</title>
<!-- <link href='http://fonts.googleapis.com/css?family=Ropa+Sans' rel='stylesheet'> -->



<link href="/SDLPlatform/font-awesome/css/font-awesome.min.css" rel='stylesheet'>
<style>
body{font-family: 'Ropa Sans', sans-serif; color:#666; font-size:14px; color:#333; background-color:#222; }
li,ul,body,input{margin:0; padding:0; list-style:none}
#login-form{width:350px; background:#FFF; margin:0 auto; margin-top:70px; background:#f8f8f8; overflow:hidden; border-radius:7px}
/* .form-header{display:table; clear:both} */
/* .form-header label{display:block; cursor:pointer; z-index:999} */
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


.social-login{padding:15px 20px; background:#f1f1f1; border-top:solid 2px #e8e8e8; text-align:right}
.social-login a{display:inline-block; height:35px; text-align:center; line-height:35px; width:35px; margin:0 3px; text-decoration:none; color:#FFFFFF}
.form a i.fa{line-height:35px}
.fb{background:#305891} .tw{background:#2ca8d2} .gp{background:#ce4d39} .in{background:#006699}
.remember{width:50%; display:inline-block; clear:both; font-size:14px}
.remember:nth-child(2){text-align:right}
.remember a{text-decoration:none; color:#666}

.hide{display:none}

/*swich form*/
#signup:checked~.section-out{margin-left:-350px}
#login:checked~.section-out{margin-left:0px}
#login:checked~div .form-header li:nth-child(1),#signup:checked~div .form-header li:nth-child(2){background:#e8e8e8}
a:link {
    color: #01A9DB;
}
/* visited link */
a:visited {
    color: #01A9DB;
}


/*swich form*/

</style>

 <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<link href="/SDLPlatform/css/bootstrap-combined.min.css" rel="stylesheet">
  
<!--   	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script> -->
	<script src="/SDLPlatform/js/Stronk.js"></script>	

</head>
<body oncontextmenu="return false;">
<div id="login-form">

<!--  <input type="radio" id="signup" name="switch" class="hide" checked onclick="checkit(this);">-->

<div>
<ul class="form-header">
<li><label for="login"> Nova password <label for="login"></li>
<!-- <li><label for="signup"><i class="fa fa-credit-card"></i> Registar</label></li> -->
</ul>
</div>

<div style="" class="section-out">
<section class="login-section">
<div style="text-align:center"class="login">
 <?php if($confirm==true || $sucessUpdate==true){?>
  <form  method="POST" action="<?=$_SERVER["PHP_SELF"]; ?>" >
 <ul class="ul-list">
     <li><span class="icon"><i class="fa fa-lock"></i></span><input type="password" required class="input" pattern=".{6,}" title="A password tem que ter no mínimo 6 catacteres!" placeholder="Password" id="password" name="password"></li>
    <li><input name="submitnewpass" type="submit" value="Alterar" class="btn"></li>
  	<input type="hidden" name="email" value="<?php echo $_GET["email"]; ?>"></input>
  	  	<input type="hidden"  name="hash" value="<?php echo $_GET["hash"]; ?>"></input>
 </ul>      
      </form> 
   			
				
		     <?php if($sucessUpdate==true){
        
        	?>
		 	
                    <p style="text-align:center; font-size:13px; color:#007F00;"><strong>Sucesso: </strong> As password foi alterada, por favor autentique-se <a href='..\login.php'>aqui</a></p>
              
		 	 <?php 
				} ?>		
	
       
       
       <?php  }else{
       	
             	?>
        <i class="fa fa-exclamation-triangle"></i> Erro: 404 ! 
       <?php }?>
 
</section>

</div>



   
</body>

</html>