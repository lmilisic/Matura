<?php
session_start();
$array = get_headers($_SERVER[REQUEST_URI]);
$string = $array[0];
if(isset($_SESSION["loggedin"])){  
    if(strpos($string,"200"))
  {
    header("Location: https://evaluator.ddns.net".$_SERVER[REQUEST_URI]);
  }
  else
  {
    header("Location: https://evaluator.ddns.net/");;
  }  
} else {
    header("Location: https://evaluator.ddns.net/login/?next=".$_SERVER[REQUEST_URI]);
}
?>
