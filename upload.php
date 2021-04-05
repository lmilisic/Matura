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
<?php
$target_dir = "/var/www/evaluator.ddns.net/uploads/";
$target_file = $target_dir.basename($_FILES["source"]["name"]);
echo $target_file;
echo " ";
echo $_FILES["source"]["size"];
echo " ";
echo $_FILES["source"]["tmp_name"];
$uploadOk = 1;

if ($_FILES["source"]["size"] > 500000) {
  $uploadOk = 0;
}
echo " ";
echo $_FILES["source"]["error"];
if ($uploadOk == 1) {
  move_uploaded_file($_FILES["source"]["tmp_name"], $target_file);
}
?>
<?php }?>
