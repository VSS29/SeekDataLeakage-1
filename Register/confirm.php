<?php
include '../handler/handleDB.php';
include '../handler/handleUserFunctions.php';

$confirm=false;
$err="";
if(isset($_GET["email"]) && !empty($_GET["email"]) AND isset($_GET["hash"]) && !empty($_GET["hash"])){
	$email = $_GET["email"];
	$hash = $_GET["hash"];
	if(gethashFromEmail($email)==$hash){
		setConfirm($email);
		$confirm=true;
		$err=mkdir("C:\\xampp\\htdocs\\SDLPlatform\\UserScripts\\".$email."\\", 0700);
		
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


<script type="text/javascript">
    var count = 5;
    var redirect = "/SDLPlatform/login.php";

    function countDown() {
        var timer = document.getElementById("timer");
        if (count > 0) {
            count--;
            timer.innerHTML = "Ir&#225; ser redirecionado para a p&#225;gina de Login dentro de " + count + " segundos.";
            setTimeout("countDown()", 1000);
        } else {
            window.location.href = redirect;
        }
    }
</script>
<link href="/SDLPlatform/font-awesome/css/font-awesome.min.css" rel='stylesheet'>
<style>
body{font-family: 'Ropa Sans', sans-serif; color:#666; font-size:14px; color:#333;background-color:#222; }
li,ul,body,input{margin:0; padding:0; list-style:none}
#login-form{width:600px; background:#FFF; margin:0 auto; margin-top:70px; background:#f8f8f8; overflow:hidden; border-radius:7px}
/* .form-header{display:table; clear:both} */
/* .form-header label{display:block; cursor:pointer; z-index:999} */
.form-header li{margin:0; line-height:60px; width:600px; text-align:center; background:#eee; font-size:18px; float:left; transition:all 600ms ease}

/*sectiop*/
.section-out{width:700px; float:left; transition:all 600ms ease}
.section-out:after{content:''; clear:both; display:table}
.section-out section{width:600px; float:left}

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
.btn{border:none; outline:none; background:#0099CC; font-family: 'Ropa Sans', sans-serif; margin:0 auto; display:block; height:40px; width:100%; padding:0 10px; border-radius:3px; font-size:16px; color:#FFF}

.social-login{padding:15px 20px; background:#f1f1f1; border-top:solid 2px #e8e8e8; text-align:center}
.form a i.fa{line-height:35px}
.remember{width:50%; display:inline-block; clear:both; font-size:14px}
.remember:nth-child(2){text-align:right}
.remember a{text-decoration:none; color:#666}

.hide{display:none}


/*swich form*/

</style>
</head>
<body oncontextmenu="return false;">
<div id="login-form">

<!--  <input type="radio" id="signup" name="switch" class="hide" checked onclick="checkit(this);">-->

<div>
<ul class="form-header">
<li><label for="login"> Confirma&ccedil;&atilde;o<label for="login"></li>
<!-- <li><label for="signup"><i class="fa fa-credit-card"></i> Registar</label></li> -->
</ul>
</div>

<div style="" class="section-out">
<section class="login-section">
<div style="text-align:center"class="login">
 <?php if($confirm==true){?>
      <i class="fa fa-check"></i>Confirma&ccedil;&atilde;o de Email feita com sucesso!
        <br>
        <span id="timer">
            <script type="text/javascript">
                countDown();</script>
        </span>
       
       
       
       <?php 
}else{?>
        <i class="fa fa-exclamation-triangle"></i> Erro: 401 ! N&atilde;o foi feita a confirma&ccedil;&atilde;o do seu email!<br> Por favor, entre em contato conosco.
       <?php }?>
 
</section>

</div>



   
</body>

</html>