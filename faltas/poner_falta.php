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
	?>
<div class="container">

<div class="page-header">
<h2>Faltas de Asistencia <small> Poner faltas</small></h2>
</div>
<div class="row">
<?
// nprofe hora ndia hoy codasi profesor clave
if (isset($_POST['nprofe'])) {$nprofe = $_POST['nprofe'];} else{$nprofe="";}
if (isset($_POST['hora'])) {$hora = $_POST['hora'];} else{$hora="";}
if (isset($_POST['ndia'])) {$ndia = $_POST['ndia'];} else{$ndia="";}
if (isset($_POST['hoy'])) {$hoy = $_POST['hoy'];} else{$hoy="";}
if (isset($_POST['codasi'])) {$codasi = $_POST['codasi'];} else{$codasi="";}
if (isset($_POST['profesor'])) {$profesor = $_POST['profesor'];} else{$profesor="";}
if (isset($_POST['clave'])) {$clave = $_POST['clave'];} else{$clave="";}
if (isset($_POST['fecha_dia'])) {$fecha_dia = $_POST['fecha_dia'];} else{$fecha_dia="";}


// Borramos faltas para luego colocarlas de nuevo.
$borra = mysqli_query($db_con, "delete from FALTAS where HORA = '$hora' and FECHA = '$hoy' and PROFESOR = '$nprofe' and (FALTA = 'F' or FALTA = 'J')");
$db_pass = trim($clave);
foreach($_POST as $clave => $valor)
{
	if(strlen(strstr($clave,"falta_")) > 0)
	{
		$nc0 = explode("_",$clave);
		$nc = $nc0[1];
		// Nivel y grupo
		$unidad = $nc0[2];

		$clave1 = "select claveal from FALUMNOS where NC = '$nc' and unidad = '$unidad'";
		$clave0 = mysqli_query($db_con, $clave1);
		$clave2 = mysqli_fetch_row($clave0);
		$claveal = $clave2[0];

		$fecha0 = explode('-',$hoy);
		
		$dia0 = $fecha0[2];
		$mes = $fecha0[1];
		$ano = $fecha0[0];
		
		$fecha1 = $ano . "-" . $mes . "-" . $dia0;
		$fecha11 = $dia0 . "-" . $mes . "-" . $ano;
		$fecha2 = mktime(0,0,0,$mes,$dia0,$ano);
		$diames = date("j");
		$nmes = date("n");
		$nano = date("Y");
		$hoy1 = mktime(0,0,0,$nmes,$diames,$nano);
		
		$comienzo_del_curso = strtotime($inicio_curso);
		$final_del_curso = strtotime($fin_curso);

		$repe=mysqli_query($db_con, "select fecha from festivos where date(fecha) = date('$fecha1')");
		if (mysqli_num_rows($repe) > '0') {
			$dia_festivo='1';
		}
		if($dia_festivo=='1')
		{
			$mens_fecha = "No es posible poner o justificar Faltas en un <b>Día Festivo</b> o en <b>Vacaciones</b>. Comprueba la Fecha: <b>$fecha11</b>";
		}
		elseif ($fecha2 < $comienzo_del_curso) {
			$mens_fecha = "No es posible poner Faltas del <b>Curso Anterior</b>.<br>Comprueba la Fecha: <b>$fecha11</b>.";
		}
		elseif ($fecha2 > $final_del_curso) {
			$mens_fecha = "No es posible poner Faltas del <b>Curso Siguiente</b>.<br>Comprueba la Fecha: <b>$fecha11</b>.";
		}
		elseif ($fecha2 > $hoy1) {
			$mens_fecha = "No es posible poner Faltas en el <b>Futuro</b>.<br>Comprueba la Fecha: <b>$fecha11</b>.";
		}
else{

		// Insertamos las faltas de TODOS los alumnos.
		$t0 = "insert INTO  FALTAS (  CLAVEAL , unidad ,  NC ,  FECHA ,  HORA , DIA,  PROFESOR ,  CODASI ,  FALTA )
VALUES ('$claveal',  '$unidad', '$nc',  '$hoy',  '$hora', '$ndia',  '$nprofe',  '$codasi', 'F')";
		//	echo $t0;
		$t1 = mysqli_query($db_con, $t0) or die("No se han podido insertar los datos");
		$count += mysqli_affected_rows();
		}
	}
}
if (empty($mens_fecha)) {
	echo "<h3 align='center'>Poner faltas de asistencia</h3><br />";
	echo '<br /><div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            Las Faltas han sido registradas.
          </div></div>'; 
}
else{
	echo "<h3 align='center'>Poner faltas de asistencia</h3><br />";
	echo '<br /><div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            '. $mens_fecha.'</div></div>'; 
}
?>
<script language="javascript">
setTimeout("window.location='index.php?fecha_dia=<? echo $fecha_dia; ?>&hora_dia=<? echo $hora; ?>'", 2000) 
</script>
</body>
</html>
