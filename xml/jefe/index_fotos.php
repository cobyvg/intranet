<?
session_start();
include("../../config.php");
include_once('../../config/version.php');

// COMPROBAMOS LA SESION
if ($_SESSION['autentificado'] != 1) {
	$_SESSION = array();
	session_destroy();
	
	if(isset($_SERVER['HTTPS'])) {
	    if ($_SERVER["HTTPS"] == "on") {
	        header('Location:'.'https://'.$dominio.'/intranet/salir.php');
	        exit();
	    } 
	}
	else {
		header('Location:'.'http://'.$dominio.'/intranet/salir.php');
		exit();
	}
}

if($_SESSION['cambiar_clave']) {
	if(isset($_SERVER['HTTPS'])) {
	    if ($_SERVER["HTTPS"] == "on") {
	        header('Location:'.'https://'.$dominio.'/intranet/clave.php');
	        exit();
	    } 
	}
	else {
		header('Location:'.'http://'.$dominio.'/intranet/clave.php');
		exit();
	}
}


registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);


$profe = $_SESSION['profi'];
if(!(stristr($_SESSION['cargo'],'1') == TRUE))
{
header('Location:'.'http://'.$dominio.'/intranet/salir.php');
exit;	
}

include("../../menu.php");
?>

<div class="container">
	
	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
		<h2>Administración <small>Importación de fotos de los alumnos</small></h2>
	</div>
	
	
	<!-- SCAFFOLDING -->
	<div class="row">
	
		<!-- COLUMNA IZQUIERDA -->
		<div class="col-sm-6">
			
			<div class="well">
				
				<form enctype="multipart/form-data" method="post" action="fotos.php">
					<fieldset>
						<legend>Importación de fotos de los alumnos</legend>

						<div class="form-group">
						  <label for="archivo"><span class="text-info">Fotografias_alumnos.zip</span></label>
						  <input type="file" id="archivo" name="archivo" accept="application/zip">
						</div>
						<div class="checkbox">
						  	<label>
						    	<input type="checkbox" name="tabla" value="1"> Crear tabla de fotos para Página Pública
						    </label>
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
			
			<p>Para importar las fotos de todos los alumnos, necesitaremos crear un archivo comprimido (.zip) conteniendo todos los archivos de fotos de los alumnos.</p>
			
			<p>Cada archivo de foto tiene como nombre el Número de Identificación Escolar que Séneca asigna a cada alumno seguido de la extensión .jpg o .jpeg. El nombre típico de un archivo de foto quedaría por ejemplo así: 1526530.jpg.</p>
			
			<p>Los tutores podrán actualizar las fotografías de los alumnos en la Página del tutor.</p>
			
		</div>
		
	
	</div><!-- /.row -->
	
</div><!-- /.container -->
  
<?php include("../../pie.php"); ?>
	
</body>
</html>
