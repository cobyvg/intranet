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

$profe = $_SESSION['profi'];

include("../../../menu.php");
include("menu.php");
?>
	<div class="container">
	
		<div class="page-header">
		  <h2>Calendario de actividades <small>Registrar nueva actividad</small></h2>
		</div>
		<br>
<?
if (isset($_GET['mens'])) {
	if($_GET['mens']=="actualizar"){ 
echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            La actividad se ha actualizado correctamente.
          </div></div>';
}
if($_GET['mens']=="insertar"){
echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            La actividad se ha registrado correctamente.
          </div></div>';}
}
if($_GET['borrar']=="1"){
mysql_query("delete from diario where id='".$_GET['id']."'");
echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            La actividad se ha eliminado de la base de datos.
          </div></div>';
}
if (isset($_GET['id'])) {
	$id =$_GET['id'];
	$dia = mysql_query(("select * from diario where id = '$id'"));
	$diar = mysql_fetch_array($dia);
	$fecha_reg = $diar[1];
	$grupo = $diar[2];
	$tr_grupo = explode("; ",$grupo);
	$n_grupo = count($tr_grupo);
	$materia = $diar[3];
	$tr_materia = explode("; ",$materia);
	for ($i=0;$i<$n_grupo;$i++){
		$grupo_total.="$tr_grupo[$i] => $tr_materia[$i];";
	}
	$tipo = $diar[4];
	$titulo = $diar[5];
	$observaciones = $diar[6];
	$calendario = $diar[7];
	$reg_profe = $diar[8];
	if ($profe != $reg_profe) {
		unset($id);
		echo '<div align="center"><div class="alert alert-danger alert-block fade in">
		            <button type="button" class="close" data-dismiss="alert">&times;</button>
		            La actividad que intenta modificar no existe o no tienes permisos administrativos para modificarla.
		          </div></div>';
		
	}
}
	?>
	
		<!-- SCAFFOLDING -->
		<div class="row">
			
			<!-- COLUMNA IZQUIERDA -->
			<div class="col-sm-7">
	
				<div class="well">
					
					<form method="post" action="jcal_post.php">
							
						<fieldset>
							<legend>Registrar nueva actividad</legend>
							
							<input type="hidden" name="id" value="<?php echo $id; ?>">
							
							<div class="row">
							
								<div class="col-sm-6">
								
									<div class="form-group" id="datetimepicker1">
										<label for="fecha_reg">Fecha de la actividad</label>
										<div class="input-group">
									  	<input type="text" class="form-control" id="fecha_reg" name="fecha_reg" value="<?php echo (isset($fecha_reg)) ? $fecha_reg : date('Y-m-d'); ?>" data-date-format="YYYY-MM-DD" required>
									  	<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
									  </div>
									</div>
									
								</div><!-- /.col-sm-6 -->
								
								<div class="col-sm-6">
									
									<?php $actividades = array("Examen escrito", "Examen oral", "Actividad", "Revisión de actividad", "Otras pruebas", "Anotación personal"); ?>
									<div class="form-group">
										<label for="tipo">Tipo de actividad</label>
										<select class="form-control" id="tipo" name="tipo" required>
											<?php foreach ($actividades as $actividad): ?>
											<option value="<?php echo $actividad; ?>" <?php echo (isset($tipo) && $tipo == $actividad) ? 'selected' : ''; ?>><?php echo $actividad; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
	
								</div><!-- /.col-sm-6 -->
								
							</div><!-- /.row -->
							
							
							<div class="form-group">
								<label for="grupos">Unidad (Asignatura)</label>
								<?php $result = mysql_query("SELECT DISTINCT grupo, materia FROM profesores WHERE profesor='".$profe."'"); ?>
								<?php if (mysql_num_rows($result)): ?>
								<select class="form-control" id="grupos" name="grupos[]" size="7" multiple>
									<?php while ($row = mysql_fetch_array($result)): ?>
									<option value="<?php echo $row['grupo'].' => '.$row['materia']; ?>" <?php echo (isset($grupos) && in_array($row['grupo'].' => '.$row['materia'], $grupos)) ? 'selected' : ''; ?>><?php echo $row['grupo'].' ('.$row['materia'].')'; ?></option>
									<?php endwhile; ?>
								</select>
								<?php else: ?>
								<select class="form-control" id="grupos" name="grupos[]" size="7" disabled>
									<option value=""></option>
								</select>
								<?php endif; ?>
							</div>
							
							<div class="form-group">
								<label for="titulo">Título de la actividad</label>
								<input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo (isset($titulo)) ? $titulo : ''; ?>" placeholder="Título de la actividad" required>
							</div>
							
							<div class="form-group">
								<label for="observaciones">Observaciones</label>
								<textarea class="form-control" id="observaciones" name="observaciones" rows="5"><?php echo (isset($observaciones)) ? $observaciones : ''; ?></textarea>
							</div>
							
							<div class="form-group">
								<div class="checkbox">
									<label>
										<input type="checkbox" id="calendario" name="calendario" value="1" <?php echo ((isset($calendario) && $calendario) || !isset($id)) ? 'checked' : ''; ?>> Mostrar en el calendario
									</label>
								</div>
							</div>
							
							<button type="submit" class="btn btn-primary" name="enviar">Registrar</button>
							<button type="reset" class="btn btn-default">Cancelar</button>
							<?php if (isset($id)): ?>
							<a href="index.php" class="btn btn-default">Nueva actividad</a>
							<?php endif; ?>
							
						</fieldset>
						
					</form>
							
				</div><!-- /.well -->
				
			</div><!-- /.col-sm-7 -->
			
			
			<!-- COLUMNA DERECHA -->
			<div class="col-sm-5">
				
				<?php include("calendario.php"); ?>
	
			</div><!-- /.col-sm-5 -->
			
		</div><!-- /.row -->
		
		
		<div class="row">
		
			<div class="col-sm-12">
			
				<h3>Mis actividades</h3>
				
				<?php $result = mysql_query("SELECT id, fecha, grupo, materia, tipo, titulo FROM diario WHERE profesor='".$_SESSION['profi']."' ORDER BY fecha DESC"); ?>
				<?php if (mysql_num_rows($result)): ?>
				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Fecha</th>
								<th>Unidad</th>
								<th>Asignatura</th>
								<th>Título</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php while ($row = mysql_fetch_array($result)): ?>
							<tr>
								<td nowrap><?php echo $row['fecha']; ?></td>
								<td><?php echo $row['grupo']; ?></td>
								<td><?php echo $row['materia']; ?></td>
								<td><?php echo $row['titulo']; ?></td>
								<td nowrap>
									<a href="index.php?id=<?php echo $row['id']; ?>"><span class="fa fa-edit fa-fw fa-lg" data-bs="tooltip" title="Editar"></span></a>&nbsp;
									<a href="index.php?id=<?php echo $row['id']; ?>&borrar=1" data-bs="tooltip" title="Eliminar" data-bb='confirm-delete'><span class="fa fa-trash-o fa-fw fa-lg"></span></a>
								</td>
							</tr>
							<?php endwhile; ?>
						</tbody>
					</table>
				</div>
				<?php else: ?>
				
				<p class="lead text-muted">No ha registrado ninguna actividad.</p>
				<br>
				
				<?php endif; ?>
			
			</div><!-- /.col-sm-12 -->
			
		</div><!-- /.row -->
		
		
	</div><!-- /.container -->
	
	<?php include("../../../pie.php"); ?>

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
