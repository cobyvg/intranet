<?php
session_start();
include("../../config.php");
include_once('../../config/version.php');

$GLOBALS['db_con'] = $db_con;

// COMPROBAMOS LA SESION
if ($_SESSION['autentificado'] != 1) {
	$_SESSION = array();
	session_destroy();
	
	if(isset($_SERVER['HTTPS'])) {
	    if ($_SERVER["HTTPS"] == "on") {
	        header('Location:'.'https://'.$dominio.'/intranet/salir.php');
	        exit();
	    } 
	}
	else {
		header('Location:'.'http://'.$dominio.'/intranet/salir.php');
		exit();
	}
}

if($_SESSION['cambiar_clave']) {
	if(isset($_SERVER['HTTPS'])) {
	    if ($_SERVER["HTTPS"] == "on") {
	        header('Location:'.'https://'.$dominio.'/intranet/clave.php');
	        exit();
	    } 
	}
	else {
		header('Location:'.'http://'.$dominio.'/intranet/clave.php');
		exit();
	}
}

if (! isset($_POST['cmp_evento_id'])) {
	die("<h1>FORBIDDEN</h1>");
	exit();
}

$evento_id = mysqli_escape_string($db_con, $_POST['cmp_evento_id']);

$result = mysqli_query($db_con, "DELETE FROM calendario WHERE id=$evento_id");
if (! $result) {
	header('Location:'.'http://'.$dominio.'/intranet/calendario/index.php');
	exit();
}
else {
	header('Location:'.'http://'.$dominio.'/intranet/calendario/index.php');
	exit();
}
?>