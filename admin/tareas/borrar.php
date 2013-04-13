<?
session_start();
include("../../config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);
?>
<?php
include("../../menu.php");
include("menu.php");
?>
<div align="center">
 <div align="center"><div class="page-header" align="center">
  <h1>Informes de Tareas <small> Borrar Informe</small></h1>
</div>
<br />
<?
$alumno=mysql_query("SELECT APELLIDOS, NOMBRE, NIVEL, GRUPO, profesor, fecha FROM tareas_alumnos WHERE ID='$id_alumno'");
$dalumno = mysql_fetch_array($alumno);
echo "<h3>Borrar informe de Tareas</h3><br />
<h4 align='center'>$dalumno[1] $dalumno[0] ($dalumno[2]-$dalumno[3])<br> Visita: $dalumno[5]<br>Tutor: $dalumno[4]</h4><br />";
if ($del=='1') {
	mysql_query("delete from tareas_profesor where id = '$id_del'");
	if (mysql_affected_rows()>'0') {
		echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El Informe ha sido borrado sin problemas.
		</div></div>';
	}
}
?>
<? include("../../pie.php");?>
</body>
</html>
