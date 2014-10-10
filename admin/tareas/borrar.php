<?
session_start();
include("../../config.php");
include_once('../../config/version.php');

// COMPROBAMOS LA SESION
if ($_SESSION['autentificado'] != 1) {
	$_SESSION = array();
	session_destroy();
	header('Location:'.'http://'.$dominio.'/intranet/salir.php');	
	exit();
}

if($_SESSION['cambiar_clave']) {
	header('Location:'.'http://'.$dominio.'/intranet/clave.php');
}

registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);


?>
<?php
include("../../menu.php");
include("menu.php");
?>
<div align="center">
 <div align="center"><div class="page-header">
  <h2>Informes de Tareas <small> Borrar Informe</small></h2>
</div>
<br />
<?
$alumno=mysqli_query($db_con, "SELECT APELLIDOS, NOMBRE, unidad, id, profesor, fecha FROM tareas_alumnos WHERE ID='$id_alumno'");
$dalumno = mysqli_fetch_array($alumno);
echo "
<h4 align='center'>$dalumno[1] $dalumno[0] ($dalumno[2])<br> Visita: $dalumno[5]<br>Tutor: $dalumno[4]</h4><br />";
if ($del=='1') {
	mysqli_query($db_con, "delete from tareas_profesor where id = '$id_del'");
	if (mysqli_affected_rows()>'0') {
		echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El Informe ha sido borrado sin problemas.
		</div></div>';
	}
}
?>
<? include("../../pie.php");?>
</body>
</html>
