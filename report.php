<?php 
include("/functions/functions.php");
include("/handler/handleReport.php");
if(!loggedIn()):
header('Location: /SDLPlatform/login.php');
endif;

if(session_status()==PHP_SESSION_NONE){
	session_start();
}

$crf_check=false;

if(isset($_POST["token"])){
	if(checkToken($_POST["token"])==true){
		$crf_check=true;
	}
}


if(isset($_POST["getSearch"])){

	if(!empty($_POST["getSearch"])){
		
		$_SESSION["Pesquisa"][] = htmlentities($_POST["getSearch"]);

		$_SESSION["Pesquisa"] = array_unique($_SESSION["Pesquisa"]);
		
	
	}
}	

if(isset($_POST["getChecks"])){
	
	$name[] = $_POST["getChecks"];
	
	print_r($name);

}


$erroRuleName="";
if(isset($_POST["name"])){
	if(!checkUniqueRuleName($_POST["name"])){
	$_SESSION['Rule_name'] = $_POST["name"];
	}else{
		$erroRuleName="O nome da regra tem que ser unico!";
	}
}



if (isset($_POST['removeTop'])) {

	$temp=$_SESSION['Pesquisa'];

	if (($key = array_search(htmlentities($_POST['removeTop']), $temp)) !== false) {
		unset($temp[$key]);
		$_SESSION['Pesquisa']=$temp;
	}
}

$errOnlyImage="";
$errIDK="";
$errUploadBig="";
if(isset($_POST["submitImage"])) {
	

	
	$target_dir = dirname(realpath(__FILE__)).'\\UserScripts\\'.$_SESSION["email"].'\\reportImage\\';
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	// Check if image file is a actual image or fake image
	$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
	if($check !== false) {
		$uploadOk = 1;
	} else {
		$uploadOk = 0;
	}



	// Check file size
	if ($_FILES["fileToUpload"]["size"] > 500000) {
		$errUploadBig = "O tamanho do ficheiro &eacute; demasiado grande.";
		$uploadOk = 0;
	}
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
				$errOnlyImage = "Erro: apenas imagens ( JPG, JPEG, PNG & GIF ) s&atilde;o permitidas.";
				$uploadOk = 0;
			}
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
			} else {
				if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				} else {
					$errIDK =  "Erro: Alguma coisa se passou, tente novamente.";
				}
			}
	
}

if(isset($_POST['deleteImage'])){
	$files = glob('UserScripts/'.$_SESSION["email"].'/reportImage/*'); // get all file names
	foreach($files as $file){ // iterate files
		if(is_file($file))
			unlink($file); // delete file
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
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
      <script src="/SDLPlatform/js/clock.js"></script>
      
      
      <script type="text/javascript" src="https://gabelerner.github.io/canvg/rgbcolor.js"></script> 
<script type="text/javascript" src="https://gabelerner.github.io/canvg/StackBlur.js"></script>
<script type="text/javascript" src="https://gabelerner.github.io/canvg/canvg.js"></script> 
      
      
   
      
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

   
 	textarea {resize:both; } /* none|horizontal|vertical|both */
	textarea.vert { resize:vertical; }
	textarea.noResize { resize:none; }
	
	.radio-toolbar input[type="radio"] {
    display:none;
	}

	.radio-toolbar label {
    display:inline-block;
    background-color:#ddd;
    padding:4px 11px;
    font-family:Arial;
    font-size:16px;
	}
	
	.radio-toolbar input[type="radio"]:checked + label {
    background-color:#bbb;
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
   
.ports li{background-color:#1ca8dd;color:white;float:left;font-size:12px;font-weight:bold;height:48px;list-style-type:none;margin:5px;position:relative;text-shadow:none;width:48px;}
.ports li{font-weight:normal;}
li{line-height:18px;}
.ports li>a{color:white;height:34;position:absolute;text-align:center;top:30%;width:48px;}
.detalhes{float:left;margin-right:20px;text-align:center;width:100px;}
detalhes>div, .detalhes>a{color:white;text-shadow:none;}
.detalhes .porta{background-color:#1ca8dd;color:white;}
.detalhes .nome{background-color:#A6CE87;color:white;}
.detalhes .protocolo{background-color:#FF915F;color:white;}
.detalhes .link{background-color:#7DBB4D;color:white;display:block;margin-top:20px;}
.detalhes .link:hover{background-color:#444;}


pre{background-color:transparent;border:0;border-top:1px solid #eee;margin:0;padding:10px 0;}

   </style>


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
                                <a href="/SDLPlatform/ruleCreator/makeRules.php">Criar Regra</a>
                            </li>
                            <li>
                                <a href="/SDLPlatform/ruleCreator/Rules.php">Consultar Regras</a>
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

         <div id="page-wrapper" >
			<!-- navegacao -->
                   <!-- navegacao -->
<!--                      <ol class="breadcrumb"> -->
<!--                             <li> -->
<!-- 		                   <i class="fa fa-dashboard"></i>  <a href="index.php">Dashboard</a> -->
<!--                             </li> -->
<!--                             <li class="active"> -->
<!--                                 <i class="fa fa-file"></i> Relat&oacute;rio -->
<!--                             </li> -->
<!--                         </ol> -->
            <div class="container-fluid">
				 <h3>Gera&ccedil;&atilde;o de Relat&oacute;rios</h3>
				 <hr></hr>
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">

					
	
		 
                       
               
                    </div>
                </div>
                
                   <div class="row">
                <div class="col-lg-3">
                </div>
                           <div class="col-lg-6">
                           <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-picture-o"></i> Imagem para o relatorio</h3>
                            </div>
                            <div class="panel-body" align="center">
                    <?php 

					if(!file_exists(dirname(realpath(__FILE__)).'\\UserScripts\\'.$_SESSION["email"].'\\reportImage\\')){
						mkdir(dirname(realpath(__FILE__)).'\\UserScripts\\'.$_SESSION["email"].'\\reportImage\\', 0777, true);
					}
					
					
					
                  // $isDirEmpty = !(new \FilesystemIterator(dirname(realpath(__FILE__)).'\\UserScripts\\'.$_SESSION["email"].'\\reportImage\\'))->valid();
                   

                    if(!(new \FilesystemIterator(dirname(realpath(__FILE__)).'\\UserScripts\\'.$_SESSION["email"].'\\reportImage\\'))->valid()){?>
          <form action="report.php" method="post" enctype="multipart/form-data">
   Escolha uma imagem para carregar: <small>(Comprimento: 150px, Altura: 28px)</small>
   				 <input class="btn btn-default" type="file" name="fileToUpload" id="fileToUpload">
   			<br>
   				  <input class="btn btn-default" type="submit" value="Carregar imagem" name="submitImage">
		</form>
		
				<?php if(!empty($errUploadBig)){?>
				<div class='alert alert-danger fade in'>
									<?php echo $errUploadBig;?>
									</div>
                    <?php }?>
                    
                 	<?php if(!empty($errOnlyImage)){?>
				<div class='alert alert-danger fade in'>
									<?php echo $errOnlyImage;?>
									</div>
                    <?php }?>  
                    
                    <?php if(!empty($errIDK)){?>
				<div class='alert alert-danger fade in'>
									<?php echo $errIDK;?>
									</div>
                    <?php }?> 
		
				<?php }else{?>
						
		
		<form action="report.php" method="post">
			<?php $handle = opendir(dirname(realpath(__FILE__)).'\\UserScripts\\'.$_SESSION["email"].'\\reportImage\\');
       			 while($file = readdir($handle)){
          		  if($file !== '.' && $file !== '..'){
                echo '<img src="UserScripts/'.$_SESSION["email"].'/reportImage/'.$file.'" border="0" width="150px" height="28px"/>';
                echo '&nbsp;';
                echo '<button class="btn btn-default" name="deleteImage"><i class="fa fa-trash"></i></button>';
         
            }
        }?>
			</form> 
		<?php }?>
		</div>
                    </div>
                    </div>
                     <div class="col-lg-3">
                </div>
          </div>
                    
                    <br>
                    
                <!-- /.row -->
                
                
                
		<?php 
		$reportSucess=false;
		if(isset($_POST["rules"])){
			$reportSucess=true;
		}
			
		$coll = connectDB_Dash();
			
		$cursor = $coll->find(array('email' => $_SESSION["email"]));
		$all = array();
		foreach ($cursor as $doc) {
				$m = date_parse_from_format("d/m/y", $doc['Data']);
				$all[] = $m["month"];
		}
		
		$filtro = array_unique($all);
		?>
		<?php if($reportSucess == false){?>
			<div class="row">
                    <div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-calendar"></i> Escolha o Ano e o M&ecirc;s</h3>
                            </div>
                            <div class="panel-body">
                              <form name='myform' action='report.php' method='POST'>
                           <div clasS="col-lg-6">
                            <select name="Ano" size="11" class="form-control" id="Ano">
                            <option name="Ano" value="2015">2015</option> 
                             <option name="Ano" value="2016" selected>2016</option> 
                              <option name="Ano" value="2017">2017</option> 
                            </select>
                           </div>
                           <div clasS="col-lg-6">
							<select name="Mes" size="11" class="form-control" id="Mes">
							
							<?php 
							foreach ($filtro as $value){
								if(isset($_POST['Mes']) && !empty($_SESSION['MesReport'])){
									?>
									
									
									<?php 
									
	
									$_SESSION['MesReport'] = $_POST['Mes']	;
									
									
									if($_SESSION['MesReport'] == $value){
									?>
									
									<option name="Mes" value="<?php echo $value;?>" selected><?php echo getMonthByNumber($value);?></option> 
									<?php }else{?>	
									<option name="Mes" value="<?php echo $value;?>"><?php echo getMonthByNumber($value);?></option> 
								<?php }?>
							
							<?php 
									
								}else{?>
								<option name="Mes" value="<?php echo $value;?>"><?php echo getMonthByNumber($value);?></option> 	
						<?php 
								}

						}
							?>
						    
							</select>
							 </div>
							&nbsp;
							<center>
							<button class="btn btn-default" name="refresh" style="width:200px;height:auto"><i class="fa fa-plus"></i>   Escolher</button>	
							<input type="hidden" name="token" value="<?php echo generateToken();?>"> 
							</center>
					</form>
                            </div>
                        </div>
                    </div>

                    <?php 
 		
      if($crf_check === true){ 

      	
     
      	$path = dirname(realpath(__FILE__)).'\\UserScripts\\'.$_SESSION["email"].'\\reportImage\\*';
      	if (count(glob($path)) === 0 ) {
      		echo '  
			  <div class="col-lg-6">
                        <div class="panel panel-default">
			<div class="panel-heading">
						<h3 class="panel-title">Erro!</h3>
                            </div>
                            <div class="panel-body">';
      		echo	"<div class='alert alert-danger fade in'>
									Por favor, inclua uma imagem para o relatorio
									</div>";
      		echo "  </div>
                        </div>
			</div>
                        </div>";
      		 
      	}else{
      	
     
      	
 		if(isset($_POST['Mes']) && isset($_POST['Ano'])){
 			
 			$_SESSION['MesReport'] = $_POST['Mes']	;
 			$_SESSION['AnoReport'] = $_POST['Ano']	;
 			
 			$rulename=array();
 			$rulename=getNameOfRule($_POST['Mes'],$_POST['Ano']);
 			
 			
 		?>
 		  <div class="col-lg-6">
                        <div class="panel panel-default">
                          
 		
 		<?php 
 		
 		
 			if(empty($rulename)){
 				echo '  <div class="panel-heading">
						<h3 class="panel-title">Erro!</h3>
                            </div>
                            <div class="panel-body">';
 				echo	"<div class='alert alert-danger fade in'>
									 N&atilde;o existem regras com resultados nesse m&ecirc;s.
									</div>";
 				echo "  </div>   
                        </div>
                    </div>
                </div>";
 			}else{
 			
 		?>
 						 
 						 <div class="panel-heading">
                                <h3 class="panel-title">Escolha as regras a incluir</h3>
                            </div>
                            <div class="panel-body">
 		<?php 
 			
 			$nomeregrafiltro=array();
 			foreach ($rulename as $nomeregra){
 				if($nomeregra['email'] == $_SESSION["email"]){
 					$nomeregrafiltro[] = $nomeregra['NomeRegra'];
 				}
 			}
 			
 			$nomeregrafiltro = array_unique($nomeregrafiltro);
 		?>    
                    
                    
                
                           
                <form name='myform' action='report.php' method='POST'>
 		
                        <?php 
                                foreach ($nomeregrafiltro as $rule){     
                         ?>
                                <div class="checkbox" name="rules" id="rules">
                                    <label>                
                                     <input type="checkbox" name="rules[]" value="<?php  echo $rule;?>"><?php  echo $rule;?> 
                                    </label>
                                </div>
                          <?php 
                                }
                          ?>
     
              				  </div>   
                        </div>
                    </div>
                </div>
		
		
 		         <center>
               	<button class="btn btn-default" id="gerar" name="gerar" style="width:200px;height:auto"><i class="fa fa-fw fa-gear"></i>   Pr&eacute;-visualizar o relat&oacute;rio</button>	
               	
               	</center>
             
               </form>
 		 
 		
 		<?php 
 			} 
 		}
      }
 		
      }
      
	}else{
	?>
	<form name='myform' action='pdfgenerator.php' method='POST'> 
	<div class="row">
 	<?php 
	
 	$dataChart = array();
 	$quantChart = array();
 	$dataChartPositiv = array();
 	$quantChartPositiv= array();
 	$nomesRegrasComTermos = array();
 	$dataChartString = "";
 	$quantChartString = "";
 	$dataChartPositivString="";
 	$quantChartPositivString="";
 	$termos=array();
 	if(isset($_POST["rules"])){
 		?>
 			<div class="col-lg-1">
 			</div>
 			 <div style="position: fixed; left: 14%;width: auto; padding: auto;">
 			 	<a href="report.php" class="btn btn-default"><i class="fa fa-arrow-left"></i> Voltar atrás</a>	
 			 </div>
 			 <div style="position: fixed; right: 0px;width: auto; padding: auto;">
 	 		<button class="btn btn-default" id="gerarPDF" name="gerarPDF"><i class="fa fa-download"></i> Descarregar PDF </button> 
 	 		
 	 		</div>
 	 		<div class="col-lg-10">
 	 		
                        <div class="panel panel-default">
 		
                            <div class="panel-body">
                            <?php 
 	echo '<p style="font-size:18px;">Mês Escolhido: <small>'.getMonthByNumber($_SESSION['MesReport']).' - '.$_SESSION['AnoReport'].'</small></p><hr>';
 	
 	?>
 	 		<?php
 	 		$i=0;

 	 		$url="";
 	 		$arrayURL=array();

 	 			unset($_SESSION['NomesRegrasParaReport']);
 	 			foreach ($_POST["rules"] as $rulenames){
 	 				if(getPlataformByName($rulenames)=='PasteBin'){
 	 					echo '<br><center><p style="font-size:18px;"><img src="/SDLPlatform/icons/pastebin.png" height="100" width="150"></img></p>';
 	 				}
 	 				
 	 				if(getPlataformByName($rulenames)=='Shodan'){
 	 					echo '<br><center><p style="font-size:18px;"><img src="/SDLPlatform/icons/shodan.png" height="50" width="150"></img></p>';
 	 				}

 	 				//$arrayPasteBinURLS=getURLfromRuleName($rulenames,'Pastebin');

 	 				
 	 	
 	 				//$url=$url.str_replace('api_scrape_item.php?i=','',$valueURL).'<br>';
 	 				
 	
 				$var= getRulesByName($rulenames);
 				
 	 				foreach ($var as $wu){
 	 					
 	 					echo '<p style="font-size:18px;">Nome da Regra: '.$rulenames.'</p>';
 	 					echo 'Termo: '.$wu.'<br><br>';
 	 					
 	 					echo '<p style="font-size:18px;">Grafico Evolutivo:</p></center>';
 	 				
 	 					$_SESSION['NomesRegrasParaReport'][]=['NomeRegra'=>$rulenames,'Termo'=>$wu,'Plataform'=>getPlataformByName($rulenames)];
 	 			
 	 					
 	 			$val = getDashOnDB($_SESSION['email'],$wu,$_SESSION['MesReport']);
 	 			$top = array();
 	 			

 	 			
 	 			if (sizeof($val)>1){
 	 				foreach ($val as $value){
 	 					$top[] = ['Data'=>$value['Data'], 'Termos'=>$value['Termo'], 'Quantidade'=>$value['Quantidade']];	 
 	 				}
 	 			
 	
 	 				$temp_top = array_map("unserialize", array_unique(array_map("serialize", $top)));
 	 				$numvezesfound=0;
 	 			
 	 				foreach($temp_top as $key => $value){
 	 					foreach($top as $valuetop){
 	 						if($value['Data'] == $valuetop['Data'] && $value['Termos'] == $valuetop['Termos']){
 	 							$numvezesfound +=1;
 	 						}
 	 					}
 	 					$temp_top[$key]['Quantidade'] = $numvezesfound;
 	 					$numvezesfound = 0;
 	 				}
 	 			
 
 	 				$top = $temp_top;
 	 			
 	 			
 	 				usort($top, function($a, $b) {
 	 					return $a['Data'] -  $b['Data'];
 	 				});
 	 			
 	 			
 	 				end($top);
 	 			
 	 			
 	 				$lastElementKey = key($top);
 	 					//iterate the array
 	 			
 	 				foreach($top as $k => $v) {
 	 						if($k == $lastElementKey) {
 	 							$dataChartString = $dataChartString . '"'.$v['Data']. '"';
 	 							$quantChartString = $quantChartString .$v['Quantidade'];
 	 						}else{
 	 							$dataChartString =  $dataChartString  . '"'.$v['Data'].'", ';
 	 							$quantChartString = $quantChartString .$v['Quantidade'].", ";
 	 						}
 	 						
 	 					}
 	 					
 	 			?>
 	 			
 	 			
 	 			<?php 
 	 					
 	 					$dataChart[]=$dataChartString;		
 	 					$quantChart[]=$quantChartString;
 	 					$dataChartString="";
 	 					$quantChartString="";
 	 			}
 	 			
 	 			//***************
 	 			if(getPlataformByName($rulenames)=="PasteBin"){
 	 			
 	 			$valPositiv=getDLFoundByTerm($_SESSION['email'],$rulenames,$wu,'Pastebin',$_SESSION['MesReport'],$_SESSION['AnoReport'],"positiv");
 	 			
 	 			}else{
 	 				$valPositiv=getDLFoundByTerm($_SESSION['email'],$rulenames,$wu,getPlataformByName($rulenames),$_SESSION['MesReport'],$_SESSION['AnoReport'],"positiv");
 	 			}
 	 			
 	 			$topPositiv= array();
 	 			
 	 			
 	 			
 	 			if(sizeof($valPositiv)!=0){
 	 				foreach ($valPositiv as $value){
 	 			
 	 						
 	 					$parse_data=strtotime($value['DataFound']);
 	 			
 	 						
 	 					$topPositiv[] = ['Plataforma'=>$value['Plataforma'],'Data'=>date('d/m/Y', $parse_data), 'Termos'=>$value['Termo'], 'Quantidade'=>$value['Num']];
 	 					$data="";
 	 				}
 	 			
 	 			
 	 			
 	 			
 	 			
 	 			
 	 				$temp_topPostivi = array_map("unserialize", array_unique(array_map("serialize", $topPositiv)));
 	 				$numvezesfoundPositv=0;
 	 			
 	 				foreach($temp_topPostivi as $key => $value){
 	 					foreach($topPositiv as $valuetop){
 	 						if($value['Data'] == $valuetop['Data'] && $value['Plataforma'] == $valuetop['Plataforma'] && $value['Termos'] == $valuetop['Termos']){
 	 							$numvezesfoundPositv +=1;
 	 						}
 	 					}
 	 					$temp_topPostivi[$key]['Quantidade'] = $numvezesfoundPositv;
 	 					$numvezesfoundPositv = 0;
 	 				}
 	 			
 	 			
 	 				$topPositiv = $temp_topPostivi;
 	 			
 	 			
 	 				//iterate the array
 	 					
 	 				//iterate the array
 	 				foreach($top as $k => $v) {
 	 					if($k == $lastElementKey) {
 	 						$dataChartPositivString = $dataChartPositivString . '"'.$v['Data']. '"';
 	 			
 	 						$datafound=false;
 	 						foreach($topPositiv as $valu) {
 	 							if($valu['Data'] == $v['Data']){
 	 								$datafound=true;
 	 								$quantChartPositivString = $quantChartPositivString .$valu['Quantidade'];
 	 							}
 	 						}
 	 						if($datafound==false){
 	 							$quantChartPositivString = $quantChartPositivString .'0';
 	 						}
 	 							
 	 			
 	 					}else{
 	 						$dataChartPositivString =  $dataChartPositivString  . '"'.$v['Data'].'", ';
 	 			
 	 						$datafound=false;
 	 						foreach($topPositiv as $valu) {
 	 							if($valu['Data'] == $v['Data']){
 	 								$datafound=true;
 	 								$quantChartPositivString = $quantChartPositivString .$valu['Quantidade'].", ";
 	 							}
 	 						}
 	 			
 	 						if($datafound==false){
 	 							$quantChartPositivString = $quantChartPositivString .'0'.", ";
 	 						}
 	 							
 	 			
 	 					}
 	 				}
 	 					
 	 				$dataChartPositiv[]=$dataChartPositivString;
 	 				$quantChartPositiv[]=$quantChartPositivString;
 	 				$dataChartPositivString="";
 	 				$quantChartPositivString="";
 	 				
 	 			
 	 			}
 	 			
 	
 	 				?>
 	 				<br>
 	 				<center>
 							<div id="graph<?php echo $i;?>" style="width:50%;display:none"> <!-- ;visibility:hidden" -->	
		 		</div>
		 	 				<canvas id="canvas<?php echo $i;?>" width="1000px" height="600px"></canvas>
 	 				
 	 				<div style="visibility:hidden">
 						 <input name="imagem[]" id="img<?php echo $i;?>" value="" size="50">
 					</div>
 					</center>
 					Conteudo Encontrado:
 	 				 <hr>
 	 				<?php 	
 	 				
 	 				$pattern = preg_quote($wu, '/');
 	 				$pattern = "/^.*$wu.*\$/m";
 	 				$conteudo_encontrado="";
 	 					if(getPlataformByName($rulenames)=='PasteBin'){
 	 						foreach($valPositiv as $valueURL){
 	 							
 	 							// search, and store all matching occurences in $matches
 	 							preg_match_all($pattern, $valueURL['TextoEncontrado'], $matches);
 	 							
 	 							foreach ($matches[0] as $value){
 	 								$conteudo_encontrado=$conteudo_encontrado.$value.'';
 	 							}
 	 							
 	 							$conteudo_encontrado=$conteudo_encontrado.'<br>';
 	 							
 	 							$url=$url.str_replace('api_scrape_item.php?i=','',$valueURL['URL']).':<br>'.$conteudo_encontrado.'<br>';
 	 							$conteudo_encontrado="";
 	 						}	
 	 					echo '<pre><small>'.$url.'</small></pre>';
 	 					}
 	 					
 	 					
 	 					if(getPlataformByName($rulenames)=='Shodan'){
 	 					$term=getDLFoundByName($rulenames);
 	 					foreach ($term as $valueterm){

 	 					?>
 	 					
 	 				<div class="row">	
                    <div class="col-lg-6">
					      
                    	 <?php 
                    	
					
                    	echo '<h3><i class="fa fa-globe"></i> '.$valueterm['Dados']['IP'].'  <small>'.$valueterm['Dados']['Hostname'].'</small></h3>';
                    	?>
                    	<hr>
	                    	 <div class="table-responsive">
	                            <table class="table table-hover table-striped">
	                                <tbody>
	                                    <tr>
	                                        <td>Pais</td>
	                                        <td><?php echo $valueterm['Dados']['Pais'];?></td> 
	                                    </tr>
	                                     <tr>
	                                        <td>Organiza&ccedil;&atilde;o</td>
	                                        <td><?php echo $valueterm['Dados']['Organization'];?></td> 
	                                    </tr>
	                                     <tr>
	                                        <td>Hostname</td>
	                                        <td><?php echo $valueterm['Dados']['Hostname'];?></td> 
	                                    </tr>
	                                     <tr>
	                                        <td>ASN</td>
	                                        <td><?php echo $valueterm['Dados']['ASN'];?></td> 
	                                    </tr>
	                     			 </tbody>
	                            </table>
	                         </div> 
	                         
	                         
	                       
	                       <?php if(!empty($valueterm['Dados']['Certificado'])){
	                       	setlocale(LC_ALL, 'pt_PT', 'pt_PT.utf-8', 'pt_PT.utf-8', 'portuguese');
	                       	date_default_timezone_set('Europe/Lisbon');
	                       	?>
						
							
						<h3><i class="fa fa-lock"></i> Certificado SSL:</h3>
							<hr>
							
									<div class="table-responsive">
		                            <table class="table table-hover table-striped">
		                                <tbody>
		                                    <tr>
		                                        <td>Emissor</td>
		                                        <td><?php echo $valueterm['Dados']['Certificado']['Emissor'];?> (<?php echo $valueterm['Dados']['Certificado']['EmissorCN'];?>)</td>
		
		                                    </tr>
		                                    <tr>
		                                        <td>Receptor</td>
		                                        <td><?php echo $valueterm['Dados']['Certificado']['Receptor'];?> (<?php echo $valueterm['Dados']['Certificado']['ReceptorCN'];?>)</td>
		           
		                                    </tr>
		                                    <tr>
		                                        <td>Emitido</td>
		                                        
		                                        <td><?php  echo date("d/M/Y - H:i:s", strtotime($valueterm['Dados']['Certificado']['EmitidoEm']));?></td>           
		                                    </tr>
		                                    <tr>
		                                        <td>Caduca</td>
		                                      
		                                        <td><?php  echo date("d/M/Y - H:i:s", strtotime($valueterm['Dados']['Certificado']['ExpiraEm']));?></td>           
		                                    </tr>  
		                                </tbody>
		                            </table>
		                        </div>
		                        SSL:
		                        <div class="table-responsive">
		                            <table class="table table-hover table-striped">
		                                <tbody>
		                                    <tr>
		                                   		 <td>Nome Cifra</td>
		                                        <td><?php echo $valueterm['Dados']['Certificado']['NomeCifra'];?></td>
		                                       
		
		                                    </tr>
		                                    <tr>
		                                         <td>Vers&otilde;es SSL</td>
		                                        <td><?php foreach ($valueterm['Dados']['Certificado']['versoesSSL'] as $SSL){ echo $SSL.' ';}?></td>
		           
		                                    </tr>
		                                    <tr>
		                                        <td>Bits da Cifra:</td>
		                                        <td><?php echo $valueterm['Dados']['Certificado']['bitsCifra'];?></td>           
		                                    </tr>

		                                </tbody>
		                            </table>
		                        </div>
							
			
							<?php if(!empty($valueterm['Dados']['Certificado']['ChavePublica'])){?>
							Chave Publica: <pre><?php echo $valueterm['Dados']['Certificado']['ChavePublica'];?></pre><br>
							<?php }
							if(!empty($valueterm['Dados']['Certificado']['ParametrosDiffie-Hellman'])){
							?>
							Par&acirc;metros Diffie-Hellman: <?php echo $valueterm['Dados']['Certificado']['ParametrosDiffie-Hellman'];?><br>
							<?php }?>
							Chain:<br>
							<pre><?php foreach ($valueterm['Dados']['Certificado']['certificate'] as $SSL){ echo $SSL.'<br>';}?></pre>
							
                    	
                       
                        <?php }?>
	                       
	                       
                         </div>
 
                         
                        <div class="col-lg-6">
                        <h3><i class="fa fa-th-large"></i> Porta:</h3>
                        <hr>
                        <ul class="ports">
							<li><a><?php echo $valueterm['Dados']['Porta'];?></a></li>				
						</ul>
                      
						<div style="clear:both"></div>
						 <h3><i class="fa fa-th-list"></i> Servi&ccedil;os:</h3>
						<hr>
							<div class="col-lg-2">
							
							<div class="detalhes">
								<div class="porta"><?php  
                    	echo $valueterm['Dados']['Porta'];?></div>
								<div class="protocolo"><?php echo $valueterm['Dados']['Transport'];?></div>
								<a href="http://<?php echo $valueterm['Dados']['IP'].':'.$valueterm['Dados']['Porta']; ?>" target="_blank" class="link"><i class="fa fa-mail-forward">&nbsp;
                                    </i></a>
								</div>
		
							</div>
						<div class="col-lg-8">
						<pre><?php echo $valueterm['Dados']['Data']?></pre>
						</div>
                       </div>
 	 					</div>
 	 					
 	 					
 	 					
 	 					<?php 
 	 					
 	 					}
 	 					echo '<br>';
 	 					}
 	 					echo '<hr>';
 	 					
 	 					?>
 	 				<?php 
 	 			$termos[]=$wu;
 				$i++;
 				$url="";
 	 				}
 	
 	 			}
 	 			
 	 		
 	 	
 	 			
 	 			
 	 			
 	 		?>
 	 		  </div>   
                        </div>
                    </div>
                    	<div class="col-lg-1">
 			</div>
                </div>
		
 		     
          
 	 		<br>
 	 		
 
 		<script>
 		var tmonth=new Array("Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");

 		function GetClock(){
 		var d=new Date();
 		var nmonth=d.getMonth(),ndate=d.getDate(),nyear=d.getYear();
 		if(nyear<1000) nyear+=1900;

 		var d=new Date();
 		var nhour=d.getHours(),nmin=d.getMinutes(),nsec=d.getSeconds();
 		if(nmin<=9) nmin="0"+nmin
 		if(nsec<=9) nsec="0"+nsec;

 		document.getElementById('clockbox').innerHTML=""+ndate+", "+tmonth[nmonth]+" "+nyear+" <b>"+nhour+":"+nmin+":"+nsec+"</b>";
 		}

 		<?php for($i=0;$i<sizeof($dataChart);$i++){?>
		$(function () {	
			$('#graph<?php echo $i; ?>').highcharts({
				    chart: {
				        type: 'area',
				    },
				    title: {
				        text: ''
				    },
				    xAxis: {
				    	 categories: [<?php echo $dataChart[$i];?>,<?php if(!empty($dataChartPositiv)){echo ($dataChartPositiv[$i]);}?>]
				    },
				    yAxis: {
				        title: {
				            text: 'Numero de vezes Encontrado'
				        }
				    },
				    plotOptions: {
				    	series: {
				            animation: false
				        }
			        
				    },
				   series: [{
			            name: '<?php echo $termos[$i];?> - Total',
			            data: [<?php echo $quantChart[$i];?>]
			        }<?php if(!empty($quantChartPositiv)){?>,
			        { name: '<?php echo $termos[$i];?> - Positivos',
			        	color: '#006600',
			    		data: [<?php echo $quantChartPositiv[$i]?>]}<?php }?>
			        ]
				    
			 });
		});
			
		<?php }
		
			?>

 			 	 			
 
 			
 			window.onload = function(){
 	 			
 				<?php for($i=0;$i<sizeof($dataChart);$i++){?>
 			 			    

 				var svg = document.getElementById('graph<?php  echo $i; ?>').children[0].innerHTML;
 				var base_image = new Image();
 				svg = "data:image/svg+xml,"+svg;

			
				canvg(document.getElementById('canvas<?php echo $i;?>'), svg);

				var url=document.getElementById('canvas<?php echo $i;?>').toDataURL();				
				document.getElementById('img<?php echo $i;?>').value=url;
				
				<?php }
					?>
 	 			GetClock();
 	 			setInterval(GetClock,1000);
 		}
 		</script>
 	
 	 	</form>
 	 		
 	 	<br>
 	       <?php 

		
	?>

	<?php 
 	}
	}
       ?>
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="/SDLPlatform/js/jquery.js"></script>
	<script src="/SDLPlatform/highcharts/js/highcharts.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="/SDLPlatform/js/bootstrap.min.js"></script>
    
</body>

</html>