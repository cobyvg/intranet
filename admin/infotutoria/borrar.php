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
<div class="page-header" align="center">
  <h2>Informes de Tutoría <small> Borrar Informe</small></h2>
</div>
<br />
    
<?
$alumno=mysql_query("SELECT APELLIDOS,NOMBRE,NIVEL,GRUPO,TUTOR, F_ENTREV FROM infotut_alumno WHERE ID='$id_alumno'");
$dalumno = mysql_fetch_array($alumno);
echo "
<h4 align='center'>$dalumno[1] $dalumno[0] ($dalumno[2]-$dalumno[3])<br> Visita: $dalumno[5]<br>Tutor: $dalumno[4]</h4><br />";
if ($del=='1') {
	mysql_query("delete from infotut_profesor where id = '$id_del'");
	if (mysql_affected_rows()>'0') {
		echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El Informe ha sido borrado sin problemas.
		</div></div>';
	}
}
$datos=mysql_query("SELECT asignatura, informe, id FROM infotut_profesor WHERE id_alumno='$id_alumno'");
if(mysql_num_rows($datos) > 0)
{
echo "<table class='table table-striped' align='center' style='width:700px;'>";
while($informe = mysql_fetch_array($datos))
{
$fondo = "";
if($informe[0] == $asignatura){$fondo="background-color:#FFFF66;";}
	echo "<tr><td style='color:black;$fondo'>$informe[0]</td>
		  <td style='$fondo'>$informe[1]</td>";
	if (strlen($fondo) > '0') {
		echo "<td><a href='borrar.php?del=1&id_del=$informe[2]&id_alumno=$id_alumno&asignatura=$asignatura&profesor=$profesor'><i class='fa fa-trash-o' title='Borrar'> </i> </a></td>";
	}
	echo"</tr>";
}
echo"</table>";
}
echo "</div>";
?>
<? include("../../pie.php");?>
</body>
</html>
