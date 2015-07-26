<?php
session_start();

error_reporting(0);

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


// Ver como usuario
if($_SESSION['profi'] == 'admin') $_SESSION['user_admin'] = 1;
if(isset($_SESSION['user_admin']) && isset($_POST['view_as_user'])) {
	$_SESSION['profi'] = $_POST['view_as_user'];
	$profe = $_SESSION['profi'];
	
	// Variables de sesión del cargo del Profesor
	$cargo0 = mysqli_query($db_con, "select cargo, departamento, idea from departamentos where nombre = '$profe'" );
	$cargo1 = mysqli_fetch_array ( $cargo0 );
	$_SESSION ['cargo'] = $cargo1 [0];
	$carg = $_SESSION ['cargo'];
	$_SESSION ['dpt'] = $cargo1 [1];
	if (isset($_POST['idea'])) {}
	else{
	$_SESSION ['ide'] = $cargo1 [2];
	}
		
	// Si es tutor
	if (stristr ( $_SESSION ['cargo'], '2' ) == TRUE) {
		$result = mysqli_query($db_con, "select distinct unidad from FTUTORES where tutor = '$profe'" );
		$row = mysqli_fetch_array ( $result );
		$_SESSION ['mod_tutoria']['tutor'] = $profe;
		$_SESSION ['mod_tutoria']['unidad'] = $row [0];
	}

	// Si tiene Horario
	$cur0 = mysqli_query($db_con, "SELECT distinct prof FROM horw where prof = '$profe'" );
	$cur1 = mysqli_num_rows ( $cur0 );
	$_SESSION ['n_cursos'] = $cur1;
	
	// Si tiene tema personalizado
	$res = mysqli_query($db_con, "select distinct tema, fondo from temas where idea = '".$_SESSION ['ide']."'" );
	if (mysqli_num_rows($res)>0) {
		$ro = mysqli_fetch_array ( $res );
		$_SESSION ['tema'] = $ro[0];
		$_SESSION ['fondo'] = $ro[1];
	}
	else{
		$_SESSION ['tema']="bootstrap.min.css";
		$_SESSION ['fondo'] = "navbar-default";
	}
	
}