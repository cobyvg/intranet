<?
session_start();
include("../config.php");
include_once('../config/version.php');
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



// RECOPILACION DE INFORMACION
$exp_inicio_curso = explode('-', $inicio_curso);
$inicio_curso_sql = $exp_inicio_curso[2].'-'.$exp_inicio_curso[1].'-'.$exp_inicio_curso[0];

mysqli_query($db_con, "TRUNCATE TABLE usuario");

$result = mysqli_query($db_con, "SELECT DISTINCT profesor FROM $bd.profesores ORDER BY profesor ASC");
while ($row = mysqli_fetch_array($result)) {
	
	$profesor = $row[0];

	for ($i = 1; $i <= $num_carrito; $i++) {
	
		$result1 = mysqli_query($db_con, "SELECT eventdate FROM carrito$i WHERE date(eventdate) > '$inicio_curso_sql' AND (event1='$profesor' OR event2='$profesor' OR event3='$profesor' OR event4='$profesor' OR event5= '$profesor' OR event6='$profesor' OR event7='$profesor')") or die ("Error in query: $query. " . mysqli_error($db_con));
		
		$dias_profesor = mysqli_num_rows($result1);	
		
		if ($dias_profesor > 0) {
			
			$result2 = mysqli_query($db_con, "SELECT profesor FROM usuario WHERE profesor='$profesor'");
			
			if (!mysqli_num_rows($result2)) {
				mysqli_query($db_con, "INSERT INTO usuario SET profesor='$profesor', c$i='$dias_profesor'");
			}
			else {
				mysqli_query($db_con, "UPDATE usuario SET c$i='$dias_profesor' WHERE profesor='$profesor'");
			}
			
			mysqli_free_result($result2);
		}
		
		mysqli_free_result($result1);
	}
}
mysqli_free_result($result1);



include("../menu.php");
include("../TIC/menu.php");
?>

	<div class="container">
		
		<!-- TITULO DE LA PAGINA -->
		<div class="page-header">
			<h2>Centro TIC <small>Estadísticas de las TIC</small></h2>
		</div>
		
		<!-- SCAFFOLDING -->
		<div class="row">
		
			<!-- COLUMNA IZQUIERDA -->
			<div class="col-sm-4">
				
				<h3>Información de carros TIC</h3>
				
				<br>
				
				<?php for ($i = 1; $i <= $num_carrito; $i++): ?>
				<?php $result = mysqli_query($db_con, "SELECT eventdate FROM `carrito$i` WHERE DATE(eventdate) > '$inicio_curso_sql'"); ?>
				<?php $n_dias = mysqli_num_rows($result); ?>
				<?php $n_horas = 0; ?>
				<?php if ($n_dias): ?>
				<?php while ($row = mysqli_fetch_array($result)): ?>
				<?php $result1 = mysqli_query($db_con, "SELECT * FROM `carrito$i` WHERE eventdate='".$row['eventdate']."'"); ?>
				<?php $row1 = mysqli_fetch_array($result1); ?>
				<?php for ($j = 3; $j < 10; $j++): ?>
				<?php if(!empty($row1[$j])): ?>
				<?php $n_horas = $n_horas+1; ?>
				<?php endif; ?>
				<?php endfor; ?>
				<?php endwhile; ?>
				<?php endif; ?>

				<table class="table table-bordered">
					<thead>
						<tr>
							<th colspan="2">Carro TIC <?php echo $i; ?></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th class="col-sm-9">Total días de uso</th>
							<td class="col-sm-3"><span class="text-info"><?php echo $n_dias; ?></span></td>
						</tr>
						<tr>
							<th>Total horas de uso</th>
							<td><span class="text-info"><?php echo $n_horas; ?></span></td>
						</tr>
					</tbody>
				</table>
				
				<?php endfor; ?>
								
			</div><!-- /.col-sm-4 -->
			
			
			<!-- COLUMNA DERECHA -->
			<div class="col-sm-8">
				
				<h3>Información de uso por profesor</h3>
				
				<br>
				
				<div class="table-responsive">
					<table class="table table-bordered table-hover">
						<thead>
							<th>Profesor/a</th>
							<?php for ($i = 1; $i <= $num_carrito; $i++): ?>
							<th class="text-center">C. TIC <?php echo $i; ?></th>
							<?php endfor; ?>
						</thead>
						<tbody>
							<?php $result = mysqli_query($db_con, "SELECT * FROM usuario"); ?>
							<?php while ($row = mysqli_fetch_array($result)): ?>
							<tr>
								<td><?php echo $row['profesor']; ?></td>
								<?php for ($i = 1; $i <= $num_carrito; $i++): ?>
								<td class="text-center"><span class="text-info"><?php echo $row['c'.$i]; ?></span></td>
								<?php endfor; ?>
							</tr>
							<?php endwhile; ?>
						</tbody>
					</table>
				</div>
				<p class="text-muted"><small class="pull-right">Total de días que el profesor/a ha reservado un carro TIC.</small></p>
								
			</div><!-- /.col-sm-8 -->
					
		</div><!-- /.row -->
		
		<div class="row">
		
			<div class="col-sm-12">
			
				<div class="hidden-print">
					<a href="#" class="btn btn-primary" onclick="javascript:print();">Imprimir</a>
				</div>
				
			</div>
			
		</div>
		
	</div><!-- /.container -->
  
<?php include("../pie.php"); ?>

</body>
</html>
