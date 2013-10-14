<?
include("../../config.php");
if (isset($_POST['enviar'])) {	
$exporta='../pendientes';
mysql_query("CREATE TABLE IF NOT EXISTS pendientes (
  id int(11) NOT NULL auto_increment,
  claveal varchar(9) collate latin1_spanish_ci NOT NULL default '',
  codigo varchar(8) collate latin1_spanish_ci NOT NULL default '',
  PRIMARY KEY  (id),
  KEY  claveal (claveal),
  KEY codigo (codigo)
) DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1");
//echo $exporta;
// Descomprimimos el zip de las calificaciones en el directorio exporta/
include('../../lib/pclzip.lib.php');   
$archive = new PclZip($_FILES['archivo2']['tmp_name']);  
      if ($archive->extract(PCLZIP_OPT_PATH,$exporta) == 0) 
	  {
        die('<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCI�N:</h5>
No se ha podido abrir el archivo comprimido con las Calificaciones. O bien te has olvidado de enviarlo o el archivo est� corrompido.
</div></div><br />
<div align="center">
  <input type="button" value="Volver atr�s" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
</div>'); 
      }  
	  
header("location:http://$dominio/intranet/xml/jefe/pendientes.php?directorio=$exporta");  	  
exit;	
}
?>
<?
session_start();
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
  <h2>Administraci�n <small> Importaci�n de alumnos con asignaturas pendientes</small></h2>
</div>
<FORM ENCTYPE="multipart/form-data" ACTION="index_pendientes.php" METHOD="post">

  <div class="control-group">
 <p class="help-block" style="width:540px; text-align:left"><span style="color:#9d261d">(*) </span>La importaci�n de alumnos con asignaturas pendientes necesita el archivo comprimido (.zip) de calificaciones de la Evaluaci�n Extraordinaria (Septiembre) del curso anterior. El archivo se descarga desde S&Eacute;NECA --> Utilidades --> Importaci�n / Exportaci�n --> Exportaci�n de calificaciones del alumno. Aseg�rate de que est�s descargando el archivo del curso anterior, no del actual.</p>
  <br />
  <div class="well well-large" style="width:500px; margin:auto;" align="left">
  <div class="controls">
 
  <label class="control-label" for="archivo2">Selecciona el archivo con las calificaciones extraordinarias
  </label>
  <input type="file" name="archivo2" class="input input-file span4" id="file">
  <hr>
  <div align="center">
    <INPUT type="submit" name="enviar" value="Aceptar" class="btn btn-primary">
  </div>
  </div>
  </div>

</FORM>
<br />
<div align="center">
  <input type="button" value="Volver atr�s" name="boton" onClick="history.back(2)" class="btn btn-success" />
</div>
</div>
</div>
</body>
</html>

