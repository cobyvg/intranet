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
<div class="page-header" align="center">
  <h1>Faltas de Asistencia <small> Actualizar datos de Séneca</small></h1>
<br />
<?
if ($_POST['enviar']=="Aceptar") {
	// Eliminamos archivos antiguos si existieran.
	$d = dir("origen/");
     while($entry=$d->read()) {
     $nombre=$entry;

$ruta = "origen/".$nombre;
unlink($ruta);
     }
     $d->close();
     
	//Descomprimimos el archivo .zip con la fotos
include('../../lib/pclzip.lib.php');   
$archive = new PclZip($_FILES['archivo']['tmp_name']);  
      if ($archive->extract(PCLZIP_OPT_PATH, 'origen/') == 0) 
	  {
        die('<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
Ha surgido un problema al importar los archivos descargados desde Séneca. Parece que el directorio donde deben ser subidas no existe o no se puede escribir en él. Comprueba que el directorio <em>/intranet/faltas/seneca/origen</em> existe y es posible escribir en él, e inténtalo de nuevo.
</div></div><br />'.$archive->errorInfo(true));
      }  
      else{
      	echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Los archivos han sido actualizados en el directorio <em>/intranet/faltas/seneca/origen/</em>. Es seguro crear los archivos para subir las faltas a Séneca.
</div></div><br />';
      }   
}
?>
<FORM ENCTYPE="multipart/form-data" ACTION="subir.php" METHOD="post">
  <div class="well-2 well-large" style="width:480px; margin:auto;" align="left">
  <p class="text-info">
  Si el módulo de faltas de asistencia está operativo, es necesario descargar desde Séneca el archivo que se utilizará como base para posteriormente subir las faltas. Se descarga de Seneca desde &quot;Intercambio de Informacion --&gt; Exportacion desde Seneca --&gt; Exportacion de Faltas de Asistencia del Alumnado&quot;. Arriba a la derecha hay un icono para crear un nuevo documento con los datos de las faltas; seleccionar el día actual como comienzo y final; seleccionar todos los grupos del Centro y añadirlos a la lista. Cuando hayais terminado, haced click en el icono de confirmación y al cabo de un minuto volved a la página de exportación de faltas de asitencia y veréis que se ha generado un archivo comprimido que podéis descargaros. Es conveniente actualizar los archivos de vez en cuando.
  </p>
  <h5><small>Selecciona el archivo comprimido con los datos de las faltas de asistencia de los alumnos que has descargado desde Séneca</small></h5><br />
    <input type="file" name="archivo">
  
  <hr>
  <div align="center">
    <INPUT type="submit" name="enviar" value="Aceptar" class="btn btn-primary">
  </div>
</FORM>
</div>
</body>
</html>
