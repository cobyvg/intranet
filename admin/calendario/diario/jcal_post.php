<?
session_start();
include("../../../config.php");
include_once('../../../config/version.php');
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
$fecha_reg = $_POST['fecha_reg']; 
if (isset($_POST['id'])) { $id = $_POST['id']; }
elseif (isset($_GET['id'])) { $id = $_GET['id']; }
if (isset($_POST['tipo'])) { $tipo = $_POST['tipo']; }
elseif (isset($_GET['tipo'])) { $tipo = $_GET['tipo']; }
else{$tipo="";}
if (isset($_POST['titulo'])) { $titulo = $_POST['titulo']; }
elseif (isset($_GET['titulo'])) { $titulo = $_GET['titulo']; }
else{$titulo="";}
if (isset($_POST['observaciones'])) { $observaciones = $_POST['observaciones']; }
elseif (isset($_GET['observaciones'])) { $observaciones = $_GET['observaciones']; }
else{$observaciones="";}
if (isset($_POST['calendario'])) { $calendario = $_POST['calendario']; }
elseif (isset($_GET['calendario'])) { $calendario = $_GET['calendario']; }
else{$calendario="";}
if (isset($_GET['dia'])) {
	$dia = $_GET['dia'];
}
elseif (isset($_POST['dia'])) {
	$dia = $_POST['dia'];
}

if (isset($_GET['hora'])) {
	$hora = $_GET['hora'];
}
elseif (isset($_POST['hora'])) {
	$hora = $_POST['hora'];
}

if (isset($_GET['curso'])) {
	$curso = $_GET['curso'];
}
elseif (isset($_POST['curso'])) {
	$curso = $_POST['curso'];
}

if (isset($_GET['asignatura'])) {
	$asignatura = $_GET['asignatura'];
}
elseif (isset($_POST['asignatura'])) {
	$asignatura = $_POST['asignatura'];
}

if (isset($_POST['grupos'])) { 
foreach ($_POST['grupos'] as $grup){
$tr_gr = explode(" => ",$grup);	
$grupo.=$tr_gr[0]."; ";
$materia.=$tr_gr[1]."; ";
}
}
if (isset($_GET['menu_cuaderno'])) {
$extra = "menu_cuaderno=1&profesor=".$_SESSION['profi']."&dia=$dia&hora=$hora&curso=$curso&asignatura=$asignatura";
}

//$grupo = substr($grupo,0,-2);
//$materia = substr($materia,0,-2);
$event_found = "";
if (isset($_POST['id']) and strlen($_POST['id'])>0) { 
  //UPDATE
    $postQuery = "UPDATE `diario` SET fecha = '".$fecha_reg."', grupo = '".$grupo."', materia = '$materia', tipo = '$tipo', titulo = '".$titulo."', observaciones = '".$observaciones."', calendario = '".$calendario."' where id='$id'";
    $postExec = mysqli_query($db_con, $postQuery) or die("Could not Post UPDATE diario Event to database!");
	header("Location: index.php?id=$id&mens=actualizar&$extra");

} else {
  //INSERT
    $postQuery = "INSERT INTO diario (fecha,grupo,materia,tipo,titulo,observaciones,calendario,profesor) VALUES ('".$fecha_reg."','".$grupo."','".$materia."','$tipo','".$titulo."','".$observaciones."','".$calendario."','".$_SESSION['profi']."')";
    $postExec = mysqli_query($db_con, $postQuery);
    header("Location: index.php?mens=insertar&$extra");
}
//echo $postQuery;
?>
