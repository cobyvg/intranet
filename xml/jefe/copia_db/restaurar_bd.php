<?
session_start();
include("../../../config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);
$profe = $_SESSION['profi'];
if(!(stristr($_SESSION['cargo'],'1') == TRUE))
{
header("location:http://$dominio/intranet/salir.php");
exit;	
}

include("../../../menu.php");
?>

<div class="container">
	
	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
		<h2>Administración <small>Restaurar base de datos</small></h2>
	</div>
	
	
	<!-- SCAFFOLDING -->
	<div class="row">
	
		<!-- COLUMNA IZQUIERDA -->
		<div class="col-sm-6">
			
			<div class="well">
				
				<form enctype="multipart/form-data" method="post" action="restore_db.php">
					<fieldset>
						<legend>Restaurar base de datos</legend>

						<div class="form-group">
						  <label for="archivo"><span class="text-info">db-backup.gz</span></label>
						  <input type="file" id="archivo" name="archivo" accept="application/gzip">
						</div>
						
						<br>
						
					  <button type="submit" class="btn btn-primary" name="enviar">Restaurar</button>
					  <a class="btn btn-default" href="dump_db.php">Volver</a>
				  </fieldset>
				</form>
				
			</div><!-- /.well -->
			
		</div><!-- /.col-sm-6 -->
		
		
		<div class="col-sm-6">
			
			<h3>Información sobre la restauración</h3>
			
			<p>Si dispones de una copia de seguridad de la base de datos puedes realizar su restauración. Recuerda que los datos actuales se eliminarán. Una vez enviado el archivo el proceso tardará unos segundos, ten paciencia.</p>
			
		</div>
		
	
	</div><!-- /.row -->
	
</div><!-- /.container -->
  
<?php include("../../../pie.php"); ?>
	
</body>
</html>
