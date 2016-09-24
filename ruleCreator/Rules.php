<?php

session_start();

include '../handler/handleDB.php';
include '../handler/handleUserFunctions.php';
include '../handler/handleRules.php';

if(!loggedIn()):
header('Location: /SDLPlatform/login.php');
endif;

set_time_limit(90);


$Added="";

if(isset($_POST["insertDB"])){

	if(empty($_POST['Plataform']) || empty($_POST['Grupo'])){
	$_SESSION['ErroDePlataformEGrupo'] = "Estão empty!";
	header('Location: /SDLPlatform/ruleCreator/makeRules.php');

		
	}else{
		
	unset($_SESSION['ErroDePlataformEGrupo']);
	
	$Plataform = "";
	$Relev = "";
	$Nome_Regra ="";
	$Termos_Regra =array();
	$Grupo=array();
	
	
		if($_POST['Plataform'] == 'Pastebin'){
			$Plataform = "PasteBin";
		}
		
		if($_POST['Plataform'] == 'Shodan'){
			$Plataform = "Shodan";
		}
	

	if($_POST['Relev'] == '2'){
		$Relev ="Alto";
	}
	if($_POST['Relev']== '1'){
		$Relev = "Medio";
	}
	if($_POST['Relev'] == '0'){
		$Relev = "Baixo";
	}

	if($_POST['Grupo'] == 'fuga'){
		$Grupo = "Fuga de dados";
	}
	
	if($_POST['Grupo'] == 'net'){
		$Grupo = "Network";
	}
	if($_POST['Grupo'] == 'domain'){
		$Grupo = "Dominio";
	}
	
	
	if(isset($_POST['emailSend'])){
		$enviaremail=1;
	}else{
		$enviaremail=0;
	}
	

	if(isset($_SESSION['Rule_name'])){
		$Nome_Regra = $_SESSION['Rule_name'];
	}
	
	
	
	

	$collection = connectDB_Rules();
	
	$Terms_cmd="";
	if(isset($_SESSION["Pesquisa"])){
		if(sizeof($_SESSION["Pesquisa"])>1){
			foreach ($_SESSION["Pesquisa"] as $value){
				$Termos_Regra[] = $value;
				$Terms_cmd =$Terms_cmd . ' -T="'.$value.'"';
			}
		}else{
			$Termos_Regra =$_SESSION["Pesquisa"];
			$Terms_cmd = '-T="'.$_SESSION["Pesquisa"][0].'"';
		}
	}
	

	
	$result=$collection->insert(array('email' => $_SESSION["email"], 'Rule_name'=>$Nome_Regra  , 'Termos_Regra'=>$Termos_Regra , 'Plataforma'=>$Plataform , 'Relevo'=>$Relev  ,'Grupo'=>$Grupo, 'isRunning'=>0,'emailed'=>$enviaremail));
	if($result['ok'] == 1){
		$Added = '<Strong> Regra inserida com sucesso, pode carregar no bot&atilde;o  <i class="fa fa-play-circle"></i> para inici&aacute;-la</Strong>';
		
		unset($_SESSION['Rule_name']);
		unset($_SESSION["Pesquisa"]);
	}
	
	
	
	$filename = "C:\\xampp\\htdocs\\SDLPlatform\\UserScripts\\".$_SESSION["email"]."\\".getIDbyRuleName($Nome_Regra,$_SESSION["email"]).'.bat';
	$cmd = 'cd C:\\xampp\\htdocs\\SDLPlatform\\UserScripts\\'.$_SESSION["email"].'\\
				"C:\xampp\php\php.exe" -f "C:\xampp\htdocs\SDLPlatform\Engine.php" -- -I='.getIDbyRuleName($Nome_Regra,$_SESSION["email"]).'';
	
	$fop = fopen($filename, 'a+');
	fwrite($fop, $cmd."\r\n" );
	fclose($fop);
	
	
	$vsScript ='Set WinScriptHost = CreateObject("WScript.Shell")
				WinScriptHost.Run Chr(34) & "'.$filename.'" & Chr(34), 0
				Set WinScriptHost = Nothing';
	$filenameVBS = "C:\\xampp\\htdocs\\SDLPlatform\\UserScripts\\".$_SESSION["email"]."\\".getIDbyRuleName($Nome_Regra,$_SESSION["email"]).'.vbs';
	$fo = fopen($filenameVBS, 'a+');
	fwrite($fo, $vsScript );
	fclose($fo);
	
	
	}

	//unset
 	
}



$sucessApagar="";
if(isset($_POST["playRule"])){
	$rule=null;
	startRule($_POST["playRule"],$_SESSION["email"]);
	
	
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


if(isset($_POST["stopRule"])){
	$rule = null;
	stopRule($_POST["stopRule"],$_SESSION["email"]);
	exec("C:\\WINDOWS\\system32\\cmd.exe /c Schtasks /delete /tn ".$_POST["stopRule"]." /f ",$rule);
}

if(isset($_POST["deleteRule"])){

	
	$deletebat=unlink("C:\\xampp\\htdocs\\SDLPlatform\\UserScripts\\".getUserSpaceByID($_POST["deleteRule"])."\\".$_POST["deleteRule"].'.bat');
	$deletevbs=unlink("C:\\xampp\\htdocs\\SDLPlatform\\UserScripts\\".getUserSpaceByID($_POST["deleteRule"])."\\".$_POST["deleteRule"].'.vbs');
	
	$nome = getRuleNameById($_POST["deleteRule"]);
	
	$colls = connectDB_DLFound();
	$colls->remove(array('NomeRegra' => $nome));
	
	$colls = connectDB_Dash();
	$colls->remove(array('NomeRegra' => $nome));
	
	$result = deleteRule($_POST["deleteRule"],$_SESSION["email"]);


	if($result && $deletebat && $deletevbs ){
		$sucessApagar ="<Strong> Apagado com sucesso!</Strong>";
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

    <title>Seek Data Leakage Plataform</title>

    <!-- Bootstrap Core CSS -->
    <link href="/SDLPlatform/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/SDLPlatform/css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="/SDLPlatform/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
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
   
   <script>
   var deleteLinks = document.querySelectorAll('.delete');

   for (var i = 0; i < deleteLinks.length; i++) {
     deleteLinks[i].addEventListener('click', function(event) {
   	  event.preventDefault();

   	  var choice = confirm(this.getAttribute('data-confirm'));

   	  if (choice) {
   	    window.location.href = this.getAttribute('href');
   	  }
     });
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
                     <!-- navegacao -->
<!--                      <ol class="breadcrumb"> -->
<!--                             <li> -->
<!-- 		                   <i class="fa fa-dashboard"></i>  <a href="../index.php">Dashboard</a> -->
<!--                             </li> -->
<!--                             <li class="active"> -->
<!--                                 <i class="fa fa-file"></i> Regras -->
<!--                             </li> -->
<!--                         </ol> -->
            <div class="container-fluid">

                <!-- Page Heading -->
<!--                 <div class="row"> -->
<!--                     <div class="col-lg-12">                        -->
<!--                     </div> -->
<!--                 </div> -->
                <!-- /.row -->
            			<h3>Regras</h3>
                        <hr></hr>
		
		<?php
		if($Added!=""){
			echo" <br><div class='alert alert-success fade in'>
			<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
			 $Added
			</div>";
		}
		
		$collum = connectDB_Rules();
		$cursor = $collum->find();
	
	
		?>		

				<div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
				                    <tr>
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
					
						if($doc['email'] == $_SESSION["email"]){
				?>  
				  <tr>
				    <td ><?php echo $doc['Rule_name'];?></td>
				    <td ><?php   foreach ($doc['Termos_Regra'] as $value) {
				    	if (sizeof($doc['Termos_Regra'])>1){
				    		echo $value." | ";
				    	}else{
				    		echo $value;
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
					<button class="btn btn-primary" name="deleteRule" onclick="return confirm('Tem a certeza que quer eliminar esta regra?');" value="<?php echo $doc['_id'];?>"><i class="fa fa-trash-o"></i> </button>
	
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
					}?>
				 
                                </tbody>
                            </table>
                        </div>
                    </div>
                  
                </div>

                
                 <?php 
                   
                   if($sucessApagar!=""){
                   	echo " <br><div class='alert alert-success fade in'>
                   	<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                  	$sucessApagar
                   	</div>";
                   }
                   
                   ?>
                   
             
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>

</body>

</html>
