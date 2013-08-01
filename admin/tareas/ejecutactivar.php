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
<?
 include("../../menu.php");
 include("menu.php");
?>
<div align="center">
<div class="page-header" align="center">
  <h2>Informes de Tareas <small> Informes por expulsión</small></h2>
</div>
<br />
          
<?
if(empty($alumno) or empty($tutor))
{
	echo '<br /><div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
Debes rellenar todos los datos, y parece que te has olvidado del Alumno o del Tutor.<br>Vuelve atrás e inténtalo de nuevo.<br /><br />
<input name="volver" type="button" onClick="history.go(-1)" value="Volver" class="btn btn-danger">
</div></div><hr>';
exit;
}
?>
  <?php
#Vamos a rellenar los datos del alumno objeto del informe en la base de datos infotut
$alumno=$_POST['alumno'];
$tutor=$_POST['tutor'];
$duracion=$_POST['duracion'];
$duracion2 = $duracion + 1;
foreach ($_POST['fecha'] as $valor){
$date[]=$valor;
}

$fecha=$date[2]."-".$date[1]."-".$date[0];

$trozos = explode (" --> ", $alumno);
$claveal = $trozos[1];
$nombre_comp = $trozos[0];
$trozos1 = explode (", ", $nombre_comp);
$apellidos = $trozos1[0];
$nombre = $trozos1[1];
$falumno=mysql_query("SELECT CLAVEAL, APELLIDOS, NOMBRE, NIVEL, GRUPO,
COMBASI FROM alma WHERE claveal = '$claveal'");
$dalumno = mysql_fetch_array($falumno);
$asignaturas=chunk_split($dalumno[5],3,"-");
$asig=explode("-",$asignaturas);

$duplicado = mysql_query("select claveal from tareas_alumnos where claveal = '$dalumno[0]' and fecha = '$fecha'");
if(mysql_num_rows($duplicado)>0)
{
	echo '<br /><div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>';
			echo "Ya hay un <b>Informe de Tareas</b> activado para el alumno/a <b> $nombre $apellidos </b>para el día
<b>$date[0] del $date[1] de $date[2]</b>, y no queremos duplicarlo, verdad?";
echo '<br /><br /><input type="button" onClick="history.back(1)" value="Volver" class="btn btn-danger">
		</div></div>';
}
else{
$insertar=mysql_query("INSERT tareas_alumnos (CLAVEAL,APELLIDOS,NOMBRE,NIVEL,GRUPO,FECHA,DURACION,PROFESOR,FIN)
 VALUES ('$dalumno[0]','$dalumno[1]','$dalumno[2]','$dalumno[3]','$dalumno[4]',
 '$fecha',$duracion,'$tutor',date_add('$fecha',interval $duracion2 day))") or die ("Error, no se ha podido activar el informe:".mysql_error());
  echo '<br /><div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>';
			echo "El <b>Informe de tareas</b> del alumno/a <b> $nombre $apellidos </b>para el día<b>
$date[0] del $date[1] de $date[2]</b> se ha activado correctamente.";
echo '<br /><br /><input type="button" onClick="history.back(1)" value="Volver" class="btn btn-success">
		</div></div>';
}
mysql_close();
?>
</div>
	<? include("../../pie.php");?>								
</body>
</html>
