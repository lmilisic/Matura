<!DOCTYPE html>
<html><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title> Login - Evaluator </title>

    
    <link href="https://evaluator.ddns.net/bootstrap.min.css" rel="stylesheet">
    <link href="https://evaluator.ddns.net/font-awesome.min.css" rel="stylesheet">
    <link href="https://evaluator.ddns.net/evaluator_style.css" rel="stylesheet">
    <link href="https://evaluator.ddns.net/favicon.ico" rel="shortcut icon">

     
     
</head>

<body>

    

    <div class="container">

        <div class="page-header">
            <div class="row">
                <div class="col-lg-10 col-md-9">
                    <h1>
<i class="fa fa-gears fa-fw"></i> Evaluator
</h1>
                </div>
                <div class="col-lg-2 col-md-3">
                     
                </div>
            </div>
        </div>

        
        
    <div class = "container form-signin">
	 <?php
	session_start();
	if(isset($_SESSION["loggedin"])){  
	    header("Location: https://evaluator.ddns.net/");  
	}
	$user = $pass = $next = "";
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		function test_input($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}
		if ( !isset($_POST['user'], $_POST['pass']) || ((strlen($_POST['user'])==0) || (strlen($_POST['pass'])==0))) {
			echo '<div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <strong>Error!</strong> Incorrect username and/or password!
    </div>';
		}else{
			$user = test_input($_POST["user"]);
			$pass = test_input($_POST["pass"]);
			$next = test_input($_POST["next"]);
		}
		session_start();
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
		$stmt->bind_param('s', $user);
		$stmt->execute();
		$stmt->store_result();
		if ($stmt->num_rows > 0) {
		$stmt->bind_result($id, $password, $name);
		$stmt->fetch();
			if (password_verify($pass, $password)) {
				session_regenerate_id();
				$_SESSION['loggedin'] = TRUE;
				$_SESSION['username'] = $user;
				$_SESSION['name'] = $name;
				$_SESSION['id'] = $id;
				header("Location: https://evaluator.ddns.net".$next);
			} else {
				echo '<div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <strong>Error!</strong> Incorrect username and/or apassword!
    </div>';
			}
		} else {
			echo '<div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <strong>Error!</strong> Incorrect username and/or password!
    </div>';
		}
		$stmt->close();
		}
	}
	?> 
    </div> <!-- /container -->

    

    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Please log in</h3>
                </div>
                <div class="panel-body">
                    <form class = "form-signin" role = "form" 
            action = "<?php echo htmlspecialchars(str_replace(".php","/",$_SERVER['PHP_SELF'])); 
            ?>" method = "POST">
                        <input type="hidden" name="next" value="<?php echo htmlspecialchars($_GET["next"])?>">
                        <div class="form-group">
                            <input class="form-control" placeholder="Username" name="user" type="text" autofocus="">
                        </div>
                        <div class="form-group">
                            <input class="form-control" placeholder="Password" name="pass" type="password" value="">
                        </div>
                        <button type="submit" class="btn btn-lg btn-success btn-block">Login</button>
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
