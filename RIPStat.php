<?php

include 'shodan_api/src/shodan.php';
include("/functions/functions.php");


if(!loggedIn()){
header('Location: /SDLPlatform/login.php');
}

$crf_check=false;


if(isset($_POST["token"])){
	if(checkToken($_POST["token"])==true){
		$crf_check=true;
	}
}


$yourip = getRealUserIp();

if($yourip=="::1"){
	$api_key = 'DoUSU6P4fSiZY4toSFlicCKccveyrt2R';
	$shodan = new Shodan($api_key);
	$yourip=$shodan->myip();
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

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
   
     <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js'></script>
   
  

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
               <a class="navbar-brand" href="index.php">SDL Platform</a>
            </div>

            <script src="js/jquery.js"></script>
  			  <script src="js/bootstrap.min.js"></script>
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a id="clockbox"><i class="fa fa-clock-o"></i></a>
                </li>
                
                 <li class="dropdown">
                     <?php 
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
				<!-- navegacao -->
                     <!-- navegacao -->
<!--                      <ol class="breadcrumb"> -->
<!--                             <li> -->
<!-- 		                   <i class="fa fa-dashboard"></i>  <a href="index.php">Dashboard</a> -->
<!--                             </li> -->
<!--                             <li class="active"> -->
<!--                                 <i class="fa fa-file"></i> Reputa&ccedil;&atilde;o de IP -->
<!--                             </li> -->
<!--                         </ol> -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                    <h3>Reputa&ccedil;&atilde;o de IP (IP actual &eacute;: <?php if(!empty($yourip)) echo $yourip; //$json['data']['ip'];?>) - Powered By :  RIPE Stat 
                    </h3>
                    <hr></hr>
	
	<form action="<?=$_SERVER["PHP_SELF"];?>" method="POST">
	  <p style="font-size:17px">Insira o IP que deseja:</p>
	<div class="form-group input-group">
		<span class="input-group-addon"><i class="fa fa-terminal"></i></span>
      <input type="text" class="form-control" name="ip" value="">
	</div>
	<input type="hidden" name="token" value="<?php echo generateToken();?>"> 
	<div class="form-group input-group">
<!-- 	<span class="input-group-addon"><i class="fa fa-thumbs-up"></i></span> -->
		<button class="btn btn-primary" style="padding:10px 76px"  name="procurar"><i class="fa fa-chevron-right"></i>&nbsp;&nbsp;&nbsp;&nbsp;Procurar</button>		
      <!-- <input class="btn btn-default" style="width:100px" name="promover" type="submit" value="Promover"> -->
	</div>
	</form>
	
	
	<?php 
	
	     if($crf_check==true){
				if(isset($_POST["procurar"])){?>
	 <div class="row">
                    <div class="col-lg-6">
                        <div class="panel panel-grey">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-long-arrow-right"></i> Resultados:</h3>
                            </div>
                            
                            <script>
	document.getElementById("page-wrapper").style.height = "auto";
	</script>
		<script src="//stat.ripe.net/widgets/widget_api.js"></script>
		
		<?php $ipPHP = $_POST["ip"];?>
	<h5 class="page-header" style="text-align:center">Geoloc</h5>
		<div style="text-align: center">
		<div class="statwdgtauto">
		<script>
		var ip = <?php 
		echo json_encode($ipPHP); ?>;
		ripestat.init("geoloc", {"resource":ip}, null, {
			size: "fit",
			disable: ["title","embed-code","permalink","logo","maximize","feedback", "footer-buttons","container"]
		})
		</script></div></div>
		&nbsp;
	
	<h5 class="page-header" style="text-align:center">Registry Browser</h5>
		<center>
		<div class="statwdgtauto"><script>
		var ip = <?php echo json_encode($ipPHP); ?>;
		ripestat.init("registry-browser", {"resource":ip}, null, {
			size: "fit",
			disable: ["title","embed-code","permalink","logo","maximize","feedback", "footer-buttons","container"]
		})
		</script></div>
			</center>
			
			<h5 class="page-header" style="text-align:center">iana registry info</h5>
		<div class="statwdgtauto"><script>
		var ip = <?php echo json_encode($ipPHP); ?>;
		ripestat.init("iana-registry-info", {"resource":ip}, null, {
			size: "fit",
			disable: ["title","embed-code","permalink","logo","maximize","feedback", "footer-buttons","container"]
		})
		</script></div>
	
    
                    </div>
              
				</div>
				
				 <div class="col-lg-6">
                        <div class="panel panel-grey">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-long-arrow-right"></i> Resultados:</h3>
                            </div>
                            
                            <h5 class="page-header" style="text-align:center">BGPlay</h5>
		<div class="statwdgtauto"><script>
		var ip = <?php echo json_encode($ipPHP); ?>;
		ripestat.init("bgplay", {"resource":ip}, null, {
			size: "fit",
			disable: ["title","embed-code","permalink","logo","maximize","feedback", "footer-buttons","container"]
		})
		</script></div>
                            
                            <h5 class="page-header" style="text-align:center">Routing Status</h5>
		<div class="statwdgtauto"><script>
		var ip = <?php echo json_encode($ipPHP); ?>;
		ripestat.init("routing-status", {"resource":ip}, null, {
			size: "fit",
			disable: ["title","embed-code","permalink","logo","maximize","feedback", "footer-buttons","container"]
		})
		</script></div>
	
		<h5 class="page-header" style="text-align:center">Reverse-Dns</h5>
		<div class="statwdgtauto"><script>
		var ip = <?php echo json_encode($ipPHP); ?>;
		ripestat.init("reverse-dns", {"resource":ip}, null, {
			size: "fit",
			disable: ["title","embed-code","permalink","logo","maximize","feedback", "footer-buttons","container"]
		})
		</script></div>
		
		<br>
		&nbsp;<h5 class="page-header" style="text-align:center">BlackList</h5>
		<div class="statwdgtauto"><script>
		var ip = <?php echo json_encode($ipPHP); ?>;
		ripestat.init("blacklist", {"resource":ip}, null, {
			size: "fit",
			disable: ["title","embed-code","permalink","logo","maximize","feedback", "footer-buttons","container"]
		})
		</script></div>
		<h5 class="page-header" style="text-align:center">Suggestions</h5>
		<div class="statwdgtauto"><script>
		var ip = <?php echo json_encode($ipPHP); ?>;
		ripestat.init("suggestions", {"resource":ip}, null, {
			size: "fit",
			disable: ["title","embed-code","permalink","logo","maximize","feedback", "footer-buttons","container"]
		})
		</script></div>
                       </div>
              
				</div>
				
				</div>
				
		
                   
			   
				<?php }}?>	

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
	<script>

	var tmonth=new Array("Janeiro","Fevereiro","Mar&ccedil;o","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");

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

	
	window.onload = function(){
		GetClock();
		setInterval(GetClock,1000);
	}
	</script>
    <!-- jQuery -->
<!--     <script src="js/jquery.js"></script> -->

    <!-- Bootstrap Core JavaScript -->
<!--     <script src="js/bootstrap.min.js"></script> -->

</body>

</html>
	


