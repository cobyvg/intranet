<?
session_start();

include("../../../config.php");
if ($_SESSION['autentificado']!='1') {
	session_destroy();
	header("location:http://$dominio/intranet/salir.php");	
	exit;
}

registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);

$profe = $_SESSION['profi'];

if(!(stristr($_SESSION['cargo'],'1') == TRUE)) {
	header("location:http://$dominio/intranet/salir.php");
	exit;	
}
?>
<?
include("../../../menu.php"); 
$datatables_activado=true;
?>
	
	<div class="container">
	
	<?php
	$query_accesos = mysql_query("SELECT profesor, count(*) AS accesos, (SELECT fecha FROM reg_intranet as r WHERE r.profesor=reg_intranet.profesor ORDER BY fecha DESC LIMIT 1) AS fecha_acceso FROM `reg_intranet` GROUP BY profesor ORDER BY `profesor` ASC");
	?>
		
		<!-- TITULO DE LA PAGINA -->
		
		<div class="page-header">
			<h2 class="page-title" align="center">Informe de accesos a la Intranet</h2>
		</div>
		
		
		<!-- CONTENIDO DE LA PAGINA -->
		
		<div class="row">
			<div class="span8 offset2">
			
			    <div class="no_imprimir">
			      <a href="../../index.php" class="btn btn-default">Volver</a>
			      <a href="#" class="btn btn-primary" onclick="print()"><i class="icon icon-print"></i> Imprimir</a>
			      <br><br>
			    </div>
				
				<table class="table table-bordered table-condensed table-striped tabladatos">
					<thead>
						<tr>
							<th>Profesor/a</th>
							<th>Total accesos</th>
							<th>Fecha último acceso</th>
						</tr>
					</thead>
					<tbody>
					  <?php while ( $row = mysql_fetch_object($query_accesos) ): ?>
					  	<tr>
					  		<td><?php echo $row->profesor; ?></td>
					  		<td><?php echo $row->accesos; ?></td>
					  		<td><?php echo $row->fecha_acceso; ?></td>
					  	</tr>
					  <?php endwhile; ?>
					</tbody>
				</table>
				
			</div><!-- /.span12 -->
		</div><!-- /.row -->
	  
	</div><!-- /.container -->
	
	<br>

<?php include('../../../pie.php'); ?>
	
</body>
</html>