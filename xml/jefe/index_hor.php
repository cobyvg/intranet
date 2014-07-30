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


if (isset($_POST['enviar'])) {
	if (empty($_POST['sustituido'])) {
		$msg_error = "Debe seleccionar el profesor sustituido.";
	}
	elseif (empty($_POST['sustituto'])){
		$msg_error = "Debe seleccionar el profesor sustituto.";
	}
	else{
		$sustituido = $_POST['sustituido'];
		$sustituto = $_POST['sustituto'];
		$ok = 0;
		
		// ACTUALIZACION EN HORARIOS
		$result1 = mysql_query("UPDATE horw SET prof='$sustituto' WHERE prof='$sustituido'");
		if(!$result1) {
			$msg_error = "No se han podido cambiar los datos del horario. Error: ".mysql_error();
			$ok = 0;
		}
		
		
		// ACTUALIZACION EN HORARIOS DE FALTAS
		$result2 = mysql_query("UPDATE horw_faltas SET prof='$sustituto' WHERE prof='$sustituido'");
		if(!$result2) {
			$msg_error = "No se han podido cambiar los datos del horario de faltas. Error: ".mysql_error();
			$ok = 0;
		}
		
		
		// ACTUALIZACION EN TUTORIAS
		$result3 = mysql_query("UPDATE FTUTORES SET tutor='$sustituto' WHERE tutor='$sustituido'");
		if(!$result3) {
			$msg_error = "No se han podido cambiar los datos de tutoría. Error: ".mysql_error();
			$ok = 0;
		}
		
		
		// ACTUALIZACION EN PROFESORES
		$result4 = mysql_query("UPDATE profesores SET profesor='$sustituto' WHERE profesor='$sustituido'");
		if(!$result4) {
			$msg_error = "No se han podido cambiar los datos de la tabla Profesores. Error: ".mysql_error();
			$ok = 0;
		}
		
		
		// ACTUALIZACION EN GUARDIAS
		$result5 = mysql_query("UPDATE guardias SET profesor='$sustituto' WHERE profesor='$sustituido'");
		if(!$result5) {
			$msg_error = "No se han podido cambiar los datos de las guardias. Error: ".mysql_error();
			$ok = 0;
		}
		
		if($ok) $msg_success = "Los datos han sido modificados correctamente.";
		
	}

}

include("../../menu.php");
?>


<div class="container">
	
	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
		<h2>Administración <small>Copiar datos de un profesor a otro</small></h2>
	</div>
	
	<!-- MENSAJES -->
	<?php if(isset($msg_success)): ?>
	<div class="alert alert-success">
		<?php echo $msg_success; ?>
	</div>
	<?php endif; ?>
	
	<?php if(isset($msg_error)): ?>
	<div class="alert alert-danger">
		<?php echo $msg_error; ?>
	</div>
	<?php endif; ?>
	
	<!-- SCAFFOLDING -->
	<div class="row">
	
		<!-- COLUMNA IZQUIERDA -->
		<div class="col-sm-6">
			
			<div class="well">
				
				<form enctype="multipart/form-data" method="post" action="">
					<fieldset>
						<legend>Copiar datos de un profesor a otro</legend>
						
						<div class="form-group">
						  <label for="sustituido">Profesor sustituido</label>
						  <?php $result = mysql_query("SELECT DISTINCT prof FROM horw ORDER BY prof ASC"); ?>
						  <?php if(mysql_num_rows($result)): ?>
						  <select class="form-control" name="sustituido">
						  	<option value=""></option>
						  	<?php while($row = mysql_fetch_array($result)): ?>
						  	<option value="<?php echo $row['prof']; ?>"><?php echo $row['prof']; ?></option>
						  	<?php endwhile; ?>
						  </select>
						  <?php else: ?>
						   <select class="form-control" name="sustituido" disabled>
						   	<option value=""></option>
						   </select>
						  <?php endif; ?>
						  <?php mysql_free_result($result); ?>
						</div>
						
						<div class="form-group">
						  <label for="sustituto">Profesor sustituto</label>
						  <?php $result = mysql_query("SELECT DISTINCT nombre FROM departamentos WHERE nombre NOT LIKE 'admin' AND nombre NOT LIKE 'conserje' AND departamento NOT LIKE 'Administ%' ORDER BY nombre ASC"); ?>
						  <?php if(mysql_num_rows($result)): ?>
						  <select class="form-control" name="sustituto">
						  	<option value=""></option>
						  	<?php while($row = mysql_fetch_array($result)): ?>
						  	<option value="<?php echo $row['nombre']; ?>"><?php echo $row['nombre']; ?></option>
						  	<?php endwhile; ?>
						  </select>
						  <?php else: ?>
						   <select class="form-control" name="sustituto" disabled>
						   	<option value=""></option>
						   </select>
						  <?php endif; ?>
						  <?php mysql_free_result($result); ?>
						</div>
						
						
					  <button type="submit" class="btn btn-primary" name="enviar">Copiar</button>
					  <a class="btn btn-default" href="../index.php">Volver</a>
				  </fieldset>
				</form>
				
			</div><!-- /.well -->
			
		</div><!-- /.col-sm-6 -->
		
		
		<div class="col-sm-6">
			
			<h3>Información sobre las sustituciones</h3>
			
			<p>Para copiar los datos de un profesor que se ha dado de baja al profesor que lo sustituye, es necesario en primer lugar copiar el horario de un profesor a otro en Séneca.</p>
			
			<p>A continuación, debes actualizar los Departamentos y los Profesores en la página de Administración de la Intranet. Si ya lo has hecho, en este formulario selecciona el profesor de baja y luego el profesor que lo sustituye, y envía los datos.</p>
			
		</div>
		
	
	</div><!-- /.row -->
	
</div><!-- /.container -->
  
<?php include("../../pie.php"); ?>
	
</body>
</html>
