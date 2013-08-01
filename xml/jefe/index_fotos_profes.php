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
  <h2>Administración <small> Importación de fotos de los profesores</small></h2>
</div>
<FORM ENCTYPE="multipart/form-data" ACTION="fotos_profes.php" METHOD="post">
<p class="help-block" style="width:600px; text-align:left"><span style="color:#9d261d">(*) </span>Para importar las fotos de todos los profesores, necesitaremos crear un archivo comprimido ( .zip ) conteniendo todos los archivos de fotos de los profesores. Cada archivo de foto tiene como nombre el usuario IdEA de Séneca seguido de la extensión .jpg o .jpeg. El nombre típico de un archivo de foto quedaría por ejemplo así: mgargon732.jpg. Las fotos se colocan en el directorio <em>/xml/fotos_profes/</em></p>
 <br />
  <div class="well well-large" style="width:480px; margin:auto;" align="left">
  <div class="control-group">
       <div class="controls">
        <label class="control-label" for="file">Selecciona el archivo comprimido con las fotos de los profesores</label>
      
    <input type="file" name="archivo" id="file">
  <hr>
  <div align="center">
    <INPUT type="submit" name="enviar" value="Aceptar" class="btn btn-primary">
  </div>
  </div>
  </div>
</div>  
<br />
<div align="center">
  <input type="button" value="Volver atrás" name="boton" onClick="history.back(2)" class="btn btn-success" />
</div>
</FORM>
</body>
</html>
