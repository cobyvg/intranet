<?
if (isset($_POST['submit1'])) {
	include("fechorias.php");
	exit();
}
else {
	session_start();
	include("../../config.php");
	if($_SESSION['autentificado']!='1') {
		session_destroy();
		header("location:http://$dominio/intranet/salir.php");	
		exit();
}


if($_SESSION['cambiar_clave']) {
	header('Location:'.'http://'.$dominio.'/intranet/clave.php');
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
				
				<form method="post" action="">
					<fieldset>
						<legend>Criterios de búsqueda</legend>
						
						<div class="row">
							<!-- FORMULARIO COLUMNA IZQUIERDA -->
							<div class="col-sm-7">
							
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="unidad">Unidad</label>
											<?php $result = mysql_query("SELECT DISTINCT a_grupo FROM horw WHERE a_grupo NOT LIKE 'G%' AND a_grupo NOT LIKE '' ORDER BY a_grupo"); ?>
											<?php if(mysql_num_rows($result)): ?>
											<select class="form-control" name="unidad">
												<option value=""></option>
												<?php while($row = mysql_fetch_array($result)): ?>
												<option value="<?php echo $row['a_grupo']; ?>"><?php echo $row['a_grupo']; ?></option>
												<?php endwhile; ?>
											</select>
											<?php else: ?>
											<select class="form-control" name="unidad" disabled></select>
											<?php endif; ?>
											<?php mysql_free_result($result); ?>
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
								
								<div class="form-group">
								  <label for="dia">Fecha</label>
								  <div class="input-group dp">
								  	<input type="text" class="form-control" name="dia" id="dia" placeholder="Fecha" data-date-format="dd-mm-yyyy">
								  	<span class="input-group-addon"><span class="fa fa-calendar"></span></span>
								  </div>
								</div>
								
								<div class="form-group">
									<label for="clase">Otros criterios</label>
									<select class="form-control" id="clase" name="clase[]" multiple size="6">
										<option value="Expulsion del Centro">Expulsión del centro</option>
										<option value="Expulsion del Aula">Expulsión del aula</option>
										<option value="Aula de Convivencia">Aula de convivencia</option>
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
		$('.dp').datepicker()
		.on('changeDate', function(ev){
			$('.dp').datepicker('hide');
		});
		});  
	</script>
	
</body>
</html>
<?php 
}
?>
