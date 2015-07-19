<?php
require('../../bootstrap.php');

if (isset($_POST['tema'])) {
			
	if ($_POST['fondo']=="1") {
				$p_fondo = 'navbar-inverse';
			}
	else{
				$p_fondo = 'navbar-default';
			}
			
if (empty($_POST['tema'])) {
		$_SESSION ['tema']="bootstrap.min.css";
		$_POST ['tema']="bootstrap.min.css";
	}
			
	$res = mysqli_query($db_con, "select distinct tema, fondo from temas where idea = '".$_SESSION['ide']."'" );
		
	if (mysqli_num_rows($res)>0) {
		
		//$ro = mysqli_fetch_array ( $res );

			mysqli_query($db_con,"update temas set tema='".$_POST['tema']."', fondo='".$p_fondo."' where idea='".$_SESSION['ide']."'");		
	}
	else{
			mysqli_query($db_con,"insert into temas (idea, tema, fondo) VALUES ('".$_SESSION['ide']."','".$_POST['tema']."', '".$p_fondo."')");
	}
		
	$_SESSION ['tema'] = $_POST['tema'];
		
	$_SESSION ['fondo'] = $p_fondo;

$mens = '<div class="alert alert-success alert-block fade in">
<button type="button" class="close" data-dismiss="alert">&times;</button>
El tema se ha modificado correctamente. Comprueba los cambios.</div>';

	}

include("../../menu.php");
?>

<div class="container"><!-- TITULO DE LA PAGINA -->
<div class="page-header">
<h2>Administración <small>Temas para la aplicación</small></h2>
</div>

<!-- SCAFFOLDING -->
<div class="row"><!-- COLUMNA IZQUIERDA -->
<?
echo $mens;
?>
<div class="col-sm-6 col-sm-offset-3"><br>

<div class="well well-lg">
<form action="index_temas.php" enctype="multipart/form-data"
	method="post">
<fieldset>
<div class="form-group"><label>Selecciona el tema</label> <select
	class="form-control" name="tema">
	<optgroup label='Temas de la aplicación'>
	<?	
	$d = dir("../../css/temas/");
	while (false !== ($entry = $d->read())) {
		if (stristr($entry,".css")==TRUE and !($entry=="bootstrap.min.css")) {
			if (stristr($_SESSION ['tema'],$entry)==TRUE) {
				$sel = "selected";
			}
			else{
				$sel="";
			}
			echo "<option $sel value='temas/$entry'>$entry</option>";
		}
	}
	
	if ($_SESSION ['tema']=="bootstrap.min.css") {
				$sel2 = "selected";
			}
	echo "</optgroup><optgroup label='Tema por defecto'>
	<option value='bootstrap.min.css' $sel2>bootstrap.min.css</option>
	</optgroup>";	
	$d->close();
	?>
</select></div>
<div class="checkbox"><label><input type="checkbox" name="fondo"
	value="1" <? if($_SESSION ['fondo']=="navbar-inverse"){echo "checked";}?>/>Invertir colores de la Barra de Navegación</label></div>
<div class="form-group"><input type="submit" name="submit"
	value="Cambiar tema" class="btn btn-primary" /></div>
</fieldset>
<p class="help-block text-justify">El
aspecto que presentan las páginas de la Intranet puede ser modificado
mediante <em><b>Temas</b></em>. La aplicación contiene un conjunto
de temas que modifican los distintos elementos que constituyen su presentación visual: el tipo de letra, los fondos, botones, etiquetas, colores de los distintos elementos, barra de navegación, etc. Puedes probar los distintos temas que suministramos seleccionando uno de ellos de la lista desplegable, pulsando el botón para enviar los datos y observando los cambios. Puedes cambiar de tema tantas veces como quieras ya que no afecta al funcionamiento de la Intranet.
<br>El tema por defecto siempre está a mano para recuperar el estado original de la aplicación.
<br>
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

