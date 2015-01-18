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

if (! isset($_POST['cmp_nombre'])) {
	die("<h1>FORBIDDEN</h1>");
	exit();
}

// Limpiamos variables
$nombre_evento = mysqli_real_escape_string($db_con, $_POST['cmp_nombre']);
$fechaini_evento = mysqli_real_escape_string($db_con, $_POST['cmp_fecha_ini']);
$horaini_evento = mysqli_real_escape_string($db_con, $_POST['cmp_hora_ini']);
$fechafin_evento = mysqli_real_escape_string($db_con, $_POST['cmp_fecha_fin']);
$horafin_evento = mysqli_real_escape_string($db_con, $_POST['cmp_hora_fin']);
$descripcion_evento = mysqli_real_escape_string($db_con, $_POST['cmp_descripcion']);
$lugar_evento = mysqli_real_escape_string($db_con, $_POST['cmp_lugar']);
$calendario_evento = mysqli_real_escape_string($db_con, $_POST['cmp_calendario']);
$departamento_evento = mysqli_real_escape_string($db_con, $_POST['cmp_departamento']);
$profesores_evento = mysqli_real_escape_string($db_con, $_POST['cmp_profesores']);
$unidades_evento = mysqli_real_escape_string($db_con, $_POST['cmp_unidades']);
$profesorreg_evento = mysqli_real_escape_string($db_con, $_SESSION['ide']);
$fechareg_evento = date('Y-m-d');

$exp_fechaini_evento = explode('/', $fechaini_evento);
$fechaini_evento_sql = $exp_fechaini_evento[2].'-'.$exp_fechaini_evento[1].'-'.$exp_fechaini_evento[0];

$exp_fechafin_evento = explode('/', $fechafin_evento);
$fechafin_evento_sql = $exp_fechafin_evento[2].'-'.$exp_fechafin_evento[1].'-'.$exp_fechafin_evento[0];

// Comprobamos si existe el calendario
$result = mysqli_query($db_con, "SELECT nombre FROM calendario WHERE nombre='$nombre_evento' AND fechaini='$fechaini_evento_sql' AND horaini='$horaini_evento' fechafin='$fechafin_evento_sql' AND horafin='$horafin_evento' AND calendario_evento='$calendario_evento' LIMIT 1");

if (mysqli_num_rows($result)) {
	header('Location:'.'http://'.$dominio.'/intranet/calendario/index.php');
	exit();
}
else {
	$crear = mysqli_query($db_con, "INSERT INTO calendario (categoria, nombre, descripcion, fechaini, horaini, fechafin, horafin, lugar, departamento, profesores, unidades, fechareg, profesorreg) VALUES ($calendario_evento, '$nombre_evento', '$descripcion_evento', '$fechaini_evento_sql', '$horaini_evento', $fechafin_evento_sql, '$fechafin_evento_sql', '$lugar_evento', '$departamento_evento', '$profesores_evento', '$unidades_evento' , '$fechareg_evento', '$profesorreg_evento')") or die (mysqli_error($db_con));
	if (! $crear) {
		header('Location:'.'http://'.$dominio.'/intranet/calendario/index.php');
		exit();
	}
	else {
		header('Location:'.'http://'.$dominio.'/intranet/calendario/index.php');
		exit();
	}
}
?>