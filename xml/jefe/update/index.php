<?
session_start();

include("../../../config.php");
if($_SESSION['autentificado']!='1') {
	session_destroy();
	header("location:http://$dominio/intranet/salir.php");	
	exit;
}

registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);

if(!(stristr($_SESSION['cargo'],'1') == TRUE)) {
	header("location:http://$dominio/intranet/salir.php");
	exit;	
}

if (isset($_POST['enviar'])) {

	if (is_uploaded_file($_FILES['archivo']['tmp_name'])) {
		
		$directorio = $raiz_dir;
		$nombre = $_FILES['archivo']['name'];
		
		$filename = $directorio . $nombre;
		
		move_uploaded_file($_FILES['archivo']['tmp_name'], $filename);
	}
	
	if (file_exists($filename) && is_readable($filename)) {
		
		$command = "unzip $filename -d $directorio";
		shell_exec($command);
		
		
		$dir = opendir($directorio.'/intranet-master');
		
		$lista_archivos = array('.','..','.gitignore');
		
		while (false != ($archivo = readdir($dir))) {
			
			if(!in_array($archivo, $lista_archivos)) {
				$command = "mv $archivo $directorio.$archivo";
				shell_exec($command);
			}
		}
		
		closedir($dir);
		
	}
}

include("../../../menu.php");
?>

<div class="container">
	
	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
		<h2>Administración <small>Actualización de la Intranet</small></h2>
	</div>
	
	
	<!-- SCAFFOLDING -->
	<div class="row">
	
		<!-- COLUMNA IZQUIERDA -->
		<div class="col-sm-6 col-sm-offset-3">
			
			<div class="well">
				
				<form enctype="multipart/form-data" method="post" action="">
					<fieldset>
						<legend>Actualización de la Intranet</legend>

						<div class="form-group">
						  <label for="archivo"><span class="text-info">intranet-master.zip</span></label>
						  <input type="file" id="archivo" name="archivo" accept="application/zip">
						</div>
						
						<br>
						
					  <button type="submit" class="btn btn-primary" name="enviar">Actualizar</button>
					  <a class="btn btn-default" href="../../index.php">Volver</a>
				  </fieldset>
				</form>
				
			</div><!-- /.well -->
			
		</div><!-- /.col-sm-6 -->
		
	
	</div><!-- /.row -->
	
</div><!-- /.container -->
  
<?php include("../../../pie.php"); ?>
	
</body>
</html>
