<?
session_start();
include("../../config.php");
// COMPROBAMOS LA SESION
if ($_SESSION['autentificado'] != 1) {
	$_SESSION = array();
	session_destroy();
	header('Location:'.'http://'.$dominio.'/intranet/salir.php');	
	exit();
}

if($_SESSION['cambiar_clave']) {
	header('Location:'.'http://'.$dominio.'/intranet/clave.php');
}

registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);


?>
<? 
include("../../menu.php");
include("menu.php");
 ?>
<div align=center>
<div class="page-header">
  <h2>Problemas de convivencia <small> Borrar problema</small></h2>
</div>
<br />
<?
if(isset($_GET['id'])){$id = $_GET['id'];}else{$id="";}

$connection = mysql_connect($db_host, $db_user, $db_pass) or die ("No es posible conectar con la base de datos!");
mysql_select_db($db) or die ("No es posible conectar con la base de datos!");
$query = "DELETE FROM Fechoria WHERE id = '$id'";
$result = mysql_query($query) or die ("Error en la Consulta: $query. " . mysql_error());
mysql_close($connection);
echo '<br /><div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Atención:</strong>
			El problema de convivencia ha sido borrado de la base de datos.
          </div></div>';
?>

</div>  
</body>
</html>
