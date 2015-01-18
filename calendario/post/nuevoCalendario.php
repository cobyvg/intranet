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

if (! isset($_POST['cmp_calendario_nombre'])) {
	die("<h1>FORBIDDEN</h1>");
	exit();
}

// Limpiamos variables
$nombre_calendario = htmlspecialchars($_POST['cmp_calendario_nombre'], ENT_QUOTES, 'ISO-8859-1');
$color_calendario = htmlspecialchars($_POST['cmp_calendario_color'], ENT_QUOTES, 'ISO-8859-1');
$fecha_calendario = date('Y-m-d');
$profesor_calendario = htmlspecialchars($_SESSION['profi'], ENT_QUOTES, 'ISO-8859-1');
$publico_calendario = htmlspecialchars($_POST['cmp_calendario_publico'], ENT_QUOTES, 'ISO-8859-1');

if ($publico_calendario == '') $publico_calendario = 0;
else $publico_calendario = 1;

// Comprobamos si existe el calendario
$result = mysqli_query($db_con, "SELECT nombre FROM calendario_categorias WHERE nombre='$nombre_calendario' AND profesor='$profesor_calendario' LIMIT 1");

if (mysqli_num_rows($result)) {
	header('Location:'.'http://'.$dominio.'/intranet/calendario/index.php?error=1');
	exit();
}
else {
	$crear = mysqli_query($db_con, "INSERT INTO calendario_categorias (nombre, fecha, profesor, color, espublico) VALUES ('$nombre_calendario', '$fecha_calendario', '$profesor_calendario', '$color_calendario', $publico_calendario)");
	if (! $crear) {
		header('Location:'.'http://'.$dominio.'/intranet/calendario/index.php?error=2');
		exit();
	}
	else {
		header('Location:'.'http://'.$dominio.'/intranet/calendario/index.php?success=1');
		exit();
	}
}
?>