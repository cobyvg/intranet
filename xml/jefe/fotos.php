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


if(!(stristr($_SESSION['cargo'],'1') == TRUE))
{
	header('Location:'.'http://'.$dominio.'/intranet/salir.php');
	exit;
}
?>
<?php
include("../../menu.php");
?>
<div align="center">
<div class="page-header">
<h2>Administración <small> Importación masiva de fotos</small></h2>
</div>
<br />
<div class="well well-large"
	style="width: 700px; margin: auto; text-align: left"><?php
	$fotos_dir = "../fotos";

	//Descomprimimos el archivo .zip con la fotos
	include('../../lib/pclzip.lib.php');
	$archive = new PclZip($_FILES['archivo']['tmp_name']);
	if ($archive->extract(PCLZIP_OPT_PATH, $fotos_dir) == 0)
	{
		die('<div align="center"><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>Atención:</strong><br />
Ha surgido un problema al importar las fotos. Una de dos: o tu servidor no admite la subida de archivos con PHP porque la directiva <em>file_uploads</em> está desactivada ( Off ) o el 
tamaño máximo de archivo para subir al servidor es inferior al del archivo comprimido que estás intentando subir.
Tienes dos opciones para solucionar el problema: o bien te aseguras de que la directiva <em>file_uploads</em> está activada ( On ) y aumentas el tamaño de 
<em>upload_max_filesize</em> en el archivo de configuración de PHP <em>php.ini</em>, o bien comprime las fotos en varios paquetes pequeños ( 32MB, p. ej. )
 y los subes uno tras otro. Tu decides.
</div></div><br />
<div align="center">
  <input type="button" value="Volver atrás" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
</div>');
	}
	?> <br />
	<?
	if ($_POST['tabla']=='1') {
		// Si no existe la tabla, la creamos por compatibilidad con versiones anteriores.
		mysqli_query($db_con,"CREATE TABLE IF NOT EXISTS `fotos` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nombre` varchar(18) NOT NULL,
  `datos` mediumblob NOT NULL,
  `fecha` datetime NOT NULL,
  `tamaño` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1");
	}
	// Comprobamos estado del directorio con las fotos.

	$d = dir($fotos_dir);
	while (false !== ($entry = $d->read())) {
		$n_file+=1;
			
		//Introducir fotos en base de datos

		if ($_POST['tabla']=='1') {
			$nombre=$entry;
			if (strlen($nombre)>'9') {
				$ruta = $fotos_dir."/".$nombre;
				$grande = filesize($ruta);
				$ya = mysqli_query($db_con,"select * from foros where nombre = '$nombre'");
				if (mysqli_num_rows($ya)>0) {}
				else{
					mysqli_query($db_con,"insert INTO fotos (nombre, datos, fecha, tamaño) VALUES('$nombre', LOAD_FILE('$ruta'),now(), '$grande')");					
					$num+=mysqli_affected_rows($db_con);
				}
			}
		}
	}

// Directorio vacío
	if ($n_file<5) {
		echo '<div align="center"><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>Atención:</strong><br />
Ha surgido un problema al importar las fotos. Parece que el directorio donde deben ser copiadas no existe o está vacío porque las fotos no se han subido correctamente. 
Comprueba el estado del directorio (debe tener permiso de escritura) e inténtalo de nuevo.
</div></div><br />
<div align="center">
  <input type="button" value="Volver atrás" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
</div>';
		exit();
	}
	else{
		echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Las fotos se han subido correctamente al directorio correspondiente. Hay <strong>'. $n_file .'</strong> fotos de alumnos en el directorio.
</div></div><br />
<div align="center">
  <input type="button" value="Volver atrás" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
</div>';
	}
	$d->close();
	?></div>
</div>
	<?php include("../../pie.php");	?>
