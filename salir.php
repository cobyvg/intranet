<?php 
session_start(); 
include("config.php");
$_SESSION = array(); 
session_destroy();
header("Location: index.php");
?> 
 
direct = "";
if (strstr($_SERVER['HTTP_REFERER'],"index0.php")==FALSE and strstr($_SERVER['HTTP_REFERER'],$dominio)==true) {
	$redirect = "?redir=".$_SERVER['HTTP_REFERER']."&profe_reg=".$profe_reg;
}
header("Location: index.php$redirect");
?> 
