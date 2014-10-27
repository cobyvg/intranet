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

if (isset($_POST['aula'])) {$aula = $_POST['aula'];} elseif (isset($_GET['aula'])) {$aula = $_GET['aula'];} else{$aula="";}

include("../../menu.php");
?>

	<div class="container">
		
		<!-- TITULO DE LA PAGINA -->
		<div class="page-header">
			<h2><?php echo $aula; ?> <small>Consulta de horario</small></h2>
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
							<?php $horas = array(1 => "1ª", 2 => "2ª", 3 => "3ª", 4 => "4ª", 5 => "5ª", 6 => "6ª"); ?>
							<?php foreach($horas as $hora => $desc): ?>
							<tr>
								<th><?php echo $desc; ?></th>
								<?php for($i = 1; $i < 6; $i++): ?>
								<td width="20%">
									<?php $result = mysqli_query($db_con, "SELECT DISTINCT asig, prof FROM horw WHERE n_aula='$aula' AND dia='$i' AND hora='$hora'"); ?>
									<?php while($row = mysqli_fetch_array($result)): ?>
									<?php echo $row['asig']; ?><br>
									<span class="text-info"><?php echo nomprofesor($row['prof']); ?></span>
									<br>
									<?php endwhile; ?>
								</td>
								<?php endfor; ?>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
				
				<div class="hidden-print">
					<a class="btn btn-primary" href="#" onclick="javascript:print();">Imprimir</a>
					<a class="btn btn-default" href="chorarios.php">Volver</a>
				</div>
				
			</div><!-- /.col-sm-12 -->
		
		</div><!-- /.row -->
	
	</div><!-- /.container -->

<?php include("../../pie.php"); ?>

</body>
</html>
