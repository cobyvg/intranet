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



include("../../menu.php");
include("menu.php");
?>

<div class="container">
	
	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
		<h2>Problemas de convivencia <small>Consultas</small></h2>
	</div>
	
	
	<!-- SCAFFOLDING -->
	<div class="row">
	
		<!-- COLUMNA IZQUIERDA -->
		<div class="col-sm-8 col-sm-offset-2">
			
			<div class="well">
				
				<form method="POST" action="fechorias.php">
					<fieldset>
						<legend>Criterios de búsqueda</legend>
						
						<div class="row">
							<!-- FORMULARIO COLUMNA IZQUIERDA -->
							<div class="col-sm-7">
							
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="unidad">Unidad</label>
											<?php $result = mysqli_query($db_con, "SELECT DISTINCT a_grupo FROM horw WHERE a_grupo NOT LIKE 'G%' AND a_grupo NOT LIKE '' ORDER BY a_grupo"); ?>
											<?php if(mysqli_num_rows($result)): ?>
											<select class="form-control" name="unidad">
												<option value=""></option>
												<?php while($row = mysqli_fetch_array($result)): ?>
												<option value="<?php echo $row['a_grupo']; ?>"><?php echo $row['a_grupo']; ?></option>
												<?php endwhile; ?>
											</select>
											<?php else: ?>
											<select class="form-control" name="unidad" disabled></select>
											<?php endif; ?>
											<?php mysqli_free_result($result); ?>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="mes">Mes</label>
											<?php $meses = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'); ?>
											<select class="form-control" name="mes">
												<option value=""></option>
												<?php for ($i = 1; $i <= count($meses); $i++): ?>
												<option value="<?php echo $i; ?>"><?php echo $meses[$i-1]; ?></option>
												<?php endfor; ?>
											</select>
										</div>
									</div>
								</div>
								
								<div class="form-group">
								  <label for="apellido">Apellidos</label>
								  <input type="text" class="form-control" name="apellido" id="apellido" placeholder="Apellidos" maxlength="60">
								</div>
								
								<div class="form-group">
								  <label for="nombre">Nombre</label>
								  <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre" maxlength="60">
								</div>
								
							</div>
							
							<!-- FORMULARIO COLUMNA DERECHA -->
							<div class="col-sm-5">
								
								<div class="form-group" id="datetimepicker1">
								  <label for="dia">Fecha</label>
								  <div class="input-group">
								  	<input type="text" class="form-control" name="dia" id="dia" placeholder="Fecha" data-date-format="DD-MM-YYYY">
								  	<span class="input-group-addon"><span class="fa fa-calendar"></span></span>
								  </div>
								</div>
								
								<div class="form-group">
									<label for="clase">Otros criterios</label>
									<select class="form-control" id="clase" name="clase[]" multiple size="6">
										<option value="Expulsion del Centro">Expulsión del centro</option>
										<option value="Expulsion del Aula">Expulsión del aula</option>
										<option value="Aula de Convivencia">Aula de convivencia: Profesor</option>
										<option value="Aula de Convivencia Jefatura">Aula de convivencia: Jefatura</option>
										<option value="Falta Grave">Falta grave</option>
										<option value="Falta Muy Grave">Falta muy grave</option>
									</select>
								</div>
								
							</div>
							
						</div>
						
					  <button type="submit" class="btn btn-primary" name="submit1">Consultar</button>
				  </fieldset>
				</form>
				
			</div><!-- /.well -->
			
		</div><!-- /.col-sm-8 -->
		
	
	</div><!-- /.row -->
	
</div><!-- /.container -->
  
<?php include("../../pie.php"); ?>

	<script>  
	$(function ()  
	{ 
		$('#datetimepicker1').datetimepicker({
			language: 'es',
			pickTime: false
		})
	});  
	</script>
	
</body>
</html>
