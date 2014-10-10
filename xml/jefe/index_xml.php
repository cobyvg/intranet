<?
session_start();
include("../../config.php");
include_once('../../config/version.php');

// COMPROBAMOS LA SESION
if ($_SESSION['autentificado'] != 1) {
	$_SESSION = array();
	session_destroy();
	header('Location:'.'http://'.$dominio.'/intranet/salir.php');	
	exit();
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
		<h2>Administración <small>Importación de datos del centro</small></h2>
	</div>
	
	<?php $result = mysqli_query($db_con, "SELECT * FROM cursos LIMIT 1"); ?>
	<?php if(mysqli_num_rows($result) && !isset($_FILES['ExpGenHor'])): ?>
	<div class="alert alert-warning">
		Ya existe información relativa a este curso escolar. Este proceso sustituirá parte de la información almacenada. Los cambios realizados manualmente en las dependencias y departamentos no se verán afectadas. Es recomendable realizar una <a href="copia_db/index.php" class="alert-link">copia de seguridad</a> antes de proceder a la importación de los datos.
	</div>
	<?php endif; ?>
	
	<?php if(isset($_FILES['ExpGenHor'])): ?>
	<div class="alert alert-success">
		Los datos del centro han sido importados.
	</div>
	<?php endif; ?>
	
	
	<!-- SCAFFOLDING -->
	<div class="row">
	
		<!-- COLUMNA IZQUIERDA -->
		<div class="col-sm-6">
			
			<div class="well">
				
				<form enctype="multipart/form-data" method="post" action="">
					<fieldset>
						<legend>Importación de datos del centro</legend>
						
						<input type="hidden" name="curso_escolar" value="<?php echo $curso_actual; ?>">
						
						<div class="form-group">
						  <label for="ExpGenHor"><span class="text-info">ExportacionHorarios.xml</span></label>
						  <input type="file" id="ExpGenHor" name="ExpGenHor" accept="text/xml">
						</div>
						
						<br>
						
					  <button type="submit" class="btn btn-primary" name="enviar">Importar</button>
					  <a class="btn btn-default" href="../index.php">Volver</a>
				  </fieldset>
				</form>
				
			</div><!-- /.well -->
			
			<?php
			$ExpGenHor = $_FILES['ExpGenHor']['tmp_name'];
			if (isset($ExpGenHor)) {
				include ('importacion_xml.php');
				importarDatos($db_con);
			}
			?>
			
		</div><!-- /.col-sm-6 -->
		
		
		<div class="col-sm-6">
			
			<h3>Información sobre la importación</h3>
			
			<p>Este módulo se encarga de importar la relación de <strong>cursos</strong> y <strong>unidades</strong> del centro registrados en Séneca, así como la relación de <strong>materias</strong> que se imparten y <strong>actividades</strong> del personal docente, necesarias para comprobar la coherencia de los horarios y poder realizar tareas de depuración. Se importará también la relación de <strong>dependencias</strong>, que se utilizará para realizar reservas de aulas o consultar el horario de aulas.</p>
			
			<p>Para obtener el archivo de exportación debe dirigirse al apartado <strong>Utilidades</strong>, <strong>Importación/Exportación de datos</strong>. Seleccione <strong>Exportación hacia generadores de horario</strong> y proceda a descargar el archivo XML.</p>
			
		</div>
		
	
	</div><!-- /.row -->
	
</div><!-- /.container -->
  
<?php include("../../pie.php"); ?>
	
</body>
</html>
