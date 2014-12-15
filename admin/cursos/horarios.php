<?
session_start();
include("../../config.php");
include_once('../../config/version.php');

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


$profesor = $_SESSION['profi'];

if (isset($_POST['curso'])) {$curso = $_POST['curso'];} elseif (isset($_GET['curso'])) {$curso = $_GET['curso'];} else{$curso="";}

include("../../menu.php");
?>

	<div class="container">
		
		<!-- TITULO DE LA PAGINA -->
		<div class="page-header">
			<h2><?php echo $curso; ?> <small>Consulta de horario y profesores</small></h2>
		</div>
		
		<!-- SCAFFOLDING -->
		<div class="row">
		
			<div class="col-sm-12">
				
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
							<?php $horas = array(1 => "1ª", 2 => "2ª", 3 => "3ª", 4 => "4ª", 5 => "5ª", 6 => "6ª" ); ?>
							<?php foreach($horas as $hora => $desc): ?>
							<tr>
								<th><?php echo $desc; ?></th>
								<?php for($i = 1; $i < 6; $i++): ?>
								<td width="20%">
									<?php $result = mysqli_query($db_con, "SELECT DISTINCT asig, a_aula, n_aula FROM horw WHERE a_grupo='$curso' AND dia='$i' AND hora='$hora'"); ?>
									<?php while($row = mysqli_fetch_array($result)): ?>
									<?php echo '<div style="display: block; font-size: 0.9em; margin-bottom: 5px;">'; ?>
									<?php echo ($row['a_aula']) ? '<abbr class="text-danger pull-right" data-bs="tooltip" title="'.$row['n_aula'].'">'.$row['a_aula'].'</abbr>' : '<abbr class="text-danger pull-right" data-bs="tooltip" title="Sin asignar o sin aula">Sin aula</abbr>'; ?>
									<?php echo $row['asig']; ?>
									
									<?php echo '</div>'; ?>
									<?php endwhile; ?>
								</td>
								<?php endfor; ?>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			
			</div><!-- /.col-sm-12 -->
		
		</div><!-- /.row -->
		
		<hr>
		
		<div class="row">
		
			<div class="col-sm-12">
	
				<h3>Equipo educativo de la unidad</h3>
				
				<?php $result = mysqli_query($db_con, "SELECT DISTINCT MATERIA, PROFESOR FROM profesores WHERE grupo='$curso'"); ?>
				<?php if(mysqli_num_rows($result)): ?>
				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
							<tr>
								<th class="col-sm-4">Asignatura</th>
								<th class="col-sm-8">Profesor/a</th>
							</tr>
						</thead>
						<tbody>
						<?php while($row = mysqli_fetch_array($result)): ?>
							<tr>
								<td><?php echo $row[0]; ?></td>
								<td><?php echo nomprofesor($row[1]); ?></td>
							</tr>
						<?php endwhile; ?>
						<?php mysqli_free_result($result); ?>
						</tbody>
					</table>
				</div>
				<?php endif; ?>
			
			</div><!-- /.col-sm-12 -->
			
		</div><!-- /.row -->
		
		<div class="hidden-print">
			<a class="btn btn-primary" href="#" onclick="javascript:print();">Imprimir</a>
			<a class="btn btn-default" href="chorarios.php">Volver</a>
		</div>
		
	</div><!-- /.container -->

<?php include("../../pie.php"); ?>

</body>
</html>