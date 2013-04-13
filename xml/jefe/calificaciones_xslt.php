<? // Creamos tabla
 $borrar = "DROP TABLE IF EXISTS  calificaciones" ;
 mysql_query($borrar);
 $califica0 = "CREATE  TABLE  calificaciones (  `codigo` varchar( 5 )  NOT  NULL default  '',
 `nombre` varchar( 64  ) default NULL ,
 `abreviatura` varchar( 4  ) default NULL ,
 `orden` varchar( 4  ) default NULL ,
 PRIMARY  KEY (  `codigo`  )  ) TYPE  =  MyISAM";
 mysql_query($califica0);

//Ejecutamos plantilla xsl sobre los ficheros xml del directorio exporta  
  $xh = xslt_create();
// Recorremos directorio donde se encuentran los ficheros y aplicamos la plantilla.
$result = xslt_process( $xh, '../exporta/1EA.xml', 'xslt/calificaciones.xsl' );

// Abrimos fichero temporal para escribir el resultado de la plantilla XSLT
 if (!(file_exists("asignaturastmp.txt.txt")))
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
  if (substr($line,0,7) == " INSERT")
 {
mysql_query($line); 

  }
}
?>
<p id='texto_en_marco'>Tablas ASIGNATURAS y CALIFICACIONES:<br /> Los datos se han introducido correctamente en la Base de Datos.</p>

