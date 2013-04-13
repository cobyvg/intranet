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

$profesor = $_SESSION['profi'];
?>
<?
// includes
 
include("../../menu.php");
include("menu.php");
?>
<div class="page-header" align="center">
  <h1>Noticias del Centro <small> Borrado de noticias</small></h1>
</div>
<br />
<?
$connection = mysql_connect($db_host, $db_user, $db_pass) or die ("No es posible conectar con la base de datos!");
mysql_select_db($db) or die ("No es posible conectar con la base de datos!");
mysql_query("delete from news where timestamp = '$fech_princ'");
$query = "DELETE from noticias where id = '$id'";
$result = mysql_query($query) or die ("Error en la Consulta: $query. " . mysql_error());
mysql_close($connection);
?>
<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Se ha borrado el registro de la base de datos.          
</div>
</div>
<? include("../../pie.php"); ?>
</body>
</html>
