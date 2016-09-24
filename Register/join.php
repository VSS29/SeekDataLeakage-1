<?PHP
session_start();

if (empty($_SESSION['loggedIn'])){
	$_SESSION['loggedIn'] = false;
}




include '../handler/handleDB.php';
include '../handler/handleUserFunctions.php';

include_once $_SERVER['DOCUMENT_ROOT'] . '/SDLPlatform/securimage/securimage.php';


if(loggedIn()){
header('Location: /SDLPlatform/index.php');
}

$blacklist = array(
		"0-mail.com",
		"0815.ru",
		"0clickemail.com",
		"0wnd.net",
		"0wnd.org",
		"10minutemail.com",
		"20minutemail.com",
		"2prong.com",
		"30minutemail.com",
		"3d-painting.com",
		"4warding.com",
		"4warding.net",
		"4warding.org",
		"60minutemail.com",
		"675hosting.com",
		"675hosting.net",
		"675hosting.org",
		"6url.com",
		"75hosting.com",
		"75hosting.net",
		"75hosting.org",
		"7tags.com",
		"9ox.net",
		"a-bc.net",
		"afrobacon.com",
		"ajaxapp.net",
		"amilegit.com",
		"amiri.net",
		"amiriindustries.com",
		"anonbox.net",
		"anonymbox.com",
		"antichef.com",
		"antichef.net",
		"antispam.de",
		"baxomale.ht.cx",
		"beefmilk.com",
		"binkmail.com",
		"bio-muesli.net",
		"bobmail.info",
		"bodhi.lawlita.com",
		"bofthew.com",
		"brefmail.com",
		"broadbandninja.com",
		"bsnow.net",
		"bugmenot.com",
		"bumpymail.com",
		"casualdx.com",
		"centermail.com",
		"centermail.net",
		"chogmail.com",
		"choicemail1.com",
		"cool.fr.nf",
		"correo.blogos.net",
		"cosmorph.com",
		"courriel.fr.nf",
		"courrieltemporaire.com",
		"cubiclink.com",
		"curryworld.de",
		"cust.in",
		"dacoolest.com",
		"dandikmail.com",
		"dayrep.com",
		"deadaddress.com",
		"deadspam.com",
		"despam.it",
		"despammed.com",
		"devnullmail.com",
		"dfgh.net",
		"digitalsanctuary.com",
		"discardmail.com",
		"discardmail.de",
		"Disposableemailaddresses:emailmiser.com",
		"disposableaddress.com",
		"disposeamail.com",
		"disposemail.com",
		"dispostable.com",
		"dm.w3internet.co.ukexample.com",
		"dodgeit.com",
		"dodgit.com",
		"dodgit.org",
		"donemail.ru",
		"dontreg.com",
		"dontsendmespam.de",
		"dump-email.info",
		"dumpandjunk.com",
		"dumpmail.de",
		"dumpyemail.com",
		"e4ward.com",
		"email60.com",
		"emaildienst.de",
		"emailias.com",
		"emailigo.de",
		"emailinfive.com",
		"emailmiser.com",
		"emailsensei.com",
		"emailtemporario.com.br",
		"emailto.de",
		"emailwarden.com",
		"emailx.at.hm",
		"emailxfer.com",
		"emz.net",
		"enterto.com",
		"ephemail.net",
		"etranquil.com",
		"etranquil.net",
		"etranquil.org",
		"explodemail.com",
		"fakeinbox.com",
		"fakeinformation.com",
		"fastacura.com",
		"fastchevy.com",
		"fastchrysler.com",
		"fastkawasaki.com",
		"fastmazda.com",
		"fastmitsubishi.com",
		"fastnissan.com",
		"fastsubaru.com",
		"fastsuzuki.com",
		"fasttoyota.com",
		"fastyamaha.com",
		"filzmail.com",
		"fizmail.com",
		"fr33mail.info",
		"frapmail.com",
		"front14.org",
		"fux0ringduh.com",
		"garliclife.com",
		"get1mail.com",
		"get2mail.fr",
		"getonemail.com",
		"getonemail.net",
		"ghosttexter.de",
		"girlsundertheinfluence.com",
		"gishpuppy.com",
		"gowikibooks.com",
		"gowikicampus.com",
		"gowikicars.com",
		"gowikifilms.com",
		"gowikigames.com",
		"gowikimusic.com",
		"gowikinetwork.com",
		"gowikitravel.com",
		"gowikitv.com",
		"great-host.in",
		"greensloth.com",
		"gsrv.co.uk",
		"guerillamail.biz",
		"guerillamail.com",
		"guerillamail.net",
		"guerillamail.org",
		"guerrillamail.biz",
		"guerrillamail.com",
		"guerrillamail.de",
		"guerrillamail.net",
		"guerrillamail.org",
		"guerrillamailblock.com",
		"h.mintemail.com",
		"h8s.org",
		"haltospam.com",
		"hatespam.org",
		"hidemail.de",
		"hochsitze.com",
		"hotpop.com",
		"hulapla.de",
		"ieatspam.eu",
		"ieatspam.info",
		"ihateyoualot.info",
		"iheartspam.org",
		"imails.info",
		"inboxclean.com",
		"inboxclean.org",
		"incognitomail.com",
		"incognitomail.net",
		"incognitomail.org",
		"insorg-mail.info",
		"ipoo.org",
		"irish2me.com",
		"iwi.net",
		"jetable.com",
		"jetable.fr.nf",
		"jetable.net",
		"jetable.org",
		"jnxjn.com",
		"junk1e.com",
		"kasmail.com",
		"kaspop.com",
		"keepmymail.com",
		"killmail.com",
		"killmail.net",
		"kir.ch.tc",
		"klassmaster.com",
		"klassmaster.net",
		"klzlk.com",
		"kulturbetrieb.info",
		"kurzepost.de",
		"letthemeatspam.com",
		"lhsdv.com",
		"lifebyfood.com",
		"link2mail.net",
		"litedrop.com",
		"lol.ovpn.to",
		"lookugly.com",
		"lopl.co.cc",
		"lortemail.dk",
		"lr78.com",
		"m4ilweb.info",
		"maboard.com",
		"mail-temporaire.fr",
		"mail.by",
		"mail.mezimages.net",
		"mail2rss.org",
		"mail333.com",
		"mail4trash.com",
		"mailbidon.com",
		"mailblocks.com",
		"mailcatch.com",
		"maileater.com",
		"mailexpire.com",
		"mailfreeonline.com",
		"mailin8r.com",
		"mailinater.com",
		"mailinator.com",
		"mailinator.net",
		"mailinator2.com",
		"mailincubator.com",
		"mailme.ir",
		"mailme.lv",
		"mailmetrash.com",
		"mailmoat.com",
		"mailnator.com",
		"mailnesia.com",
		"mailnull.com",
		"mailshell.com",
		"mailsiphon.com",
		"mailslite.com",
		"mailzilla.com",
		"mailzilla.org",
		"mbx.cc",
		"mega.zik.dj",
		"meinspamschutz.de",
		"meltmail.com",
		"messagebeamer.de",
		"mierdamail.com",
		"mintemail.com",
		"moburl.com",
		"moncourrier.fr.nf",
		"monemail.fr.nf",
		"monmail.fr.nf",
		"msa.minsmail.com",
		"mt2009.com",
		"mx0.wwwnew.eu",
		"mycleaninbox.net",
		"mypartyclip.de",
		"myphantomemail.com",
		"myspaceinc.com",
		"myspaceinc.net",
		"myspaceinc.org",
		"myspacepimpedup.com",
		"myspamless.com",
		"mytrashmail.com",
		"nepwk.com",
		"nervmich.net",
		"nervtmich.net",
		"netmails.com",
		"netmails.net",
		"netzidiot.de",
		"neverbox.com",
		"no-spam.ws",
		"nobulk.com",
		"noclickemail.com",
		"nogmailspam.info",
		"nomail.xl.cx",
		"nomail2me.com",
		"nomorespamemails.com",
		"nospam.ze.tc",
		"nospam4.us",
		"nospamfor.us",
		"nospamthanks.info",
		"notmailinator.com",
		"nowmymail.com",
		"nurfuerspam.de",
		"nus.edu.sg",
		"nwldx.com",
		"objectmail.com",
		"obobbo.com",
		"oneoffemail.com",
		"onewaymail.com",
		"online.ms",
		"oopi.org",
		"ordinaryamerican.net",
		"otherinbox.com",
		"ourklips.com",
		"outlawspam.com",
		"ovpn.to",
		"neomailbox.com",
		"owlpic.com",
		"pancakemail.com",
		"pimpedupmyspace.com",
		"pjjkp.com",
		"politikerclub.de",
		"poofy.org",
		"pookmail.com",
		"privacy.net",
		"proxymail.eu",
		"prtnx.com",
		"punkass.com",
		"PutThisInYourSpamDatabase.com",
		"qq.com",
		"quickinbox.com",
		"rcpt.at",
		"recode.me",
		"recursor.net",
		"regbypass.com",
		"safe-mail.net",
		"rejectmail.com",
		"rklips.com",
		"rmqkr.net",
		"rppkn.com",
		"rtrtr.com",
		"s0ny.net",
		"safe-mail.net",
		"safersignup.de",
		"safetymail.info",
		"safetypost.de",
		"sandelf.de",
		"saynotospams.com",
		"selfdestructingmail.com",
		"SendSpamHere.com",
		"sharklasers.com",
		"shiftmail.com",
		"shitmail.me",
		"shortmail.net",
		"sibmail.com",
		"skeefmail.com",
		"slaskpost.se",
		"slopsbox.com",
		"smellfear.com",
		"snakemail.com",
		"sneakemail.com",
		"sofimail.com",
		"sofort-mail.de",
		"sogetthis.com",
		"soodonims.com",
		"spam.la",
		"spam.su",
		"spamavert.com",
		"spambob.com",
		"spambob.net",
		"spambob.org",
		"spambog.de",
		"spambog.com",
		"spambog.ru",
		"spambox.info",
		"spambox.irishspringrealty.com",
		"spambox.us",
		"spamcannon.com",
		"spamcannon.net",
		"spamcero.com",
		"spamcon.org",
		"spamcorptastic.com",
		"spamcowboy.com",
		"spamcowboy.net",
		"spamcowboy.org",
		"spamday.com",
		"spamex.com",
		"spamfree24.com",
		"spamfree24.de",
		"spamfree24.eu",
		"spamfree24.info",
		"spamfree24.net",
		"spamfree24.org",
		"spamgourmet.com",
		"spamgourmet.net",
		"spamgourmet.org",
		"SpamHereLots.com",
		"SpamHerePlease.com",
		"spamhole.com",
		"spamify.com",
		"spaminator.de",
		"spamkill.info",
		"spaml.com",
		"spaml.de",
		"spammotel.com",
		"spamobox.com",
		"spamoff.de",
		"spamslicer.com",
		"spamspot.com",
		"spamthis.co.uk",
		"spamthisplease.com",
		"spamtrail.com",
		"speed.1s.fr",
		"supergreatmail.com",
		"supermailer.jp",
		"suremail.info",
		"teewars.org",
		"teleworm.com",
		"tempalias.com",
		"tempe-mail.com",
		"tempemail.biz",
		"tempemail.com",
		"TempEMail.net",
		"tempinbox.co.uk",
		"tempinbox.com",
		"tempmail.it",
		"tempmail2.com",
		"tempomail.fr",
		"temporarily.de",
		"temporarioemail.com.br",
		"temporaryemail.net",
		"temporaryforwarding.com",
		"temporaryinbox.com",
		"thanksnospam.info",
		"thankyou2010.com",
		"thisisnotmyrealemail.com",
		"throwawayemailaddress.com",
		"tilien.com",
		"tmailinator.com",
		"tradermail.info",
		"trash-amil.com",
		"trash-mail.at",
		"trash-mail.com",
		"trash-mail.de",
		"trash2009.com",
		"trashemail.de",
		"trashmail.at",
		"trashmail.com",
		"trashmail.de",
		"trashmail.me",
		"trashmail.net",
		"trashmail.org",
		"trashmail.ws",
		"trashmailer.com",
		"trashymail.com",
		"trashymail.net",
		"trillianpro.com",
		"turual.com",
		"twinmail.de",
		"tyldd.com",
		"uggsrock.com",
		"upliftnow.com",
		"uplipht.com",
		"venompen.com",
		"veryrealemail.com",
		"viditag.com",
		"viewcastmedia.com",
		"viewcastmedia.net",
		"viewcastmedia.org",
		"webm4il.info",
		"wegwerfadresse.de",
		"wegwerfemail.de",
		"wegwerfmail.de",
		"wegwerfmail.net",
		"wegwerfmail.org",
		"wetrainbayarea.com",
		"wetrainbayarea.org",
		"wh4f.org",
		"whyspam.me",
		"willselfdestruct.com",
		"winemaven.info",
		"wronghead.com",
		"wuzup.net",
		"wuzupmail.net",
		"www.e4ward.com",
		"www.gishpuppy.com",
		"www.mailinator.com",
		"wwwnew.eu",
		"xagloo.com",
		"xemaps.com",
		"xents.com",
		"xmaily.com",
		"xoxy.net",
		"yep.it",
		"yogamaven.com",
		"yopmail.com",
		"yopmail.fr",
		"yopmail.net",
		"ypmail.webarnak.fr.eu.org",
		"yuurok.com",
		"zehnminutenmail.de",
		"zippymail.info",
		"zoaxe.com",
		"zoemail.org",
		"33mail.com",
		"maildrop.cc",
		"inboxalias.com",
		"spam4.me",
		"koszmail.pl",
		"tagyourself.com",
		"whatpaas.com",
		"drdrb.com",
		"emeil.in",
		"azmeil.tk",
		"mailfa.tk",
		"inbax.tk",
		"emeil.ir",
		"lackmail.ru",
		"haribu.com");





if(isset($_POST["submitRegist"]) && isset($_POST['captcha_code'])){
$err_pass ="";
$err_userm ="";
$nonagree = "";
$err_captcha ="";
$checkpass = false;
$securimage = new Securimage();


$email = explode('@',  $_POST["email"]);

	
	if(!in_array ($email[1],$blacklist)){
		if(!($_POST["password"] == $_POST["password2"])){
			$err_pass = '<p style="text-align:center; font-size:13px; color:#d62e2e;"> <b>Erro:</b> Passwords nao s&atilde;o iguais!<p>';
		}else{
			$checkpass = true;
		}
		
		
		if ($checkpass){
			if(checkToken($_POST["token"])==true){
				
								
			$query = connectDB_Users()->findOne(array('email' => $_POST["email"])); 
			if(empty($query) && isset($_POST['check']) && $securimage->check($_POST['captcha_code'])==true){
				newUser(htmlentities($_POST["login"]), $_POST["password"], $_POST["email"]); 
				sendEmailto($_POST["email"] , htmlentities($_POST["login"]), gethashFromEmail($_POST["email"]));
				header("Location: /SDLPlatform/Register/redirect.php");
				unset($_SESSION['securimage_code_disp']);
				unset($_SESSION['securimage_code_value']);
				unset($_SESSION['securimage_code_ctime']);
			}else{
				if(!empty($query)){
				$err_userm = '<p style="text-align:center; font-size:13px; color:#d62e2e;"> <b>Erro:</b>O email j&aacute; existe, por favor escolha outro.</p>';
				}
				
				if(!isset($_POST['check'])){
					$nonagree ='<p style="text-align:center; font-size:13px; color:#d62e2e;"> Tem que aceitar os termos e condi&ccedil;&otilde;es.</p>';
				}
				
				if($securimage->check($_POST['captcha_code'])==false){
					$err_captcha ='<p style="text-align:center; font-size:13px; color:#d62e2e;"> O código de seguran&ccedil;a est&aacute; errado! Tente novamente.</p>';
				}
			}
		}
		}
	}else{
		$err_userm = '<p style="text-align:center; font-size:13px; color:#d62e2e;"> <b>Erro:</b>O email que escolheu n&atilde;o &eacute; aceite!</p>';
	}
}


function sendEmailto($emailSend , $username, $var){

	
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
	$mail->Subject = "Registo @ SDL Platform";
	$mail->Body = "Bem vindo à plataforma Seek Data Leakage!<br>
			<br>O seu registo na plataforma foi registado.<br><br>
			 Para activar a sua conta, por favor visite este URL:<br>
		
			-> <a href='https://seekdataleakage.ddns.net/SDLPlatform/Register/confirm.php?email=".$emailSend."&hash=".$var."'> https://seekdataleakage.ddns.net/SDLPlatform/Register/confirm.php?email=".$emailSend."&hash=".$var." </a><br>
			<br>
			+----------------------------------+<br>
			As suas credenciais são:         <br>
			+----------------------------------+<br>
			Username: ".htmlentities($username)."<br>
			Login: ".$emailSend."	<br>	
			+----------------------------------+<br>
		
			<br>
			<br> <small><i>Copyright © 2015-2016 SDLP, Todos os direitos reservados.
			<br>Em caso de contacto faça-o para:
			<br>seekdataleakplataform.info@gmail.com
			<br>Mais info em: https://seekdataleakage.ddns.net/SDLPlatform/index.php</i></small>";
	
	$mail->AddAddress($emailSend);
	if(!$mail->Send())
	{
		echo "Mailer Error: " . $mail->ErrorInfo;
	}
	else
	{
		echo "Message has been sent";
	}
}

?>


<!DOCTYPE html>
<html lang="en-IN">
<head>
<meta charset="utf-8">
<link rel="icon" type="image/ico" href="/SDLPlatform/icons/sdlflavicon.png">
<!-- <meta content="width=320px, initial-scale=1, user-scalable=yes" name="viewport" /> -->
<title>Seek Data Leakage Platform</title>
<!-- <link href='http://fonts.googleapis.com/css?family=Ropa+Sans' rel='stylesheet'> -->
<link href="/SDLPlatform/font-awesome/css/font-awesome.min.css" rel='stylesheet'>
   
 
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script type="text/javascript" src="/SDLPlatform/js/terms.js"></script>
    <link type="text/css" rel="stylesheet" href="/SDLPlatform/css/overlaypopup.css" />

<style type="text/css">
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
</style>
  
  <link href="/SDLPlatform/css/bootstrap-combined.min.css" rel="stylesheet">
  
<!--   	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script> -->
	<script src="/SDLPlatform/js/Stronk.js"></script>	
	
	
</head>
<body oncontextmenu="return false;">
<div id="login-form">
<div>
<ul class="form-header">
<li><label for="signup"><i class="fa fa-credit-card"></i> Registar</label></li>
</ul>
</div>

<div class="section-out">
<section class="signup-section">
 	 <?php if(!loggedIn()){?>
<div class="login">
 <form  method="POST" action="<?=$_SERVER["PHP_SELF"]; ?>" >
<ul class="ul-list">


<li><span class="icon"><i class="fa fa-user"></i></span><input type="text" class="input" required placeholder="Nome de Utilizador ou Empresa" id="username" name="login" maxlength="15"  value="<?php print isset($_POST["login"]) ? htmlentities($_POST["login"]): "" ; ?>"/></li>
<li><span class="icon"><i class="fa fa-envelope-o"></i></span><input type="email" required class="input" id="email" name="email" placeholder="Email (ex@exemplo.com)"value="<?php print isset($_POST["email"]) ? htmlentities($_POST["email"]) : "" ; ?>"/></li>
<?php if(isset($_POST["submitRegist"])){if($err_userm!=""){ echo $err_userm; }}?>
<li><span class="icon"><i class="fa fa-lock"></i></span><input type="password" required class="input" pattern=".{6,}" title="A password tem que ter no mínimo 6 catacteres!" placeholder="Password" id="password" name="password"></li>
<li><span class="icon"><i class="fa fa-lock"></i></span><input type="password" required class="input" id="inputPassword2" name="password2" placeholder="Confirmar password"/></li>
 <?php if(isset($_POST["submitRegist"])){if($err_pass!=""){ echo $err_pass; }}?>
 
<div style="text-align: center">
<li><small>Por favor, insira o texto indicado a baixo.</small></li>
<li><img id="captcha" style="border: 1px solid #ccc;" src="/SDLPlatform/securimage/securimage_show.php" alt="CAPTCHA Image" /></li>
</div>
<li><span class="icon"><a href="#" onclick="document.getElementById('captcha').src = '/SDLPlatform/securimage/securimage_show.php?' + Math.random(); return false"><i class="fa fa-refresh"></i></a></span><input type="text" name="captcha_code" class="input" size="10" maxlength="6" /></li>

 <?php if(isset($_POST["submitRegist"])){if($err_captcha!=""){ echo $err_captcha; }}?> 


<li><input type="checkbox" name="check" value="aceite" id="checkTerms"> <label for="check">Eu aceito os <a class="show-popup" href="#" data-showpopup="1" >Termos e Condi&ccedil;&otilde;es</a></label></li>

<input type="hidden" name="token" value="<?php echo generateToken();?>">

 <?php if(isset($_POST["submitRegist"])&&isset($_POST['captcha_code'])){if($nonagree!=""){ echo $nonagree; }}?>
<li><input name="submitRegist" type="submit" value="Registar" class="btn"></li>
</ul>
</form>
</div>
 <?php }else{
	header("Location: /SDLPlatform/index.php");
 	  }?>
</section>

</div>

</div>

<div class="overlay-bg">
</div>
<div style="text-align:left" class="overlay-content popup1">
   <h1>Terms and Conditions:</h1>
<h2>Last updated: 08/08/2015</h2>
Please read these <b>Terms and Conditions ("Terms", "Terms and Conditions")</b> carefully before using
the SDL Platform:
<br>
Your access to and use of the Service is conditioned on your acceptance of and compliance with
these Terms. These Terms apply to all visitors, users and others who access or use the Service.
By accessing or using the Service you agree to be bound by these Terms. If you disagree with any
part of the terms then you may not access the Service.
Termination clause for websites that do not have accounts. If your website or mobile app allows
users to register and have an account, create your own Terms and Conditions.
<br><br>

<h3>Termination</h3>
We may terminate or suspend access to our Service immediately, without prior notice or liability, for
any reason whatsoever, including without limitation if you breach the Terms.
All provisions of the Terms which by their nature should survive termination shall survive
termination, including, without limitation, ownership provisions, warranty disclaimers, indemnity and
limitations of liability.
<br>
<br>
<h3>Links To Other Web Sites</h3>
Our Service may contain links to third&#45;party web sites or services that are not owned or controlled
by SDL Platform.
SDL Platform has no control over, and assumes no responsibility for, the content,
privacy policies, or practices of any third party web sites or services. You further acknowledge and
agree that SDL Platform shall not be responsible or liable, directly or indirectly, for
any damage or loss caused or alleged to be caused by or in connection with use of or reliance on
any such content, goods or services available on or through any such web sites or services.
We strongly advise you to read the terms and conditions and privacy policies of any third&#45;party web
sites or services that you visit.
<br>
<br>
<h3>Governing Law</h3>
These Terms shall be governed and construed in accordance with the laws of Portugal, without regard to its conflict of law provisions.
Our failure to enforce any right or provision of these Terms will not be considered a waiver of those
rights. If any provision of these Terms is held to be invalid or unenforceable by a court, the
remaining provisions of these Terms will remain in effect. These Terms constitute the entire
agreement between us regarding our Service, and supersede and replace any prior agreements we
might have between us regarding the Service.
<br>
<br>
<h3>Changes</h3>
We reserve the right, at our sole discretion, to modify or replace these Terms at any time. If a
revision is material we will try to provide at least 30 days notice prior to any new terms
taking effect. What constitutes a material change will be determined at our sole discretion 
By continuing to access or use our Service after those revisions become effective, you agree to be
bound by the revised terms. If you do not agree to the new terms, please stop using the Service.
<br>
<br>
<h3>Contact Us</h3>
If you have any questions about these Terms, please contact us @ seekdataleakplataform.info@gmail.com.
</div>


</body>
</html>