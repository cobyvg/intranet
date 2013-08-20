<?
include("../../config.php");
if (isset($_POST['eval'])) {$eval = $_POST['eval'];}else{$eval="";}

if (strlen($eval)>1) {	
if (substr($eval,0,1)=='1') {$exporta='../exporta1';$xml='xslt/notas1.xsl';}
if (substr($eval,0,1)=='2') {$exporta='../exporta2';$xml='xslt/notas2.xsl';}
if (substr($eval,0,1)=='J') {$exporta='../exportaO';$xml='xslt/notas3.xsl';}
if (substr($eval,0,1)=='S') {$exporta='../exportaE';$xml='xslt/notas4.xsl';}
//echo $exporta;
// Descomprimimos el zip de las calificaciones en el directorio exporta/
include('../../lib/pclzip.lib.php');   
$archive = new PclZip($_FILES['archivo2']['tmp_name']);  
      if ($archive->extract(PCLZIP_OPT_PATH,$exporta) == 0) 
	  {
        die('<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
No se ha podido abrir el archivo comprimido con las Calificaciones. O bien te has olvidado de enviarlo o el archivo está corrompido.
</div></div><br />
<div align="center">
  <input type="button" value="Volver atrás" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
</div>'); 
      }  
	  
if(phpversion() < '5'){
	header("location:http://$dominio/intranet/xml/notas/notas_xslt.php?directorio=$exporta&trans=$xml");
}
else{
	header("location:http://$dominio/intranet/xml/notas/notas.php?directorio=$exporta&trans=$xml");
}	  	  
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
  <h2>Administración <small> Importación de calificaciones por evaluación</small></h2>
</div>
<FORM ENCTYPE="multipart/form-data" ACTION="index_notas.php" METHOD="post">

  <div class="control-group">
 <p class="help-block" style="width:400px; text-align:left"><span style="color:#9d261d">(*) </span>Si tienes a mano los archivos de Evaluaci&oacute;n
    exportados desde S&Eacute;NECA , puedes continuar con el
    segundo paso.</p>
  <br />
  <div class="well well-large" style="width:500px; margin:auto;" align="left">
  <div class="controls">
  <label class="control-label" for="eval">Selecciona la Evaluación</label>
  <select name="eval" class="span3" id="eval">
  <option></option>
  <option>1ª Evaluación</option>
  <option>2ª Evaluación</option>
  <option>Junio</option>
  <option>Septiembre</option>
  </select>  
  <hr />
  <label class="control-label" for="file">Selecciona el archivo con las calificaciones
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
  <input type="button" value="Volver atrás" name="boton" onClick="history.back(2)" class="btn btn-success" />
</div>
</div>
</div>
</body>
</html>

