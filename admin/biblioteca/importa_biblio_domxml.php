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
  <h2>Biblioteca del Centro <small> Importación de libros desde Abbies</small></h2>
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
//$fp = fopen ($_FILES['archivo']['tmp_name'] , "r" ) or die ("<br><blockquote>No se ha podido abrir el fichero.<br> Asegúrate de que su formato es correcto.</blockquote>");
mysql_query("truncate table biblioteca");
$reg=0;

echo "<legend align='center'>Listados de libros procesados</legend>";

if ($handle = opendir('.')) {
   while (false !== ($file = readdir($handle))) {
       if ($file == "Informe.htm") {
$doc = new DOMDocument('1.0', 'iso-8859-1');
/*Cargo el XML*/
$doc->load($file );

//$doc = domxml_open_file($file);

// Ver estructura
$root = $doc->document_element( );
function process_node($node) {
if ($node->has_child_nodes( )) {
foreach($node->child_nodes( ) as $n) { process_node($n);
} }
// process leaves
if ($node->node_type( ) == XML_TEXT_NODE) {
$content = rtrim($node->node_value( )); 
if (!empty($content)) {
print "$content\n"; }
}
} 
process_node($root);

// Procesar datos
$tablas = $doc->getElementsByTagName( "table" );

$tramos = $tablas->getElementsByTagName( "tr" );

$sql="";
foreach( $tramos as $tramo )
{		
$codigos0 = $tramo->getElementsByTagName( "td" );

foreach ($codigos0 as $td){
	$codigos1 = $td->getElementsByTagName( "td" );
	$td1 = $codigos1->item(0)->nodeValue;
	echo $td1;
	$sql.="$td1, ";
}
echo "$sql<br>";
$reg+=1;
}
}
// Sql para importar datos
$sql="	INSERT INTO  biblioteca (Autor, Titulo, Editorial, ISBN, Tipo, anoEdicion, extension, serie, lugaredicion, tipoEjemplar, Ubicacion) VALUES (";
$sql.="	'$data[0]',  '$data[1]',  '$data[2]',  '$data[3]',  '$data[4]',  '$data[5]',  '$data[6]',  '$data[7]',  '$data[8]',  '$data[9]',  '$data[10]')";
//echo $sql."<br>";	
mysql_query($sql);		     
}
}

fclose ( $handle ); 
mysql_close();
echo "<div align='center' class='text-info'><b>Se han importado un total de ",$reg," libros a la base de datos</b></div>";
echo "</div></div></div>";

include ("../../pie.php");
?>