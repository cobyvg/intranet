<?
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
<div class="page-header">
  <h2>Administración <small> Alumnos con asignaturas pendientes</small></h2>
</div>
<br />
<div class="well well-large" style="width:700px;margin:auto;text-align:left">
<?
mysql_query("drop TABLE pendientes");
mysql_query("CREATE TABLE IF NOT EXISTS pendientes (
  id int(11) NOT NULL auto_increment,
  claveal varchar(9) collate latin1_spanish_ci NOT NULL default '',
  codigo varchar(8) collate latin1_spanish_ci NOT NULL default '',
  nota int(2) NOT NULL,
  grupo varchar(6) collate latin1_spanish_ci NOT NULL default '',  
  PRIMARY KEY  (id),
  KEY  claveal (claveal),
  KEY codigo (codigo)
) DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1");

$directorio = "../pendientes";
//echo $directorio."<br>";

// Recorremos directorio donde se encuentran los ficheros y aplicamos la plantilla.
if ($handle = opendir($directorio)) {
   while (false !== ($file = readdir($handle))) {   	
      if ($file != "." && $file != ".."&& $file != ".xml") {
       	
$doc = new DOMDocument('1.0', 'utf-8');

$doc->load( $directorio.'/'.$file );

$grupo0 = $doc->getElementsByTagName( "T_NOMBRE" );
$grupo1 = $grupo0->item(0)->nodeValue;

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
if (strstr($file,"1") == FALSE) {
	$c_nota = mysql_query("select nombre from calificaciones where codigo = '$nota'");
	$c_notas = mysql_fetch_row($c_nota);
	
if ($c_notas[0]<5) {
	$cod = "INSERT INTO pendientes VALUES ('', '$clave3', '$codigo','$c_notas[0]', '$grupo1')";	
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
