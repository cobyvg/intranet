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
$profe = $_SESSION['profi'];
if(!(stristr($_SESSION['cargo'],'1') == TRUE))
{
	header("location:http://$dominio/intranet/salir.php");
	exit;
}
?>
<?php
include("../../menu.php");
?>
<br />
<div class="page-header" align="center">
<h2>Administración: <small> Importación de datos del Centro</small></h2>
</div>
<br />
<div class="container">

<div class="row">

<div class="span6 offset3"><?php
$result = mysql_query("SELECT COUNT(*) FROM cursos");
$datos = mysql_fetch_array($result);

if ($datos[0]>0 and !(isset($_FILES['ExpGenHor']))) {
	?>
<div class="alert alert-warning"><legend><i
	class="fa fa-exclamation-triangle"> </i> Advertencia:</legend>Ya existe
información relativa a este curso escolar. Este proceso sustituirá parte
de la información almacenada. Los cambios realizados manualmente en las
dependencias y departamentos no se verán afectadas. Es recomendable
realizar una <a class="alert-link" href="#">copia de seguridad</a> antes
de proceder a la importación de los datos.</div>
	<?php }
	elseif(isset($_FILES['ExpGenHor'])){
		echo '<div class="alert alert-success">
				  <i class="fa fa-info-circle"> </i> Los datos del Centro se han importado correctamente en la Base de datos.
				</div>';
	}
	?>
<form class="form-horizontal" method="POST"
	enctype="multipart/form-data" action="index_xml.php">
<fieldset><legend>Importación de los datos del centro</legend>

<p>Este módulo se encarga de importar la relación de <strong>cursos</strong>
y <strong>unidades</strong> del Centro registrados en Séneca, asi como
la relación de <strong>materias</strong> que se imparten y <strong>actividades</strong>
del personal docente, necesarias para comprobar la coherencia de los
horarios y poder realizar tareas de depuración. Se importará también la
relación de <strong>dependencias</strong>, que se utilizará para
realizar reservas de aulas o consultar el horario de aulas.</p>

<p>Para obtener el archivo de exportación debe dirigirse al apartado <strong>Utilidades</strong>,
<strong>Importación/Exportación de datos</strong>. Seleccione <strong>Exportación
hacia generadores de horario</strong> y proceda a descargar el archivo
XML.</p>

<br>

<legend>ExportacionHorarios.xml</legend>

<div class="well" align="center"><label for="file1">Selecciona el
archivo descargado de Séneca: </label>
<hr />
<input type="file" name="ExpGenHor" accept="text/xml" id="file1"
	required> <input type="hidden" name="curso_escolar"
	value="<? echo $curso_actual;?>"></div>

<hr>

<div align="center">
<button class="btn btn-primary btn-block" type="submit">Importar datos</button>
</div>
<br>
<br>
<br>

	<?php
	$ExpGenHor = $_FILES['ExpGenHor']['tmp_name'];
	if (isset($ExpGenHor)) {
		include ('importacion_xml.php');
		importarDatos();
	}
	?></fieldset>
</form>

</div>
</div>
</div>
</body>
</html>
