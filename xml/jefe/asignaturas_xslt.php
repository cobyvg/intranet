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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Asignaturas y Calificaciones</title>
<LINK href="http://<? echo $dominio; ?>/<? echo $css1; ?>" rel="stylesheet" type="text/css">
<LINK href="http://<? echo $dominio; ?>/<? echo $css2; ?>" rel="stylesheet" type="text/css">
</head>
<body>
<div align="left" style="width:700px;margin:auto;margin-top:25px;">
<div class="titulogeneral" align=center>Asignaturas y Calificaciones.</div>
<?
mysql_connect ($db_host, $db_user, $db_pass) or die("Error de conexión");
// Vaciamos tabla
$borrar = "TRUNCATE TABLE asignaturas" ;
mysql_query($borrar);
// Asignaturas de Horw
$asignaturas = "insert into asignaturas (CODIGO, NOMBRE, ABREV, CURSO) select distinct c_asig, asig, a_asig, curso from horw, alma where alma.unidad=horw.a_grupo";
mysql_query($asignaturas);	
  // Crear la tabla temporal donde guardar todas las asignaturas de todos los grupos	
$crear = "CREATE TABLE  IF NOT EXISTS `asignaturtmp` (
	`CODIGO` varchar( 10 ) default NULL ,
 	`NOMBRE` varchar( 64 ) default NULL ,
 	`ABREV` varchar( 10 ) default NULL ,
	`CURSO` varchar( 64 ) default NULL
	) TYPE = MYISAM " ;
	mysql_query($crear) or die("No se puede crear la tabla asignaturtmp");
// Claveal primaria e índice
  $SQL6 = "ALTER TABLE  `asignaturtmp` ADD INDEX (  `codigo` )";
  $result6 = mysql_query($SQL6);
//Ejecutamos plantilla xsl sobre los ficheros xml del directorio exporta  
  $xh = xslt_create();
// Recorremos directorio donde se encuentran los ficheros y aplicamos la plantilla.
if ($handle = opendir('../exporta')) {
   while (false !== ($file = readdir($handle))) {
       if ($file != "." && $file != ".."&& $file != ".xml") {
           	$result .= xslt_process($xh, '../exporta/'.$file, 'xslt/codasi.xsl');
       }
   }
   closedir($handle);
}  
else{
echo "<p id='texto_en_marco'>No se han colocado los ficheros de Evaluación de Séneca en el directorio exporta/.<br> Descárgalos de Séneca y colócalos allí antes de continuar.</p>"; 
exit;
}

// Abrimos fichero temporal para escribir el resultado de la plantilla XSLT
 if (!(file_exists("asignaturastmp.txt")))
{
$fp=fopen("asignaturastmp.txt","w+");
 }
 else
 {
 $fp=fopen("asignaturastmp.txt","w+");
 }
 $pepito=fwrite($fp,$result);
 fclose ($fp);
  
$lines = file('asignaturastmp.txt');
$Definitivo="";

foreach ($lines as $line_num => $line) {
  if (substr($line,1,7) == " INSERT")
 {
 mysql_query($line); 
 }
}
// Borramos registros tomados from Horw que son iguales a las asignaturas de Séneca
mysql_query("delete from asignaturas where codigo in (select distinct codigo from asignaturtmp)") or die("No se pueden borrar los registros duplicados.");
// Depuramos los códigos de las asignaturas eliminando duplicados y creamos tabla definitiva asignaturas.
$crear = "insert into asignaturas select distinct CODIGO, NOMBRE, ABREV, CURSO from asignaturtmp order by CODIGO" ;
mysql_query($crear) or die("No se puede crear la tabla asignaturas");
$borrar1 = "DROP TABLE IF EXISTS asignaturtmp" ;
mysql_query($borrar1) or die("No se puede borrar la tabla asignaturtmp");

    // Y luego creamos la tabla con los sistemas de calificación y sus equivalencias
  include("calificaciones_xslt.php");

  // Comprobación con Horw
echo "<p>Comprobación de coherencia entre las Asignaturas de Séneca y de Horw.</p> ";
$elimina = "select distinct c_asig, a_asig, asig from horw, asignaturas where c_asig NOT IN (select distinct codigo from asignaturas)";
$elimina1 = mysql_query($elimina);
echo "<p style='color:brown;font-size:1.1em;'>Asignaturas de Horw que no están en Séneca</p>";
echo "<div style='text-align:left;width:500px;'>";
while($elimina2 = mysql_fetch_array($elimina1))
{
echo "<li>". $elimina2[0] . " --> " . $elimina2[1] . " --> " . $elimina2[2] . "</li>";
}
echo "</div>";
$elimina = "select distinct codigo, abrev, nombre, curso from asignaturas, horw where codigo NOT IN (select distinct c_asig from horw)";
echo "<p style='color:brown;font-size:1.1em;'>Asignaturas de Séneca que no están en Horw.</p>";
echo "<div style='text-align:left;width:700px;'>";
$elimina1 = mysql_query($elimina);
while($elimina2 = mysql_fetch_array($elimina1))
{
$pend = explode("_",$elimina2[1]);
if(strlen($pend[1]) > 0) {} else
{echo "<li>".$elimina2[0] . " --> " . $elimina2[1] . " --> " . $elimina2[2] .  " --> " . $elimina2[3] ."</li>";}
}
echo "</div>";

?>
<br />
<input type="button" value="Volver atrás" name="boton" onclick="history.back(2)" />
</div>
</body>
</html>
