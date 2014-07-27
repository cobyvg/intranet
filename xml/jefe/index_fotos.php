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
  <h2>Administración <small> Importación de fotos de los alumnos</small></h2>
</div>
<FORM ENCTYPE="multipart/form-data" ACTION="fotos.php" METHOD="post">
 <p class="help-block" style="width:600px; text-align:left"><span style="color:#9d261d">(*) </span>Para importar las fotos de todos los alumnos, necesitaremos crear un archivo comprimido ( .zip ) conteniendo todos los archivos de fotos de los alumnos. Cada archivo de foto tiene como nombre el NIE de Séneca (el Número de Identificación que Séneca asigna a cada alumno ) seguido de la extensión .jpg o .jpeg. El nombre típico de un archivo de foto quedaría por ejemplo así: 1526530.jpg. Las fotos se colocan en el directorio <em>/xml/fotos/</em></p>
 <br />
  <div class="well well-large" style="width:480px; margin:auto;" align="left">
  <div class="form-group">
 
  <br />
      <div class="controls">
        <label class="control-label" for="file">Selecciona el archivo comprimido con las fotos de los alumnos</label>
      
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
