<?php   
session_start();  
$logedInName = $_SESSION['name'];
$logedInUsername = $_SESSION['username'];
if(!isset($_SESSION["loggedin"])){  
    header("Location: https://evaluator.ddns.net/login/?next=/");  
} else {
?>
<!DOCTYPE html>
<html><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title> Dashboard - Evaluator </title>

    
    <link href="https://evaluator.ddns.net/bootstrap.min.css" rel="stylesheet">
    <link href="https://evaluator.ddns.net/font-awesome.min.css" rel="stylesheet">
    <link href="https://evaluator.ddns.net/evaluator_style.css" rel="stylesheet">
    <link href="https://evaluator.ddns.net/favicon.ico" rel="shortcut icon">

     
     
</head>

<body>

    
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div class="navbar-brand"><i class="fa fa-gears fa-fw"></i> Evaluator</div>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="https://evaluator.ddns.net/"><i class="fa fa-dashboard fa-fw"></i> Dashboard </a></li>
                    
                    <li><a href="https://evaluator.ddns.net/tasks/"><i class="fa fa-tasks fa-fw"></i> Tasks </a></li>
                    
                    <li><a href="https://evaluator.ddns.net/events/"><i class="fa fa-calendar fa-fw"></i> Events </a></li>
                    
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-user fa-fw"></i> <b><?php echo $logedInName; ?></b> <i>(<?php echo $logedInUsername; ?>)</i> <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            
                            <li><a href="https://evaluator.ddns.net/change_password/"><i class="fa fa-key fa-fw"></i> Change password </a></li>
                            <li role="separator" class="divider"></li>
                            
                            <li><a href="https://evaluator.ddns.net/logout/"><i class="fa fa-sign-out fa-fw"></i> Logout </a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <div class="container">

        <div class="page-header">
            <div class="row">
                <div class="col-lg-10 col-md-9">
                    <h1>
<i class="fa fa-dashboard fa-fw"></i> Dashboard
</h1>
                </div>
                <div class="col-lg-2 col-md-3">
                     
                </div>
            </div>
        </div>

        
        
    <div class="row">
        <div class="col-md-4 col-sm-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-file-text-o fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <h4>0</h4>Submissions
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-tasks fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <h4><?php
                            $DATABASE_HOST = 'localhost';
							$DATABASE_USER = 'root';
							$DATABASE_PASS = '';
							$DATABASE_NAME = 'tasks';
							$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
							$pristup = False;
							$query = 'SELECT id, access, name, submits_all, submits_successful FROM tasks';
							$result = mysqli_query($con, $query);
							if (mysqli_num_rows($result) > 0) {
						    	$num = 0;
								while($row = mysqli_fetch_assoc($result))
								{
									if (strpos($row["access"], $logedInUsername) !== false){
										$num = $num+1;
									}
								}
								echo $num;
							} else {
								echo "0";
							}                         
                            ?></h4>Tasks
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-calendar fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <h4>0</h4>Events
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

    

    


    </div>

    <script src="https://evaluator.ddns.net/jquery-2.1.4.min.js"></script>
    <script src="https://evaluator.ddns.net/bootstrap.min.js"></script>
    </script>
    



</body></html>
<?php } ?>
