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
$profe = $_SESSION['profi'];
if(!(stristr($_SESSION['cargo'],'1') == TRUE))
{
header("location:http://$dominio/intranet/salir.php");
exit;	
}
?>
<?php
include("../../menu.php");
?>
<div align="center">
<div class="page-header" align="center" style="margin-top:-15px;">
  <h1>Administración <small> Creación de la tabla de alumnos</small></h1>
</div>
<br />
<FORM ENCTYPE="multipart/form-data" ACTION="almafaltas.php" METHOD="post">
  <div class="control-group success"><p class="help-block" style="width:400px; text-align:left"><span style="color:#9d261d">(*) </span>Si has descargado los archivos de Evaluaci&oacute;n y el fichero RegAlum.tx exportados desde S&Eacute;NECAt, puedes continuar con el segundo paso.</p></div><br />
  <div class="well-2 well-large" style="width:500px; margin:auto;" align="left">
  <h6>Selecciona el archivo <span style="color:#9d261d">RegAlum.txt:</span><br />
  </h6>
  <input type="file" name="archivo1" class="input input-file span4">
  <hr>
  <h6> Selecciona el archivo comprimido <span style="color:#9d261d">Exportacion_de_Calificaciones.zip:</span><br />
    <input type="file" name="archivo2" class="input input-file span4">
  </h6>
  <hr>
  <div align="center">
    <INPUT type="submit" name="enviar" value="Aceptar" class="btn btn-primary">
  </div>
</FORM>
<br />
<div align="center">
  <input type="button" value="Volver atrás" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
</div>
</body>
</html>
