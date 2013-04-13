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
<title>Departamentos y Especialidades</title>
<LINK href="http://<? echo $dominio; ?>/<? echo $css1; ?>" rel="stylesheet" type="text/css">
<LINK href="http://<? echo $dominio; ?>/<? echo $css2; ?>" rel="stylesheet" type="text/css">
</head>
<body>
<div align="center" style="width:700px;margin:auto;margin-top:25px;">
<div class="titulogeneral" align=center>Importación de Días Festivos.</div>
<?
 // Conexión 
 
mysql_connect ($db_host, $db_user, $db_pass) or die("Error de conexión");

// Borramos datos
mysql_query("truncate table festivos");	

// Importamos los datos del fichero CSV en la tabña alma.
$handle = fopen ($_FILES['archivo']['tmp_name'] , "r" ) or die("<p>No se ha podido abrir el fichero de importación<br> Asegúrate de que su formato es correcto y no está vacío.</p>"); 
while (($data1 = fgetcsv($handle, 1000, "|")) !== FALSE) 
{
$tr = explode("/",trim($data1[0]));
$fecha="$tr[2]-$tr[1]-$tr[0]";
$datos1 = "INSERT INTO festivos ( `fecha` , `nombre` , `ambito` , `docentes` ) VALUES (\"". $fecha . "\",\"". trim($data1[1]) . "\",\"". trim($data1[2]) . "\",\"". trim($data1[3]) . "\")";
mysql_query($datos1);
}
fclose($handle);
$borrarvacios = "delete from festivos where date(fecha) = '0000-00-00'";
 mysql_query($borrarvacios);
 if (mysql_affected_rows() > '0') {
 	echo "<p id='texto_en_marco'>Los datos se han importado correctamente.</p>";
 }
?>
<br />
<input type="button" value="Volver atrás" name="boton" onclick="history.back(2)" />
</div>
</body>
</html>