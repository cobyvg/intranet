<?
session_start();
include("../../config.php");
	if((!(stristr($_SESSION['cargo'],'1') == TRUE)) and (!(stristr($_SESSION['cargo'],'c') == TRUE)) )
{
header("location:http://$dominio/intranet/salir.php");
exit;	
}

if($_SESSION['cambiar_clave']) {
	header('Location:'.'http://'.$dominio.'/intranet/clave.php');
}

registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);

$crea ="CREATE TABLE IF NOT EXISTS `morosos` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `curso` varchar(64) NOT NULL,
  `apellidos` varchar(60) NOT NULL,
  `nombre` varchar(25) NOT NULL,
  `ejemplar` varchar(100) NOT NULL,
  `devolucion` varchar(10) NOT NULL,
  `hoy` date NOT NULL ,
  `amonestacion` varchar(2) NOT NULL DEFAULT 'NO',
  `sms` VARCHAR( 2 ) NOT NULL DEFAULT  'NO', 
  PRIMARY KEY (`id`)
) ";
mysqli_query($db_con, $crea);


include("../../menu.php");
include("menu.php");
?>

	<div class="container">
		
		<!-- TITULO DE LA PAGINA -->
		<div class="page-header">
		  <h2>Biblioteca <small>Gestión de los Préstamos</small></h2>
		</div>
		
		<!-- SCAFFOLDING -->
		<div class="row">
		
			<div class="col-sm-6 col-sm-offset-3">
				
				<div class="well">
				
					<form method="post" action="consulta.php">
					
						<fieldset>
							<legend>Gestión de los Préstamos</legend>
							
							<div class="form-group">
								<label for="fecha">Elige una fecha</label>
								<?php $result = mysqli_query($db_con, "SELECT DISTINCT hoy FROM morosos ORDER BY hoy DESC"); ?>
								<?php if (mysqli_num_rows($result)): ?>
								<select class="form-control" id="fecha" name="fecha">
									<?php while($row = mysqli_fetch_array($result)): ?>
									<option><?php echo $row['hoy']; ?></option>
									<?php endwhile; ?>
								</select>
								<?php else: ?>
								<select class="form-control" id="fecha" name="fecha" disabled>
									<option value=""></option>
								</select>
								<?php endif; ?>
							</div>
							
						</fieldset>
						
						<button type="submit" class="btn btn-primary" name="submit1">Consultar</button>
					
					</form>
					
				</div><!-- /.well -->
			
			</div><!-- /.col-sm-6 -->
			
		</div><!-- /.row -->
		
	</div><!-- /.container -->

<?php include("../../pie.php"); ?>

</body>
</html>
