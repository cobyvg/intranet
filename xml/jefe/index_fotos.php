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
  <h1>Administración <small> Importación de fotos de los alumnos</small></h1>
</div>
<br />
<FORM ENCTYPE="multipart/form-data" ACTION="fotos.php" METHOD="post">
  <div class="well-2 well-large" style="width:480px; margin:auto;" align="left">
  <h5><small>Selecciona el archivo comprimido con las fotos de los alumnos</small></h5><br />
    <input type="file" name="archivo">
  
  <hr>
  <div align="center">
    <INPUT type="submit" name="enviar" value="Aceptar" class="btn btn-primary">
  </div>
</FORM>
</div>
</body>
</html>
