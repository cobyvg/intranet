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
if(!(stristr($_SESSION['cargo'],'1') == TRUE))
{
	header("location:http://$dominio/intranet/salir.php");
	exit;
}
?>
<?
if(!(stristr($_SESSION['cargo'],'1') == TRUE))
{
	header("location:http://$dominio/intranet/salir.php");
	exit;
}
	if (isset($_POST['enviar'])) {
	if (isset($_FILES['archivo'])) {$archivo = $_FILES['archivo'];}
	
	// Recorremos directorio donde se encuentran los ficheros y aplicamos la plantilla.
	$uploads_dir = '../../varios/';
    if ($error == UPLOAD_ERR_OK) {
        $tmp_name = $_FILES["archivo"]["tmp_name"];
        $name = $_FILES["archivo"]["name"];
        move_uploaded_file($tmp_name, $uploads_dir.$name);
    }

	$doc = new DOMDocument('1.0', 'utf-8');
	
	$doc->load( $uploads_dir.$name ) or die("No se ha podido subir el archivo para ser procesado.");
	
	$mensaje.= "<br /><div align'center><div class='alert alert-error alert-block fade in' style='max-width:500px;'><br />
            <button type='button' class='close' data-dismiss='alert'>&times;</button>
El archivo generado por Horwin ha sido procesado y se ha creado una copia modificada preparada para subir a Séneca. 
<br>Los mesajes que aparecen más abajo indican los cambios realizados y las advertencias sobre problemas que podrías encontrar al importar los datos a Séneca.
</div></div>";	

	$profes = $doc->getElementsByTagName( "grupo_datos");

	foreach ($profes as $materia) {
		//$texto="";

		$codigos = $materia->getElementsByTagName( "dato" );

		$N_DIASEMANA=$codigos->item(0)->nodeValue;
		$X_TRAMO=$codigos->item(1)->nodeValue;
		$X_DEPENDENCIA=$codigos->item(2)->nodeValue;
		$X_UNIDAD=$codigos->item(3)->nodeValue;
		$X_OFERTAMATRIG=$codigos->item(4)->nodeValue;
		$X_MATERIAOMG=$codigos->item(5)->nodeValue;
		$F_INICIO=$codigos->item(6)->nodeValue;
		$F_FIN=$codigos->item(7)->nodeValue;
		$N_HORINI=$codigos->item(8)->nodeValue;
		$N_HORFIN=$codigos->item(9)->nodeValue;
		$X_ACTIVIDAD=$codigos->item(10)->nodeValue;

		if (strlen($X_UNIDAD)>0 and $X_UNIDAD > "3174012") {

			$un = mysql_query("select unidades.idcurso, nomcurso, nomunidad from unidades, cursos where unidades.idcurso = cursos.idcurso and idunidad = '$X_UNIDAD' order by unidades.idcurso, nomunidad");
			$uni = mysql_fetch_array($un);

			$asignatura="";

			$nombre_asig = mysql_query("select nombre from asignaturas where codigo = '$X_MATERIAOMG'");

			if ($nombre_asig) {
				$nombre_asigna= mysql_fetch_array($nombre_asig);

				$asig = mysql_query("select codigo, nombre from asignaturas  where curso = '$uni[1]' and nombre = '$nombre_asigna[0]'");


				if (mysql_num_rows($asig)>0) {

					while ($asignatur = mysql_fetch_array($asig)){
						$asignatura.=$asignatur[0].";";
						$nombre_asignatura = $asignatur[1];
					}
					if (stristr($asignatura,$X_MATERIAOMG)==FALSE) {
						if (strstr($texto,$asignatura)==FALSE) {
							$asig_corta = substr($asignatura,0,-1);
							$mensaje.= "<br /><div align'center><div class='alert alert-success alert-block fade in' style='max-width:500px;'><br />
            <button type='button' class='close' data-dismiss='alert'>&times;</button>
El código de la asignatura <u>$X_MATERIAOMG</u> (<em>$nombre_asignatura</em>) no corresponde al Curso $uni[1], sino este código: <strong>$asig_corta</strong>. <br><span clas='text-warning'>Código sustituído..</span>
</div></div>";					
							$codigos->item(5)->nodeValue = $asig_corta;
							$texto.=$asignatura.'';
						}

					}
				}
				else{
					if (strstr($texto,$X_MATERIAOMG)==FALSE) {
						$mensaje.= '<br /><div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;"><br />
            <button type="button" class="close" data-dismiss="alert">&times;</button>
No existe la asignatura <u>'.$X_MATERIAOMG.'</u> (<em>'.$nombre_asignatura.'</em>) en la tabla de asignaturas de'. $uni[1].'.
</div></div>';
						$texto.=$X_MATERIAOMG.' ';
							
					}
					//echo $texto."<br>";
				}
			}
			else{
				$mensaje.= "<br /><div align'center><div class='alert alert-error alert-block fade in' style='max-width:500px;'><br />
            <button type='button' class='close' data-dismiss='alert'>&times;</button>
<strong>$uni[2]</strong>: No existe ninguna asignatura con este código (<u>$X_MATERIAOMG</u>) en la tabla de asignaturas de la base de datos.
</div></div>";	
			}
		}

	}
	$contenido=$doc->saveXML();
	$directorio = "../../varios/";
	$archivo = "Importacion_horarios_Seneca.xml";
	$fopen = fopen($directorio.$archivo, "w");
	fwrite($fopen, $contenido);
	$mensaje.= '<div align="center" class="alert alert-success">
	<i class="fa fa-info-circle"> </i> Los datos han sido procesados correctamente. El archivo resultante del proceso se llama <strong>Importacion_horarios_seneca.xml</strong>, y se encuentra en el directorio <em>/varios/</em> de la Intranet. Este es el archivo que debes subir a Séneca.
	</div>';
	$mens=1;;
	header("Content-disposition: attachment; filename=$archivo");
	header("Content-type: application/octet-stream");
	readfile($directorio.$archivo);
	exit();
}

include("../../menu.php");

?>
<br />
<div class="page-header" align="center">
<h2>Administración. <small> Preparación de la Importación del Horario a Séneca</small></h2>
</div>
<br />
<div class="container">

<div class="row">

<div class="span6 offset3">

<?
//echo $mens;
if(isset($_POST['enviar'])){	
		echo '<div class="alert alert-success">
				  <i class="fa fa-info-circle"> </i> Los datos del Centro se han importado correctamente en la Base de datos.
				</div>';
	}
	
?>

<form class="form-horizontal" method="POST"
	enctype="multipart/form-data" action="horario_xml.php">
<fieldset><legend>Importación a Séneca de los Horarios del Centro </legend>

<p class="help-block">
Este módulo se encarga de preparar el archivo que crean los programas de Horarios (Horwin, etc.) para importar en Séneca, evitando tener que registrar manualmente los horarios de cada profesor. La adaptación que realiza este módulo es conveniente, ya que la compatibilidad con Séneca de los generadores de horarios tiene limitaciones (Código único de las asignaturas de Bachillerato, Diversificación, etc.). Es necesario tener a mano el archivo en formato XML que se exporta desde Horwin.
</p>

<br>

<div class="well" align="center">
<label for="file1">Selecciona el archivo descargado desde Horwin: </label>
<hr />
<input type="file" name="archivo" accept="text/xml" id="file1" required /> 
</div>

<hr>

<div align="center">
<input class="btn btn-primary btn-block" type="submit" name='enviar' value='Procesar datos' />
</div>
<br>
<br>
<br>
</fieldset>
</form>

</div>
</div>
</div>
<? include("../../pie.php");?>
