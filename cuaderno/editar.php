<?
session_start();
include("../config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);
?>
<?
include("../menu.php");
echo "<div align='center'><h2>Cuaderno de Notas</h2><br />
	 <h3>Edición de datos</h3><br />";
// Procesamos los datos
if ($eliminar) {
include("edicion/eliminar.php");
exit;	
}
elseif ($ocultar) {
$ocultar = "1";
include("edicion/ocultar.php");	
exit;	
}
elseif ($mostrar) {
$ocultar = "0";
include("edicion/ocultar.php");
exit;
}	
elseif ($media) {
include("edicion/calcular.php");
exit;	
}
elseif ($recalcula) {
include("edicion/calcular_pond.php");
exit;	
}

elseif ($media_pond2) {


include("edicion/calcular_pond.php");
exit;	
}

elseif ($estadistica) {


include("edicion/estadistica.php");
exit;	
}


?>
</body>
</html>