<?
session_start();
include("../../../config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);
$profe = $_SESSION['profi'];
if(!(stristr($_SESSION['cargo'],'1') == TRUE))
{
header("location:http://$dominio/intranet/salir.php");
exit;	
}
?>
<?php
include("../../../menu.php");
?>
<div align="center">
<div class="page-header" align="center" style="margin-top:-15px;">
  <h1>Administración <small> Restaurar la Base de Datos</small></h1>
</div>
<br />
<form enctype="multipart/form-data" action="restore_db.php" method="post" class="form-vertical">
  <div class="control-group success"><p class="help-block" style="width:400px; text-align:left"><span style="color:#9d261d">(*) </span>Si dispones de una copia de seguridad de la base de datos puedes realizar su restauración. Recuerda que los datos actuales se eliminarán. Una vez enviado el archivo el proceso tardará unos segundos, ten paciencia.</p></div><br />
  <div class="well-2 well-large" style="width:600px; margin:auto;" align="left">
				<div class="control-group">
				<p class="lead">Archivo de datos:</p>
				<div class="controls">
				<input name="archivo" id='archivo' type="file" />
				</div>
				</div>
<br />
<div align="center">
<input class='btn btn-primary btn-large' type="submit" name="enviar" value="Aceptar" />
</div>
</FORM>
