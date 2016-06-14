<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1));


if (isset($_GET['id'])) $id = $_GET['id']; elseif (isset($_POST['id'])) $id = $_POST['id']; else $id="";
if (isset($_GET['profesor'])) $profesor = $_GET['profesor']; 
elseif (isset($_POST['profesor'])) $profesor = $_POST['profesor']; 
else {
	$result = mysqli_query($db_con, "SELECT DISTINCT prof FROM horw WHERE c_asig NOT IN (SELECT DISTINCT idactividad FROM actividades_seneca WHERE idactividad <> '2' AND idactividad <> '21') ORDER BY prof ASC LIMIT 1");
	$row = mysqli_fetch_array($result);
	$profesor = $row['prof'];
}


if ($no_dia== '1') {$nombre_dia = 'Lunes';}
if ($no_dia== '2') {$nombre_dia = 'Martes';}
if ($no_dia== '3') {$nombre_dia = 'Miércoles';}
if ($no_dia== '4') {$nombre_dia = 'Jueves';}
if ($no_dia== '5') {$nombre_dia = 'Viernes';}
$mes=date('m');
$dia_n = date('d');
$ano = date('Y');
$numerodiasemana = date('w', mktime(0,0,0,$mes,$dia_n,$ano));

if ($no_dia> $numerodiasemana) {
	$dif = $no_dia- $numerodiasemana;
	$g_dia = date('d')+$dif;
}
if ($no_dia< $numerodiasemana) {
	$dif = $numerodiasemana - $no_dia;
	$g_dia = date('d')-$dif;
}
if ($no_dia== $numerodiasemana) {
	$dif = 0;
	$g_dia = date('d');
}
if ($g_dia=="") {
	$g_dia = date('d');
}
$g_fecha = date("Y-m-$g_dia");
$fecha_sp = formatea_fecha($g_fecha);

include("../../menu.php");
include("menu.php");
?>

<style type="text/css">
@media print {
	.col-print-100 {
		width: 100% !important;
	}
}
</style>

<div class="container">
	
	<div class="page-header">
		<form method="post" action="">
			<div class="pull-right">
				<?php $result = mysqli_query($db_con, "SELECT DISTINCT prof FROM horw WHERE c_asig NOT IN (SELECT DISTINCT idactividad FROM actividades_seneca WHERE idactividad <> '2' AND idactividad <> '21') ORDER BY prof ASC"); ?>
				<?php if(mysqli_num_rows($result)): ?>
				<select class="form-control input-sm" id="profesor" name="profesor" onchange="submit()" style="width:280px;">
					<?php while($row = mysqli_fetch_array($result)): ?>
					<option value="<?php echo nomprofesor($row['prof']); ?>"<?php echo ($profesor == $row['prof']) ? 'selected' : ''; ?>><?php echo nomprofesor($row['prof']); ?></option>
					<?php endwhile; ?>
				</select> 
				<?php else: ?>
				<select class="form-control" id="tutor" name="tutor" disabled>
					<option value=""></option>
				</select>
				<?php endif; ?>
				<?php mysqli_free_result($result); ?>
			</div>
		</form>
		
		<h2 style="display: inline;">Guardias de aula <small>Consulta por profesores</small></h2>
	</div>
	
	<?php if (isset($_GET['borrar']) && $_GET['borrar'] == 1): ?>
	<?php mysqli_query($db_con, "DELETE FROM guardias WHERE id='$id' LIMIT 1"); ?>
	<div class="alert alert-success alert-block fade in">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		La sustitución ha sido borrada correctamente. Puedes comprobarlo en la tabla de la derecha.
	</div>
	<?php endif; ?>
	
	<div class="row">
	
		<div class="col-sm-12">
			<h3><?php echo nomprofesor($profesor); ?></h3>
		</div><!-- /.col-sm-12 -->
	
	</div><!-- /.row -->
	
	<br>
	
	<div class="row">

		<div class="col-sm-5 col-print-100">
		<?php if (isset($profesor) && !empty($profesor)): ?>
		<?php include("inc_horario.php"); ?>
		<?php endif; ?>
		</div><!-- /.col-sm-5 -->

		<div class="col-sm-7 col-print-100">
			
			<h4><span class="fa fa-history fa-fw"></span> Histórico de guardias</h4>

			<?php $result = mysqli_query($db_con, "SELECT id, profesor, profe_aula, fecha_guardia, dia, hora, turno FROM guardias WHERE profesor = '$profesor' ORDER BY fecha_guardia DESC"); ?>
			<?php if (mysqli_num_rows($result)): ?>
			
			<div class="table-responsive">
				<table class="table table-bordered table-striped" style="font-size: 0.9em;">
					<thead>
						<tr>
							<th>Profesor ausente</th>
							<th>Fecha</th>
							<th>Hora</th>
							<th>Turno</th>
							<th class="hidden-print"></th>
						</tr>
					</thead>
					<tbody>
						<?php while ($row = mysqli_fetch_array($result)): ?>
						<tr>
							<td><?php echo nomprofesor($row['profe_aula']); ?></td>
							<td><?php echo strftime('%A %e, %B %Y' ,strtotime($row['fecha_guardia'])); ?></td>
							<td><?php echo $row['hora']; ?>ª</td>
							<td><?php if ($row['turno'] == 1) echo '1 hora'; elseif ($row['turno'] == 2) echo '1ª media hora'; else echo '2ª media hora'; ?></td>
							<td class="hidden-print">
								<a href="?id=<?php echo $row['id']; ?>&borrar=1&profesor=<?php echo $row['profesor']; ?>" data-bb="confirm-delete" data-bs="tooltip" title="Borrar"><span class="fa fa-trash fa-lg fa-fw"></span></a>
							</td>
						</tr>
						<?php endwhile; ?>
					</tbody>
				</table>
			</div>
			
			<?php else: ?>
			
			<br><br>
			<p class="text-lead text-muted text-center">No hay guardias registradas.</p>
			<br><br>
			
			<?php endif; ?>

		</div><!-- /.col-sm-7 -->
	
	</div><!-- /.row -->
	
	<br>
	
	<div class="row">
		
		<div class="col-sm-12">
			<div class="hidden-print">
				<a class="btn btn-primary" href="#" onclick="javascript:print();">Imprimir</a>
			</div>
		</div>
		
	</div>
	
</div><!-- /.container -->

	<?php include("../../pie.php"); ?>
	
</body>
</html>