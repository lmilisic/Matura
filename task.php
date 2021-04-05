<?php   
session_start();  
$logedInUsername = "";
$logedInName = $_SESSION['name'];
$logedInUsername = $_SESSION['username'];
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$zadatak = $_GET['id'];
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'tasks';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
$pristup = False;
$query = 'SELECT * FROM tasks WHERE id = '.$zadatak;
$result = mysqli_query($con, $query);
if (mysqli_num_rows($result) > 0) {
	while($row = mysqli_fetch_assoc($result))
	{
	    if (strpos($row["access"], $logedInUsername) !== false){
	    	$pristup = True;
	    	$zadatak_category = $row["category"];
	    	$zadatak_access = $row["access"];
	    	$zadatak_name = $row["name"];
	    }
	    if ($row["jelimatura"]==1){
	    	$zadatak_matura = $row["jelimatura"];
	        $zadatak_predmet = $row["predmet"];
	        $zadatak_rok = $row["rok"];
	        $zadatak_razina = $row["razina"];
	        $zadatak_godina = $row["godina"];
	        $zadatak_zadatak = $row["zadatak"];
	        $zadatak_bodovi = $row["bodovi"];
	        $zadatak_attachments = explode("$", $row["attachments"]);
	    }
	}
} else {  
    header("Location: https://evaluator.ddns.net/"); 
}
if(!isset($_SESSION["loggedin"]) && $pristup){  
    header("Location: https://evaluator.ddns.net/login/?next=/task/?id=".$zadatak);  
} 
if(!isset($_SESSION["loggedin"]) && !$pristup){  
    header("Location: https://evaluator.ddns.net/login/?next=/task/?id=".$zadatak); 
}
if(isset($_SESSION["loggedin"]) && !$pristup){  
    header("Location: https://evaluator.ddns.net/"); 
}
if(isset($_SESSION["loggedin"]) && $pristup){  
?>
<!DOCTYPE html>
<html><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title> <?php echo $zadatak_name;?> - Evaluator </title>

    
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
<i class="fa fa-tasks fa-fw"></i> <?php echo $zadatak_name;?>
</h1>
                </div>
                <div class="col-lg-2 col-md-3">
                     
                </div>
            </div>
        </div>
		
			<div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel">
				<div class="modal-dialog modal-lg" role="document">
				    <div class="modal-content">
				        <div class="modal-body"></div>
				    </div>
				</div>
			</div>
			
			
	<div class="row">
        <div class="col-md-6 col-xs-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Details</h3>
                </div>
                <div class="panel-body">
                    <dl class="dl-horizontal" style="margin-bottom:0">
                        <?php
                        if ($zadatak_matura==1){
                        	echo "<dt>Year</dt>";
                        	echo "<dd>".$zadatak_godina."</dd>";
                        	echo "<dt>Season</dt>";
                        	echo "<dd>".$zadatak_rok."</dd>";
                        	echo "<dt>Subject</dt>";
                        	echo "<dd>".$zadatak_predmet."</dd>";
                        	echo "<dt>Level</dt>";
                        	echo "<dd>".$zadatak_razina."</dd>";
                        	echo "<dt>Task number</dt>";
                        	echo "<dd>".$zadatak_zadatak."</dd>";
                        	echo "<dt>Points</dt>";
                        	echo "<dd><strong>".$zadatak_bodovi."</strong></dd>";
                        }
                        
                        ?>
                        
                    </dl>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Statements and attachments</h3>
                </div>
                <div class="list-group">
                    <?php
                    	$i = -1;
                    	$audio = False;
                    	foreach ($zadatak_attachments as &$value) {
                    		$i+=1;
							if ($i%2==0){
								$ime = $value;
								if (strpos($ime,"Školski esej")!==false){
									echo "<a class='list-group-item list-group-item-info'>The following files are part of the essay task.</a>";
								}
								if ((strpos($ime,"Audio track")!==false) && !$audio){
									$audio = True;
									echo "<a class='list-group-item list-group-item-info'>The following files are part of the auditive task.</a>";
								}
							} else{
							    $path_parts = pathinfo($value);
								echo "<a href='".$value."' class='list-group-item'><strong>".$ime."</strong> <em>[.".$path_parts["extension"]."]</em></a>";
							}
						}
                    ?>                                  
                </div>
            </div>

        </div>
        

            
	<div class="col-md-6 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Submit solution</h3>
                </div>
                <div class="panel-body">
                    
                    <form action="/upload/" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="inputSource">Solution file</label>
                            <input type="file" name="source" id="inputSource">
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
	</div>
    </div>
    
    <div class="row">
        <div class="col-xs-12">

        </div>
    </div>
    
    </div>

    <script src="https://evaluator.ddns.net/jquery-2.1.4.min.js"></script>
    <script src="https://evaluator.ddns.net/bootstrap.min.js"></script>
    <script src="https://evaluator.ddns.net/colorizer.js"></script>
    



</body></html>

<?php }?>
