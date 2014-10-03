<?
session_start();
include("../../config.php");
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



?>
<?php
include("../../menu.php");

if (isset($_POST['unidad'])) {
	$unidad = $_POST['unidad'];
}
elseif (isset($_GET['unidad'])) {
	$unidad = $_GET['unidad'];
} 
else
{
$unidad="";
}
if (isset($_GET['nombre_al'])) {
	$nombre = $_GET['nombre_al'];
}
else{
	$nombre = $nombre_al;
}

?>
<div class="container">
	
	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
		<h2>Informes de alumnos <small>Consulta individual</small></h2>
	</div>
	
	
	<!-- SCAFFOLDING -->
	<div class="row">
	
		<!-- MODULO -->
		<div class="col-sm-8 col-sm-offset-2">
			
			<div class="well">
				
				<form method="post" action="">
					
					<div class="row">
						
						<div class="col-sm-6">
							
							<fieldset>
								<legend>Datos del alumno</legend>
								
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
										  <label for="unidad">Unidad</label>
											<?php $result = mysqli_query($db_con, "SELECT DISTINCT unidad, SUBSTRING(unidad,2,1) AS orden FROM alma ORDER BY orden ASC"); ?>
											<?php if(mysqli_num_rows($result)): ?>
											<select class="form-control" id="unidad" name="unidad" onchange="submit()">
												<option></option>
												<?php while($row = mysqli_fetch_array($result)): ?>
												<option value="<?php echo $row['unidad']; ?>" <?php echo ($row['unidad'] == $unidad) ? 'selected' : ''; ?>><?php echo $row['unidad']; ?></option>
												<?php endwhile; ?>
												<?php mysqli_free_result($result); ?>
											</select>
											<?php else: ?>
											<select class="form-control" name="unidad" disabled>
												<option></option>
											</select>
											<?php endif; ?>
										</div>
									</div>
								</div>
								
								<div class="form-group">
							    <label for="nombre">Alumno/a</label>
							    <?php $result = mysqli_query($db_con, "SELECT DISTINCT APELLIDOS, NOMBRE, CLAVEAL FROM FALUMNOS WHERE unidad='$unidad' ORDER BY APELLIDOS ASC"); ?>
							    <?php if(mysqli_num_rows($result)): ?>
							    <select class="form-control" id="nombre" name="nombre">
							    	<option></option>
							    	<?php while($row = mysqli_fetch_array($result)): ?>
							    	<option value="<?php echo $row['APELLIDOS'].', '.$row['NOMBRE'].' --> '.$row['CLAVEAL']; ?>" <?php echo (isset($nombre) && $row['APELLIDOS'].', '.$row['NOMBRE'].' --> '.$row['CLAVEAL'] == $nombre) ? 'selected' : ''; ?>><?php echo $row['APELLIDOS'].', '.$row['NOMBRE']; ?></option>
							    	<?php endwhile; ?>
							    	<?php mysqli_free_result($result); ?>
							    </select>
							    <?php else: ?>
							    <select class="form-control" name="nombre" disabled>
							    	<option></option>
							    </select>
							    <?php endif; ?>
							  </div>
							  
							  <div class="form-group">
							    <label for="c_escolar">Curso escolar</label>
							    
							    <select class="form-control" id="c_escolar" name="c_escolar">
							    	<?php $ano=explode("/",$curso_actual); ?>
							    	<?php for($i = 0; $i < 5; $i++): ?>
							    	<?php ${b.$i}=$ano[0]-$i; ?>
							    	<?php ${c.$i}=$ano[1]-$i; ?>
							    	<?php ${a.$i}=${b.$i}."/".${c.$i}; ?>
							    	<option><?php echo ${a.$i}; ?></option>
							    	<?php endfor; ?>
							    </select>
							  </div>
							  
							</fieldset>
							
						</div><!-- /.col-sm-6 -->
						
						
						
						<div class="col-sm-6">
							
							<fieldset>
								<legend>Opciones del informe</legend>
								
								
								<div class="checkbox">
									<label>
										<input type="checkbox" name="faltas" value="faltas" <?php echo ($mod_faltas == '1') ? '' : 'disabled' ?> checked> Resumen de faltas de asistencia
									</label>
								</div>
								
								<div class="checkbox">
									<label>
										<input type="checkbox" name="faltasd" value="faltasd" <?php echo ($mod_faltas == '1') ? '' : 'disabled' ?> checked> Faltas de asistencia detalladas
									</label>
								</div>
								
								<div class="checkbox">
									<label>
										<input type="checkbox" name="fechorias" value="fechorias" checked> Problemas de convivencia
									</label>
								</div>
								
								<div class="checkbox">
									<label>
										<input type="checkbox" name="tutoria" value="tutoria" checked> Informes de tutoría
									</label>
								</div>
								
								<div class="checkbox">
									<label>
										<input type="checkbox" name="notas" value="notas" checked> Notas de evaluación
									</label>
								</div>
								
								<div class="checkbox">
									<label>
										<input type="checkbox" name="act_tutoria" value="act_tutoria" checked> Acciones de tutoría
									</label>
								</div>
								
								<div class="checkbox">
									<label>
										<input type="checkbox" name="horarios" value="horarios" <?php echo ($mod_horario == '1') ? '' : 'disabled' ?> checked> Horario del alumno
									</label>
								</div>
							</fieldset>
							
							<button type="submit" class="btn btn-primary" name="submit1" formaction="index.php" checked>Consultar</button>
							
						</div><!-- /.col-sm-6 -->
						
					</div><!-- /.row -->
					
				</form>
				
			</div><!-- /.well -->
			
		</div><!-- /.col-sm-8 -->
	
	</div><!-- /.row -->
	
</div><!-- /.container -->

<?php include("../../pie.php"); ?>
</body>
</html>