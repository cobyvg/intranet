<?
session_start();
include("../config.php");
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
// Titulo
echo "<br /><div align='center' class='page-header'>";
$n_profe = explode(", ",$pr);
$nombre_profe = "$n_profe[1] $n_profe[0]";
echo "<h2 class='no_imprimir'>Cuaderno de Notas&nbsp;&nbsp;<small> Operaciones con los datos</small></h2>";
echo "</div><br />";
echo '<div align="center">';

 foreach($_POST as $key => $val)
	{
		${$key} = $val;
	}
echo "<p class='lead'>$curso <span class='muted'>( $nom_asig )</span></p>";		
	
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