<?php   
session_start();  
$logedInName = $_SESSION['name'];
$logedInUsername = $_SESSION['username'];
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if(!isset($_SESSION["loggedin"])){  
    header("Location: https://evaluator.ddns.net/login/?next=/");  
} else {
?>
<html>
<head></head>
<body>
<?php
$kategorija = $_GET['id'];
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
				$query = 'SELECT id, access, name FROM folders WHERE category = '.$kategorija;
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
				$query = 'SELECT id, access, name, submits_all, submits_successful FROM tasks WHERE category = '.$kategorija;
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
<body>
</html>
<?php }?>
