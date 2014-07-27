<?
session_start();
include("../../config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);


include("../../menu.php");
?>
  
<div class="container">
	
	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
		<h2>Fotografías <small>Alumnado</small></h2>
	</div>
	
	
	<!-- SCAFFOLDING -->
	<div class="row">
	
		<div class="col-sm-6 col-sm-offset-3">
			
			<div class="well">
				
				<form method="post" action="fotos_alumnos.php" target="_blank">
					<fieldset>
						<legend>Seleccione grupo</legend>
						
						<div class="form-group">
						  <select class="form-control" name="curso">
						  	 <?php unidad(); ?>
						  </select>
						</div>
					  
					  <button type="submit" class="btn btn-primary" name="submit1">Consultar</button>
				  </fieldset>
				</form>
				
			</div><!-- /.well -->
			
		</div><!-- /.col-sm-6 -->
	
	</div><!-- /.row -->
	
</div><!-- /.container -->  

<?php include("../../pie.php"); ?>
</body>
</html>
