<?
session_start();
include("../../config.php");
include_once('../../config/version.php');

// COMPROBAMOS LA SESION
if ($_SESSION['autentificado'] != 1) {
	$_SESSION = array();
	session_destroy();
	
	if(isset($_SERVER['HTTPS'])) {
	    if ($_SERVER["HTTPS"] == "on") {
	        header('Location:'.'https://'.$dominio.'/intranet/salir.php');
	        exit();
	    } 
	}
	else {
		header('Location:'.'http://'.$dominio.'/intranet/salir.php');
		exit();
	}
}

if($_SESSION['cambiar_clave']) {
	if(isset($_SERVER['HTTPS'])) {
	    if ($_SERVER["HTTPS"] == "on") {
	        header('Location:'.'https://'.$dominio.'/intranet/clave.php');
	        exit();
	    } 
	}
	else {
		header('Location:'.'http://'.$dominio.'/intranet/clave.php');
		exit();
	}
}


registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);
?>
  <?php
include("../../menu.php");
include("menu.php");  
  ?>
<div class="container">
<div class="row">
<div class="page-header">
  <h2>Actividades Complementarias y Extraescolares <small> Registro de alumnos</small></h2>
</div>
</div>

<?
$tutor = $_SESSION['profi'];

if (isset($_GET['id'])) {$id = $_GET['id'];}elseif (isset($_POST['id'])) {$id = $_POST['id'];}else{$id="";}
if (isset($_GET['eliminar'])) {$id = $_GET['eliminar'];}elseif (isset($_POST['eliminar'])) {$eliminar = $_POST['eliminar'];}else{$eliminar="";}
if (isset($_GET['enviar'])) {$enviar = $_GET['enviar'];}elseif (isset($_POST['enviar'])) {$enviar = $_POST['enviar'];}else{$enviar="";}
if (isset($_GET['crear'])) {$crear = $_GET['crear'];}elseif (isset($_POST['crear'])) {$crear = $_POST['crear'];}else{$crear="";}
if (isset($_GET['buscar'])) {$buscar = $_GET['buscar'];}elseif (isset($_POST['buscar'])) {$buscar = $_POST['buscar'];}else{$buscar="";}

if (isset($_GET['calendario'])) {$calendario = $_GET['calendario'];}elseif (isset($_POST['calendario'])) {$calendario = $_POST['calendario'];}else{$calendario="";}
if (isset($_GET['act_calendario'])) {$act_calendario = $_GET['act_calendario'];}elseif (isset($_POST['act_calendario'])) {$act_calendario = $_POST['act_calendario'];}else{$act_calendario="";}
if (isset($_GET['confirmado'])) {$confirmado = $_GET['confirmado'];}elseif (isset($_POST['confirmado'])) {$confirmado = $_POST['confirmado'];}else{$confirmado="";}
if (isset($_GET['detalles'])) {$detalles = $_GET['detalles'];}elseif (isset($_POST['detalles'])) {$detalles = $_POST['detalles'];}else{$detalles="";}
if (isset($_GET['fecha'])) {$fecha = $_GET['fecha'];}elseif (isset($_POST['fecha'])) {$fecha = $_POST['fecha'];}else{$fecha="";}
if (isset($_GET['horario'])) {$horario = $_GET['horario'];}elseif (isset($_POST['horario'])) {$horario = $_POST['horario'];}else{$horario="";}
if (isset($_GET['profesor'])) {$profesor = $_GET['profesor'];}elseif (isset($_POST['profesor'])) {$profesor = $_POST['profesor'];}else{$profesor="";}
if (isset($_GET['actividad'])) {$actividad = $_GET['actividad'];}elseif (isset($_POST['actividad'])) {$actividad = $_POST['actividad'];}else{$actividad="";}
if (isset($_GET['descripcion'])) {$descripcion = $_GET['descripcion'];}elseif (isset($_POST['descripcion'])) {$descripcion = $_POST['descripcion'];}else{$descripcion="";}

include_once ("../../funciones.php"); 
// PDF
$fecha2 = date('Y-m-d');
$hoy = formatea_fecha($fecha);

  
  $fecha1 = explode("-",$fecha);
  $dia = $fecha[0];
  $mes = $fecha[1];
  $ano = $fecha[2];
  foreach($_POST as $key => $value)
  { 
//  echo "$key --> $value<br>";
if(is_numeric(trim($key))){

$alumnos0 = "select alma.nombre, alma.apellidos, padre, domicilio, codpostal, localidad, provinciaresidencia, NC, dnitutor, alma.unidad, alma.matriculas from alma, FALUMNOS where alma.claveal = FALUMNOS.claveal and alma.claveal = '$value'";
$alumnos1 = mysqli_query($db_con, $alumnos0);
while($alumno = mysqli_fetch_array($alumnos1))
{
mysqli_query($db_con,"delete from actividadalumno where claveal='$value' and cod_actividad='$id'");
mysqli_query($db_con, "insert into actividadalumno (claveal,cod_actividad) values ('".$value."','".$id."')");
# insertamos la primera pagina del documento
	}
}
}
echo '
<br /><div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			Los alumnos seleecionados han sido regsitrados en la Actividad Extraescolar o Complementaria.          
			</div></div>';
?>
