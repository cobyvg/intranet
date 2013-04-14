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
<?php
include("../../menu.php");
?>
<div align="center">
<div class="page-header" align="center" style="margin-top:-15px;">
  <h1>Administración <small> Asignaturas y Calificaciones</small></h1>
</div>
<br />
<div class="well-2 well-large" style="width:700px;margin:auto;text-align:left">
<?
// Vaciamos o borramos tablas
mysql_query("TRUNCATE TABLE calificaciones");
mysql_query("TRUNCATE TABLE asignaturas");
mysql_query("drop table materias");

// Asignaturas de Horw
$asignaturas = "insert into asignaturas (CODIGO, NOMBRE, ABREV, CURSO) select distinct c_asig, asig, a_asig, curso from horw, alma where alma.unidad=horw.a_grupo";
mysql_query($asignaturas);	

  // Crear la tabla temporal donde guardar todas las asignaturas de todos los gruposy la tabla del sistema de calificaciones	
$crear = "CREATE TABLE  IF NOT EXISTS `materias_temp` (
	`CODIGO` varchar( 10 ) default NULL ,
 	`NOMBRE` varchar( 64 ) default NULL ,
 	`ABREV` varchar( 10 ) default NULL ,
	`CURSO` varchar( 64 ) default NULL,
	`GRUPO` varchar( 6 ) default NULL
	)" ;
	mysql_query($crear);
	mysql_query("CREATE TABLE if not exists `calificaciones_temp` (
  `codigo` varchar(5) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `nombre` varchar(64) CHARACTER SET latin1 DEFAULT NULL,
  `abreviatura` varchar(4) CHARACTER SET latin1 DEFAULT NULL,
  `orden` varchar(4) CHARACTER SET latin1 DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;");
	
// Claveal primaria e índice
mysql_query("ALTER TABLE  `materias_temp` ADD  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY");
mysql_query("ALTER TABLE  `materias_temp` ADD INDEX (  `CODIGO` )");
  
// Recorremos directorio donde se encuentran los ficheros y aplicamos la plantilla.
if ($handle = opendir('../exporta')) {
   while (false !== ($file = readdir($handle))) {
       if ($file != "." && $file != ".."&& $file != ".xml") {
 //echo $file."<br />";
       	
$doc = new DOMDocument('1.0', 'iso-8859-1');

/*Cargo el XML*/
$doc->load( '../exporta/'.$file );
 
/*Obtengo el nodo MATERIA del XML
a traves del metodo getElementsByTagName,
este nos entregara una lista de todos los
nodos encontrados */
$cursos = $doc->getElementsByTagName( "D_OFERTAMATRIG");
$cur = $cursos->item(0)->nodeValue;

$materias = $doc->getElementsByTagName( "MATERIA" );
 
/*Al ser $materias una lista de nodos
lo puedo recorrer y obtener todo
su contenido*/
foreach( $materias as $materia )
{	
$file0 = substr($file, 0, 2);
$file1 = substr($file, 2, 1);	
$grupo = $file0."-".$file1;
$codigos = $materia->getElementsByTagName( "X_MATERIAOMG" );
 
/*Obtengo el valor del primer elemento 'item(0)'
de la lista $codigos.
Si existiera un atriburto en el nodo para obtenerlo
usaria $codigos->getAttribute('atributo');
*/
$codigo = $codigos->item(0)->nodeValue;
$nombres = $materia->getElementsByTagName( "D_MATERIAC" );
$nombre = $nombres->item(0)->nodeValue;
$abrevs = $materia->getElementsByTagName( "T_ABREV" );
$abrev = $abrevs->item(0)->nodeValue;
mysql_query("INSERT INTO  `materias_temp` (
`CODIGO` ,
`NOMBRE` ,
`ABREV` ,
`CURSO` ,
`GRUPO`
)
VALUES ('$codigo',  '$nombre',  '$abrev',  '$cur', '$grupo')");}

//
///*Obtengo el nodo Calificación del XML
//a traves del metodo getElementsByTagName,
//este nos entregara una lista de todos los
//nodos encontrados */
//
$calificaciones = $doc->getElementsByTagName( "CALIFICACION" );
 
/*Al ser $calificaciones una lista de nodos
lo puedo recorrer y obtener todo
su contenido*/
foreach( $calificaciones as $calificacion )
{	
 
/*Obtengo el valor del primer elemento 'item(0)'
de la lista $codigos.
Si existiera un atributo en el nodo para obtenerlo
usaria $codigos->getAttribute('atributo');
*/
$codigos0 = $calificacion->getElementsByTagName( "X_CALIFICA" );
$codigo0 = $codigos0->item(0)->nodeValue;
$nombres0 = $calificacion->getElementsByTagName( "D_CALIFICA" );
$nombre0 = $nombres0->item(0)->nodeValue;
$abrevs0 = $calificacion->getElementsByTagName( "T_ABREV" );
$abrev0 = $abrevs0->item(0)->nodeValue;
$ordenes0 = $calificacion->getElementsByTagName( "N_ORDEN" );
$orden0 = $ordenes0->item(0)->nodeValue;
$nombre_utf = utf8_decode($nombre0);
mysql_query("INSERT INTO  `calificaciones_temp` 
VALUES ('$codigo0',  '$nombre_utf',  '$abrev0',  '$orden0')");
}  
  }
 }  
closedir($handle);
}  
else{
	echo '<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
No se han colocado los ficheros de Evaluación de Séneca en el directorio exporta/.<br> Descárgalos de Séneca y colócalos allí antes de continuar.
</div></div><br />
<div align="center">
  <input type="button" value="Volver atrás" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
</div>';
exit();
}

//Tabla calificaciones
mysql_query("insert into calificaciones select distinct codigo, nombre, abreviatura, orden from calificaciones_temp");

//Creamos tabla materias y arreglamos problema de codificación.

mysql_query("create table materias select * from materias_temp");
mysql_query("ALTER TABLE  `materias` ADD INDEX ( `CODIGO` )");
//mysql_query("ALTER TABLE `materias` DROP `GRUPO`");

$pr1 = mysql_query("select * from materias");
while ($pr10 = mysql_fetch_array($pr1)){
	$nombr = utf8_decode($pr10[1]);	
	$abre = utf8_decode($pr10[2]);
	$cu = utf8_decode($pr10[3]);
	$id = $pr10[5];
	mysql_query("update materias set nombre = '$nombr', curso = '$cu', abrev = '$abre' where id = '$id'");	
}

//Borramos tablas temporales
mysql_query("drop table materias_temp");
mysql_query("drop table calificaciones_temp");

// Borramos registros tomados from Horw que son iguales a las asignaturas de Séneca
mysql_query("delete from asignaturas where codigo in (select distinct codigo from materias)") or die("No se pueden borrar los registros duplicados.");
// Depuramos los códigos de las asignaturas eliminando duplicados y creamos tabla definitiva asignaturas.
$crear = "insert into asignaturas select distinct CODIGO, NOMBRE, ABREV, CURSO from materias order by CODIGO" ;
mysql_query($crear) or die('<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
No se pueden crear los registros en la tabla asignaturas. Busca ayuda.
</div></div><br />
<div align="center">
  <input type="button" value="Volver atrás" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
</div>'); 

    // Y luego creamos la tabla con los sistemas de calificación y sus equivalencias
 //  include("calificaciones.php");
   
echo '<br />
<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Tablas ASIGNATURAS y CALIFICACIONES:<br /> Los datos se han introducido correctamente en la Base de Datos.
</div></div><br />
<div align="center">
  <input type="button" value="Volver atrás" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
</div><hr>';
  // Comprobación con Horw
echo "<p class='lead'>Comprobación de coherencia entre las Asignaturas de Séneca y de Horw.</p><br /> ";
$elimina = "select distinct c_asig, a_asig, asig from horw, asignaturas where c_asig NOT IN (select distinct codigo from asignaturas)";
$elimina1 = mysql_query($elimina);
echo "<p class='label label-important'>Asignaturas de Horw que no están en Séneca</p>";
while($elimina2 = mysql_fetch_array($elimina1))
{
echo "<li>". $elimina2[0] . " --> " . $elimina2[1] . " --> " . $elimina2[2] . "</li>";
}
$elimina = "select distinct codigo, abrev, nombre, curso from asignaturas, horw where codigo NOT IN (select distinct c_asig from horw)";
echo "<br /><p class='label label-warning'>Asignaturas de Séneca que no están en Horw.</p>";
$elimina1 = mysql_query($elimina);
while($elimina2 = mysql_fetch_array($elimina1))
{
$pend = explode("_",$elimina2[1]);
if(strlen($pend[1]) > 0) {} else
{echo "<li>".$elimina2[0] . " --> " . $elimina2[1] . " --> " . $elimina2[2] .  " --> " . $elimina2[3] ."</li>";}
}

?>

</div>
</body>
</html>
