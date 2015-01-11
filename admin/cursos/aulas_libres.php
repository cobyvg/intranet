<?
session_start();
include("../../config.php");
include_once('../../config/version.php');

// COMPROBAMOS LA SESION
if ($_SESSION['autentificado'] != 1) {
	$_SESSION = array();
	session_destroy();
	
	if(isset($_SERVER['HTTPS'])) {
	    if ($_SERVER["HTTPS"] == "on") {
	        header('Location:'.'https://'.$dominio.'/intranet/salir.php');
	        exit();
	    } 
	}
	else {
		header('Location:'.'http://'.$dominio.'/intranet/salir.php');
		exit();
	}
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



$profesor = $_SESSION['profi'];

if (isset($_POST['n_dia'])) {$n_dia = $_POST['n_dia'];} elseif (isset($_GET['n_dia'])) {$n_dia = $_GET['n_dia'];} else{$n_dia="";}
if ($n_dia == 'Lunes') {	$dia = '1';}
if ($n_dia == 'Martes') { $dia = '2';}
if ($n_dia == 'Miércoles') {	$dia = '3';}
if ($n_dia == 'Jueves') {	$dia = '4';}
if ($n_dia == 'Viernes') {	$dia = '5';}

include("../../menu.php");
?>

	<div class="container">
		
		<!-- TITULO DE LA PAGINA -->
		<div class="page-header">
			<h2><?php echo $n_dia; ?> <small>Consulta de aulas libres</small></h2>
		</div>
		
		<!-- SCAFFOLDING -->
		<div class="row">
		
			<div class="col-sm-12">
				
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>08:15 - 09:15</th>
								<th>09:15 - 10:15</th>
								<th>10:15 - 11:15</th>
								<th>11:45 - 12:45</th>
								<th>12:45 - 13:45</th>
								<th>13:45 - 14:45</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<?php for($i = 1; $i < 7; $i++): ?>
								<td>
								<?php $result = mysqli_query($db_con, "SELECT DISTINCT a_aula, n_aula FROM horw WHERE a_aula NOT LIKE 'B%' AND a_aula NOT LIKE 'G%' AND a_aula NOT LIKE '' AND a_aula NOT LIKE 'ACO%' AND a_aula NOT LIKE 'DI%' ORDER BY n_aula ASC"); ?>
								<?php while ($row = mysqli_fetch_array($result)): ?>
								<?php $grupo = mysqli_query($db_con, "SELECT a_grupo FROM horw where a_aula = '$row[0]' AND dia='$dia' AND hora='$i' AND a_grupo NOT LIKE 'B%' AND a_grupo NOT LIKE 'G%' ORDER BY a_grupo ASC"); ?>

								<?php $asig = mysqli_fetch_array($grupo); ?>
								<?php if($asig['a_grupo'] == ''): ?>
									<p><a href="hor_aulas.php?aula=<?php echo $row['n_aula']; ?>"><?php echo $row['n_aula']; ?></a></p>
								<?php endif; ?>
								<?php endwhile; ?>
								</td>
								<?php endfor; ?>
							</tr>
						</tbody>
					</table>
				</div>
				
				<div class="hidden-print">
					<a class="btn btn-primary" href="#" onclick="javascript:print();">Imprimir</a>
					<a class="btn btn-default" href="chorarios.php">Volver</a>
				</div>
			
			</div>
			
		</div>
		
	</div>

<?php include("../../pie.php"); ?>

</body>
</html>
