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
include("../menu.php");
?>
<br />
<div align="center">
<div class="page-header" align="center">
  <h2>Faltas de Asistencia <small> Actualización de Días Festivos en la localidad</small></h2>
</div>
<br />
<FORM ENCTYPE="multipart/form-data" ACTION="festivos.php" METHOD="post">
<div class="form-group">
 <p class="help-block" style="width:400px; text-align:left"><span style="color:#9d261d">(*) </span>Si has descargado el archivo <strong>200CalEscCent</strong> de Séneca (desde Séneca --> Centro --> Días festivos), puedes continuar con el segundo paso.</p>
  <br />
  <div class="well well-large" style="width:500px; margin:auto;" align="left">
  <div class="controls">
  <label class="control-label" for="file">Selecciona el archivo con los datos de las Fiestas y Vacaciones
  </label>
  <input type="file" name="archivo" class="input input-file col-sm-4" id="file">
  <hr>
  <div align="center">
    <INPUT type="submit" name="enviar" value="Aceptar" class="btn btn-primary">
  </div>
  </div>
  </div>
</FORM>
<br />
</div>
    <? 
include("../../pie.php");
?>
</body>
</html>
