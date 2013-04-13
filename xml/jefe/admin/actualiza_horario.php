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
<div class="page-header" align="center">
  <h1>Administración <small> Actualización de Horarios y Profesores</small></h1>
</div>
<br />
<FORM ENCTYPE="multipart/form-data" ACTION="horarios.php" METHOD="post">
  <div class="control-group success"><p class="help-block" style="width:500px; text-align:left"><span style="color:#9d261d">(*) </span>El archivo que se debe importar se obtiene de HORW exportando los datos en formato DEL como muestra la imagen de abajo. El Horario se extrae de Horw incluyendo todos los datos del mismo, y lo utilizan los m&oacute;dulos que presentan Horarios de Profesores y Grupos.</p></div><br />
  <div class="well-2 well-large" style="width:500px; margin:auto;" align="left">
  <h6>Selecciona el archivo con los datos<br />
  </h6>
  <input type="file" name="archivo" class="input input-file span4">
  <hr>
  <div align="center">
    <INPUT type="submit" name="enviar" value="Aceptar" class="btn btn-primary">
  </div>
  <INPUT type="hidden" name="actualizar" value="1">
</FORM>
</div>
<br>
<img border="0" src="exporta_horw.jpg" width="466" height="478">
<br /><br />
<div align="center">
  <input type="button" value="Volver atrás" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
</div>
</body>
</html>