<?
session_start();
include("../config.php");
include_once('../config/version.php');
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
include("../menu.php");
include("menu.php");
// Titulo
echo "<div class='container'><div class='row'>";
echo "<br /><div class='page-header'>";
$n_profe = explode(", ",$pr);
$nombre_profe = "$n_profe[1] $n_profe[0]";
echo "<h2 class='hidden-print'>Cuaderno de Notas&nbsp;&nbsp;<small> Operaciones con los datos</small></h2>";
echo "</div>";
echo '<div align="center">';

foreach($_POST as $key => $val)
{
	${$key} = $val;
}
echo "<h3><span class='label label-info' style='padding:8px'>$curso -- $nom_asig </span></h3><br>";

// Procesamos los datos
if ($eliminar) {
	include("edicion/eliminar.php");

}
elseif ($ocultar) {
	$ocultar = "1";
	include("edicion/ocultar.php");

}
elseif ($mostrar) {
	$ocultar = "0";
	include("edicion/ocultar.php");
	exit;
}
elseif ($media) {
	include("edicion/calcular.php");

}
elseif ($recalcula) {
	include("edicion/calcular_pond.php");

}

elseif ($media_pond2) {


	include("edicion/calcular_pond.php");

}

elseif ($estadistica) {


	include("edicion/estadistica.php");

}
?>
<?
include("../pie.php")
?>
</body>
</html>
