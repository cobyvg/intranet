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
  <h2>Administración <small> Actualización de la tabla de Departamentos</small></h2>
</div>
<FORM ENCTYPE="multipart/form-data" ACTION="departamentos.php" METHOD="post">

  <div class="control-group">
 <p class="help-block" style="width:400px; text-align:left"><span style="color:#9d261d">(*) </span>Si has descargado el archivo RelPerCen.txt de Séneca (desde Personal --> Personal del Centro), puedes continuar con el segundo paso.</p>
  <br />
  <div class="well well-large" style="width:500px; margin:auto;" align="left">
  <div class="controls">
  <label class="control-label" for="file">Selecciona el archivo con los datos de los Departamentos
  </label>
  <input type="file" name="archivo" class="input input-file span4" id="file">
  <hr>
  <div align="center">
    <INPUT type="submit" name="actualizar" value="Actualizar" class="btn btn-primary">
  </div>
  </div>
  </div>

</FORM>
<br />
<div align="center">
  <input type="button" value="Volver atrás" name="boton" onClick="history.back(2)" class="btn btn-success" />
</div>
</div>
</body>
</html>
