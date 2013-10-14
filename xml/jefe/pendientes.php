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
include("../../menu.php");
?>
<br />
<div align="center">
<div class="page-header" align="center">
  <h2>Administración <small> Alumnos con asignaturas pendientes</small></h2>
</div>
<br />
<div class="well well-large" style="width:700px;margin:auto;text-align:left">
<?
$directorio = "../pendientes";
//echo $directorio."<br>";
mysql_query("TRUNCATE TABLE pendientes");

// Recorremos directorio donde se encuentran los ficheros y aplicamos la plantilla.
if ($handle = opendir($directorio)) {
   while (false !== ($file = readdir($handle))) {   	
      if ($file != "." && $file != ".."&& $file != ".xml") {
       	
$doc = new DOMDocument('1.0', 'utf-8');

$doc->load( $directorio.'/'.$file );

$claves = $doc->getElementsByTagName( "ALUMNO" );
 
foreach( $claves as $clave )
{	
$clave2 = $clave->getElementsByTagName( "C_NUMESCOLAR" );
$clave3 = $clave2->item(0)->nodeValue;
//$codigo = "";
$materias = $clave->getElementsByTagName( "MATERIA_ALUMNO" );

foreach( $materias as $materia )
{		
$codigos = $materia->getElementsByTagName( "X_MATERIAOMG" );
$codigo = $codigos->item(0)->nodeValue;
$notas = $materia->getElementsByTagName( "X_CALIFICA" );
$nota = $notas->item(0)->nodeValue;
if (strstr($file,"1B") == TRUE or strstr($file,"2B") == TRUE) {
if ($nota=='417' or $nota=='419' or $nota=='421' or $nota=='423' or $nota=='425' or $nota=='439') {
	$cod = "INSERT INTO pendientes VALUES ('', '$clave3', '$codigo')";	
	mysql_query($cod);
}
}
else{
if ($nota=='337' or $nota=='341' or $nota=='343' or $nota=='345' or $nota=='397') {
	$cod = "INSERT INTO pendientes VALUES ('', '$clave3', '$codigo')";	
	mysql_query($cod);
}
}
}	
}   	       
}
}
   closedir($handle);
   echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Las Notas de la Evaluación Extraordinaria del Curso anterior se han registrado correctamente en la base de datos.
</div></div><br />';
}  
else
{
	echo '<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
Parece que no hay archivos en el directorio correspondiente.<br> O bien no has enviado el archivo correcto descargado de Séneca o bien el archivo está corrompido.
</div></div><br />';
exit;
}

?>
<div align="center">
<input type="button" value="Volver atrás" name="boton" onclick="history.back(2)" class="btn btn-inverse" />
</div>
</div>
</div>
<? include("../../pie.php");?>
</body>
</html>
