<?php
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

$evaluaciones = array(
	'ini' => 'Evaluación Inicial (Septiembre)',
	'in1' => 'Intermedia 1 (Octubre)',
	'in2' => 'Intermedia 2 (Noviembre)',
	'1ev' => '1ª Evaluación (Diciembre)',
	'in3' => 'Intermedia 3 (Enero)',
	'in4' => 'Intermedia 4 (Febrero)',
	'2ev' => '2ª Evaluación (Marzo)',
	'in5' => 'Intermedia 5 (Abril)',
	'in6' => 'Intermedia 6 (Mayo)',
	'ord' => 'Evaluación Ordinaria (Junio)',
	'ext' => 'Evaluación Extraordinaria (Septiembre)',
);


if (isset($_POST['curso'])) $curso = $_POST['curso'];
if (isset($_POST['evaluacion']) && !empty($_POST['evaluacion'])) $evaluacion = $_POST['evaluacion'];


include("../../menu.php");
include("menu.php");
?>
	
	<div class="container">
		
		<!-- TITULO DE LA PAGINA -->
		<div class="page-header">
			<h2>Evaluaciones <small>Sesiones de evaluación</small></h2>
		</div>
		
		<!-- MENSAJES -->
		<?php if (isset($msg_error)): ?>
		<div class="alert alert-danger">
			<?php echo $msg_error; ?>
		</div>
		<?php endif; ?>
		
		<?php if (isset($msg_success)): ?>
		<div class="alert alert-success">
			<?php echo $msg_success; ?>
		</div>
		<?php endif; ?>
		
		
		<div class="row hidden-print">
		
			<div class="col-sm-12">
			
				<form method="post" action="">
					
					<fieldset>
					
						<div class="well">
							
							<legend>Seleccione unidad y evaluación</legend>
							
							<div class="row">
								
								<div class="col-sm-6">
								
									<div class="form-group">
										<label for="curso">Unidad</label>
										<?php if (strstr($_SESSION['cargo'], '1') == true): ?>
										<?php $result = mysql_query("SELECT DISTINCT a_grupo FROM horw WHERE nivel <> '' AND n_grupo <> '' AND a_asig NOT LIKE '%TUT%' ORDER BY a_grupo ASC"); ?>
										<?php else: ?>
										<?php $result = mysql_query("SELECT DISTINCT a_grupo FROM horw WHERE prof='".mb_strtoupper($_SESSION['profi'], 'iso-8859-1')."' AND nivel <> '' AND n_grupo <> '' AND a_asig NOT LIKE '%TUT%' ORDER BY a_grupo ASC"); ?>
										<?php endif; ?>
										<select class="form-control" id="curso" name="curso" onchange="submit()">
											<option value=""></option>
											<?php while ($row = mysql_fetch_array($result)): ?>
											<option value="<?php echo $row['a_grupo']; ?>" <?php echo (isset($curso) && $curso == $row['a_grupo']) ? 'selected' : ''; ?>><?php echo $row['a_grupo']; ?></option>
											<?php endwhile; ?>
										</select>
									</div>
									
								</div>
								
								<div class="col-sm-6">
									
									<div class="form-group">
										<label for="evaluacion">Evaluación</label>
										<select class="form-control" id="evaluacion" name="evaluacion" onchange="submit()">
											<option value=""></option>
											<?php foreach ($evaluaciones as $eval => $desc): ?>
											<option value="<?php echo $eval; ?>" <?php echo (isset($evaluacion) && $evaluacion == $eval) ? 'selected' : ''; ?>><?php echo $desc; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
									
								</div>
								
							</div>
								
							
						</div><!-- /.well -->
						
					</fieldset>
					
				</form>
				
			</div><!-- /.col-sm-12 -->
			
		</div><!-- /.row -->
		

		<?php if (isset($curso) && isset($evaluacion)): ?>
		<div class="row">
		
			<div class="col-sm-12">
			
				<div class="visible-print">
					<h3><?php echo $evaluaciones[$evaluacion]; ?>  de <?php echo $curso; ?></h3>
				</div>
								
				<table class="table table-bordered table-striped table-hover table-vcentered">
					<thead>
						<tr>
							<th>Alumno/a</th>
							<?php $result = mysql_query("SELECT DISTINCT a_asig, asig FROM horw WHERE a_grupo='$curso' AND nivel <> '' AND n_grupo <> '' AND a_asig NOT LIKE '%TUT%' ORDER BY asig ASC") or die (mysql_error()); ?>
							<?php while ($row = mysql_fetch_array($result)): ?>
							<th><abbr rel="tooltip" title="<?php echo $row['asig']; ?>"><?php echo $row['a_asig']; ?></abbr></th>
							<?php endwhile; ?>
						</tr>
					</thead>
					<tbody>
						<?php $result = mysql_query("SELECT apellidos, nombre, claveal FROM alma WHERE unidad='$curso'"); ?>
						<?php $i = 0; ?>
						<?php while ($row = mysql_fetch_array($result)): ?>
						<tr>
							<td nowrap><?php echo $row['apellidos'].', '.$row['nombre']; ?></td>
							<?php $result1 = mysql_query("SELECT DISTINCT c_asig FROM horw WHERE a_grupo='$curso' AND nivel <> '' AND n_grupo <> '' AND a_asig NOT LIKE '%TUT%' ORDER BY asig ASC") or die (mysql_error()); ?>
							<?php while ($row1 = mysql_fetch_array($result1)): ?>
								
							<?php $result2 = mysql_query("SELECT calificaciones FROM evaluaciones WHERE unidad='$curso' AND evaluacion='$evaluacion' AND asignatura='".$row1['c_asig']."'"); ?>
							<?php if (mysql_num_rows($result2)): ?>
							<?php $row2 = mysql_fetch_array($result2); ?>
							<?php $calificaciones = unserialize($row2['calificaciones']); ?>
							<td>
								<?php echo ($calificaciones[$i]['obs'] != "") ? '<span class="pull-right fa fa-question-circle" rel="tooltip" title="'.$calificaciones[$i]['obs'].'"></span>' : ''; ?>
								<?php echo ($calificaciones[$i]['nota'] > 5) ? '<span class="text-success">'.$calificaciones[$i]['nota'].'</span>' : '<span class="text-danger">'.$calificaciones[$i]['nota'].'</span>'; ?>
							</td>
							<?php else: ?>
							<td>&nbsp;</td>
							<?php endif; ?>
							
							<?php endwhile; ?>
						</tr>
						<?php $i++; ?>
						<?php endwhile; ?>
					</tbody>
				</table>
				
				<div class="hidden-print">
					<a href="#" class="btn btn-primary" onclick="javascript:print();">Imprimir</a>
				</div>
				
			</div><!-- /.col-sm-12 -->
			
		</div><!-- /.row -->
		<?php endif; ?>
	
	</div><!-- /.container -->

<? include("../../pie.php");?>
 
</body>
</html>
