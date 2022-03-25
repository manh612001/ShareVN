<?php
require_once('./utils/utility.php');
require_once('./database/dbhelper.php');

session_start();

setcookie('Id','',time(),'/');
session_destroy();
header('Location:login.php');
?>