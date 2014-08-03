<?
session_start();
include("../../../config.php");
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
?>
<?php
include("../../../menu.php");
?>

<div class="container">
	
	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
		<h2>Administración <small>Actualización de horarios y profesores</small></h2>
	</div>
	
	<?php $result = mysql_query("SELECT * FROM horw LIMIT 1"); ?>
	<?php if(mysql_num_rows($result)): ?>
	<div class="alert alert-warning">
		Ya existe información en la base de datos. Este proceso actualizará la información de los horarios. Es recomendable realizar una <a class="../copia_db/dump_db.php">copia de seguridad</a> antes de proceder a la importación de los datos.
	</div>
	<?php endif; ?>
	
	
	<!-- SCAFFOLDING -->
	<div class="row">
	
		<!-- COLUMNA IZQUIERDA -->
		<div class="col-sm-6">
			
			<div class="well">
				
				<form enctype="multipart/form-data" method="post" action="horarios.php">
					<fieldset>
						<legend>Actualización de horarios y profesores</legend>
						
						<input type="hidden" name="actualizar" value="1">
						
						<div class="form-group">
						  <label for="archivo"><span class="text-info">Horario.del</span></label>
						  <input type="file" id="archivo" name="archivo" accept="text/*">
						</div>
						
						<br>
						
					  <button type="submit" class="btn btn-primary" name="enviar">Importar</button>
					  <a class="btn btn-default" href="../../index.php">Volver</a>
				  </fieldset>
				</form>
				
			</div><!-- /.well -->
			
		</div><!-- /.col-sm-6 -->
		
		
		<div class="col-sm-6">
			
			<h3>Información sobre la importación</h3>
			
			<p>Este apartado se encarga de importar los <strong>horarios</strong> de los profesores. Esto permitirá consultar los horarios de las unidades, dependencias y profesores del centro. También será necesario para realizar reservas de las dependencias.</p>
			
			
			<p>Para obtener el archivo debe haber generado el horario con la aplicación <a href="http://www.horw.es" target="_blank">Horw</a>. Diríjase al apartado <strong>Archivo</strong>, <strong>Exportar como...</strong>, <strong>Exportar a DEL</strong>. Marque las casillas que aparece en la imagen inferior y haga click en <strong>Aceptar</strong> para generar el fichero.</p>
			
			<img class="img-thumbnail" src="exporta_horw.jpg">
			
		</div>
		
	
	</div><!-- /.row -->
	
</div><!-- /.container -->
  
<?php include("../../../pie.php"); ?>
	
</body>
</html>
