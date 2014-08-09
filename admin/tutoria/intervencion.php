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


// SE DEFINE UNA VARIABLE PARA CARGAR LOS INCLUDES
define('INC_TUTORIA',1);


if (isset($_GET['id'])) {
	$id = $_GET['id'];
}
elseif(isset($_POST['id'])){
	$id = $_POST['id'];
}
else{
	$id = "";
}
if (isset($_GET['eliminar'])) {
	$eliminar = $_GET['eliminar'];
}
if (isset($_POST['fecha_reg'])) {
	$fecha_reg = $_POST['fecha_reg'];
} else{$fecha_reg="";}

if (isset($_POST['alumno'])) {
	$alumno = $_POST['alumno'];
}   else{$alumno="";}
if (isset($_POST['observaciones'])) {
	$observaciones = $_POST['observaciones'];
} else{$observaciones="";}
if (isset($_POST['accion'])) {
	$accion = $_POST['accion'];
} else{$accion="";}
if (isset($_POST['causa'])) {
	$causa = $_POST['causa'];
} else{$causa="";}
if (isset($_POST['id2'])) {
	$id2 = $_POST['id2'];
} else{$id2="";}
if (isset($_POST['unidad0'])) {
	$unidad0 = $_POST['unidad0'];
} else{$unidad0="";}

if (isset($_POST['prohibido'])) {
	$prohibido = $_POST['prohibido'];
}else{$prohibido="";}

if ($id) {
$alumno = "";
$result = mysql_query ("select apellidos, nombre, fecha, accion, causa, observaciones, tutoria.unidad, FTUTORES.tutor, id, prohibido, orienta, jefatura, claveal from tutoria, FTUTORES where tutoria.unidad = FTUTORES.unidad and id = '$id'");
$row = mysql_fetch_array($result);
$alumno = $row[0].", ".$row[1]." --> ".$row[12];
$apellidos = $row[0];
$nombre = $row[1];
$fecha0 = $row[2];
$dia = explode("-",$fecha0);
$fecha_reg = "$dia[2]-$dia[1]-$dia[0]";
$accion = $row[3];
$causa = $row[4];
$observaciones = $row[5];
$unidad = $row[6];
$tutor = $row[7];
$id = $row[8];
$prohibido = $row[9];
$orientacion = $row[10];
$jefatura = $row[11];
$clave = $row[12];
  }


if ($eliminar=="1") {
	mysql_query("delete from tutoria where id='$id'");
echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El registro ha sido borrado en la Base de datos.
</div></div><br />';		
}

if (isset($_POST['submit1'])) {
		include("insertar.php");
}

if (isset($_POST['submit2'])) {
	$dia = explode("-",$fecha);
	$fecha2 = "$dia[2]-$dia[1]-$dia[0]";
	
	mysql_query("UPDATE tutoria SET observaciones = '$observaciones', causa = '$causa', accion = '$accion', fecha = '$fecha2' WHERE  id = '$id2'");
}


// INFORMAMOS AL TUTOR QUIEN HA REGISTRADO LA INTERVENCIÓN
if (isset($orientacion) && $orientacion == 1) {
	$msg_info = "El departamento de Orientacion ha registrado esta intervención tutorial.";
}

if (isset($accion) && $accion == 'Registro de Jefatura de Estudios') {
	$msg_info = "Jefatura de estudios ha registrado esta intervención tutorial.";
}

if (isset($jefatura) && $jefatura == 1) {
	$msg_info = "Jefatura de estudios ha registrado esta intervención tutorial.";
}


include("../../menu.php");
include("menu.php");
?>

	<div class="container">
		
		<!-- TITULO DE LA PAGINA -->
		<div class="page-header">
			<h2>Tutoría de <?php echo $unidad; ?> <small>Intervenciones sobre los alumnos</small></h2>
		</div>
		
		
		<!-- MENSAJES -->
		<?php if(isset($msg_error)): ?>
		<div class="alert alert-danger" role="alert">
			<?php echo $msg_error; ?>
		</div>
		
		<br>
		<?php endif; ?>
		
		<?php if(isset($msg_success)): ?>
		<div class="alert alert-success" role="alert">
			<?php echo $msg_success; ?>
		</div>
		
		<br>
		<?php endif; ?>
		
		<?php if(isset($msg_info)): ?>
		<div class="alert alert-info" role="alert">
			<?php echo $msg_info; ?>
		</div>
		
		<br>
		<?php endif; ?>
		
		
		<!-- SCAFFOLDING -->
		<div class="row">
		
			<!-- COLUMNA IZQUIERDA -->
			<div class="col-sm-7">
			
				<?php if(isset($id) && $alumno && !($alumno == "Todos los Alumnos")): ?>
				<?php $tr = explode(" --> ",$alumno); ?>
				<?php $al = $tr[0]; ?>
				<?php $clave = $tr[1]; ?>
				<?php $foto = '../../xml/fotos/'.$clave.'.jpg'; ?>
				<?php if(file_exists($foto)): ?>
				<img class="img-thumbnail" src="<?php echo $foto; ?>" alt="" width="92" style="position: absolute; top: -35px; right: 0; margin-right: 35px;">
				<?php endif; ?>
				<?php endif; ?>
				
				<div class="well">
					
					<form method="post" action="">
						<fieldset>
							<legend>Registro de datos</legend>
							
							<?php if(isset($id)): ?>
							<input type="hidden" name="id2" value="<?php echo $id; ?>">
							<?php endif; ?>
	
							<div class="row">
								<div class="col-sm-7">
									<div class="form-group">
									  <label for="alumno">Alumno/a</label>
									  <?php $result = mysql_query("SELECT DISTINCT APELLIDOS, NOMBRE, claveal FROM FALUMNOS WHERE unidad='$unidad' ORDER BY NC ASC"); ?>
									  <?php if(mysql_num_rows($result)): ?>
									  <select class="form-control" id="alumno" name="alumno" onchange="submit()">
									  	<option value="Todos, todos">Todos los Alumnos</option>
									  	<?php while($row = mysql_fetch_array($result)): ?>
									  	<option value="<?php echo $row['APELLIDOS'].', '.$row['NOMBRE'].' --> '.$row['claveal']; ?>" <?php echo (isset($alumno) && $row['APELLIDOS'].', '.$row['NOMBRE'].' --> '.$row['claveal'] == $alumno) ? 'selected' : ''; ?>><?php echo $row['APELLIDOS'].', '.$row['NOMBRE']; ?></option>
									  	<?php endwhile; ?>
									  	<?php mysql_free_result($result); ?>
									  </select>
									  <?php else: ?>
									  <select class="form-control" name="alumno" disabled>
									  	<option></option>
									  </select>
									  <?php endif; ?>
									</div>
								</div>
								
								<div class="col-sm-5">
									<div class="form-group">
									  <label for="fecha_reg">Fecha</label>
										<div class="input-group">
											<input name="fecha_reg" type="text" class="input form-control" value="<?php echo (isset($id) && $fecha_reg) ? $fecha_reg : date('d-m-Y'); ?>" data-date-format="dd-mm-yyyy" id="fecha_reg" >
										  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										</div>
									</div>
								</div>
							</div>
							
						  
						  <div class="form-group">
						  	<label for="observaciones">Observaciones</label>
						    <textarea class="form-control" id="observaciones" name="observaciones" placeholder="Escriba la intervención realizada sobre el alumno..." rows="10"><?php echo (isset($id) && $observaciones) ? $observaciones : ''; ?></textarea>
						  </div>
						  
						  <div class="row">
						  	<div class="col-sm-6">
						  		<div class="form-group">
						  		  <label for="causa">Causa</label>
						  		  <select class="form-control" id="causa" name="causa">
						  		  	<option value="Estado general del Alumno" <?php echo (isset($id) && $causa == 'Estado general del Alumno') ? 'selected' : ''; ?>>Estado general del Alumno</option>
						  		  	<option value="Evolución académica" <?php echo (isset($id) && $causa == 'Evolución académica') ? 'selected' : ''; ?>>Evolución académica</option>
						  		  	<option value="Faltas de Asistencia" <?php echo (isset($id) && $causa == 'Faltas de Asistencia') ? 'selected' : ''; ?>>Faltas de Asistencia</option>
						  		  	<option value="Problemas de convivencia" <?php echo (isset($id) && $causa == 'Problemas de convivencia') ? 'selected' : ''; ?>>Problemas de convivencia</option>
						  		  	<option value="Llamada por Enfermedad" <?php echo (isset($id) && $causa == 'Llamada por Enfermedad') ? 'selected' : ''; ?>>Llamada por Enfermedad</option>
						  		  	<option value="Robo, hurto" <?php echo (isset($id) && $causa == 'Robo, hurto') ? 'selected' : ''; ?>>Robo, hurto</option>
						  		  	<option value="Otras" <?php echo (isset($id) && $causa == 'Otras') ? 'selected' : ''; ?>>Otras</option>
						  		  </select>
						  		</div>
						  	</div>
						  	
						  	<div class="col-sm-6">
						  		<div class="form-group">
						  		  <label for="accion">Tipo</label>
						  			<select class="form-control" id="accion" name="accion">
						  				<option value="Entrevista telefónica" <?php echo (isset($id) && $accion == 'Entrevista telefónica') ? 'selected' : ''; ?>>Entrevista telefónica</option>
						  				<option value="Entrevista personal" <?php echo (isset($id) && $accion == 'Entrevista personal') ? 'selected' : ''; ?>>Entrevista personal</option>
						  				<option value="Comunicación por escrito" <?php echo (isset($id) && $accion == 'Comunicación por escrito') ? 'selected' : ''; ?>>Comunicación por escrito</option>
						  			</select>
						  		</div>
						  	</div>
						  </div>
						  
						  <?php if(isset($id) && $id): ?>
						  <button type="submit" class="btn btn-primary" name="submit2">Actualizar</button>
						  <button type="submit" class="btn btn-danger" name="submit3" onclick="confirmacion();">Eliminar</button>
						  <a class="btn btn-default" href="intervencion.php?tutor=<?php echo $tutor; ?>">Nueva intervención</a>
						  <?php else: ?>
						  <button type="submit" class="btn btn-primary" name="submit1">Registrar</button>
						  <?php endif; ?>
						</fieldset>
							
					</form>
					
				</div><!-- /.well -->
				
				<?php
				if($alumno){
					$tr = explode(" --> ",$alumno);
					$al = $tr[0];
					$clave = $tr[1];
					$trozos = explode (", ", $al);
					$apellidos = $trozos[0];
					$nombre = $trozos[1];
				?>
				<div class="well">
					<h4>Historial de intervenciones de <?php echo $nombre." ".$apellidos; ?></h4>
				<?php
					$result = mysql_query ("select apellidos, nombre, fecha, accion, causa, observaciones, id from tutoria where claveal = '$clave' order by fecha");
				
					if ($row = mysql_fetch_array($result)) {
						echo '<table class="table table-striped">';
						echo "<thead><tr><th>Fecha</th><th>Clase</th><th>Causa</th><th></th></tr></thead><tbody>";
						
						do{
						  $obs=substr($row[5],0,80)."...";
						  $dia3 = explode("-",$row[2]);
						  $fecha3 = "$dia3[2]-$dia3[1]-$dia3[0]";
							echo "<tr><td>$fecha3</td><td>$row[3]</a></td><td>$row[4]</a></td><td >
							<a href='intervencion.php?id=$row[6]&tutor=$tutor' rel='tooltip' title='Ver informe'><i class='fa fa-search fa-lg fa-fw'></i></a>
							</td></tr>";
						}
						while($row = mysql_fetch_array($result));
					
						echo "</table>";
					}
					else {
						echo '<br><p class="lead text-center text-muted">El alumno/a no tiene intervenciones registradas.</p>';
					}
				?>
				</div><!-- /.well -->
				<?php
				}
				?>
				
			</div><!-- /.col-sm-7 -->
			
			
			<!-- COLUMNA DERECHA -->
			<div class="col-sm-5">
				
				<h3>Intervenciones registradas</h3>
				
				<?php $result = mysql_query("SELECT DISTINCT apellidos, nombre, claveal FROM tutoria WHERE unidad='$unidad' AND DATE(fecha) > '$inicio_curso' ORDER BY apellidos ASC, nombre ASC"); ?>
				<?php if (mysql_num_rows($result)): ?>
				<table class="table table-striped dt-tutor">
					<thead>
						<tr>
							<th>#</th>
							<th>Alumno/a</th>
							<th>Fecha</th>
						</tr>
					</thead>
					<tbody>
						<?php while ($row = mysql_fetch_array($result)): ?>
						<?php $result1 = mysql_query("SELECT fecha, id FROM tutoria WHERE claveal = '".$row['claveal']."' AND prohibido = '0' AND unidad = '$unidad' AND DATE(fecha)> '$inicio_curso' ORDER BY fecha DESC LIMIT 1"); ?>
						<?php while ($row1 = mysql_fetch_array($result1)): ?>
						<tr>
							<td><?php echo $row1['id']; ?></td>
							<td><a href="intervencion.php?id=<?php echo $row1['id']; ?>&tutor=<?php echo $tutor; ?>"><?php echo ($row['apellidos'] == 'Todos') ? 'Todos los alumnos' : $row['nombre'].' '.$row['apellidos']; ?></a></td>
							<td><?php echo strftime('%e %b',strtotime($row1['fecha'])); ?></td>
						</tr>
						<?php endwhile; ?>
						<?php mysql_free_result($result1); ?>
						<?php endwhile; ?>
						<?php mysql_free_result($result); ?>
					</tbody>
				</table>
				
				<?php else: ?>
				
				<br>
				<p class="lead text-muted">No hay intervenciones registradas para esta unidad.</p>
				<br>
				
				<?php endif; ?>
				
			</div><!-- /.col-sm-5 -->
		
		</div><!-- /.row -->
		
	</div><!-- /.container -->

<?php include("../../pie.php");?>

	<script>  
	$('.dt-tutor').DataTable( {
	    "lengthMenu": [[15, 25, 50, -1], [15, 25, 50, "All"]],
	    
	    "order": [[ 0, "desc" ]],
	    
	    "bPaginate": true,
	    "bLengthChange": true,
	    "bFilter": true,
	    "bSort": true,
	    "bInfo": false,
	    "sDom": "<'row'<'col-sm-12'f>>t<'row'<'col-sm-12'p>>",
	    
	    "oLanguage": {
					"sProcessing":     "Procesando...",
				   "sLengthMenu":     "Mostrar _MENU_ registros",
				   "sZeroRecords":    "No se encontraron resultados",
				   "sEmptyTable":     "Ningún dato disponible en esta tabla",
				   "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
				   "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
				   "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
				   "sInfoPostFix":    "",
				   "sSearch":         "Buscar:",
				   "sUrl":            "",
				   "sInfoThousands":  ",",
				   "sLoadingRecords": "Cargando...",
				   "oPaginate": {
				   		"sFirst":    "Primero",
				      "sLast":     "Último",
				      "sNext":     "",
				      "sPrevious": ""
				   },
	    		 "oAria": {
	    		 		"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
	    		 		"sSortDescending": ": Activar para ordenar la columna de manera descendente"
	    		 }	
	    }
	});
	</script>
	<script>  
	$(function ()  { 
		$('#fecha').datepicker()
		.on('changeDate', function(ev){
			$('#fecha').datepicker('hide');
		});
	});
	</script>

</body>
</html>
