<?
ini_set("memory_limit","192M");
session_start();
include("../../config.php");
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



$idea = $_SESSION['ide'];
if (isset($_POST['profesor'])) {$profesor = $_POST['profesor'];} else{$profesor="";}


// COMPROBAMOS SI EL PROFESOR HA SUBIDO SU FOTOGRAFIA
$foto = 0;
if(file_exists("../../xml/fotos_profes/".$_SESSION['ide'].".jpg")){
	$ruta = '../../xml/fotos_profes/'.$_SESSION['ide'].'.jpg?t'.time();
	$foto = 1;
}


// ENVIO DEL FORMULARIO
if (isset($_POST['enviar'])) {
	
	$fotografia = $_FILES['foto']['tmp_name'];
	
	if (empty($fotografia)) {
		$msg_error = "Todos los campos del formulario son obligatorios.";
	}
	else {
		
		require('../../lib/class.Images.php');
		$image = new Image($fotografia);
		$image->resize(240,320,'crop');
		$image->save($_SESSION['ide'], '../../xml/fotos_profes/', 'jpg');
		
		if (isset($_GET['tour']) && $_GET['tour']) {
			header('Location:'.'../../index.php?tour=1');
		}
		else {
			$msg_success = "La fotografía se ha actualizado.";
		}
		
	}
	
}


include("../../menu.php");
?>

<div class="container">
	
	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
		<h2><?php echo (isset($_GET['tour']) && $_GET['tour']) ? 'Para terminar. Suba o actualice su fotografía.' : 'Fotografías <small>Profesores</small>'; ?></h2>
	</div>
	
	<!-- MENSAJES -->
	<?php if(isset($msg_error)): ?>
	<div class="alert alert-danger" role="alert">
		<?php echo $msg_error; ?>
	</div>
	<?php endif; ?>
	
	<?php if(isset($msg_success)): ?>
	<div class="alert alert-success" role="alert">
		<?php echo $msg_success; ?>
	</div>
	<?php endif; ?>
	
	
	<!-- SCAFFOLDING -->
	<div class="row">
	
		<!-- COLUMNA IZQUIERDA -->
		<div class="col-sm-6">
			
			<div class="well">
				
				<form method="post" action="" enctype="multipart/form-data">
					<fieldset>
						<legend><?php echo $foto ? 'Actualizar' : 'Subir'; ?> fotografía</legend>
						
						<div class="row">
							<?php if($foto): ?>
							<!-- FOTO -->
							<div class="col-sm-4">
								<img class="img-thumbnail" src="<?php echo $ruta; ?>" alt="<?php echo $_SESSION['profi']; ?>" width="140">
							</div>
							<?php endif; ?>
							
							<!-- FORMULARIO -->
							<div class="<?php echo $foto ? 'col-sm-8' : 'col-sm-12'; ?>">
							
								<div class="form-group">
									<label for="foto">Fotografía (formato JPEG)</label>
								  <input type="file" id="foto" name="foto" accept="image/jpeg">
								</div>
								
								<br>
								
								<button type="submit" class="btn btn-primary" name="enviar"><?php echo $foto ? 'Actualizar' : 'Subir'; ?> fotografía</button>
								<?php if (isset($_GET['tour']) && $_GET['tour']): ?>
								<a href="../../index.php?tour=1" class="btn btn-default">Omitir</a>
								<?php endif; ?>
							</div>
						</div>
					  
				  </fieldset>
				</form>
				
			</div><!-- /.well -->
			
		</div><!-- /.col-sm-6 -->
		
		
		<!-- COLUMNA DERECHA -->
		<div class="col-sm-6">
			
				
			<h3>Información sobre las fotografías</h3>
			
			<p>La foto debe cumplir la norma especificada:<p>
			 	
			<ul>
				<li>Tener el fondo de un único color, liso y claro.</li>
				<li>La foto ha de ser reciente y tener menos de 6 meses de antigüedad.</li>
				<li>Foto tipo carnet, la imagen no puede estar inclinada, tiene que mostrar la cara claramente de frente.</li>
				<li>Fotografía de cerca que incluya la cabeza y parte superior de los hombros, la cara ocuparía un 70-80% de la fotografía.</li>
				<li>Fotografía perfectamente enfocada y clara.</li>
			</ul>
				
			<?php if (!isset($_GET['tour']) && !$_GET['tour']): ?>
			<form method="post" action="profes.php">
				<button type="submit" class="btn btn-info btn-block" name="ver_todos">Todas las fotografías</button>
			</form>
			<?php endif; ?>
			
		</div><!-- /.col-sm-6 -->
	
	</div><!-- /.row -->
	
</div><!-- /.container -->

<? include("../../pie.php");?>
</body>
</html>
