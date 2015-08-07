<?
require('../../bootstrap.php');


if(!(stristr($_SESSION['cargo'],'1') == TRUE))
{
header('Location:'.'http://'.$config['dominio'].'/intranet/salir.php');
exit;	
}


include("../../menu.php");
?>
<div class="container">
<br />
<div class="page-header">
  <h2>Administración <small> Importación de la Jornada Escolar del centro</small></h2>
  </div>
<div class="row">
<br />
<?
 // Conexión 
$db_con = mysqli_connect($db_host, $db_user, $db_pass);
mysqli_select_db($db_con, $db);

// Creamos tabla 

mysqli_query($db_con, "drop table jornada");	

mysqli_query($db_con,"CREATE TABLE IF NOT EXISTS `jornada` (
  `tramo` varchar(24) COLLATE latin1_spanish_ci NOT NULL,
  `hora_inicio` varchar(5) COLLATE latin1_spanish_ci NOT NULL,
  `hora_fin` varchar(5) COLLATE latin1_spanish_ci NOT NULL,
  `minutos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// Importamos los datos del fichero CSV en la tabña alma.
$handle = fopen ($_FILES['archivo']['tmp_name'] , "r" ) or die('
<div align="center"><div class="alert alert-success alert-block fade in" align="left">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
No se ha podido abrir el fichero de importación<br> Asegúrate de que su formato es correcto y no está vacío.
			</div></div><br />	'); 
while (($data1 = fgetcsv($handle, 1000, "|")) !== FALSE) 
{
	if (strstr($data1[1],":")==TRUE and strstr($data1[2],":")==TRUE) {
		if (strstr($data1[0],"R")==TRUE) {	$data1[0]="R";	}
		if (strstr($data1[0],"5")==TRUE) {	$data1[0]="4";	}
		if (strstr($data1[0],"6")==TRUE) {	$data1[0]="5";	}
		if (strstr($data1[0],"7")==TRUE) {	$data1[0]="6";	}
	$datos1 = "INSERT INTO jornada VALUES (\"". trim($data1[0]) . "\",\"". trim($data1[1]) . "\",\"". trim($data1[2]) . "\",\"". trim($data1[3]) . "\")";
mysqli_query($db_con, $datos1);	
	}
}
fclose($handle);

?>
 	<div align="center""><div class="alert alert-success alert-block fade in" align="left">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
	 Los datos se han importado correctamente.
			</div></div><br>
			<div align="center"><a href="../index.php" class="btn btn-primary" />Volver
a Administración</a></div>
			<?

$borrarvacios = "delete from jornada where minutos = ''";
mysqli_query($db_con, $borrarvacios);
mysqli_query($db_con,"ALTER TABLE `jornada` ADD PRIMARY KEY (`tramo`)");
	
?>
</div>
</div>
   <?php 
include("../../pie.php");
?>
</body>
</html>