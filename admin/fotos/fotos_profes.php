<?
ini_set("memory_limit","192M");
session_start();
include("../../config.php");
if($_SESSION['autentificado']!='1')
{
	session_destroy();
	header("location:http://$dominio/intranet/salir.php");
	exit;
}
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);

$idea = $_SESSION ['ide'];
if (isset($_POST['profesor'])) {$profesor = $_POST['profesor'];} else{$profesor="";}
if (isset($_POST['idea'])) {$idea = $_POST['idea'];}


// COMPROBAMOS SI EL PROFESOR HA SUBIDO SU FOTOGRAFIA
if(file_exists("../../xml/fotos_profes/".$idea.".jpg")){
	$grande = filesize("../../xml/fotos_profes/".$idea.".jpg");
	$foto = 1;	
}
	
if ($foto) {
	$ruta = '../../xml/fotos_profes/'.$idea.'.jpg?t'.date('Hmi');
}


include("../../menu.php");
?>

<div class="container">
	
	<!-- ERRORES -->
<?php
if (isset($_POST['enviar']))
{
	$ok=0;
	if ($_FILES['File']['size']>0) {
	
	$fotos_dir = "../../xml/fotos_profes/";
	
	if ($_FILES['File']['size']>'30000' and $_FILES['File']['size']<'2000000') {
		
		if (stristr($_FILES['File']['type'],"image/jp")==TRUE) {
			
			$extension="jpg";
			$n_foto=$idea.".".$extension;
			$n_foto0=$idea."0.".$extension;
			$arch0 = $fotos_dir.$n_foto0;

			$arch = $fotos_dir.$n_foto;
			move_uploaded_file($_FILES['File']['tmp_name'], $arch0) or die("No se ha actualizado");
			chmod($arch0,0777);

			function redimensionar_jpeg($img_original, $img_nueva, $img_nueva_anchura, $img_nueva_altura, $img_nueva_calidad) {
				// crear imagen desde original
				$img = ImageCreateFromJPEG($img_original);
				// crear imagen nueva
				$thumb = ImageCreatetruecolor($img_nueva_anchura,$img_nueva_altura);
				// redimensionar imagen original copiandola en la imagen
				ImageCopyResampled($thumb,$img,0,0,0,0,$img_nueva_anchura,$img_nueva_altura,ImageSX($img),ImageSY($img));
				// guardar la imagen redimensionada donde indicia $img_nueva
				ImageJPEG($thumb,$img_nueva,$img_nueva_calidad);
			}
			// Calcular tamaño ideal
			$tam = getimagesize($arch0);
			$ancho0 = $tam[0];
			$alto0 = $tam[1];
			$cent = 600 * 100 / $ancho0;
			$cent_alto = $cent *$alto0 / 100;

			redimensionar_jpeg($arch0,$arch,600,$cent_alto,100);
			$nuevo_tamaño = filesize($arch);
			$foto=1;
			copy($arch0,"../../xml/fotos/".$idea.".jpg");
			unlink($arch0);
		}
		else {
			$ok = 1;
			echo '<div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<legend>ATENCIÓN:</legend>
El archivo que est&aacute;s enviando no es un tipo de imagen v&aacute;lido. Selecciona un archivo de imagen con formato JPG.
          </div></div>';
		}
	}
	else{
		
		if ($_FILES['File']['size']< '30000') {
			$ok = 1;
		echo '<div class="alert alert-warning alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<legend>ATENCIÓN:</legend>
La fotograf&iacute;a no tiene suficiente resoluci&oacute;n, por lo que su visualizaci&oacute;n ser&aacute; necesariamente defectuosa. Es conveniente que actualices la foto eligiendo una nueva con mayor calidad. 
          </div>';
		}
		else{
		$ok = 1;
		echo '<div class="alert alert-warning alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<legend>ATENCIÓN:</legend>
La fotograf&iacute;a tiene excesiva resoluci&oacute;n. Es conveniente que actualices la foto eligiendo una nueva con menor resolución (o tamaño, como quieras). 
          </div>';	
		}
	}
	if ($ok==0) {
		echo '<div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<legend>ATENCIÓN:</legend>
            La fotografía se ha actualizado correctamente. Si la foto que ves abajo es la antigua, sal de est página y vuelve a entrar: comprobarás que la foto se ha actualizado.
          </div>';	
	}	
	}
	else{
		$ok = 1;
	echo '
	<div class="alert alert-danger alert-block fade in">
		<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>		<strong>Error:</strong> No has seleccionado ninguna fotografía. Elige un archivo con la fotografía e inténtalo de nuevo.
	</div>';
	}
}
?>
	
	
	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
		<h2>Fotografías <small>Profesores</small></h2>
	</div>
	
	
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
								  <input type="file" name="File" value="" accept="image/*">
								  <p class="help-block">La fotografía debe tener una resolución mínima de 40KB y máxima de 1MB. El archivo de imagen debe ser JPG.</p>
								</div>
								
								<button type="submit" class="btn btn-primary" name="enviar"><?php echo $foto ? 'Actualizar' : 'Subir'; ?> fotografía</button>
								
							</div>
						</div>
					  
				  </fieldset>
				</form>
				
			</div><!-- /.well -->
			
		</div><!-- /.col-sm-6 -->
		
		
		<!-- COLUMNA DERECHA -->
		<div class="col-sm-6">
			
			<div class="well">
				
				<form method="post" action="">
					<fieldset>
						<legend>Consulta individual</legend>
						
						<div class="form-group">
							<?php $result = mysql_query("SELECT DISTINCT profesor FROM profesores ORDER BY profesor"); ?>
							<?php if(mysql_num_rows($result)): ?>
						  <select class="form-control" name="profesor" onchange="submit()">
						  	<option></option>
								<?php while($row = mysql_fetch_array($result)): ?>
								<option value="<?php echo $row['profesor']; ?>" <?php echo ($profesor == $row['profesor']) ? 'selected' : ''; ?>><?php echo $row['profesor']; ?></option>			
								<?php endwhile; ?>
						  </select>
						  <?php else: ?>
						  <select class="form-control" name="profesor" disabled></select>
						  <?php endif; ?>
						</div>
					  
<?php
if ($profesor) {
	$result = mysql_query("SELECT idea FROM departamentos WHERE nombre='$profesor'");
	$foto_profesor = mysql_fetch_array($result);
	
	$ruta = "../../xml/fotos_profes/".$foto_profesor['idea'].".jpg";
	
	if(file_exists($ruta)) {
		echo "<div class=\"text-center\">\n";
		echo "\t<img class=\"img-thumbnail\" src=\"".$ruta."\" alt=\"".$foto_profesor['idea']."\" width=\"140\">\n";
		echo "</div>\n";
	}
}
?>
				  </fieldset>
				</form>
				
			</div><!-- /.well -->
			
			<form method="post" action="profes.php">
				<button type="submit" class="btn btn-info btn-block" name="ver_todos">Todas las fotografías</button>
			</form>
			
		</div><!-- /.col-sm-6 -->
	
	</div><!-- /.row -->
	
</div><!-- /.container -->

<? include("../../pie.php");?>
</body>
</html>
