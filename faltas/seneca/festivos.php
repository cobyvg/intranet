<?
session_start();
include("../../config.php");
include_once('../../config/version.php');

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


registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);


if(!(stristr($_SESSION['cargo'],'1') == TRUE))
{
header('Location:'.'http://'.$dominio.'/intranet/salir.php');
exit;	
}
?>
<?php
include("../../menu.php");
include("../menu.php");
?>
<br />
<div align="center">
<div class="page-header">
  <h2>Faltas de Asistencia <small> Días festivos y vacaciones</small></h2>
</div>
<br />
<?
 // Conexión 
$db_con = mysqli_connect($db_host, $db_user, $db_pass);
mysqli_select_db($db_con, $db);

// Borramos datos
mysqli_query($db_con, "truncate table festivos");	

// Importamos los datos del fichero CSV en la tabña alma.
$handle = fopen ($_FILES['archivo']['tmp_name'] , "r" ) or die('
<div align="center"><div class="alert alert-success alert-block fade in" align="left">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
No se ha podido abrir el fichero de importación<br> Asegúrate de que su formato es correcto y no está vacío.
			</div></div><br />	'); 
while (($data1 = fgetcsv($handle, 1000, "|")) !== FALSE) 
{
$tr = explode("/",trim($data1[0]));
$fecha="$tr[2]-$tr[1]-$tr[0]";
$datos1 = "INSERT INTO festivos ( `fecha` , `nombre` , `ambito` , `docentes` ) VALUES (\"". $fecha . "\",\"". trim($data1[1]) . "\",\"". trim($data1[2]) . "\",\"". trim($data1[3]) . "\")";
mysqli_query($db_con, $datos1);
}
fclose($handle);
$borrarvacios = "delete from festivos where date(fecha) = '0000-00-00'";
 mysqli_query($db_con, $borrarvacios);
 if (mysqli_affected_rows() > '0') {
?>
 	<div align="center""><div class="alert alert-success alert-block fade in" align="left">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
	 Los datos se han importado correctamente.
			</div></div><br /> 
			<?
			}
?>
<br />
<input type="button" value="Volver atrás" name="boton" onclick="history.back(2)" />
</div>
</body>
</html>