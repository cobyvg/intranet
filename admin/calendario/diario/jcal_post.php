<?
session_start();
include("../../../config.php");
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

if (isset($_POST['grupos'])) { 
foreach ($_POST['grupos'] as $grup){
$tr_gr = explode(" => ",$grup);	
$grupo.=$tr_gr[0]."; ";
$materia.=$tr_gr[1]."; ";
}
}
//$grupo = substr($grupo,0,-2);
//$materia = substr($materia,0,-2);
$event_found = "";
if (isset($_POST['id']) and strlen($_POST['id'])>0) { 
  //UPDATE
<<<<<<< HEAD
    $postQuery = "UPDATE `diario` SET fecha = '".$fecha."', grupo = '".$grupo."', materia = '$materia', tipo = '$tipo', titulo = '".$titulo."', observaciones = '".$observaciones."', calendario = '".$calendario."' where id='$id'";
echo $postQuery;
=======
    $postQuery = "UPDATE `diario` SET fecha = '".$fecha_reg."', grupo = '".$grupo."', materia = '$materia', tipo = '$tipo', titulo = '".$titulo."', observaciones = '".$observaciones."', calendario = '".$calendario."' where id='$id'";
>>>>>>> FETCH_HEAD
    $postExec = mysql_query($postQuery) or die("Could not Post UPDATE diario Event to database!");
	header("Location: index.php?id=$id&mens=actualizar");

} else {
  //INSERT
    $postQuery = "INSERT INTO diario (fecha,grupo,materia,tipo,titulo,observaciones,calendario,profesor) VALUES ('".$fecha_reg."','".$grupo."','".$materia."','$tipo','".$titulo."','".$observaciones."','".$calendario."','".$_SESSION['profi']."')";
    $postExec = mysql_query($postQuery);
    header("Location: index.php?mens=insertar");
}
//echo $postQuery;

?>
