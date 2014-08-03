<?
include("../../config.php");
if (isset($_POST['enviar'])) {	
$exporta='../pendientes';

//echo $exporta;
// Descomprimimos el zip de las calificaciones en el directorio exporta/
include('../../lib/pclzip.lib.php');   
$archive = new PclZip($_FILES['archivo2']['tmp_name']);  
      if ($archive->extract(PCLZIP_OPT_PATH,$exporta) == 0) 
	  {
        die('<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCión:</h5>
No se ha podido abrir el archivo comprimido con las Calificaciones. O bien te has olvidado de enviarlo o el archivo estï¿½ corrompido.
</div></div><br />
<div align="center">
  <input type="button" value="Volver atrï¿½s" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
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

if($_SESSION['cambiar_clave']) {
	header('Location:'.'http://'.$dominio.'/intranet/clave.php');
}

registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);


$profe = $_SESSION['profi'];
if(!(stristr($_SESSION['cargo'],'1') == TRUE))
{
header("location:http://$dominio/intranet/salir.php");
exit;	
}

include("../../menu.php");
?>

<div class="container">
	
	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
		<h2>Administración <small>Importación de alumnos con asignaturas pendientes</small></h2>
	</div>
	
	
	<!-- SCAFFOLDING -->
	<div class="row">
	
		<!-- COLUMNA IZQUIERDA -->
		<div class="col-sm-6">
			
			<div class="well">
				
				<form enctype="multipart/form-data" method="post" action="">
					<fieldset>
						<legend>Importación de alumnos con asignaturas pendientes</legend>
						
						<div class="form-group">
						  <label for="archivo2"><span class="text-info">Exportacion_de_Calificaciones.zip</span></label>
						  <input type="file" id="archivo2" name="archivo2" accept="application/zip">
						</div>
						
						<br>
						
					  <button type="submit" class="btn btn-primary" name="enviar">Importar</button>
					  <a class="btn btn-default" href="../index.php">Volver</a>
				  </fieldset>
				</form>
				
			</div><!-- /.well -->
			
		</div><!-- /.col-sm-6 -->
		
		
		<div class="col-sm-6">
			
			<h3>Información sobre la importación</h3>
			
			<p>Este apartado se encarga de importar los <strong>alumnos matriculados en el centro con asignaturas pendientes</strong>.</p>

			<p>Para obtener el archivo de exportación de calificaciones debe dirigirse al apartado <strong>Utilidades</strong>, <strong>Importación/Exportación de datos</strong>. Seleccione <strong>Exportación de Calificaciones</strong>. Seleccione la convocatoria <strong>Evaluación extraordinaria</strong> del curso anterior y añada todas las unidades de todos los cursos del centro. Proceda a descargar el archivo comprimido.<p>
			
		</div>
		
	
	</div><!-- /.row -->
	
</div><!-- /.container -->
  
<?php include("../../pie.php"); ?>
	
</body>
</html>
