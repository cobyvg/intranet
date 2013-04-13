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

$asignaturas0 = "select distinct claveal from competencias_seg";
$asignaturas1 = mysql_query($asignaturas0);
while ($asignaturas = mysql_fetch_array($asignaturas1)) {	
		$edit = mysql_query("select unidad from alma where claveal = '$asignaturas[0]'");
		$curso = mysql_fetch_array($edit);
		mysql_query("update competencias_seg set grupo = '$curso[0]' where claveal = '$asignaturas[0]'");
}
?>

</table>

</body>
</html>