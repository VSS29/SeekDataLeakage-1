<?php 

set_include_path('../SDLPlatform/');

session_start();
include '../handler/handleDB.php';
include '../handler/handleUserFunctions.php';
include '../handler/handleRules.php';

if(!loggedIn()):
header('Location: /SDLPlatform/login.php');
endif;

set_time_limit(90);


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


$crf_check=false;


if(isset($_POST["token"])){
	if(checkToken($_POST["token"])==true){
		$crf_check=true;
	}
}




$erroRuleName="";
if(isset($_POST["name"])){
	if(!checkUniqueRuleName($_POST["name"])){
	$_SESSION['Rule_name'] = stripslashes(strip_tags($_POST["name"]));
	}else{
		$erroRuleName="O nome da regra tem que ser unico!";
	}
	
	
	if($_SESSION['Rule_name']==""){
		if($erroRuleName==""){
			$erroRuleName="O nome da regra n&atilde;o pode conter elementos HTML!";
		}else{
			$erroRuleName=$erroRuleName."<br>O nome da regra n&atilde;o pode conter elementos HTML!";
		}
		
	}
}



if (isset($_POST['removeTop'])) {


	$temp=$_SESSION['Pesquisa'];
	

	if (($key = array_search(htmlentities($_POST['removeTop']), $temp)) !== false) {
		unset($temp[$key]);
		$_SESSION['Pesquisa']=$temp;
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
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
   
   <script src="/SDLPlatform/js/clock.js"></script>
    
  	

   <script type="text/javascript">

  

   
   
    		function getButton(checking){
        	    if( checking.checked == true){

        		   	if(checking.value=="Pastebin"){
        			document.getElementById("pastebinGrupo").disabled=false;
        		    document.getElementById("pastebin").src = "/SDLPlatform/icons/pastebinselected.png";
        		 	document.getElementById("shodan").src = "/SDLPlatform/icons/shodan.png";
        		 	document.getElementById("shodanGrupoNetWork").checked=false;
        		 	document.getElementById("shodanGrupoDominio").checked=false;
        		 	document.getElementById("shodanGrupoNetWork").disabled=true;
        		 	document.getElementById("shodanGrupoDominio").disabled=true;
        			
        		   	}

        		 

        		 	if(checking.value=="Shodan"){
        		 		document.getElementById("shodanGrupoNetWork").disabled=false;
        		 		document.getElementById("shodanGrupoDominio").disabled=false;
        			   	document.getElementById("shodan").src = "/SDLPlatform/icons/shodan_selected.png";
        			   	document.getElementById("pastebin").src = "/SDLPlatform/icons/pastebin.png";
        				document.getElementById("pastebinGrupo").checked=false;
        				document.getElementById("pastebinGrupo").disabled=true;
        			 	}



        	   }
        	}
    	
    


   </script>
   
   
   
   <style>
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
                                <a href="/SDLPlatform/ruleCreator/makeRules.php">Criar Regra</a>
                            </li>
                            <li>
                                <a href="/SDLPlatform/ruleCreator/Rules.php">Consultar Regras</a>
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

            <div class="container-fluid">
	
	<div class="form-group">
		 <h3>Cria&ccedil;&atilde;o de Regras</h3><hr></hr>
		
		
                           <form action="<?=$_SERVER["PHP_SELF"];?>" method="POST"> 
		<div class="row">
		  <?php if(isset($_SESSION['ErroDePlataformEGrupo'])){
       ?>
       <div class="alert alert-danger">
                    <strong>Aten&ccedil;&atilde;o</strong> tem de escolher uma plataforma e um tipo de dados associado &atilde; plataforma!
      </div>
       <?php 
       }?>
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body ">
                             Nome da Regra: <input class="form-control" id="" pattern=".{3,}" title="O nome da regra tem de ter um minimo de 3 caracteres" name="name" value="<?php if(isset($_SESSION['Rule_name'])){echo htmlentities($_SESSION['Rule_name']);} ?>">   
                             	<?php   
                        if($erroRuleName!=""){
					echo" <br><div class='alert alert-danger fade in'>
					<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
					<strong>Erro! </strong> $erroRuleName
					</div>";
					}
				  	?>
                             	 
                            </div>
                        </div>
                    </div>
        </div>
		
		
		<div class="row">
                     <div class="col-lg-6 text-center">
                        <div class="panel panel-default">
                            <div class="panel-body">
                              Termos a Procurar:
      
               <div class="box">
		
					 <div class="form-group input-group">
                            <span class="input-group-addon"><i class="fa fa-terminal"></i></span>
                              <input type="search" id="search" name="getSearch" pattern=".{5,}" title="O termo a procurar tem de ter um minimo de 5 caracteres" class="form-control" placeholder="Introduza termos de pesquisa para procurar.">
                   	</div>
                    <div class="form-group input-group">
                    		<input type="hidden" name="token" value="<?php echo generateToken();?>"> 
						<button class="btn btn-default"><i class="fa fa-plus"></i> Adicionar Termos</button>
					</div>
			
			
						</form> 
				
			  	<form action="<?=$_SERVER["PHP_SELF"];?>" method="POST">
										<?php 
										if(!empty($_SESSION["Pesquisa"])){
										echo "<h1 class='panel-title'>Termos Adicionados: </h1>";
										echo"<table>";
										foreach ($_SESSION["Pesquisa"] as $value) {
										echo"<tr>";
										echo "<td>"."<button  name='removeTop' value='$value' class='btn btn-default btn-xs' ><i class='fa fa-times'></i></button> " . "<br></td>";
										echo "<td>". "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . "" . $value . "</td>";
										echo "</tr>";
										}
										echo"</table>";
										}
										
										?>
     			 </form>
				
				

			</div>
                              
                       
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 text-center">
                        <div class="panel panel-default">
                            <div class="panel-body">
                            
      		<form action="Rules.php" method="POST">
                               	  Plataforma:<br><br>
<!--                                   	<input type="checkbox" name="Plataform[]" value="PB">PasteBin<br> -->
<!-- 									<input type="checkbox" name="Plataform[]" value="GitHub">GitHub Gist<br> -->
<!-- 									<input type="checkbox" name="Plataform[]" value="Google">Google Advanced Search<br> -->
<!-- 									<input type="checkbox" name="Plataform[]" value="Shodan">Shodan<br> -->
                               	    <label class="checkbox-inline">
                                       	<input type="radio" style="opacity:0;" name="Plataform" id="PasteBinCheck" onclick="getButton(this)" value="Pastebin">
                                       	<img src="/SDLPlatform/icons/pastebin.png" id="pastebin" alt="PasteBin" height="100" width="125"></image>
                            
                              	<!-- aqui era onde estava as checkboxes. -->
                                  
                                  
                                    </label>
        
                
               
                                   
      
              
                                    <label class="checkbox-inline">
                                       		<input type="radio" style="opacity:0;" name="Plataform" onclick="getButton(this)" value="Shodan">
                                       		 <img src="/SDLPlatform/icons/shodan.png" id="shodan" alt="Shodan" height="50" width="150"></image>
                                    </label>
              
			
              		<br>
              		<br><br><br>
                       
                            </div>
                        </div>
                    </div>
                    
       </div>
		
       <div class="row">
                    <div class="col-lg-6 text-center">
                        <div class="panel panel-default">
                            <div class="panel-body">
                              <div class="col-lg-11 text-center">
                              
                                 Relev&acirc;ncia:
                                 <div class="form-group">
                                <label class="radio-inline">
                                    <input type="radio" name="Relev" id="Relev" value=0 style="background: #00CC99; color: #000;" checked=""><medium style="color: #00CC99;"><b> Baixa</b></medium>
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="Relev" id="Relev" value=1 style="background: #FFFF99; color: #000;"><medium style="color: #CDCD00;"><b> M&eacute;dia</b></medium>
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="Relev" id="Relev" value=2 style="background: #FF3B3B; color: #000;"><medium style="color: #FF3B3B;"><b> Alta</b></medium>
                                </label>
                          		  </div>
						     		<!-- <select name="Relev" id="Relev" class="form-control" size=1 style="background: #00CC99; color: #000;" onChange="this.style.backgroundColor=this.options[this.selectedIndex].style.backgroundColor">   
									<option name="Relev" value=1 style="background: #FFFF99; color: #000;">Media</option>
									<option name="Relev" value=2 style="background: #FF3B3B; color: #000;">Alta</option>
									<!--</select> -->
												
						
								</div>
                   		  <div class="col-lg-1 text-left">
							&nbsp;
							<center>
		                    <i class="fa fa-2x fa-info-circle" onclick="abrirHelp()"></i>
		                    </center>
		                  </div>          	
		                           
              				
                            </div>
                            
                              <center>         
                              <div id="help" style="display: none; width:80%; text-align:center">
							<table class="table table-bordered table-hover table-striped" style="font-size:small;text-align:center">
							  <tr>
							    <th><center>Relev&acirc;ncia </center></th>
							    <th><center>Periodicidade que a regra corre</center></th>
							    <th><center>Tipo de Notifica&ccedil;&atilde;o</center></th>
							  </tr>
							  <tr>
							    <td>Baixa</td>
							    <td>De 15 em 15 Minutos.</td>
							    <td>Plataforma</td>
							  </tr>
							  <tr>
							    <td >M&eacute;dia</td>
							    <td >De 10 a 10 Minutos.</td>
							    <td>Plataforma</td>
							  </tr>
							  <tr>
							    <td>Alta</td>
							    <td>De 5 em 5 Minutos.</td>
							    <td>Plataforma</td>
							  </tr>
							</table>
                         
                         
                         
                           	<br>
								</div>
                           	</center>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-body">
<!--                                Grupo: -->
<!-- 							 <select  name="Grupo" class="form-control" id="Grupo"> -->
<!-- 							 <option>Escolha um grupo</option> -->
<!-- 						    <optgroup name="PB" label="PasteBin" id="PB"> -->
<!-- 						      <option  name="Grupo" value="fuga">Fuga de Dados</option> -->
<!-- 						      <option  name="Grupo" value="notset">...</option> -->
<!-- 						      <option  name="Grupo" value="notset">...</option> -->
<!-- 						    </optgroup> -->
<!-- 						    <optgroup name="Shodan" label="Shodan" id="Shodan"> -->
<!-- 						      <option  name="Grupo" value="domain">Domain</option> -->
<!-- 						      <option  name="Grupo" value="notset">...</option> -->
<!-- 						      <option  name="Grupo" value="notset">....</option> -->
<!-- 						    </optgroup> -->
<!--   							</select> -->
                                <div class="row">
                                  <div class="col-lg-3">
			                                <label>PasteBin</label>
			                                <div class="checkbox">
			                                    <label>
			                                        <input type="checkbox" name="Grupo" id="pastebinGrupo" value="fuga">Fuga de Dados
			                                    </label>
			                                </div>
			                      	</div>
			            
			                        <div class="col-lg-3">
			                        
			                                <label>Shodan</label>
			                                <div class="checkbox">
			                                    <label>
			                                        <input type="checkbox" name="Grupo" id="shodanGrupoDominio" class="shodanGrupo" value="domain">Dominio
			                                    </label>
			                                </div>
			                                <div class="checkbox">
			                                    <label>
			                                        <input  type="checkbox" name="Grupo" id="shodanGrupoNetWork" class="shodanGrupo" value="net">Rede
			                                    </label>
			                                </div>
			                            </div>
							  		 
								</div>			
                            </div>
                        </div>
                    </div>
                    
                     <div class="row">
                      <div class="col-lg-12">
                        <div class="panel panel-default">
                                          <div class="checkbox" align="center">
			                                    <label>
			                                        <input type="checkbox"  name="emailSend" id="emailSend" value="send"> Enviar emails a notificar quando encontrar fugas de informa&ccedil;&atilde;o
			                                    </label>
			                                </div>
			              			
                        </div> 
                                 				  		 
						</div>	
						</div>	
						
        </div>                      
    
       
     
   
              
         
         
         
         
         
         
          
       </div>
      
      
       <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="panel panel-default">
                            <div class="panel-body">
                            	<center>
                            	
									 <div class="form-group input-group">
									 <?php 
									
									 if(!empty($_SESSION["Pesquisa"]) && !empty($_SESSION['Rule_name']) &&  $crf_check==true){?>
									<button class="btn btn-primary" name="insertDB" style="width:300px;height:50px"><i class="fa fa-plus"></i>  Inserir</button>		
										<?php }else{?>
											<fieldset disabled>
										<button class="btn btn-primary"  style="width:300px;height:50px"><i class="fa fa-plus"></i>  Inserir</button>	
											</fieldset>		
										<?php }
									 ?>
									</div>
								</center>
								</div>
                        </div>
                    </div>
				</form>
				
       
        </div>
 
  
       
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
 
       
    
    <script src="../js/jquery.js"></script>
    
    	<script type="text/javascript">

 	$('input.shodanGrupo').on('change', function() {
        $('input.shodanGrupo').not(this).prop('checked', false);  
    });

	
 	
        function abrirHelp () {
            var mydiv = document.getElementById('help');
            if (mydiv.style.display === 'block' || mydiv.style.display === '') {
                mydiv.style.display = 'none';
            } else {
                mydiv.style.display = 'block';
            }
        }
    </script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>
    
</body>

</html>