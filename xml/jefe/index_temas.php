<?php
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


$profe = $_SESSION['profi'];
if(!(stristr($_SESSION['cargo'],'1') == TRUE))
{
	header("location:http://$dominio/intranet/salir.php");
	exit;
}

include("../../menu.php");
?>

<div class="container"><!-- TITULO DE LA PAGINA -->
<div class="page-header">
<h2>Administración <small>Temas para la aplicación</small></h2>
</div>

<!-- SCAFFOLDING -->
<div class="row"><!-- COLUMNA IZQUIERDA -->
<div class="col-sm-6 col-sm-offset-3"><br>
<?
if (isset($_POST['tema'])) {
	$tema = $_POST['tema'];
	$file = "../../css/temas/$tema";
	$newfile = '../../css/bootstrap.min.css';

	if (!copy($file, $newfile)) {
		echo '<div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
No ha sido posible modificar el tema. ¿Estás seguro de haber concedido permiso de escritura al directorio de la Intranet?
</div><br />';
	}
	if (isset($_POST['inverso'])) {			
		$file = '../../menu.php';
		$current = file_get_contents($file);
		if (stristr($current,"navbar navbar-default")==TRUE) {
			$bar = "navbar navbar-default";
			$bar_inverse = "navbar navbar-inverse";
		}
		else{
			$bar = "navbar navbar-inverse";
			$bar_inverse = "navbar navbar-default";
		}
		$current = str_replace($bar,$bar_inverse,$current);
		file_put_contents($file, $current);
	}
	else{
		?>
<div class="alert alert-success alert-block fade in">
<button type="button" class="close" data-dismiss="alert">&times;</button>
El tema se ha modificado correctamente. Comprueba los cambios.</div>
<br />

		<?
	}
}
?>
<div class="well well-lg">
<form action="index_temas.php" enctype="multipart/form-data"
	method="post">
<fieldset>
<div class="form-group"><label>Selecciona el tema</label> <select
	class="form-control" name="tema">
	<option><? echo $tema;?></option>
	<optgroup label='Temas de la aplicación'>
	<?
	$d = dir("../../css/temas/");
	while (false !== ($entry = $d->read())) {
		if (stristr($entry,".css")==TRUE and !($entry=="bootstrap.min.css")) {
			echo "<option>$entry</option>";
		}
	}
	echo "</optgroup><optgroup label='Tema por defecto'>
	<option>bootstrap.min.css</option>
	</optgroup>";	
	$d->close();
	?>
</select></div>
<div class="checkbox"><label><input type="checkbox" name="inverso"
	value="1" />Invertir colores del tema</label></div>
<div class="form-group"><input type="submit" name="submit"
	value="Cambiar tema" class="btn btn-primary" /></div>
</fieldset>
<p class="help-block text-justify">Al construirse sobre <a
	href="http://getbootstrap.com"><strong>BootStrap</strong></a>, el
aspecto que presentan las páginas de la Intranet puede ser modificado
con temas. Los archivos <strong>CSS</strong> de los temas se encuentran
en la carpeta <em>/css/temas/</em>. La aplicación contiene un conjunto
de temas ya preparados libres y gratuitos, descargados desde la página
de <a href="http://bootswatch.com"><strong>Bootswatch</strong></a>.
Puedes colocar nuevos temas en ese directorio, pero recuerda que sólo
funcionan aquellos temas que contienen un único archivo <strong>CSS</strong>.<br>
No te olvides de refrescar la página si los cambios no aparecen inmediatamente.
</p>
</form>
</div>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<div class="thumbnail"><a target="_blank"
	href="../../img/temas/intranet.png" target="_blank"> <img
	src="../../img/temas/intranet.png"> </a>
<div class="caption">
<h3>Tema de la Aplicación</h3>
</div>
</div>
</div>
<div class="col-sm-6">
<div class="thumbnail"><a target="_blank"
	href="../../img/temas/bootstrap.png"> <img
	src="../../img/temas/bootstrap.png"> </a>
<div class="caption">
<h3>Tema standard de Bootstrap</h3>
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<div class="thumbnail"><a target="_blank"
	href="../../img/temas/cosmo.png"> <img class="img-responsive" src="../../img/temas/cosmo.png">
</a>
<div class="caption">
<h3>Cosmo</h3>
</div>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<div class="thumbnail"><a target="_blank"
	href="../../img/temas/lumen.png"> <img class="img-responsive" src="../../img/temas/lumen.png">
</a>
<div class="caption">
<h3>Lumen</h3>
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<div class="thumbnail"><a target="_blank"
	href="../../img/temas/cerulean.png"> <img
	src="../../img/temas/cerulean.png"> </a>
<div class="caption">
<h3>Cerulean</h3>
</div>
</div>
</div>
<div class="col-sm-6">
<div class="thumbnail"><a target="_blank"
	href="../../img/temas/paper.png"> <img
	src="../../img/temas/paper.png"> </a>
<div class="caption">
<h3>Paper</h3>
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<div class="thumbnail"><a target="_blank"
	href="../../img/temas/sandstone.png"> <img
	src="../../img/temas/sandstone.png"> </a>
<div class="caption">
<h3>Sandstone</h3>
</div>
</div>
</div>
<div class="col-sm-6">
<div class="thumbnail"><a target="_blank"
	href="../../img/temas/united.png"> <img
	src="../../img/temas/united.png"> </a>
<div class="caption">
<h3>United</h3>
</div>
</div>
</div>
</div>
</div>
</div>
	<?php include("../../pie.php");	?>

