<?php   
session_start();  
$logedInName = $_SESSION['name'];
$logedInUsername = $_SESSION['username'];
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if(!isset($_SESSION["loggedin"])){  
    header("Location: https://evaluator.ddns.net/login/?next=/tasks/");  
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

    <title> Tasks - Evaluator </title>

    
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
<i class="fa fa-tasks fa-fw"></i> Tasks
</h1>
                </div>
                <div class="col-lg-2 col-md-3">
                     
                </div>
            </div>
        </div>
        
    <div class="panel panel-default category-list-container">
        <div class="panel-body">
            <ul class="category-list">
            
            	<?php
            	$DATABASE_HOST = 'localhost';
				$DATABASE_USER = 'root';
				$DATABASE_PASS = '';
				$DATABASE_NAME = 'tasks';
				$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
            	
            	if ( mysqli_connect_errno() ) {
					echo '<div class="alert alert-danger alert-dismissible" role="alert">
        			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        			<strong>Error!</strong> Could not connect to MySQL!
    				</div>';
				}
				$pristup = False;
				$query = 'SELECT id, access, name FROM folders WHERE category = 1';
				$result = mysqli_query($con, $query);
				if (mysqli_num_rows($result) > 0) {
					while($row = mysqli_fetch_assoc($result))
					{
					    if (strpos($row["access"], $logedInUsername) !== false){
					    	$pristup = True;
					    	echo "<li><a onclick='toggleCat(".$row["id"].")'><i class='fa fa-folder fa-fw'></i> ".$row["name"]."</a><ul id='cat".$row["id"]."' class='category-list' style='display: none;'><li><i class='fa fa-refresh fa-spin'></i></li></ul></li>";
					    }
					}

				}
				$query = 'SELECT id, access, name, submits_all, submits_successful FROM tasks WHERE category = 1';
				$result = mysqli_query($con, $query);
				if (mysqli_num_rows($result) > 0) {
					while($row = mysqli_fetch_assoc($result))
					{
					    if (strpos($row["access"], $logedInUsername) !== false){
					    	$pristup = True;
					    	if ($row["submits_all"]==0){
					    		echo "<li><a href='/task/?id=".$row["id"]."'><i class='fa fa-file-o fa-fw'></i> ".$row["name"]."</a></li>";
					    	} else {
					    		echo "<li><a href='/task/?id=".$row["id"]."'><i class='fa fa-file-o fa-fw'></i> ".$row["name"]."</a><small>".(($row["submits_successful"]/$row["submits_all"])*100)."% (".$row["submits_successful"]."/".$row["submits_all"].")</small></li>";
					    	}
					    	
					    }
					}

				}
				if (!$pristup){
					echo "<em>(empty)</em>";
				}
            	?>
            	
            </ul>
        </div>
    </div>


    </div>

    <script src="https://evaluator.ddns.net/jquery-2.1.4.min.js"></script>
    <script src="https://evaluator.ddns.net/bootstrap.min.js"></script>
    <script>
    function loadCat(cat_id){
        cat_id = cat_id.toString();
        $.ajax({
            url: "/cat/?id=" + cat_id,
            type: "GET",
            dataType: "html"
        }).done( function( data ){
            $('#cat' + cat_id ).html(data);
            $('#cat' + cat_id + ' ul').each(function(){
                $(this).data( "loaded", false );
                $(this).hide();
            });
        }).fail( function(){
            $( '#category_' + cat_id ).html(
                "<button class='btn btn-default' onclick='load_me(" + cat_id + ");'>Retry</button>"
            );
        });
    }

    function toggleCat(cat_id){
        var ul = $("#cat" + cat_id);
        if(!ul.data("loaded")){
            ul.data("loaded", true);
            loadCat(cat_id);
        }
        ul.toggle();
    }

    $(document).ready(function() {
         $(".category-list ul").hide(); 
        $(".category-list").each(function(){
            $(this).data("loaded", false);
        });
    });
    </script>
</body></html>

<?php }?>
