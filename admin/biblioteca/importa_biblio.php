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
<br />
<div align="center">
<div class="page-header">
  <h2>Biblioteca del Centro <small> Importación de libros desde Abies</small></h2>
</div>
</div>
<div class="container-fluid">
<div class="row-fluid">
<div class='well well-large span6 offset3'>  
<?
mysql_query("CREATE TABLE if not exists `biblioteca` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Autor` varchar(128) COLLATE latin1_spanish_ci NOT NULL,
  `Titulo` varchar(128) COLLATE latin1_spanish_ci NOT NULL,
  `Editorial` varchar(128) COLLATE latin1_spanish_ci NOT NULL,
  `ISBN` varchar(15) COLLATE latin1_spanish_ci NOT NULL,
  `Tipo` varchar(64) COLLATE latin1_spanish_ci NOT NULL,
  `anoEdicion` int(4) NOT NULL,
  `extension` varchar(8) COLLATE latin1_spanish_ci NOT NULL,
  `serie` int(11) NOT NULL,
  `lugaredicion` varchar(48) COLLATE latin1_spanish_ci NOT NULL,
  `tipoEjemplar` varchar(128) COLLATE latin1_spanish_ci NOT NULL,
  `ubicacion` varchar(32) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1");
mysql_query("drop table biblioteca_seg");
mysql_query("create table biblioteca_seg select * from biblioteca");

ini_set('auto_detect_line_endings', true);
$fp = fopen ($_FILES['archivo']['tmp_name'] , "r" ) or die ("<br><blockquote>No se ha podido abrir el fichero.<br> Asegúrate de que su formato es correcto.</blockquote>");

mysql_query("truncate table biblioteca");
$reg=0;

echo "<legend align='center'>Listados de libros procesados</legend>";

while (( $data = fgetcsv ( $fp , 1000, ';' )) !== FALSE ) {
	$reg+=1;
	$sql="	INSERT INTO  biblioteca (Autor, Titulo, Editorial, ISBN, Tipo, anoEdicion, extension, serie, lugaredicion, tipoEjemplar, Ubicacion) VALUES (";
	$sql.="	'$data[0]',  '$data[1]',  '$data[2]',  '$data[3]',  '$data[4]',  '$data[5]',  '$data[6]',  '$data[7]',  '$data[8]',  '$data[9]',  '$data[10]')";
	//echo $sql."<br>";	
	mysql_query($sql);    
} 
fclose ( $fp ); 
mysql_close();
echo "<div align='center' class='text-info'><b>Se han importado un total de ",$reg," libros a la base de datos</b></div>";
echo "</div></div></div>";

include ("../../pie.php");
?>