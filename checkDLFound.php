<?php
include("/functions/functions.php");
include("handler/handleDLFound.php");

if(!loggedIn()):
header('Location: /SDLPlatform/login.php');
endif;

if(session_status()==PHP_SESSION_NONE){
	session_start();
}

set_time_limit(90);


// if(isset($_POST["deleteRule"])){
// 	$res = connectDB_DLFound()->remove(array('_id' => new MongoId($_POST["deleteRule"])));
// 	if ($res['n'] == 1){
// 		return true;
// 	}
// 	return false;
// }

if(!isset($_POST['filtro'])){
	$_POST['Mes']=date("m");
	$_POST['Ano']=date("Y");
}

if(isset($_POST['All'])){
	$_POST['Mes']=date("m");
	$_POST['Ano']=date("Y");
	
}

$collum = connectDB_DLFound();
$cursorAll = $collum->find(array('email' => $_SESSION["email"]));

$crf_check=false;


if(isset($_POST["token"])){
	if(checkToken($_POST["token"])==true){
		$crf_check=true;
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
    <link href="/SDLPlatform/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
   <script src="/SDLPlatform/js/clock.js"></script>


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
                <a class="navbar-brand" href="index.php">SDL Plataform</a>
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

        <div id="page-wrapper">

            <div class="container-fluid">
		
		
   <?php 

		
		$nomeregrafiltro=array();
		$platform=Array();
		foreach ($cursorAll as $nomeregra){
				$nomeregrafiltro[] = $nomeregra['NomeRegra'];
				$platform[] = $nomeregra['Plataforma'];
		}
		
		$nomeregrafiltro = array_unique($nomeregrafiltro);
		$platform = array_unique($platform);

		?>
		

		      <div class="col-lg-2"></div>
		
		<div class="col-lg-8">
     				<div class="panel panel-primary">
     				 <div class="panel-heading">
                                <h3 class="panel-title" align="center"><i class=""></i>Filtro: </h3>
                            </div>
   
       <div class="panel-body">
     <form action="<?=$_SERVER["PHP_SELF"];?>" method="POST">
     	<?php if(!empty($nomeregrafiltro)){?>
     Escolha a regra: 
	 	<select id="Regra" class="form-control" name="Regra">
	     <?php foreach ($nomeregrafiltro as $nome_regra){?>
	     
	    <?php if($_POST['Regra'] == $nome_regra || $_POST['All'] == $nome_regra){
								?><option name="Regra" value="<?php echo $nome_regra;?>" selected><?php echo $nome_regra;?></option> 
								<?php }else{?>
								<option name="Regra" value="<?php echo $nome_regra;?>"><?php echo $nome_regra;?></option><?php 	
								}
							}
				?>
	     
	     
	     </select>
	     Escolha o Ano: 
							<select name="Ano" class="form-control"  id="Ano" >
						     		<?php if($_POST['Ano'] == 2014){?>
									<option name="Ano" value=2014 selected>2014</option>
									<?php }else{?>
									<option name="Ano" value=2014>2014</option>
									<?php }?>
									
									<?php if($_POST['Ano'] == 2015){?>
									<option name="Ano" value=2015 selected>2015</option>
									<?php }else{?>
									<option name="Ano" value=2015>2015</option>
									<?php }?>
									
									
									<?php if($_POST['Ano'] == 2016){?>
									<option name="Ano" value=2016 selected>2016</option>
									<?php }else{?>
									<option name="Ano" value=2016>2016</option>
									<?php }?>
			
									<?php if($_POST['Ano'] == 2017){?>
									<option name="Ano" value=2017 selected>2017</option>
									<?php }else{?>
									<option name="Ano" value=2017>2017</option>
									<?php }?>
									
							</select>
	    		Escolha o M&ecirc;s: 
							<select name="Mes" class="form-control" id="Mes" >
						     		<?php if($_POST['Mes'] == 01){?>
									<option name="Mes" value=01 selected>Janeiro</option>
									<?php }else{?>
									<option name="Mes" value=01>Janeiro</option>
									<?php }?>
									
									<?php if($_POST['Mes'] == 02){?>
										<option name="Mes" value=02 selected> Fevereiro</option>
									<?php }else{?>
									<option name="Mes" value=02> Fevereiro</option>
									<?php }?>
									
									
									<?php if($_POST['Mes'] == 03){?>
										<option name="Mes" value=03 selected> Mar&ccedil;o</option>
									<?php }else{?>
									<option name="Mes" value=03 > Mar&ccedil;o</option>
									<?php }?>
									
									
									<?php if($_POST['Mes'] == 04){?>
									<option name="Mes" value=04  selected>Abril</option>
									<?php }else{?>
									<option name="Mes" value=04 >Abril</option>
									<?php }?>
									
									
									<?php if($_POST['Mes'] == 05){?>
									<option name="Mes" value=05 selected>Maio</option>
									<?php }else{?>
									<option name="Mes" value=05 >Maio</option>
									<?php }?>
									
									<?php if($_POST['Mes'] == 06){?>
									<option name="Mes" value=06  selected>Junho</option>
									<?php }else{?>
									<option name="Mes" value=06 >Junho</option>
									<?php }?>
									
									<?php if($_POST['Mes'] == 07){?>
									<option name="Mes" value=07  selected>Julho</option>
									<?php }else{?>
									<option name="Mes" value=07 >Julho</option>
									<?php }?>
									
									<?php if($_POST['Mes'] == "08" || $_POST['Mes'] == 08){?>
									
									<option name="Mes" value=08 selected>Agosto</option>
									<?php }else{?>
									<option name="Mes" value=08>Agosto</option>
									<?php }?>
									
									<?php if($_POST['Mes'] == "09" || $_POST['Mes'] == 09){?>
									<option name="Mes" value=09  selected>Setembro</option>
									<?php }else{?>
									<option name="Mes" value=09 >Setembro</option>
									<?php }?>
									
									<?php if($_POST['Mes'] == 10){?>
									<option name="Mes" value=10  selected>Outubro</option>
									<?php }else{?>
									<option name="Mes" value=10>Outubro</option>
									<?php }?>
									
									<?php if($_POST['Mes'] == 11){?>
									<option name="Mes" value=11 selected>Novembro</option>
									<?php }else{?>
									<option name="Mes" value=11>Novembro</option>
									<?php }?>
									
										<?php if($_POST['Mes'] == 12){?>
									<option name="Mes" value=12 selected>Dezembro</option>
									<?php }else{?>
									<option name="Mes" value=12>Dezembro</option>
									<?php }?>
									
									<?php if($_POST['Mes'] == 13){?>
									<option name="Mes" value=13 selected>Todos os Meses</option>
									<?php }else{?>
									<option name="Mes" value=13>Todos os Meses</option>
									<?php }?>
							</select>
           <br>
         
           <div align="center">
				<button class="btn btn-primary" name="filtro" style="width:200px;height:auto" ><i class="fa fa-filter"></i>   Filtrar</button>		
           		<input type="hidden" name="token" value="<?php echo generateToken();?>"> 
			</div>	
				
     </form>
  
     	</div>
     
					</div>
				</div>
     
       <div class="col-lg-2"></div>
   <?php }else{?>
  <br><div class='alert alert-info fade in'>
                   	<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                  	N&atilde;o existem regras definidas ou a plataforma ainda n&atilde;o encontrou fugas de informa&ccedil;&atilde;o;
                   	</div>
   <?php }?>
     <br>
     
     
       <?php 
     if($crf_check==true){ 
     if(isset($_POST['filtro']) || isset($_POST['All'])){
     
  
     	
     if(!isset($_POST['Regra'])){
     	$_POST['Regra'] = $_POST['All'];
     }	
         ?>
    <div class="col-lg-12">
	<h3>Termos Encontrados:</h3>
	<hr></hr>

     
     
     <div class="row">
                    <div class="col-lg-12">
                        
                        <br>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
				                    <tr>
				                    <th> Nome Regra</th>
								    <th >Plataforma</th>
								    <th >Termo</th>
								    <th >Data</th>
								    <th >Falso Positivo?</th>
								    <th > </th>
								  </tr>
                                </thead>
                                <tbody>
                     <?php 
                     
                     $topView = array();
			
			if($_POST['Mes']=="13"){
	                	foreach ($cursorAll as $doc){
	                		$m = date_parse_from_format("Y-m-d", $doc['DataFound']);
								if($doc['email'] == $_SESSION["email"] && $doc['NomeRegra'] == $_POST['Regra'] && $m["year"]==$_POST['Ano']){
									$topView[]=['_id'=>$doc['_id'], 'NomeRegra'=>$doc['NomeRegra'],'Plataforma'=>$doc['Plataforma'],'Termo'=> $doc['Termo'],'DataFound'=>$doc['DataFound'], 'falsePositiv'=>$doc['falsePositiv'] , 'viewed'=>$doc['viewed']];
								 	
								}
	                	}
			}else{
				foreach ($cursorAll as $doc){
					$m = date_parse_from_format("Y-m-d", $doc['DataFound']);
					if($doc['email'] == $_SESSION["email"] && $doc['NomeRegra'] == $_POST['Regra'] && $m["month"] == $_POST['Mes'] && $m["year"]==$_POST['Ano']){
						$topView[]=['_id'=>$doc['_id'], 'NomeRegra'=>$doc['NomeRegra'],'Plataforma'=>$doc['Plataforma'],'Termo'=> $doc['Termo'],'DataFound'=>$doc['DataFound'], 'falsePositiv'=>$doc['falsePositiv'] , 'viewed'=>$doc['viewed']];
				
					}
				}
			}
			
			usort($topView, function($a, $b) {
				return strtotime($b['DataFound']) -  strtotime($a['DataFound']);
			});
			
			foreach ($topView as $val){
				?>  
					  <tr>
					  <?php if($val['viewed'] == 1){?>
					  <td> <?php echo $val['NomeRegra'];?></td>
					    <td ><?php echo $val['Plataforma'];?></td>
					   <td ><?php echo $val['Termo'];?></td>
					   <td><?php echo $val['DataFound'];?></td>
					   
					   <?php if(($val['falsePositiv']==2)){
					   	?>
					   <td width="10%" align="justify">
					  	 N&atilde;o Definido
					   </td>
					   	<?php   
					   }else{
					   	
						   	if($val['falsePositiv']==1) {
						   	?> <td width="10%" height="10%" align="justify">
					  			<p style="color:#339900">Sim</p>
					  			 </td> <?php 
						   	}else{
						   	?><td width="10%" align="justify">
					  			<p style="color:#CC0000">N&atilde;o </p>
					  		 </td> <?php
						   	}
					   }?>			   
					    <form action="viewTerm.php" method="POST" target="_blank"> 
					     <td>
					     <button class="btn btn-success" name="verifyTerm" value="<?php echo $val['_id'];?>"><i class="fa fa-eye"></i> Visualizar </button>	
					   	</td>
					   	</form>
					<?php }else{ ?>
						<td><b> <?php echo $val['NomeRegra'];?> </b></td>
					    <td><b><?php echo $val['Plataforma'];?></b></td>
					   <td><b><?php echo $val['Termo'];?></b></td>
					   <td><b><?php echo $val['DataFound'];?></b></td>
					   <td><b>
					   <?php if(($val['falsePositiv']==2)){echo 'N&atilde;o Definido';}else{if($val['falsePositiv']==1) {echo 'Sim';}else{echo 'N&atilde;o';}}?>			   
					   </b></td>
					    <form action="viewTerm.php" method="POST" target="_blank"> 
					     <td>
					     <button class="btn btn-success" name="verifyTerm" value="<?php echo $val['_id'];?>"><i class="fa fa-eye"></i> Visualizar </button>	
					    	</td>
					   	</form>
					  
						
					<?php }?>		
					  </tr>
				  <?php 
						}
					
				?>
				 
                                </tbody>
                            </table>
                        </div>
                    </div>
                  
                </div>
     
     
     
     
     <?php 
     
     	}
     
     
     } 
     
     
     ?>
		</div>	
			
                  
                </div>


             
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery-2.1.4.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    
    <script src="/SDLPlatform/js/jquery.dataTables.min.js"></script>
    
    <script>
 
    
    $(document).ready(function() {
        $('#DLFound').DataTable({
              responsive:true  
        });
    });
    </script>

</body>

</html>
