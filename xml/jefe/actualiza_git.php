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
<h2>Actualización de la Intranet.</h2>
<br />
<br />
<?
if ($enviar) {
	// Importamos los datos del fichero comprimido.
	include('../../lib/pclzip.lib.php');   
	$archive = new PclZip($_FILES['archivo']['tmp_name']);  
      if ($archive->extract(PCLZIP_OPT_PATH, '/opt/e-smith/html/') == 0) 
	  {
        die("Error al descomprimir el archivo comprimido : ".$archive->errorInfo(true));
      }  
}
?>
<FORM ENCTYPE="multipart/form-data" ACTION="actualiza_git.php" METHOD="post">
  <div class="control-group success"><p class="help-block" style="width:400px; text-align:left"><span style="color:#9d261d">(*) </span>Si has descargado el archivo comprimido del repositorio de GitHub, puedes proceder a actualizar la Intranet. Si has personalizado algún archivo o módulo, no te olvides hacer una copia de seguridad desde la que puedas restaurarlo posteriormente. En cualquier caso, haz una copia de seguridad...</p></div><br />
  <div class="well-2 well-large" style="width:500px; margin:auto;" align="left">
  <h6>Selecciona el archivo comprimido.<br />
  </h6>
  <input type="file" name="archivo" class="input input-file span4">
  <hr>
  <div align="center">
    <INPUT type="submit" name="enviar" value="Actualizar" class="btn btn-primary">
  </div>
</FORM>
<br />
<div align="center">
  <input type="button" value="Volver atrás" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
</div>
</div>
</body>
</html>
