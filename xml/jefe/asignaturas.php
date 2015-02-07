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
<br />
<div align="center">
<div class="page-header">
  <h2>Administración <small> Asignaturas y Calificaciones</small></h2>
</div>
<br />
<div class="text-center" id="t_larga_barra">
	<span class="lead"><span class="fa fa-circle-o-notch fa-spin"></span> Cargando...</span>
</div>
<div id='t_larga' style='display:none' >

<div class="well well-large" style="width:700px;margin:auto;text-align:left">
<?
// Vaciamos o borramos tablas
mysqli_query($db_con, "TRUNCATE TABLE calificaciones");
mysqli_query($db_con, "TRUNCATE TABLE asignaturas");
mysqli_query($db_con, "ALTER TABLE  `asignaturas` CHANGE  `CURSO`  `CURSO` VARCHAR( 128 ) CHARACTER SET latin1 COLLATE latin1_spanish_ci NULL DEFAULT NULL
");

mysqli_query($db_con, "drop table materias");

// Asignaturas de Horw
$asignaturas = "insert into asignaturas (CODIGO, NOMBRE, ABREV, CURSO) select distinct c_asig, asig, a_asig, curso from horw, alma where alma.unidad=horw.a_grupo";
mysqli_query($db_con, $asignaturas);	

  // Crear la tabla temporal donde guardar todas las asignaturas de todos los gruposy la tabla del sistema de calificaciones	
$crear = "CREATE TABLE  IF NOT EXISTS `materias_temp` (
	`CODIGO` varchar( 10 ) default NULL ,
 	`NOMBRE` varchar( 64 ) default NULL ,
 	`ABREV` varchar( 10 ) default NULL ,
	`CURSO` varchar( 128 ) default NULL,
	`GRUPO` varchar( 6 ) default NULL
	)" ;
	mysqli_query($db_con, $crear);
	mysqli_query($db_con, "CREATE TABLE if not exists `calificaciones_temp` (
  `codigo` varchar(5) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `nombre` varchar(64) CHARACTER SET latin1 DEFAULT NULL,
  `abreviatura` varchar(4) CHARACTER SET latin1 DEFAULT NULL,
  `orden` varchar(4) CHARACTER SET latin1 DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE latin1_spanish_ci ");
	
// Claveal primaria e índice
mysqli_query($db_con, "ALTER TABLE  `materias_temp` ADD  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY");
mysqli_query($db_con, "ALTER TABLE  `materias_temp` ADD INDEX (  `CODIGO` )");

mysqli_query($db_con, "ALTER TABLE  `calificaciones_temp` ADD INDEX (  `CODIGO` )");  
$num="";
// Recorremos directorio donde se encuentran los ficheros y aplicamos la plantilla.
if ($handle = opendir('../exporta')) {
   while (false !== ($file = readdir($handle))) {
       if ($file != "." && $file != ".."&& $file != ".xml") {
 //echo $file."<br />";
$num+=1;       	
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
mysqli_query($db_con, "INSERT INTO  `materias_temp` (
`CODIGO` ,
`NOMBRE` ,
`ABREV` ,
`CURSO` ,
`GRUPO`
)
VALUES ('$codigo',  '$nombre',  '$abrev',  '$cur', '$grupo')");}

//
if ($num=="1") {
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
mysqli_query($db_con, "INSERT INTO  `calificaciones_temp` 
VALUES ('$codigo0',  '$nombre_utf',  '$abrev0',  '$orden0')");
}
}
  
  }
 }  
closedir($handle);
}  
else{
	echo '<div align="center"><div class="alert alert-danger alert-block fade in">
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
mysqli_query($db_con, "insert into calificaciones select distinct codigo, nombre, abreviatura, orden from calificaciones_temp");

//Creamos tabla materias y arreglamos problema de codificación.

mysqli_query($db_con, "create table materias select * from materias_temp");
mysqli_query($db_con, "ALTER TABLE  `materias` ADD INDEX ( `CODIGO` )");
//mysqli_query($db_con, "ALTER TABLE `materias` DROP `GRUPO`");

$pr1 = mysqli_query($db_con, "select * from materias");
while ($pr10 = mysqli_fetch_array($pr1)){
	$nombr = utf8_decode($pr10[1]);	
	$abre = utf8_decode($pr10[2]);
	$cu = utf8_decode($pr10[3]);
	$id = $pr10[5];
	mysqli_query($db_con, "update materias set nombre = '$nombr', curso = '$cu', abrev = '$abre' where id = '$id'");	
}

//Borramos tablas temporales
mysqli_query($db_con, "drop table materias_temp");
mysqli_query($db_con, "drop table calificaciones_temp");

// Borramos registros tomados from Horw que son iguales a las asignaturas de Séneca
mysqli_query($db_con, "delete from asignaturas where codigo in (select distinct codigo from materias)") or die("No se pueden borrar los registros duplicados.");
// Depuramos los códigos de las asignaturas eliminando duplicados y creamos tabla definitiva asignaturas.
$crear = "insert into asignaturas select distinct CODIGO, NOMBRE, ABREV, CURSO from materias order by CODIGO" ;
mysqli_query($db_con, $crear) or die('<div align="center"><div class="alert alert-danger alert-block fade in">
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
<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Tablas ASIGNATURAS y CALIFICACIONES:<br /> Los datos se han introducido correctamente en la Base de Datos.
</div></div><br />
<div align="center">
  <input type="button" value="Volver atrás" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
</div><br>';
  // Comprobación con Horw
echo "<h4>Comprobación de coherencia entre las Asignaturas/Actividades de Séneca y de Horw.</h4> ";
$n_h=0;
$elimina = "select distinct c_asig, a_asig, asig from horw, asignaturas where c_asig NOT IN (select distinct codigo from asignaturas)";
$elimina1 = mysqli_query($db_con, $elimina);
$no_hay = "<p class='badge badge-important'>Asignaturas/Actividades de Horw que no están en Séneca</p>";
while($elimina2 = mysqli_fetch_array($elimina1))
{
$activ = mysqli_query($db_con,"select idactividad from actividades_seneca where idactividad = '$elimina2[0]'");	
if (mysqli_num_rows($activ)>0) {}
else{
$n_h+=1;	
$no_hay.="<li>". $elimina2[0] . " --> " . $elimina2[1] . " --> " . $elimina2[2] . "</li>";
}
}
if ($n_h>0) {
echo $no_hay;
}
$elimina = "select distinct codigo, abrev, nombre, curso from asignaturas, horw where codigo NOT IN (select distinct c_asig from horw)";
echo "<br /><p class='badge badge-warning'>Asignaturas de Séneca que no están en Horw.</p>";
$elimina1 = mysqli_query($db_con, $elimina);
while($elimina2 = mysqli_fetch_array($elimina1))
{
$pend = explode("_",$elimina2[1]);
if(strlen($pend[1]) > 0) {} else
{
echo "<li>".$elimina2[0] . " --> " . $elimina2[1] . " --> " . $elimina2[2] .  " --> " . $elimina2[3] ."</li>";
}
}

?>

</div>
 <? include("../../pie.php");?>
  <script>
function espera( ) {
        document.getElementById("t_larga").style.display = '';
        document.getElementById("t_larga_barra").style.display = 'none';        
}
window.onload = espera;
</script>  
</body>
</html>
