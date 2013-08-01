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
?>
<?
include("../../menu.php");
?>
<?
include("../menu.php");
?>
<div align=center>
<div class="page-header" align="center">
  <h2>Centro TIC <small> Nombre de usuario del Profesor</small></h2>
</div>
<br />

<table class="table table-striped table-bordered" style="width:auto">
<tr><th>Profesor</th>
<th>Usuario T.I.C.</th>
</tr>
<?

$profes = $_SESSION['profi'];
$profesores = "select distinct usuario, nombre from usuarioprofesor where nombre = '$profes'";
$sqlprof = mysql_query($profesores);
while ($sql0 = mysql_fetch_array($sqlprof)) {
	echo "<tr>
<td> $sql0[1] </td>
<td style='color:#'> $sql0[0] </td>
</tr>";
}
echo "</table>";

include("../../pie.php");
?>

</div>
</BODY>

</HTML>
