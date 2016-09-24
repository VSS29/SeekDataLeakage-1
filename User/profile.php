<?php 

session_start();
include '../handler/handleDB.php';
include '../handler/handleUserFunctions.php';




$erro_pass ="";
$wrongpassAntiga = false;
$erroNoConfirm = false;
$sucessUpdate = false;

if(isset($_POST["token"])){
if(checkToken($_POST["token"])==true){
	if(isset($_POST["submit"])){
		if(!deleteUser($_SESSION["email"], $_POST["passwordDelete"])){
			$erro_pass = '<p style="font-size:13px; color:#d62e2e;"> <b>Erro:</b> A password n&atilde;o est&aacute; correcta..<p>';
		}else{
			header('Location: /SDLPlatform/Register/logout.php');
		}
	}




function sendEmailNewPassword($emailSend, $newpassword){
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
			<br> <small><i>Copyright © 2015-2016 SDLP, Todos os direitos reservados.
			<br>Em caso de contacto faça-o para:
			<br>seekdataleakplataform.info@gmail.com
			<br>Mais info em: https://seekdataleakage.ddns.net/SDLPlatform/index.php</i></small>";

	$mail->AddAddress($emailSend);
	
	$mail->Send();
	
	
}

if(isset($_POST["submitnewpass"])){
		if(!checkPass($_SESSION["email"], $_POST["passwordAntiga"])){
			$wrongpassAntiga = true;
		}
		
		if($_POST["password"]!=$_POST["passwordConfirm"]){
			$erroNoConfirm = true;
		}
		
		if(checkPass($_SESSION["email"], $_POST["passwordAntiga"]) && $_POST["password"]==$_POST["passwordConfirm"]){
			setNewPassword($_SESSION["email"] , $_POST["password"]);
			sendEmailNewPassword($_SESSION["email"] , $_POST["password"]);
			$sucessUpdate=true;
		}
}

}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Vitor Sousa">
    <link rel="icon" type="image/ico" href="/SDLPlatform/icons/sdlflavicon.png">

    <title>Seek Data Leakage Platform</title>

    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css/sb-admin.css" rel="stylesheet">

  

    <!-- Custom Fonts -->
    <link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  
 	<script src="../js/clock.js"></script>
 	


  	<style type="text/css">

	table {
  color: #333;
  font-family: sans-serif;
  font-size: .9em;
  font-weight: 300;
  text-align: center;
  line-height: 35px;
  border-spacing: 0;
  border: 1px solid #9d9d9d;
  width: 200px;
}	

thead tr:first-child {
  background: #9d9d9d;
  color: #fff;
  border: none;
  text-align: center;
}

th {text-align: center;}

tbody tr:hover {background-color: #f0fbff;}
tbody tr:last-child td {border: none;}
tbody td {border-bottom: 1px solid #ddd;}

td:last-child {
  text-align: center;
  padding-right: 10px;
}


.chart-legend span{
    display: inline-block;
    width: 12px;
    height: 12px;
    margin-right: 5px;
}

  	
   
      a:link {
    text-decoration: none;
}

a:visited {
    text-decoration: none;
}

a:hover {
    text-decoration: none;
}

a:active {
    text-decoration: none;
}

li,ul{margin:0; padding:0; list-style:none}


@-webkit-keyframes progress-bar-stripes{from{background-position:40px 0;} to{background-position:0 0;}}@-moz-keyframes progress-bar-stripes{from{background-position:40px 0;} to{background-position:0 0;}}@-ms-keyframes progress-bar-stripes{from{background-position:40px 0;} to{background-position:0 0;}}@-o-keyframes progress-bar-stripes{from{background-position:0 0;} to{background-position:40px 0;}}@keyframes progress-bar-stripes{from{background-position:40px 0;} to{background-position:0 0;}}.progress{overflow:hidden;height:20px;margin-bottom:20px;background-color:#f7f7f7;background-image:-moz-linear-gradient(top, #f5f5f5, #f9f9f9);background-image:-webkit-gradient(linear, 0 0, 0 100%, from(#f5f5f5), to(#f9f9f9));background-image:-webkit-linear-gradient(top, #f5f5f5, #f9f9f9);background-image:-o-linear-gradient(top, #f5f5f5, #f9f9f9);background-image:linear-gradient(to bottom, #f5f5f5, #f9f9f9);background-repeat:repeat-x;filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#fff5f5f5', endColorstr='#fff9f9f9', GradientType=0);-webkit-box-shadow:inset 0 1px 2px rgba(0, 0, 0, 0.1);-moz-box-shadow:inset 0 1px 2px rgba(0, 0, 0, 0.1);box-shadow:inset 0 1px 2px rgba(0, 0, 0, 0.1);-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px;}
.progress .bar{width:0%;height:100%;color:#ffffff;float:left;font-size:12px;text-align:center;text-shadow:0 -1px 0 rgba(0, 0, 0, 0.25);background-color:#0e90d2;background-image:-moz-linear-gradient(top, #149bdf, #0480be);background-image:-webkit-gradient(linear, 0 0, 0 100%, from(#149bdf), to(#0480be));background-image:-webkit-linear-gradient(top, #149bdf, #0480be);background-image:-o-linear-gradient(top, #149bdf, #0480be);background-image:linear-gradient(to bottom, #149bdf, #0480be);background-repeat:repeat-x;filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff149bdf', endColorstr='#ff0480be', GradientType=0);-webkit-box-shadow:inset 0 -1px 0 rgba(0, 0, 0, 0.15);-moz-box-shadow:inset 0 -1px 0 rgba(0, 0, 0, 0.15);box-shadow:inset 0 -1px 0 rgba(0, 0, 0, 0.15);-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;-webkit-transition:width 0.6s ease;-moz-transition:width 0.6s ease;-o-transition:width 0.6s ease;transition:width 0.6s ease;}
.progress .bar+.bar{-webkit-box-shadow:inset 1px 0 0 rgba(0,0,0,.15), inset 0 -1px 0 rgba(0,0,0,.15);-moz-box-shadow:inset 1px 0 0 rgba(0,0,0,.15), inset 0 -1px 0 rgba(0,0,0,.15);box-shadow:inset 1px 0 0 rgba(0,0,0,.15), inset 0 -1px 0 rgba(0,0,0,.15);}
.progress-striped .bar{background-color:#149bdf;background-image:-webkit-gradient(linear, 0 100%, 100% 0, color-stop(0.25, rgba(255, 255, 255, 0.15)), color-stop(0.25, transparent), color-stop(0.5, transparent), color-stop(0.5, rgba(255, 255, 255, 0.15)), color-stop(0.75, rgba(255, 255, 255, 0.15)), color-stop(0.75, transparent), to(transparent));background-image:-webkit-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);background-image:-moz-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);background-image:-o-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);background-image:linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);-webkit-background-size:40px 40px;-moz-background-size:40px 40px;-o-background-size:40px 40px;background-size:40px 40px;}
.progress.active .bar{-webkit-animation:progress-bar-stripes 2s linear infinite;-moz-animation:progress-bar-stripes 2s linear infinite;-ms-animation:progress-bar-stripes 2s linear infinite;-o-animation:progress-bar-stripes 2s linear infinite;animation:progress-bar-stripes 2s linear infinite;}
.progress-danger .bar,.progress .bar-danger{background-color:#dd514c;background-image:-moz-linear-gradient(top, #ee5f5b, #c43c35);background-image:-webkit-gradient(linear, 0 0, 0 100%, from(#ee5f5b), to(#c43c35));background-image:-webkit-linear-gradient(top, #ee5f5b, #c43c35);background-image:-o-linear-gradient(top, #ee5f5b, #c43c35);background-image:linear-gradient(to bottom, #ee5f5b, #c43c35);background-repeat:repeat-x;filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffee5f5b', endColorstr='#ffc43c35', GradientType=0);}
.progress-danger.progress-striped .bar,.progress-striped .bar-danger{background-color:#ee5f5b;background-image:-webkit-gradient(linear, 0 100%, 100% 0, color-stop(0.25, rgba(255, 255, 255, 0.15)), color-stop(0.25, transparent), color-stop(0.5, transparent), color-stop(0.5, rgba(255, 255, 255, 0.15)), color-stop(0.75, rgba(255, 255, 255, 0.15)), color-stop(0.75, transparent), to(transparent));background-image:-webkit-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);background-image:-moz-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);background-image:-o-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);background-image:linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);}
.progress-success .bar,.progress .bar-success{background-color:#5eb95e;background-image:-moz-linear-gradient(top, #62c462, #57a957);background-image:-webkit-gradient(linear, 0 0, 0 100%, from(#62c462), to(#57a957));background-image:-webkit-linear-gradient(top, #62c462, #57a957);background-image:-o-linear-gradient(top, #62c462, #57a957);background-image:linear-gradient(to bottom, #62c462, #57a957);background-repeat:repeat-x;filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff62c462', endColorstr='#ff57a957', GradientType=0);}
.progress-success.progress-striped .bar,.progress-striped .bar-success{background-color:#62c462;background-image:-webkit-gradient(linear, 0 100%, 100% 0, color-stop(0.25, rgba(255, 255, 255, 0.15)), color-stop(0.25, transparent), color-stop(0.5, transparent), color-stop(0.5, rgba(255, 255, 255, 0.15)), color-stop(0.75, rgba(255, 255, 255, 0.15)), color-stop(0.75, transparent), to(transparent));background-image:-webkit-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);background-image:-moz-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);background-image:-o-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);background-image:linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);}
.progress-info .bar,.progress .bar-info{background-color:#4bb1cf;background-image:-moz-linear-gradient(top, #5bc0de, #339bb9);background-image:-webkit-gradient(linear, 0 0, 0 100%, from(#5bc0de), to(#339bb9));background-image:-webkit-linear-gradient(top, #5bc0de, #339bb9);background-image:-o-linear-gradient(top, #5bc0de, #339bb9);background-image:linear-gradient(to bottom, #5bc0de, #339bb9);background-repeat:repeat-x;filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff5bc0de', endColorstr='#ff339bb9', GradientType=0);}
.progress-info.progress-striped .bar,.progress-striped .bar-info{background-color:#5bc0de;background-image:-webkit-gradient(linear, 0 100%, 100% 0, color-stop(0.25, rgba(255, 255, 255, 0.15)), color-stop(0.25, transparent), color-stop(0.5, transparent), color-stop(0.5, rgba(255, 255, 255, 0.15)), color-stop(0.75, rgba(255, 255, 255, 0.15)), color-stop(0.75, transparent), to(transparent));background-image:-webkit-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);background-image:-moz-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);background-image:-o-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);background-image:linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);}
.progress-warning .bar,.progress .bar-warning{background-color:#faa732;background-image:-moz-linear-gradient(top, #fbb450, #f89406);background-image:-webkit-gradient(linear, 0 0, 0 100%, from(#fbb450), to(#f89406));background-image:-webkit-linear-gradient(top, #fbb450, #f89406);background-image:-o-linear-gradient(top, #fbb450, #f89406);background-image:linear-gradient(to bottom, #fbb450, #f89406);background-repeat:repeat-x;filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#fffbb450', endColorstr='#fff89406', GradientType=0);}
.progress-warning.progress-striped .bar,.progress-striped .bar-warning{background-color:#fbb450;background-image:-webkit-gradient(linear, 0 100%, 100% 0, color-stop(0.25, rgba(255, 255, 255, 0.15)), color-stop(0.25, transparent), color-stop(0.5, transparent), color-stop(0.5, rgba(255, 255, 255, 0.15)), color-stop(0.75, rgba(255, 255, 255, 0.15)), color-stop(0.75, transparent), to(transparent));background-image:-webkit-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);background-image:-moz-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);background-image:-o-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);background-image:linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);}



  	</style>


    
</head>



<body oncontextmenu="return false;">
<?php if(loggedIn()){?>
    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="../index.php">SDL Platform</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
             <li class="dropdown">
                    <a id="clockbox"><i class="fa fa-clock-o"></i></a>
                </li>
                
               <li class="dropdown">
                     <?php 
                      $collum = connectDB_DLFound();
	$cursor = $collum->find(array('email' => $_SESSION["email"] , 'viewed' => 0));
	
	
	$top = array();
	if (sizeof($cursor)>=1){
		foreach ($cursor as $value){
				$top[] = ['NomeRegra'=>$value['NomeRegra'],'Quantidade'=>1];
		}
			
		$temp_top = array_map("unserialize", array_unique(array_map("serialize", $top)));
		$numvezesfound=0;

		 
		foreach($temp_top as $key => $value){
			foreach($top as $valuetop){
				if($value['NomeRegra'] == $valuetop['NomeRegra']){
					$numvezesfound +=1;
				}
			}
			$temp_top[$key]['Quantidade'] = $numvezesfound;
			$numvezesfound = 0;
		}
		
		
		$top = $temp_top;
                       		
           
                       	
                       	?>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <?php if(sizeof($top)>=1){?>
                    <i class="fa fa-bell"></i> <span class="label label-danger"> <?php echo sizeof($top); ?></span>
                    <?php }else{?>
                    <i class="fa fa-bell"></i>
                    <?php }?> <b class="caret"></b></a>
                    <ul class="dropdown-menu alert-dropdown">
                       <?php 
                      					
                       	foreach ($top as $value){
                       	?>  
                       	<li>
                            <center><a href="#"><span class="label label-danger">
                         <?php 
                            if(strlen($value['NomeRegra'])>40 ){
                            	$result = substr($value['NomeRegra'], 0, 28). " ...";
                            	echo $result;
                            }else{
                            	     echo $value['NomeRegra'];} ?> </span>  &nbsp;- <span class="label label-danger"> <?php echo $value['Quantidade']; ?> </span> </a>
                       </center>
                        </li>
                         <?php }
                       }
                         ?>
                        <li class="divider"></li>
                        <li>
                            <a href="../checkDLFound.php">Ver todos</a>
                        </li>
                      
                    </ul>
                </li>
                
                <li class="dropdown"> 
             		   <li class="dropdown">   	
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
	                    <i class="fa fa-user"></i> <?=htmlentities($_SESSION["login"]); ?> <b class="caret"></b></a>
	                    <ul class="dropdown-menu">
                        <li>
                            <a href="../User/profile.php"><i class="fa fa-fw fa-user"></i> Perfil</a>
                        </li>
                       <?php if($_SESSION["isAdmin"]){?>
                         <li>
                            <a href="/SDLPlatform/managePlat.php"><i class="fa fa-fw fa-gear"></i> Defini&ccedil;&otilde;es Plataforma</a>
                        </li>
                        <?php }?>
                        <li class="divider"></li>
                        <li>
                            <a href="../Register/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="../index.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#regras" class=""><i class="fa fa-fw fa-arrows-v"></i> Regras <i class="fa fa-fw fa-caret-down"></i></a>
                         <ul id="regras" class="collapse">
                            <li>
                                <a href="/SDLPlatform/ruleCreator/makeRules.php"><i class="fa fa-plus"></i> Criar Regra</a>
                            </li>
                            <li>
                                <a href="/SDLPlatform/ruleCreator/Rules.php"><i class="fa fa-search"></i> Consultar Regras</a>
                            </li>
                        </ul>
                  </li>
                   <li>
                        <a href="../RIPStat.php">   <i class="fa fa-globe"></i> Reputa&ccedil;&atilde;o de IP</a>
                    </li>
                      <li>
                        <a href="../report.php">   <i class="fa fa-file-text"></i> Gera&ccedil;&atilde;o de Relat&oacute;rios</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

      
        <div id="page-wrapper">
					<!-- navegacao -->
<!--                      <ol class="breadcrumb"> -->
<!--                          <li> -->
<!-- 		                   <i class="fa fa-dashboard"></i>  <a href="../index.php">Dashboard</a> -->
<!--                             </li> -->
<!--                             <li class="active"> -->
<!--                                 <i class="fa fa-fw fa-user"></i> Profile -->
<!--                             </li> -->
<!--                     </ol> -->
                     
        
              
            <div class="container-fluid">

                        <h3>Gest&atilde;o de Perfil:</h3>
                        <hr></hr>
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                       
                    </div>
                </div>
                
            
                <!-- /.row -->
               <div class="form-group input-group">
               <center>
             <i class="fa fa-fw fa-user"></i> Nome de Utilizador : <?= $_SESSION["login"];?><br>
             <i class="fa fa-envelope-o"></i> Email: <?= $_SESSION["email"];?><br>
             </center>
              	</div>
		<br>
              	
             <div class="row">
             <div class="col-lg-6">
              <label>  Deseja eliminar a sua conta?</label>
			<hr>
			Confirme a sua password:
			<form action="<?=$_SERVER["PHP_SELF"];?>" method="POST">
			
			 <div class="form-group input-group">
			       <span class="input-group-addon"><i class="fa fa-key"></i></span>
				<input type="password" id="passwordDelete" name="passwordDelete" class="form-control" value="" placeholder="" autocomplete="off">
				</div>
			 <div class="form-group input-group">
				<span class="input-group-addon"><i class="fa fa-trash-o"></i></span>
				<input name="submit" type="submit" onclick="return confirm('Tem a certeza que quer eliminar a sua conta?');" class="btn btn-default" value="Eliminar conta">
			</div>
		
               <?php if(isset($_POST["submit"])){if($erro_pass!=""){ echo $erro_pass;}}?> 
             </div>

             <div class="col-lg-6">
             	 <?php if($wrongpassAntiga==true){
		 	 ?>
		 	 <div class="alert alert-danger">
                    <strong>Erro: </strong> A password que inseriu está incorrecta.
                </div>
		 	 <?php 
				}?>
				
				 <?php if(	$erroNoConfirm==true){
		 	 ?>
		 	 <div class="alert alert-danger">
                    <strong>Erro: </strong> As password inseridas não sao iguais.
                </div>
		 	 <?php 
				}?>
				<?php if($sucessUpdate==true){
		 	 ?>
		 	 <div class="alert alert-success">
                    <strong>Sucesso: </strong> A password foi alterada!
                </div>
		 	 <?php 
				}?>
	
		 	 <label>Alterar a password</label>
		 	 <hr>
		 	 
		 	 	
		 	 	 <div class="form-group input-group">
			       <span class="input-group-addon"><i class="fa fa-key"></i></span>
					<input type="password" id="passwordAntiga" name="passwordAntiga" class="form-control" value="" placeholder="Insira a sua password antiga" autocomplete="off">
				</div>
				 <div class="form-group input-group">
				  <span class="input-group-addon"><i class="fa fa-key"></i></span>
				
				<input type="password" id="password" name="password" class="form-control" value="" placeholder="Insira a sua password nova" autocomplete="off">
				<input type="password" id="passwordConfirm" name="passwordConfirm" class="form-control" value="" placeholder="Confirme a sua password nova" autocomplete="off">
				</div>
			
			 <div class="form-group input-group">
				<span class="input-group-addon"><i class="fa fa-trash-o"></i></span>
				<input name="submitnewpass" type="submit" class="btn btn-default" value="Alterar password">
			</div>
		 	 	
		 	 	
		 	 <input type="hidden" name="token" value="<?php echo generateToken();?>">	
		 	 	</form>
             
             </div>
             
             </div> 	
              	<hr>
		 
		 	 
		</div>
		

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
   <script src="../js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
     
   
	<script src="/SDLPlatform/js/Stronk.js"></script>
	
    <script src="../js/bootstrap.min.js"></script>
   

 <?php }else{
	header("Location: /SDLPlatform/login.php");
 	  }?>



</body>

</html>
