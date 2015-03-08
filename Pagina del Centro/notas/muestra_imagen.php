<?
session_start();
$clave_al = $_SESSION['clave_al'];
include_once("../conf_principal.php");
include("../funciones.php");
mysql_connect ($host, $user, $pass);
mysql_select_db ($db);
$result = mysql_query("SELECT datos FROM fotos WHERE nombre='".$clave_al.".jpg'");
$result_array = mysql_fetch_array($result);
header('Content-Type: image/jpeg');
echo $result_array[0];
?>