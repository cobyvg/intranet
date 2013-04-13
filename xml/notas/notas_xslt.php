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
<div align="center">
<h2>Importación de Calificaciones de las Evaluaciones</h2>
<br />
<br />
<div class="well well-large" style="width:700px;margin:auto;text-align:left">
<?
if ($directorio=="../exporta1") {
	mysql_query("TRUNCATE TABLE notas");
}
//Ejecutamos plantilla xsl sobre los ficheros xml del directorio exporta  
  $xh = xslt_create();
// Recorremos directorio donde se encuentran los ficheros y aplicamos la plantilla.
if ($handle = opendir($directorio)) {
   while (false !== ($file = readdir($handle))) {
       if ($file != "." && $file != ".."&& $file != ".xml") {
           	$result .= xslt_process($xh, $directorio.'/'.$file, $trans);
       }
   }
   closedir($handle);
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
// Abrimos fichero temporal para escribir el resultado de la plantilla XSLT
 if (!(file_exists("notastmp.txt")))
{
$fp=fopen("notastmp.txt","w+");
 }
 else
 {
 $fp=fopen("notastmp.txt","w+");
 }
 $pepito=fwrite($fp,$result);
 fclose ($fp);
  
$lines = file('notastmp.txt');
$Definitivo="";
if ($directorio=="../exporta1") {

foreach ($lines as $line_num => $line) {
  if (substr($line,0,7) == " INSERT")
 {
 mysql_query($line); 
  }
}

}
else {
foreach ($lines as $line_num => $line) {
  if (substr($line,0,7) == " UPDATE")
 {
 mysql_query($line); 
  }
}
	
}
 echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Las Notas de Evaluación se han importado correctamente en la base de datos.
</div></div><br />';
?>
<div align="center">
<input type="button" value="Volver atrás" name="boton" onclick="history.back(2)" class="btn btn-inverse" />
</div>
</div>
</div>
<? include("../../pie.php");?>
</body>
</html>
