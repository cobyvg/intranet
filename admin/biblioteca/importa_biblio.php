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
if(!(stristr($_SESSION['cargo'],'1') == TRUE) and !(stristr($_SESSION['cargo'],'4') == TRUE) and !(stristr($_SESSION['cargo'],'5') == TRUE) and !(stristr($_SESSION['cargo'],'8') == TRUE))
{
header("location:http://$dominio/intranet/salir.php");
exit;	
}  
?>
<?php
 include("../../menu.php");
 include("menu.php");
?>
<div align="center">
<div class="page-header">
  <h2>Biblioteca del Centro <small> Importación de libros desde Abbies</small></h2>
</div>
</div>
<div class="container-fluid">
<div class="row-fluid">
<div class='well well-large span6 offset3'>  
<?
mysql_query("CREATE TABLE IF NOT EXISTS `biblioteca` (
  `id` int(11) NOT NULL auto_increment,
  `autor` varchar(128) collate latin1_spanish_ci NOT NULL,
  `codigo` int(11) NOT NULL,
  `editorial` varchar(128) collate latin1_spanish_ci NOT NULL,
  `signatura` int(11) NOT NULL,
  `tipo` varchar(64) collate latin1_spanish_ci NOT NULL,
  `titulo` varchar(128) collate latin1_spanish_ci NOT NULL,
  `ubicacion` varchar(32) collate latin1_spanish_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ");

$fp = fopen ($_FILES['archivo']['tmp_name'] , "r" ) or die ("<br><blockquote>No se ha podido abrir el fichero.<br> Asegúrate de que su formato es correcto.</blockquote>");
$reg=0;
echo "<div class='well span8 offset2>";
echo "<div align='center' class='lead'>Listados de libros procesados</div>";
echo "<br>";
while (( $data = fgetcsv ( $fp , 1000 , ";" )) !== FALSE ) {
 
if ($data[1]!=''){

$sql="	INSERT INTO  biblioteca (Autor, Codigo, Editorial, Signatura, Tipo, Titulo, Ubicacion) VALUES (";
$sql.="	'$data[0]',  '$data[1]',  '$data[2]',  '$data[3]',  '$data[4]',  '$data[5]',  '$data[6]')";

if(mysql_query($sql,$c)){echo "<div>",$data[5],"</b> ha sido importado a la base de datos</div>";$reg++;}
			else {
				echo "<div>",$data[5],"</b> no ha sido importado a la base de datos. Error nº: ",mysql_errno(),"</div>";
				 }			
             }
	     
} 
fclose ( $fp ); 
mysql_close();
echo "<div align='center' class='text-info'><b>Se han importado un total de ",$reg," libros a la base de datos</b></div>";
echo "<div align='center' class='text-info'>Posiblemente los libros que no han sido importados ya existían en la base de datos. Consulta el número del error.</div>";
echo "</div>";

include ("../pie.inc.php");
?>