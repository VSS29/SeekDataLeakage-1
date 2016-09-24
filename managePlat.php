<?PHP
set_include_path('../SDLPlatform/');

include '/functions/functions.php';
include '/handler/handleManagePlataform.php';
include '/handler/handleProxy.php';

if(!loggedIn()){
header('Location: /SDLPlatform/login.php');
}

if(session_status()==PHP_SESSION_NONE){
	session_start();
}

set_time_limit(0);


$check=false;
$checkProm=false;
$sucess="";
$fail="";
$sucessProm="";
$failProm="";
$erro_proprio="";
$erro_proprioProm="";
$deleteTop = "";
$topReseted ="";
$proxyerror="";
$listusers=array();
$listusers=getDB($_SESSION["login"]);





if(isset($_POST["delete"])):

if($_SESSION["login"]==$_POST["delete"]){
	$erro_proprio="N&atilde;o se pode apagar a si proprio";
}else{
$check = deleteid($_POST["delete"]);
header('location: managePlat.php');
if($check){
	$sucess='O utilizador foi apagado com sucesso!';
}else{
	$fail='N&atilde;o foi apagado!';
}

}
endif;

if(isset($_POST["promover"])):

if($_SESSION["login"]==$_POST["promover"]){
	$erro_proprioProm="N&atilde;o se pode promover a si proprio!";
}else{

$checkProm = setAdmin(getEmailFromUserName($_POST["promover"]));

if($checkProm){
	$sucessProm='O utilizdor promovido com sucesso!';
}else{
	$failProm='O utilizador j&aacute; &eacute; administrador!';
}

}
endif;




if(isset($_POST["makeRule"])){
	$cursor = connectDB_Rules();
	$result=$cursor->insert(array('email' => "Server@rule", 'Rule_name'=>"GetAllPBArchives"  , 'Termos_Regra'=>"" , 'Plataforma'=>"PasteBin" , 'Relevo'=>"Alto"  ,'Grupo'=>"N/A", 'isRunning'=>0));
	$getAllPB = getIDbyRuleName("GetAllPBArchives");
	$filename = "C:\\xampp\\htdocs\\SDLPlatform\\UserScripts\\Server@rule\\".$getAllPB.".bat";
	$cmd = 'cd C:\\xampp\\htdocs\\SDLPlatform\\UserScripts\\Server@rule\\
				"C:\xampp\php\php.exe" -f "C:\xampp\htdocs\SDLPlatform\Engine.php" -- -I='.getIDbyRuleName("GetAllPBArchives").'';
	
	$fop = fopen($filename, 'a+');
	fwrite($fop, $cmd."\r\n" );
	fclose($fop);
	
	
	$vsScript ='Set WinScriptHost = CreateObject("WScript.Shell")
				WinScriptHost.Run Chr(34) & "'.$filename.'" & Chr(34), 0
				Set WinScriptHost = Nothing';
	$filenameVBS = "C:\\xampp\\htdocs\\SDLPlatform\\UserScripts\\Server@rule\\".$getAllPB .".vbs";
	$fo = fopen($filenameVBS, 'a+');
	fwrite($fo, $vsScript );
	fclose($fo);

}


if(isset($_POST["makeServerRule"])){
	$cursor = connectDB_Rules();
	$result=$cursor->insert(array('email' => "Server@rule", 'Rule_name'=>"resetPBArchives"  , 'Termos_Regra'=>"" , 'Plataforma'=>"PasteBin" , 'Relevo'=>"Alto"  ,'Grupo'=>"N/A", 'isRunning'=>0));
	$resetPB = getIDbyRuleName("resetPBArchives");
	$filename = "C:\\xampp\\htdocs\\SDLPlatform\\UserScripts\\Server@rule\\".$resetPB.".bat";
	$cmd = 'cd C:\\xampp\\htdocs\\SDLPlatform\\UserScripts\\Server@rule\\
				"C:\xampp\php\php.exe" -f "C:\xampp\htdocs\SDLPlatform\Engine.php" -- -I='.getIDbyRuleName("resetPBArchives").'';

	$fop = fopen($filename, 'a+');
	fwrite($fop, $cmd."\r\n" );
	fclose($fop);


	$vsScript ='Set WinScriptHost = CreateObject("WScript.Shell")
				WinScriptHost.Run Chr(34) & "'.$filename.'" & Chr(34), 0
				Set WinScriptHost = Nothing';
	$filenameVBS = "C:\\xampp\\htdocs\\SDLPlatform\\UserScripts\\Server@rule\\".$resetPB .".vbs";
	$fo = fopen($filenameVBS, 'a+');
	fwrite($fo, $vsScript );
	fclose($fo);

}



if(isset($_POST["playRule"])){
		$rule=null;
		
		if(getIDbyRuleName("GetAllPBArchives") == $_POST["playRule"]){
			startRule($_POST["playRule"]);
			exec("C:\\WINDOWS\\system32\\cmd.exe /c Schtasks /create /tn ".$_POST["playRule"]." /tr C:\\xampp\\htdocs\\SDLPlatform\\UserScripts\\Server@rule\\".$_POST["playRule"].".vbs /sc DAILY /mo 1 /RI 2 /DU 24:00",$rule);
		}else if(getIDbyRuleName("resetPBArchives") == $_POST["playRule"]){
			startRule($_POST["playRule"]);
			exec("C:\\WINDOWS\\system32\\cmd.exe /c Schtasks /create /tn ".$_POST["playRule"]." /tr C:\\xampp\\htdocs\\SDLPlatform\\UserScripts\\Server@rule\\".$_POST["playRule"].".vbs /sc DAILY /st 00:00",$rule);
		}else{
			startRule($_POST["playRule"]);
			
			if(getRelevRule($_POST["playRule"]) == "Baixo"){
				exec("C:\\WINDOWS\\system32\\cmd.exe /c Schtasks /create /tn ".$_POST["playRule"]." /tr C:\\xampp\\htdocs\\SDLPlatform\\UserScripts\\".getUserSpaceByID($_POST["playRule"])."\\".$_POST["playRule"].".vbs /sc DAILY /mo 1 /RI 15 /DU 24:00",$rule);
			}
			
			
			if(getRelevRule($_POST["playRule"]) == "Medio"){
				exec("C:\\WINDOWS\\system32\\cmd.exe /c Schtasks /create /tn ".$_POST["playRule"]." /tr C:\\xampp\\htdocs\\SDLPlatform\\UserScripts\\".getUserSpaceByID($_POST["playRule"])."\\".$_POST["playRule"].".vbs /sc DAILY /mo 1 /RI 10 /DU 24:00",$rule);
			}
			
			
			
			if(getRelevRule($_POST["playRule"]) == "Alto"){
				exec("C:\\WINDOWS\\system32\\cmd.exe /c Schtasks /create /tn ".$_POST["playRule"]." /tr C:\\xampp\\htdocs\\SDLPlatform\\UserScripts\\".getUserSpaceByID($_POST["playRule"])."\\".$_POST["playRule"].".vbs /sc DAILY /mo 1 /RI 5 /DU 24:00",$rule);
			}
			
		
		}
			
}


if(isset($_POST["stopRule"])){
	$rule = null;
	stopRule($_POST["stopRule"]);
	exec("C:\\WINDOWS\\system32\\cmd.exe /c Schtasks /delete /tn ".$_POST["stopRule"]." /f ",$rule);
}

if(isset($_POST["deleteRule"])){

	
	$deletebat=unlink("C:\\xampp\\htdocs\\SDLPlatform\\UserScripts\\".getUserSpaceByID($_POST["deleteRule"])."\\".$_POST["deleteRule"].'.bat');
	$deletevbs=unlink("C:\\xampp\\htdocs\\SDLPlatform\\UserScripts\\".getUserSpaceByID($_POST["deleteRule"])."\\".$_POST["deleteRule"].'.vbs');

	$result = deleteRule($_POST["deleteRule"]);

	if($result && $deletebat && $deletevbs ){
		$sucessApagar ="<Strong> Apagado com sucesso!</Strong>";
	}
	

}

if(isset($_POST["deleteURLS"])){
	connectDB_engine()->drop();
}

if(isset($_POST["deleteProxy"])){
	connectDB_proxy()->drop();
}


if(isset($_POST["addDefault"])){
	setDefaultProxy();
}

if(isset($_POST["deleteProxyWithValue"])){
	deleteProxy($_POST["deleteProxyWithValue"]);
}

if(isset($_POST["newProxy"])){
	$proxyerror=setProxy($_POST["newProxy"]);
}

if(isset($_POST["checkProxy"])){
	checkProxy($_POST["checkProxy"]);
}

if(isset($_POST["refreshProxy"])){
	checkProxy($_POST["refreshProxy"]);
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
    <link href="/SDLPlatform/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/SDLPlatform/css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
	<script src="js/jquery.js"></script>
    <link href="/SDLPlatform/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
     <link href="/SDLPlatform/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
     <script type="text/javascript" src="/SDLPlatform/js/jquery.scrollTo.min.js"></script>
     <script src="/SDLPlatform/js/jquery.dataTables.min.js"></script>
   <script src="/SDLPlatform/js/clock.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

   <style type="text/css">
   
	.tg  {border-collapse:collapse;border-spacing:0; border:#6F6F6F;}
	.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border:#6F6F6F;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
	.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border:#6F6F6F;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
	.tg .tg-s6z2{text-align:center}
	.tg .tg-hgcj{font-weight:bold;text-align:center}
	
	.btn-primary{color:#000;background-color:#EEEEEE;border-color:#D6D6D6}.btn-primary.active,.btn-primary.focus,.btn-primary:active,.btn-primary:focus,.btn-primary:hover,.open>.dropdown-toggle.btn-primary{color:#000;background-color:#A7A7A7;border-color:#969696}
	
    
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

   </style>
   
<!--    <script type="text/javascript" src="/SDLPlatform/js/jquery.scrollTo.min.js"></script> -->
<!--    <script src="/SDLPlatform/js/jquery.dataTables.min.js"></script> -->
      
        <?php 	if($proxyerror=="fail" || $proxyerror=="sucesso"){?>
    				<script>
						$.scrollTo(document.getElementById('jumpProxy'), 800);  
					</script>
    <?php }?>
    
    <script>
    $(document).ready(function() {
        $('#DLFound').DataTable({
              responsive:true  
        });
    });

    $(document).ready(function() {
        $('#DLFound2').DataTable({
              responsive:true  
        });
    });

    $(document).ready(function() {
        $('#Proxy').DataTable({
              responsive:true  
        });
    });
    </script>
    <script>
    function openDiv() {
        var mydiv = document.getElementById('menuEnv');
        if (mydiv.style.display === 'block' || mydiv.style.display === '') {
        	  document.getElementById("users").innerHTML = "<i class='fa fa-users'></i> Lista de Utilizadores <i class='fa fa-arrow-circle-down'></i>";
        	
            mydiv.style.display = 'none';
        } else {
        	  document.getElementById("users").innerHTML = "<i class='fa fa-users'></i> Lista de Utilizadores <i class='fa fa-arrow-circle-up'></i>";
            mydiv.style.display = 'block';
        }
        
    }

    function openDivRules() {
        var mydiv = document.getElementById('menuRules');
        if (mydiv.style.display === 'block' || mydiv.style.display === '') {
        	  document.getElementById("rules").innerHTML = " <i class='fa fa-cogs'></i> Gerir Regras <i class='fa fa-arrow-circle-down'></i>";
        	
            mydiv.style.display = 'none';
        } else {
        	  document.getElementById("rules").innerHTML = "<i class='fa fa-cogs'></i> Gerir Regras <i class='fa fa-arrow-circle-up'></i>";
            mydiv.style.display = 'block';
        }
        
    }

    function openDivURL() {
        var mydiv = document.getElementById('menuURL');
        if (mydiv.style.display === 'block' || mydiv.style.display === '') {
        	  document.getElementById("url").innerHTML = "<i class='fa fa-link'></i> Gerir URLS <i class='fa fa-arrow-circle-down'></i>";
        	
            mydiv.style.display = 'none';
        } else {
        	  document.getElementById("url").innerHTML = "<i class='fa fa-link'></i> Gerir URLS <i class='fa fa-arrow-circle-up'></i>";
            mydiv.style.display = 'block';
        }
        
    }

    function openDivProxy() {
        var mydiv = document.getElementById('menuProxy');
        if (mydiv.style.display === 'block' || mydiv.style.display === '') {
        	  document.getElementById("proxy").innerHTML = "<i class='fa fa-globe'></i> Gerir Proxys <i class='fa fa-arrow-circle-down'></i>";
        	
            mydiv.style.display = 'none';
        } else {
        	  document.getElementById("proxy").innerHTML = "<i class='fa fa-globe'></i> Gerir Proxys <i class='fa fa-arrow-circle-up'></i>";
            mydiv.style.display = 'block';
        }
        
    }
    </script>
   
</head>

<body oncontextmenu="return false;">

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
                <a class="navbar-brand" href="index.php">SDL Platform</a>
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
                            <a href="checkDLFound.php">Ver todos</a>
                        </li>
                      
                    </ul>
                </li>
                
                <li class="dropdown">
             		   <li class="dropdown">
	                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?=$_SESSION["login"]; ?> <b class="caret"></b></a>
	                    <ul class="dropdown-menu">
                        <li>
                            <a href="/SDLPlatform/User/profile.php"><i class="fa fa-fw fa-user"></i> Perfil</a>
                        </li>
                         <?php if($_SESSION["isAdmin"]){?>
                         <li>
                            <a href="/SDLPlatform/managePlat.php"><i class="fa fa-fw fa-gear"></i> Defini&ccedil;&otilde;es Plataforma</a>
                        </li>
                        <?php }?>
                        <li class="divider"></li>
                        <li>
                            <a href="/SDLPlatform/Register/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="index.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
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
                        <a href="RIPStat.php">   <i class="fa fa-globe"></i> Reputa&ccedil;&atilde;o de IP</a>
                    </li>
                      <li>
                        <a href="report.php">   <i class="fa fa-file-text"></i> Gera&ccedil;&atilde;o de Relat&oacute;rios</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

		<?php  
	
		
			if($_SESSION["isAdmin"]){
							
				?>
        <div id="page-wrapper" style="height:auto">
					<!-- navegacao -->
                     <!-- navegacao -->
                     <ol class="breadcrumb">
                            <li>
		                   	Navega&ccedil;&atilde;o: <a href="#jumpURL"> <i class="fa fa-link"></i> Gerir URLS</a> | <a href="#jumpProxy"> <i class='fa fa-globe'></i> Gerir Proxys</a>
                            </li>
                        </ol>
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">                       
                    </div>
                </div>
                <!-- /.row -->
<!-- 	<div class="row"> -->
<!-- 		<div class="col-lg-12"> -->
<!-- 		Navega&ccedil;&atilde;o: <a href="#jumpURL"> <i class="fa fa-link"></i>Gerir URLS</a> | <a href="#jumpProxy"> <i class='fa fa-globe'></i> Gerir Proxys</a> -->
<!-- 		</div> -->
<!-- 	</div> -->
<!-- 	<br><br> -->
	<div class="row">
	<div class="col-lg-12">
	<button type="button" id="users" class="btn btn-primary btn-lg btn-block" style="text-align:left"  onclick="openDiv()"> <i class="fa fa-users"></i> Lista de Utilizadores <i class="fa fa-arrow-circle-down"></i></button>
	<div class="table-responsive" id="menuEnv" style="display:block">
	<br>
	<table id="DLFound" class="table table-hover">
	<thead>
	<tr >
	<th> <i class="fa fa-user"></i> Nome de Utilizador </th>
	<th><i class="fa fa-eye"></i> Administrador </th>
	<th> <i class="fa fa-envelope-o"></i> Email </th>
	<th> <i class="fa fa-check-square-o"></i> Conta confirmada </th>
	<th><i class="fa fa-thumbs-up"></i> Promover a Admin  </th>
	<th><i class="fa fa-trash-o"></i>  Eliminar Utilizador</th>
	</tr>
	</thead>
         <tbody>
	<?php 
			foreach($listusers as $username){
				echo '<tr>';
				echo'<td>'.$username.'</td>';
				if(isAdmin(getEmailFromUserName($username))==1){
					echo '<td>  <i class="fa fa-eye" style="font-size:20px;color:green"></i> Sim</td>';
				}else{
					echo '<td><i class="fa fa-eye-slash" style="font-size:20px;color:red"></i> N&atilde;o</td>';
				}
				echo'<td>'.getEmailFromUserName($username).'</td>';
				
				if(getConfirmFromEmail(getEmailFromUserName($username))==1){
					echo '<td>  <i class="fa fa-check-square-o" style="font-size:20px;color:green"></i> Sim</td>';
					}else{
						echo '<td><i class="fa fa-square-o" style="font-size:20px;color:red"></i> N&atilde;o</td>';
					}
				
			
				?>
				<td>
			
				<?php if(isAdmin(getEmailFromUserName($username))==0){?>
				<form action="<?=$_SERVER["PHP_SELF"];?>" method="POST">
				<button class="btn btn-primary" style="width:150px" value="<?php echo $username;?>" onclick="return confirm('Tem a certeza que quer promover o utilizador <?php echo $username;?> a administrador?');" name="promover"><i class="fa fa-thumbs-up" style="color:grey"></i></button>		
				</form>
			
				<?php }?>
				</td>
				<td>
			
				<form action="<?=$_SERVER["PHP_SELF"];?>" method="POST">
				<button class="btn btn-primary" style="width:150px"  value="<?php echo $username;?>" onclick="return confirm('Tem a certeza que quer eliminar o utilizador <?php echo $username;?> ?');"  name="delete"><i class="fa fa-trash-o"></i></button>
				</form>
				
				</td>
				
				<?php 
				echo '</tr>';
// 			echo isAdmin(getEmailFromUserName($username))==1 ? '<i class="fa fa-2x fa-user"></i> '.$username.' Sim ':'<i class="fa fa-2x fa-user"></i> '.$username.' N&atilde;o'.'<br>';
				}
	echo ' </tbody>';
	echo '</table>';
	echo '</div>';		
	echo '</div>';
	echo '</div>';
			?>
		
	
<form action="<?=$_SERVER["PHP_SELF"];?>" method="POST">

	<?php if(!doesRuleExist("GetAllPBArchives")){?>
	<hr>
	<?php $value['content']= curlGet('http://pastebin.com/archive'); //http://pastebin.com/archive


	$pastPageXPath = returnXPathObject($value['content']);
	$queryERRO = $pastPageXPath->query('//div[@id="error"]');
	if($queryERRO->length == 0){
	?>
	<p style="font-size:19px">Criar Regras:</p>
					Obter Enderecos do PasteBin : <button class="btn btn-success" name="makeRule"><i class="fa fa-plus-square"></i> </button>			
					<?php }else{?>
					
					<div class="alert alert-danger">
                    <strong> <i class="fa fa-exclamation-circle"></i> ERRO <i class="fa fa-exclamation-circle"></i> : </strong> O arquivo do <a href="http://pastebin.com/archive" target="_blank" style="color:#973d40">Pastebin.com</a> encontra-se bloqueado.
               		 </div>
					
				<?php 
			}
	}?>
	

	</form>
	
	
	<?php 
	
	$collum = connectDB_Rules();
	$cursor = $collum->find();
	?>
	<hr>
	<button type="button"  id="rules"  class="btn btn-primary btn-lg btn-block" style="text-align:left"  onclick="openDivRules()"> <i class="fa fa-cogs"></i> Gerir Regras <i class='fa fa-arrow-circle-down'></i></button>
	<!-- <p style="font-size:19px" id="rules" onclick="openDivRules()">Gerir Regras <i class='fa fa-arrow-circle-down'></i></p> -->
	
	<div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive" id="menuRules" style="display:block">
                        	<br> 
                            <table id="DLFound2"  class="table table-hover" >
                                <thead>
				                    <tr>
				                   	<th >Email do utilizador</th>
								    <th >Nome da Regra</th>
								    <th >Termos de Procura</th>
								    <th >Plataforma</th>
								    <th >Relevancia</th>
								    <th >Grupo</th>
								    <th ></th>
								    <th ></th>
								  </tr>
                                </thead>
                                <tbody>
                                   <?php 
				
				foreach ($cursor as $doc){
					
				?>  
				  <tr>
				  	<td><?php echo $doc['email'];?></td>
				    <td ><?php echo $doc['Rule_name'];?></td>
				    <td ><?php  
					if (!empty($doc['Termos_Regra'])){
				     foreach ($doc['Termos_Regra'] as $value) {
				    	if (sizeof($doc['Termos_Regra'])>1){
				    		echo $value." | ";
				    	}else{
				    		echo $value;
				    	}
				    }
					}
				    
				    ?>
				    
				    
				    </td>
				    <td><?php echo $doc['Plataforma'];?></td>
				    <td><?php echo $doc['Relevo'];?></td>
				    <td><?php echo $doc['Grupo'];?></td>
				    <td>
						<form action="<?=$_SERVER["PHP_SELF"];?>" method="POST"> 
				
					<?php if(isRunning($doc['_id'])==false){?>
					<button class="btn btn-primary" name="deleteRule" onclick="return confirm('Tem a certeza que quer eliminar esta regra?');"  value="<?php echo $doc['_id'];?>"><i class="fa fa-trash-o"></i> </button>
	
					<?php }else{ ?>
					<fieldset disabled>
						 <button class="btn btn-success"><i class="fa fa-cog fa-spin"></i></button>
					</fieldset>
						
						<?php }?>
						
				    </td>
				    <td>
						
					<?php if(isRunning($doc['_id'])==false){?>
					<button class="btn btn-success" name="playRule" value="<?php echo $doc['_id'];?>"><i class="fa fa-play-circle"></i> </button>	
					<?php }else{ ?>
					<button class="btn btn-danger" name="stopRule" value="<?php echo $doc['_id'];?>"><i class="fa fa-stop"></i> </button>	
					<?php }?>
						</form>
				    </td>
				   
				 	
				  </tr>
				  <?php 
						
					}
					?>
				    
                                </tbody>
                                  
                            </table>
                         <div id="jumpURL"></div>
                        </div>
                        	
                    </div> 
                </div>

	<hr>
	<button type="button"  id="url"  class="btn btn-primary btn-lg btn-block" style="text-align:left"  onclick="openDivURL()"> <i class="fa fa-link"></i> Gerir URLS <i class='fa fa-arrow-circle-down'></i></button>
	<!-- <p style="font-size:19px" id="url" onclick="openDivURL()">Gerir URLS <i class='fa fa-arrow-circle-down'></i></p> -->
	<div id="menuURL" style="display:block">
	
	<br> 

	<form action="<?=$_SERVER["PHP_SELF"];?>" method="POST">

	<?php if(!doesRuleExist("resetPBArchives")){?>
					Adicionar regra: <button class="btn btn-success" name="makeServerRule"><i class="fa fa-plus-square"></i> </button>			
				
				<?php 
	}?>
	


	
		
		<button class="btn btn-primary" onclick="return confirm('Tem a certeza que quer eliminar todos os URLS?');" name="deleteURLS">Eliminar os URLS <i class="fa fa-trash-o"></i> </button>
	</form>
		<br>
		<br>
	<select multiple="" style="height:500px" class="form-control">
			<?php 
			$getList = connectDB_engine()->find();
			foreach ($getList as $value){
				echo  '<option>'.$value['URL']."</option>";
			}
			?>
     </select>
     
     </div>
	<hr>
	<button type="button"  id="proxy"  class="btn btn-primary btn-lg btn-block" style="text-align:left" onclick="openDivProxy()"> <i class="fa fa-globe"></i> Gerir Proxys <i class='fa fa-arrow-circle-down'></i></button>
	<!-- <p style="font-size:19px" id="proxy" onclick="openDivProxy()">Gerir Proxys <i class='fa fa-arrow-circle-down'></i></p> -->
	<div id="menuProxy" style="display:block">
	<form action="<?=$_SERVER["PHP_SELF"];?>" method="POST">
	<br>
	
	

	<button class="btn btn-primary" name="addDefault"><i class="fa fa-plus"></i> Adicionar Proxys Defaults</button>
	<button class="btn btn-primary" name="deleteProxy" onclick="return confirm('Tem a certeza que quer eliminar todas as proxys?');"><i class="fa fa-trash-o"></i> Apagar todas as Proxys </button>
	
		  	</form>
		  <br>
		  <form action="<?=$_SERVER["PHP_SELF"];?>" method="POST"> 
		  Adicionar uma proxy:
		  <div class="row">
					 <div class="col-lg-4">
			                  <input type="search" id="newProxy" name="newProxy" title="Por favor, insira um IP valido" pattern="[0-9]+(?:\.[0-9]+){3}:[0-9]+" class="form-control" placeholder="Introduza uma nova proxy (IP:Porta).">
			         </div>
			         
			           <div class="col-lg-2">
								<button class="btn btn-default"><i class="fa fa-plus"></i> Adicionar Proxy</button>
					</div>
						
			</div>
			<br>
			<?php if($proxyerror=="sucesso"){?>
					<div class="col-lg-5">
						<div class="alert alert-success">
	                    <strong>Sucesso! </strong> O IP foi adicionado com sucesso!
	               		 </div>
							
               		 </div>
					<?php }
					
					if($proxyerror=="fail"){?>
					<div class="col-lg-5">
							<div id="jumpProxy" class="alert alert-danger">
		                    <strong>Erro !</strong> O IP submetido j&aacute; existe!
		              		  </div>
              		 </div>
					<?php }?>
		</form>
		<br>
	
     <div class="row">
      <div class="col-lg-12">
                        <div class="table-responsive">
                        	<br> 
                            <table id="Proxy"  class="table table-hover">
                                <thead>
				                    <tr>
				                   	<th >IP da Proxy</th>
				                   	<th><center> Conectividade</center></th>
				                   	<th><center> Verificar proxy</center></th>
				                   	<th><center> Apagar proxy</center></th>
								  </tr>
                                </thead>
                                <tbody>
                                   <?php 
                $getList = connectDB_proxy()->find();
				foreach ($getList as $doc){
					
				?>  
				  <tr>
				  	<td width="20%"><?php echo $doc['Proxy'];?></td>
				    <td width="45px">
				    <center>
				     <?php if($doc['time']==0){?>por verificar..<?php }?>
				    <p style="display:none"><?php echo $doc['time'];?></p>
				    <?php if($doc['time']>0 && $doc['time']<8){?><img src="/SDLPlatform/images/signal-64x64-green.png" width="25px" width="25px"></img><?php }?>
				     <?php if($doc['time']>9 && $doc['time']<14){?><img src="/SDLPlatform/images/wifi-signal-normal-64x64-org.png" width="25px" width="25px"></img><?php }?>
				      <?php if($doc['time']>=14){?><img src="/SDLPlatform/images/wifi-signal-low-64x64-red.png" width="25px" width="25px"></img><?php }?>
				    </center>
				    </td>
				   <td width="50px">
				  <?php if($doc['verified']===0){?>
				  	<form action="<?=$_SERVER["PHP_SELF"];?>" method="POST"> 
				  <button class="btn btn-warning" name="checkProxy" value="<?php echo $doc['Proxy'];?>">Por verificar <i class="fa fa-play-circle"></i> </button>
				 	</form>
				  <?php }else{?>
				 <form action="<?=$_SERVER["PHP_SELF"];?>" method="POST"> 
				 <div class="row">
				 <div class="col-lg-3">
				 </div>
				 <div class="col-lg-3">
				 <fieldset disabled="">
                                <button class="btn btn-success"> <i class="fa fa-check-square"></i> Verificado!</button>
                 </fieldset>
                 </div>
                  <div class="col-lg-3">
				  <button class="btn btn-success" name="refreshProxy" style="text-align:right" value="<?php echo $doc['Proxy'];?>">Refresh Proxy <i class="fa fa-refresh"></i> </button>
				 	</div>
				 	<div class="col-lg-3">
				 	</div>
				 	    </div>
				 	</form>
				  <?php }?>
				   </td>
			<td width="30px"><center>
						<form action="<?=$_SERVER["PHP_SELF"];?>" method="POST"> 
					<button class="btn btn-primary" name="deleteProxyWithValue" onclick="return confirm('Tem a certeza que quer eliminar esta proxy?');"  value="<?php echo $doc['Proxy'];?>"><i class="fa fa-trash-o"></i> </button>
				</center>
						</form>
				    </td>
				 	
				  </tr>
				  <?php 
						
					}
					?>
				 
                                </tbody>
                            </table>
                        </div>
                    </div>
              </div>
	</div>
	<div id='jumpProxy'> </div>
<?php 

}
?>


            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

  
    <!-- jQuery -->

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    	
	

</body>

</html>
