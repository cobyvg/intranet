<?
session_start();
include("../config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}

if($_SESSION['cambiar_clave']) {
	header('Location:'.'http://'.$dominio.'/intranet/clave.php');
}

registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);


include("../menu.php");
include("menu.php");
?>

	<div class="container">
		
		<!-- TITULO DE LA PAGINA -->
		<div class="page-header">
			<h2>Centro TIC <small>Perfiles de profesores</small></h2>
		</div>
		
		<!-- SCAFFOLDING -->
		<div class="row">
		
			<!-- COLUMNA CENTRAL -->
			<div class="col-sm-12">
				
				<div class="table-responsive">	
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Profesor</th>
								<th>Usuario</th>
								<th>Contraseña</th>
								<th>&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							<?php if (stristr($_SESSION['cargo'],'1') == TRUE) $sql_where = ''; else $sql_where = 'WHERE nombre=\''.$_SESSION['profi'].'\' LIMIT 1'; ?>
							<?php $result = mysql_query("SELECT DISTINCT usuario, nombre FROM usuarioprofesor $sql_where"); ?>
							<?php while ($row = mysql_fetch_array($result)): ?>
							<tr>
								<td><?php echo $row['nombre']; ?></td>
								<td><?php echo $row['usuario']; ?></td>
								<td><?php echo $row['usuario']; ?></td>
								<td>
									<a href="http://c0/gesuser/" target="_blank"><span class="fa fa-key fa-fw fa-lg" rel="tooltip" title="Cambiar contraseña"></span></a>
								</td>
							</tr>
							<?php endwhile; ?>
							<?php mysql_free_result($result); ?>
						</tbody>
					</table>
				</div>
				
				<div class="hidden-print">
					<a href="#" class="btn btn-primary" onclick="javascript:print();">Imprimir</a>
				</div>
					
				
			</div><!-- /.col-sm-6 -->
			
		
		</div><!-- /.row -->
		
	</div><!-- /.container -->
  
<?php include("../pie.php"); ?>

</body>
</html>
