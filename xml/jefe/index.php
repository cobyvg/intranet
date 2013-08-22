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
<br />
<div align="center">
<div class="page-header" align="center">
  <h2>Administración <small> Actualización de la tabla de alumnos</small></h2>
</div>

<FORM ENCTYPE="multipart/form-data" ACTION="alma.php" METHOD="post">
  <div class="control-group">
  <p class="help-block" style="width:400px; text-align:left"><span style="color:#9d261d">(*) </span>Si has descargado los archivos de Evaluaci&oacute;n y el fichero RegAlum.txt exportados desde S&Eacute;NECA, puedes continuar con el segundo paso.</p>
  <br />
  <div class="well well-large" style="width:500px; margin:auto;" align="left">
      <div class="controls">
  <label class="control-label" for="file1">Selecciona el archivo <span style="color:#9d261d">RegAlum.txt:</span>
  </label>
  <input type="file" name="archivo1" class="input input-file span4" id="file1">
  <hr>
  <label class="control-label" for="file2"> Selecciona el archivo comprimido <span style="color:#9d261d">Exportacion_de_Calificaciones.zip:</span><br />
    </label>
    <input type="file" name="archivo2" id="file2" class="input input-file span4">
  <hr>
  <div align="center">
    <INPUT type="submit" name="enviar" value="Aceptar" class="btn btn-primary">
  </div>
  </div>
  </div>
</FORM>
<br />
<div align="center">
  <input type="button" value="Volver atrás" name="boton" onClick="history.back(2)" class="btn btn-success" />
</div>
</body>
</html>
