<?php
session_start();

define('INTRANET_DIRECTORY', __DIR__);
define('CONFIG_FILE', INTRANET_DIRECTORY . '/config.php');
define('VERSION_FILE', INTRANET_DIRECTORY .'/config/version.php');

if (file_exists(CONFIG_FILE)) {
	include_once(CONFIG_FILE);
	include_once(VERSION_FILE);
	include_once(INTRANET_DIRECTORY . '/funciones.php');
	include_once(INTRANET_DIRECTORY . '/simplepie/autoloader.php');
}
else {
	
	if(isset($_SERVER['HTTPS'])) {
	    if ($_SERVER["HTTPS"] == "on") {
	        header('Location:'.'https://'.$_SERVER['SERVER_NAME'].'/intranet/config/index.php');
	        exit();
	    } 
	}
	else {
		header('Location:'.'http://'.$_SERVER['SERVER_NAME'].'/intranet/config/index.php');
		exit();
	}
	
}

// COMPROBAMOS LA SESION
if ($_SESSION['autentificado'] != 1) {
	$_SESSION = array();
	session_destroy();
	
	if(isset($_SERVER['HTTPS']) && $_SERVER["HTTPS"] == "on") {
		header('Location:'.'https://'.$dominio.'/intranet/salir.php');
		exit();
	}
	else {
		header('Location:'.'http://'.$dominio.'/intranet/salir.php');
		exit();
	}
}


if($_SESSION['cambiar_clave']) {
	if(isset($_SERVER['HTTPS']) && $_SERVER["HTTPS"] == "on") {
		header('Location:'.'https://'.$dominio.'/intranet/clave.php');
		exit();
	}
	else {
		header('Location:'.'http://'.$dominio.'/intranet/clave.php');
		exit();
	}
}

registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);