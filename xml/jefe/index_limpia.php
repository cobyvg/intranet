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
  <h2>Administración <small> Depuración de la tabla de Horarios</small></h2>
</div>
<FORM ENCTYPE="multipart/form-data" ACTION="limpia_hor.php" METHOD="post">

  <div class="control-group">
  <div class="well well-large" style="width:500px; margin:auto;" align="left">
  <div class="controls">
  <p class="help-block" style="text-align:left">La depuración del horario se debe realizar cuando los horarios de los profesores se encuentran en Séneca y han sido completamente revisados. Si consideras que ya no caben más cambios en los horarios, comienza actualizando los profesores con el archivo RelPerCen.txt de Séneca. Una vez actualizados los profesores, puedes proceder a ejecutar esta función, la cual eliminará los elementos del horario generado por Horwin que ya no son necesarios.</p>
  <hr>
  <div align="center">
    <INPUT type="submit" name="enviar" value="Depurar los horarios" class="btn btn-primary btn-block">
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