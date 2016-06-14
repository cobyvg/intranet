<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1));

function texto_turno($turno) {
	
	switch ($turno) {
		case 1 : $texto_turno = 'Hora completa'; break;
		case 2 : $texto_turno = 'Primera mitad de la hora'; break;
		case 3 : $texto_turno = 'Segunda mitad de la hora'; break;
	}
	
	return $texto_turno;
}


if (! isset($_POST['submit'])) {
	exit('No direct script access allowed');
}

// VARIABLES FORMULARIO
if (isset($_POST['profesor'])) $profesor = mysqli_real_escape_string($db_con, $_POST['profesor']);
if (isset($_POST['ausente'])) $ausente = mysqli_real_escape_string($db_con, $_POST['ausente']);
if (isset($_POST['fecha_guardia'])) $fecha_guardia = mysqli_real_escape_string($db_con, $_POST['fecha_guardia']);
if (isset($_POST['hora_guardia'])) $hora = mysqli_real_escape_string($db_con, $_POST['hora_guardia']);
if (isset($_POST['turno_guardia'])) $turno = mysqli_real_escape_string($db_con, $_POST['turno_guardia']);


// COMPROBACIÓN DEL FORMULARIO

// Campos vacíos
if (empty($_POST['profesor']) || empty($_POST['ausente']) || empty($_POST['fecha_guardia']) || empty($_POST['hora_guardia']) || empty($_POST['turno_guardia'])) {

	$msg_error = "<h4>Campos sin cumplimentar</h4>\n<ul>";

	if (empty($_POST['profesor'])) $msg_error .= "<li>Profesor sustituto - No has seleccionado el profesor que va a realizar la guardia.</li>\n";
	if (empty($_POST['ausente'])) $msg_error .= "<li>Profesor ausente - No has seleccionado el profesor que va a ausentarse.</li>\n";
	if (empty($_POST['fecha_guardia'])) $msg_error .= "<li>Fecha de la guardia - No has seleccionado la fecha de la guardia.</li>\n";
	if (empty($_POST['hora_guardia'])) $msg_error .= "<li>Hora de la guardia - No has seleccionado la hora de la guardia.</li>\n";
	if (empty($_POST['turno_guardia'])) $msg_error .= "<li>Turno de la guardia - No has seleccionado el turno de la guardia.</li>\n";

	$msg_error .= "</ul>\n";
}
else {
	// Fechas
	$exp_fecha = explode('-', $fecha_guardia);
	$dia = $exp_fecha[0];
	$mes = $exp_fecha[1];
	$anno = $exp_fecha[2];
	$fechasql = $anno.'-'.$mes.'-'.$dia;
	$diasem = date('w', mktime(0, 0, 0, $mes, $dia, $anno));
	$fechahoy = date('Y-m-d H:i:s');
	
	// Comprobamos si el usuario está actualizando los datos o comprobando la validez del formulario.
	if (isset($_POST['accion'])) {
		
		if ($_POST['accion'] == 'actualizar') {
			if (isset($_POST['id'])) $id = mysqli_real_escape_string($db_con, $_POST['id']);
			
			$result = mysqli_query($db_con, "UPDATE guardias SET profesor = '$profesor', fecha = '".$fechahoy."', turno = $turno WHERE id = '".$id."'");
			if (! $result) $msg_error = "Ha ocurrido un error al actualizar los datos. Error: ".mysqli_error($db_con);
			else $msg_success = "Los datos de la guardia han sido registrados correctamente.\n";
		}
		
		if ($_POST['accion'] == 'asignar') {
			if (isset($_POST['id'])) $id = mysqli_real_escape_string($db_con, $_POST['id']);
			
			$result = mysqli_query($db_con, "INSERT INTO guardias (profesor, profe_aula, dia, hora, fecha, fecha_guardia, turno) VALUES ('$profesor', '$ausente', '$diasem', '$hora', '$fechahoy', '$fechasql', '$turno')");
			if (! $result) $msg_error = "Ha ocurrido un error al insertar los datos. Error: ".mysqli_error($db_con);
			else $msg_success = "Los datos de la guardia han sido registrados correctamente.\n";
		}
		
	}
	else {
	
		$result = mysqli_query($db_con, "SELECT id, profesor, profe_aula, hora, fecha, fecha_guardia, turno FROM guardias WHERE dia = '$diasem' AND hora = '$hora' AND fecha_guardia = '$fechasql' AND profe_aula = '$ausente'");
		
		if ($num_reg = mysqli_num_rows($result)) {
			
			$row = mysqli_fetch_array($result);
			
			// Ya ha registrado la guardia a este profesor en el mismo turno
			if (nomprofesor($row['profesor']) == nomprofesor($profesor) && $row['turno'] == $turno) {
				
				$msg_error = "<h4>Guardia registrada</h4>\n<p>Ya ha sido registrada esta guardia.</p>\n";
				
			}
			
			// Ya ha registrado la guardia a este profesor pero en otro turno, se le da la opción de modificar el turno.
			elseif (nomprofesor($row['profesor']) == nomprofesor($profesor) && $row['turno'] != $turno) {
				
				$msg_warning = "<h4>Guardia registrada</h4>\n<p><strong>".nomprofesor($row['profe_aula'])."</strong> ya ha sido sustituido por <strong>".nomprofesor($row['profesor'])."</strong> el <strong>".strftime("%A, %e de %B de %Y", strtotime($fecha_guardia))."</strong> a <strong>".$row['hora']."ª hora</strong> en la ".texto_turno($row['turno']).". ¿Quieres cambiar el turno?</p>\n";
				
				$datos_registrados = array(
					'id' => $row['id'],
					'fecha' => $row['fecha'],
					'fecha_guardia' => $row['fecha_guardia'],
					'profesor' => nomprofesor($row['profesor']),
					'ausente' => nomprofesor($row['profe_aula']),
					'hora' => $row['hora'],
					'turno' => $row['turno'],
				);
				
				$actualizar_turno = 1;
				
			}
			
			// Ya ha registrado la guardia a otro profesor y la hora completa
			elseif (nomprofesor($row['profesor']) != nomprofesor($profesor) && $row['turno'] == 1) {
				$msg_error = "<h4>Guardia registrada</h4>\n<p><strong>".nomprofesor($row['profe_aula'])."</strong> ya ha sido sustituido por <strong>".nomprofesor($row['profesor'])."</strong> el <strong>".strftime("%A, %e de %B de %Y", strtotime($fecha_guardia))."</strong> a <strong>".$row['hora']."ª hora</strong>.</p>\n";
			}
			
			// Ya ha registrado la guardia a otro profesor pero no la hora completa
			elseif (nomprofesor($row['profesor']) != nomprofesor($profesor) && $row['turno'] != 1) {
				
				// Si hay varios registros significa que están asignados ambos turnos
				if ($num_reg > 1) {
				
					$msg_error = "<h4>Guardia registrada</h4>\n<p><strong>".nomprofesor($row['profe_aula'])."</strong> ya ha sido sustituido por <strong>".nomprofesor($row['profesor'])."</strong> el <strong>".strftime("%A, %e de %B de %Y", strtotime($fecha_guardia))."</strong> a <strong>".$row['hora']."ª hora</strong> en la ".texto_turno($row['turno']).".</p>\n";
					
					$row = mysqli_fetch_array($result); // Obtenemos el segundo registro
					
					$msg_error .= "<p><strong>".nomprofesor($row['profe_aula'])."</strong> ya ha sido sustituido por <strong>".nomprofesor($row['profesor'])."</strong> el <strong>".strftime("%A, %e de %B de %Y", strtotime($fecha_guardia))."</strong> a <strong>".$row['hora']."ª hora</strong> en la ".texto_turno($row['turno']).".</p>\n";

					
				}
				// En otro caso, ofrecemos la opción de registrar el turno disponible
				else {
					
					$turno = ($row['turno'] == 2) ? 3 : 2;
					
					$msg_warning = "<h4>Guardia registrada</h4>\n<p>Ya ha sido registrada esta guardia en este turno. Queda sin asignar el turno de la ".texto_turno($turno).". ¿Quieres asignar la guardia en el turno disponible?</p>\n";
				
					$datos_registrados = array(
						'id' => $row['id'],
						'fecha' => $row['fecha'],
						'fecha_guardia' => $row['fecha_guardia'],
						'profesor' => nomprofesor($row['profesor']),
						'ausente' => nomprofesor($row['profe_aula']),
						'hora' => $row['hora'],
						'turno' => $row['turno']
					);
					
					$asignar_turno = 1;
					
				}
				
			}
			
		}
		
		// No se han encontrado registros, por lo que insertamos en la base de datos los datos
		else {
			
			// Comprobamos si el profesor ausente ha registrado la ausencia
			$result = mysqli_query($db_con, "SELECT * FROM ausencias WHERE profesor = '$ausente' AND inicio <= '$fechasql' AND fin >= '$fechasql'");
			
			if (mysqli_num_rows($result)) {
				
				$row = mysqli_fetch_array($result);
				$horas = $row['horas'];
				
				if ($horas != 0 && $horas != '' && strstr($horas, $hora) == FALSE) {
					$horas = $horas.$hora;
					
					mysqli_query($db_con, "UPDATE ausencias SET horas = '$horas' WHERE id = '".$row['id']."'");
				}
			}
			else {
				mysqli_query($db_con, "INSERT INTO ausencias (profesor, inicio, fin, horas, tareas, ahora, archivo, Observaciones) VALUES ('$ausente', '$fechasql', '$fechasql', '$hora', '', '$fechahoy', '', NULL)");
			}
			
			// Insertamos en la base de datos de guardias
			$result = mysqli_query($db_con, "INSERT INTO guardias (profesor, profe_aula, dia, hora, fecha, fecha_guardia, turno) VALUES ('$profesor', '$ausente', '$diasem', '$hora', '$fechahoy', '$fechasql', '$turno')");
			if (! $result) $msg_error = "Ha ocurrido un error al insertar los datos. Error: ".mysqli_error($db_con);
			else $msg_success = "Los datos de la guardia han sido registrados correctamente.\n";
		}
	}

}


include("../../menu.php");
include("menu.php");
?>

<div class="container">

	<div class="page-header">
		<h2>Guardias de aula <small>Registrar guardia</small></h2>
	</div>

	<div class="row">

		<div class="col-sm-12">

			<?php if (isset($msg_error)): ?>
			<div class="alert alert-danger">
				<?php echo $msg_error; ?>
			</div>

			<a class="btn btn-primary" href="javascript:history.go(-1);">Volver atrás</a>
			<?php else: ?>
			
			<?php if (isset($msg_warning)): ?>
			<div class="alert alert-warning">
				<?php echo $msg_warning; ?>
			</div>
			<?php endif; ?>
			
			<?php if (isset($msg_success)): ?>
			<div class="alert alert-success">
				<?php echo $msg_success; ?>
			</div>
			<?php endif; ?>

			<h3>Información de la guardia</h3>

			<table class="table table-bordered table-striped">
				<?php if (isset($datos_registrados)): ?>
				<thead>
					<tr>
						<th class="col-sm-2">&nbsp;</th>
						<th>Guardia propuesta</th>
						<th>Guardia registrada</th>
					</tr>
				</thead>
				<?php endif; ?>
				<tbody>
					<tr>
						<th>Fecha de registro</th>
						<td><span class="text-success"><?php echo strftime("%e de %B de %Y a las %Rh", strtotime($fechahoy)); ?></span></td>
						<?php if (isset($datos_registrados)): ?>
						<td><span class="text-warning"><?php echo strftime("%e de %B de %Y a las %Rh", strtotime($datos_registrados['fecha'])); ?></span></td>
						<?php endif; ?>
					</tr>
					<tr>
						<th>Fecha de ausencia</th>
						<td><span class="text-success"><?php echo strftime("%A, %e de %B de %Y", strtotime($fecha_guardia)); ?></span></td>
						<?php if (isset($datos_registrados)): ?>
						<td><span class="text-warning"><?php echo strftime("%A, %e de %B de %Y", strtotime($datos_registrados['fecha_guardia'])); ?></span></td>
						<?php endif; ?>
					</tr>
					<tr>
						<th>Profesor de guardia</th>
						<td><span class="text-success"><?php echo $profesor; ?></span></td>
						<?php if (isset($datos_registrados)): ?>
						<td><span class="text-warning"><?php echo $datos_registrados['profesor']; ?></span></td>
						<?php endif; ?>
					</tr>
					<tr>
						<th>Profesor ausente</th>
						<td><span class="text-success"><?php echo $ausente; ?></span></td>
						<?php if (isset($datos_registrados)): ?>
						<td><span class="text-warning"><?php echo $datos_registrados['ausente']; ?></span></td>
						<?php endif; ?>
					</tr>
					<tr>
						<th>Hora</th>
						<td><span class="text-success"><?php echo $hora; ?>ª hora</span></td>
						<?php if (isset($datos_registrados)): ?>
						<td><span class="text-warning"><?php echo $datos_registrados['hora']; ?>ª hora</span></td>
						<?php endif; ?>
					</tr>
					<tr>
						<th>Turno</th>
						<td><span class="text-success"><?php echo texto_turno($turno); ?></span></td>
						<?php if (isset($datos_registrados)): ?>
						<td><span class="text-warning"><?php echo texto_turno($datos_registrados['turno']); ?></span></td>
						<?php endif; ?>
					</tr>
				</tbody>
			</table>
			
			<?php if (isset($datos_registrados)): ?>
			<div class="text-center">
				<form action="procesa_guardias.php" method="post">
					<input type="hidden" name="profesor" value="<?php echo $profesor; ?>">
					<input type="hidden" name="ausente" value="<?php echo $ausente; ?>">
					<input type="hidden" name="fecha_guardia" value="<?php echo $fecha_guardia; ?>">
					<input type="hidden" name="hora_guardia" value="<?php echo $hora; ?>">
					<input type="hidden" name="turno_guardia" value="<?php echo $turno; ?>">
					<input type="hidden" name="id" value="<?php echo $datos_registrados['id']; ?>">
					<?php if (isset($actualizar_turno) && $actualizar_turno == 1): ?>
					<input type="hidden" name="accion" value="actualizar">
					<button type="submit" class="btn btn-primary" name="submit">Actualizar datos</button>
					<?php endif; ?>
					<?php if (isset($asignar_turno) && $asignar_turno == 1): ?>
					<input type="hidden" name="accion" value="asignar">
					<button type="submit" class="btn btn-primary" name="submit">Asignar turno</button>
					<?php endif; ?>
					
					<a class="btn btn-default" href="javascript:history.go(-1);">Volver</a>
				</form>
			</div>
			
			<?php else: ?>
			
			<div class="text-center">
				<a class="btn btn-primary" href="index_admin.php">Volver</a>
			</div>
			<?php endif; ?>
			
			<?php endif; // MSG_ERROR ?>
			
		</div>



	</div>

<?php
/*


		$reg_sust0 = mysqli_query($db_con, "select id, profesor, profe_aula, hora, fecha_guardia from guardias where dia = '$n_dia' and hora = '$hora' and date(fecha_guardia) = date('$g_fecha') and profesor = '$profesor'"  );

		if (mysqli_num_rows($reg_sust0) > '0') {
			$c1 = "1";
			
			$reg_sust = mysqli_fetch_array($reg_sust0);
			$id= $reg_sust[0];
			$prof_sust= $reg_sust[1];
			$prof_reg= $reg_sust[2];
			$hor_reg = $reg_sust[3];
			$fecha_reg0 = explode(" ",$reg_sust[4]);
			$fecha_reg = $fecha_reg0[0];
			
			$reg_sust1 = mysqli_query($db_con, "select id, profesor, profe_aula, hora, fecha_guardia, turno from guardias where dia = '$n_dia' and hora = '$hora' and date(fecha_guardia) = date('$g_fecha') and profe_aula = '$sustituido'");
			
			// en el caso de que ya haya sido sustituido por otro profesor ya no puede cambiar guardia hasta que el otro profesor borre su guardia, compruebo que sea > 1 ya que 1 es el registro que quiere modificar y si hay otro es que otro profesor ha cogido la otra media hora.
			    
			if (mysqli_num_rows($reg_sust1) > '1') {
				$c1 = "2";
				
				$reg_sust2 = mysqli_fetch_array($reg_sust1);
				$id= $reg_sust2[0];
				$prof_sust= $reg_sust2[1];
				$prof_reg= $reg_sust2[2];
				$fecha_reg0 = explode(" ",$reg_sust2[4]);
				$fecha_reg = $fecha_reg0[0];
				
				echo '<div class="alert alert-warning alert-block fade in"><legend>ATENCIï¿½N:</legend>'.$sustituido .'ya ha sido sustituido a la '.$hora.' hora el dï¿½a '.$fecha_reg.'. Selecciona otro profesor y continï¿½a.</div>';
				
			}
			else{
				
				mysqli_query($db_con, "update guardias set profe_aula = '$sustituido', turno='$turno' where id = '$id'");
				echo '<div class="alert alert-success alert-block fade in">Has actualizado correctamente los datos del Profesor que sustituyes.</div>';
			}
		}
		else{

		$reg_sust0 = mysqli_query($db_con, "select id, profesor, profe_aula, hora, fecha_guardia from guardias where dia = '$n_dia' and hora = '$hora' and date(fecha_guardia) = date('$g_fecha') and profe_aula = '$sustituido' and (turno='$turno' or turno='1')");
		    // en el caso de que ya haya sido sustituido por otro profesor con el mismo turno o a hora completa manda mensaje de error
			if (mysqli_num_rows($reg_sust0) > '0' ) {
		$c1 = "2";
		$reg_sust = mysqli_fetch_array($reg_sust0);
		$id= $reg_sust[0];
		$prof_sust= $reg_sust[1];
		$prof_reg= $reg_sust[2];
		$fecha_reg0 = explode(" ",$reg_sust[4]);
		$fecha_reg = $fecha_reg0[0];
		echo '<div align="center"><div class="alert alert-warning alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<legend>ATENCIï¿½N:</legend>'.
$sustituido .'ya ha sido sustituido a la '.$hora.' hora el dï¿½a '.$fecha_reg.'. Selecciona otro profesor y continï¿½a.
</div></div><br>';
			}
		else{

		$reg_sust0 = mysqli_query($db_con, "select id, profesor, profe_aula, hora, fecha_guardia from guardias where dia = '$n_dia' and hora = '$hora' and date(fecha_guardia) = date('$g_fecha') and profe_aula = '$sustituido' and turno <> '$turno'");
		    // en el caso de que ya haya sido sustituido por otro profesor con distinto turno y quiera apuntarse toda la hora
			if ((mysqli_num_rows($reg_sust0) > '0')  && ($turno == 1)) {
		$c1 = "2";
		$reg_sust = mysqli_fetch_array($reg_sust0);
		$id= $reg_sust[0];
		$prof_sust= $reg_sust[1];
		$prof_reg= $reg_sust[2];
		$fecha_reg0 = explode(" ",$reg_sust[4]);
		$fecha_reg = $fecha_reg0[0];
		echo '<div align="center"><div class="alert alert-warning alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<legend>ATENCIï¿½N:</legend>'.
$sustituido .'ya ha sido sustituido a la '.$hora.' hora el dï¿½a '.$fecha_reg.'. Selecciona otro profesor y continï¿½a.
</div></div><br>';
			}
			else{

		if (!($c1) > '0') {

			$ya = mysqli_query($db_con, "select * from ausencias where profesor = '$sustituido' and date(inicio) <= date('$g_fecha') and date(fin) >= ('$g_fecha')");

		if (mysqli_num_rows($ya) > '0') {
			$ausencia_ya = mysqli_fetch_array($ya);
			$horas = $ausencia_ya[4];
			if ($horas!=="0" and $horas!=="" and strstr($horas, $hora)==FALSE) {
				$horas=$horas.$hora;
				$actualiza = mysqli_query($db_con, "update ausencias set horas = '$horas' where id = '$ausencia_ya[0]'");
				}
		}
		else{
			$inserta = mysqli_query($db_con, "insert into ausencias VALUES ('', '$sustituido', '$g_fecha', '$g_fecha', '$hora', '', NOW(), '')");
		}


			$r_profe = mb_strtoupper($profesor, "ISO-8859-1");
			mysqli_query($db_con, "insert into guardias (profesor, profe_aula, dia, hora, fecha, fecha_guardia, turno ) VALUES ('$r_profe', '$sustituido', '$n_dia', '$hora', NOW(), '$g_fecha', '$turno')");
			if (mysqli_affected_rows() > 0) {
				echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Has registrado correctamente a '.$sustituido.' a '.$hora.' hora en el turno '.$turno.' para sustituirle en al Aula.
</div></div><br>';
			}
		}
			}
		}
		}


	}
	else{
		echo '<div align="center"><div class="alert alert-warning alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<legend>ATENCIï¿½N:</legend>
No has seleccionado a ningï¿½n profesor para sustituir. Elige uno de la lista desplegable para registrar esta hora.
          </div></div>';
		}
}
*/
?>
</div>
</div>
</div>

	<?php include("../../pie.php"); ?>

</body>
</html>
