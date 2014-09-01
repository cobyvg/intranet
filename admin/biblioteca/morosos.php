<?
session_start();
include("../../config.php");
	if((!(stristr($_SESSION['cargo'],'1') == TRUE)) and (!(stristr($_SESSION['cargo'],'c') == TRUE)) )
{
header("location:http://$dominio/intranet/salir.php");
exit;	
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
<br>
<div class="container">
<div class="row">
<div class="page-header">
  <h2>Biblioteca <small> Edición de morosos</small></h2>
</div>
<br>

<div class="col-sm-6 col-sm-offset-3">
<?
if(isset($_FILES['archivo'])){ 
$archivo = $_FILES['archivo'];
mysql_connect ($db_host, $db_user, $db_pass) or die("Error de conexión");
mysql_select_db($db);
ini_set('auto_detect_line_endings',TRUE);
$handle = fopen ($_FILES['archivo']['tmp_name'] , 'r' ) or die
('<div align="center"><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<legend>ATENCIÓN:</legend>
No se ha podido abrir el archivo exportado. O bien te has olvidado de enviarlo o el archivo está corrompido.
</div></div><br />
<div align="center">
  <input type="button" value="Volver atrás" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
</div>'); 
while (($data1 = fgetcsv($handle, 1000, ";")) !== FALSE) 
{	
	
		$tr_f = explode("/",$data1[4]);
		$fecha_ed = $tr_f[2]."-".$tr_f[1]."-".$tr_f[0];
		$hoy = date('Y-m-d');
	$dup = mysql_query("select * from morosos where curso = '$data1[0]' and apellidos = '$data1[1]' and nombre = '$data1[2]' and ejemplar = '$data1[3]' and devolucion = '$fecha_ed'");
	
	if (mysql_num_rows($dup)==0) {
		$datos1 = mysql_query("INSERT INTO morosos (curso, apellidos, nombre, ejemplar, devolucion, hoy) VALUES ('". $data1[0]. "','". $data1[1]. "','". $data1[2] . "','". $data1[3] ."','". $fecha_ed ."', '".$hoy."')");
	}
	mysql_query("delete from morosos where apellidos = '' and nombre = '' and ejemplar = ''");
}

fclose($handle);
$borrar = mysql_query("delete from morosos where curso = 'ANT' or curso='' or curso='$nombre_del_centro' or curso like 'Abies%'");

?> <div align="center"><div class="alert alert-success alert-block fade in">
			<legend>ATENCI&Oacute;N:</legendh5>
La actualizaci&oacute;n se ha realizado con &eacute;xito. Vuelve atr&aacute;s y compru&eacute;balo.
</div></div><br />
<div align="center">
  <input type="button" value="Volver atr&aacute;s" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
</div>

<?
}?>
</div>
</div>
</div>

<? include("../../pie.php");?>

