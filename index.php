<?php 
set_include_path('../SDLPlatform/');

include 'functions/functions.php';
include 'shodan_api/src/shodan.php';
include 'handler/handleIndex.php';
error_reporting(0);

if(loggedIn()){
$coll = connectDB_Dash();
$cursor = $coll->find(array('email' =>  $_SESSION["email"]));
}


if(!isset($_POST['refresh'])){
	$_POST['Mes']=date("m");
	$_POST['Ano']=date("Y");
	$_SESSION['Mes'] = date("m");
	$_SESSION['Ano'] = date("Y");
	
}


function DLFound_Quantity(){

	set_time_limit(120);
	
	$collum = connectDB_DLFound();
	$cursorDLFound = $collum->find(array('email' => $_SESSION["email"] , 'viewed' => 0));
	
	
	$top = array();
	if (sizeof($cursorDLFound)>=1){
		foreach ($cursorDLFound as $value){
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
				
		
	return $top;
	}
}



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
<?php if(loggedIn()){?>
    <meta charset="utf-16">
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
   
  <?php  }else{
	header("Location: /SDLPlatform/login.php");
 	  }?>
    
    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
 
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
 	<!-- <script src="/SDLPlatform/js/clock.js"></script> -->


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

  	</style>


    
</head>



<body oncontextmenu="return false;">
<?php if(loggedIn()){?>
    <div id="wrapper">
   <script src="/SDLPlatform/js/jquery.js"></script>
	<script src="/SDLPlatform/highcharts/js/highcharts.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="/SDLPlatform/js/bootstrap.min.js"></script>
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
             $top=DLFound_Quantity();
             set_time_limit(30);
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
                                                
                       
                       
                         ?>
                        <li class="divider"></li>
                        <li>
                            <a href="checkDLFound.php">Ver todos</a>
                        </li>
                      
                    </ul>
                </li>
                
                <li class="dropdown"> 
             		   <li class="dropdown">   	
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
	                    <i class="fa fa-user"></i> <?=htmlentities($_SESSION["login"]); ?> <b class="caret"></b></a>
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

      
        <div id="page-wrapper" style="height-min:800px;height:auto">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h3>
                            Bem-vindo ,   <small><?=htmlentities($_SESSION["login"]);?></small> !  </h3>
               					 <hr></hr>  

                           </div> 
                 </div>
                      
                
				 
				 <div class="col-lg-12" id="divFiltro"  style="display: block;">
                        <div class="panel panel-primary">
                            <div  class="panel-heading">
	                              	<form action="<?=$_SERVER["PHP_SELF"];?>" method="POST">
	                              	
                                <center><h3 class="panel-title" > <a href="#" onclick="abrirFiltro()" style="color: white"><i class="fa fa-filter"></i> Filtro</a></h3></center>
                            </div>
                            <?php if(isset($_POST['refresh'])){?>
	                            <div  id="filtro" class="panel-body" style="display: none;">
	                         <?php }else{?>
	                          	<div  id="filtro" class="panel-body" style="display: block;">
	                         <?php }?>
	                              <SMALL>	Plataforma: </SMALL>
	                            	<select name="Plataform" class="form-control" id="Plataform" onclick="changePlat(this);">
									<?php if($_SESSION['Plataform'] == "Pastebin"){?>
							 		<option name="Plataform" value="Pastebin" selected>PasteBin</option>
							 		<?php }else{?>
							 		<option name="Plataform" value="Pastebin">PasteBin</option>
							 		<?php }?>
							 		
											 		
							 		<?php if($_SESSION['Plataform'] == "Shodan"){?>
							 		<option name="Plataform" value="Shodan" selected>Shodan</option>
							 		<?php }else{?>
							 		<option name="Plataform" value="Shodan" >Shodan</option>
							 		<?php }?>						 		
					
							</select>
							<small>	Ano: </small>
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
						<small>	M&ecirc;s: </small>
							<select name="Mes" class="form-control" size="13" id="Mes" >
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
							</select>
							<small>	Nome Regra: </small>
							<select name="NomeRegra" class="form-control" style="width-min:auto;" id="NomeRegra" onchange="configDrop(this,document.getElementById('Term'))" >
							
							<?php 
							
							
							$all = array();
							foreach ($cursor as $doc) {
								if($doc['email']==$_SESSION['email'] && $doc['Plataforma'] == $_SESSION['Plataform']){
									$all[] = $doc['NomeRegra'];
								}
							}
							
							$filtro = array_unique($all);
						
					
							foreach ($filtro as $value){
							if($_SESSION['NomeRegra'] == $value){
								?><option name="NomeRegra" value="<?php echo $value;?>" selected><?php echo $value;?></option> 
								<?php }else{?>
								<option name="NomeRegra" value="<?php echo $value;?>"><?php echo $value;?></option><?php 	
								}
							}
							?>
						    
							</select>
							<div id="termhide">
							<small>	Termo: </small>
							<select name="Term" class="form-control" id="Term">
							<?php 
					
						
							$all = array();
							foreach ($cursor as $doc) {
								if($doc['email']==$_SESSION['email'] && $_SESSION['NomeRegra']==$doc['NomeRegra']){
									$all[] = $doc['Termo'];
								}
							}
							
							
							$filtro = array_unique($all);
					
							
							foreach ($filtro as $value){
							if($_SESSION['Term'] == $value){
								?>< <option name="Term" value="<?php  echo $value;?>" selected><?php  echo $value;?></option> 
								<?php }else{?>
								<option name="Term" value="<?php  echo $value;?>"><?php  echo $value;?></option><?php 	
								}
							}
							?>
							</select>
							</div>
							<br>
								<center>
										<button class="btn btn-primary" name="refresh" style="width:200px;height:auto" onclick="loadingGraph()"><i class="fa fa-filter"></i>   Filtrar</button>		
										<input type="hidden" name="token" value="<?php echo generateToken();?>"> 
								</center>	
							</form>
							
							<?php 
// 							$time = microtime();
// 							$time = explode(' ', $time);
// 							$time = $time[1] + $time[0];
// 							$finish = $time;
// 							$total_timeFiltro = round(($finish - $start), 4);
							
							
							?>
							
							
						
								</div>
                            </div>
                    </div>
 				</div>	
               
              
           <?php 

 	  			 $val="";
               $dataChart = "";
               $quantChart = "";
               $dataChartPositiv="";
               $quantChartPositiv="";
               $dataChartNeg="";
               $quantChartNeg="";
   
       if($crf_check==true){
         if(isset($_POST['refresh'])) { 
         
         	//**
//          	$time = microtime();
//          	$time = explode(' ', $time);
//          	$time = $time[1] + $time[0];
//          	$finish = $time;
//          	$total_timePagerefresehd = round(($finish - $start), 4);
         	//**echo 'Pagerefresehd and generated in '.$total_time.' seconds.<br>';
         	
        $continue=true;
     
	  	$_SESSION['Plataform'] = $_POST['Plataform']; 	
    	$_SESSION['Ano'] = $_POST['Ano'];
    	$_SESSION['Mes'] = $_POST['Mes'];

   		 if(!empty($_POST['Term']) && !empty($_POST['NomeRegra'])){
    	$_SESSION['Term'] = $_POST['Term'];
	  	$_SESSION['NomeRegra'] = $_POST['NomeRegra'];
    	
    	//CreateDash($_SESSION['email'], $_SESSION['Plataform'],$_SESSION['Ano'],$_SESSION['Mes'],$_SESSION['NomeRegra'],$_SESSION['Term']);
    	        
         	
		$val = getDashOnDB($_SESSION['email'],$_POST['NomeRegra'],$_POST['Term'],$_POST['Plataform'],$_POST['Mes'],$_POST['Ano']);
		$top = array();
		
		//**page
// 		$time = microtime();
// 		$time = explode(' ', $time);
// 		$time = $time[1] + $time[0];
// 		$finish = $time;
// 		$total_timePageaftergetdash = round(($finish - $start), 4);
		//**echo 'Pageaftergetdash in '.$total_time.' seconds.';
		
		if (sizeof($val)>1){
			
			
		foreach ($val as $value){
		
				$top[] = ['Plataforma'=>$value['Plataforma'],'Data'=>$value['Data'], 'Termos'=>$value['Termo'], 'Quantidade'=>$value['Quantidade']];
			
			
		}
		
		$temp_top = array_map("unserialize", array_unique(array_map("serialize", $top)));
		$numvezesfound=0;
		
		foreach($temp_top as $key => $value){
				foreach($top as $valuetop){
					if($value['Data'] == $valuetop['Data'] && $value['Plataforma'] == $valuetop['Plataforma'] && $value['Termos'] == $valuetop['Termos']){
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
				$dataChart = $dataChart . '"'.$v['Data']. '"';
				$quantChart = $quantChart .$v['Quantidade'];
			}else{
				$dataChart =  $dataChart  . '"'.$v['Data'].'", ';
				$quantChart = $quantChart .$v['Quantidade'].", ";
			}
		}
		
		//---------
		
		
			
		
		}
		
		$valPositiv=getDLFoundByTerm($_SESSION['email'],$_POST['NomeRegra'],$_POST['Term'],$_POST['Plataform'],$_POST['Mes'],$_POST['Ano'],"positiv");
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
						$dataChartPositiv = $dataChartPositiv . '"'.$v['Data']. '"';
		
						$datafound=false;
						foreach($topPositiv as $valu) {
							if($valu['Data'] == $v['Data']){
								$datafound=true;
								$quantChartPositiv = $quantChartPositiv .$valu['Quantidade'];
							}
						}
						if($datafound==false){
							$quantChartPositiv = $quantChartPositiv .'0';
						}
						 
		
					}else{
						$dataChartPositiv =  $dataChartPositiv  . '"'.$v['Data'].'", ';
		
						$datafound=false;
						foreach($topPositiv as $valu) {
							if($valu['Data'] == $v['Data']){
								$datafound=true;
								$quantChartPositiv = $quantChartPositiv .$valu['Quantidade'].", ";
							}
						}
		
						if($datafound==false){
							$quantChartPositiv = $quantChartPositiv .'0'.", ";
						}
						 
		
					}
				}
				 
		
		}
		
		
		//**page
// 		$time = microtime();
// 		$time = explode(' ', $time);
// 		$time = $time[1] + $time[0];
// 		$finish = $time;
// 		$total_timePagegetDLFoundPositiv = round(($finish - $start), 4);
		//echo 'PagegetDLFoundPositiv generated in '.$total_time.' seconds.<br>';
		
	//----------
	
		
		
		
		
         
         $valNeg=getDLFoundByTerm($_SESSION['email'],$_POST['NomeRegra'],$_POST['Term'],$_POST['Plataform'],$_POST['Mes'],$_POST['Ano'],'negativ');
         $topNeg= array();

         if(sizeof($valNeg)!=0){
         	foreach ($valNeg as $value){
         		$parse_data=strtotime($value['DataFound']);
         		$topNeg[] = ['Plataforma'=>$value['Plataforma'],'Data'=>date('d/m/Y', $parse_data), 'Termos'=>$value['Termo'], 'Quantidade'=>$value['Num']];
         		$data="";
         	}
         	 
         	$temp_topNeg = array_map("unserialize", array_unique(array_map("serialize", $topNeg)));
         	$numvezesfoundNeg=0;
         	 
         	foreach($temp_topNeg as $key => $value){
         		foreach($topNeg as $valuetop){
         			if($value['Data'] == $valuetop['Data'] && $value['Plataforma'] == $valuetop['Plataforma'] && $value['Termos'] == $valuetop['Termos']){
         				$numvezesfoundNeg +=1;
         			}
         		}
         		$temp_topNeg[$key]['Quantidade'] = $numvezesfoundNeg;
         		$numvezesfoundNeg = 0;
         	}
         	 //**page
         	$time = microtime();
         	$time = explode(' ', $time);
         	$time = $time[1] + $time[0];
         	$finish = $time;
         	$total_timePagegetDLFoundNeg = round(($finish - $start), 4);
         	//**echo 'PagegetDLFoundNeg generated in '.$total_time.' seconds.<br>';
         	 
         	 
         	
         	$topNeg = $temp_topNeg;
         	 
         	 
        
         		//iterate the array
         
         		 
         		foreach($top as $k => $v) {
         			if($k == $lastElementKey) {
         				$dataChartNeg = $dataChartNeg . '"'.$v['Data']. '"';
         				 
         				$datafound=false;
         				foreach($topNeg as $valu) {
         					if($valu['Data'] == $v['Data']){
         						$datafound=true;
         						$quantChartNeg = $quantChartNeg .$valu['Quantidade'];
         					}
         				}
         				if($datafound==false){
         					$quantChartNeg = $quantChartNeg .'0';
         				}
         
         				 
         			}else{
         				$dataChartNeg =  $dataChartNeg  . '"'.$v['Data'].'", ';
         				 
         				$datafound=false;
         				foreach($topNeg as $valu) {
         					if($valu['Data'] == $v['Data']){
         						$datafound=true;
         						$quantChartNeg = $quantChartNeg .$valu['Quantidade'].", ";
         					}
         				}
         				 
         				if($datafound==false){
         					$quantChartNeg = $quantChartNeg .'0'.", ";
         				}
         
         				 
         			}
         		}
          
         
         }
        
         }
		
         }
 	  }	
       

		?>     
	
			  
            
		<?php if(isset($_POST['refresh'])){?>
     <div class="row" id="loading" style="display: block;">
     				
                          	</form>
     				<div class="col-lg-3">
     				<div class="panel panel-primary">
     				 <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-dashboard"></i> Regras Com Termos Encontrados </h3>
                            </div>
                            <div class="panel-body" style="height:580px">
                             
     					<div id="pie" style="height:100%;width:100%"></div>
						</div>
					</div>
				</div>
     
                    <div class="col-lg-9">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-dashboard"></i> &nbsp;Dashboard Mensal (M&ecirc;s de <?php  if(isset($_POST['Mes'])){ echo getMonthByNumber($_POST['Mes']).' - '. $_POST['Ano'];}else{ echo getMonthByNumber(date("m")).' - '.date("Y");}?>) 
                            </div>
                            <div class="panel-body">
                              
                              
                              <div class="row">

                            	<div id="graficoTerms" class="col-lg-12">
                 				<div style="height:550px">
 								
							<?php if(sizeof($val)>1){?> 
 								<div id="graph" style="height:100%;width:100%"></div>
 							<?php }else{
 								
	 								if(empty($_SESSION['Plataform'])){
	 									echo	"<div class='alert alert-danger fade in' style='text-align:center'>
										<strong>Aten&ccedil;&atildeo</strong>, N&atilde;o indicou qual a plataforma a filtrar.
										</div>";
	 								}	
 								
 									if(empty($_SESSION['Term']) || empty($_SESSION['NomeRegra']) ){
 									echo	"<div class='alert alert-danger fade in' style='text-align:center'>
									<strong>Aten&ccedil;&atildeo</strong>, N&atilde;o indicou qual a regra ou termo a filtrar.
									</div>";
									}
									
									
									
									?>
									<div class='alert alert-warning fade in' style='text-align:center'>
									N&atilde;o existe dados relativos &aacute; sua pesquisa.
									</div>
								<?php }
						?>
 								</div>
 							
 						
 							</div>		
 								
 					
 					</div>	
 					
 							
 						
							</div>
						</div>
						
			
					</div>
			
                     
                   
    </div>     
		<?php }?>	    
    					<div class="row" id="loadingAppear" style="display: none;">
    					<br>
    					<br>
									<div class="col-lg-3" >
									</div>
									<div class="col-lg-6">
									<div class="panel panel-primary">
	                           		 <div class="panel-body ">
										<center> <h3>A carregar os dashboards,<br>
										<img src="/SDLPlatform/images/loadingGraph.gif" width="400px" height="300px"></img><br>por favor aguarde..</h3></center>
									</div>
									</div>
									</div>
									<div class="col-lg-3" >
									</div>
							</div>
							
							
    <?php if(isset($_POST['refresh'])){?>
      <div class="row" id="dashAnual" style="display: block;">
    <div class="col-lg-12" >
     				<div class="panel panel-primary">
     				 <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-dashboard"></i> Dashboard Anual - <?php echo $_SESSION['Ano']?> </h3>
                            </div>
                            <div class="panel-body "> 
     						<div id="yeargraph" style="height:100%;width:100%"></div>
     					
				
						</div>
					</div>
				</div>
    </div> 
    	<?php }?>
	    

				<script type="text/javascript">

				
				
				if(document.getElementById('filtro').style.display == 'none'){
					document.getElementById('graficoTerms').className  = "col-lg-12";	
				}
				
				
				
				function configDrop(nomeRegra,termosDrop) {

					$('#termhide').show();
					<?php 
					
					
					$allNomeRegra = array();
					foreach ($cursor as $doc) {
						if($doc['email']==$_SESSION['email']){
							$allNomeRegra[] = $doc['NomeRegra'];
						}
					}
					
					$filtroNomeRegra = array_unique($allNomeRegra);
					
					$Termos=array();
					foreach ($cursor as $doc) {
						foreach ($filtroNomeRegra as $regra){
							if($doc['email']==$_SESSION['email'] && $regra == $doc['NomeRegra'] ){
								$Termos[] = ['Regra'=>$regra, 'Termos'=>"'".$doc['Termo']."'"];
							}
						}
					}
					
					
					$filtrarTermos = array_unique($Termos,SORT_REGULAR);

					
					$array = array();
					
					foreach ($filtrarTermos as $value){
						if(empty($array)){
							$array[] = $value;
						}else{
							foreach ($array as $key=>$b){
								if($b['Regra'] == $value['Regra']){
									$array[$key]['Termos'] = "".$b['Termos'].",".$value['Termos']."";
								}else{
									$array[] = $value;
								}
							}	
						}
					}
					
					
					

					?>
				 					 
					     switch(nomeRegra.value){
					     <?php $id=0;
					     foreach ($array as $term => $value){?>
					         case "<?php echo $value['Regra']?>":
					        	 <?php 
				
					        	
					        	 ?>
						         $('#termhide').show();
						         var termos<?php echo $id;?> = new Array(<?php echo $value['Termos'];?>);
						         termosDrop.options.length = 0;
					            for (i = 0; i < termos<?php echo $id;?>.length; i++) {
					                createOption(termosDrop, termos<?php echo $id;?>[i], termos<?php echo $id;?>[i]);
					            }
					            break;
					     <?php $id++;}?>
					             
			
					                default:
					                	 $('#termhide').hide();
					                termosDrop.options.length = 0;
					                    createOption(termosDrop, " ", "")               
					     }
					 

					}

					

		<?php if(isset($_POST['refresh'])){?>		
			$(function () {
    $('#graph').highcharts({
        chart: {
            type: 'areaspline'
        },
        title: {
            text: "Nome da regra: <?php echo $_SESSION['NomeRegra'] ?>"
        },
        xAxis: {
            categories: [<?php echo $dataChart;?>,<?php  if($dataChartPositiv!=""){echo $dataChartPositiv;}?>,<?php  if($dataChartNeg!=""){echo$dataChartNeg;}?>]
        },
        yAxis: {
            title: {
                text: 'N\xFAmero de vezes Encontrado'
            }
        },
        plotOptions: {
        	 series: {
                 events: {
                     legendItemClick: function () {
                             return true; 
                     }
                 },
             },
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: true
            },
        },
        series: [{
            name: '<?php echo $_SESSION['Term'];?> - Total',
            data: [<?php echo $quantChart;?>]
        }<?php if($quantChartPositiv!=""){?>,
        { name: '<?php echo $_SESSION['Term'];?> - Positivos',
        	color: '#006600',
    		data: [<?php echo $quantChartPositiv;?>]}<?php }?>
    	
		<?php if($quantChartNeg!=""){?>,
    		        { name: '<?php echo $_SESSION['Term'];?> - Falsos Positivos',
    		        	color: '#FF3333',
    		   data: [<?php echo $quantChartNeg;?>]}<?php }?>
        ]
        
    });
});




			$(function () {
			    $('#yeargraph').highcharts({
			        chart: {
			            type: 'column'
			        },
			        title: {
			            text: "Nome da regra: <?php echo $_SESSION['NomeRegra'] ?>"
			        },
			        xAxis: {
			            categories: ["Janeiro","Fevereiro","Mar\xe7o","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro"]
			        },
			        yAxis: {
			            title: {
			                text: 'N\xFAmero de vezes Encontrado'
			            }
			        },
			        plotOptions: {
			        	series: {
			                dataLabels: {
			                    enabled: true,
			                    allowOverlap: true
			                },
			                enableMouseTracking: false
			            }
			        }, 
			        series: [{
			            name: '<?php echo $_SESSION['Term'];?> - Total',
			            data: [<?php getDLFoundMontlyByTerm($_SESSION['email'],$_SESSION['NomeRegra'],$_SESSION['Term'],$_SESSION['Plataform'],$_SESSION['Ano'],"total"); ?>]
			        },{
			        	type: 'spline',
			        	 name: '<?php echo $_SESSION['Term'];?> - Positivos',
			        	 color: '#006600',
			            data: [<?php getDLFoundMontlyByTerm($_SESSION['email'],$_SESSION['NomeRegra'],$_SESSION['Term'],$_SESSION['Plataform'],$_SESSION['Ano'],"positiv"); ?>]
			        },{
			        	type: 'spline',
			        	 name: '<?php echo $_SESSION['Term'];?> - Falsos Positivos',
			        	 color: '#FF3333',
			            data: [<?php getDLFoundMontlyByTerm($_SESSION['email'],$_SESSION['NomeRegra'],$_SESSION['Term'],$_SESSION['Plataform'],$_SESSION['Ano'],"negativ"); ?>]
			        }] 
			    });
			});


			
		
			<?php 

					$collumPie = connectDB_DLFound();
					$cursorPie = $collumPie->find(array('email' =>  $_SESSION["email"]));
					 
					 

					$pie = array();
					if (sizeof($cursorPie)>=1){
						foreach ($cursorPie as $value){
							if($value['email'] == $_SESSION["email"]){
								$pie[] = ['NomeRegra'=>$value['NomeRegra'],'Quantidade'=>1];
							}
						}
						 
						 
						$temp_pie = array_map("unserialize", array_unique(array_map("serialize", $pie)));
						$numvezesfound=0;
						 
						foreach($temp_pie as $key => $value){
							foreach($pie as $valuetop){
								if($value['NomeRegra'] == $valuetop['NomeRegra']){
									$numvezesfound +=1;
								}
							}
							$temp_pie[$key]['Quantidade'] = $numvezesfound;
							$numvezesfound = 0;
						}

						$pie = $temp_pie;
						
						end($pie);
						
						$dataPie="";
						$lastElementKey = key($pie);
						//iterate the array
						
						foreach($pie as $k => $v) {
							if($k == $lastElementKey) {
								$dataPie = $dataPie . '{name:"'.$v['NomeRegra']. '", y:'.$v['Quantidade'].'}';
							}else{
								$dataPie = $dataPie . '{name:"'.$v['NomeRegra']. '", y:'.$v['Quantidade'].'}, ';
							}
						}
					}
						
		?>
			
$(function () {
    $('#pie').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Regras Com Termos Encontrados'
        },
        tooltip: {
            pointFormat: '<b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
        	 pie: {
                 allowPointSelect: true,
                 cursor: 'pointer',
                 dataLabels: {
                     enabled: false
                 },
                 showInLegend: true,

                  point:{
                     events : {
                      legendItemClick: function(e){
                          e.preventDefault();
                      }
                     }
                 }
             }
        },
        series: [{
            colorByPoint: true,
            data: [<?php echo $dataPie;?>]
        }]
    });
});

<?php }?>
		</script>
		
			
	<script type="text/javascript">
	function GetClock(){var e=new Date,o=e.getMonth(),t=e.getDate(),n=e.getYear();1e3>n&&(n+=1900);var e=new Date,r=e.getHours(),a=e.getMinutes(),c=e.getSeconds();9>=a&&(a="0"+a),9>=c&&(c="0"+c),document.getElementById("clockbox").innerHTML=""+t+", "+tmonth[o]+" "+n+" <b>"+r+":"+a+":"+c+"</b>"}var tmonth=new Array("Janeiro","Fevereiro","Mar&ccedil;o","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");window.onload=function(){GetClock(),setInterval(GetClock,1e3)};
	</script>
		
		
		 <script type="text/javascript">

		 function abrirFiltro(){
	            var mydiv = document.getElementById('filtro');
	            if (mydiv.style.display === 'block' || mydiv.style.display === '') {
	                mydiv.style.display = 'none';
	            } else {	   
	                mydiv.style.display = 'block';
	            }
	        }
			

		 function loadingGraph(){

		
				 var f=document.getElementById("divFiltro");
				 f.style.display='none';
			 

			 if(document.getElementById("loading")!=null){
			 var e=document.getElementById("loading");
				e.style.display="none";
			 }

			var l=document.getElementById("dashAnual");
			if(document.getElementById("dashAnual")!=null){
			l.style.display="none";
			}

			
		
			 var t=document.getElementById("loadingAppear");t.style.display="block"
				 }


		 function loadingGraphs(){
			var e=document.getElementById("graphsload");e.style.display="none";var t=document.getElementById("loadingAppear");t.style.display="block"
		 }

		 	 
  function changePlat(plataform){
		if(plataform.value == 'Pastebin'){
			document.getElementById('NomeRegra').options.length = 0;
			  createOption(document.getElementById('NomeRegra'), "Selectione uma regra", "Selectione uma regra"); 
			  document.getElementById('termhide').style.display = "none";
          <?php 
					$all = array();
					foreach ($cursor as $doc) {
						if($doc['email']==$_SESSION['email'] &&  $doc['Plataforma'] == 'Pastebin'){
							$all[] = $doc['NomeRegra'];
						}
					}
					$filtro = array_unique($all);
					foreach ($filtro as $value){									
						?>
        			  createOption(document.getElementById('NomeRegra'), "<?php echo $value?>", "<?php echo $value?>"); 
						<?php 
					}?>
		}
		if(plataform.value == 'Shodan'){
			document.getElementById('NomeRegra').options.length = 0;
			createOption(document.getElementById('NomeRegra'), "Selectione uma regra", "Selectione uma regra");
			  document.getElementById('termhide').style.display = "none";
          <?php 
					
					
          
					$all = array();
					foreach ($cursor as $doc) {
						if($doc['email']==$_SESSION['email'] &&  $doc['Plataforma'] == 'Shodan'){
							$all[] = $doc['NomeRegra'];
						}
					}
					
					$filtro = array_unique($all);
				
				
			
					foreach ($filtro as $value){									
						?>
        			  createOption(document.getElementById('NomeRegra'), "<?php echo $value?>", "<?php echo $value?>"); 
						<?php 
					}?>

			
		}
		
	}
	

  function createOption(t,e,n){var o=document.createElement("option");o.value=n,o.text=e,t.options.add(o)}
  
  </script>
		
	
		
	
		 <?php 
//         echo '*******************************************************************************<br>';
// 		echo '**                          Time Debugger                                    **<br>';
// 		echo '*******************************************************************************<br>';
//         echo ' [+] Notification bar in '.$total_timeCheckDLFOound.' seconds.<br>';
//         if(isset($_POST['refresh'])){
//         echo ' ========== New Graphic Comand ======================<br>';
//         echo ' [+] Time since beginning until POST is commited in '.$total_timePagerefresehd.' seconds.<br>';
//         echo ' [+] Time since beginning of Function (Graph and Cached_Graph as been called) in '.$total_timePageaftergetdash.' seconds.<br>';
//         echo ' [+] Time since beginning of Function (Positiv hits on Graph)  in '.$total_timePagegetDLFoundPositiv.' seconds.<br>';
//         echo ' [+] Time since beginning of Function (Negativ hits on Graph)  in '.$total_timePagegetDLFoundNeg.' seconds.<br>';
//         echo ' ===============================================<br>';
//         }else{
//         echo ' ==========  Simple Plage Refresh  ======================<br>';
//         echo ' [+] Time since beginning until Simple Refresh is commited in '.$total_timeRefresh.' seconds.<br>';
//         echo ' [+] Time since beginning of Function (GetCreatGraph is called) in '.$total_timePOSTcreateDash.' seconds.<br>';
//         echo ' [+] Time since beginning of Function (GetDashOnDB is called) in '.$total_timePOSTcreateDashgetDash.' seconds.<br>';
//         echo ' [+] Time since beginning of Function (Positiv hits on Graph) in '.$total_timePOSTcreateDashetDashPOSITIV.' seconds.<br>';
//         echo ' [+] Time since beginning of Function (Negativ hits on Graph) in '.$total_timePOSTCreateDashgetDASHNEG.' seconds.<br>';
//         echo ' ===============================================<br>';
//         }
//         echo ' [+] Time since beginning of Function to create filter in '.$total_timeFiltro.' seconds.<br>';
        
     

        
        ?>
		
		</div>
		<?php    
		//$time = microtime();
//         $time = explode(' ', $time);
//         $time = $time[1] + $time[0];
//         $finish = $time;
//         $total_time = round(($finish - $start), 4);
//         echo '<div align="right" style="background-color:white"><small>Page generated in '.$total_time.' seconds.</small></div>';?>

      </div>
        <!-- /#page-wrapper -->
 
        
    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->


 <?php }else{
	header("Location: /SDLPlatform/login.php");
 	  }


?>

</body>

</html>
