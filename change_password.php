<?php   
session_start();  
$logedInName = $_SESSION['name'];
$logedInUsername = $_SESSION['username'];
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if(!isset($_SESSION["loggedin"])){  
    header("Location: https://evaluator.ddns.net/login/?next=/change_password/");  
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

    <title> Change password - Evaluator </title>

    
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
<i class="fa fa-key fa-fw"></i> Change password
</h1>
                </div>
                <div class="col-lg-2 col-md-3">
                     
                </div>
            </div>
        </div>
	<?php
        $passo = $pass1 = $pass2 = "";
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		function test_input($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}
		
		if ( !isset($_POST["password_new1"], $_POST["password_new2"], $_POST["password_old"]) || ( (strlen($_POST['password_new1'])==0) || (strlen($_POST['password_new2'])==0) || (strlen($_POST['password_old'])==0))) {
			echo '<div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <strong>Error!</strong> Incorrect password!
    </div>';
		}else{
			$passo = test_input($_POST["password_old"]);
			$pass1 = test_input($_POST["password_new1"]);
			$pass2 = test_input($_POST["password_new2"]);
		
		
		
		if (($pass1==$pass2) && !($pass1==$passo)){
		
		$DATABASE_HOST = 'localhost';
		$DATABASE_USER = 'root';
		$DATABASE_PASS = '';
		$DATABASE_NAME = 'phplogin';
		$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
		
		if ( mysqli_connect_errno() ) {
			echo '<div class="alert alert-danger alert-dismissible" role="alert">
        		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        		<strong>Error!</strong> Could not connect to MySQL!
    			</div>';
		}
		
		if ($stmt = $con->prepare('SELECT id, password, name FROM accounts WHERE username = ?')) {
			$stmt->bind_param('s', $logedInUsername);
			$stmt->execute();
			$stmt->store_result();
		if ($stmt->num_rows > 0) {
			$stmt->bind_result($id, $password, $name);
			$stmt->fetch();
			$stmt->close();
		}

			if (password_verify($passo, $password)) {
				$DATABASE_HOST = 'localhost';
				$DATABASE_USER = 'root';
				$DATABASE_PASS = '';
				$DATABASE_NAME = 'phplogin';
				$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
				
				if ( mysqli_connect_errno() ) {
					echo '<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
			<strong>Error!</strong> Could not connect to MySQL!
		    </div>';
				}
				
				if ($stmt = $con->prepare('UPDATE accounts SET password = ? WHERE username = ?')) {
				$newpasss = password_hash($pass2, PASSWORD_DEFAULT);
				$stmt->bind_param('ss', $newpasss, $logedInUsername);
				$stmt->execute();
				$stmt->close();
				}
				
			} else {
				echo '<div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <strong>Error!</strong> Old password not correct!
    </div>';
			}
		}		
		} else {
		    echo '<div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <strong>Error!</strong> Passwords don\'t match or your new password must be different from old password!
    </div>';
		}
		}
        }
    	?>

    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Enter your credentials</h3>
                </div>
                <div class="panel-body">
                    <form role = "form" 
            action = "<?php echo htmlspecialchars(str_replace(".php","/",$_SERVER['PHP_SELF'])); 
            ?>" method = "POST">
                        <div class="form-group">
                            <input class="form-control" type="password" name="password_old" placeholder="Old password" autofocus="" value="">
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="password" name="password_new1" placeholder="New password" value="">
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="password" name="password_new2" placeholder="New password" value="">
                        </div>
                        <button type="submit" class="btn btn-lg btn-success btn-block">Change password!</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    </div>

    <script src="https://evaluator.ddns.net/jquery-2.1.4.min.js"></script>
    <script src="https://evaluator.ddns.net/bootstrap.min.js"></script>
    </script>
    



</body></html>

<?php }?>
