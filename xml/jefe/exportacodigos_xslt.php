<?
if(!(stristr($_SESSION['cargo'],'1') == TRUE))
{
header("location:http://$dominio/intranet/salir.php");
exit;	
}
// Activamos la plantilla XSLT para extaer los datos de los XML
$xh = xslt_create();
// Recorremos directorio donde se encuentran los ficheros y aplicamos la plantilla.
if ($handle = opendir('../exporta')) {
   while (false !== ($file = readdir($handle))) {
       if ($file != "." && $file != "..") {
           		$result .= xslt_process($xh, "../exporta/".$file,"xslt/combasi.xsl");
       }
   }
   closedir($handle);
}
// Escribimos en el fichero temporal los resultados de la función anterior (vienen contaminados con código html)
if (!(file_exists("almatmp.txt")))
{
$fp=fopen("almatmp.txt","w+");
 }
 else
 {
 $fp=fopen("almatmp.txt","w+");
 }
 $pepito=fwrite($fp,$result);
 fclose ($fp);
// Quitamos código html y nos uedamos con las líneas puras sql
$lines = file('almatmp.txt');
$Definitivo="";
foreach ($lines as $line_num => $line) {
	if (substr($line,1,6) == 'UPDATE')
 {
   $Definitivo.=$line;
  }
}
// Escribimos el resultado en el fichero alma.txt
if (!(file_exists("alma.txt")))
{
$fp=fopen("alma.txt","w+");
 }
 else
 {
 $fp=fopen("alma.txt","w+");
 }

$pepito=fwrite($fp,$Definitivo);
 fclose ($fp);
 $fp = @fopen ("alma.txt" , "r" ); 
 // Actualizamos los datos en Alma desde alma.tx
  while (!feof($fp))
{
        $bufer = fgets($fp);
	if (substr($bufer,1,6)=="UPDATE"){
$trozo = explode(';',$bufer);
$apell = $trozo[3] . " " . $trozo[4];
$actualiza = "UPDATE alma SET CLAVEAL1=\"".$trozo[1]."\",COMBASI=\"".$trozo[2]."\" WHERE APELLIDOS = \"".trim($apell)."\" AND NOMBRE = \"".$trozo[5]."\" AND UNIDAD = \"".$trozo[6]."\"" ;
$sql = mysql_query($actualiza) or die('<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
Ha surgido un error al insertar los registros en la Base de datos. Ponte en contacto con quien pueda resolver el problema.
</div></div><br />');
}
  }
fclose($fp);
?>

