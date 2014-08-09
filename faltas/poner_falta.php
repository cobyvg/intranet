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
include("menu.php");
// nprofe hora ndia hoy codasi profesor clave
if (isset($_POST['nprofe'])) {$nprofe = $_POST['nprofe'];} else{$nprofe="";}
if (isset($_POST['hora'])) {$hora = $_POST['hora'];} else{$hora="";}
if (isset($_POST['ndia'])) {$ndia = $_POST['ndia'];} else{$ndia="";}
if (isset($_POST['hoy'])) {$hoy = $_POST['hoy'];} else{$hoy="";}
if (isset($_POST['codasi'])) {$codasi = $_POST['codasi'];} else{$codasi="";}
if (isset($_POST['profesor'])) {$profesor = $_POST['profesor'];} else{$profesor="";}
if (isset($_POST['clave'])) {$clave = $_POST['clave'];} else{$clave="";}

// Borramos faltas para luego colocarlas de nuevo.
$borra = mysql_query("delete from FALTAS where HORA = '$hora' and FECHA = '$hoy' and PROFESOR = '$nprofe' and (FALTA = 'F' or FALTA = 'J')");
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
	$clave0 = mysql_query($clave1); 
	$clave2 = mysql_fetch_row($clave0);
	$claveal = $clave2[0];

// Insertamos las faltas de TODOS los alumnos.
$t0 = "insert INTO  FALTAS (  CLAVEAL , unidad ,  NC ,  FECHA ,  HORA , DIA,  PROFESOR ,  CODASI ,  FALTA ) 
VALUES ('$claveal',  '$unidad', '$nc',  '$hoy',  '$hora', '$ndia',  '$nprofe',  '$codasi', 'F')";
$t1 = mysql_query($t0) or die("No se ha podido insertar los datos");	
$count += mysql_affected_rows();
}
}
	echo "<h3 align='center'>Poner faltas de asistencia</h3><br />";
echo '<br /><div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            Las Faltas han sido registradas.
          </div></div>'; 
?>
<script language="javascript">
setTimeout("window.location='index.php'", 2000) 
</script>
<? 
?>
</body>
</html>