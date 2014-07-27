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

$error=0;
if(isset($_POST['Submit'])) {
	
	$tipo = $_POST['tipo'];
	$iniciofalta = $_POST['iniciofalta'];
	$finfalta = $_POST['finfalta'];
	
	if (!empty($iniciofalta) && !empty($finfalta)) {
		switch ($tipo) {
			default :
			case 1 : header("Location:"."exportarSeneca.php?iniciofalta=$iniciofalta&finfalta=$finfalta"); break;
			case 2 : header("Location:"."exportar.php?iniciofalta=$iniciofalta&finfalta=$finfalta"); break;
		}
	}
	else {
		$error=1;
	}
}
?>
<?
 include("../../menu.php");
 include("../menu.php");
 ?>
 <br />
<div class="page-header" align="center">
  <h2>Faltas de Asistencia <small> Subir faltas a S&eacute;neca</small></h2>
</div>
<br />
 <?
 if(isset($_POST['enviar'])) {
 // Descomprimimos el zip de las calificaciones en el directorio origen/ tras eliminar los antiguos
$dir = "./origen/";
$ficheroseliminados="";
$handle = opendir($dir);
while ($file = readdir($handle)) {
 if (is_file($dir.$file) and strstr($file,"xml")==TRUE) {
  if ( unlink($dir.$file) ){
   $ficheroseliminados++;
  }
 }
}

include('../../lib/pclzip.lib.php');   
$archive = new PclZip($_FILES['archivo1']['tmp_name']);  
      if ($archive->extract(PCLZIP_OPT_PATH, $dir) == 0) 
	  {
        die("Error : ".$archive->errorInfo(true));
      }  
      echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Los archivos de los alumnos han sido descragados correctamente en el directorio /faltas/seneca/origen/.
</div></div><br />';
 }
?>

<div class="container-fluid">
<div class="row">
<div class="col-sm-4 col-sm-offset-2">
<legend align="center">Importar datos de los Alumnos</legend>
<FORM ENCTYPE="multipart/form-data" ACTION="index.php" METHOD="post">
  <div class="form-group">
  <div class="well well-large" align="left">
      <div class="controls">
  <label class="control-label" for="file1">Selecciona el archivo comprimido descargado desde Séneca <span style="color:#9d261d">Exportacion_Faltas_Alumnado.zip</span>
  </label>
  <hr />
  <input type="file" name="archivo1" class="input input-file" id="file1">
  <hr>
  
  <div align="center">
    <INPUT type="submit" name="enviar" value="Aceptar" class="btn btn-primary btn-block">
  </div> <!-- center -->
  
  </div> <!-- form-group -->
  </div> <!-- well -->
</div> <!-- control -->
<hr />
  <div class="help-block" style="text-align:justify; <?php if($error) echo 'color: red;';?>"><p class="lead text-warning">Información sobre la Importación.</p>
Para poder importar las faltas de los alumnos, es necesario en primer lugar descargar un archivo desde <em>S&eacute;neca --> Utilidades --> Imprtaci&oacute;n/Exportaci&oacute;n
 --> Exportaci&oacute;n de Faltas del alumnado</em>. <br />Crea un nuevo archivo con todos los grupos del Centro, y acepta la fecha propuesta. Tardar&aacute; unos instantes en aparecer, as&iacute; que vuelve al cabo de un minuto a la misma p&aacute;gina y te aparecer&aacute; un mensaje confirmando que el archivo ha sido generado. <br />Descarga el archivo y selecciónalo para proceder. Los archivo se colocan en el directorio /faltas/seneca/origen/
</div>
</FORM>

</div>
<div class="col-sm-4"><legend align="center">Exportar Faltas a Séneca</legend>
<div class="well" align="left">	
        <form id="form1" name="form1" method="post" action="index.php">
        
         <label >Primer d&iacute;a: 
      <div class="input-group" >
            <input name="iniciofalta" type="text" class="input input-small" data-date-format="dd/mm/yyyy" id="iniciofalta" required />
  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
</div> 
</label>
 &nbsp;&nbsp;&nbsp;&nbsp;
<label>Ultimo d&iacute;a: 
 <div class="input-group" >
  <input name="finfalta" type="text" class="input input-small" data-date-format="dd/mm/yyyy" id="finfalta" required />
  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
</div> 

      </label>
      
      <br>
      
      <p class="lead">Tipo de exportaci&oacute;n</p>
      
      <label class="radio">
        <input type="radio" name="tipo" value="1" checked> Generar un archivo con todas las unidades.
      </label>
      
      <label class="radio">
        <input type="radio" name="tipo" value="2"> Generar un archivo por cada unidad.
      </label>
      
   <br />
  <div align="center"><input type="submit" name="Submit" value="Enviar" class="btn btn-primary btn-block" /></div>
        </form>
      
        </div>
        <hr />
        <div class="help-block" style="text-align:justify; <?php if($error) echo 'color: red;';?>"><p class="lead text-warning">Instrucciones de Uso.</p>
        La condición esencial que debe cumplirse para poder subir las faltas a Séneca es que el horario de los profesores esté correctamente registrado en Séneca. El 99% de los problemas que puedan surgir al subir las faltas se deben al horario. Revisa el horario con detenimiento antes de proceder, con especial cuidado a los cursos de Bachillerato.<br />
        Es importante que los datos de los Alumnos est&eacute;n actualizados para evitar errores en la importaci&oacute;n de las Faltas. El formulario de la izquierda permite actualizar la información.<br />Adem&aacute;s, ten en cuenta que S&eacute;neca s&oacute;lo acepta importaciones de un mes m&aacute;ximo de Faltas de Asistencia. Por esta raz&oacute;n, el Primer D&iacute;a que introduces debe ser el primer d&iacute;a del mes (o el mas pr&oacute;ximo en caso de que sea un mes de vacaciones, o 
puente coincidente con los primeros dias de un mes, etc.). <br />El mismo criterio se aplica para el ultimo d&iacute;a del mes. <br />Es muy importante que selecciones dias lectivos, as&iacute; que echa un vistazo al Calendario oficial de la Consejer&iacute;a para asegurarte. <br />Una vez le damos a enviar se generan los ficheros (o el fichero comprimido, según la opción elegida) que posteriormente se importan a S&eacute;neca, as&iacute; que ya puedes abrir la pagina de S&eacute;neca para hacerlo.<br /> Los archivos se encuentran en el directorio de la intranet /faltas/seneca/exportado/; el archivo comprimido se genera en el navegador preparado para subirlo.</div>
        
</div>
</div>

</div>
  
        <?php	
include("../../pie.php");
?>   

<?php  
$inicio = explode('-', $inicio_curso);
$inicio_anio = $inicio[0];
$inicio_mes  = $inicio[1];
$inicio_dia  = $inicio[2];

$fin = explode('-', $fin_curso);
$fin_anio = $fin[0];
$fin_mes  = $fin[1];
$fin_dia  = $fin[2];

$festivos = mysql_query("SELECT fecha FROM festivos");
?>
<script>
$(function ()  {
	var inicio = new Date(<?php echo $inicio_anio; ?>, <?php echo $inicio_mes; ?>-1, <?php echo $inicio_dia; ?>, 0, 0, 0, 0);
	var fin    = new Date(<?php echo $fin_anio; ?>, <?php echo $fin_mes; ?>-1, <?php echo $fin_dia; ?>, 0, 0, 0, 0);
	
	<?php
	$cadena_festivos = '';
	$i=1;
	while ($festivo = mysql_fetch_array($festivos)) {
		$festfecha = explode('-', $festivo['fecha']);
		$festivo_anio = $festfecha[0];
		$festivo_mes  = $festfecha[1];
		$festivo_dia  = $festfecha[2];
		
		echo "var festivo$i = new Date($festivo_anio, $festivo_mes-1, $festivo_dia, 0, 0, 0, 0);";
		
		$cadena_festivos .= " || (date.valueOf() == festivo$i.valueOf())";
		$i++;
	}
	?>
	
	var checkin = $('#iniciofalta').datepicker({
		weekStart: 1,
		onRender: function(date) {
			return (date.valueOf() < inicio.valueOf()) || (date.valueOf() > fin.valueOf()) || (date.getUTCDay() == 5) || (date.getUTCDay() == 6)<?php echo $cadena_festivos; ?> ? 'disabled' : '';
		}
	}).on('changeDate', function(ev) {
		var newDate = new Date(ev.date);
		newDate.setDate(newDate.getDate() + 1);
		checkout.setValue(newDate);
		checkin.hide();
		$('#finfalta')[0].focus();
	}).data('datepicker');
	
	var checkout = $('#finfalta').datepicker({
		weekStart: 1,
		onRender: function(date) {
			return date.valueOf() <= checkin.date.valueOf() || (date.valueOf() > fin.valueOf()) || (date.getUTCDay() == 5) || (date.getUTCDay() == 6)<?php echo $cadena_festivos; ?> ? 'disabled' : '';
		}
	}).on('changeDate', function(ev) {
		checkout.hide();
	}).data('datepicker');
});  
</script>
</body>
</html>