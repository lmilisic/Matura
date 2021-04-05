<?php
session_start();
session_destroy();
header('Location: https://evaluator.ddns.net/login/?next=/');
?>
