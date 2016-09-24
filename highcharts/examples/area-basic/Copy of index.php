<?php






?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE = edge">
        <meta name="viewport" content="width = device-width, initial-scale = 1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Plataforma</title>

        <!-- Bootstrap Core CSS -->
        <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
                <script src = "https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
                <![endif]-->

    </head>

    <body>

        <div id="wrapper">

            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php">Teste</a>
                </div>
                <!-- /.navbar-header -->

              
                <!-- /.navbar-top-links -->

             
             
                <!-- /.navbar-static-side -->
            </nav>

            <!-- Page Content -->
            <div id="page-wrapper">

                
                    <div class="row">
                        <div class="col-lg-2" style="width: auto">
                    <div class="form-group">
                        <label for="sel1">Classificação:</label>
                        <select class="form-control" id="selectClass" onchange="configureDropDownLists(this,document.getElementById('selectTax'))" style="width: auto">
                            <option value="">Escolha a classificação</option>
                            <option value="OWASP">OWASP</option>
                            <option value="OWASPM">OWASPM</option>
                            <option>3</option>
                            <option>4</option>
                        </select>
                    </div>
                        </div>
                        <div class="col-lg-1">
                    <div class="form-group">
                        <label for="sel1">Taxonomia:</label>
                        <select class="form-control" id="selectTax" onclick="" style="width: auto">
                            <option value="">...</option>
                        </select>
                    </div>
                    </div>
                    </div>
                    <br>
                  

                  


                <!-- /.container-fluid -->
            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->

        <!-- jQuery -->
        <script src="../bower_components/jquery/dist/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="../dist/js/sb-admin-2.js"></script>

        <script type="text/javascript">function updateClock() {
                var now = new Date(), // current date

                        time = now.getHours() + ':' + now.getMinutes() + ':' + now.getSeconds(), // again, you get the idea

                        // a cleaner way than string concatenation
                        date = [now.getDate(),
                            now.getMonth() + 1,
                            now.getFullYear()].join('/');

                // set the content of the element with the ID time to the formatted string
                document.getElementById('time').innerHTML = [date, time].join(' | ');

                // call this function again in 1000ms
                setTimeout(updateClock, 1000);
            }
            updateClock();</script>

<script type="text/javascript">
function configureDropDownLists(ddl1,ddl2) {
    
var owaspTOP = new Array('A1 - Injection', 'A2 - Broken Authentication and Session Management', 'A3 - Cross-Site Scripting (XSS)','A4 - Insecure Direct Object References',
'A5 - Security Misconfiguration','A6 - Sensitive Data Exposure','A7 - Missing Function Level Access Control','A8 - Cross-Site Request Forgery (CSRF)','A9 - Using Components with Known Vulnerabilities','A10 - Unvalidated Redirects and Forwards');
var owaspM = new Array('M1 - Weak Server Side Controls', 'M2 - Insecure Data Storage', 'M3 - Insufficient Transport Layer Protection','M4 - Unintended Data Leakage','M5 - Poor Authorization and Authentication'
,'M6 - Broken Cryptography','M7 - Client Side Injection','M8 - Security Decisions Via Untrusted Inputs','M9 - Improper Session Handling','M10 - Lack of Binary Protections');

 

     switch(ddl1.value){
         case "OWASP":
            ddl2.options.length = 0;
            for (i = 0; i < owaspTOP.length; i++) {
                createOption(ddl2, owaspTOP[i], owaspTOP[i]);
            }
            break;
            case "OWASPM":
            ddl2.options.length = 0;
            for (i = 0; i < owaspM.length; i++) {
                createOption(ddl2, owaspM[i], owaspM[i]);
            }
             
             break;
                default:
                    ddl2.options.length = 0;
                    createOption(ddl2, "...", "")
                    
     }
 

}

function createOption(ddl, text, value) {
        var opt = document.createElement('option');
        opt.value = value;
        opt.text = text;
        ddl.options.add(opt);
    }
</script>



    </body>

</html>
