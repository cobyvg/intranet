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
  <h2>Informes de Tutoría <small> Activar Informe</small></h2>
</div>
<br />
    
 <br /> 
 <?php
if(empty($alumno) or empty($tutor))
{
	echo '<div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<legend>Atención:</legend>
Debes rellenar todos los datos, y parece que te has olvidado del Alumno o del Tutor.<br>Vuelve atrás e inténtalo de nuevo.<br /><br />
<input name="volver" type="button" onClick="history.go(-1)" value="Volver" class="btn btn-inverse">
</div></div><hr>';
exit;
}
#Vamos a rellenar los datos del alumno objeto del informe en la base de datos infotut
$fecha = cambia_fecha($fecha);
$trozos = explode (" --> ", $alumno);
$claveal = $trozos[1];
$nombre_comp = $trozos[0];
$trozos1 = explode (", ", $nombre_comp);
$apellidos = $trozos1[0];
$nombre = $trozos1[1];
$falumno=mysql_query("SELECT CLAVEAL, APELLIDOS, NOMBRE, NIVEL, GRUPO, COMBASI FROM alma WHERE claveal ='$claveal'");
$dalumno = mysql_fetch_array($falumno);
$asignaturas=chunk_split($dalumno[5],3,"-");
$asig=explode("-",$asignaturas);
$hoy = date('Y\-m\-d');

$duplicado = mysql_query("select claveal from infotut_alumno where claveal = '$claveal' and f_entrev = '$fecha'");
if(mysql_num_rows($duplicado)>0)
{
	echo '<div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<legend>Atención:</legend>';
			echo "Ya hay un <b>Informe Tutorial</b> activado para el alumno/a <b> $nombre $apellidos </b>para el día
<b>";
echo formatea_fecha($fecha);
echo "</b>, y no queremos duplicarlo, verdad?";
echo '<br /><br /><input type="button" onClick="history.back(1)" value="Volver" class="btn btn-inverse">
		</div></div>';
exit;
}

 $insertar=mysql_query("INSERT infotut_alumno (CLAVEAL,APELLIDOS,NOMBRE,NIVEL,GRUPO,F_ENTREV,TUTOR,FECHA_REGISTRO)
VALUES ('$dalumno[0]',\"$dalumno[1]\",'$dalumno[2]','$dalumno[3]','$dalumno[4]',
'$fecha','$tutor', '$hoy')") or die ("Error en la activación del informe: " . mysql_error());
 
 echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>';
			echo "El <b>Informe Tutorial</b> del alumno/a <b> $nombre $apellidos </b>para el día <b>";
echo formatea_fecha($fecha);
echo "</b> se ha activado.";
echo '</div><br /><input type="button" onClick="history.back(1)" value="Volver" class="btn btn-inverse">
		</div>';
exit;
?>
</div>
	<? include("../../pie.php");?>								
</body>
</html>
