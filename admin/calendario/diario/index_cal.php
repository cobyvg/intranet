<?
session_start();
include("../../../config.php");
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




if (isset($_POST['curso'])) {$curso = $_POST['curso'];} elseif (isset($_GET['curso'])) { $curso = $_GET['curso'];}


include("../../../menu.php");
include("menu.php");
?>

<div class="container">
	
	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
		<h2>Registro de exámenes y actividades <small>Calendario de las unidades</small></h2>
	</div>
	
	
	<!-- SCAFFOLDING -->
	<div class="row">
	
		<!-- COLUMNA IZQUIERDA -->
		<div class="col-sm-4 col-sm-offset-4">
			
			<div class="well">
				
				<form method="post" action="">
					<fieldset>
						<legend>Calendario de un Grupo</legend>
						
						<div class="row">
							<!--FORMLISTACURSOS
							<div class="col-sm-6">
								<div class="form-group">
									<label for="curso">Curso</label>
								</div>
							</div>
							FORMLISTACURSOS//-->
							
							<div class="col-sm-12">
								<div class="form-group">
								  
									<?php $result = mysqli_query($db_con, "SELECT DISTINCT unidad, SUBSTRING(unidad,2,1) AS orden FROM alma ORDER BY orden ASC"); ?>
									<?php if(mysqli_num_rows($result)): ?>
									<select class="form-control" id="curso" name="curso">
										<option></option>
										<?php while($row = mysqli_fetch_array($result)): ?>
										<option value="<?php echo $row['unidad']; ?>" <?php echo ($row['unidad'] == $curso) ? 'selected' : ''; ?>><?php echo $row['unidad']; ?></option>
										<?php endwhile; ?>
										<?php mysqli_free_result($result); ?>
									</select>
									<?php else: ?>
									<select class="form-control" name="curso" disabled>
										<option></option>
									</select>
									<?php endif; ?>
								</div>
							</div>
						</div>
					  
					  <button type="submit" class="btn btn-primary btn-block" name="submit1">Consultar</button>
				  </fieldset>
				</form>
				
			</div><!-- /.well -->
			
		</div><!-- /.col-sm-6 -->
		
	
	</div><!-- /.row -->
	
	<br>
	<?php if(isset($_POST['submit1']) || $_GET['curso']): ?>
	
	<legend class="text-center">Calendario del Grupo <span class="text-info"><?php echo $curso; ?></span></legend>
	
	<br>
	
	<div class="row">
		<div class="col-sm-8">
			<?php $result = mysqli_query($db_con, "SELECT id, fecha, grupo, materia, tipo, titulo FROM diario WHERE grupo like '%".$curso."%'"); ?>
			<table class="table table-striped">
				<thead>
					<th>Fecha</th>
					<th>Grupo</th>
					<th>Materia</th>
					<th>Título</th>
				</thead>
				<tbody>
					<?php while ($row = mysqli_fetch_array($result)): ?>
					<tr>
						<td nowrap><?php echo $row[1]; ?></td>
						<td><?php echo $row[2]; ?></td>
						<td><?php echo $row[3]; ?></td>
						<td><?php echo $row[5]; ?></td>
					</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
		
		<div class="col-sm-4">
			<?php include("calendario_grupos.php"); ?>
		</div>
	</div>
	
	<?php endif; ?>
	
</div><!-- /.container -->

<?php include("../../../pie.php"); ?>

</body>
</html>
