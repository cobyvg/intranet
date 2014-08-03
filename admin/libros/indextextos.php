<?
session_start();
include("../../config.php");
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


if(!(stristr($_SESSION['cargo'],'1') == TRUE or stristr($_SESSION['cargo'],'2') == TRUE))
{
header("location:http://$dominio/intranet/index.php");
exit;	
}

include("../../menu.php");
// Actualizamos el campo nivel
mysql_query("ALTER TABLE  `textos_gratis` CHANGE  `nivel`  `nivel` VARCHAR( 48 ) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL DEFAULT  '' ");

mysql_query("update `textos_gratis` set nivel = '1º de E.S.O.' WHERE nivel = '1E'");
mysql_query("update `textos_gratis` set nivel = '2º de E.S.O.' WHERE nivel = '2E'");
mysql_query("update `textos_gratis` set nivel = '3º de E.S.O.' WHERE nivel = '3E'");
mysql_query("update `textos_gratis` set nivel = '4º de E.S.O.' WHERE nivel = '4E'");

?>


<div class="container">
	
	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
		<h2>Programa de Ayudas al Estudio <small>Libros gratuitos de la ESO</small></h2>
	</div>
	
	<?php if(stristr($_SESSION['cargo'],'1') == TRUE): ?>
	
	<?php $result = mysql_query("SELECT * FROM textos_gratis LIMIT 1"); ?>
	<?php if(mysql_num_rows($result)): ?>
	<div class="alert alert-warning">
		Ya existe información en la base de datos. Este proceso actualizará el listado de libros de texto. Es recomendable realizar una <a class="copia_db/dump_db.php">copia de seguridad</a> antes de proceder a la importación de los datos.
	</div>
	<?php endif; ?>
	
	
	<!-- SCAFFOLDING -->
	<div class="row">
		
		<!-- COLUMNA IZQUIERDA -->
		<div class="col-sm-6">
			
			<div class="well">
				
				<form enctype="multipart/form-data" method="post" action="in_textos.php">
					<fieldset>
						<legend>Importación de libros</legend>

						<div class="form-group">
						  <label for="archivo"><span class="text-info">1ESO.txt, 2ESO.txt, 3ESO.txt, 4ESO.txt</span></label>
						  <input type="file" id="archivo" name="archivo" accept="text/plain">
						</div>
						
						<br>
						
					  <button type="submit" class="btn btn-primary" name="enviar">Importar</button>
					  <a class="btn btn-default" href="../../xml/index.php">Volver</a>
				  </fieldset>
				</form>
				
			</div><!-- /.well -->
			
		</div><!-- /.col-sm-6 -->
		
		
		<!-- COLUMNA DERECHA -->
		<div class="col-sm-6">
			
			<h3>Información sobre la importación</h3>
			
			<p>Para importar las fotos de todos los alumnos, necesitaremos crear un archivo comprimido (.zip) conteniendo todos los archivos de fotos de los alumnos.</p>
			
			<p>Cada archivo de foto tiene como nombre el Número de Identificación Escolar que Séneca asigna a cada alumno seguido de la extensión .jpg o .jpeg. El nombre típico de un archivo de foto quedaría por ejemplo así: 1526530.jpg.</p>
			
			<p>Los tutores podrán actualizar las fotografías de los alumnos en la Página del tutor.</p>
			
		</div>
				
	
	</div><!-- /.row -->
	
	<hr>
	<?php endif; ?>
	
	<div class="row">
		
		<!-- COLUMNA IZQUIERDA -->
		<div class="col-sm-6">
			
			<div class="well">
				
				<form method="post" action="reposicion.php">
					<fieldset>
						<legend>Imprimir Certificados de Reposición</legend>

						<div class="form-group">
						  <label for="niv">Curso</label>
						  <?php $result = mysql_query("SELECT nomcurso FROM cursos WHERE nomcurso LIKE '%E.S.O.' ORDER BY nomcurso ASC"); ?>
						  <?php if(mysql_num_rows($result)): ?>
						  <select class="form-control" name="niv">
						  	<?php while($row = mysql_fetch_array($result)): ?>
						  	<option value="<?php echo $row['nomcurso']; ?>"><?php echo $row['nomcurso']; ?></option>
						  	<?php endwhile; ?>
						  </select>
						  <?php else: ?>
						   <select class="form-control" name="niv" disabled></select>
						  <?php endif; ?>
						  <?php mysql_free_result($result); ?>
						</div>
						
						
					  <button type="submit" class="btn btn-primary" name="enviar3">Consultar</button>
				  </fieldset>
				</form>
				
			</div><!-- /.well -->
			
		</div><!-- /.col-sm-6 -->
		
		
		<!-- COLUMNA DERECHA -->
		<div class="col-sm-6">
			
			<div class="well">
							
				<form method="post" action="libros.php">
					<fieldset>
						<legend>Consultar el estado de los libros</legend>
						
						<input type="hidden" name="jefe" value="1">

						<div class="form-group">
						  <label for="nivel">Curso</label>
						  <?php $result = mysql_query("SELECT nomcurso FROM cursos WHERE nomcurso LIKE '%E.S.O.' ORDER BY nomcurso ASC"); ?>
						  <?php if(mysql_num_rows($result)): ?>
						  <select class="form-control" name="nivel">
						  	<?php while($row = mysql_fetch_array($result)): ?>
						  	<option value="<?php echo $row['nomcurso']; ?>"><?php echo $row['nomcurso']; ?></option>
						  	<?php endwhile; ?>
						  </select>
						  <?php else: ?>
						   <select class="form-control" name="nivel" disabled></select>
						  <?php endif; ?>
						  <?php mysql_free_result($result); ?>
						</div>
						
						
					  <button type="submit" class="btn btn-primary" name="enviar2">Consultar</button>
				  </fieldset>
				</form>
				
			</div><!-- /.well -->
			
		</div><!-- /.col-sm-6 -->
			
		
	</div><!-- /.row -->
	
	
</div><!-- /.container -->
  
<?php include("../../pie.php"); ?>
	
</body>
</html>
