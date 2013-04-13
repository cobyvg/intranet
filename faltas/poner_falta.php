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
include("menu.php");
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
$grupos = $nc0[2];
$niv_grupo = explode("-",$grupos);
$nivel = $niv_grupo[0];
$grupo = $niv_grupo[1];
	$clave1 = "select claveal from FALUMNOS where NC = '$nc' and nivel = '$nivel' and grupo = '$grupo'";
	$clave0 = mysql_query($clave1); 
	$clave2 = mysql_fetch_row($clave0);
	$claveal = $clave2[0];

// Insertamos las faltas de TODOS los alumnos.
$t0 = "insert INTO  FALTAS (  CLAVEAL , NIVEL ,  GRUPO ,  NC ,  FECHA ,  HORA , DIA,  PROFESOR ,  CODASI ,  FALTA ) 
VALUES ('$claveal',  '$nivel',  '$grupo',  '$nc',  '$hoy',  '$hora', '$ndia',  '$nprofe',  '$codasi', 'F')";
$t1 = mysql_query($t0) or die("No se ha podido insertr datos");	
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