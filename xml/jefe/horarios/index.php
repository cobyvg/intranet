<?
require('../../../bootstrap.php');


function abrevactividad($db_con, $actividad) {
	$result = mysqli_query($db_con, "SELECT idactividad, nomactividad FROM actividades_seneca WHERE nomactividad = '$actividad'");
	while ($row = mysqli_fetch_array($result)) {
		$exp_nomactividad = explode('(', $row['nomactividad']);
		
		$exp_nomactividad = str_replace(' a ', ' ', $exp_nomactividad);
		$exp_nomactividad = str_replace(' al ', ' ', $exp_nomactividad);
		$exp_nomactividad = str_replace(' el ', ' ', $exp_nomactividad);
		$exp_nomactividad = str_replace(' la ', ' ', $exp_nomactividad);
		$exp_nomactividad = str_replace(' las ', ' ', $exp_nomactividad);
		$exp_nomactividad = str_replace(' los ', ' ', $exp_nomactividad);
		$exp_nomactividad = str_replace(' de ', ' ', $exp_nomactividad);
		$exp_nomactividad = str_replace(' en ', ' ', $exp_nomactividad);
		$exp_nomactividad = str_replace(' del ', ' ', $exp_nomactividad);
		$exp_nomactividad = str_replace(' que ', ' ', $exp_nomactividad);
		$exp_nomactividad = str_replace(' y ', ' ', $exp_nomactividad);
		$exp_nomactividad = str_replace('.', ' ', $exp_nomactividad);
		$exp_nomactividad = str_replace(',', ' ', $exp_nomactividad);
		$exp_nomactividad = str_replace('-', ' ', $exp_nomactividad);
		$exp_nomactividad = str_replace(' para ', ' ', $exp_nomactividad);
		$exp_nomactividad = str_replace(' cuando ', ' ', $exp_nomactividad);
		$exp_nomactividad = str_replace(' como ', ' ', $exp_nomactividad);
		$exp_nomactividad = str_replace(' no ', ' ', $exp_nomactividad);
		$exp_nomactividad = str_replace(' tengan ', ' ', $exp_nomactividad);
		$exp_nomactividad = str_replace(' determine ', ' ', $exp_nomactividad);
		$exp_nomactividad = str_replace(' correspondientes ', ' ', $exp_nomactividad);
		
		$nomactividad = ucwords(mb_strtolower($exp_nomactividad[0]));
		
		$abrev = "";
		for ($i = 0; $i < strlen($nomactividad); $i++) {
			if ($nomactividad[$i] == mb_strtoupper($nomactividad[$i], 'ISO-8859-1') && $nomactividad[$i] != " " && $nomactividad[$i] != ".") {
				$abrev .= mb_strtoupper($nomactividad[$i], 'ISO-8859-1');
			}
		}
		
		if (strlen($abrev) < 3) {
			$exp_nomactividad = explode(' ', $nomactividad);
			$abrev .= $exp_nomactividad[1][1].$exp_nomactividad[1][2];
			$abrev = mb_strtoupper($abrev, 'ISO-8859-1');;
		}
		
		if (strlen($abrev) < 2) {
			$exp_nomactividad = explode(' ', $nomactividad);
			$abrev .= $exp_nomactividad[0][1].$exp_nomactividad[0][2];
			$abrev = mb_strtoupper($abrev, 'ISO-8859-1');;
		}
	}
	
	return $abrev;
}


// SELECCION DE PROFESOR
if(!(stristr($_SESSION['cargo'],'1') == TRUE))
{
	$profesor = $_SESSION['profi'];
}
else {
	if (isset($_SESSION['mod_horarios']['profesor'])) {
		$profesor = $_SESSION['mod_horarios']['profesor'];
	}
	
	if ($_POST['profesor']) {
		$profesor = $_POST['profesor'];
		$_SESSION['mod_horarios']['profesor'] = $profesor;
	}	
}


// MODIFICADORES DE FORMULARIO
if (isset($_GET['dia'])) $dia = urldecode($_GET['dia']);
else $dia = $_POST['dia'];

if (isset($_GET['hora'])) $hora = urldecode($_GET['hora']);
else $hora = $_POST['hora'];

if (isset($_GET['asignatura'])) $asignatura = urldecode($_GET['asignatura']);
else $asignatura = $_POST['asignatura'];

if (isset($_GET['unidad'])) $unidad = urldecode($_GET['unidad']);
else $unidad = $_POST['unidad'];

if (isset($_GET['dependencia'])) $dependencia = urldecode($_GET['dependencia']);
else $dependencia = $_POST['dependencia'];


// ENVIO DE FORMULARIO
if (isset($_POST['enviar'])) {
	$dia = $_POST['dia'];
	$hora = $_POST['hora'];
	
	// OBTENEMOS DATOS DEL PROFESOR
	$result = mysqli_query($db_con, "SELECT DISTINCT no_prof, c_prof FROM horw WHERE prof='".$profesor."'");
	$datos_profesor = mysqli_fetch_array($result);
	$numprofesor = $datos_profesor['no_prof'];
	$codprofesor = $datos_profesor['c_prof'];
	
	// OBTENEMOS DATOS DE LA ASIGNATURA
	$result = mysqli_query($db_con, "SELECT nombre, abrev FROM asignaturas WHERE codigo='".$_POST['asignatura']."' AND abrev NOT LIKE '%\_%'");
	$datos_asignatura = mysqli_fetch_array($result);
	$codasignatura = $_POST['asignatura'];
	$nomasignatura = $datos_asignatura['nombre'];
	$abrevasignatura = $datos_asignatura['abrev'];
	
	if ($nomasignatura == '') {
		$result = mysqli_query($db_con, "SELECT idactividad, nomactividad FROM actividades_seneca WHERE idactividad='".$_POST['asignatura']."'");
		$datos_asignatura = mysqli_fetch_array($result);
		$codasignatura = $_POST['asignatura'];
		$nomasignatura = $datos_asignatura['nomactividad'];
		$abrevasignatura = abrevactividad($db_con, $datos_asignatura['nomactividad']);
	}
	
	// OBTENEMOS DATOS DE LA UNIDAD
	$result = mysqli_query($db_con, "SELECT DISTINCT n_grupo FROM horw WHERE a_grupo='".$_POST['unidad']."'");
	$datos_unidad = mysqli_fetch_array($result);
	$codunidad = $_POST['unidad'];
	$nomunidad = $datos_unidad['n_grupo'];
	
	// OBTENEMOS DATOS DE LA DEPENDENCIA
	$result = mysqli_query($db_con, "SELECT DISTINCT n_aula FROM horw WHERE a_aula='".$_POST['dependencia']."'");
	$datos_dependencia = mysqli_fetch_array($result);
	$coddependencia = $_POST['dependencia'];
	$nomdependencia = $datos_dependencia['n_aula'];
	
	$result = mysqli_query($db_con, "INSERT INTO horw (dia, hora, a_asig, asig, c_asig, prof, no_prof, c_prof, a_aula, n_aula, a_grupo, n_grupo) VALUES ('$dia', '$hora', '$abrevasignatura', '$nomasignatura', '$codasignatura', '$profesor', '$numprofesor', '$codprofesor', '$coddependencia', '$nomdependencia', '$codunidad', '$nomunidad')");
	
	if (! $result) {
		$msg_error = "Error al modificar el horario. Error: ".mysqli_error($db_con);
	}
	else {
		header('Location:'.'index.php?msg_success=1');
	}
}


if (isset($_POST['actualizar'])) {
	$dia = $_POST['dia'];
	$hora = $_POST['hora'];
	
	// OBTENEMOS DATOS DEL PROFESOR
	$result = mysqli_query($db_con, "SELECT DISTINCT no_prof, c_prof FROM horw WHERE prof='".$profesor."'");
	$datos_profesor = mysqli_fetch_array($result);
	$numprofesor = $datos_profesor['no_prof'];
	$codprofesor = $datos_profesor['c_prof'];
	
	// OBTENEMOS DATOS DE LA ASIGNATURA
	$result = mysqli_query($db_con, "SELECT nombre, abrev FROM asignaturas WHERE codigo='".$_POST['asignatura']."' AND abrev NOT LIKE '%\_%'");
	$datos_asignatura = mysqli_fetch_array($result);
	$codasignatura = $_POST['asignatura'];
	$nomasignatura = $datos_asignatura['nombre'];
	$abrevasignatura = $datos_asignatura['abrev'];
	
	if ($nomasignatura == '') {
		$result = mysqli_query($db_con, "SELECT idactividad, nomactividad FROM actividades_seneca WHERE idactividad='".$_POST['asignatura']."'");
		$datos_asignatura = mysqli_fetch_array($result);
		$codasignatura = $_POST['asignatura'];
		$nomasignatura = $datos_asignatura['nomactividad'];
		$abrevasignatura = abrevactividad($db_con, $datos_asignatura['nomactividad']);
	}
	
	// OBTENEMOS DATOS DE LA UNIDAD
	$result = mysqli_query($db_con, "SELECT DISTINCT n_grupo FROM horw WHERE a_grupo='".$_POST['unidad']."'");
	$datos_unidad = mysqli_fetch_array($result);
	$codunidad = $_POST['unidad'];
	$nomunidad = $datos_unidad['n_grupo'];
	
	// OBTENEMOS DATOS DE LA DEPENDENCIA
	$result = mysqli_query($db_con, "SELECT DISTINCT n_aula FROM horw WHERE a_aula='".$_POST['dependencia']."'");
	$datos_dependencia = mysqli_fetch_array($result);
	$coddependencia = $_POST['dependencia'];
	$nomdependencia = $datos_dependencia['n_aula'];
	
	$result = mysqli_query($db_con, "UPDATE horw SET dia='$dia', hora='$hora', a_asig='$abrevasignatura', asig='$nomasignatura', c_asig='$codasignatura', a_aula='$coddependencia', n_aula='$nomdependencia', a_grupo='$codunidad', n_grupo='$nomunidad' WHERE dia='".$_GET['dia']."' AND hora='".$_GET['hora']."' AND a_grupo='".$_GET['unidad']."' AND prof='".$profesor."'");
	
	if (! $result) {
		$msg_error = "Error al modificar el horario. Error: ".mysqli_error($db_con);
	}
	else {
		header('Location:'.'index.php?msg_success=1');
	}
}

if (isset($_POST['eliminar'])) {
	$dia = $_POST['dia'];
	$hora = $_POST['hora'];
	$unidad = $_POST['unidad'];
	
	$result = mysqli_query($db_con, "DELETE FROM horw WHERE dia='".$_GET['dia']."' AND hora='".$_GET['hora']."' AND a_grupo='".$_GET['unidad']."' AND prof='".$profesor."'");
	if (! $result) {
		$msg_error = "Error al modificar el horario. Error: ".mysqli_error($db_con);
	}
	else {
		header('Location:'.'index.php?msg_success=1');
	}
}

include("../../../menu.php");
?>


<div class="container">
	
	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
		<h2>Administración <small>Modificación de horarios</small></h2>
	</div>
	
	
	<?php if(isset($msg_error)): ?>
	<div class="alert alert-danger">
		<?php echo $msg_error; ?>
	</div>
	<?php endif; ?>
	
	<?php if(isset($_GET['msg_success'])): ?>
	<div class="alert alert-success">
		El horario ha sido modificado.
	</div>
	<?php endif; ?>
	
	
	<!-- SCAFFOLDING -->
	<div class="row">
	
		<!-- COLUMNA IZQUIERDA -->
		<div class="col-sm-5">
			
			<div class="well">
				
				<form enctype="multipart/form-data" method="post" action="">
					<fieldset>
						<legend>Horario regular</legend>
						
						<?php if (stristr($_SESSION['cargo'],'1') == TRUE): ?>
						<div class="form-group">
						  <label for="profesor">Profesor/a</label>
						  <select class="form-control" id="profesor" name="profesor" onchange="submit()">
						  	<option value=""></option>
						  	<?php $result = mysqli_query($db_con, "SELECT nombre FROM departamentos WHERE departamento <> 'Admin' AND departamento <> 'Administracion' AND departamento <> 'Conserjeria' ORDER BY nombre ASC"); ?>
						  	<?php while ($row = mysqli_fetch_array($result)): ?>
						  	<option value="<?php echo $row['nombre']; ?>" <?php echo (isset($profesor) && $row['nombre'] == $profesor) ? 'selected' : ''; ?>><?php echo $row['nombre']; ?></option>
						  	<?php endwhile; ?>
						  </select>
						</div>
						
						<hr>
						<?php else: ?>
						<input type="hidden" name="profesor" value="<?php echo $profesor; ?>">
						<?php endif; ?>
						
						<div class="form-group">
						  <label for="dia">Día de la semana</label>
						  <select class="form-control" id="dia" name="dia">
						  	<option value=""></option>
						  	<?php $arrdias = array(1=>'Lunes',2=>'Martes',3=>'Miércoles',4=>'Jueves',5=>'Viernes'); ?>
						  	<?php foreach ($arrdias as $numdia => $nomdia): ?>
						  	<option value="<?php echo $numdia; ?>" <?php echo (isset($dia) && $numdia == $dia) ? 'selected' : ''; ?>><?php echo $nomdia; ?></option>
						  	<?php endforeach; ?>
						  </select>
						</div>
						
						<div class="form-group">
						  <label for="hora">Hora</label>
						  <select class="form-control" id="hora" name="hora">
						  	<option value=""></option>
						  	<?php $arrhoras = array(1=>'08:15 - 09:15',2=>'09:15 - 10:15',3=>'10:15 - 11:15',4=>'11:45 - 12:45',5=>'12:45 - 13:45',6=>'13:45 - 14:45'); ?>
						  	<?php foreach ($arrhoras as $numhora => $nomhora): ?>
						  	<option value="<?php echo $numhora; ?>" <?php echo (isset($hora) && $numhora == $hora) ? 'selected' : ''; ?>><?php echo $nomhora; ?></option>
						  	<?php endforeach; ?>
						  </select>
						</div>
						
						<div class="form-group">
						  <label for="unidad">Unidad</label>
						  <select class="form-control" id="unidad" name="unidad">
						  	<option value=""></option>
						  	<?php $result = mysqli_query($db_con, "SELECT unidades.nomunidad, cursos.nomcurso FROM unidades JOIN cursos ON unidades.idcurso=cursos.idcurso"); ?>
						  	<?php while ($row = mysqli_fetch_array($result)): ?>
						  	<option value="<?php echo $row['nomunidad']; ?>" <?php echo (isset($unidad) && $row['nomunidad'] == $unidad) ? 'selected' : ''; ?>><?php echo $row['nomunidad'].' ('.$row['nomcurso'].')'; ?></option>
						  	<?php endwhile; ?>
						  </select>
						</div>
						
						<div class="form-group">
						  <label for="asignatura">Asignatura</label>
						  <select class="form-control" id="asignatura" name="asignatura">
						 	<option value=""></option>
						  	<optgroup label="Asignaturas">
						  	  	<?php $result = mysqli_query($db_con, "SELECT codigo, nombre, abrev, curso FROM asignaturas WHERE codigo <> '' AND abrev NOT LIKE '%\_%' ORDER BY curso ASC, nombre ASC"); ?>
						  	  	<?php while ($row = mysqli_fetch_array($result)): ?>
						  	  	<option value="<?php echo $row['codigo']; ?>" <?php echo (isset($asignatura) && $row['codigo'] == $asignatura) ? 'selected' : ''; ?>><?php echo $row['curso'].' - '.$row['nombre'].' ('.$row['abrev'].')'; ?></option>
						  	  	<?php endwhile; ?>
						  	</optgroup>
						  	<optgroup label="Actividades">
							  	<?php $result = mysqli_query($db_con, "SELECT idactividad, nomactividad FROM actividades_seneca"); ?>
							  	<?php while ($row = mysqli_fetch_array($result)): ?>
							  	<option value="<?php echo $row['idactividad']; ?>" <?php echo (isset($asignatura) && $row['idactividad'] == $asignatura) ? 'selected' : ''; ?>><?php echo $row['nomactividad']; ?></option>
							  	<?php endwhile; ?>
						  	</optgroup>
						  </select>
						</div>
						
						<div class="form-group">
						  <label for="dependencia">Aula</label>
						  <select class="form-control" id="dependencia" name="dependencia">
						  	<option value=""></option>
						  	<?php $result = mysqli_query($db_con, "SELECT DISTINCT a_aula, n_aula FROM horw WHERE a_aula <> 'n_aula' ORDER BY n_aula"); ?>
						  	<?php while ($row = mysqli_fetch_array($result)): ?>
						  	<option value="<?php echo $row['a_aula']; ?>" <?php echo (isset($dependencia) && $row['a_aula'] == $dependencia) ? 'selected' : ''; ?>><?php echo $row['n_aula']; ?></option>
						  	<?php endwhile; ?>
						  </select>
						</div>
						
						<br>				
					  	
					  	<?php if (isset($_GET['dia']) && isset($_GET['hora'])): ?>
					  	<button type="submit" class="btn btn-primary" name="actualizar">Actualizar</button>
					  	<button type="submit" class="btn btn-danger" name="eliminar">Eliminar</button>
					  	<a href="index.php" class="btn btn-default">Nuevo</a>
					  	<?php else: ?>
					  	<button type="submit" class="btn btn-primary" name="enviar">Añadir</button>
					  	<a class="btn btn-default" href="../../index.php">Volver</a>
					  	<?php endif; ?>
					  	
				  </fieldset>
				</form>
				
			</div><!-- /.well -->
			
		</div><!-- /.col-sm-5 -->
		
		
		<div class="col-sm-7">
			
			<h3><?php echo $profesor; ?></h3>
			
			<div class="table-responsive">
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>&nbsp;</th>
							<th>Lunes</th>
							<th>Martes</th>
							<th>Miércoles</th>
							<th>Jueves</th>
							<th>Viernes</th>
						</tr>
					</thead>
					<tbody>
					<?php $dia = ""; ?>
					<?php $horas = array(1 => "1ª", 2 => "2ª", 3 => "3ª", 4 => "4ª", 5 => "5ª", 6 => "6ª" ); ?>
					<?php foreach($horas as $hora => $desc): ?>
						<tr>
							<th><?php echo $desc; ?></th>
							<?php for($i = 1; $i < 6; $i++): ?>
							<?php $result = mysqli_query($db_con, "SELECT DISTINCT a_asig, asig, c_asig, a_grupo, a_aula, n_aula FROM horw WHERE prof='$profesor' AND dia='$i' AND hora='$hora'"); ?>
							<td width="20%">
					 			<?php while($row = mysqli_fetch_array($result)): ?>
					 			<abbr data-bs="tooltip" title="<?php echo $row['asig']; ?>"><?php echo $row['a_asig']; ?></abbr><br>
					 			<?php echo (!empty($row['n_aula']) && $row['n_aula'] != 'Sin asignar o sin aula' && $row['n_aula'] != 'NULL') ? '<abbr class="pull-right text-danger" data-bs="tooltip" title="'.$row['n_aula'].'">'.$row['a_aula'].'</abbr>' : ''; ?>
					 			<?php echo (!empty($row['a_grupo'])) ? '<span class="text-warning">'.$row['a_grupo'].'</span>' : ''; ?><br>
					 			<a href="index.php?dia=<?php echo $i; ?>&hora=<?php echo $hora; ?>&unidad=<?php echo $row['a_grupo']; ?>&asignatura=<?php echo $row['c_asig']; ?>&dependencia=<?php echo $row['a_aula']; ?>"><span class="fa fa-edit fa-fw fa-lg"></span></a>
				 				<?php echo '<hr>'; ?>
					 			<?php endwhile; ?>
					 			<?php mysqli_free_result($result); ?>
					 		</td>
					 		<?php endfor; ?>
					 	</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			</div>
						
		</div><!-- /.col-sm-7 -->
	
	</div><!-- /.row -->
	
</div><!-- /.container -->
  
<?php include("../../../pie.php"); ?>
	
</body>
</html>
