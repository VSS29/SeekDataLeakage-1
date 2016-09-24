<?php
include ("functions/functions.php");
include ("handler/handleViewTerm.php");
if(!loggedIn()):
header('Location: /SDLPlatform/login.php');
endif;

if(session_status()==PHP_SESSION_NONE){
	session_start();
}




if(isset($_POST['falsePositiv'])){
	if($_POST['optionsRadiosInline']=="Sim"){
		setFalsePositivYes($_SESSION['verifyTermSession']);
	}
	if($_POST['optionsRadiosInline']=="Nao"){
		setFalsePositivNo($_SESSION['verifyTermSession']);
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

        <div id="page-wrapper" style="height:auto">
					<!-- navegacao -->
                     <!-- navegacao -->
                     <?php 

		
		if(isset($_POST['verifyTerm']) || !empty($_SESSION['verifyTermSession'])){
		
		$term = array();
			if(!empty($_POST['verifyTerm'])){
				$_SESSION['verifyTermSession'] = $_POST['verifyTerm'];
				viewTerm($_POST['verifyTerm']);
				$term = getDLFound( $_POST['verifyTerm']);
			}else{
				viewTerm($_SESSION['verifyTermSession']);
				$term = getDLFound($_SESSION['verifyTermSession']);
				
			}
	

	
		?>
                    
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">      
                    <h2 class="page-header"><?php echo $term['NomeRegra'];?></h2>                 
                    </div>
                </div>
                <!-- /.row -->
				
		<div class="row">
				<div class="col-lg-10">
			<form action="<?=$_SERVER["PHP_SELF"];?>" method="POST">
                                <label>Falso positivo ?</label>
                                <label class="radio-inline">
                                <?php if( $term['falsePositiv']==1){?>
                                    <input type="radio" name="optionsRadiosInline" id="optionsRadiosInline1" onclick="document.getElementById('labelYES').style.color = 'green';" value="Sim" checked="">
                                     <label style="color:green"  id="labelYES" for="optionsRadiosInline1">Sim</label>
                                    <?php }else{?>
                                        <input type="radio" name="optionsRadiosInline" id="optionsRadiosInline1" onclick="document.getElementById('labelYES').style.color = 'green';" value="Sim">
                                         <label style="color:grey" id="labelYES" for="optionsRadiosInline1">Sim</label>
                                    <?php }?>
                                </label>
                                <label class="radio-inline">
                                 <?php if( $term['falsePositiv']==0){?>
                                    <input type="radio" name="optionsRadiosInline" id="optionsRadiosInline1" value="Nao" onclick="document.getElementById('labelNO').style.color = 'red';" checked="">
                                      <label  style="color:red" id="labelNO" for="optionsRadiosInline1">N&atilde;o</label>
                                    <?php }else{?>
                                        <input type="radio" name="optionsRadiosInline" id="optionsRadiosInline1"  onclick="document.getElementById('labelNO').style.color = 'red';" value="Nao">
                                          <label style="color:grey" id="labelNO" for="optionsRadiosInline1">N&atilde;o</label>
                                    <?php }?>
                                </label>
                  <button class="btn btn-primary" name="falsePositiv" ><i class="fa fa-check"></i> Confirmar</button>	
                 </form>
                 </div>
                 <div class="col-lg-1" style="text-align:left">
                    <a class="btn btn-primary" href="checkDLFound.php"><i class="fa fa-arrow-left"></i> Voltar para tr&aacute;s</a>
                 </div>
			
				</div>
					<br>
				<div class="row">
				
                    <div class="col-lg-6">
                   
                       <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-list-alt"></i>    Termo:</h3>
                            </div>
                            <div class="panel-body">
                              <?php echo $term['Termo'];?>
     
                            </div>
                        </div>
                     </div>
                      <?php if($term['Plataforma']=='Pastebin'){?>
                      <div class="col-lg-6">
                      <div class="panel panel-default">
                            <div class="panel-heading">
                           
                                <h3 class="panel-title"><i class="fa fa-link"></i>    Endere&ccedil;o onde foi encontrado:</h3>
             
                            </div>
                            <div class="panel-body">
                             <a href="<?php echo str_replace('api_scrape_item.php?i=','',$term['URL']);?>"  target="_blank"><?php echo str_replace('api_scrape_item.php?i=','',$term['URL']);?></a>
                            </div>
                        </div>
                     </div>
                </div>
                <?php }?>
                <?php if($term['Plataforma']=='Shodan'){?>
                      <div class="col-lg-6">
             
<!--                       <div class="panel panel-default"> -->
<!--                             <div class="panel-heading"> -->
                           
<!--                                 <h3 class="panel-title"><i class="fa fa-link"></i>   Localização:</h3> -->
             
<!--                             </div> -->
<!--                             <div class="panel-body"> -->
                      
                           <div id="map" style="height:200px;"></div>
                       
                            <script>
							
							var map;
							function initMap() {
								  var myLatLng = {lat: <?php echo $term['Dados']['Latitude'];?>, lng:<?php echo $term['Dados']['Longitude'];?>};
							
								  var map = new google.maps.Map(document.getElementById('map'), {
								    zoom: 15,
								    center: myLatLng,
								    zoomControl: true,
								    disableDefaultUI: true,
								    zoomControlOptions: {
								        position: google.maps.ControlPosition.LEFT_CENTER
								    },
								    scaleControl: true,
								    streetViewControl: true,
								    streetViewControlOptions: {
								        position: google.maps.ControlPosition.LEFT_TOP
								    }
								  });
							
								  var marker = new google.maps.Marker({
								    position: myLatLng,
								    map: map
								  });
								}
							
							    </script>
							    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBA2AL0nHjdM7UIGWYBTEyq1xW7AG3OXdA&callback=initMap"
							    ></script>
                    
<!--                             </div> -->
<!--                         </div> -->
                     </div>
                </div>
                <br>
                <?php }?>
                <div class="row">
                      <div class="col-lg-12">
                   
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-file-word-o"></i>   Conte&uacute;do Encontrado:</h3>
                            </div>
                            <div class="panel-body">
                              <?php if($term['Plataforma']=='Pastebin'){?>
                              
                              <?php 
                              $wu=$term['Termo'];
                              $pattern = preg_quote($wu, '/');
                              $pattern = "/^.*$wu.*\$/m";
                              $conteudo_encontrado="";
                              
                              preg_match_all($pattern, $term['TextoEncontrado'], $matches);
                              
                              foreach ($matches[0] as $value){
                              	$conteudo_encontrado=$conteudo_encontrado.$value.'';
                              }
                              
                 
                              
                              ?>
                    	<pre style="width:100%;height:600px"><code><?php echo htmlentities( $conteudo_encontrado);?></code></pre>
                    	<?php }?>
                    	 <?php if($term['Plataforma']=='Shodan'){
                    	 ?>
                    	   
                    	<div class="col-lg-6">
					      
                    	 <?php 
                    	
					
                    	echo '<h3><i class="fa fa-globe"></i> '.$term['Dados']['IP'].'  <small>'.$term['Dados']['Hostname'].'</small></h3>';
                    	?>
                    	<hr>
	                    	 <div class="table-responsive">
	                            <table class="table table-hover table-striped">
	                                <tbody>
	                                    <tr>
	                                        <td>Pais</td>
	                                        <td><?php echo $term['Dados']['Pais'];?></td> 
	                                    </tr>
	                                     <tr>
	                                        <td>Organiza&ccedil;&atilde;o</td>
	                                        <td><?php echo $term['Dados']['Organization'];?></td> 
	                                    </tr>
	                                     <tr>
	                                        <td>Hostname</td>
	                                        <td><?php echo $term['Dados']['Hostname'];?></td> 
	                                    </tr>
	                                     <tr>
	                                        <td>ASN</td>
	                                        <td><?php echo $term['Dados']['ASN'];?></td> 
	                                    </tr>
	                     			 </tbody>
	                            </table>
	                         </div> 
	                         
	                         
	                       
	                       <?php if(!empty($term['Dados']['Certificado'])){
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
		                                        <td><?php echo $term['Dados']['Certificado']['Emissor'];?> (<?php echo $term['Dados']['Certificado']['EmissorCN'];?>)</td>
		
		                                    </tr>
		                                    <tr>
		                                        <td>Receptor</td>
		                                        <td><?php echo $term['Dados']['Certificado']['Receptor'];?> (<?php echo $term['Dados']['Certificado']['ReceptorCN'];?>)</td>
		           
		                                    </tr>
		                                    <tr>
		                                        <td>Emitido</td>
		                                        
		                                        <td><?php  echo date("d/M/Y - H:i:s", strtotime($term['Dados']['Certificado']['EmitidoEm']));?></td>           
		                                    </tr>
		                                    <tr>
		                                        <td>Caduca</td>
		                                      
		                                        <td><?php  echo date("d/M/Y - H:i:s", strtotime($term['Dados']['Certificado']['ExpiraEm']));?></td>           
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
		                                        <td><?php echo $term['Dados']['Certificado']['NomeCifra'];?></td>
		                                       
		
		                                    </tr>
		                                    <tr>
		                                         <td>Vers&otilde;es SSL</td>
		                                        <td><?php foreach ($term['Dados']['Certificado']['versoesSSL'] as $SSL){ echo $SSL.' ';}?></td>
		           
		                                    </tr>
		                                    <tr>
		                                        <td>Bits da Cifra:</td>
		                                        <td><?php echo $term['Dados']['Certificado']['bitsCifra'];?></td>           
		                                    </tr>

		                                </tbody>
		                            </table>
		                        </div>
							
			
							<?php if(!empty($term['Dados']['Certificado']['ChavePublica'])){?>
							Chave Publica: <pre><?php echo $term['Dados']['Certificado']['ChavePublica'];?></pre><br>
							<?php }
							if(!empty($term['Dados']['Certificado']['ParametrosDiffie-Hellman'])){
							?>
							Par&acirc;metros Diffie-Hellman: <?php echo $term['Dados']['Certificado']['ParametrosDiffie-Hellman'];?><br>
							<?php }?>
							Chain:<br>
							<pre><?php foreach ($term['Dados']['Certificado']['certificate'] as $SSL){ echo $SSL.'<br>';}?></pre>
							
                    	
                       
                        <?php }?>
	                       
	                       
                         </div>
                         
                         
                         
                         
                         
                         
                        <div class="col-lg-6">
                        <h3><i class="fa fa-th-large"></i> Porta:</h3>
                        <hr>
                        <ul class="ports">
							<li><a><?php echo $term['Dados']['Porta'];?></a></li>				
						</ul>
                      
						<div style="clear:both"></div>
						 <h3><i class="fa fa-th-list"></i> Servi&ccedil;os:</h3>
						<hr>
							<div class="col-lg-2">
							
							<div class="detalhes">
								<div class="porta"><?php  
                    	echo $term['Dados']['Porta'];?></div>
								<div class="protocolo"><?php echo $term['Dados']['Transport'];?></div>
								<a href="http://<?php echo $term['Dados']['IP'].':'.$term['Dados']['Porta']; ?>" target="_blank" class="link"><i class="fa fa-mail-forward">&nbsp;
                                    </i></a>
								</div>
		
							</div>
						<div class="col-lg-8">
						<pre><?php echo $term['Dados']['Data']?></pre>
						</div>
			
                    	<?php 
                    		
                    	 }?>
                    	
                            </div>
                        </div>
                     
             
                    	
                    </div>
                  
                </div>


          <?php 
          
          
		}?>   
		
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
